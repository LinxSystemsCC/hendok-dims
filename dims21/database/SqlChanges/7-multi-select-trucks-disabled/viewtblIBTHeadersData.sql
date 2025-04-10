USE [linxdbDIMSHendok]
GO

/****** Object:  View [dbo].[viewtblIBTHeadersData]    Script Date: 2025/04/10 10:57:09 ******/
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
    ln.strBin AS varianceBinName,
    ln2.strBin AS gitBinName,
    dc.strDCName,
    dc2.strDCName AS toDCName,
    'TL' + CAST(head.intTLnumber AS NVARCHAR(10)) AS strTlNumber,
    head.intReceivingBin,
    CASE
        WHEN intStatus = 0 THEN 'Pending'
        WHEN intStatus = 1 THEN IIF(bitPartiallyProcessed = 1, 'Partially ', '') + 'Planned'
        WHEN intStatus = 2 THEN IIF(bitPartiallyProcessed = 1, 'Partially ', '') + 'Issued'
        WHEN intStatus = 3 THEN IIF(bitPartiallyProcessed = 1, 'Partially ', '') + 'Received'
        ELSE ''
    END AS strStatus,
    intStatus,
    bitPartiallyProcessed,
	 
    -- ✅ Corrected bin availability logic (exclude only those not fully received) Update by Johnson 2025-04-10
    CASE 
        WHEN NOT EXISTS (
            SELECT 1 
            FROM tblIBTHeader sub 
            WHERE sub.intGIT = head.intGIT 
              AND sub.intStatus IN (0, 1, 2)
        )
        THEN 1 ELSE 0 
    END AS bitActive

FROM tblIBTHeader AS head
INNER JOIN tblDIMSUSERS du ON du.UserID = head.intCreatedBy
LEFT JOIN tblDIMSUSERS ru ON ru.UserID = head.intReceivedBy
LEFT JOIN viewBinNames ln ON head.intVariance = ln.intBinId
LEFT JOIN viewBinNames ln2 ON head.intGIT = ln2.intBinId
LEFT JOIN tblDCNames dc ON dc.intAutoId = head.intFromDC
LEFT JOIN tblDCNames dc2 ON dc2.intAutoId = head.intToDC;
GO


