-- Rename the column
EXEC sp_rename 'tblStockIssueLines.mnyQty', 'decIssuedQty', 'COLUMN';

-- Alter the column to ensure it is of type DECIMAL(18,2)
ALTER TABLE tblStockIssueLines
ALTER COLUMN decIssuedQty DECIMAL(18,2);

ALTER TABLE tblStockIssueLines ADD intReqType BIGINT
ALTER TABLE tblStockIssueLines ADD decReturnedQtyOld DECIMAL(18,2)
ALTER TABLE tblStockIssueLines ADD decReturnedQtyNew DECIMAL(18,2)
ALTER TABLE tblStockIssueLines ADD intReason BIGINT


CREATE TABLE [dbo].[tblStockIssueRequestTypes](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[strType] [nvarchar](50) NULL,
	[dtmCreated] [datetime] NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[tblStockIssueRequestTypes] ADD  CONSTRAINT [PK_tblStockIssueRequestTypes] PRIMARY KEY CLUSTERED 
(
	[intAutoId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO


CREATE TABLE [dbo].[tblStockIssueTracking](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[intHeaderId] [bigint] NOT NULL,
	[intLineId] [bigint] NOT NULL,
	[intReturnedBy] [int] NOT NULL,
	[decReturnedQtyOld] [decimal](18, 2) NULL,
	[decReturnedQtyNew] [decimal](18, 2) NULL,
	[dtmReturned] [datetime] NOT NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[tblStockIssueTracking] ADD  CONSTRAINT [DEFAULT_tblStockIssueTracking_dtmReturned]  DEFAULT (getdate()) FOR [dtmReturned]
GO


CREATE TABLE [dbo].[tblStockIssueReasons](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[strReason] [nvarchar](100) NOT NULL,
	[dtmCreated] [datetime] NOT NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[tblStockIssueReasons] ADD  CONSTRAINT [DEFAULT_tblStockIssueReasons_dtmCreated]  DEFAULT (getdate()) FOR [dtmCreated]
GO


ALTER PROCEDURE [dbo].[usp_C_InsertStockIssue]
    @Reference AS NVARCHAR(50),
    @AssignedBy AS INT,
    @AssignedTo AS NVARCHAR(50),
    @Lines AS XML

AS
BEGIN
    DECLARE @HeaderID AS INT

    -- Temporary table to capture identities of inserted lines
    DECLARE @InsertedLines TABLE (
        intAutoID INT,
        intHeaderID INT,
        intType INT,
        strStockGroup NVARCHAR(50),
        strPastelCode NVARCHAR(50),
        decIssuedQty DECIMAL(18,2),
        strUpkeepJob NVARCHAR(50),
        strPastelProjectJob NVARCHAR(50),
        intArea INT,
        intDept INT,
        intSubDept INT,
        intMachine INT,
        intReqType BIGINT,
        decReturnedQtyOld DECIMAL(18,2),
        decReturnedQtyNew DECIMAL(18,2),
        intReason BIGINT
    )

    -- Body of the stored procedure
    BEGIN TRY 
        BEGIN TRANSACTION

        -- Insert into tblStockIssueHeader and get the generated HeaderID
        INSERT INTO tblStockIssueHeader (strReference, intAssignedBy, strEmployeeNo)
        VALUES (@Reference, @AssignedBy, @AssignedTo)

        SELECT @HeaderID = @@IDENTITY

        -- Parse XML data into a temporary table
        SELECT 
            @HeaderID AS intHeaderID,
            x.result.value('(strPastelCode)[1]', 'NVARCHAR(50)') AS strPastelCode,
            x.result.value('(intType)[1]', 'INT') AS intType,
            x.result.value('(intReqType)[1]', 'BIGINT') AS intReqType,
            x.result.value('(strUpkeep)[1]', 'NVARCHAR(50)') AS strUpkeepJob,
            x.result.value('(strPastelProjectJob)[1]', 'NVARCHAR(50)') AS strPastelProjectJob,
            x.result.value('(decIssuedQty)[1]', 'DECIMAL(18,2)') AS decIssuedQty,
            x.result.value('(decReturnedOld)[1]', 'DECIMAL(18,2)') AS decReturnedQtyOld,
            x.result.value('(decReturnedNew)[1]', 'DECIMAL(18,2)') AS decReturnedQtyNew,
            x.result.value('(intReason)[1]', 'BIGINT') AS intReason,
            x.result.value('(intArea)[1]', 'INT') AS intArea,
            x.result.value('(intDept)[1]', 'INT') AS intDept,
            x.result.value('(intSubDept)[1]', 'INT') AS intSubDept,
            x.result.value('(intMachine)[1]', 'INT') AS intMachine,
            x.result.value('(strStockGroup)[1]', 'NVARCHAR(50)') AS strStockGroup
        INTO #tempLines
        FROM @Lines.nodes('/xml/result') AS x(result);

        -- Insert data from #tempLines into tblStockIssueLines and capture inserted identities
        INSERT INTO tblStockIssueLines (
            intHeaderID, 
            intType, 
            strStockGroup, 
            strPastelCode, 
            decIssuedQty, 
            strUpkeepJob, 
            strPastelProjectJob, 
            intArea, 
            intDept, 
            intSubDept, 
            intMachine, 
            intReqType, 
            decReturnedQtyOld, 
            decReturnedQtyNew,
            intReason
        )
        OUTPUT 
            INSERTED.intAutoID,
            INSERTED.intHeaderID,
            INSERTED.intType,
            INSERTED.strStockGroup,
            INSERTED.strPastelCode,
            INSERTED.decIssuedQty,
            INSERTED.strUpkeepJob,
            INSERTED.strPastelProjectJob,
            INSERTED.intArea,
            INSERTED.intDept,
            INSERTED.intSubDept,
            INSERTED.intMachine,
            INSERTED.intReqType,
            INSERTED.decReturnedQtyOld,
            INSERTED.decReturnedQtyNew,
            INSERTED.intReason
        INTO @InsertedLines
        SELECT 
            intHeaderID, 
            intType, 
            strStockGroup, 
            strPastelCode, 
            decIssuedQty, 
            strUpkeepJob, 
            strPastelProjectJob, 
            intArea, 
            intDept, 
            intSubDept, 
            intMachine, 
            intReqType, 
            decReturnedQtyOld, 
            decReturnedQtyNew,
            intReason
        FROM #tempLines;

        -- Insert data into tblStockIssueTracking using captured identities
        INSERT INTO tblStockIssueTracking (
            intHeaderId, 
            intLineId, 
            intReturnedBy, 
            decReturnedQtyOld, 
            decReturnedQtyNew
        )
        SELECT 
            intHeaderID, 
            intAutoID, 
            @AssignedBy, 
            decReturnedQtyOld, 
            decReturnedQtyNew
        FROM @InsertedLines;

        -- Clean up the temporary table
        DROP TABLE #tempLines;

        -- Return success message
        SELECT 'Success' AS Result;

        COMMIT 
    END TRY 

    BEGIN CATCH 
        -- Rollback transaction on error
        IF @@TRANCOUNT > 0 
            ROLLBACK 

        -- Return error message
        SELECT ERROR_MESSAGE() AS Result;
    END CATCH 
END
GO


CREATE PROCEDURE [dbo].[usp_CU_IssueStockRecieve]
    -- ADD PARAMETERS
    @intHeaderId BIGINT
    , @intLineId BIGINT
    , @oldQtyReturned DECIMAL
    , @newQtyReturned DECIMAL
    , @UserId BIGINT
AS
BEGIN
    SET NOCOUNT ON;

    BEGIN TRY
        BEGIN TRANSACTION

        -- body of the stored procedure
        UPDATE tblStockIssueLines
        SET decReturnedQtyOld = decReturnedQtyOld + ISNULL(@oldQtyReturned, 0)
            , decReturnedQtyNew = decReturnedQtyNew + ISNULL(@newQtyReturned, 0)

        SELECT 'Success' AS Result

        INSERT INTO tblStockIssueTracking (
            intHeaderId
            , intLineId
            , intReturnedBy
            , decReturnedQtyOld
            , decReturnedQtyNew
            )
        VALUES (
            @intHeaderId
            , @intLineId
            , @UserId
            , @oldQtyReturned
            , @newQtyReturned
            )

        COMMIT
    END TRY

    BEGIN CATCH
        -- Rollback transaction on error
        IF @@TRANCOUNT > 0
            ROLLBACK

        -- Return error message
        SELECT ERROR_MESSAGE() AS Result;
    END CATCH
END
GO


ALTER VIEW [dbo].[viewIssuedStock] AS
    SELECT sih.intAutoId intHeaderId
        , sil.intAutoId intLineId
        , sih.dteCreated
        , sih.strReference
        , sil.intType
        , sil.intReqType
        , sit.strIssueType
        , sih.strEmployeeNo strIssuedTo
        , sil.strUpkeepJob
        , sil.strPastelProjectJob
        , sil.strPastelCode
        , stk.Description_1 AS strPastelDescription
        , sil.strStockGroup
        , sil.decIssuedQty
        , (sil.decIssuedQty * sc.AverageCost) AS fltTotalAvgCost
        , sil.intArea
        , a.strAreaName
        , sil.intDept
        , d.strDeptName
        , sil.intSubDept
        , sd.strSubDeptName
        , sil.intMachine
        , m.strMachineName
        , sil.intReason
        , sil.decReturnedQtyOld decReturnedOld
        , sil.decReturnedQtyNew decReturnedNew
    FROM tblStockIssueHeader sih
    INNER JOIN tblStockIssueLines sil
        ON sil.intHeaderID = sih.intAutoId
    LEFT OUTER JOIN tblStockIssueTypes sit
        ON sit.intAutoID = sil.intType
    LEFT OUTER JOIN tblStockIssueRequestTypes sirt
        ON sirt.intAutoId = sil.intReqType
    LEFT OUTER JOIN tblDIMSUSERS du
        ON du.UserID = sih.intAssignedBy
    INNER JOIN [Hendok Distribution].dbo._bvStockFull stk
        ON stk.Code = sil.strPastelCode COLLATE DATABASE_DEFAULT
    LEFT OUTER JOIN [Hendok Distribution].dbo._etblStockCosts sc
        ON sc.StockID = stk.StockID
    LEFT OUTER JOIN tblAreas a
        ON a.intAutoID = sil.intArea
    LEFT OUTER JOIN tblDepartments d
        ON d.intAutoID = sil.intDept
    LEFT OUTER JOIN tblSubDepartments sd
        ON sd.intAutoID = sil.intSubDept
    LEFT OUTER JOIN tblMachines m
        ON m.intAutoMachineID = sil.intMachine
GO

ALTER VIEW [dbo].[viewStockIssue] AS
    SELECT whs.Code AS strPastelCode
        , s.Description_1 AS strPastelDescription
        , s.ItemGroup AS strStockGroup
        , s.ItemGroupDescription AS strStockGroupDesc
        , ISNULL(s.QtyOnHand, 0) AS decQtyOnHand
        , s.MinLevel AS intMinLevel
        , s.MaxLevel AS intMaxLevel
        , sc.AverageCost fltAvgCost
    FROM [Hendok Distribution].dbo._bvWarehouseStockFull whs
    INNER JOIN [Hendok Distribution].dbo._bvStockFull s
        ON s.Code = whs.Code
    LEFT OUTER JOIN [Hendok Distribution].dbo._etblStockCosts sc
        ON sc.StockID = s.StockID
    WHERE whs.WhCode = 'MRO';
GO