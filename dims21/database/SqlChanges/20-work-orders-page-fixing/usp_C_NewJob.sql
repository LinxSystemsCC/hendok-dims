SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		Kyle Westran
-- Create date:   2025-06-23
-- Description:	New And improved version from spInsertNewJob
-- =============================================
ALTER PROCEDURE [dbo].[usp_C_NewJob]
    -- Add the parameters for the stored procedure here
    @intDepartmentId AS INT
    , @intMachineId AS INT
    , @strProductCode AS NVARCHAR(50)
    , @decQtyRequired AS DECIMAL(18,2)
    , @decQtyConfiguration AS DECIMAL(18,2)
    , @strConfigurationType AS NVARCHAR(10)
    , @intCreatedBy AS INT
    , @dtePropStart AS DATE
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @bitMachineAvailable AS BIT

    SELECT @bitMachineAvailable = CASE 
            WHEN count(*) > 0
                THEN 0
            ELSE 1
            END
    FROM [tblWorkOrders]
    WHERE intMachineId = @intMachineId
        AND intStatusId IN (0, 1)

    IF @bitMachineAvailable = 1
    BEGIN
        INSERT INTO tblWorkOrders (
            intDepartmentId
            , intMachineId
            , strProductCode
            , decQtyRequired
            , decQtyConfiguration
            , strConfigurationType
            , intStatusId
            , intCreatedBy
            , dtmCreated
            , dtePropStart
        )
        VALUES (
            @intDepartmentId
            , @intMachineId
            , @strProductCode
            , @decQtyRequired
            , @decQtyConfiguration
            , @strConfigurationType
            , 0 -- Not Started State
            , @intCreatedBy
            , GETDATE()
            , @dtePropStart
        )

        SELECT 1 AS [Status],
            'Success' AS [Message]
    END
    ELSE
    BEGIN
        SELECT 0 AS [Status],
            'You cannot create more than 1 job on this machine' AS [Message]
    END
END
GO