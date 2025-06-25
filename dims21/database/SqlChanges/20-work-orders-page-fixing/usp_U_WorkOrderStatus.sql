-- Create the stored procedure in the specified schema
CREATE PROCEDURE dbo.usp_U_WorkOrderStatus
    @intAutoId INT
    , @intStatusId INT
    , @intUserId INT
-- add more stored procedure parameters here
AS
    IF @intStatusId = 1
    BEGIN
        UPDATE tblWorkOrders 
        SET intStatusId = @intStatusId
            , intStartedBy = @intUserId
            , dtmStarted = GETDATE()
        
        SELECT 1 [Status], 'Job Started' [Message]
    END
    ELSE
    IF @intStatusId = 2
    BEGIN
        UPDATE tblWorkOrders 
        SET intStatusId = @intStatusId
            , intEndedBy = @intUserId
            , dtmEnded = GETDATE()
        
        SELECT 1 [Status], 'Job Ended' [Message]

    END
    ELSE
    BEGIN        
        UPDATE tblWorkOrders 
        SET intStatusId = @intStatusId
        SELECT 1 [Status], 'Job has been stopped' [Message]
    END
GO
