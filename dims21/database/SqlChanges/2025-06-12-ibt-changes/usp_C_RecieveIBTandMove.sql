/****** Object:  StoredProcedure [dbo].[usp_C_RecieveIBTandMove]    Script Date: 2025/06/13 02:16:24 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- Create the stored procedure in the specified schema
ALTER PROCEDURE [dbo].[usp_C_RecieveIBTandMove]
    -- Add Parameters
    @ibtHeaderId BIGINT
    , @xml XML
    , @receivingBin INT
    , @userId BIGINT
    , @intTLNumber BIGINT -- ADDED 2025/04/29 BY KYLE TO RECIEVE A SPECIFIC TRUCK LOAD
    -- add more stored procedure parameters here
AS
BEGIN
    SET NOCOUNT ON;

    BEGIN TRANSACTION;

    BEGIN TRY
        -- body of the stored procedure
        DECLARE @ref AS NVARCHAR(50);

        -- Temporary table to hold XML data
        SELECT intAutoId = XTbl.value('(intAutoId)[1]', 'BIGINT')
            , intAutoHeaderId = XTbl.value('(intAutoHeaderId)[1]', 'BIGINT')
            , Qty = XTbl.value('(Qty)[1]', 'DECIMAL(18,2)')
            , mnyQtyToReceive = XTbl.value('(mnyQtyToReceive)[1]', 'DECIMAL(18,2)')
        INTO #tempXMLData
        FROM @xml.nodes('/xml/result') AS x(XTbl);

        -- Update header table
        UPDATE tblIBTHeader
        SET intStatus = 3
            , intReceivingBin = @receivingBin
            , dtmReceived = GETDATE()
            , intReceivedBy = @userId
            , intAutoRecieveId = CASE 
                WHEN bitPartiallyProcessed = 0
                    THEN (
                            SELECT MAX(ISNULL(intAutoRecieveId, 0)) + 1
                            FROM tblIBTHeader
                        )
                ELSE intAutoRecieveId
                END
        WHERE intAutoId = @ibtHeaderId;

        -- FIX FOR TRACKING TABLE LOGIC BY KYLE 2025/04/29
        UPDATE track
        SET decQtyRecieved = TEMP.mnyQtyToReceive
            , intRecievedBy = @userId
            , dtmReceived = GETDATE()
        FROM tblIBTTracking track
        INNER JOIN #tempXMLData TEMP
            ON TEMP.intAutoId = track.intIBTLineId
        INNER JOIN tblIBTHeader ibth
            ON ibth.intAutoId = TEMP.intAutoHeaderId
        WHERE track.intTLNumber = @intTLNumber

        -- Step 1: Calculate the delta (issued - received) per line in the tracking table
        ;WITH QtyDeltas AS (
            SELECT 
                t.intIBTLineId,
                t.intTLNumber,
                SUM(ISNULL(t.decQtyIssued, 0) - ISNULL(t.decQtyRecieved, 0)) AS decQtyVariance,
                ISNULL(t.decQtyRecieved, 0) AS decQtyRecieved
            FROM tblIBTTracking t
            WHERE t.intTLNumber = @intTLNumber
            GROUP BY t.intIBTLineId, t.intTLNumber, t.decQtyRecieved
        )

        -- Step 2: Update mnyQtyReceived by adding the delta from tracking
        UPDATE ibtl
        SET 
            ibtl.mnyQtyReceived = ISNULL(ibtl.mnyQtyReceived, 0) + ISNULL(qd.decQtyRecieved, 0),
            ibtl.mnyQtyVariance = ISNULL(ibtl.mnyQtyVariance, 0) + ISNULL(qd.decQtyVariance, 0)
        FROM tblIBTLines ibtl
        INNER JOIN tblIBTHeader ibth ON ibth.intAutoId = ibtl.intAutoHeaderId
        INNER JOIN QtyDeltas qd ON qd.intIBTLineId = ibtl.intAutoId
        WHERE ibth.intAutoId = @ibtHeaderId
        AND qd.intTLNumber = @intTLNumber;

        -- ADDED CHECK TO SET STATUS CORRECTLY 2025/04/29
        UPDATE tblIBTHeader
        SET intStatus = CASE 
            WHEN EXISTS (
                SELECT 1
                FROM tblIBTTracking
                WHERE intIBTHeaderId = @ibtHeaderId
                    AND decQtyRecieved IS NULL
            ) THEN 2
            ELSE 3
        END
        WHERE intAutoId = @ibtHeaderId;

        INSERT INTO tblStockTransactionHistory (
            intBinId, intProductID, intDocType, intOwnerId, decSingleQuantity,
            decBundleQuantity, decPalletQuantity, decSingleWeight, decBundleWeight,
            decPalletWeight, dtmMovement, UserId, decAvgCost, decLastCost,
            intDocId, intLineId, strDocReference, strDocReference2
        )
        -- MOVE OUT TRUCK
        SELECT ibth.intGIT intBinId,
            stk.StockLink intProductID,
            4 intDocType, 
            ppl.intOwnerID,
            -ppl.mnyQty decSingleQuantity,
            -0 decBundleQuantity,
            -0 decPalletQuantity,
            -(ppl.mnyQty * stk.Weight) decSingleWeight,
            -0 decBundleWeight,
            -0 decPalletWeight,
            GETDATE() dtmMovement,
            @userId UserId,
            NULL decAvgCost,
            NULL decLastCost,
            ppl.intOrderId intDocId,
            ppl.intorderdetailId intLineId,
            ppl.strUnickReference strDocReference,
            'DIMS IBT' strDocReference2
        FROM tblPickingPlan ppl
        INNER JOIN tblPickingPlanHeader ph ON ppl.intAutoPickingHeader = ph.intAutoPickingHeader
        INNER JOIN vwDIMSIBTLines ibtl ON ibtl.intAutoId = ppl.intorderdetailId
        INNER JOIN tblIBTHeader ibth ON ibth.intAutoId = ibtl.intAutoHeaderId
        INNER JOIN tblSageFullStock stk ON stk.Code = ibtl.strPartNumber
        WHERE ibth.intAutoId = @ibtHeaderId AND ppl.strPickingType = 'ibt' AND ppl.intAutoPickingHeader = @intTLNumber

        UNION ALL 

        -- MOVE INTO RECEIVING BIN
        SELECT ibth.intReceivingBin intBinId,
            stk.StockLink intProductID,
            4 intDocType, 
            ppl.intOwnerID,
            ISNULL(track.decQtyRecieved, 0) decSingleQuantity,
            0 decBundleQuantity,
            0 decPalletQuantity,
            (ISNULL(track.decQtyRecieved, 0) * stk.Weight) decSingleWeight,
            0 decBundleWeight,
            0 decPalletWeight,
            GETDATE() dtmMovement,
            @userId UserId,
            NULL decAvgCost,
            NULL decLastCost,
            ppl.intOrderId intDocId,
            ppl.intorderdetailId intLineId,
            ppl.strUnickReference strDocReference,
            'DIMS IBT' strDocReference2
        FROM tblPickingPlan ppl
        INNER JOIN tblPickingPlanHeader ph ON ppl.intAutoPickingHeader = ph.intAutoPickingHeader
        INNER JOIN vwDIMSIBTLines ibtl ON ibtl.intAutoId = ppl.intorderdetailId
        INNER JOIN tblIBTTracking track ON track.intIBTLineId = ibtl.intAutoId 
            AND track.intTLNumber = @intTLNumber
        INNER JOIN tblIBTHeader ibth ON ibth.intAutoId = ibtl.intAutoHeaderId
        INNER JOIN tblSageFullStock stk ON stk.Code = ibtl.strPartNumber
        WHERE ibth.intAutoId = @ibtHeaderId AND ppl.strPickingType = 'ibt' AND ppl.intAutoPickingHeader = @intTLNumber

        UNION ALL 

        -- MOVE INTO VARIANCE BIN
        SELECT ibth.intVariance intBinId,
            stk.StockLink intProductID,
            4 intDocType, 
            ppl.intOwnerID,
            SUM(ISNULL(track.decQtyIssued, 0) - ISNULL(track.decQtyRecieved, 0)) decSingleQuantity,
            0 decBundleQuantity,
            0 decPalletQuantity,
            (SUM(ISNULL(track.decQtyIssued, 0) - ISNULL(track.decQtyRecieved, 0)) * stk.Weight) decSingleWeight,
            0 decBundleWeight,
            0 decPalletWeight,
            GETDATE() dtmMovement,
            @userId UserId,
            NULL decAvgCost,
            NULL decLastCost,
            ppl.intOrderId intDocId,
            ppl.intorderdetailId intLineId,
            ppl.strUnickReference strDocReference,
            'DIMS IBT' strDocReference2
        FROM tblPickingPlan ppl
        INNER JOIN tblPickingPlanHeader ph ON ppl.intAutoPickingHeader = ph.intAutoPickingHeader
        INNER JOIN vwDIMSIBTLines ibtl ON ibtl.intAutoId = ppl.intorderdetailId
        INNER JOIN tblIBTTracking track ON track.intIBTLineId = ibtl.intAutoId 
            AND track.intTLNumber = @intTLNumber
        INNER JOIN tblIBTHeader ibth ON ibth.intAutoId = ibtl.intAutoHeaderId
        INNER JOIN tblSageFullStock stk ON stk.Code = ibtl.strPartNumber
        WHERE ibth.intAutoId = @ibtHeaderId AND ppl.strPickingType = 'ibt' AND ppl.intAutoPickingHeader = @intTLNumber
        GROUP BY 
            ibth.intVariance,
            stk.StockLink,
            ppl.intOwnerID,
            stk.Weight,
            ppl.intOrderId,
            ppl.intorderdetailId,
            ppl.strUnickReference

        INSERT INTO tblPrintedDocuments (
            documenttype
            , DocId
            , [User]
            , TimePrinted
            , Printed
            , Attempted
            , OwnerId
            )
        VALUES (
            223
            , @ibtHeaderId
            , @userId
            , GETDATE()
            , 0
            , 0
            , 1
            )

        -- Commit transaction
        COMMIT TRANSACTION;

        SELECT 1 AS [Status], 'Successfully Received' AS [Message];
    END TRY

    BEGIN CATCH
        -- Rollback transaction on error
        ROLLBACK TRANSACTION;

        SELECT 0 AS [Status], ERROR_MESSAGE() AS [Message];
    END CATCH;
END