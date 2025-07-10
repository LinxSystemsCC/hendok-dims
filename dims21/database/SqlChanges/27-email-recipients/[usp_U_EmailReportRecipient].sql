USE [linxdbDIMSHendok]
GO

/****** Object:  StoredProcedure [dbo].[usp_U_EmailReportRecipient]    Script Date: 2025/07/10 10:31:49 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


-- Stored Procedure to update an existing recipient
CREATE PROCEDURE [dbo].[usp_U_EmailReportRecipient]
    @intAutoId INT,
    @strType NVARCHAR(100),
    @intUserId INT,
    @strEmail NVARCHAR(255)
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE tblEmailReportRecipients
    SET strType = @strType,
        intUserId = @intUserId,
        strEmail = @strEmail
    WHERE intAutoId = @intAutoId;
END

GO


