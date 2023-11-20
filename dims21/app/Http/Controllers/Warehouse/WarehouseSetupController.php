<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseSetupController extends Controller
{
    public function stockLocations()
    {
        return view('warehouse.setup.stockLocations');
    }

    public function stockLocationCrud(Request $request){
        $intLocationId  = $request->get("intLocationId");
        $strLocationName = $request->get("strLocationName");
        $strLocationAbv = $request->get("strLocationAbv");
        $intLocationTypeId = $request->get("intLocationTypeId");
        $command = $request->get("command");

        $result = DB::connection('sqlsrv2')->select("EXEC spStockLocationCrud '$intLocationId', '$strLocationName', '$strLocationAbv', '$intLocationTypeId', '$command'");

        return response()->json($result);
    }

    public function stockLocationTypesCrud(Request $request){
        $intLocationTypeId = $request->get("intLocationTypeId"); 
        $strLocationType = $request->get("strLocationType");
        $command = $request->get("command");

        $result = DB::connection('sqlsrv2')->select("EXEC spStockLocationTypesCrud '$intLocationTypeId', '$strLocationType', '$command'");

        return response()->json($result);
    }

    public function stockLocationAttributesCrud(Request $request){
        $intAutoId = $request->get("intAutoId"); 
        $strAttribute = $request->get("strAttribute");
        $command = $request->get("command");

        $result = DB::connection('sqlsrv2')->select("EXEC spStockLocationAttributesCrud '$intAutoId', '$strAttribute', '$command'");
        return response()->json($result);
    }

    public function binCrud(Request $request){
        $intBinId = $request->get("intBinId"); 
        $strBinName = $request->get("strBinName");
        $intLocationId = $request->get("intLocationId");
        $mnyBinCapacity = $request->get("mnyBinCapacity");
        $command = $request->get("command");

        $result = DB::connection('sqlsrv2')->select("EXEC spBinCrud '$intBinId', '$strBinName', '$intLocationId', '$mnyBinCapacity', '$command'");
        return response()->json($result);
    }

    public function binAttributesCrud(Request $request){
        $intAutoId = $request->get("intAutoId");
        $strAttributeName = $request->get("strAttributeName");
        $strDefaultChar = $request->get("strDefaultChar");
        $intSequence = $request->get("intSequence");
        $command = $request->get("command");

        $result = DB::connection('sqlsrv2')->select("EXEC spBinAttributesCrud '$intAutoId', '$strAttributeName', '$strDefaultChar', '$intSequence', '$command'");

        return response()->json($result);
    }

    

    
}
