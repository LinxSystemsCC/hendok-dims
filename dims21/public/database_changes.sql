CREATE TABLE tblIBTHeader (
    intAutoId BIGINT IDENTITY(1,1) PRIMARY KEY,
    strReference NVARCHAR(50) NULL,
    dtmCreated DATE NULL,
    intCreatedBy BIGINT DEFAULT 0,
    intStatus INT NULL
);


CREATE TABLE tblIBTLines (
    intAutoId BIGINT IDENTITY(1,1) PRIMARY KEY,
    intAutoHeaderId BIGINT NOT NULL,
    strPartNumber NVARCHAR(50) NOT NULL,
    fltWeight FLOAT NULL,
    mnyQty MONEY NULL,
    strComment NVARCHAR(250) NULL,

    -- Foreign key constraint (optional, if needed)
    CONSTRAINT FK_tblIBTLines_tblIBTHeader FOREIGN KEY (intAutoHeaderId)
    REFERENCES tblIBTHeader(intAutoId)
);


CREATE PROCEDURE [dbo].[spCreateIBT]
    @reference NVARCHAR(50),
    @date DATETIME,
    @userID BIGINT,
    @intStatus INT = 0,
    @xmlLines XML
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @identityInsertHeader BIGINT;

    -- Create temporary table for product data
    CREATE TABLE #tempProductDataDump (
        pastelcode NVARCHAR(50),
        pasteldesc NVARCHAR(255),
        qty FLOAT,
        [weight] FLOAT,
        comment NVARCHAR(255)
    );

    -- Insert product data from XML into the temporary table
    INSERT INTO #tempProductDataDump (pastelcode, pasteldesc, qty, [weight], comment)
    SELECT
        result.value('PastelCode[1]', 'nvarchar(50)'),
        result.value('PastelDescription[1]', 'nvarchar(255)'),
        result.value('Qty[1]', 'float'),
        result.value('Weight[1]', 'float'),
        result.value('Comment[1]', 'nvarchar(255)')
    FROM @xmlLines.nodes('/xml/result') AS results(result);

    -- Insert into tblIBTHeader
    INSERT INTO tblIBTHeader (
        strReference,
        dtmCreated,
        intCreatedBy,
        intStatus
    )
    VALUES (
        @reference,
        @date,
        @userID,
        @intStatus
    );

    SET @identityInsertHeader = SCOPE_IDENTITY();

    -- Insert into tblIBTLines from the temporary product data
    INSERT INTO tblIBTLines (
        intAutoHeaderId,
        strPartNumber,
        fltWeight,
        mnyQty,
        strComment
    )
    SELECT
        @identityInsertHeader,
        pastelcode,
        [weight],
        qty,
        comment
    FROM #tempProductDataDump;

    -- Return the created header identity
    SELECT @identityInsertHeader AS intAutoHeaderId;

    -- Clean up temporary table
    DROP TABLE #tempProductDataDump;
END


CREATE PROCEDURE [dbo].[spUpdateIBT]
    @SelectedIbtHeaderId BIGINT,
    @reference NVARCHAR(50),
    @date DATE,
    @userID BIGINT,
    @intStatus INT = 0,
    @xmlLines XML
