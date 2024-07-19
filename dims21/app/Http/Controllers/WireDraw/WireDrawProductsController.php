<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawProductsRequest;
use App\Models\WireDraw\WireDrawProduct;
use App\Models\WireDraw\WireDrawCustomer;
use Illuminate\Support\Facades\DB;

class WireDrawProductsController extends Controller
{
    public function index()
    {
        $customers = WireDrawCustomer::select('strCustomerName as Name', 'intCustomerId as ID')->get();

        return view('warehouse.wiredraw.products.index')->with('customers', $customers);
    }
    public function store(StorePostWireDrawProductsRequest $request)
    {
        $validated = $request->validated();
        WireDrawProduct::create([
            'strProductName' => $validated['strProductName'],
            'ftlWireSize' => $validated['ftlWireSize'],
            'strSizeTolerance' => $validated['strSizeTolerance'],
            'strMPATolerance' => $validated['strMPATolerance'],
            'intCustomerId' => $validated['intCustomerId'],
        ]);

        return response()->json(['success' => true]);
    }

    public function update(StorePostWireDrawProductsRequest $request, WireDrawProduct $Product)
    {
        $validated = $request->validated();
        $Product->update($this->getRequestData($validated));
        return response()->json(['data' => $Product]);
    }

    private function getRequestData($data)
    {
        return [
            'strProductName' => $data['strProductName'],
            'ftlWireSize' => $data['ftlWireSize'],
            'strSizeTolerance' => $data['strSizeTolerance'],
            'strMPATolerance' => $data['strMPATolerance'],
            'intCustomerId' => $data['intCustomerId'],
        ];
    }

    public function destroy(string $id)
    {
        WireDrawProduct::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }

    public function getProductsName()
    {
        $data = DB::table('tbl_customers_wiredraw')->join('tbl_products_wiredraw', 'tbl_customers_wiredraw.intCustomerId', '=', 'tbl_products_wiredraw.intCustomerId')
        ->select('tbl_customers_wiredraw.strCustomerName','tbl_products_wiredraw.intProductId','tbl_products_wiredraw.strProductName','tbl_products_wiredraw.ftlWireSize','tbl_products_wiredraw.strSizeTolerance','tbl_products_wiredraw.strMPATolerance','tbl_products_wiredraw.intCustomerId')
        ->get();
        
        return response()->json($data);
    }
}
