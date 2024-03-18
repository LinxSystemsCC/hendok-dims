<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockControlController extends Controller
{
    public function stockLocation()
    {
        $sageWarehouses = DB::connection('sqlsrv2')->select("SELECT Code, [Name] FROM [Hendok Distribution].dbo.WhseMst");
        return view('warehouse.stockcontrol.stockLocation')
            ->with('sageWarehouses', $sageWarehouses);
    }

    public function getStockLocationSummary(Request $request)
    {
        $data = DB::connection('sqlsrv2')->select("select * from  viewWareHouseTransferStockQty");
        return response()->json($data);
    }

    public function getStockDetailsSummary(Request $request)
    {
        $ItemCode = $request->get("ItemCode");
        $data = DB::connection('sqlsrv2')->select("select * from viewStockDetailsSummary where strErpItemCode ='" . $ItemCode . "' order by strErpItemCode");
        return response()->json($data);
    }
}
