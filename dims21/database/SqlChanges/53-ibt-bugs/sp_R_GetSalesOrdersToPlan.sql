SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- Create the stored procedure in the specified schema
ALTER PROCEDURE [dbo].[sp_R_GetSalesOrdersToPlan]
    @DeliveryDateFrom DATE,
    @DeliveryDateTo DATE,
    @intDcId BIGINT,
    @routeIds NVARCHAR(MAX),
    @orderType NVARCHAR(50) -- 'DELIVERED' OR 'COLLECT'
AS
BEGIN
    -- body of the stored procedure
    SET NOCOUNT ON;

    EXEC [spGetOrderHeadersFromSage]
    EXEC [spGeUplifmentsFromSage]
    EXEC [spUpdateRoutesFromSage]

    DROP TABLE IF EXISTS #tempOrderQtys

    SELECT * INTO #tempOrderQtys
    FROM viewQtyPlannedForOrder WHERE CAST(DeliveryDate AS DATE) BETWEEN @DeliveryDateFrom AND @DeliveryDateTo


        SELECT
            cli.Account CustomerPastelCode
            , cli.Name StoreName 
            , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription) Area
            , r.Route
            , stk.ItemGroupDescription COLLATE DATABASE_DEFAULT ItemGroupDescription 
            , TRY_CAST(inv.OrderDate AS date) OrderDate
            , TRY_CAST(inv.DeliveryDate AS date) DeliveryDate
            , sum((invl.fQuantity - invl.fQtyProcessed) * stk.ufIIWeight) mnyTonsOnSalesOrder
            , stk.ufIIWeight mnyTonsProduct
            , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50))) OrderNo
            , invl.iLineID LineId
            , invl.idInvoiceLines intorderdetailId
            , stk.Code COLLATE DATABASE_DEFAULT PastelCode
            , stk.Description_1 COLLATE DATABASE_DEFAULT PastelDescription
            , invl.fQuantity - invl.fQtyProcessed mnyOutstanding
            , invl.fQuantity - invl.fQtyProcessed - isnull(vpq.qtyPlanned, 0) mnyToPlan
            , isnull(vpq.qtyPlanned, 0) mnyAlreadyPlanned
            , isnull(ie.mnyAvail , 0) mnyAvail
            , CASE 
                WHEN inv.ubARIBT = 1 THEN 'WAREHOUSE TRANSFER'
                ELSE inv.ucIDSOrdINST
            END  strInstruction
            , ow.OwnerID
            , null intSequence
            , CASE
                -- WHEN MAX(CAST(invl.ubIDSOrdTxSTPriorityItem as INT)) = 1 THEN '#E090FC'
                WHEN MAX(CAST(0 as INT)) = 1 THEN '#E090FC'
                ELSE '' 
            END AS strRowColor
        FROM [Hendok Distribution].dbo._bvInvNumARFull inv
        INNER JOIN [Hendok Distribution].dbo._btblInvoiceLines(NOLOCK) invl ON invl.iInvoiceID = inv.AutoIndex
        INNER JOIN [Hendok Distribution].dbo.Client(NOLOCK) cli ON cli.DCLink = inv.AccountID
        INNER JOIN [Hendok Distribution].dbo._bvStockFull(NOLOCK) stk ON stk.StockLink = invl.iStockCodeID
        INNER JOIN tblOrders(NOLOCK) ord ON ord.AutoIndex = inv.AutoIndex
        INNER JOIN tblOwners(NOLOCK) ow ON ow.OwnerID = ord.intOwnerID
        INNER JOIN tblRoutes(NOLOCK) r
            ON r.Route collate database_default = CASE 
                    WHEN inv.ulIDSOrdAreaSO = '(NONE)'
                        THEN dbo.[fnGetRouteMappedToArea](inv.AreaDescription)
                    ELSE dbo.[fnGetRouteMappedToArea](inv.ulIDSOrdAreaSO)
                    END
        -- Added by kyle to account for planned qunatities 2024-07-10
        LEFT OUTER JOIN #tempOrderQtys vpq
            ON vpq.AutoIndex = invl.iInvoiceID
                AND vpq.intorderdetailId = invl.idInvoiceLines
                AND vpq.intOwnerID = ow.OwnerID
        -- Added by kyle to account for inventory available 2024-08-02
        LEFT OUTER JOIN (
			SELECT intProductID
                , decAvail AS mnyAvail
                , intDCId
            FROM vwIDXAvailableStockByDc
		) ie ON ie.intProductID = stk.StockLink AND ie.intDCId = @intDcId
        WHERE ow.OwnerID = 1
            AND fQuantity - invl.fQtyProcessed > 0
            AND DocState IN (1, 3)
            AND inv.DueDate BETWEEN @DeliveryDateFrom AND @DeliveryDateTo
            AND DocType IN (1, 4)
            AND r.RouteId IN (
                SELECT *
                FROM dbo.fnSplitStringAsTable(@routeIds, ',')
                )
            AND cli.On_Hold = 0
            AND DeliveryMethod = @orderType
        GROUP BY cli.Account
            , cli.Name
            , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription)
            , r.Route
            , stk.ItemGroupDescription
            , inv.OrderDate
            , inv.DeliveryDate
            , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50)))
            , invl.iLineID
            , invl.idInvoiceLines
            , stk.Code
            , stk.Description_1
            , invl.fQuantity - invl.fQtyProcessed
            , vpq.qtyPlanned
            , ie.mnyAvail
            , inv.ubARIBT
            , inv.ucIDSOrdINST
            , ow.OwnerID
            , stk.ufIIWeight

        UNION ALL

        SELECT
            cli.Account CustomerPastelCode
            , cli.Name StoreName 
            , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription) Area
            , r.Route
            , stk.ItemGroupDescription COLLATE DATABASE_DEFAULT ItemGroupDescription
            , TRY_CAST(inv.OrderDate AS date) OrderDate
            , TRY_CAST(inv.DeliveryDate AS date) DeliveryDate
            , sum((invl.fQuantity - invl.fQtyProcessed) * stk.ufIIWeight) mnyTonsOnSalesOrder
            , stk.ufIIWeight mnyTonsProduct
            , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50))) OrderNo
            , invl.iLineID LineId
            , invl.idInvoiceLines intorderdetailId
            , stk.Code COLLATE DATABASE_DEFAULT PastelCode
            , stk.Description_1 COLLATE DATABASE_DEFAULT PastelDescription
            , invl.fQuantity - invl.fQtyProcessed mnyOutstanding
            , invl.fQuantity - invl.fQtyProcessed - isnull(vpq.qtyPlanned, 0) mnyToPlan
            , isnull(vpq.qtyPlanned, 0) mnyAlreadyPlanned
            , isnull(ie.mnyAvail , 0) mnyAvail
            ,  inv.ucIDSOrdINST strInstruction
            , ow.OwnerID
            , null intSequence
            , CASE
                -- WHEN MAX(CAST(invl.ubIDSOrdTxSTPriorityItem as INT)) = 1 THEN '#E090FC'
                WHEN MAX(CAST(0 as INT)) = 1 THEN '#E090FC'
                ELSE '' 
            END AS strRowColor
        FROM [Henroof].dbo._bvInvNumARFull inv
        INNER JOIN [Henroof].dbo._btblInvoiceLines(NOLOCK) invl ON invl.iInvoiceID = inv.AutoIndex
        INNER JOIN [Henroof].dbo.Client(NOLOCK) cli ON cli.DCLink = inv.AccountID
        INNER JOIN [Henroof].dbo._bvStockFull(NOLOCK) stk ON stk.StockLink = invl.iStockCodeID
        INNER JOIN tblOrders(NOLOCK) ord ON ord.AutoIndex = inv.AutoIndex
        INNER JOIN tblOwners(NOLOCK) ow ON ow.OwnerID = ord.intOwnerID
        INNER JOIN tblRoutes(NOLOCK) r
            ON r.Route collate database_default = CASE 
                    WHEN inv.ulIDSOrdAreaSO = '(NONE)'
                        THEN dbo.[fnGetRouteMappedToArea](inv.AreaDescription)
                    ELSE dbo.[fnGetRouteMappedToArea](inv.ulIDSOrdAreaSO)
                    END
        -- Added by kyle to account for planned qunatities 2024-07-10
        LEFT OUTER JOIN #tempOrderQtys vpq
            ON vpq.AutoIndex = invl.iInvoiceID
                AND vpq.intorderdetailId = invl.idInvoiceLines
                AND vpq.intOwnerID = ow.OwnerID
        -- Added by kyle to account for inventory available 2024-08-02
        LEFT OUTER JOIN (
			SELECT intProductID
                , decAvail AS mnyAvail
                , intDCId
            FROM vwIDXAvailableStockByDc
		) ie ON ie.intProductID = stk.StockLink AND ie.intDCId = @intDcId
        WHERE ow.OwnerID = 2
            AND fQuantity - invl.fQtyProcessed > 0
            AND DocState IN (1, 3)
            AND inv.DueDate BETWEEN @DeliveryDateFrom AND @DeliveryDateTo
            AND DocType IN (1, 4)
            AND r.RouteId IN (
                SELECT *
                FROM dbo.fnSplitStringAsTable(@routeIds, ',')
                )
            AND cli.On_Hold = 0
            AND DeliveryMethod = @orderType
        GROUP BY cli.Account
            , cli.Name
            , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription)
            , r.Route
            , stk.ItemGroupDescription
            , inv.OrderDate
            , inv.DeliveryDate
            , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50)))
            , invl.iLineID
            , invl.idInvoiceLines
            , stk.Code
            , stk.Description_1
            , invl.fQuantity - invl.fQtyProcessed
            , vpq.qtyPlanned
            , ie.mnyAvail
            , inv.ucIDSOrdINST
            , ow.OwnerID
            , stk.ufIIWeight

        UNION ALL

        SELECT
            cli.Account CustomerPastelCode
            , cli.Name StoreName 
            , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription) Area
            , r.Route
            , stk.ItemGroupDescription COLLATE DATABASE_DEFAULT ItemGroupDescription
            , TRY_CAST(inv.OrderDate AS date) OrderDate
            , TRY_CAST(inv.DeliveryDate AS date) DeliveryDate
            , sum((invl.fQuantity - invl.fQtyProcessed) * stk.ufIIWeight) mnyTonsOnSalesOrder
            , stk.ufIIWeight mnyTonsProduct
            , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50))) OrderNo
            , invl.iLineID LineId
            , invl.idInvoiceLines intorderdetailId
            , stk.Code COLLATE DATABASE_DEFAULT PastelCode
            , stk.Description_1 COLLATE DATABASE_DEFAULT PastelDescription
            , invl.fQuantity - invl.fQtyProcessed mnyOutstanding
            , invl.fQuantity - invl.fQtyProcessed - isnull(vpq.qtyPlanned, 0) mnyToPlan
            , isnull(vpq.qtyPlanned, 0) mnyAlreadyPlanned
            , isnull(ie.mnyAvail , 0) mnyAvail
            , inv.ucIDSOrdINST strInstruction
            , ow.OwnerID
            , null intSequence
            , CASE
                -- WHEN MAX(CAST(invl.ubIDSOrdTxSTPriorityItem as INT)) = 1 THEN '#E090FC'
                WHEN MAX(CAST(0 as INT)) = 1 THEN '#E090FC'
                ELSE '' 
            END AS strRowColor
        FROM [Ukhosi].dbo._bvInvNumARFull inv
        INNER JOIN [Ukhosi].dbo._btblInvoiceLines(NOLOCK) invl ON invl.iInvoiceID = inv.AutoIndex
        INNER JOIN [Ukhosi].dbo.Client(NOLOCK) cli ON cli.DCLink = inv.AccountID
        INNER JOIN [Ukhosi].dbo._bvStockFull(NOLOCK) stk ON stk.StockLink = invl.iStockCodeID
        INNER JOIN tblOrders(NOLOCK) ord ON ord.AutoIndex = inv.AutoIndex
        INNER JOIN tblOwners(NOLOCK) ow ON ow.OwnerID = ord.intOwnerID
        INNER JOIN tblRoutes(NOLOCK) r
            ON r.Route collate database_default = CASE 
                    WHEN inv.ulIDSOrdAreaSO = '(NONE)'
                        THEN dbo.[fnGetRouteMappedToArea](inv.AreaDescription)
                    ELSE dbo.[fnGetRouteMappedToArea](inv.ulIDSOrdAreaSO)
                    END
        -- Added by kyle to account for planned qunatities 2024-07-10
        LEFT OUTER JOIN #tempOrderQtys vpq
            ON vpq.AutoIndex = invl.iInvoiceID
                AND vpq.intorderdetailId = invl.idInvoiceLines
                AND vpq.intOwnerID = ow.OwnerID
        -- Added by kyle to account for inventory available 2024-08-02
        LEFT OUTER JOIN (
			SELECT intProductID
                , decAvail AS mnyAvail
                , intDCId
            FROM vwIDXAvailableStockByDc
		) ie ON ie.intProductID = stk.StockLink AND ie.intDCId = @intDcId
        WHERE ow.OwnerID = 3
            AND fQuantity - invl.fQtyProcessed > 0
            AND DocState IN (1, 3)
            AND inv.DueDate BETWEEN @DeliveryDateFrom AND @DeliveryDateTo
            AND DocType IN (1, 4)
            AND r.RouteId IN (
                SELECT *
                FROM dbo.fnSplitStringAsTable(@routeIds, ',')
                )
            AND cli.On_Hold = 0
            AND DeliveryMethod = @orderType
        GROUP BY cli.Account
            , cli.Name
            , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription)
            , r.Route
            , stk.ItemGroupDescription
            , inv.OrderDate
            , inv.DeliveryDate
            , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50)))
            , invl.iLineID
            , invl.idInvoiceLines
            , stk.Code
            , stk.Description_1
            , invl.fQuantity - invl.fQtyProcessed
            , vpq.qtyPlanned
            , ie.mnyAvail
            , inv.ucIDSOrdINST
            , ow.OwnerID
            , stk.ufIIWeight

        UNION ALL

        SELECT 
            head.strcustomer collate database_default AS CustomerPastelCode
            , cust.StoreName collate database_default AS StoreName 
            , head.strArea collate database_default AS Area
            , r.Route
            , stk.ItemGroupDescription
            , head.dteUpliftDate
            , head.dteUpliftDate
            , headprod.Weight mnyTonsOnSalesOrder
            , stk.ufIIWeight mnyTonsProduct
            , 'UPL#' + right(1000000 + head.intUpliftmentNumber, 6) OrderNo
            , headprod.ID LineId
            , headprod.ID intorderdetailId
            , stk.Code PastelCode
            , stk.Description_1 PastelDescription
            , headprod.Qty mnyOutstanding
            , headprod.Qty mnyToPlan
            , 0 mnyAlreadyPlanned
            , 0 mnyAvail
            , 'Upliftment-DIMS' strInstruction
            , cust.OwnerID intOwnerId
            , null intSequence
            , '#E1AD01' strRowColor
        FROM tblUpliftmentHeaders head
        INNER JOIN tblUpliftmentProducts headprod
            ON head.intUpliftmentNumber = headprod.intUpliftmentNumber
        INNER JOIN tblSageFullStock stk
            ON stk.Code collate database_default = headprod.PastelCode
        INNER JOIN viewtblCustomers cust
            ON cust.CustomerPastelCode collate database_default = head.strCustomer
                AND head.strCompany collate database_default = cust.CompanyName
        INNER JOIN tblRoutes r
            ON r.Route = dbo.[fnGetRouteMappedToArea](head.strArea)
        LEFT JOIN viewOrdersRouteMass rm
            ON rm.rName collate database_default = r.[Route]
        INNER JOIN tblDIMSUSERS du
            ON du.UserID = head.intUserID
        WHERE head.strUpliftmentStatus = 'Approved'
            AND head.dteUpliftDate BETWEEN @DeliveryDateFrom AND @DeliveryDateTo
            AND r.routeID IN (
                SELECT *
                FROM dbo.fnSplitStringAsTable(@routeIds, ',')
                ) -- need to look at this function regarding areaid and routeid

        -- ADDED FOR IBTS
        UNION ALL 

        SELECT 'HDK001' CustomerPastelCode
            , 'Hendok Distribution' StoreName 
            , dc.strDCName Area
            , dc.strDCName Route
            , stk.ItemGroupDescription
            , ibth.dtmCreated
            , ibth.dtmCreated
            , ibtl.fltWeight
            , stk.ufIIWeight mnyTonsProduct
            , 'IBT#' + right(1000000 + ibth.intAutoId, 6) OrderNo
            , ibtl.intAutoId LineId
            , ibtl.intAutoId intorderdetailId
            , stk.Code PastelCode
            , stk.Description_1 PastelDescription
            , ibtl.mnyQty - isnull(vpq.qtyPlanned, 0) mnyOutstanding
            , ibtl.mnyQty - isnull(vpq.qtyPlanned, 0) mnyToPlan
            , vpq.qtyPlanned mnyAlreadyPlanned
            , 0 mnyAvail
            , 'IBT-DIMS' strInstruction
            , 1 intOwnerId
            , null intSequence
            , '#34C0EB' strRowColor 
        FROM tblIBTHeader ibth 
        INNER JOIN tblIBTLines ibtl ON ibtl.intAutoHeaderId = ibth.intAutoId
        INNER JOIN tblSageFullStock stk ON stk.Code = ibtl.strPartNumber
        INNER JOIN tblDCNames dc ON dc.intAutoId = ibth.intToDC
        -- Added to track IBT Planned qty
        LEFT OUTER JOIN #tempOrderQtys vpq
            ON vpq.AutoIndex = ibth.intAutoId
                AND vpq.intorderdetailId = ibtl.intAutoId
        WHERE CAST(ibth.dtmCreated AS DATE) BETWEEN @DeliveryDateFrom AND @DeliveryDateTo
            AND @orderType = 'IBT' 
            AND CASE 
                WHEN ibth.bitPartiallyProcessed = 1 THEN 0 -- Adjusted (removed the check for intStatus when its partially processed)
                ELSE COALESCE(ibth.intStatus, 0)
            END < 1
END
