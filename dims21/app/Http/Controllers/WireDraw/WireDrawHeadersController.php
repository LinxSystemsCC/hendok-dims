<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawHeadersRequest;
use App\Models\WireDraw\WireDrawHeaders;
use App\Models\WireDraw\WireDrawCustomer;
use App\Models\WireDraw\WireDrawProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WireDrawHeadersController extends Controller
{
    public function index()
    {
        $customers = WireDrawCustomer::select('strCustomerName', 'intCustomerId')->get();
        $products = WireDrawProduct::select('strProductName', 'intProductId')->get();
        $data = DB::connection('sqlsrv3')->select("EXEC spGetBulkMappingAreaDeptSubDeptMachines 10037, 'DepartmentMachines'");

        return view('warehouse.wiredraw.headers.index')->with('customers', $customers)->with('products', $products)->with('data', $data);
    }
    public function store(StorePostWireDrawHeadersRequest $request)
    {
        $validated = $request->validated();
        dd($validated);
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
        
        ->select('tblCustomersWireDraw.strCustomerName','tblCustomersWireDraw.intCustomerId','tblProductsWireDraw.intProductId','tblProductsWireDraw.strProductName','tblWireDrawHeaders.intHeaderId',
        'tblWireDrawHeaders.strReference','tblWireDrawHeaders.dtDateEnd','tblWireDrawHeaders.dtDateStart','tblWireDrawHeaders.fltMassRequired','tblWireDrawHeaders.fltMassProduced','tblWireDrawHeaders.intNoOfStand',
        'tblMachines.strMachineName','tblMachines.intAutoMachineID','tblWireDrawHeaders.strType')

        ->get();

        return response()->json($data);
    }

    public function changeWireDrawJobStatus(Request $request){
        $JobId = $request->get("JobId");
    }
}


