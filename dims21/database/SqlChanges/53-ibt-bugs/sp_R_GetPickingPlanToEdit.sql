SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- Create the stored procedure in the specified schema
ALTER PROCEDURE [dbo].[sp_R_GetPickingPlanToEdit] @intAutoHeaderId BIGINT
AS
BEGIN
    -- body of the stored procedure
    SET NOCOUNT ON;

    SELECT cli.Account CustomerPastelCode
        , cli.Name StoreName
        , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription) Area
        , r.Route
        , stk.ItemGroupDescription
        , TRY_CAST(inv.OrderDate AS DATE) OrderDate
        , TRY_CAST(inv.DeliveryDate AS DATE) DeliveryDate
        , sum((invl.fQuantity - invl.fQtyProcessed) * stk.ufIIWeight) mnyTonsOnSalesOrder
        , stk.ufIIWeight mnyTonsProduct
        , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50))) OrderNo
        , invl.iLineID LineId
        , invl.idInvoiceLines intorderdetailId
        , stk.Code COLLATE DATABASE_DEFAULT PastelCode
        , stk.Description_1 COLLATE DATABASE_DEFAULT PastelDescription
        , invl.fQuantity - invl.fQtyProcessed - isnull(vpq.qtyPlanned, 0) mnyOutstanding
        , pp.mnyQty mnyToPlan
        , isnull(vpq.qtyPlanned, 0) mnyAlreadyPlanned
        , isnull(ie.mnyAvail, 0) mnyAvail
        , CASE 
            WHEN inv.ubARIBT = 1
                THEN 'WAREHOUSE TRANSFER'
            ELSE inv.ucIDSOrdINST
            END strInstruction
        , ow.OwnerID
        , pp.intSequence
        , '' strRowColor
        , CASE 
            WHEN ISNULL(pp.mnyPickedQuantity, 0) <> 0
                THEN 0
            WHEN ISNULL(pp.mnyLoadedQty, 0) <> 0
                THEN 0
            ELSE 1
            END AS bitCanEdit
    FROM [tblPickingPlanHeader] ph
    INNER JOIN tblPickingPlan pp
        ON pp.intAutoPickingHeader = ph.intAutoPickingHeader
    INNER JOIN [Hendok Distribution].dbo._btblInvoiceLines(NOLOCK) invl
        ON invl.idInvoiceLines = pp.intorderdetailId
    INNER JOIN [Hendok Distribution].dbo._bvInvNumARFull inv
        ON inv.AutoIndex = invl.iInvoiceID
    INNER JOIN [Hendok Distribution].dbo.Client(NOLOCK) cli
        ON cli.DCLink = inv.AccountID
    INNER JOIN [Hendok Distribution].dbo._bvStockFull(NOLOCK) stk
        ON stk.StockLink = invl.iStockCodeID
    LEFT OUTER JOIN tblOrders(NOLOCK) ord
        ON ord.AutoIndex = inv.AutoIndex
    LEFT OUTER JOIN tblOwners(NOLOCK) ow
        ON ow.OwnerID = ord.intOwnerID
    LEFT OUTER JOIN tblRoutes(NOLOCK) r
        ON r.Route collate database_default = CASE 
                WHEN inv.ulIDSOrdAreaSO = '(NONE)'
                    THEN dbo.[fnGetRouteMappedToArea](inv.AreaDescription)
                ELSE dbo.[fnGetRouteMappedToArea](inv.ulIDSOrdAreaSO)
                END
    LEFT OUTER JOIN viewQtyPlannedForOrder vpq
        ON vpq.AutoIndex = invl.iInvoiceID
            AND vpq.intorderdetailId = invl.idInvoiceLines
            AND vpq.intOwnerID = ow.OwnerID
    LEFT OUTER JOIN (
        SELECT intProductID
            , decAvail AS mnyAvail
            , intDCId
        FROM vwIDXAvailableStockByDc
        ) ie
        ON ie.intProductID = stk.StockLink
            AND ie.intDCId = ph.IntDcId
    WHERE ph.intAutoPickingHeader = @intAutoHeaderId
        AND pp.intOwnerID = 1
        AND pp.strPickingType NOT IN ('ibt', 'upliftment')
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
        , pp.mnyQty
        , vpq.qtyPlanned
        , ie.mnyAvail
        , inv.ubARIBT
        , inv.ucIDSOrdINST
        , ow.OwnerID
        , stk.ufIIWeight
        , pp.intSequence
        , pp.mnyPickedQuantity
        , pp.mnyLoadedQty
    
    UNION ALL
    
    SELECT cli.Account CustomerPastelCode
        , cli.Name StoreName
        , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription) Area
        , r.Route
        , stk.ItemGroupDescription
        , TRY_CAST(inv.OrderDate AS DATE) OrderDate
        , TRY_CAST(inv.DeliveryDate AS DATE) DeliveryDate
        , sum((invl.fQuantity - invl.fQtyProcessed) * stk.ufIIWeight) mnyTonsOnSalesOrder
        , stk.ufIIWeight mnyTonsProduct
        , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50))) OrderNo
        , invl.iLineID LineId
        , invl.idInvoiceLines intorderdetailId
        , stk.Code COLLATE DATABASE_DEFAULT PastelCode
        , stk.Description_1 COLLATE DATABASE_DEFAULT PastelDescription
        , invl.fQuantity - invl.fQtyProcessed - isnull(vpq.qtyPlanned, 0) mnyOutstanding
        , pp.mnyQty mnyToPlan
        , isnull(vpq.qtyPlanned, 0) mnyAlreadyPlanned
        , isnull(ie.mnyAvail, 0) mnyAvail
        , inv.ucIDSOrdINST strInstruction
        , ow.OwnerID
        , pp.intSequence
        , '' strRowColor
        , CASE 
            WHEN ISNULL(pp.mnyPickedQuantity, 0) <> 0
                THEN 0
            WHEN ISNULL(pp.mnyLoadedQty, 0) <> 0
                THEN 0
            ELSE 1
            END AS bitCanEdit
    FROM [tblPickingPlanHeader] ph
    INNER JOIN tblPickingPlan pp
        ON pp.intAutoPickingHeader = ph.intAutoPickingHeader
    INNER JOIN [Henroof].dbo._btblInvoiceLines(NOLOCK) invl
        ON invl.idInvoiceLines = pp.intorderdetailId
    INNER JOIN [Henroof].dbo._bvInvNumARFull inv
        ON inv.AutoIndex = invl.iInvoiceID
    INNER JOIN [Henroof].dbo.Client(NOLOCK) cli
        ON cli.DCLink = inv.AccountID
    INNER JOIN [Henroof].dbo._bvStockFull(NOLOCK) stk
        ON stk.StockLink = invl.iStockCodeID
    LEFT OUTER JOIN tblOrders(NOLOCK) ord
        ON ord.AutoIndex = inv.AutoIndex
    LEFT OUTER JOIN tblOwners(NOLOCK) ow
        ON ow.OwnerID = ord.intOwnerID
    LEFT OUTER JOIN tblRoutes(NOLOCK) r
        ON r.Route collate database_default = CASE 
                WHEN inv.ulIDSOrdAreaSO = '(NONE)'
                    THEN dbo.[fnGetRouteMappedToArea](inv.AreaDescription)
                ELSE dbo.[fnGetRouteMappedToArea](inv.ulIDSOrdAreaSO)
                END
    LEFT OUTER JOIN viewQtyPlannedForOrder vpq
        ON vpq.AutoIndex = invl.iInvoiceID
            AND vpq.intorderdetailId = invl.idInvoiceLines
            AND vpq.intOwnerID = ow.OwnerID
    LEFT OUTER JOIN (
        SELECT intProductID
            , decAvail AS mnyAvail
            , intDCId
        FROM vwIDXAvailableStockByDc
        ) ie
        ON ie.intProductID = stk.StockLink
            AND ie.intDCId = ph.IntDcId
    WHERE ph.intAutoPickingHeader = @intAutoHeaderId
        AND pp.intOwnerID = 2
        AND pp.strPickingType NOT IN ('ibt', 'upliftment')
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
        , pp.mnyQty
        , vpq.qtyPlanned
        , ie.mnyAvail
        , inv.ucIDSOrdINST
        , ow.OwnerID
        , stk.ufIIWeight
        , pp.intSequence
        , pp.mnyPickedQuantity
        , pp.mnyLoadedQty
    
    UNION ALL
    
    SELECT cli.Account CustomerPastelCode
        , cli.Name StoreName
        , iif(inv.ulIDSOrdAreaSO <> '(NONE)', iif(len(inv.ulIDSOrdAreaSO) < 1, AreaDescription, inv.ulIDSOrdAreaSO), AreaDescription) Area
        , r.Route
        , stk.ItemGroupDescription
        , TRY_CAST(inv.OrderDate AS DATE) OrderDate
        , TRY_CAST(inv.DeliveryDate AS DATE) DeliveryDate
        , sum((invl.fQuantity - invl.fQtyProcessed) * stk.ufIIWeight) mnyTonsOnSalesOrder
        , stk.ufIIWeight mnyTonsProduct
        , iif(inv.DocType = 4, inv.OrderNum, cast(inv.AutoIndex AS NVARCHAR(50))) OrderNo
        , invl.iLineID LineId
        , invl.idInvoiceLines intorderdetailId
        , stk.Code COLLATE DATABASE_DEFAULT PastelCode
        , stk.Description_1 COLLATE DATABASE_DEFAULT PastelDescription
        , invl.fQuantity - invl.fQtyProcessed - isnull(vpq.qtyPlanned, 0) mnyOutstanding
        , pp.mnyQty mnyToPlan
        , isnull(vpq.qtyPlanned, 0) mnyAlreadyPlanned
        , isnull(ie.mnyAvail, 0) mnyAvail
        , inv.ucIDSOrdINST strInstruction
        , ow.OwnerID
        , pp.intSequence
        , '' strRowColor
        , CASE 
            WHEN ISNULL(pp.mnyPickedQuantity, 0) <> 0
                THEN 0
            WHEN ISNULL(pp.mnyLoadedQty, 0) <> 0
                THEN 0
            ELSE 1
            END AS bitCanEdit
    FROM [tblPickingPlanHeader] ph
    INNER JOIN tblPickingPlan pp
        ON pp.intAutoPickingHeader = ph.intAutoPickingHeader
    INNER JOIN [Ukhosi].dbo._btblInvoiceLines(NOLOCK) invl
        ON invl.idInvoiceLines = pp.intorderdetailId
    INNER JOIN [Ukhosi].dbo._bvInvNumARFull inv
        ON inv.AutoIndex = invl.iInvoiceID
    INNER JOIN [Ukhosi].dbo.Client(NOLOCK) cli
        ON cli.DCLink = inv.AccountID
    INNER JOIN [Ukhosi].dbo._bvStockFull(NOLOCK) stk
        ON stk.StockLink = invl.iStockCodeID
    LEFT OUTER JOIN tblOrders(NOLOCK) ord
        ON ord.AutoIndex = inv.AutoIndex
    LEFT OUTER JOIN tblOwners(NOLOCK) ow
        ON ow.OwnerID = ord.intOwnerID
    LEFT OUTER JOIN tblRoutes(NOLOCK) r
        ON r.Route collate database_default = CASE 
                WHEN inv.ulIDSOrdAreaSO = '(NONE)'
                    THEN dbo.[fnGetRouteMappedToArea](inv.AreaDescription)
                ELSE dbo.[fnGetRouteMappedToArea](inv.ulIDSOrdAreaSO)
                END
    LEFT OUTER JOIN viewQtyPlannedForOrder vpq
        ON vpq.AutoIndex = invl.iInvoiceID
            AND vpq.intorderdetailId = invl.idInvoiceLines
            AND vpq.intOwnerID = ow.OwnerID
    LEFT OUTER JOIN (
        SELECT intProductID
            , decAvail AS mnyAvail
            , intDCId
        FROM vwIDXAvailableStockByDc
        ) ie
        ON ie.intProductID = stk.StockLink
            AND ie.intDCId = ph.IntDcId
    WHERE ph.intAutoPickingHeader = @intAutoHeaderId
        AND pp.intOwnerID = 3
        AND pp.strPickingType NOT IN ('ibt', 'upliftment')
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
        , pp.mnyQty
        , vpq.qtyPlanned
        , ie.mnyAvail
        , inv.ucIDSOrdINST
        , ow.OwnerID
        , stk.ufIIWeight
        , pp.intSequence
        , pp.mnyPickedQuantity
        , pp.mnyLoadedQty
    
    -- Added For IBTs
    UNION ALL
    
    SELECT 'HK001' CustomerPastelCode
        , 'Hendok Distribution' StoreName
        , '' Area
        , '' Route
        , stk.ItemGroupDescription COLLATE DATABASE_DEFAULT ItemGroupDescription
        , TRY_CAST(ibth.dtmCreated AS DATE) OrderDate
        , TRY_CAST(ibth.dtmIssued AS DATE) DeliveryDate
        , '' mnyTonsOnSalesOrder
        , stk.ufIIWeight mnyTonsProduct
        , 'IBT' + FORMAT(ibth.intAutoId, '00000') OrderNo
        , ibtl.intAutoId LineId
        , ibtl.intAutoId intorderdetailId
        , stk.Code COLLATE DATABASE_DEFAULT PastelCode
        , stk.Description_1 COLLATE DATABASE_DEFAULT PastelDescription
        , ibtl.mnyQty mnyOutstanding
        , pp.mnyQty mnyToPlan
        , 0 mnyAlreadyPlanned
        , 0 mnyAvail
        , 'IBT-DIMS' strInstruction
        , 1 OwnerID
        , pp.intSequence
        , '#E17DFF' strRowColor
        , CASE 
            WHEN ISNULL(pp.mnyPickedQuantity, 0) <> 0
                THEN 0
            WHEN ISNULL(pp.mnyLoadedQty, 0) <> 0
                THEN 0
            ELSE 1
            END AS bitCanEdit
    FROM [tblPickingPlanHeader] ph
    INNER JOIN tblPickingPlan pp
        ON pp.intAutoPickingHeader = ph.intAutoPickingHeader
    INNER JOIN tblIBTLines ibtl
        ON ibtl.intAutoHeaderId = pp.intOrderId
            AND ibtl.intAutoId = pp.intorderdetailId
    INNER JOIN tblIBTHeader ibth
        ON ibth.intAutoId = ibtl.intAutoHeaderId
    INNER JOIN tblSageFullStock stk
        ON stk.Code COLLATE DATABASE_DEFAULT = ibtl.strPartNumber
    WHERE ph.intAutoPickingHeader = @intAutoHeaderId
        AND pp.intOwnerID = 1
        AND pp.strPickingType = 'ibt'
END