AS
BEGIN
    SET NOCOUNT ON;

    -- Update tblIBTHeader
    UPDATE tblIBTHeader
    SET
        strReference = @reference,
        dtmCreated = @date,
        intCreatedBy = @userID,
        intStatus = @intStatus
    WHERE
        intAutoId = @SelectedIbtHeaderId;

    -- Temporary table for product data
    IF OBJECT_ID(N'tempdb..#tempProductDataDump') IS NOT NULL
    BEGIN
        DROP TABLE #tempProductDataDump;
    END

    CREATE TABLE #tempProductDataDump (
        pastelcode NVARCHAR(50),
        pasteldesc NVARCHAR(255),
        qty FLOAT,
        [weight] FLOAT,
        comment NVARCHAR(255)
    );

    -- Insert product data from XML into the temporary table
    INSERT INTO #tempProductDataDump (pastelcode, pasteldesc, qty, [weight], comment)
    SELECT
        result.value('PastelCode[1]', 'nvarchar(50)'),
        result.value('PastelDescription[1]', 'nvarchar(255)'),
        result.value('Qty[1]', 'float'),
        result.value('Weight[1]', 'float'),
        result.value('Comment[1]', 'nvarchar(255)')
    FROM @xmlLines.nodes('/xml/result') AS results(result);

    -- Delete existing lines for the selected header
    DELETE FROM tblIBTLines
    WHERE intAutoHeaderId = @SelectedIbtHeaderId;

    -- Insert new product data into tblIBTLines
    INSERT INTO tblIBTLines (
        intAutoHeaderId,
        strPartNumber,
        fltWeight,
        mnyQty,
        strComment
    )
    SELECT
        @SelectedIbtHeaderId,
        pastelcode,
        [weight],
        qty,
        comment
    FROM #tempProductDataDump;

    -- Clean up temporary table
    DROP TABLE #tempProductDataDump;
	SELECT @SelectedIbtHeaderId AS intAutoId
END

CREATE PROCEDURE [dbo].[spGetIBTDetails]
    @ibtnumber INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT
        intAutoId,
        intAutoHeaderId,
        strPartNumber AS PastelCode,
        fltWeight AS Weight,
        mnyQty AS Qty,
        strComment AS Comment,
        PastelDescription
    FROM
        tblIBTLines
    INNER JOIN
        viewTblProductWeightedCalc
        ON tblIBTLines.strPartNumber COLLATE SQL_Latin1_General_CP1_CI_AS = viewTblProductWeightedCalc.PastelCode
    WHERE
        intAutoHeaderId = @ibtnumber;
END



CREATE view [dbo].[viewtblIBTHeadersData] as
select
	intAutoId,
	strReference,
	dtmCreated,
	du.UserName as [Username],
	CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN 'Open'
        WHEN intStatus = 2 THEN 'Complete'
        ELSE ''
    END AS strStatus
from tblIBTHeader as head
inner join tblDIMSUSERS du on du.UserID = head.intCreatedBy


--============Updated the View viewTblProductWeightedCalc=============
ALTER view [dbo].[viewTblProductWeightedCalc] as (
	select  Code [PastelCode],Description_1 as [PastelDescription], ISNULL(ufIIWeight,1) as [Weight],mnySumAvail as [qtyavl] from [Hendok Distribution].dbo._bvStockFull
	Left JOIN tblInventory ON Code COLLATE SQL_Latin1_General_CP1_CI_AS = tblInventory.strPartNumber
)

--===========IBT NEW CHANGES(DATE - 20-11-2024(D-M-Y)))============

ALTER TABLE tblIBTHeader
ADD
    intFromDC INT NULL,
    intToDC INT NULL,
    intGIT INT NULL,
    strTlNumber NVARCHAR(100) NULL,
    intVariance INT NULL;


ALTER TABLE tblIBTLines
ADD
    mnyQtyReceived int,
    mnyQtyVariance int;



