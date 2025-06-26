-- Create the stored procedure in the specified schema
ALTER PROCEDURE dbo.usp_U_WorkOrderStatus
    @intAutoId INT
    , @intStatusId INT
    , @intUserId INT
-- add more stored procedure parameters here
AS
    SET NOCOUNT ON;

    DECLARE @currentTime AS DATETIME = GETDATE();
    
    IF @intStatusId = 1
    BEGIN
        UPDATE tblWorkOrders 
        SET intStatusId = @intStatusId
            , intStartedBy = @intUserId
            , dtmStarted = @currentTime
        
        SELECT 1 [Status], 'Job Started' [Message], @currentTime [dtmStarted]
    END
    ELSE
    IF @intStatusId = 2
    BEGIN
        UPDATE tblWorkOrders 
        SET intStatusId = @intStatusId
            , intEndedBy = @intUserId
            , dtmEnded = @currentTime
        
        SELECT 1 [Status], 'Job Ended' [Message], @currentTime [dtmEnded]

    END
    ELSE
    BEGIN        
        UPDATE tblWorkOrders 
        SET intStatusId = @intStatusId
        SELECT 1 [Status], 'Job has been stopped' [Message]
    END
GO
