--WARNING! ERRORS ENCOUNTERED DURING SQL PARSING!
/****** Object:  StoredProcedure [dbo].[spInsertPrintRoofingLabels]    Script Date: 2025/07/03 04:23:26 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		Kyle Westran
-- Create date: 2025-07-03
-- Description:	Inserts a roofing label To Print!
-- =============================================
CREATE OR ALTER PROCEDURE [dbo].[usp_C_RoofingLabels]
    -- Variables
    @intAutoJobId AS INT,
    @strOperator AS NVARCHAR(50),
    @strPrintId AS NVARCHAR(50),
    @decQtyToPrint AS DECIMAL(18, 2),
    @intUserId INT
AS
BEGIN
    -- SET NOCOUNT ON added to prevent extra result sets from
    -- interfering with SELECT statements.
    SET NOCOUNT ON;

    DECLARE @intDepartmentId INT;
    DECLARE @intMachineId INT;
    DECLARE @intJobId INT;
    DECLARE @Counter INT;
    DECLARE @strProductCode NVARCHAR(50);
    DECLARE @strSONumber NVARCHAR(10);
    DECLARE @strCustomerName NVARCHAR(100);
    DECLARE @strPrinterPath NVARCHAR(50);
    DECLARE @decQtyRequired DECIMAL(18, 2);
    DECLARE @decQtyPrinted DECIMAL(18, 2);

    -- Gets the Roofing Sales Order Information
    SELECT @intMachineId = intMachineId,
        @strProductCode = strProductCode,
        @strSONumber = rf.strSONum,
        @strCustomerName = r.CustomerName
    FROM tblRoofingSONumToPlan rf
    INNER JOIN [Hendok Distribution].dbo.pv_RoofPlanning r ON r.OrderNumber collate database_default = rf.strSONum
        AND r.Company collate database_default = rf.strCompany
        AND r.ProductCode collate database_default = rf.strProductCode
    WHERE intRoofSOID = @intAutoJobId

    -- Sets the Department
    SELECT @intDepartmentId = intAutoID
    FROM tblDepartments
    WHERE strDeptName = 'Roofing'

    -- Sets the printer path
    SELECT @strPrinterPath = p.strPrinter
    FROM tblMapPrinterToMachine mp
    INNER JOIN tblPrinters p ON p.ID = mp.intPrinterID
    INNER JOIN tblMachines m ON m.intAutoMachineID = mp.intMachineID
    WHERE @intMachineId = m.intAutoMachineID

    -- insert for QR Code Allocation
    INSERT INTO tblJobQrcodeAllocation (
        intMachineId,
        intDeptId,
        mnyQtyRequired,
        strOperator,
        mnyEstimatedPallets,
        strRef,
        strItemCode,
        intPalletId,
        strCustomerName,
        strLabelType,
        intRef,
        strTableName
        )
    VALUES (
        @intMachineId,
        @intDepartmentId,
        1,
        @strOperator,
        1,
        @strSONumber,
        @strProductCode,
        12,
        @strCustomerName,
        'Single',
        @intAutoJobId,
        'tblRoofingSONumToPlan'
        )

    -- Gets the latest Added Job Id from tblJobQrcodeAllocation
    SELECT @intJobId = @@IDENTITY
    FROM tblJobQrcodeAllocation

    -- We insert a line for each label that needs to be printed
    SET @Counter = 1

    WHILE (@Counter <= @decQtyToPrint)
    BEGIN
        INSERT INTO tblPrintLables (
            intLabelType,
            intFlag,
            intQty,
            intUserId,
            strPrinterPath,
            intJobId,
            strToken
            )
        VALUES (
            - 1,
            1,
            1,
            1,
            @strPrinterPath,
            @intJobId,
            @strPrintId
            )

        SET @Counter = @Counter + 1
    END

    -- Gets Quantities Required and printed
    SELECT @decQtyRequired = intQty,
        @decQtyPrinted = intQtyPrinted
    FROM tblRoofingSONumToPlan
    WHERE intRoofSOID = @intAutoJobId

    -- Updates the job quantity printed
    IF (@decQtyPrinted + 1) > @decQtyRequired
    BEGIN
        UPDATE tblJobQrcodeAllocation
        SET mnyEstimatedPallets = @decQtyRequired - @decQtyPrinted
        WHERE intJobId = @intJobId

        UPDATE tblRoofingSONumToPlan
        SET intQtyPrinted = intQty
        WHERE intRoofSOID = @intAutoJobId
    END
    ELSE
    BEGIN
        UPDATE tblRoofingSONumToPlan
        SET intQtyPrinted = intQtyPrinted + 1
        WHERE intRoofSOID = @intAutoJobId
    END

    -- Gets Quantities Required and printed
    SELECT @decQtyRequired = intQty,
        @decQtyPrinted = intQtyPrinted
    FROM tblRoofingSONumToPlan
    WHERE intRoofSOID = @intAutoJobId

    -- Does a check to see if it has met its Quota then updates the job to end
    IF @decQtyRequired <= @decQtyPrinted
    BEGIN
        UPDATE tblRoofingSONumToPlan
        SET strJobStatus = 'end',
            dtmJobEnded = GETDATE(),
            dtmUpdated = GETDATE()
        WHERE intRoofSOID = @intAutoJobId
    END

    SELECT 1 [Status],
        'Success' [Message]
END
