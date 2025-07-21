SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Kyle Westran
-- Create date: 2025-07-04
-- Description:	Inserts a general work order label To Print!
-- =============================================
CREATE OR ALTER PROCEDURE dbo.usp_C_WorkOrderLabels
    @intAutoJobId INT
    , @strOperator NVARCHAR(50)
    , @strPrintId NVARCHAR(50)
    , @decQtyToPrint DECIMAL(18,2)
    , @intUserId INT
-- add more stored procedure parameters here
AS
BEGIN
    SET NOCOUNT ON;

    -- body of the stored procedure
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

    SELECT @intDepartmentId = wo.intDepartmentId
        , @intMachineId = wo.intMachineId
        , @strProductCode = wo.strProductCode
        , @decQtyRequired = ISNULL(wo.decQtyRequired, 0)
        , @decQtyPrinted = ISNULL(wo.decQtyProduced, 0)
        , @strSONumber = 'PRODUCTION'
    FROM tblWorkOrders wo
    WHERE wo.intAutoId = @intAutoJobId

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
        'tblWorkOrders'
        )

    -- Gets the latest Added Job Id from tblJobQrcodeAllocation
    SET @intJobId = SCOPE_IDENTITY();

    -- INSERT THE LABELS
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

    -- Updates the job quantity printed
    IF (@decQtyPrinted + 1) > @decQtyRequired
    BEGIN
        UPDATE tblJobQrcodeAllocation
        SET mnyEstimatedPallets = @decQtyRequired - @decQtyPrinted
        WHERE intJobId = @intJobId

        UPDATE tblWorkOrders
        SET decQtyProduced = decQtyRequired
        WHERE intAutoId = @intAutoJobId
    END
    ELSE
    BEGIN
        UPDATE tblWorkOrders
        SET decQtyProduced = ISNULL(decQtyProduced, 0) + 1
        WHERE intAutoId = @intAutoJobId
    END

    -- Gets Quantities Required and printed
    SELECT @decQtyRequired = ISNULL(decQtyRequired, 0),
        @decQtyPrinted = ISNULL(decQtyProduced, 0)
    FROM tblWorkOrders
    WHERE intAutoId = @intAutoJobId

    -- Does a check to see if it has met its Quota then updates the job to end
    IF @decQtyRequired <= @decQtyPrinted
    BEGIN
        UPDATE tblWorkOrders
        SET intStatusId = 2,
            dtmEnded = GETDATE(),
            intEndedBy = @intUserId
        WHERE intAutoId = @intAutoJobId
    END

    SELECT 1 [Status], 'Success' [Message]
END
GO