ALTER PROCEDURE [dbo].[spCreateIBT]
    @reference NVARCHAR(50),
    @date DATETIME,
    @userID BIGINT,
    @intStatus INT = 0,
	@intFromDC INT,
	@intToDC INT,
	@intGIT INT,
	@intVariance INT,
    @xmlLines XML
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @identityInsertHeader BIGINT;

    -- Create temporary table for product data
    CREATE TABLE #tempProductDataDump (
        pastelcode NVARCHAR(50),
        pasteldesc NVARCHAR(255),
        qty FLOAT,
        [weight] FLOAT,
        comment NVARCHAR(255)
    );

    -- Insert product data from XML into the temporary table
    INSERT INTO #tempProductDataDump (pastelcode, pasteldesc, qty, [weight], comment)
    SELECT
        result.value('PastelCode[1]', 'nvarchar(50)'),
        result.value('PastelDescription[1]', 'nvarchar(255)'),
        result.value('Qty[1]', 'float'),
        result.value('Weight[1]', 'float'),
        result.value('Comment[1]', 'nvarchar(255)')
    FROM @xmlLines.nodes('/xml/result') AS results(result);

    -- Insert into tblIBTHeader
    INSERT INTO tblIBTHeader (
        strReference,
        dtmCreated,
        intCreatedBy,
        intStatus,
		intFromDC,
		intToDC,
		intGIT,
		intVariance
    )
    VALUES (
        @reference,
        @date,
        @userID,
        @intStatus,
		@intFromDC,
		@intToDC,
		@intGIT,
		@intVariance
    );

    SET @identityInsertHeader = SCOPE_IDENTITY();

    -- Insert into tblIBTLines from the temporary product data
    INSERT INTO tblIBTLines (
        intAutoHeaderId,
        strPartNumber,
        fltWeight,
        mnyQty,
        strComment
    )
    SELECT
        @identityInsertHeader,
        pastelcode,
        [weight],
        qty,
        comment
    FROM #tempProductDataDump;

    -- Return the created header identity
	SELECT 'Success' AS Result
    SELECT @identityInsertHeader AS intAutoHeaderId;

    -- Clean up temporary table
    DROP TABLE #tempProductDataDump;
END



ALTER PROCEDURE [dbo].[spUpdateIBT]
    @SelectedIbtHeaderId BIGINT,
    @reference NVARCHAR(50),
    @date DATE,
    @userID BIGINT,
    @intStatus INT = 0,
	@strTlNumber varchar(255) null,
	@intFromDC INT null,
	@intToDC INT null,
	@intGIT INT null,
	@intVariance INT null,
    @xmlLines XML
AS
BEGIN
    SET NOCOUNT ON;

    -- Update tblIBTHeader
    UPDATE tblIBTHeader
    SET
        strReference = @reference,
        dtmCreated = @date,
        intCreatedBy = @userID,
        intStatus = @intStatus,
		strTlNumber = @strTlNumber,
		intFromDC = @intFromDC,
		intToDC = @intToDC,
		intGIT = @intGIT,
		intVariance = @intVariance
    WHERE
        intAutoId = @SelectedIbtHeaderId;

    -- Temporary table for product data
    IF OBJECT_ID(N'tempdb..#tempProductDataDump') IS NOT NULL
    BEGIN
        DROP TABLE #tempProductDataDump;
    END

    CREATE TABLE #tempProductDataDump (
        pastelcode NVARCHAR(50),
        pasteldesc NVARCHAR(255),
        qty FLOAT,
        [weight] FLOAT,
        comment NVARCHAR(255),
    );

    -- Insert product data from XML into the temporary table
    INSERT INTO #tempProductDataDump (pastelcode, pasteldesc, qty, [weight], comment)
    SELECT
        result.value('PastelCode[1]', 'nvarchar(50)'),
        result.value('PastelDescription[1]', 'nvarchar(255)'),
        result.value('Qty[1]', 'float'),
        result.value('Weight[1]', 'float'),
        result.value('Comment[1]', 'nvarchar(255)')
    FROM @xmlLines.nodes('/xml/result') AS results(result);

    -- Delete existing lines for the selected header
    DELETE FROM tblIBTLines
    WHERE intAutoHeaderId = @SelectedIbtHeaderId;

    -- Insert new product data into tblIBTLines
    INSERT INTO tblIBTLines (
        intAutoHeaderId,
        strPartNumber,
        fltWeight,
        mnyQty,
        strComment
    )
    SELECT
        @SelectedIbtHeaderId,
        pastelcode,
        [weight],
        qty,
        comment
    FROM #tempProductDataDump;

    -- Clean up temporary table
    DROP TABLE #tempProductDataDump;
	SELECT @SelectedIbtHeaderId AS intAutoId

	-- Return the created header identity
	SELECT 'Success' AS Result
END


ALTER PROCEDURE [dbo].[spGetIBTDetails]
    @ibtnumber INT
