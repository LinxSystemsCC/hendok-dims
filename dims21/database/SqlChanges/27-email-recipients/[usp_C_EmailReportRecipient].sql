USE [linxdbDIMSHendok]
GO

/****** Object:  StoredProcedure [dbo].[usp_C_EmailReportRecipient]    Script Date: 2025/07/10 10:30:36 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- Stored Procedure to insert a new recipient
CREATE PROCEDURE [dbo].[usp_C_EmailReportRecipient]
    @strType NVARCHAR(100),
    @intUserId INT,
    @strEmail NVARCHAR(255)
AS
BEGIN
    SET NOCOUNT ON;
    INSERT INTO tblEmailReportRecipients (strType, intUserId, strEmail, dtmCreated)
    VALUES (@strType, @intUserId, @strEmail, GETDATE());
END

GO


