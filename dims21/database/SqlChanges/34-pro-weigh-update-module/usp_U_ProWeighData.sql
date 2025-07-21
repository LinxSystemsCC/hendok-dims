CREATE OR ALTER PROCEDURE dbo.usp_U_ProWeighData 
    @TICKET_NUMBER NVARCHAR(10),
    @OLD_REG_NUMBER NVARCHAR(10),
    @OLD_FIRST_WEIGHT DECIMAL(18, 4),
    @OLD_TRUCK_TARE_WEIGHT DECIMAL(18, 4),
    @NEW_REG_NUMBER NVARCHAR(10),
    @NEW_FIRST_WEIGHT DECIMAL(18, 4),
    @NEW_TRUCK_TARE_WEIGHT DECIMAL(18, 4),
    @intUserId INT
AS
BEGIN
    SET NOCOUNT ON;

    BEGIN TRY
        BEGIN TRANSACTION;

        -- Log the adjustment
        INSERT INTO tblProWeighAdjustmentLogs (
            strTicket,
            strOldRegNumber,
            decOldFirstWeigh,
            decOldTruckTareWeight,
            strNewRegNumber,
            decNewFirstWeigh,
            decNewTruckTareWeight,
            intCreatedBy,
            dtmLogged
        )
        VALUES (
            @TICKET_NUMBER,
            @OLD_REG_NUMBER,
            @OLD_FIRST_WEIGHT,
            @OLD_TRUCK_TARE_WEIGHT,
            @NEW_REG_NUMBER,
            @NEW_FIRST_WEIGHT,
            @NEW_TRUCK_TARE_WEIGHT,
            @intUserId,
            GETDATE()
        );

        -- Update ticket info
        -- UPDATE WB_Ticket_Trans
        -- SET 
        --     REG_NUMBER = @NEW_REG_NUMBER,
        --     FIRST_WEIGHT = @NEW_FIRST_WEIGHT
        -- WHERE TICKET_NUMBER = @TICKET_NUMBER;

        COMMIT;

        SELECT 1 AS [Status], 'Successfully Changed Truck and First Weight' AS [Message];
    END TRY
    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK;

        -- Return error message
        SELECT 
            0 AS [Status],
            ERROR_MESSAGE() AS [Message];
    END CATCH
END
GO
