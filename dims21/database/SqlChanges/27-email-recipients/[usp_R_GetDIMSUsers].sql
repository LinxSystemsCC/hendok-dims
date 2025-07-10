USE [linxdbDIMSHendok]
GO

/****** Object:  StoredProcedure [dbo].[usp_R_GetDIMSUsers]    Script Date: 2025/07/10 10:29:37 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- Stored Procedure to fetch all users
CREATE PROCEDURE [dbo].[usp_R_GetDIMSUsers]
AS
BEGIN
    SET NOCOUNT ON;
    SELECT UserID, UserName, Email FROM tblDIMSUSERS;
END

GO


