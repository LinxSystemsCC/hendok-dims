SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[usp_C_IssueIBTandMove] @ref NVARCHAR(50)
    , @userId BIGINT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    BEGIN TRANSACTION;

    BEGIN TRY
        -- Get IBT Header I

        -- MOVE OUT OF HARDCODED ZONE
        INSERT INTO tblStockTransactionHistory (
            intBinId
            , intProductID
            , intDocType
            , intOwnerId
            , decSingleQuantity
            , decBundleQuantity
            , decPalletQuantity
            , decSingleWeight
            , decBundleWeight
            , decPalletWeight
            , dtmMovement
            , UserId
            , decAvgCost
            , decLastCost
            , intDocId
            , intLineId
            , strDocReference
            , strDocReference2
            )
        SELECT CASE 
                WHEN ph.IntDcId = 1
                    THEN 1
                WHEN ph.IntDcId = 2
                    THEN 49
                END intBinId
            , stk.StockLink intProductID
            , 4 intDocType
            , ppl.intOwnerID
            , - ppl.mnyQty decSingleQuantity
            , - 0 decBundleQuantity
            , - 0 decPalletQuantity
            , - (ppl.mnyQty * stk.Weight) decSingleWeight
            , - 0 decBundleWeight
            , - 0 decPalletWeight
            , GETDATE() dtmMovement
            , @userId UserId
            , NULL decAvgCost
            , NULL decLastCost
            , ppl.intOrderId intDocId
            , ppl.intorderdetailId intLineId
            , ppl.strUnickReference strDocReference
            , 'DIMS IBT' strDocReference2
        FROM tblPickingPlan ppl
        INNER JOIN tblPickingPlanHeader ph
            ON ppl.intAutoPickingHeader = ph.intAutoPickingHeader
        INNER JOIN tblIBTLines ibtl
            ON ibtl.intAutoId = ppl.intorderdetailId
        INNER JOIN tblIBTHeader ibth
            ON ibth.intAutoId = ibtl.intAutoHeaderId
        INNER JOIN tblSageFullStock stk
            ON stk.Code = ibtl.strPartNumber
        WHERE ppl.strUnickReference = @ref
            AND ppl.strPickingType = 'ibt'
        
        UNION ALL
        
        -- MOVE INTO TRUCK
        SELECT ibth.intGIT intBinId
            , stk.StockLink intProductID
            , 4 intDocType
            , ppl.intOwnerID
            , ppl.mnyQty decSingleQuantity
            , 0 decBundleQuantity
            , 0 decPalletQuantity
            , (ppl.mnyQty * stk.Weight) decSingleWeight
            , 0 decBundleWeight
            , 0 decPalletWeight
            , GETDATE() dtmMovement
            , @userId UserId
            , NULL decAvgCost
            , NULL decLastCost
            , ppl.intOrderId intDocId
            , ppl.intorderdetailId intLineId
            , ppl.strUnickReference strDocReference
            , 'DIMS IBT' strDocReference2
        FROM tblPickingPlan ppl
        INNER JOIN tblPickingPlanHeader ph
            ON ppl.intAutoPickingHeader = ph.intAutoPickingHeader
        INNER JOIN tblIBTLines ibtl
            ON ibtl.intAutoId = ppl.intorderdetailId
        INNER JOIN tblIBTHeader ibth
            ON ibth.intAutoId = ibtl.intAutoHeaderId
        INNER JOIN tblSageFullStock stk
            ON stk.Code = ibtl.strPartNumber
        WHERE ppl.strUnickReference = @ref
            AND ppl.strPickingType = 'ibt';
            
        -- Update IBT Header Status
        ;WITH RelevantHeaders AS (
            SELECT DISTINCT ibtl.intAutoHeaderId AS intAutoId
            FROM tblPickingPlan ppl
            INNER JOIN tblIBTLines ibtl ON ppl.intorderdetailId = ibtl.intAutoId
            WHERE ppl.strUnickReference = @ref
                AND ppl.strPickingType = 'ibt'
        ),
        HeaderSums AS (
            SELECT 
                ibtl.intAutoHeaderId AS intAutoId,
                SUM(ibtl.mnyQty) AS totalQty
            FROM tblIBTLines ibtl
            WHERE ibtl.intAutoHeaderId IN (SELECT intAutoId FROM RelevantHeaders)
            GROUP BY ibtl.intAutoHeaderId
        ),
        PlannedSums AS (
            SELECT 
                ibtl.intAutoHeaderId AS intAutoId,
                SUM(ppl.mnyQty) AS totalPlannedQty
            FROM tblIBTLines ibtl
            LEFT OUTER JOIN tblPickingPlan ppl
                ON ppl.intorderdetailId = ibtl.intAutoId
                    AND ppl.intOrderId = ibtl.intAutoHeaderId
                    AND ppl.strPickingType = 'ibt'
            WHERE ibtl.intAutoHeaderId IN (SELECT intAutoId FROM RelevantHeaders)
            GROUP BY ibtl.intAutoHeaderId
        ),
        Aggregated AS (
            SELECT 
                H.intAutoId,
                H.totalQty,
                ISNULL(P.totalPlannedQty, 0) AS totalPlannedQty
            FROM HeaderSums H
            INNER JOIN PlannedSums P ON H.intAutoId = P.intAutoId
        )
        UPDATE ibth
        SET ibth.intStatus = 2
            , dtmIssued = GETDATE()
            , intIssuedBy = @userId
            , ibth.bitPartiallyProcessed = IIF(A.totalQty > A.totalPlannedQty, 1, 0)
        FROM tblIBTHeader ibth
        INNER JOIN Aggregated A
            ON ibth.intAutoId = A.intAutoId;

        -- Update IBT Lines Issued Quantity
        UPDATE ibtl
        SET mnyQtyIssued = ISNULL(ppl.mnyQty, 0)
        FROM tblIBTLines ibtl
        INNER JOIN tblPickingPlan ppl
            ON ppl.intorderdetailId = ibtl.intAutoId
                AND ppl.intOrderId = ibtl.intAutoHeaderId
                AND strPickingType = 'ibt'
        WHERE ppl.strUnickReference = @ref

        -- FIX FOR TRACKING TABLE LOGIC BY KYLE 2025/04/29
        UPDATE track
        SET decQtyIssued = pp.mnyQty,
            intIssuedBy = @userId,
            dtmIssued = GETDATE()
        FROM tblIBTTracking track
        INNER JOIN tblPickingPlan pp
            ON pp.intorderdetailId = track.intIBTLineId
        INNER JOIN tblIBTHeader ibth
            ON ibth.intAutoId = track.intIBTHeaderId
            --AND ibth.intTLNumber = track.intTLNumber no longer uses truck load  2025 07  22
        WHERE pp.strUnickReference = @ref

        INSERT INTO tblPrintedDocuments (
            documenttype
            , DocId
            , [User]
            , TimePrinted
            , Printed
            , Attempted
            , OwnerId
            )
        SELECT DISTINCT
            222 
            , track.intIBTHeaderId
            , @userId
            , getdate()
            , 0
            , 0
            , 1
        FROM tblIBTTracking track
        INNER JOIN tblPickingPlan pp
            ON pp.intorderdetailId = track.intIBTLineId
        WHERE pp.strUnickReference = @ref 

		-- Mark The Scanned QR Code to not scanned
		update tblScannedOrders set intJobId = -1*intJobId, intJobIdScannedItemID=-1*intJobIdScannedItemID
		where strUnickReference=@ref and (intJobId>0 and intJobIdScannedItemID>0)
		---insert new receiver/picker and Teamleader
		Update tblLoadAssignedUsers set intAssignedUserId =  282 where strUnickReference =@ref and strOperationName='Picking' 

		--Set Picked Qty to be 0
		update tblPickingPlan SET mnyPickedQuantity=0
		WHERE strUnickReference=@ref

		Update tblPickingPlanHeader set isReadyForInvoicing=NULL WHERE strUnickReference=@ref

        -- Added to track Delivery Notes for the IBT on the truck load
        INSERT INTO tblIBTHeaderTracking(
            intIBTHeaderId
            , intTLNumber
            , dtmCreated
            , intCreatedBy
        )
        SELECT DISTINCT ibtl.intAutoHeaderId AS intIBTHeaderId
            , ppl.intAutoPickingHeader AS intTLNumber
            , GETDATE() AS dtmCreated
            , @userId AS intCreatedBy
        FROM tblPickingPlan ppl
        INNER JOIN tblIBTLines ibtl ON ppl.intorderdetailId = ibtl.intAutoId
        WHERE ppl.strUnickReference = @ref
            AND ppl.strPickingType = 'ibt'

        COMMIT TRANSACTION;

        SELECT 'Success' AS Result;
    END TRY

    BEGIN CATCH
        ROLLBACK TRANSACTION;

        SELECT ERROR_MESSAGE() AS Result;
    END CATCH;
END;


 