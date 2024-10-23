CREATE TABLE tblSystemModules (
    intAutoId BIGINT IDENTITY(1,1) PRIMARY KEY,
    strName NVARCHAR(50),
    intParentsId int NULL,
);


USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[GetSystemModulesListing]    Script Date: 23-10-2024 4:00:32 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[GetSystemModulesListing]
AS
BEGIN
    SET NOCOUNT ON;

    SELECT 
        sm.intAutoId,
        sm.strName,
        pm.strName AS ParentIdName
    FROM 
        dbo.tblSystemModules AS sm
    LEFT JOIN 
        dbo.tblSystemModules AS pm ON sm.intParentsId = pm.intAutoId
END


USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[SystemModules]    Script Date: 23-10-2024 4:01:18 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[SystemModules]
    @intAutoId AS int = NULL,
    @intParentsId AS int = NULL,
    @strName nvarchar(50),
    @StatementType VARCHAR(50)
AS
BEGIN
    IF @StatementType = 'add'
    BEGIN
        INSERT INTO tblSystemModules (strName, intParentsId)
        VALUES (@strName, @intParentsId);
    END
    ELSE IF @StatementType = 'update'
    BEGIN
        UPDATE tblSystemModules
        SET strName = @strName,
            intParentsId = @intParentsId  -- Corrected this line
        WHERE intAutoId = @intAutoId;
    END

    SELECT 'success' AS Result;
END;


USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[DeleteSystemModule]    Script Date: 23-10-2024 4:02:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[DeleteSystemModule]
    @IntAutoId INT
AS
BEGIN
    SET NOCOUNT ON;

    DELETE FROM tblSystemModules
    WHERE intAutoId = @IntAutoId;
END

USE [linxdbDIMSHendok]
GO

/****** Object:  Table [dbo].[tblSystemModules]    Script Date: 23-10-2024 5:58:45 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[tblSystemModules](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[strName] [nvarchar](50) NULL,
	[intParentsId] [int] NULL,
	[intUserId] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[intAutoId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
