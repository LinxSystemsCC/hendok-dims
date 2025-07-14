SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[spRoofingPlannedLines]
    -- Add the parameters for the stored procedure here
    @intRoofingHeader AS BIGINT
AS
BEGIN
    -- SET NOCOUNT ON added to prevent extra result sets from
    -- interfering with SELECT statements.
    SET NOCOUNT ON;

    -- Insert statements for procedure here
    SELECT r.intRoofingHeader
        , r.strSONum
        , r.intOrderLineID
        , rh.strReference
        , l.StoreName
        , l.Code
        , stk.Description_1 ItemName
        , r.intMachineId
        , m.strMachineName
        , r.decQtyOrdered
        , r.intConfiguration
        , r.intQty
        , intRoofSOID UniqueID
        , r.intSequence
    FROM tblRoofingSONumToPlan r
    INNER JOIN viewOrderlinesForPickingWithReferences l
        ON r.intOrderLineId = l.OrderDetailId
    INNER JOIN tblRoofingHeaderInfo rh
        ON rh.intRoofingHeader = r.intRoofingHeader
    LEFT OUTER JOIN tblMachines m
        ON m.intAutoMachineID = r.intMachineId
    INNER JOIN tblSageFullStock stk
        ON stk.Code COLLATE DATABASE_DEFAULT = l.Code
    WHERE r.intRoofingHeader = @intRoofingHeader
    ORDER BY intSequence
END
GO