AS
BEGIN
    SET NOCOUNT ON;

    SELECT intAutoId, intAutoHeaderId, strPartNumber as PastelCode, fltWeight as Weight, mnyQty as Qty, strComment as Comment, PastelDescription,mnyQtyVariance,mnyQtyReceived
    FROM tblIBTLines
    INNER JOIN viewTblProductWeightedCalc
        ON tblIBTLines.strPartNumber COLLATE SQL_Latin1_General_CP1_CI_AS = viewTblProductWeightedCalc.PastelCode
    WHERE intAutoHeaderId = @ibtnumber;
END


ALTER VIEW [dbo].[viewtblIBTHeadersData] AS
SELECT
    head.intAutoId,
    strReference,
    intFromDC,
    intToDC,
    intGIT,
    intVariance,
    head.dtmCreated,
    du.UserName AS [Username],
    ln.strLocationName,
    ln2.strLocationName As gitstrLocationName,
    dc.strDCName,
    dc2.strDCName AS toDCName,
	head.strTlNumber,
    CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN 'Planned'
        WHEN intStatus = 2 THEN 'Issued'
        WHEN intStatus = 3 THEN 'Received'
        ELSE ''
    END AS strStatus
FROM tblIBTHeader AS head
INNER JOIN tblDIMSUSERS du ON du.UserID = head.intCreatedBy
LEFT JOIN tblLocationNames ln ON head.intVariance = ln.intLocationNameId
LEFT JOIN tblLocationNames ln2 ON head.intGIT = ln2.intLocationNameId
LEFT JOIN tblDCNames dc ON dc.intAutoId = head.intFromDC
LEFT JOIN tblDCNames dc2 ON dc2.intAutoId = head.intToDC
GO


--===========IBT NEW CHANGES(DATE - 26-11-2024(D-M-Y)))============
ALTER TABLE tblIBTHeader
ADD
    intReceivingBin INT NULL;


ALTER VIEW [dbo].[viewtblIBTHeadersData] AS
SELECT
    head.intAutoId,
    strReference,
    intFromDC,
    intToDC,
    intGIT,
    intVariance,
    head.dtmCreated,
    du.UserName AS [Username],
    ln.strBin As varianceBinName,
    ln2.strBin As gitBinName,
    dc.strDCName,
    dc2.strDCName AS toDCName,
	head.strTlNumber,
	head.intReceivingBin,
    CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN 'Planned'
        WHEN intStatus = 2 THEN 'Issued'
        WHEN intStatus = 3 THEN 'Received'
        ELSE ''
    END AS strStatus
FROM tblIBTHeader AS head
INNER JOIN tblDIMSUSERS du ON du.UserID = head.intCreatedBy
LEFT JOIN viewBinNames ln ON head.intVariance = ln.intBinId
LEFT JOIN viewBinNames ln2 ON head.intGIT = ln2.intBinId
LEFT JOIN tblDCNames dc ON dc.intAutoId = head.intFromDC
LEFT JOIN tblDCNames dc2 ON dc2.intAutoId = head.intToDC
GO


--===========IBT NEW CHANGES(DATE - 27-11-2024(D-M-Y)))============
EXEC sp_rename 'tblIBTHeader.strTLNumber', 'intTLNumber', 'COLUMN';

ALTER TABLE tblIBTHeader
ALTER COLUMN intTLNumber BIGINT;

ALTER PROCEDURE [dbo].[spUpdateIBT]
    @SelectedIbtHeaderId BIGINT,
    @reference NVARCHAR(50),
    @date DATE,
    @userID BIGINT,
    @intStatus INT = 0,
	@intTLNumber varchar(255) null,
	@intFromDC INT null,
	@intToDC INT null,
	@intGIT INT null,
	@intVariance INT null,
    @xmlLines XML
