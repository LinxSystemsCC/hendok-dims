<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawProductsRequest;
use App\Models\WireDraw\WireDrawProduct;

class WireDrawProductsController extends Controller
{
    public function index()
    {
        $data = WireDrawProduct::all();

        return view('warehouse.wiredraw.products.index')->with('data', $data);
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
            'intCustomerId' => $data['intCustomerId']
        ];
    }

    public function destroy(string $id)
    {
        WireDrawProduct::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }

}
