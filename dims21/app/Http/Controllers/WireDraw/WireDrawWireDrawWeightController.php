<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawWeighRequest;
use App\Models\WireDraw\WireDrawHeaders;
use App\Models\WireDraw\WireDrawWeigh;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\UtilityTrait;

class WireDrawWireDrawWeightController extends Controller
{
    use UtilityTrait;

    /**
     * This function is used for return view and disply data
     */
    public function index()
    {
        $jobHeaders = DB::table('tblWireDrawHeaders')
            ->select(
                DB::raw("CONCAT('WD', tblWireDrawHeaders.intHeaderId) AS intHeaderIdcustom"),
                'intWireDrawMachineId',
                'tblMachines.strMachineName',
                'intNoOfStand',
                'tblProductsWireDraw.strProductName',
                'tblWireDrawHeaders.intHeaderId',
                'tblWireDrawHeaders.intProductId'
            )
            ->leftJoin('tblMachines', 'tblWireDrawHeaders.intWireDrawMachineId', '=', 'tblMachines.intAutoMachineID')
            ->join('tblProductsWireDraw', 'tblWireDrawHeaders.intProductId', '=', 'tblProductsWireDraw.intProductId')
            ->where('strJobStatus', '!=', 'Completed')
            ->get();

        $machines = $jobHeaders->pluck('strMachineName', 'intWireDrawMachineId');
        $machineWiseJobs = $jobHeaders->groupBy('intWireDrawMachineId');

        $stands = DB::table('tblStands')
            ->Join('tblDepartments', 'tblStands.intDepartmentId', '=', 'tblDepartments.intAutoID')
            ->select('tblStands.strStandName', 'tblStands.intStandId', 'tblStands.fltStandMass')
            ->where('tblDepartments.strDeptName', '=', 'Wire Draw')
            ->get();

        $stand = $stands->pluck('strStandName', 'intStandId');
        $standMass = $stands->pluck('fltStandMass', 'intStandId');
        $standGuop = $stands->groupBy('intStandId');
        $rodcodes = $this->getRodCodesList();
        $suppliers = $this->getSuppliersList();

        return view('warehouse.wiredraw.wiredrawweight.index', compact('machineWiseJobs', 'machines', 'standGuop', 'stand', 'standMass', 'rodcodes', 'suppliers'));
    }

    /**
     * This function is used for save the data and also save the add NoOfStand,weight,JobStatus,DateStart in tblWireDrawHeaders
     *
     * @param obj $request
     */
    public function store(StorePostWireDrawWeighRequest $request)
    {
        $validated = $request->validated();
        $intRodId = $this->getRodIdLastOfJobHeader($validated['intJobNumber']);

        $newRecord = WireDrawWeigh::create([
            'intJobNumber' => $validated['intJobNumber'],
            'intProductId' => $validated['intProductId'],
            'intStand' => $validated['intStand'],
            'intStandId' => $validated['intStandId'],
            'fltWeight' => $validated['fltWeight'],
            'intRodId' => $intRodId,
            'intUserId' => Auth::user()->UserID,
        ]);

        $newJobId = $newRecord->intOrderLineId;

        $header = WireDrawHeaders::find($validated['intJobNumber']);
        if ($header) {
            $totalWeight = WireDrawWeigh::where('intJobNumber', $validated['intJobNumber'])->sum('fltWeight');
            $updateData = [
                'intNoOfStand' => $validated['intStand'],
                'fltMassProduced' => $header->fltMassProduced + $totalWeight,
            ];
            if ($header->strJobStatus == 'Pending') {
                $updateData['strJobStatus'] = 'Inprocess';
            }
            if ($header->dtDateStart === null) {
                $updateData['dtDateStart'] = Carbon::now();
            }
            $header->update($updateData);
        }

        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $strToken = $t . $randomString;

        $UserId = Auth::user()->UserID;

        // dd("EXEC usp_C_InsertWireDrawLabel $newJobId, 1, $UserId, '$strToken'");

        DB::connection('sqlsrv2')->statement("EXEC usp_C_InsertWireDrawLabel $newJobId, 1, $UserId, '$strToken'");

        return response()->json(['success' => true]);
    }
}
