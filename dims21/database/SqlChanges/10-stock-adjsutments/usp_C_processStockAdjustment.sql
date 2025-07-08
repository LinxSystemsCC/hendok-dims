SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- Create the stored procedure in the specified schema
ALTER PROCEDURE [dbo].[usp_C_processStockAdjustment] 
    @xml XML
    , @userId INT
    -- add more stored procedure parameters here
AS
BEGIN

    SET NOCOUNT ON;
    -- body of the stored procedure
    INSERT INTO tblXmldata (
        strXML
        , strType
        )
    VALUES (
        @xml
        , 'Stock Adjustment'
        )

    BEGIN TRY
        BEGIN TRANSACTION

        DROP TABLE IF EXISTS #tempStockAdjustment

        SELECT intStockLink = XTbl.value('(intStockLink)[1]', 'BIGINT')
            , intDocumentTypeId = XTbl.value('(intDocumentTypeId)[1]', 'NVARCHAR(100)')
            , intDcId = XTbl.value('(intDcId)[1]', 'BIGINT')
            , intLocationId = XTbl.value('(intLocationId)[1]', 'BIGINT')
            , intBinId = XTbl.value('(intBinId)[1]', 'BIGINT')
            , mnyOnHand = XTbl.value('(mnyOnHand)[1]', 'MONEY')
            , strAdjustmentType = XTbl.value('(strAdjustmentType)[1]', 'NVARCHAR(100)')
            , mnyAdjustment = XTbl.value('(mnyAdjustment)[1]', 'MONEY')
            , mnyNewOnHand = XTbl.value('(mnyNewOnHand)[1]', 'MONEY')
            , strDocReference = XTbl.value('(strDocReference)[1]', 'NVARCHAR(100)')
            , strDocReference2 = XTbl.value('(strDocReference2)[1]', 'NVARCHAR(100)')
        INTO #tempStockAdjustment
        FROM @xml.nodes('/xml/result') AS x(XTbl)

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
        SELECT td.intBinId AS intBinId
            , td.intStockLink AS intProductID
            , td.intDocumentTypeId AS intDocType -- Hardcoded Stock Adjustment from tblDocumentTypes
            , 1 AS intOwnerId
            , (td.mnyNewOnHand - td.mnyOnHand) AS decSingleQuantity
            , 0 AS decBundleQuantity
            , 0 AS decPalletQuantity
            , ((td.mnyNewOnHand - td.mnyOnHand) * stk.Weight) AS decSingleWeight
            , 0 AS decBundleWeight
            , 0 AS decPalletWeight
            , GETDATE() AS dtmMovement
            , @userId AS UserId
            , NULL AS decAvgCost
            , NULL AS decLastCost
            , NULL AS intDocId
            , NULL AS intLineId
            , td.strDocReference AS strDocReference
            , td.strDocReference2 AS strDocReference2
        FROM #tempStockAdjustment td
        INNER JOIN viewBinNames bn ON bn.intBinId = td.intBinId
        INNER JOIN tblSageFullStock stk ON stk.StockLink = td.intStockLink

        DROP TABLE #tempStockAdjustment

        COMMIT;

        SELECT 1 AS [Status], 'Success' AS [Message];
    END TRY

    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK

        SELECT 0 AS [Status], ERROR_MESSAGE() AS [Message]
    END CATCH
END
GO
