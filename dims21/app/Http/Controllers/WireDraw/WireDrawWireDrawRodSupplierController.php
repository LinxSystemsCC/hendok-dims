<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawRodSupplierRequest;
use App\Models\WireDraw\WireDrawRodSupplier;


class WireDrawWireDrawRodSupplierController extends Controller
{

    /**
    * This function is used for return view and disply data    
    */
    public function index()
    {
        return view('warehouse.wiredraw.rodsupplier.index');
    }

    /**
     * This function is used for save the new Rod Supplier
     *
     * @param obj $request
     */
    public function store(StorePostWireDrawRodSupplierRequest $request)
    {
        $validated = $request->validated();
        WireDrawRodSupplier::create([
            'strRodSupplierName' => $validated['strRodSupplierName'],
        ]);

        return response()->json(['success' => 'Customer created successfully']);
    }

    /**
     * This function is used for get the Rod Supplier list
     *
     */
    public function getRodSupplierName()
    {
        $customerNames = WireDrawRodSupplier::select('intRodSupplierId','strRodSupplierName')
            ->latest('intRodSupplierId')
            ->get();

        return response()->json($customerNames);
    }

    /**
     * This function is used for delete the Rod Supplier
     * 
     * @param string $id
     */
    public function destroy(string $id)
    {
        WireDrawRodSupplier::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }

    /**
     * This function is used for update the Rod Supplier
     *
     * @param obj $request
     */
    public function update(StorePostWireDrawRodSupplierRequest $request, WireDrawRodSupplier $rodSupplier)
    {
        $validated = $request->validated();
        $rodSupplier->update($this->getRequestData($validated));

        return response()->json(['data' => $rodSupplier]);
    }

    /**
     * This function is used for get data,update data and return array
     * 
     *  @param array $data
     */
    private function getRequestData($data)
    {
        return [
            'strRodSupplierName' => $data['strRodSupplierName'],
        ];
    }

}
