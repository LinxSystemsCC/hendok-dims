<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawProductsRequest;
use App\Models\WireDraw\WireDrawProduct;
use App\Models\WireDraw\WireDrawCustomer;
use Illuminate\Support\Facades\DB;

class WireDrawProductsController extends Controller
{
    /**
     * This function is used for return view and disply data  
     */
    public function index()
    {
        $customers = WireDrawCustomer::select('strCustomerName as Name', 'intCustomerId as ID')->get();

        return view('warehouse.wiredraw.products.index')->with('customers', $customers);
    }

    /**
     * This function is used for save the new products
     *
     * @param obj $request
     */
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

    /**
     * This function is used for update the products
     *
     * @param obj $request
     */
    public function update(StorePostWireDrawProductsRequest $request, WireDrawProduct $Product)
    {
        $validated = $request->validated();
        $Product->update($this->getRequestData($validated));

        return response()->json(['success' => true]);
    }

    /**
     * This function is used for get data,update data and return array 
     */
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

    /**
     * This function is used for delete the products
     */
    public function destroy(string $id)
    {
        WireDrawProduct::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }

    /**
     * This function is used for get the products list
     */
    public function getProductsName()
    {
        $data = DB::table('tblCustomersWireDraw')
            ->join('tblProductsWireDraw', 'tblCustomersWireDraw.intCustomerId', '=', 'tblProductsWireDraw.intCustomerId')
            ->select('tblCustomersWireDraw.strCustomerName','tblProductsWireDraw.intProductId','tblProductsWireDraw.strProductName',
                'tblProductsWireDraw.ftlWireSize','tblProductsWireDraw.strSizeTolerance','tblProductsWireDraw.strMPATolerance','tblProductsWireDraw.intCustomerId'
            )
            ->latest('intProductId')
            ->get();

        return response()->json($data);
    }
}
