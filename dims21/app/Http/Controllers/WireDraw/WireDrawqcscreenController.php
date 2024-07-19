<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Models\WireDraw\WireDrawCustomer;
use App\Models\WireDraw\WireDrawHeaders;
use App\Models\WireDraw\WireDrawProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WireDrawqcscreenController extends Controller
{
    public function index()
    {
        return view('warehouse.wiredraw.qcphase.index');
    }

    public function getqc()
    {
        $customers = WireDrawCustomer::select('strCustomerName', 'intCustomerId')->get();
        $products = WireDrawProduct::select('strProductName', 'intProductId')->get();
        $data = DB::connection('sqlsrv3')->select("EXEC spGetBulkMappingAreaDeptSubDeptMachines 10037, 'DepartmentMachines'");
        $headers = WireDrawHeaders::select('intHeaderId', 'dtDateStart', 'dtDateEnd', 'strReference')->get();

        $data = [
            'headers' => $headers,
            'customerName' => $customers,
            'productName' => $products,
            'machine' => $data,
        ];
        return response()->json($data);
    }
}
