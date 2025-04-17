USE [linxdbDIMSHendok]
GO

/****** Object:  View [dbo].[viewtblUpliftmentData]    Script Date: 2025/04/02 09:08:50 ******/
/***Added Handling Fee By Johnson Upadate (2025/04/02)**/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO


ALTER view [dbo].[viewtblUpliftmentData] as 
SELECT head.ID
    , intUpliftmentNumber
    , dteUpliftDate
    , strUpliftAction
    , strCompany
    , strCustomer
    , strArea
    , strAddress
    , strInvoice
    , strReasonPickup
    , strReasonUpliftment
    , strUpliftmentStatus
    , du.UserName AS [Username]
    , strCollectionType
	, bitHandingFee  -- Added Handling Fee By Johnson Upadate (2025/04/02)
FROM tblUpliftmentHeaders head
INNER JOIN tblDIMSUSERS du
    ON du.UserID = head.intUserID

GO




