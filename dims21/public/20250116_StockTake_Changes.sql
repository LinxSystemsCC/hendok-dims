
ALTER TABLE tblStockTakeCounts
ADD bitAdjustmentApproved BIT DEFAULT 0 NOT NULL;


ALTER TABLE tblStockTakeItems
ADD strTeamName NVARCHAR(50);


SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- Create the stored procedure in the specified schema
ALTER PROCEDURE [dbo].[sp_C_stockCountVarianceStockAdjustment] @xml XML
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
        , 'Stock Count Variance Adjustment'
        )

    BEGIN TRY
        BEGIN TRANSACTION

        DROP TABLE IF EXISTS #TempXMLData

        SELECT intAutoCountId = XTbl.value('(intAutoCountId)[1]', 'bigint')
            , strItemCode = XTbl.value('(strItemCode)[1]', 'nvarchar(50)')
            , intMainStockCountID = XTbl.value('(intMainStockCountID)[1]', 'int')
            , mnySingle = XTbl.value('(mnySingle)[1]', 'money')
            , mnyPallet = XTbl.value('(mnyPallet)[1]', 'money')
            , mnyTotal = XTbl.value('(mnyTotal)[1]', 'money')
            , mnyOnHand = XTbl.value('(mnyOnHand)[1]', 'money')
            , intBinId = XTbl.value('(intBinId)[1]', 'int')
            , strBinName = XTbl.value('(strBinName)[1]', 'nvarchar(50)')
            , mnyVariance = XTbl.value('(mnyVariance)[1]', 'money')
        INTO #TempXMLData
        FROM @xml.nodes('/xml/result') AS x(XTbl)

        UPDATE stc 
        SET stc.bitAdjustmentApproved = 1
        FROM tblStockTakeCounts stc 
        INNER JOIN #TempXMLData temp ON temp.intAutoCountId = stc.intAutoCountId

        -- Update or Insert count for managers
        MERGE INTO tblStockTakeCounts AS stc
        USING #TempXMLData AS td
            ON stc.intMainStockCountID = td.intMainStockCountID
                AND stc.strItemCode = td.strItemCode
                AND stc.strBinLocation = td.strBinName
                AND stc.strStockTakeName = 'Manager'
        WHEN MATCHED
            THEN
                UPDATE
                SET stc.mnyQty = td.mnySingle
                    , stc.mnyCarton = td.mnyPallet
                    , stc.bitAdjustmentApproved = 1
        WHEN NOT MATCHED
            THEN
                INSERT (
                    strItemCode
                    , intUserId
                    , dteDeviceTime
                    , strTransactionType
                    , strSubScriber
                    , mnyQty
                    , strBinLocation
                    , dteTimeSaved
                    , strStockTakeName
                    , mnyCarton
                    , dteExpiryDate
                    , intMainStockCountID
                    , strComment
                    , bitAdjustmentApproved
                    )
                VALUES (
                    td.strItemCode
                    , @userId
                    , GETDATE()
                    , 'COUNT'
                    , NULL
                    , td.mnySingle
                    , td.strBinName
                    , GETDATE()
                    , 'Manager'
                    , td.mnyPallet
                    , GETDATE()
                    , td.intMainStockCountID
                    , ''
                    , 1
                    );

        DECLARE @StockMove AS udfStockMovementType;

        -- Set up table to do stock adjustment
        INSERT INTO @StockMove (
            strDocType
            , strDocReference
            , intDocReference
            , strCompanyName
            , dtmMovement
            , intLineNo
            , intUserId
            , intLocationId
            , strLocationName
            , intDcId
            , strDCName
            , intBinId
            , strBinName
            , intStockLinkId
            , strPartNumber
            , mnyQtyMovedOnHandBase
            , mnyQtyMovedOnHand
            , mnyQtyMovedAvailableBase
            , mnyQtyMovedAvailable
            , strUOMBase
            , strUOMMoved
            , mnyConversion
            , mnyValueMoved
            , mnyMovedWeightOnHand
            , mnyMovedWeightAvailable
            )
        SELECT 'Inventory Adjustment' strDocType
            , st.strStockTakeName strDocReference
            , td.intMainStockCountID intDocReference
            , 'Hendok Distiribution' strCompanyName
            , GETDATE() dtmMovement
            , NULL intLineNo
            , @userId intUserId
            , bn.intLocationId
            , bn.strLocationName
            , bn.intDcId
            , bn.strDCName
            , td.intBinId
            , td.strBinName
            , stk.StockLink intStockLinkId
            , stk.Code strPartNumber
            , td.mnyTotal - ISNULL(ib.mnyOnHand, 0) mnyQtyMovedOnHandBase
            , td.mnyPallet - ISNULL(ib.mnyOnHandPallet, 0) mnyQtyMovedOnHand
            , td.mnyTotal - ISNULL(ib.mnyAvail, 0) mnyQtyMovedAvailableBase
            , td.mnyPallet - ISNULL(ib.mnyAvailPallet, 0) mnyQtyMovedAvailable
            , 'Single' strUOMBase
            , 'Single' strUOMMoved
            , stk.uiIIPackSize mnyConversion
            , 1 mnyValueMoved
            , stk.ufIIWeight - ISNULL(ib.mnyOnHandWeight, 0) mnyMovedWeightOnHand
            , stk.ufIIWeight - ISNULL(ib.mnyAvailWeight, 0) mnyMovedWeightAvailable
        FROM #TempXMLData td
        INNER JOIN tblStockTakenames st
            ON st.intAutoId = td.intMainStockCountID
        INNER JOIN viewBinNames bn
            ON bn.intBinId = td.intBinId
        INNER JOIN tblSageFullStock stk
            ON stk.Code = td.strItemCode
        LEFT OUTER JOIN tblInventoryBin ib ON ib.intBinId = bn.intBinId AND ib.strPartNumber = td.strItemCode
        WHERE td.mnyVariance <> 0

        -- SELECT * FROM @StockMove

        -- Post Stock adjustment
        EXEC sp_C_InventoryMovements @StockMove

        DROP TABLE #TempXMLData

        COMMIT;

        SELECT 'Success' AS Result;
    END TRY

    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK

        SELECT ERROR_MESSAGE() AS Result
    END CATCH
