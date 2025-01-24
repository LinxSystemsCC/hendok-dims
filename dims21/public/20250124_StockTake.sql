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
        , bn.intDcId
        , bn.strDCName
        , bn.intLocationId
        , bn.strLocationName
        , bn.intBinId
        , bn.strBin AS strBinName
        , stc.intUserId
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
    , rc.intDcId
    , rc.strDCName
    , rc.intLocationId
    , rc.strLocationName
    , rc.intBinId
    , rc.strBinName
    , rc.mnyPalletFactor
    , rc.strTeamName AS strLastCountBy
    , du.UserID
    , du.UserName
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
LEFT OUTER JOIN tblDIMSUSERS du ON du.UserID = rc.intUserId
WHERE rc.RowNum = 1;
GO


SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER VIEW [dbo].[viewLocationNames]
AS
SELECT loc.intLocationNameId
    , loc.strLocationAbv
    , loc.strLocationName
    , types.intLocationTypeId
    , types.strLocationType
    , loc.dtmCreated
    , loc.strSageWhsCode
    , dcs.intDcId
    , dcs.strDCName
FROM tblLocationNames loc
INNER JOIN tblLocationTypes types
    ON loc.intLocationTypeId = types.intLocationTypeId
INNER JOIN (
    SELECT DISTINCT intLocationId
        , intDcId
        , strDCName
    FROM viewBinNames
    ) dcs
    ON dcs.intLocationId = loc.intLocationNameId
GO