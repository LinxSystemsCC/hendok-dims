<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanningController extends Controller
{
    function pickingPlanner(){
        $dcs = DB::connection('sqlsrv3')->table('tblDCNames')->select('intAutoId', 'strDCName')->get();
        $routes = DB::connection('sqlsrv3')->select("EXEC spGetRouteTonnageOnPlanning");
        $orderTypes = DB::connection('sqlsrv4')->table('tblOrderTypes')->select('OrderTypeId', 'OrderType')->get();

        $trailerTypes = DB::connection('sqlsrv3')->select('Select * from tblTrucks where intType=2' );
        
        $drivers = DB::connection('sqlsrv4')->table('tblDrivers')->select('DriverName', 'DriverId')->orderBy('DriverName', 'ASC')->get();

        $teamleaders = DB::connection('sqlsrv2')->select("SELECT * FROM viewTeamLeaders");

        // dd($dcs, $routes, $orderTypes, $trucks, $drivers);
        // dd($productGroups);

        return view('warehouse.pickingPlanner.pickingPlanner')
            ->with('dcs', $dcs)
            ->with('routes', $routes)
            ->with('orderTypes', $orderTypes)
            ->with('trailerTypes', $trailerTypes)
            ->with('drivers', $drivers)
            ->with('teamleaders', $teamleaders);
    }

    public function getSalesOrdersToPlanOptimized(Request $request)
    {
        $DeliveryDateFrom = $request->get('DeliveryDateFrom');
        $DeliveryDateTo = $request->get('DeliveryDateTo');
        $intDcId = $request->get('intDcId');
        $routeIds = $request->get('routeIds');
        $userGroup = Auth::user()->GroupId;

        // dd("EXEC sp_R_GetSalesOrdersToPlan '$DeliveryDateFrom','$DeliveryDateTo',$intDcId,'$routeIds',$userGroup");

        $orders = DB::connection('sqlsrv3')->select("EXEC sp_R_GetSalesOrdersToPlan '$DeliveryDateFrom','$DeliveryDateTo',$intDcId,'$routeIds',$userGroup");

        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t=time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $strUnickReference = $t.$randomString;

        $response['orders'] = $orders;
        $response['strUnickReference'] = $strUnickReference;
        
        return response()->json($response);
    }

    public function savePickingPlan(Request $request)
    {
        $lines = $request->get('lines');
        $strUnickReference = $request->get('strUnickReference');
        $userId = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $intDc = $request->get('intDc');
        $intTrailerType = $request->get('intTrailerType');
        $intTeamLeaderId = $request->get('intTeamLeaderId');
        $loadName = $request->get('loadName');
        $loadType = $request->get('loadType');

        if (is_array($lines)) {
            $xml = $this->toxml($lines, "xml", array("result"));

            // dd("EXEC sp_C_SavePickingPlan '$xml', '$strUnickReference', $userId, '$userName', $intDc, $intTrailerType, $intTeamLeaderId, '$loadName', '$loadType'");
            
            $response = DB::connection('sqlsrv3')->select("EXEC sp_C_SavePickingPlan '$xml', '$strUnickReference', $userId, '$userName', $intDc, $intTrailerType, $intTeamLeaderId, '$loadName', '$loadType'");

            return response()->json($response);
        }
        
    }

    private static function getTabs($tabcount)
    {
        $tabs = '';
        for ($i = 0; $i < $tabcount; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = array(), $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach ($arr as $key => $val) {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= "<" . $element . ">";
            if (!is_array($val))
                $result .= $val;
            else {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount + 1);
                $result .= $tabs;
            }
            $result .= "</" . $element . ">\r\n";
        }
        return $result;
    }

    public static function toxml($arr, $root = "xml", $elements = array())
    {
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }
}