END
GO



SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- Create the stored procedure in the specified schema
ALTER PROCEDURE [dbo].[sp_C_StockTake] @strReference NVARCHAR(50)
    , @locations NVARCHAR(MAX)
    , @bins NVARCHAR(MAX)
    , @ProductGroups NVARCHAR(MAX)
    -- add more stored procedure parameters here
AS
BEGIN
    -- body of the stored procedure
    SET NOCOUNT ON;

    DECLARE @stockTakeiD AS INT
    DECLARE @locationName AS NVARCHAR(50)

    DROP TABLE IF EXISTS #tblTempBins
    DROP TABLE IF EXISTS #tblTempTeams

    -- Set the set of Bins
    -- DECLARE @bins NVARCHAR(max) = '84,83' -- Uncomment to test
    SELECT intBinId
        , strBin
    INTO #tblTempBins
    FROM fnSplitString(@bins, ',') sb
    INNER JOIN viewBinNames b
        ON b.intBinId = sb.[Data]

    SELECT du.UserID
        , du.UserName
        , gt.strGroupType strTeamName
    INTO #tblTempTeams
    FROM tblDIMSUsers du
    INNER JOIN tblGroupTypes gt
        ON gt.intGroupId = du.GroupId
    WHERE gt.strGroupType = 'RedTeam'

    -- Get the Location
    SELECT @locationName = strLocationName
    FROM viewLocationNames
    WHERE intLocationNameId = TRY_CAST(@locations AS INT)

    -- Create The stock take
    -- SELECT * FROM tblStockTakenames
    INSERT INTO tblStockTakenames (
        strStockTakeName
        , dtmCreated
        , stockTakeLocation
        )
    VALUES (
        @strReference
        , getdate()
        , @locationName
        )

    -- Set Id for Stocktake
    SELECT @stockTakeiD = @@IDENTITY
    FROM tblStockTakenames

    -- Create links to items for stock take to count
    INSERT INTO tblStockTakeItems (
        intStockTakeId
        , strPartNumber
        , strTeamName
        )
    SELECT @stockTakeiD intStockTakeId
        , stk.Code
        , 'RedTeam'
    FROM fnSplitString(@ProductGroups, ',') g
    INNER JOIN tblSageFullStock stk
        ON stk.ItemGroup = g.[Data]

    -- Allocate Bins for stock take that havent been allocated for that user
    -- SELECT * FROM tblBinNamesAllocated
    INSERT INTO tblBinNamesAllocated (
        intBinId
        , strBin
        , intUserId
        , intStocktakeId
        )
    SELECT tb.intBinId
        , tb.strBin
        , tt.UserID
        , @stockTakeiD
    FROM #tblTempBins tb
    CROSS JOIN #tblTempTeams tt
    LEFT OUTER JOIN tblBinNamesAllocated cab ON cab.intBinId = tb.intBinId AND cab.intUserId = tt.UserID 
    WHERE cab.intBinId IS NULL

    -- Create stock take link for users
    INSERT INTO tblStockTakeLinks (
        intStockTakeId
        , strStockTakeNameRef
        )
    SELECT DISTINCT @stockTakeiD
        , strTeamName + '|'+ @strReference
    FROM #tblTempTeams

    -- Create Manager Team
    /*INSERT INTO tblStockTakeLinks (
        intStockTakeId
        , strStockTakeNameRef
        )
    VALUES (
        @stockTakeiD
        , 'Manager|' + @strReference
        )
    */
    
    SELECT 'SUCCESS' AS Result
