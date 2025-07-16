CREATE TABLE tblProWeighAdjustmentLogs (
    intAutoId INT IDENTITY(1,1) PRIMARY KEY,
    strTicket NVARCHAR(50) NOT NULL,
    strOldRegNumber NVARCHAR(50),
    decOldFirstWeigh DECIMAL(18,2),
    decOldTruckTareWeight DECIMAL(18,2),
    strNewRegNumber NVARCHAR(50),
    decNewFirstWeigh DECIMAL(18,2),
    decNewTruckTareWeight DECIMAL(18,2),
    intCreatedBy INT NOT NULL,
    dtmLogged DATETIME NOT NULL DEFAULT GETDATE()
);