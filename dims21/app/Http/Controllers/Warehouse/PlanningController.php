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
        $productGroups = DB::connection('sqlsrv3')->table('tblSageFullStock')->select('ItemGroupDescription')->orderBy('ItemGroupDescription','ASC')->distinct()->get();
        $orderTypes = DB::connection('sqlsrv4')->table('tblOrderTypes')->select('OrderTypeId', 'OrderType')->get();

        $trucks = DB::connection('sqlsrv4')->table('tblTrucks')->select('TruckName', 'TruckId', 'RegNo')->orderBy('TruckName', 'ASC')->get();
        $drivers = DB::connection('sqlsrv4')->table('tblDrivers')->select('DriverName', 'DriverId')->orderBy('DriverName', 'ASC')->get();

        // dd($dcs, $routes, $orderTypes, $trucks, $drivers);
        // dd($productGroups);

        return view('warehouse.pickingPlanner.pickingPlanner')
            ->with('dcs', $dcs)
            ->with('routes', $routes)
            ->with('productGroups', $productGroups)
            ->with('orderTypes', $orderTypes)
            ->with('trucks', $trucks)
            ->with('drivers', $drivers);
    }

    public function getSalesOrdersToPlanOptimized(Request $request)
    {
        $DeliveryDateFrom = $request->get('DeliveryDateFrom');
        $DeliveryDateTo = $request->get('DeliveryDateTo');
        $intDcId = $request->get('intDcId');
        $productGroup = $request->get('productGroup');
        $routeIds = $request->get('routeIds');
        $userGroup = Auth::user()->GroupId;

        // dd("EXEC sp_R_GetSalesOrdersToPlan '$DeliveryDateFrom','$DeliveryDateTo',$intDcId,'$routeIds',$userGroup, '$productGroup'");

        $orders = DB::connection('sqlsrv3')->select("EXEC sp_R_GetSalesOrdersToPlan '$DeliveryDateFrom','$DeliveryDateTo',$intDcId,'$routeIds',$userGroup, '$productGroup'");

        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t=time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $strUnickReference = $t.$randomString;

        $response['orders'] = $orders;
        $response['strUnickReference'] = $strUnickReference;
        
        return response()->json($response);
    }
}