AS
BEGIN
    SET NOCOUNT ON;

    -- Update tblIBTHeader
    UPDATE tblIBTHeader
    SET
        strReference = @reference,
        dtmCreated = @date,
        intCreatedBy = @userID,
        intStatus = @intStatus,
		intTLNumber = @intTLNumber,
		intFromDC = @intFromDC,
		intToDC = @intToDC,
		intGIT = @intGIT,
		intVariance = @intVariance
    WHERE
        intAutoId = @SelectedIbtHeaderId;

    -- Temporary table for product data
    IF OBJECT_ID(N'tempdb..#tempProductDataDump') IS NOT NULL
    BEGIN
        DROP TABLE #tempProductDataDump;
    END

    CREATE TABLE #tempProductDataDump (
        pastelcode NVARCHAR(50),
        pasteldesc NVARCHAR(255),
        qty FLOAT,
        [weight] FLOAT,
        comment NVARCHAR(255),
    );

    -- Insert product data from XML into the temporary table
    INSERT INTO #tempProductDataDump (pastelcode, pasteldesc, qty, [weight], comment)
    SELECT
        result.value('PastelCode[1]', 'nvarchar(50)'),
        result.value('PastelDescription[1]', 'nvarchar(255)'),
        result.value('Qty[1]', 'float'),
        result.value('Weight[1]', 'float'),
        result.value('Comment[1]', 'nvarchar(255)')
    FROM @xmlLines.nodes('/xml/result') AS results(result);

    -- Delete existing lines for the selected header
    DELETE FROM tblIBTLines
    WHERE intAutoHeaderId = @SelectedIbtHeaderId;

    -- Insert new product data into tblIBTLines
    INSERT INTO tblIBTLines (
        intAutoHeaderId,
        strPartNumber,
        fltWeight,
        mnyQty,
        strComment
    )
    SELECT
        @SelectedIbtHeaderId,
        pastelcode,
        [weight],
        qty,
        comment
    FROM #tempProductDataDump;

    -- Clean up temporary table
    DROP TABLE #tempProductDataDump;
	SELECT @SelectedIbtHeaderId AS intAutoId

	-- Return the created header identity
	SELECT 'Success' AS Result
END
GO


ALTER VIEW [dbo].[viewtblIBTHeadersData] AS
SELECT
    head.intAutoId,
    strReference,
    intFromDC,
    intToDC,
    intGIT,
    intVariance,
    head.dtmCreated,
    du.UserName AS [Username],
    ln.strBin As varianceBinName,
    ln2.strBin As gitBinName,
    dc.strDCName,
    dc2.strDCName AS toDCName,
	'TL' + CAST(head.intTLnumber AS NVARCHAR(10)) strTlNumber,
	head.intReceivingBin,
    CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN 'Planned'
        WHEN intStatus = 2 THEN 'Issued'
        WHEN intStatus = 3 THEN 'Received'
        ELSE ''
    END AS strStatus
FROM tblIBTHeader AS head
INNER JOIN tblDIMSUSERS du ON du.UserID = head.intCreatedBy
LEFT JOIN viewBinNames ln ON head.intVariance = ln.intBinId
LEFT JOIN viewBinNames ln2 ON head.intGIT = ln2.intBinId
LEFT JOIN tblDCNames dc ON dc.intAutoId = head.intFromDC
LEFT JOIN tblDCNames dc2 ON dc2.intAutoId = head.intToDC
GO


--===========IBT NEW CHANGES(DATE - 28-11-2024(D-M-Y)))============
ALTER TABLE tblIBTHeader
ADD
    dtmReceived DATETIME NULL,
    intReceivedBy BIGINT NULL;

ALTER TABLE tblIBTHeader
ALTER COLUMN dtmCreated DATETIME;

ALTER VIEW [dbo].[viewtblIBTHeadersData] AS
SELECT
    head.intAutoId,
    strReference,
    intFromDC,
    intToDC,
    intGIT,
    intVariance,
    head.dtmCreated,
    du.UserName AS IssuedBy,
	head.dtmReceived,
	ru.UserName AS ReceivedBy,
    ln.strBin As varianceBinName,
    ln2.strBin As gitBinName,
    dc.strDCName,
    dc2.strDCName AS toDCName,
	'TL' + CAST(head.intTLnumber AS NVARCHAR(10)) strTlNumber,
	head.intReceivingBin,
    CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN 'Planned'
        WHEN intStatus = 2 THEN 'Issued'
        WHEN intStatus = 3 THEN 'Received'
        ELSE ''
    END AS strStatus
