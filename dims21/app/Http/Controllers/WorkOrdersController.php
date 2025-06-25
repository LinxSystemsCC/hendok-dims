<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WorkOrdersController extends Controller
{
    public function index()
    {
        $departments = DB::connection('sqlsrv2')->select("SELECT * FROM tblDepartments");
        $statuses = DB::connection('sqlsrv2')->select("SELECT * FROM tblStatuses WHERE strReference = 'work_order'");

        return view('warehouse.workOrders.index')
            ->with("statuses", $statuses)
            ->with("departments", $departments);
    }

    public function getActiveJobs()
    {
        $activeJobs = DB::connection('sqlsrv2')->select("EXEC usp_R_ActiveJobs");
        return response()->json($activeJobs);
    }

    public function createNewJob(Request $request)
    {
        $intDepartmentId = $request->get("intDepartmentId");
        $intMachineId = $request->get("intMachineId");
        $strProductCode = $request->get("strProductCode");
        $decQtyRequired = $request->get("decQtyRequired");
        $decQtyConfiguration = $request->get("decQtyConfiguration");
        $strConfigurationType = $request->get("strConfigurationType");
        $intCreatedBy = Auth::user()->UserID;
        $dtePropStart = $request->get("dtePropStart");

        // dd("EXEC usp_C_NewJob $intDepartmentId, $intMachineId, '$strProductCode', $decQtyRequired, $decQtyConfiguration, '$strConfigurationType', $intCreatedBy, '$dtePropStart'");

        $result = DB::connection('sqlsrv2')->select("EXEC usp_C_NewJob $intDepartmentId, $intMachineId, '$strProductCode', $decQtyRequired, $decQtyConfiguration, '$strConfigurationType', $intCreatedBy, '$dtePropStart'");

        return response()->json($result[0]);
    }

    public function getMachineJobs(Request $request)
    {
        $intMachineId = $request->get("intMachineId");

        $jobs = DB::connection('sqlsrv2')->select("EXEC usp_R_MachineJobs $intMachineId");
        return response()->json($jobs);
    }

    public function updateWorkOrderStatus(Request $request)
    {
        $intStatusId = $request->get("intStatusId");
        $intUserId = Auth::user()->UserID;

        $response = DB::connection('sqlsrv2')->select("EXEC usp_U_WorkOrderStatus $intStatusId, $intUserId");
        return response()->json($response);
    }
}
