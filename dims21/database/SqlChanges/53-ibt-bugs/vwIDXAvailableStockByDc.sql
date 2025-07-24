SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW dbo.vwIDXAvailableStockByDc
WITH SCHEMABINDING
AS
SELECT
    stk.intProductID,
    bins.intDcId,
    SUM(ISNULL(stk.decSingleQuantityInStock, 0)) AS decOnHand,
    SUM(ISNULL(stk.decSingleQuantityInStock, 0)) - ISNULL(pl.decTotalQuantityPlanned, 0) AS decAvail,
    COUNT_BIG(*) AS RecordCount -- Required for indexed views
FROM dbo.vwIDXBinsInventory AS stk
    INNER JOIN dbo.tblBinNames AS bins ON stk.intAutoBinID = bins.intBinId
    INNER JOIN dbo.tblLocationNames AS locs ON bins.intLocationId = locs.intLocationNameId
    INNER JOIN dbo.tblLocationTypes AS loctypes ON locs.intLocationTypeId = loctypes.intLocationTypeId
    LEFT JOIN dbo.vwIDXPlannedInventoryByDc AS pl
        ON pl.intProductId = stk.intProductID AND pl.intDcId = bins.intDcId
WHERE loctypes.bitTracked = 1
GROUP BY
    stk.intProductID,
    bins.intDcId,
    pl.decTotalQuantityPlanned;
GO
