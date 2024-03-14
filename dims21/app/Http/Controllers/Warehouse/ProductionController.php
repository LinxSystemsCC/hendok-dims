<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function productionCapture()
    {
        $shifts = DB::connection('sqlsrv2')->select("SELECT * FROM tblProductionShifts");
        $departments = DB::connection('sqlsrv2')->select("SELECT * FROM tblDepartments");
        $operators = DB::connection('sqlsrv2')->select("SELECT * FROM viewSage300Employees");
        $reasons = DB::connection('sqlsrv2')->select("SELECT * FROM tblProductionReasons");

        return view('warehouse.production.productionCapture')
            ->with('shifts', $shifts)
            ->with('departments', $departments)
            ->with('operators', $operators)
            ->with('reasons', $reasons);
    }

    public function postProductionCaptureCrud(Request $request){
        $intAutoId = $request->get("intAutoId");
        $dteOccured = $request->get("dteOccured");
        $intShiftId = $request->get("intShiftId");
        $intDepartmentId = $request->get("intDepartmentId");
        $intMachineId = $request->get("intMachineId");
        $strProductCode = $request->get("strProductCode");
        $fltWeight = $request->get("fltWeight");
        $fltQty = $request->get("fltQty");
        $strOperator1 = $request->get("strOperator1");
        $strOperator2 = $request->get("strOperator2");
        $strOperator3 = $request->get("strOperator3");
        $strOperator4 = $request->get("strOperator4");
        $fltScrap = $request->get("fltScrap");
        $strDowntime1 = $request->get("strDowntime1");
        $intReason1 = $request->get("intReason1");
        $strComment1 = $request->get("strComment1");
        $strDowntime2 = $request->get("strDowntime2");
        $intReason2 = $request->get("intReason2");
        $strComment2 = $request->get("strComment2");
        $strDowntime3 = $request->get("strDowntime3");
        $intReason3 = $request->get("intReason3");
        $strComment3 = $request->get("strComment3");
        $strDowntime4 = $request->get("strDowntime4");
        $intReason4 = $request->get("intReason4");
        $strComment4 = $request->get("strComment4");
        $command = $request->get("command");

        // dd("'$intAutoId', '$dteOccured', '$intShiftId', '$intDepartmentId', '$intMachineId', '$strProductCode', '$fltWeight', '$fltQty', '$strOperator1', '$strOperator2', '$strOperator3', '$strOperator4', '$fltScrap', '$strDowntime1', '$intReason1', '$strComment1', '$strDowntime2', '$intReason2', '$strComment2', '$strDowntime3', '$intReason3', '$strComment3', '$strDowntime4', '$intReason4', '$strComment4', '$command'");

        $data = DB::connection('sqlsrv2')->select("EXEC spProductionCaptureCRUD '$intAutoId', '$dteOccured', '$intShiftId', '$intDepartmentId', '$intMachineId', '$strProductCode', '$fltWeight', '$fltQty', '$strOperator1', '$strOperator2', '$strOperator3', '$strOperator4', '$fltScrap', '$strDowntime1', '$intReason1', '$strComment1', '$strDowntime2', '$intReason2', '$strComment2', '$strDowntime3', '$intReason3', '$strComment3', '$strDowntime4', '$intReason4', '$strComment4', '$command'");
        return response()->json($data);
    }
}
