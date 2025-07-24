SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE VIEW [dbo].[vwIDXPlannedInventoryByDc] 
WITH SCHEMABINDING 
AS 
SELECT 
    intProductId,
    intDcId,
    SUM(ISNULL(mnyQty,0)) AS decTotalQuantityPlanned,
    COUNT_BIG(*) AS RecordCount
FROM dbo.tblpickingplan AS tblPickPlanLines
    INNER JOIN dbo.tblPickingPlanHeader AS tblPickPlanHeaders
        ON tblPickPlanLines.intAutoPickingHeader = tblPickPlanHeaders.intAutoPickingHeader
WHERE 
    ISNULL(tblPickPlanHeaders.bitInvoiced, 0) <> 1 AND ISNULL(tblPickPlanHeaders.isCancelled, 0) <> 1 AND ISNULL(tblPickPlanLines.isLineInvoiced, 0) <> 1 AND ISNULL(tblPickPlanHeaders.intStatus, 0) <> 1
GROUP BY intProductId, intDcId;
GO
