SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[usp_R_ProductsToPrint] 
    @intMachineId BIGINT,
    @intDepartmentId BIGINT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @strDepartmentName AS NVARCHAR(50)

    SELECT @strDepartmentName = strDeptName
    FROM tblDepartments
    WHERE intAutoID = @intDepartmentId;

    IF @strDepartmentName = 'Roofing'
    BEGIN
        SELECT r.CustomerName + ' : ' + rmd.Description_1 + ' : ' + rm.Description_1 AS strProductDescription,
            CASE 
                WHEN ((CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) * CAST(rm.[Pack Size 01] AS DECIMAL(10, 2))) % CAST(rm.[Pack Size 01] AS DECIMAL(10, 2)) = 0
                    THEN CAST(rm.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                WHEN (CAST(rm.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2)))) > CAST(rm.[Pack Size 01] AS DECIMAL(10, 2))
                    THEN CAST(rm.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                ELSE CAST(CAST(CAST(rm.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) AS INTEGER) AS NVARCHAR(50)) + ' Required'
                END AS strPackToCut,
            rp.intRoofSOID AS intAutoJobId,
            CAST(ISNULL(rp.intQtyPrinted, 0) AS NVARCHAR(20)) + ' of ' + CAST(ISNULL(rp.intQty, 0) AS NVARCHAR(20)) AS strProductStats,
            ISNULL(rp.strReference, 'Ask your Supervisor to start a job') AS strReference,
            rp.intSequence,
            @strDepartmentName strDepartment,
            2 intDefaultToPrint
        FROM tblRoofingSONumToPlan rp
        INNER JOIN [Hendok Distribution].dbo.pv_RoofPlanning r ON r.OrderNumber collate database_default = rp.strSONum
            AND r.Company collate database_default = rp.strCompany
            AND r.ProductCode collate database_default = rp.strProductCode
        INNER JOIN [Hendok Distribution].dbo._bvStockFull rm ON rm.Code = r.ProductCode
        INNER JOIN [Hendok Distribution].dbo._bvStockFull rmd ON rmd.Code = rm.ucIIROOFRAW1
        WHERE intMachineId = @intMachineId
            AND rp.strJobStatus = 'start'
        ORDER BY dtmCreated,
            strReference,
            rp.intSequence;
    END
    ELSE IF @strDepartmentName LIKE '%Diamond Mesh%'
    BEGIN
        SELECT sm.CustomerName + ' : ' + isnull(rstk.Description_1, 'NO RAW MAT') + ' : ' + stk.Description_1 AS strProductDescription,
            CASE 
                WHEN ((CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) * CAST(stk.[Pack Size 01] AS DECIMAL(10, 2))) % CAST(stk.[Pack Size 01] AS DECIMAL(10, 2)) = 0
                    THEN CAST(stk.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                WHEN (CAST(stk.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2)))) > CAST(stk.[Pack Size 01] AS DECIMAL(10, 2))
                    THEN CAST(stk.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                ELSE CAST(CAST(CAST(stk.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) AS INTEGER) AS NVARCHAR(50)) + ' Required'
                END AS strPackToCut,
            ml.intDiamondMeshSOID intAutoJobId,
            CAST(ISNULL(ml.intQtyPrinted, 0) AS NVARCHAR(20)) + ' of ' + CAST(ISNULL(ml.intQty, 0) AS NVARCHAR(20)) AS strProductStats,
            ISNULL(ml.strReference, 'Ask your Supervisor to start a job') AS strReference,
            ml.intSequence,
            @strDepartmentName strDepartment,
            1 intDefaultToPrint
        FROM tblDiamondMeshLines ml
        INNER JOIN [Hendok Distribution].dbo.pv_DiMeshR4Eva sm ON sm.OrderNumber collate database_default = ml.strSONum
            AND sm.Company collate database_default = ml.strCompany
            AND sm.ProductCode collate database_default = ml.strProductCode
        INNER JOIN [Hendok Distribution].dbo._bvStockFull stk ON stk.Code = sm.ProductCode
        LEFT OUTER JOIN [Hendok Distribution].dbo._bvStockFull rstk ON rstk.Code = stk.ucIIROOFRAW1
        WHERE intMachineId = @intMachineId
            AND ml.strJobStatus = 'start'
        ORDER BY dtmCreated,
            strReference,
            ml.intSequence;
    END
    ELSE
    BEGIN
        SELECT 
            stk.Description_1 AS strProductDescription,
            CAST(decQtyConfiguration AS nvarchar(5)) + ' Required' AS strPackToCut,
            wo.intAutoId intAutoJobId,
            CAST(ISNULL(wo.decQtyProduced, 0) AS NVARCHAR(20)) + ' of ' + CAST(ISNULL(wo.decQtyRequired, 0) AS NVARCHAR(20)) AS strProductStats,
            ISNULL('JOB ID - ' + CAST(wo.intAutoId AS NVARCHAR(20)), 'Ask your Supervisor to start a job') AS strReference,
            wo.intSequence,
            @strDepartmentName strDepartment,
            1 intDefaultToPrint
        FROM tblWorkOrders wo
        INNER JOIN tblSageFullStock stk ON stk.Code = wo.strProductCode
        WHERE intMachineId = @intMachineId
            AND intStatusId = 1
        ORDER BY wo.intSequence;
    END
END
GO


