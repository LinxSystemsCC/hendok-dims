ALTER VIEW [dbo].[viewOrderLinesUpliftments]
AS
SELECT *
FROM (
	SELECT o.ExtOrderNum AS OrderId
		,o.InvNumber AS DocNumber
		,c.Account
		,stk.Code
		,ol.cDescription AS PDesc
		,ol.fQtyProcessed AS decQtyProcessed -- Added QTY Date [2025-03-28]
		,o.DeliveryDate
		,'Hendok Distribution' AS strCompany
	FROM [Hendok Distribution].dbo._btblInvoiceLines ol
	INNER JOIN [Hendok Distribution].dbo._bvStockFull stk ON ol.iStockCodeID = stk.StockLink
	INNER JOIN [Hendok Distribution].dbo.InvNum o ON o.AutoIndex = ol.iInvoiceID
	INNER JOIN [Hendok Distribution].dbo.Client c ON c.DCLink = o.AccountID
	WHERE o.DeliveryDate > DATEADD(MONTH, - 3, GETDATE()) -- Updated to 3 month Date[2025-03-28]
	
	UNION ALL
	
	SELECT o.ExtOrderNum AS OrderId
		,o.InvNumber AS DocNumber
		,c.Account
		,stk.Code
		,ol.cDescription AS PDesc
		,ol.fQtyProcessed AS decQtyProcessed -- Added QTY Date [2025-03-28]
		,o.DeliveryDate
		,'Henroof' AS strCompany
	FROM [Henroof].dbo._btblInvoiceLines ol
	INNER JOIN [Henroof].dbo._bvStockFull stk ON ol.iStockCodeID = stk.StockLink
	INNER JOIN [Henroof].dbo.InvNum o ON o.AutoIndex = ol.iInvoiceID
	INNER JOIN [Henroof].dbo.Client c ON c.DCLink = o.AccountID
	WHERE o.DeliveryDate > DATEADD(MONTH, - 3, GETDATE()) -- Updated to 3 month Date[2025-03-28]
	
	UNION ALL
	
	SELECT o.ExtOrderNum AS OrderId
		,o.InvNumber AS DocNumber
		,c.Account
		,stk.Code
		,ol.cDescription AS PDesc
		,ol.fQtyProcessed AS decQtyProcessed -- Added QTY Date [2025-03-28]
		,o.DeliveryDate
		,'Ukhosi' AS strCompany
	FROM [Ukhosi].dbo._btblInvoiceLines ol
	INNER JOIN [Ukhosi].dbo._bvStockFull stk ON ol.iStockCodeID = stk.StockLink
	INNER JOIN [Ukhosi].dbo.InvNum o ON o.AutoIndex = ol.iInvoiceID
	INNER JOIN [Ukhosi].dbo.Client c ON c.DCLink = o.AccountID
	WHERE o.DeliveryDate > DATEADD(MONTH, - 3, GETDATE()) -- Updated to 3 month Date[2025-03-28]
	) AS x
GO