END
GO



SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER VIEW [dbo].[viewtblItemToStockCount]
AS
SELECT StockLink itemId
    , Code PastelCode
    , Description_1 + '[ ' + Code + ' ] ' PastelDescription
    , '' Binnumber
    , isnull(BarCode, '') BarCode
    , null Barcodetwo
    , uiIIPackSize BarcodeThree
    , ucIIPackSize2 BarcodeFour
    , null BarCodeFive
    , stn.strStockTakeName
    , sti.strTeamName
FROM tblSageFullStock AS p
INNER JOIN tblStockTakeItems AS sti
    ON sti.strPartNumber = p.Code COLLATE DATABASE_DEFAULT
INNER JOIN tblStockTakenames AS stn
    ON stn.intAutoId = sti.intStockTakeId
GO



SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[spViewItemsToCount]
    -- Add the parameters for the stored procedure here
    @userId AS BIGINT = 1
    , @uniid AS NVARCHAR(50)
AS
BEGIN
    -- SET NOCOUNT ON added to prevent extra result sets from
    -- interfering with SELECT statements.
    SET NOCOUNT ON;

    SELECT [itemId]
        , [PastelCode]
        , [PastelDescription]
        , [Binnumber]
        , [BarCode]
        , [Barcodetwo]
        , [BarcodeThree]
        , [BarcodeFour]
        , [BarCodeFive]
        , [strStockTakeName]
    FROM [linxdbDIMSHendok].[dbo].[viewtblItemToStockCount]
    WHERE strStockTakeName = RIGHT(@uniid, LEN(@uniid) - CHARINDEX('|', @uniid))
        AND strTeamName = LEFT(@uniid, CHARINDEX('|', @uniid) - 1)
    ORDER BY PastelDescription
END
GO



SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- Create the stored procedure in the specified schema
CREATE PROCEDURE [dbo].[usp_c_StockTakeRecountItems]
    -- add params
    @intStockTakeId BIGINT
    , @xml XML
AS
BEGIN
    -- body of the stored procedureintAutoCountId
    SET NOCOUNT ON;

    DECLARE @strStockTakeName NVARCHAR(50);

    BEGIN TRY
        BEGIN TRANSACTION [TranRecount];

        SELECT @strStockTakeName = strStockTakeName
        FROM tblStockTakenames
        WHERE intAutoId = @intStockTakeId

        SELECT intAutoCountId = XTbl.value('(intAutoCountId)[1]', 'BIGINT')
            , intMainStockCountID = XTbl.value('(intMainStockCountID)[1]', 'BIGINT')
            , strStockTakeName = XTbl.value('(strStockTakeName)[1]', 'NVARCHAR(100)')
            , strItemCode = XTbl.value('(strItemCode)[1]', 'NVARCHAR(50)')
        INTO #tempRecountItems
        FROM @xml.nodes('/xml/result') AS x(XTbl)

        IF NOT EXISTS (
            SELECT 1
            FROM tblStockTakeLinks
            WHERE intStockTakeId = @intStockTakeId
                AND strStockTakeNameRef = 'BlueTeam|' + @strStockTakeName
        )
        BEGIN
            INSERT INTO tblStockTakeLinks (
                intStockTakeId
                , strStockTakeNameRef
                )
            VALUES (
                @intStockTakeId
                , 'BlueTeam|' + @strStockTakeName
                )
        END

        select * from tblStockTakeItems

        MERGE INTO tblStockTakeItems AS target
        USING #tempRecountItems AS source
            ON target.strPartNumber = source.strItemCode
                AND target.intStockTakeId = source.intMainStockCountID
                AND target.strTeamName = 'BlueTeam'
        WHEN MATCHED
            THEN
                UPDATE
                SET target.strPartNumber = source.strItemCode
        WHEN NOT MATCHED
            THEN
                INSERT (
                    intStockTakeId
                    , strPartNumber
                    , strTeamName
                    )
                VALUES (
                    source.intMainStockCountID
                    , source.strItemCode
                    , 'BlueTeam'
                    );

        COMMIT TRANSACTION [TranRecount]

        SELECT 'SUCCESS' AS Result
    END TRY

    BEGIN CATCH
        ROLLBACK TRANSACTION [TranRecount]

        SELECT (
                CONCAT (
                    ERROR_MESSAGE()
                    , 'SQL Error Line: '
                    , ERROR_LINE()
                    )
                ) AS Result
    END CATCH
