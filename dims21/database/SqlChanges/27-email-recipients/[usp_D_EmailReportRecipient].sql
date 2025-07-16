USE [linxdbDIMSHendok]
GO

/****** Object:  StoredProcedure [dbo].[usp_D_EmailReportRecipient]    Script Date: 2025/07/10 10:32:31 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- Stored Procedure to delete a recipient
CREATE PROCEDURE [dbo].[usp_D_EmailReportRecipient]
    @intAutoId INT
AS
BEGIN
    SET NOCOUNT ON;
    DELETE FROM tblEmailReportRecipients WHERE intAutoId = @intAutoId;
END

GO


