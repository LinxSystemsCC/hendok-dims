<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawWeighRequest;
use App\Models\WireDraw\WireDrawHeaders;
use App\Models\WireDraw\WireDrawWeigh;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class WireDrawWireDrawWeightController extends Controller
{
    public function index()
    {
        $jobHeaders = DB::table('tblWireDrawHeaders')->select(DB::raw("CONCAT('WD', tblWireDrawHeaders.intHeaderId) AS intHeaderIdcustom"), 
            'intWireDrawMachineId', 'tblMachines.strMachineName', 'intNoOfStand', 'tblProductsWireDraw.strProductName', 'tblWireDrawHeaders.intHeaderId',
            'tblWireDrawHeaders.intProductId')
        ->leftJoin('tblMachines', 'tblWireDrawHeaders.intWireDrawMachineId', '=', 'tblMachines.intAutoMachineID')
        ->join('tblProductsWireDraw', 'tblWireDrawHeaders.intProductId', '=', 'tblProductsWireDraw.intProductId')
        ->get();

        $machines = $jobHeaders->pluck('strMachineName', 'intWireDrawMachineId');

        $machineWiseJobs = $jobHeaders->groupBy('intWireDrawMachineId');

        $stands = DB::table('tblStands')->Join('tblDepartments', 'tblStands.intDepartmentId', '=', 'tblDepartments.intAutoID')
        ->select('tblStands.strStandName', 'tblStands.intStandId', 'tblStands.fltStandMass')->where('tblDepartments.strDeptName', '=', 'Wire Draw')->get();

        $stand = $stands->pluck('strStandName', 'intStandId');
        $standMass = $stands->pluck('fltStandMass', 'intStandId');
        $standGuop = $stands->groupBy('intStandId');
        return view('warehouse.wiredraw.wiredrawweight.index', compact('machineWiseJobs', 'machines', 'standGuop', 'stand', 'standMass'));
    }

    public function store(StorePostWireDrawWeighRequest $request)
    {
        $validated = $request->validated();

        // Create a WireDrawWeigh instance
            WireDrawWeigh::create([
            'intjobNumber' => $validated['intjobNumber'],
            'intproductId' => $validated['intproductId'],
            'intstand' => $validated['intstand'],
            'intStandId' => $validated['intStandId'],
            'fltweight' => $validated['fltweight'],
        ]);

        $header = WireDrawHeaders::find($validated['intjobNumber']); 
       
        if ($header) {
            $totalWeight = WireDrawWeigh::where('intjobNumber', $validated['intjobNumber'])->sum('fltweight');
            
            $header->intNoOfStand = $validated['intstand'];

            $header->fltMassProduced += $totalWeight;

            if ($header->strJobStatus === 'Pending') {
                $header->strJobStatus = 'Inprocess';
            }
            if ($header->dtDateStart === null) {
                $header->dtDateStart = Carbon::now();
            }
            $header->save();
        }

        return response()->json(['success' => true]);
    }
}
