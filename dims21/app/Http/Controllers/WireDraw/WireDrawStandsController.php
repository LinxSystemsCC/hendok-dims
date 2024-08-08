<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawStandsRequest;
use App\Models\WireDraw\WireStands;
use Illuminate\Support\Facades\DB;


class WireDrawStandsController extends Controller
{
    /**
     * This function is used for return view and disply data    
     */
    public function index()
    {
        $dept = DB::table('tblDepartments')
            ->select('intAutoID as dptID','strDeptName as dptName')
            ->get();

        return view('warehouse.wiredraw.stands.index')->with('dept',$dept);
    }

    /**
     * This function is used for save the data
     *
     * @param obj $request
     */
    public function store(StorePostWireDrawStandsRequest $request)
    {
        $validated = $request->validated();
        WireStands::create([
            'strStandName' => $validated['strStandName'],
            'fltStandMass' => $validated['fltStandMass'],
            'intDepartmentId' => $validated['intDepartmentId'],
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * This function is used for get the stand list
     */
    public function getStandName()
    {
        $data = DB::table('tblDepartments')
            ->join('tblStands', 'tblDepartments.intAutoID', '=', 'tblStands.intDepartmentId')
            ->select('tblDepartments.strDeptName','tblStands.intStandId','tblStands.strStandName','tblStands.fltStandMass','tblStands.intDepartmentId')
            ->latest('intStandId')
            ->get();

        return response()->json($data);
    }

    /**
     * This function is used for delete the stand
     * 
     * @param string $id
     */
    public function destroy(string $id)
    {
        WireStands::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }

    /**
     * This function is used for update the products
     *
     * @param obj $request
     */
    public function update(StorePostWireDrawStandsRequest $request, WireStands $stand)
    {
        $validated = $request->validated();
        $stand->update($this->getRequestData($validated));
        return response()->json(['success' => true]);
    }

    /**
     * This function is used for get data,update data and return array 
     * 
     * @param array $data
     */
    private function getRequestData($data)
    {
        return [
            'strStandName' => $data['strStandName'],
            'fltStandMass' => $data['fltStandMass'],
            'intDepartmentId' => $data['intDepartmentId'],
        ];
    }

}
