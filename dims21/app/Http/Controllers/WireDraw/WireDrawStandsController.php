<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawStandsRequest;
use App\Models\WireDraw\WireStands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WireDrawStandsController extends Controller
{
    public function index()
    {
        $dept = DB::table('tblDepartments')->select('intAutoID as dptID','strDeptName as dptName')->get();    
        return view('warehouse.wiredraw.Stands.index')->with('dept',$dept);
    }

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

    public function getStandName()
    {
        $data = DB::table('tblDepartments')
        ->join('tblStands', 'tblDepartments.intAutoID', '=', 'tblStands.intDepartmentId')
        ->select('tblDepartments.strDeptName','tblStands.intStandId','tblStands.strStandName','tblStands.fltStandMass','tblStands.intDepartmentId')
        ->get();
        
        return response()->json($data);
    }
    public function destroy(string $id)
    {
        WireStands::destroy($id);

        return response()->json(['success' => 'Customer deleted successfully']);
    }
    public function update(StorePostWireDrawStandsRequest $request, WireStands $stand)
    {
        $validated = $request->validated();
        $stand->update($this->getRequestData($validated));
        return response()->json(['success' => true]);
    }

    private function getRequestData($data)
    {
        return [
            'strStandName' => $data['strStandName'],
            'fltStandMass' => $data['fltStandMass'],
            'intDepartmentId' => $data['intDepartmentId'],
        ];
    }

}
