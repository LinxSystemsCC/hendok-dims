-- Create the table in the specified schema
CREATE TABLE dbo.tblIBTHeaderTracking
(
    intAutoId INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    intIBTHeaderId INT NOT NULL,
    intTLNumber INT NOT NULL,
    dtmCreated DATETIME NOT NULL,
    intCreatedBy INT NOT NULL
);
GO