-- Create the stored procedure in the specified schema
ALTER PROCEDURE dbo.usp_R_ProWeighData 
    @dateFrom DATE
    , @dateTo DATE
    -- add more stored procedure parameters here
AS
-- body of the stored procedure
    SELECT TICKET_NUMBER,
        TICKET_DATE,
        TICKET_TIME,
        WEIGHBRIDGE_NAME,
        REG_NUMBER,
        TRAILER1_REG_NUMBER,
        TRAILER2_REG_NUMBER,
        VEHICLE_CODE,
        AXLE_CODE,
        TRUCK_CAPACITY,
        TRUCK_TARE_WEIGHT,
        FIRST_WEIGHT,
        FIRST_WEIGH_DATETIME,
        FIRST_WEIGH_OPERATOR,
        SECOND_WEIGHT,
        SECOND_WEIGH_DATETIME,
        SECOND_WEIGH_OPERATOR
    FROM WB_Ticket_Trans
GO


