<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawHeadersRequest;
use App\Models\WireDraw\WireDrawHeaders;
use App\Models\WireDraw\WireDrawCustomer;
use App\Models\WireDraw\WireDrawProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $headers = WireDrawHeaders::all();

        $customerName = DB::table('tbl_customers_wiredraw')->join('tbl_wire_draw_header_lines', 'tbl_customers_wiredraw.intCustomerId', '=', 'tbl_wire_draw_header_lines.intCustomerId')->select('tbl_customers_wiredraw.strCustomerName')->get();

        $productName = DB::table('tbl_products_wiredraw')->join('tbl_wire_draw_header_lines', 'tbl_products_wiredraw.intProductId', '=', 'tbl_wire_draw_header_lines.intProductId')->select('tbl_products_wiredraw.strProductName')->get();

        $machine = DB::connection('sqlsrv3')->select("EXEC spGetBulkMappingAreaDeptSubDeptMachines 10037, 'DepartmentMachines'");

        $data = [
            'headers' => $headers,
            'customerName' => $customerName,
            'productName' => $productName,
            'machine' => $machine,
        ];

        return response()->json($data);
    }
}