FROM tblIBTHeader AS head
INNER JOIN tblDIMSUSERS du ON du.UserID = head.intCreatedBy
LEFT JOIN tblDIMSUSERS ru ON ru.UserID = head.intReceivedBy
LEFT JOIN viewBinNames ln ON head.intVariance = ln.intBinId
LEFT JOIN viewBinNames ln2 ON head.intGIT = ln2.intBinId
LEFT JOIN tblDCNames dc ON dc.intAutoId = head.intFromDC
LEFT JOIN tblDCNames dc2 ON dc2.intAutoId = head.intToDC
GO

--===========IBT NEW CHANGES(DATE - 05-12-2024(D-M-Y)))============
ALTER TABLE tblIBTHeader
    ADD intAutoRecieveId BIGINT NULL;

ALTER VIEW [dbo].[viewtblIBTHeadersData] AS
SELECT
    head.intAutoId,
    strReference,
    intFromDC,
    intToDC,
    intGIT,
    intVariance,
    head.dtmCreated,
    du.UserName AS IssuedBy,
    ISNULL(head.intAutoRecieveId, '-') intAutoRecieveId,
	head.dtmReceived,
	ru.UserName AS ReceivedBy,
    ln.strBin As varianceBinName,
    ln2.strBin As gitBinName,
    dc.strDCName,
    dc2.strDCName AS toDCName,
	'TL' + CAST(head.intTLnumber AS NVARCHAR(10)) strTlNumber,
	head.intReceivingBin,
    CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN 'Planned'
        WHEN intStatus = 2 THEN 'Issued'
        WHEN intStatus = 3 THEN 'Received'
        ELSE ''
    END AS strStatus
FROM tblIBTHeader AS head
INNER JOIN tblDIMSUSERS du ON du.UserID = head.intCreatedBy
LEFT JOIN tblDIMSUSERS ru ON ru.UserID = head.intReceivedBy
LEFT JOIN viewBinNames ln ON head.intVariance = ln.intBinId
LEFT JOIN viewBinNames ln2 ON head.intGIT = ln2.intBinId
LEFT JOIN tblDCNames dc ON dc.intAutoId = head.intFromDC
LEFT JOIN tblDCNames dc2 ON dc2.intAutoId = head.intToDC
GO

--===========IBT NEW CHANGES(DATE - 09-12-2024(D-M-Y)))============
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER VIEW [dbo].[viewtblIBTHeadersData] AS
SELECT
    head.intAutoId,
    strReference,
    intFromDC,
    intToDC,
    intGIT,
    intVariance,
    head.dtmCreated,
    du.UserName AS IssuedBy,
    head.intAutoRecieveId,
	head.dtmReceived,
	ru.UserName AS ReceivedBy,
    ln.strBin As varianceBinName,
    ln2.strBin As gitBinName,
    dc.strDCName,
    dc2.strDCName AS toDCName,
	'TL' + CAST(head.intTLnumber AS NVARCHAR(10)) strTlNumber,
	head.intReceivingBin,
    CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN 'Planned'
        WHEN intStatus = 2 THEN 'Issued'
        WHEN intStatus = 3 THEN 'Received'
        ELSE ''
    END AS strStatus
FROM tblIBTHeader AS head
INNER JOIN tblDIMSUSERS du ON du.UserID = head.intCreatedBy
LEFT JOIN tblDIMSUSERS ru ON ru.UserID = head.intReceivedBy
LEFT JOIN viewBinNames ln ON head.intVariance = ln.intBinId
LEFT JOIN viewBinNames ln2 ON head.intGIT = ln2.intBinId
LEFT JOIN tblDCNames dc ON dc.intAutoId = head.intFromDC
LEFT JOIN tblDCNames dc2 ON dc2.intAutoId = head.intToDC
GO
