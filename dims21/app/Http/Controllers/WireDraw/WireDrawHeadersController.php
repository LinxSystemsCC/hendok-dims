<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawHeadersRequest;
use App\Models\WireDraw\WireDrawHeaders;
use App\Models\WireDraw\WireDrawCustomer;
use App\Models\WireDraw\WireDrawProduct;
use Illuminate\Support\Carbon;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WireDrawHeadersController extends Controller
{
    public function index()
    {
        $customers = WireDrawCustomer::select('strCustomerName', 'intCustomerId')->get();
        $products = WireDrawProduct::select('strProductName', 'intProductId')->get();

        $dept = DB::connection('sqlsrv2')->select("select * from tblDepartments Where strDeptName in ('Wire Draw')");
        $wireDrawDepartmentId = 0;
        if (isset($dept[0]->intAutoID)) {
            $wireDrawDepartmentId = $dept[0]->intAutoID;
        }
        $machines = DB::connection('sqlsrv2')
            ->select("EXEC spGetBulkMappingAreaDeptSubDeptMachines $wireDrawDepartmentId, 'DepartmentMachines'");

        return view('warehouse.wiredraw.headers.index', compact('customers', 'products', 'machines'));
    }
    public function store(StorePostWireDrawHeadersRequest $request)
    {
        $validated = $request->validated();
        WireDrawHeaders::create([
            'intCustomerId' => $validated['intCustomerId'],
            'intProductId' => $validated['intProductId'],
            'intWireDrawMachineId' => $validated['intWireDrawMachineId'],
            'strType' => $validated['strType'],
            'fltMassRequired' => $validated['fltMassRequired'],
            'strReference' => $validated['strReference'],
            'intUserId' => Auth::user()->UserID,
        ]);

        return response()->json(['success' => true]);
    }

    public function getheaders()
    {

        $data = DB::table('tblWireDrawHeaders')
        ->leftJoin('tblCustomersWireDraw', 'tblWireDrawHeaders.intCustomerId', '=', 'tblCustomersWireDraw.intCustomerId')
        ->join('tblProductsWireDraw','tblWireDrawHeaders.intProductId','=','tblProductsWireDraw.intProductId')
        ->leftJoin('tblMachines','tblWireDrawHeaders.intWireDrawMachineId','=','tblMachines.intAutoMachineID')
        

        ->select('tblCustomersWireDraw.strCustomerName','tblCustomersWireDraw.intCustomerId','tblProductsWireDraw.intProductId','tblProductsWireDraw.strProductName',DB::raw("CONCAT('WD', tblWireDrawHeaders.intHeaderId) AS intHeaderId"),
        'tblWireDrawHeaders.strReference','tblWireDrawHeaders.dtDateEnd',DB::raw("FORMAT(tblWireDrawHeaders.dtDateStart, 'yyyy-MM-dd HH:mm:ss') as dtDateStart"),'tblWireDrawHeaders.fltMassRequired','tblWireDrawHeaders.fltMassProduced','tblWireDrawHeaders.intNoOfStand',
        'tblMachines.strMachineName','tblMachines.intAutoMachineID','tblWireDrawHeaders.strType')
        ->where('strJobStatus','=','Pending')
        ->orWhere('strJobStatus','=','Inprocess')
        

        ->get();

        return response()->json($data);
    }

    public function changeJobStatus(Request $request){

        $jobId = $request->input('JobId');

        $header = WireDrawHeaders::find($jobId);
        //dd($header);
        $header->dtDateEnd = Carbon::now();
           
        $header->strJobStatus = "Complete";
        $header->save();
        //dd($header);

        return response()->json(['success' => true]);
    }
}


