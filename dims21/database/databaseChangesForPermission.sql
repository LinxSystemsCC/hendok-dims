CREATE TABLE [dbo].[tblSystemModules] (
    [intAutoId] INT IDENTITY(1,1) PRIMARY KEY,
    [strName] nvarchar(50),
    [intParentId] INT,
    [strSlug] nvarchar(50),
    [created_at] datetime,
    [updated_at] datetime
);

CREATE TABLE [dbo].[tblUserPermissions] (
    [intAutoId] INT IDENTITY(1,1) PRIMARY KEY,
    [intSystemModuleId] INT,
    [intIsActive] INT,
    [intUserId] INT,
    [created_at] datetime,
    [updated_at] datetime
);

-- This sp is use for add new and update module details  for user permissions.

USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[sp_SystemModules]    Script Date: 11-11-2024 8:54:04 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_SystemModules]
    @intAutoId AS INT = NULL,
    @intParentId AS INT = NULL,
    @strName NVARCHAR(50),
    @strSlug VARCHAR(255),
    @StatementType VARCHAR(50)
AS
BEGIN
    SET NOCOUNT ON;

    IF @StatementType = 'add'
    BEGIN
        -- If @intAutoId is provided, we will use it, otherwise SQL Server will generate the value
        DECLARE @InsertedRows TABLE (intAutoId INT, strName NVARCHAR(50), intParentId INT, strSlug VARCHAR(255));

        IF @intAutoId IS NOT NULL
        BEGIN
            -- Temporarily allow explicit insert into the identity column
            SET IDENTITY_INSERT tblSystemModules ON;

            -- Insert with explicit intAutoId
            INSERT INTO tblSystemModules (intAutoId, strName, intParentId, strSlug)
            OUTPUT INSERTED.intAutoId, INSERTED.strName, INSERTED.intParentId, INSERTED.strSlug INTO @InsertedRows
            VALUES (@intAutoId, @strName, @intParentId, @strSlug);

            -- Turn off IDENTITY_INSERT to prevent future issues
            SET IDENTITY_INSERT tblSystemModules OFF;
        END
        ELSE
        BEGIN
            -- Insert without specifying intAutoId (let SQL Server auto-generate it)
            INSERT INTO tblSystemModules (strName, intParentId, strSlug)
            OUTPUT INSERTED.intAutoId, INSERTED.strName, INSERTED.intParentId, INSERTED.strSlug INTO @InsertedRows
            VALUES (@strName, @intParentId, @strSlug);
        END

        -- Return the inserted rows
        SELECT * FROM @InsertedRows;
    END
    ELSE IF @StatementType = 'update'
    BEGIN
        DECLARE @UpdatedRows TABLE (intAutoId INT, strName NVARCHAR(50), intParentId INT);

        -- Update existing row by intAutoId
        UPDATE tblSystemModules
        SET strName = @strName,
            intParentId = @intParentId
        OUTPUT INSERTED.intAutoId, INSERTED.strName, INSERTED.intParentId INTO @UpdatedRows
        WHERE intAutoId = @intAutoId;

        -- Return the updated rows
        SELECT * FROM @UpdatedRows;
    END
END;

-- This sp is use for get permissions list.

USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[sp_GetPermissionsList]    Script Date: 11-11-2024 8:58:02 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_GetPermissionsList]
    @ParentId INT,
    @UserId INT  -- New parameter for User ID
AS
BEGIN
    SET NOCOUNT ON;

    SELECT DISTINCT
        sm.intAutoId AS ID,
        sm.strName AS name,
        CASE 
            WHEN sp.intIsActive = 1 AND sp.intUserId = @UserId THEN 1
            ELSE 0
        END AS isChecked,
        sm.intParentId
    FROM 
        tblSystemModules AS sm
    LEFT JOIN
        tblUserPermissions AS sp ON sm.intAutoId = sp.intSystemModuleId AND sp.intUserId = @UserId
    WHERE 
        (@ParentId IS NULL AND sm.intParentId IS NULL) OR
        (sm.intParentId = @ParentId);
END

-- This sp is use for delete system module.

USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[sp_DeleteSystemModule]    Script Date: 07-11-2024 9:23:16 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_DeleteSystemModule]
    @IntAutoId INT
AS
BEGIN
    SET NOCOUNT ON;

    DELETE FROM tblSystemModules
    WHERE intAutoId = @IntAutoId;
END

-- This sp is use for insert user permissions if not exist tblSaveUserPermissions.

USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[sp_InsertUserPermissionsIfNotExist]    Script Date: 11-11-2024 9:00:49 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_InsertUserPermissionsIfNotExist]
    @UserId INT
AS
BEGIN
    -- Start of the procedure
    SET NOCOUNT ON;

    -- Step 1: Insert missing intNode values from tblSystemModules for the user
    -- This will insert any intAutoId values from tblSystemModules that are not already assigned to the user
    INSERT INTO tblUserPermissions (intSystemModuleId, intIsActive, intUserId)
    SELECT sm.intAutoId, 1, @UserId  -- Default intIsAllow is set to 1
    FROM tblSystemModules sm
    WHERE sm.intAutoId IS NOT NULL
    AND NOT EXISTS (
        SELECT 1
        FROM tblUserPermissions sp
        WHERE sp.intUserId = @UserId
        AND sp.intSystemModuleId = sm.intAutoId
    );

    -- Step 2: Update intNode in tblSaveUserPermissions for new intAutoId entries
    -- This step ensures that if new rows were inserted, their intNode values are properly updated.
   

    -- Optional: Message indicating the operation result
    PRINT 'Permissions inserted (if they did not already exist) and updated successfully.';
END;

-- This sp is use for update user permissions.

USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[sp_UpdateUserPermissions]    Script Date: 11-11-2024 9:03:17 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[sp_UpdateUserPermissions]
    @ChildIds VARCHAR(MAX),
    @ParentIds VARCHAR(MAX),
    @UserId INT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @ChildIdTable TABLE (ChildId INT);
    DECLARE @ParentIdTable TABLE (ParentId INT);

    INSERT INTO @ChildIdTable (ChildId)
    SELECT value FROM STRING_SPLIT(@ChildIds, ',');

    INSERT INTO @ParentIdTable (ParentId)
    SELECT value FROM STRING_SPLIT(@ParentIds, ',');


    UPDATE tblUserPermissions
    SET intIsActive = 1
    WHERE intSystemModuleId IN (SELECT ChildId FROM @ChildIdTable)
      AND intUserId = @UserId;

    UPDATE tblUserPermissions
    SET intIsActive = 1
    WHERE intSystemModuleId IN (SELECT ParentId FROM @ParentIdTable)
      AND intUserId = @UserId;

    UPDATE tblUserPermissions
    SET intIsActive = 0
    WHERE intUserId = @UserId
      AND intSystemModuleId NOT IN (SELECT ChildId FROM @ChildIdTable)
      AND intSystemModuleId NOT IN (SELECT ParentId FROM @ParentIdTable);

END

--This stored procedure is designed to retrieve the side menu items based on the permissions assigned to the user.

USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[sp_GetAllowedPermissionSystemModules]    Script Date: 11-11-2024 9:06:50 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[sp_GetAllowedPermissionSystemModules]
    @UserId INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT 
		sm.strSlug
    FROM
        tblSystemModules AS sm
    INNER JOIN
        tblUserPermissions AS sp
        ON sm.intAutoId = sp.intSystemModuleId
    WHERE 
        sp.intUserId = @UserId 
        AND sp.intIsActive = 1
END

--This sp is use for get system modules listing.

USE [linxdbDIMSHendok]
GO
/****** Object:  StoredProcedure [dbo].[sp_GetSystemModulesListing]    Script Date: 11-11-2024 9:08:35 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[sp_GetSystemModulesListing]
AS
BEGIN
    SET NOCOUNT ON;

    SELECT 
        sm.intAutoId,
        sm.strName,
        pm.strName AS ParentIdName,
        sm.strSlug
    FROM 
        dbo.tblSystemModules AS sm
    LEFT JOIN 
        dbo.tblSystemModules AS pm ON sm.intParentId = pm.intAutoId
    ORDER BY 
        sm.intAutoId DESC
END
