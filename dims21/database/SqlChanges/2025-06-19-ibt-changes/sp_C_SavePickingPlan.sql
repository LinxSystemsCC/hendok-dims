SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_C_SavePickingPlan]
    @xml AS XML
    , @strUnickReference AS NVARCHAR(20)
    , @userId AS INT
    , @userName AS NVARCHAR(50)
    , @intDcId INT

    , @intTrailerType INT
    , @intTeamLeaderId INT
    , @loadName NVARCHAR(100)
    , @loadType NVARCHAR(250)
    , @orderType NVARCHAR(250) -- 20240902 Added to account for collection
    -- add more stored procedure parameters here
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @intAutoHeaderId AS INT
    DECLARE @responseMessage NVARCHAR(500) = '';
    DECLARE @StockPlanned AS udfStockPlanned;
    DECLARE @intLocationId AS INT;
    DECLARE @strDCName AS NVARCHAR(100);
    DECLARE @strLocationName AS NVARCHAR(100);
    DECLARE @problemLines AS NVARCHAR(MAX);
	

    INSERT INTO tblXmldata (
        strXML
        , intOptionId
        , strType
    )
    VALUES (
        @xml
        , 717
        , 'Picking Plan ' + @strUnickReference
    )

    BEGIN TRY
        BEGIN TRANSACTION

            DROP TABLE IF EXISTS #tempXMLLines
            DROP TABLE IF EXISTS #tempPlannedLines

            -- We use this to adjust the available quantities.
            SELECT @strDCName = strDCName, @intLocationId = intLocationId, @strLocationName = strLocationName FROM viewBinNames WHERE intDcId = @intDcId AND strBin IN ('MWH-KZN-ZONE 1', 'CTW-WC-ZONE1')

            SELECT *
            INTO #tempXMLLines
            FROM (
                SELECT strUnickReference = XTbl.value('(strUnickReference)[1]', 'nvarchar(50)')
                    , strPickingType = XTbl.value('(strPickingType)[1]', 'nvarchar(50)')
                    , mnyQty = XTbl.value('(mnyQty)[1]', 'money')
                    , intorderdetailId = XTbl.value('(intorderdetailId)[1]', 'int')
                    , intOwnerId = XTbl.value('(intOwnerID)[1]', 'int')
                    , intSequence = XTbl.value('(intSequence)[1]', 'int')
                FROM @xml.nodes('/xml/result') AS x(XTbl)
            ) AS x

            -- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< Build Up the planned data >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            SELECT xl.*, od.iInvoiceID intOrderId, stk.StockLink intProductId, stk.Code strCode
            INTO #tempPlannedLines
            FROM #tempXMLLines xl
            INNER JOIN [Hendok Distribution].dbo._btblInvoiceLines od ON od.idInvoiceLines = xl.intorderdetailId
            INNER JOIN [Hendok Distribution].dbo.StkItem stk ON stk.StockLink = od.iStockCodeID
            WHERE intOwnerId = 1 AND strPickingType <> 'upliftment' AND strPickingType <> 'ibt'

            UNION ALL

            SELECT xl.*, od.iInvoiceID intOrderId, stk.StockLink intProductId, stk.Code strCode
            FROM #tempXMLLines xl
            INNER JOIN [Henroof].dbo._btblInvoiceLines od ON od.idInvoiceLines = xl.intorderdetailId
            INNER JOIN [Henroof].dbo.StkItem stk ON stk.StockLink = od.iStockCodeID
            WHERE intOwnerId = 2 AND strPickingType <> 'upliftment' AND strPickingType <> 'ibt'

            UNION ALL

            SELECT xl.*, od.iInvoiceID intOrderId, stk.StockLink intProductId, stk.Code strCode
            FROM #tempXMLLines xl
            INNER JOIN [Ukhosi].dbo._btblInvoiceLines od ON od.idInvoiceLines = xl.intorderdetailId
            INNER JOIN [Ukhosi].dbo.StkItem stk ON stk.StockLink = od.iStockCodeID
            WHERE intOwnerId = 3 AND strPickingType <> 'upliftment' AND strPickingType <> 'ibt'

            UNION ALL

            SELECT xl.*, upl.intUpliftmentNumber intOrderId, stk.StockLink intProductId, stk.Code COLLATE DATABASE_DEFAULT strCode
            FROM #tempXMLLines xl
            INNER JOIN tblUpliftmentProducts upl ON upl.ID = xl.intorderdetailId
            INNER JOIN tblSageFullStock stk ON stk.Code = upl.PastelCode COLLATE DATABASE_DEFAULT
            WHERE strPickingType = 'upliftment'

            -- ADDED FOR IBTS
            UNION ALL

            SELECT xl.*, ibtl.intAutoHeaderId intOrderId, stk.StockLink intProductId, stk.Code COLLATE DATABASE_DEFAULT strCode
            FROM #tempXMLLines xl
            INNER JOIN tblIBTLines ibtl ON ibtl.intAutoId = xl.intorderdetailId
            INNER JOIN tblSageFullStock stk ON stk.Code = ibtl.strPartNumber COLLATE DATABASE_DEFAULT
            WHERE strPickingType = 'ibt'

            -- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ERROR HANDELING START >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            -- Catch Lines that have been picked or loaded for updating
            IF EXISTS (SELECT 1 FROM tblPickingPlan pp
                INNER JOIN #tempPlannedLines pl
                    ON pp.strUnickReference = pl.strUnickReference
                    AND pp.intorderdetailId = pl.intorderdetailId
                    AND pp.intOrderId = pl.intOrderId
                WHERE (pp.mnyQty <> pl.mnyQty OR pp.intSequence <> pl.intSequence)
                    AND ((ISNULL(pp.mnyPickedQuantity, 0) <> 0 OR ISNULL(pp.mnyLoadedQty, 0) <> 0))
            )
            BEGIN
                SELECT @problemLines = STUFF((
                SELECT DISTINCT CHAR(13) + CHAR(10) + '• ' + CAST(issues.intOrderId AS NVARCHAR(50)) + ' - ' + issues.strCode
                FROM (
                    SELECT 
                        pp.intOrderId
                        , pp.strCode
                    FROM tblPickingPlan pp
                    INNER JOIN #tempPlannedLines pl
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE (pp.mnyQty <> pl.mnyQty OR pp.intSequence <> pl.intSequence)
                        AND ((ISNULL(pp.mnyPickedQuantity, 0) <> 0 OR ISNULL(pp.mnyLoadedQty, 0) <> 0))
                ) AS issues
                FOR XML PATH('')
                ), 1, 2, '') + CHAR(13) + CHAR(10)

                SET @problemLines = REPLACE(@problemLines, 'x0D;', CHAR(13)) -- Replacing x0D; with carriage return
                SET @problemLines = REPLACE(@problemLines, '&#x0D;', CHAR(10)) -- Replacing &#x0D; with line feed
                SET @problemLines = REPLACE(@problemLines, '&#x0A;', CHAR(10)) -- Replacing &#x0A; with line feed
                SET @problemLines = REPLACE(@problemLines, '\r\n', CHAR(13) + CHAR(10)) -- Replacing \r\n with carriage return and line feed
                SET @problemLines = REPLACE(@problemLines, '&#', '') -- Removing incomplete HTML entity

                SET @responseMessage += 'The Following Lines cannot be Updated because Picking or Loading has already commenced:' + @problemLines + CHAR(13) + CHAR(10);
            END

            -- Catch Lines that have been Picked or loaded for deleting
            IF EXISTS (
                SELECT 
                    1
                FROM tblPickingPlan pp
                LEFT OUTER JOIN #tempPlannedLines pl
                    ON pp.strUnickReference = pl.strUnickReference
                    AND pp.intorderdetailId = pl.intorderdetailId
                    AND pp.intOrderId = pl.intOrderId
                WHERE pl.intorderdetailId IS NULL AND pp.strUnickReference = @strUnickReference
                    AND ((ISNULL(pp.mnyPickedQuantity, 0) <> 0 OR ISNULL(pp.mnyLoadedQty, 0) <> 0))
            )
            BEGIN
                SELECT @problemLines = STUFF((
                SELECT DISTINCT CHAR(13) + CHAR(10) + '• ' + CAST(issues.intOrderId AS NVARCHAR(50)) + ' - ' + issues.strCode
                FROM (
                    SELECT 
                        pp.intOrderId
                        , pp.strCode
                    FROM tblPickingPlan pp
                    LEFT OUTER JOIN #tempPlannedLines pl
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE pl.intorderdetailId IS NULL AND pp.strUnickReference = @strUnickReference
                        AND ((ISNULL(pp.mnyPickedQuantity, 0) <> 0 OR ISNULL(pp.mnyLoadedQty, 0) <> 0))
                ) AS issues
                FOR XML PATH('')
                ), 1, 2, '') + CHAR(13) + CHAR(10)

                SET @problemLines = REPLACE(@problemLines, 'x0D;', CHAR(13)) -- Replacing x0D; with carriage return
                SET @problemLines = REPLACE(@problemLines, '&#x0D;', CHAR(10)) -- Replacing &#x0D; with line feed
                SET @problemLines = REPLACE(@problemLines, '&#x0A;', CHAR(10)) -- Replacing &#x0A; with line feed
                SET @problemLines = REPLACE(@problemLines, '\r\n', CHAR(13) + CHAR(10)) -- Replacing \r\n with carriage return and line feed
                SET @problemLines = REPLACE(@problemLines, '&#', '') -- Removing incomplete HTML entity

                SET @responseMessage += 'The Following Lines cannot be Deleted because Picking or Loading has already commenced:' + @problemLines + CHAR(13) + CHAR(10);
            END

            IF (LEN(ISNULL(@strUnickReference, '')) < 3)
            BEGIN
                SET @responseMessage += 'A Unique reference needs to be generated for the plan';

                RAISERROR (
                    @responseMessage,
                    16,
                    1
                );
            END

            -- TURN ON FOR DEBUGGING ERRORS AND STOP ANY FURTHER PROGRESS
            IF 1 = 0
            BEGIN
                SET @responseMessage += '[DEBUG ON]' + CHAR(13) + CHAR(10);
                RAISERROR (
                    @responseMessage,
                    16,
                    1
                );
            END
            
            -- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ERROR HANDELING END >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

            -- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< PROCESS HANDELING START >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
            -- Insert A new picking plan if one doesnt exist
            IF NOT EXISTS (SELECT 1 FROM tblPickingPlanHeader WHERE strUnickReference = @strUnickReference)
            BEGIN
                INSERT INTO tblPickingPlanHeader (
                    strUnickReference
                    , intDcId
                    , intTeamLeaderId
                    , strPickingNickname
                    , intTrailerType
                    , bitCollection
                    , hasAssignedExtras
                    , strLoadType
                )
                VALUES (
                    @strUnickReference
                    , @intDcId
                    , @intTeamLeaderId
                    , @loadName
                    , @intTrailerType
                    , CASE WHEN @orderType = 'COLLECT' THEN 1 ELSE 0 END
                    , CASE WHEN @orderType = 'COLLECT' THEN 1 ELSE NULL END
                    , @loadType
                )

                SELECT @intAutoHeaderId = @@IDENTITY

                -- Catch error for unset header ID
                IF (ISNULL(@intAutoHeaderId, 0) < 1)
                BEGIN
                    SET @responseMessage += 'Unable To Set Auto Header ID: ' + CAST(@intAutoHeaderId AS NVARCHAR(50)) + ' And the plan could not be saved. Please Try Again.';

                    RAISERROR (
                        @responseMessage
                        , 16
                        , 1
                    )
                END

                INSERT INTO [dbo].[tblPickingPlan] (
                    intorderdetailId
                    , mnyQty
                    , strPickingType
                    , strUnickReference
                    , intAutoPickingHeader
                    , intProductId
                    , intUserId
                    , intOwnerID
                    , strCode
                    , intOrderId
                    , mnyOriginalQty
                    , intorderdetailIdcurrent
                    , intOrderIdcurrent
                    , intSequence
                )
                SELECT 
                    intorderdetailId
                    , mnyQty
                    , strPickingType
                    , strUnickReference
                    , @intAutoHeaderId
                    , intProductId
                    , @userId
                    , intOwnerID
                    , strCode
                    , intOrderId
                    , mnyQty
                    , intorderdetailId
                    , intOrderId
                    , intSequence
                FROM #tempPlannedLines

                INSERT INTO tblManagementConsol (
                    ConsoleTypeId
                    , UserId
                    , Message
                    , Importance
                    , ReferenceNo
                    , LoggedBy
                )
                SELECT 444
                    , @userId
                    , 'Product ID: ' + cast(intProductId AS NVARCHAR(15)) + ' QTY ' + cast(mnyQty AS NVARCHAR(25)) + ' Inserted into picking plan'
                    , 1
                    , strUnickReference
                    , @userName 
                FROM #tempPlannedLines
                
                INSERT INTO @StockPlanned(
                    intLocationId
                    , strLocationName
                    , intDCId
                    , strDCName
                    , intStockLinkId
                    , strPartNumber
                    , mnyPlanned
                    , mnyPlannedWeight
                ) SELECT 
                    @intLocationId intLocationId
                    , @strLocationName strLocationName -- Hardcoded while we figure out a solution
                    , @intDcId intDCId
                    , @strDCName strDCName
                    , stk.StockLink intStockLinkId
                    , stk.Code strPartNumber
                    , -mnyQty mnyPlanned
                    , -(stk.ufIIWeight * mnyQty) mnyPlannedWeight
                FROM #tempPlannedLines tpl
                INNER JOIN tblSageFullStock stk ON stk.Code = tpl.strCode

                EXEC sp_U_AggrigatedPlanStock @StockPlanned

				EXEC spPickingPlannerCreditLimitEmail @strUnickReference

                ;WITH RelevantHeaders AS (
                    SELECT DISTINCT ibtl.intAutoHeaderId AS intAutoId
                    FROM tblIBTLines ibtl
                    INNER JOIN #tempPlannedLines tpl ON ibtl.intAutoId = tpl.intorderdetailId
                ), HeaderSums AS (
                    -- Get total qty of all lines per header
                    SELECT 
                        ibtl.intAutoHeaderId AS intAutoId,
                        SUM(ibtl.mnyQty) AS totalQty
                    FROM tblIBTLines ibtl
                    WHERE ibtl.intAutoHeaderId IN (SELECT intAutoId FROM RelevantHeaders)
                    GROUP BY ibtl.intAutoHeaderId
                ),
                PlannedSums AS (
                    -- Get planned qty per header based on planned lines
                    SELECT 
                        ibtl.intAutoHeaderId AS intAutoId,
                        SUM(ibtl.mnyQty) AS totalPlannedQty
                    FROM tblIBTLines ibtl
                    INNER JOIN #tempPlannedLines tpl ON ibtl.intAutoId = tpl.intorderdetailId
                    WHERE ibtl.intAutoHeaderId IN (SELECT intAutoId FROM RelevantHeaders)
                    GROUP BY ibtl.intAutoHeaderId
                ),
                Aggregated AS (
                    -- Join both sets: only include headers where at least one line is planned
                    SELECT 
                        H.intAutoId,
                        H.totalQty,
                        ISNULL(P.totalPlannedQty, 0) AS totalPlannedQty
                    FROM HeaderSums H
                    INNER JOIN PlannedSums P ON H.intAutoId = P.intAutoId
                )
                UPDATE ibth
                SET 
                    ibth.intStatus = 1, 
                    ibth.intTlNumber = @intAutoHeaderId,
                    ibth.bitPartiallyProcessed = IIF(A.totalQty > A.totalPlannedQty, 1, 0)
                FROM tblIBTHeader ibth
                INNER JOIN Aggregated A ON ibth.intAutoId = A.intAutoId;

				-- ADDITION FOR TRACKING TABLE LOGIC BY KYLE 2025/04/29
                INSERT INTO tblIBTTracking(
                    intIBTHeaderId
                    , intIBTLineId
                    , intTLNumber
                    , intCreatedBy
                    , dtmCreated
                )
                SELECT ibtl.intAutoHeaderId
                    , ibtl.intAutoId
                    , @intAutoHeaderId
                    , @userId
                    , GETDATE()
                FROM #tempPlannedLines pl
                INNER JOIN tblIBTLines ibtl ON ibtl.intAutoId = pl.intorderdetailId

            END

            -- Update the plan if it exists
            ELSE IF EXISTS (SELECT 1 FROM tblPickingPlanHeader WHERE strUnickReference = @strUnickReference)
            BEGIN

                -- Update the Header
                UPDATE tblPickingPlanHeader 
                SET 
                    intTeamLeaderId = @intTeamLeaderId
                    , strPickingNickname = @loadName
                    , intTrailerType = @intTrailerType 
                    , strLoadType = @loadType
                WHERE strUnickReference = @strUnickReference
                
                -- Log into console
                INSERT INTO tblManagementConsol (
                    ConsoleTypeId
                    , UserId
                    , Message
                    , Importance
                    , ReferenceNo
                    , LoggedBy
                )
                SELECT 444
                    , @userId
                    , 'Product ID: ' + cast(pl.intProductId AS NVARCHAR(15)) + ' Updated from Qty: ' + cast(pp.mnyQty AS NVARCHAR(25)) + 'to Qty: ' + cast(pl.mnyQty AS NVARCHAR(25))
                    , 1
                    , pl.strUnickReference
                    , @userName 
                FROM tblPickingPlan pp
                INNER JOIN #tempPlannedLines pl
                    ON pp.strUnickReference = pl.strUnickReference
                    AND pp.intorderdetailId = pl.intorderdetailId
                    AND pp.intOrderId = pl.intOrderId
                WHERE (pp.mnyQty <> pl.mnyQty OR pp.intSequence <> pl.intSequence)
                    AND (ISNULL(pp.mnyPickedQuantity, 0) = 0 AND ISNULL(pp.mnyLoadedQty, 0) = 0)

                -- Update Stock For Updated Planned Stock needs to happen here
                INSERT INTO @StockPlanned(
                    intLocationId
                    , strLocationName
                    , intDCId
                    , strDCName
                    , intStockLinkId
                    , strPartNumber
                    , mnyPlanned
                    , mnyPlannedWeight
                ) SELECT 
                    @intLocationId intLocationId
                    , @strLocationName strLocationName -- Hardcoded while we figure out a solution
                    , @intDcId intDCId
                    , @strDCName strDCName
                    , stk.StockLink intStockLinkId
                    , stk.Code strPartNumber
                    , -1 * (tpl.mnyQty - pp.mnyQty) mnyPlanned
                    , -1 * (stk.ufIIWeight * (tpl.mnyQty - pp.mnyQty)) mnyPlannedWeight
                FROM tblPickingPlan pp
                INNER JOIN #tempPlannedLines tpl
                    ON pp.strUnickReference = tpl.strUnickReference
                    AND pp.intorderdetailId = tpl.intorderdetailId
                    AND pp.intOrderId = tpl.intOrderId
                INNER JOIN tblSageFullStock stk ON stk.Code = tpl.strCode
                WHERE (pp.mnyQty <> tpl.mnyQty OR pp.intSequence <> tpl.intSequence)
                    AND (ISNULL(pp.mnyPickedQuantity, 0) = 0 AND ISNULL(pp.mnyLoadedQty, 0) = 0)

                EXEC sp_U_AggrigatedPlanStock @StockPlanned

                -- Update The lines that havent been picked or loaded
                UPDATE pp
                SET pp.mnyQty = pl.mnyQty
                    , pp.intSequence = pl.intSequence
                FROM tblPickingPlan pp
                INNER JOIN #tempPlannedLines pl
                    ON pp.strUnickReference = pl.strUnickReference
                    AND pp.intorderdetailId = pl.intorderdetailId
                    AND pp.intOrderId = pl.intOrderId
                WHERE (pp.mnyQty <> pl.mnyQty OR pp.intSequence <> pl.intSequence)
                    AND (ISNULL(pp.mnyPickedQuantity, 0) = 0 AND ISNULL(pp.mnyLoadedQty, 0) = 0)
                
				;WITH RelevantHeaders AS (
                    SELECT DISTINCT ibtl.intAutoHeaderId AS intAutoId
                    FROM tblIBTLines ibtl
                    INNER JOIN #tempPlannedLines tpl ON ibtl.intAutoId = tpl.intorderdetailId
                ), HeaderSums AS (
                    -- Get total qty of all lines per header
                    SELECT 
                        ibtl.intAutoHeaderId AS intAutoId,
                        SUM(ibtl.mnyQty) AS totalQty
                    FROM tblIBTLines ibtl
                    WHERE ibtl.intAutoHeaderId IN (SELECT intAutoId FROM RelevantHeaders)
                    GROUP BY ibtl.intAutoHeaderId
                ),
                PlannedSums AS (
                    -- Get planned qty per header based on planned lines
                    SELECT 
                        ibtl.intAutoHeaderId AS intAutoId,
                        SUM(ibtl.mnyQty) AS totalPlannedQty
                    FROM tblIBTLines ibtl
                    INNER JOIN #tempPlannedLines tpl ON ibtl.intAutoId = tpl.intorderdetailId
                    WHERE ibtl.intAutoHeaderId IN (SELECT intAutoId FROM RelevantHeaders)
                    GROUP BY ibtl.intAutoHeaderId
                ),
                Aggregated AS (
                    -- Join both sets: only include headers where at least one line is planned
                    SELECT 
                        H.intAutoId,
                        H.totalQty,
                        ISNULL(P.totalPlannedQty, 0) AS totalPlannedQty
                    FROM HeaderSums H
                    INNER JOIN PlannedSums P ON H.intAutoId = P.intAutoId
                )
                UPDATE ibth
                SET 
                    ibth.intStatus = 1, 
                    ibth.intTlNumber = @intAutoHeaderId,
                    ibth.bitPartiallyProcessed = IIF(A.totalQty > A.totalPlannedQty, 1, 0)
                FROM tblIBTHeader ibth
                INNER JOIN Aggregated A ON ibth.intAutoId = A.intAutoId;
                
                -- Insert newly added lines
                IF EXISTS (
                    SELECT 
                        1
                    FROM #tempPlannedLines pl
                    LEFT OUTER JOIN tblPickingPlan pp
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE pp.intorderdetailId IS NULL
                )
                BEGIN

                    SELECT @intAutoHeaderId = intAutoPickingHeader FROM tblPickingPlanHeader WHERE strUnickReference = @strUnickReference

                    -- Log to console
                    INSERT INTO tblManagementConsol (
                        ConsoleTypeId
                        , UserId
                        , Message
                        , Importance
                        , ReferenceNo
                        , LoggedBy
                    )
                    SELECT 444
                        , @userId
                        , 'Product ID: ' + cast(pl.intProductId AS NVARCHAR(15)) + ' Qty: ' + cast(pl.mnyQty AS NVARCHAR(25)) + ' Added on to picking plan'
                        , 1
                        , pl.strUnickReference
                        , @userName 
                    FROM #tempPlannedLines pl
                    LEFT OUTER JOIN tblPickingPlan pp
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE pp.intorderdetailId IS NULL;

                     -- Update Stock For Additionally Inserted Planned Stock
                    INSERT INTO @StockPlanned(
                        intLocationId
                        , strLocationName
                        , intDCId
                        , strDCName
                        , intStockLinkId
                        , strPartNumber
                        , mnyPlanned
                        , mnyPlannedWeight
                    ) SELECT 
                        @intLocationId intLocationId
                        , @strLocationName strLocationName
                        , @intDcId intDCId
                        , @strDCName strDCName
                        , stk.StockLink intStockLinkId
                        , stk.Code strPartNumber
                        , -tpl.mnyQty mnyPlanned
                        , -(stk.ufIIWeight * tpl.mnyQty) mnyPlannedWeight
                    FROM #tempPlannedLines tpl
                        LEFT OUTER JOIN tblPickingPlan pp
                            ON pp.strUnickReference = tpl.strUnickReference
                            AND pp.intorderdetailId = tpl.intorderdetailId
                            AND pp.intOrderId = tpl.intOrderId
                    INNER JOIN tblSageFullStock stk ON stk.Code = tpl.strCode
                    WHERE pp.intorderdetailId IS NULL;

                    EXEC sp_U_AggrigatedPlanStock @StockPlanned

                    -- Insert Newly Added Lines to the existing plan
                    INSERT INTO [dbo].[tblPickingPlan] (
                        intorderdetailId
                        , mnyQty
                        , strPickingType
                        , strUnickReference
                        , intAutoPickingHeader
                        , intProductId
                        , intUserId
                        , intOwnerID
                        , strCode
                        , intOrderId
                        , mnyOriginalQty
                        , intorderdetailIdcurrent
                        , intOrderIdcurrent
                        , intSequence
                    )
                    SELECT 
                        pl.intorderdetailId,
                        pl.mnyQty,
                        pl.strPickingType,
                        pl.strUnickReference,
                        @intAutoHeaderId,
                        pl.intProductId,
                        @userId,
                        pl.intOwnerId,
                        pl.strCode,
                        pl.intOrderId,
                        pl.mnyQty,
                        pl.intorderdetailId,
                        pl.intOrderId,
                        pl.intSequence
                    FROM #tempPlannedLines pl
                    LEFT OUTER JOIN tblPickingPlan pp
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE pp.intorderdetailId IS NULL;

                END
                -- Delete lines that havent been picked or loaded if applicable [DANGER ZONE]
                IF EXISTS (
                    SELECT 
                        1
                    FROM tblPickingPlan pp
                    LEFT OUTER JOIN #tempPlannedLines pl
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE pl.intorderdetailId IS NULL AND pp.strUnickReference = @strUnickReference
                        AND (ISNULL(pp.mnyPickedQuantity, 0) = 0 AND ISNULL(pp.mnyLoadedQty, 0) = 0)
                )
                BEGIN
                    -- Log into management console
                    INSERT INTO tblManagementConsol (
                        ConsoleTypeId
                        , UserId
                        , Message
                        , Importance
                        , ReferenceNo
                        , LoggedBy
                    )
                    SELECT 444
                        , @userId
                        , 'Product ID: ' + cast(pp.intProductId AS NVARCHAR(15)) + ' Qty: ' + cast(pp.mnyQty AS NVARCHAR(25)) + ' Deleted from picking plan'
                        , 1
                        , pp.strUnickReference
                        , @userName 
                    FROM tblPickingPlan pp
                    LEFT OUTER JOIN #tempPlannedLines pl
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE pl.intorderdetailId IS NULL AND pp.strUnickReference = @strUnickReference
                        AND (ISNULL(pp.mnyPickedQuantity, 0) = 0 AND ISNULL(pp.mnyLoadedQty, 0) = 0)

                    -- Update Stock For Deleted Planned Stock 
                    INSERT INTO @StockPlanned(
                        intLocationId
                        , strLocationName
                        , intDCId
                        , strDCName
                        , intStockLinkId
                        , strPartNumber
                        , mnyPlanned
                        , mnyPlannedWeight
                    )
                    SELECT 
                        @intLocationId intLocationId
                        , @strLocationName strLocationName
                        , @intDcId intDCId
                        , @strDCName strDCName
                        , stk.StockLink intStockLinkId
                        , stk.Code strPartNumber
                        , pp.mnyQty mnyPlanned
                        , (stk.ufIIWeight * pp.mnyQty) mnyPlannedWeight
                    FROM tblPickingPlan pp
                    LEFT OUTER JOIN #tempPlannedLines pl
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    INNER JOIN tblSageFullStock stk ON stk.Code = pp.strCode
                    WHERE pl.intorderdetailId IS NULL AND pp.strUnickReference = @strUnickReference
                        AND (ISNULL(pp.mnyPickedQuantity, 0) = 0 AND ISNULL(pp.mnyLoadedQty, 0) = 0)

                    EXEC sp_U_AggrigatedPlanStock @StockPlanned
                    
                    -- Delete the lines that havent been picked or loaded yet
                    DELETE pp
                    FROM tblPickingPlan pp
                    LEFT OUTER JOIN #tempPlannedLines pl
                        ON pp.strUnickReference = pl.strUnickReference
                        AND pp.intorderdetailId = pl.intorderdetailId
                        AND pp.intOrderId = pl.intOrderId
                    WHERE pl.intorderdetailId IS NULL AND pp.strUnickReference = @strUnickReference
                        AND (ISNULL(pp.mnyPickedQuantity, 0) = 0 AND ISNULL(pp.mnyLoadedQty, 0) = 0)
                END
            END
            
            -- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< PROCESS HANDELING END >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

        COMMIT

        IF LEN(@responseMessage) < 3
        BEGIN
            SET @responseMessage = 'Success'
        END

        SELECT @responseMessage AS Result
    END TRY

    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK

        SELECT ERROR_MESSAGE() AS Result
    END CATCH
    
END
GO
