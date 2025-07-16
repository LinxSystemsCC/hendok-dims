USE [linxdbDIMSHendok]
GO

/****** Object:  StoredProcedure [dbo].[usp_R_GetEmailReportRecipients]    Script Date: 2025/07/10 10:26:26 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


-- Stored Procedure to fetch all recipients
CREATE PROCEDURE [dbo].[usp_R_GetEmailReportRecipients]
AS
BEGIN
    SET NOCOUNT ON;
    SELECT * FROM tblEmailReportRecipients;
END

GO


