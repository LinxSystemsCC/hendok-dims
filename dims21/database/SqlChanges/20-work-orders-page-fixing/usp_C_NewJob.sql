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
GO