END
GO



SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER VIEW [dbo].[viewStockCountVariances]
AS
WITH RankedCounts
AS (
    SELECT stc.intAutoCountId
        , sti.strPartNumber strItemCode
        , stc.dteDeviceTime
        , sti.intStockTakeId intMainStockCountID
        , sti.strTeamName 
        , stc.mnyQty
        , stc.mnyCarton
        , stc.mnyCarton * stk.uiIIPackSize AS mnyPalletInSingles
        , (stc.mnyQty + stc.mnyCarton * stk.uiIIPackSize) AS mnyTotal
        , ISNULL(ib.mnyOnHand, 0) AS mnyOnHand
        , bn.intBinId
        , bn.strBin AS strBinName
        , stk.uiIIPackSize AS mnyPalletFactor
        , ISNULL(stc.bitAdjustmentApproved, 0) bitAdjustmentApproved
        , CASE 
            WHEN sti.strTeamName = 'Manager'
                THEN 1
            WHEN sti.strTeamName = 'BlueTeam'
                THEN 2
            WHEN sti.strTeamName = 'RedTeam'
                THEN 3
            ELSE 4
            END AS TeamPriority
    FROM tblStockTakeItems sti
    LEFT OUTER JOIN tblStockTakeCounts stc
        ON sti.intStockTakeId = stc.intMainStockCountID
        AND sti.strPartNumber = stc.strItemCode
        AND sti.strTeamName = stc.strStockTakeName
    LEFT OUTER JOIN viewBinNames bn 
        ON bn.strBin = stc.strBinLocation
    LEFT OUTER JOIN tblInventoryBin ib
        ON ib.intBinId = bn.intBinId
            AND ib.strPartNumber = sti.strPartNumber
    INNER JOIN tblSageFullStock stk
        ON stk.Code = sti.strPartNumber
    )
SELECT rc.intAutoCountId
    , stn.strStockTakeName
    , rc.strItemCode
    , rc.dteDeviceTime
    , rc.intMainStockCountID
    , rc.mnyQty AS mnySingle
    , rc.mnyCarton AS mnyPallet
    , rc.mnyPalletInSingles
    , rc.mnyTotal
    , rc.mnyOnHand
    , rc.intBinId
    , rc.strBinName
    , rc.mnyPalletFactor
    , rc.strTeamName AS strLastCountBy
    , CASE 
        WHEN rc.intAutoCountId IS NULL THEN 0 
        WHEN rc.bitAdjustmentApproved = 1 THEN 0
    ELSE 1 END AS bitCanApprove
    , CASE 
        WHEN rc.bitAdjustmentApproved = 1
            THEN '#BDF786'
        WHEN RC.mnyTotal <> rc.mnyOnHand
            THEN NULL
        WHEN rc.intAutoCountId IS NULL THEN '#E7E6E8'
        ELSE NULL
        END AS strRowColor
FROM (
    SELECT r.*
        , ROW_NUMBER() OVER (
            PARTITION BY r.intMainStockCountID
            , r.strItemCode ORDER BY r.TeamPriority
            ) AS RowNum
    FROM RankedCounts r
    ) rc
INNER JOIN tblStockTakenames stn
    ON stn.intAutoId = rc.intMainStockCountID
WHERE rc.RowNum = 1;
GO
