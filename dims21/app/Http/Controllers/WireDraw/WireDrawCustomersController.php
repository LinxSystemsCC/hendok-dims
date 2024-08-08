<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawCustomerRequest;
use App\Models\WireDraw\WireDrawCustomer;

class WireDrawCustomersController extends Controller
{
    /**
     * This function is used for return view and disply data    
     */
    public function index()
    {
        return view('warehouse.wiredraw.customers.index');
    }

    /**
     * This function is used for save the new customerName
     *
     * @param obj $request
     */
    public function store(StorePostWireDrawCustomerRequest $request)
    {
        $validated = $request->validated();
        WireDrawCustomer::create([
            'strCustomerName' => $validated['strCustomerName'],
        ]);

        return response()->json(['success' => 'Customer created successfully']);
    }

    /**
     * This function is used for get the customer list
     */
    public function getCustomerName()
    {
        $customerNames = WireDrawCustomer::select('intCustomerId',	'strCustomerName')
            ->latest('intCustomerId')
            ->get();

        return response()->json($customerNames);
    }

    /**
     * This function is used for delete the customer
     * 
     * @param string $id
     */
    public function destroy(string $id)
    {
        WireDrawCustomer::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }

    /**
     * This function is used for update the customerName
     *
     * @param obj $request
     */
    public function update(StorePostWireDrawCustomerRequest $request, WireDrawCustomer $customer)
    {
        $validated = $request->validated();
        $customer->update($this->getRequestData($validated));

        return response()->json(['data' => $customer]);
    }

    /**
     * This function is used for get data,update data and return array 
     * 
     * @param array $data
     */
    private function getRequestData($data)
    {
        return [
            'strCustomerName' => $data['strCustomerName'],
        ];
    }
}
