-- Create the stored procedure in the specified schema
CREATE OR ALTER PROCEDURE dbo.usp_U_ProWeighData
    @TICKET_NUMBER NVARCHAR(10)
    , @REG_NUMBER NVARCHAR(10)
    , @FIRST_WEIGHT DECIMAL(18,4)
-- add more stored procedure parameters here
AS
    -- body of the stored procedure
    UPDATE WB_Ticket_Trans 
    SET 
        REG_NUMBER = @REG_NUMBER
        , FIRST_WEIGHT = @FIRST_WEIGHT
    WHERE TICKET_NUMBER = @TICKET_NUMBER
GO