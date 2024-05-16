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
        $DCs = DB::connection('sqlsrv2')->select("SELECT intAutoId, strDCName FROM tblDCNames");
        return view('warehouse.stockcontrol.stockLocation')
            ->with('sageWarehouses', $sageWarehouses)
            ->with('DCs', $DCs);
    }

    public function getStockLocationSummary(Request $request)
    {
        $intDCId = $request->get('intDCid');
        $data = DB::connection('sqlsrv2')->select("EXEC spGetStockSummary $intDCId");
        return response()->json($data);
    }

    public function getStockDetailsSummary(Request $request)
    {
        $ItemCode = $request->get("ItemCode");
        $intDCId = $request->get('intDCid');
        $data = DB::connection('sqlsrv2')->select("EXEC spGetStockDetailSummary '$ItemCode', $intDCId");
        return response()->json($data);
    }

    public function getIssuedStock(Request $request){
        $data = DB::connection('sqlsrv2')->select("SELECT * FROM viewIssuedStock");
        return response()->json($data);
        
    }
}
