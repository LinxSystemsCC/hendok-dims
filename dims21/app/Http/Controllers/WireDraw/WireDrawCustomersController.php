<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawCustomerRequest;
use App\Models\WireDraw\WireDrawCustomer;

class WireDrawCustomersController extends Controller
{
    public function index()
    {
        return view('warehouse.wiredraw.customers.index');
    }
    public function store(StorePostWireDrawCustomerRequest $request)
    {
        $validated = $request->validated();
        WireDrawCustomer::create([
            'strCustomerName' => $validated['strCustomerName'],
        ]);

        return response()->json(['success' => 'Customer created successfully']);
    }
    public function getCustomerName()
    {
        $customerNames = WireDrawCustomer::select('intCustomerId',	'strCustomerName')
            ->latest('intCustomerId')
            ->get();

        return response()->json($customerNames);
    }
    public function destroy(string $id)
    {
        WireDrawCustomer::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }
    public function update(StorePostWireDrawCustomerRequest $request, WireDrawCustomer $customer)
    {
        $validated = $request->validated();
        $customer->update($this->getRequestData($validated));

        return response()->json(['data' => $customer]);
    }
    private function getRequestData($data)
    {
        return [
            'strCustomerName' => $data['strCustomerName'],
        ];
    }

}
