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

        $trucks = DB::connection('sqlsrv4')->table('tblTrucks')->select('TruckName', 'TruckId', 'RegNo')->orderBy('TruckName', 'ASC')->get();
        $drivers = DB::connection('sqlsrv4')->table('tblDrivers')->select('DriverName', 'DriverId')->orderBy('DriverName', 'ASC')->get();

        // dd($dcs, $routes, $orderTypes, $trucks, $drivers);

        return view('warehouse.pickingPlanner.pickingPlanner')
            ->with('dcs', $dcs)
            ->with('routes', $routes)
            ->with('orderTypes', $orderTypes)
            ->with('trucks', $trucks)
            ->with('drivers', $drivers);
    }

    public function getSalesOrdersToPlanOptimized(Request $request)
    {
        $DeliveryDateFrom = $request->get('DeliveryDateFrom');
        $DeliveryDateTo = $request->get('DeliveryDateTo');
        $intDcId = $request->get('intDcId');
        $routeIds = $request->get('routeIds');
        $userGroup = Auth::user()->GroupId;

        $result = DB::connection('sqlsrv3')
            ->select("EXEC sp_R_GetSalesOrdersToPlan '$DeliveryDateFrom','$DeliveryDateTo',$intDcId,'$routeIds',$userGroup");

        return response()->json($result);
    }
}
