SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[spGetProductsToPrint] @machineId BIGINT,
    @deptId BIGINT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @deptName AS NVARCHAR(50)

    SELECT @deptName = strDeptName
    FROM tblDepartments
    WHERE intAutoID = @deptId;

    IF @deptName = 'Roofing'
    BEGIN
        SELECT rm.Description_1,
            r.CustomerName + ' : ' + rmd.Description_1 + ' : ' + rm.Description_1 + ' | ' strProductDescription,
            CASE 
                WHEN ((CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) * CAST(rm.[Pack Size 01] AS DECIMAL(10, 2))) % CAST(rm.[Pack Size 01] AS DECIMAL(10, 2)) = 0
                    THEN CAST(rm.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                WHEN (CAST(rm.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2)))) > CAST(rm.[Pack Size 01] AS DECIMAL(10, 2))
                    THEN CAST(rm.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                ELSE CAST(CAST(CAST(rm.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) AS INTEGER) AS NVARCHAR(50)) + ' Required'
                END AS strPackToCut,
            rp.intQty,
            rp.intRoofSOID intSoId,
            CAST(ISNULL(rp.intQtyPrinted, 0) AS NVARCHAR(20)) + ' of ' + CAST(ISNULL(rp.intQty, 0) AS NVARCHAR(20)) AS strProductStats,
            '' AS intPalletConf,
            '' AS strPalletTypeDescription,
            rp.strJobStatus,
            0 AS intJobId,
            ISNULL(rp.strReference, 'Ask your Supervisor to start a job') AS strReference,
            rp.intSequence,
            rm.[Pack Size 01] intPackSize,
            'Roofing' strDepartment
        FROM tblRoofingSONumToPlan rp
        --INNER JOIN viewOrderlinesForPickingWithReferences r ON r.idInvoiceLines = rp.intOrderLineId -- Adjusted 20240326 by Kyle to Pirans view below
        INNER JOIN [Hendok Distribution].dbo.pv_RoofPlanning r ON r.OrderNumber collate database_default = rp.strSONum
            AND r.Company collate database_default = rp.strCompany
            AND r.ProductCode collate database_default = rp.strProductCode
        INNER JOIN [Hendok Distribution].dbo._bvStockFull rm ON rm.Code = r.ProductCode
        INNER JOIN [Hendok Distribution].dbo._bvStockFull rmd ON rmd.Code = rm.ucIIROOFRAW1
        WHERE intMachineId = @machineId
            AND rp.strJobStatus = 'start'
        ORDER BY dtmCreated,
            strReference,
            rp.intSequence;
    END
    ELSE IF @deptName LIKE '%Diamond Mesh%'
    BEGIN
        SELECT stk.Description_1,
            sm.CustomerName + ' : ' + isnull(rstk.Description_1, 'NO RAW MAT') + ' : ' + stk.Description_1 + ' | ' strProductDescription,
            CASE 
                WHEN ((CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) * CAST(stk.[Pack Size 01] AS DECIMAL(10, 2))) % CAST(stk.[Pack Size 01] AS DECIMAL(10, 2)) = 0
                    THEN CAST(stk.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                WHEN (CAST(stk.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2)))) > CAST(stk.[Pack Size 01] AS DECIMAL(10, 2))
                    THEN CAST(stk.[Pack Size 01] AS NVARCHAR(50)) + ' Required'
                ELSE CAST(CAST(CAST(stk.[Pack Size 01] AS DECIMAL(10, 2)) * (CAST(intQty AS DECIMAL(10, 2)) - CAST(intQtyPrinted AS DECIMAL(10, 2))) AS INTEGER) AS NVARCHAR(50)) + ' Required'
                END AS strPackToCut,
            ml.intQty,
            ml.intDiamondMeshSOID intSoId,
            CAST(ISNULL(ml.intQtyPrinted, 0) AS NVARCHAR(20)) + ' of ' + CAST(ISNULL(ml.intQty, 0) AS NVARCHAR(20)) AS strProductStats,
            '' AS intPalletConf,
            '' AS strPalletTypeDescription,
            ml.strJobStatus,
            0 AS intJobId,
            ISNULL(ml.strReference, 'Ask your Supervisor to start a job') AS strReference,
            ml.intSequence,
            stk.[Pack Size 01] intPackSize,
            'Diamond Mesh' strDepartment
        FROM tblDiamondMeshLines ml
        INNER JOIN [Hendok Distribution].dbo.pv_DiMeshR4Eva sm ON sm.OrderNumber collate database_default = ml.strSONum
            AND sm.Company collate database_default = ml.strCompany
            AND sm.ProductCode collate database_default = ml.strProductCode
        INNER JOIN [Hendok Distribution].dbo._bvStockFull stk ON stk.Code = sm.ProductCode
        LEFT OUTER JOIN [Hendok Distribution].dbo._bvStockFull rstk ON rstk.Code = stk.ucIIROOFRAW1
        WHERE intMachineId = @machineId
            AND ml.strJobStatus = 'start'
        ORDER BY dtmCreated,
            strReference,
            ml.intSequence;
    END
    ELSE
    BEGIN

        SELECT CAST([tblJobQrcodeAllocation].dteJobCreated AS NVARCHAR(22)) + ' :' + strProductDescription AS strProductDescription,
            intJobId,
            CAST(ISNULL(mnyQtyProduced, 0) AS NVARCHAR(20)) + ' Produced / ' + CAST(ISNULL(mnyQtyRequired, 0) AS NVARCHAR(20)) AS strProductStats,
            pc.intPalletConf,
            pc.strPalletTypeDescription,
            strJobStatus,
            NULL strDepartment
        FROM [tblJobQrcodeAllocation]
        INNER JOIN viewtblProducts p ON p.PastelCode COLLATE DATABASE_DEFAULT = [tblJobQrcodeAllocation].strItemCode
        INNER JOIN tblPalletConf pc ON pc.intPalletId = [tblJobQrcodeAllocation].intPalletId
        WHERE dteJobEnded IS NULL
            AND intMachineId = @machineId
            AND intDeptId = @deptId;
    END
END
GO


