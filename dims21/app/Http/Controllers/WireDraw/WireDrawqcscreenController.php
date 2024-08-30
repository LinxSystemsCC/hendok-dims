<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawQcRequest;
use App\Models\WireDraw\WireDrawQcScreen;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\UtilityTrait;

class WireDrawqcscreenController extends Controller
{
    use UtilityTrait;

    /**
     * This function is used for return view and disply data
     */
    public function index()
    {
        return view('warehouse.wiredraw.qcphase.index');
    }

    /**
     * This function is used for get the qc list
     */
    public function getqc()
    {
        $data = DB::table('tblWireDrawHeaders')
            ->leftJoin('tblCustomersWireDraw', 'tblWireDrawHeaders.intCustomerId', '=', 'tblCustomersWireDraw.intCustomerId')
            ->join('tblProductsWireDraw', 'tblWireDrawHeaders.intProductId', '=', 'tblProductsWireDraw.intProductId')
            ->leftJoin('tblMachines', 'tblWireDrawHeaders.intWireDrawMachineId', '=', 'tblMachines.intAutoMachineID')
            ->select('tblCustomersWireDraw.strCustomerName', 'tblCustomersWireDraw.intCustomerId', 'tblProductsWireDraw.intProductId', 'tblProductsWireDraw.strProductName', DB::raw("CONCAT('WD', tblWireDrawHeaders.intHeaderId) AS intHeaderIdcustom"), 'tblWireDrawHeaders.intHeaderId', 'tblWireDrawHeaders.strReference', DB::raw("FORMAT(tblWireDrawHeaders.dtDateStart, 'yyyy-MM-dd HH:mm:ss') as dtDateStart"), DB::raw("FORMAT(tblWireDrawHeaders.dtDateEnd, 'yyyy-MM-dd HH:mm:ss') as dtDateEnd"), 'tblWireDrawHeaders.fltMassRequired', 'tblWireDrawHeaders.fltMassProduced', 'tblWireDrawHeaders.intNoOfStand', 'tblMachines.strMachineName', 'tblMachines.intAutoMachineID')
            ->where('strJobStatus', '!=', 'Completed')
            ->get();

        return response()->json($data);
    }

    /**
     * This function is used for save the data
     *
     * @param obj $request
     */
    public function store(StorePostWireDrawQcRequest $request)
    {
        $validated = $request->validated();
        // Set the initial data from the form.
        $passData = [
            'intJobNumber' => $validated['intJobNumber'],
            'intProductId' => $validated['intProductId'],
            'fltWireSize' => $validated['fltWireSize'],
            'intStand' => $validated['intStand'],
            'strTensileTicketNumber' => $validated['strTensileTicketNumber'],
            'strMPATolerance' => $validated['strMPATolerance'],
            'dtQCDateTime' => Carbon::now()->format('Y-m-d H:i:s'),
            'intUserId' => Auth::user()->UserID,
        ];

        // Find the previous lines that don't have a QC check yet
        $untestedStands = DB::table('tblWireDrawLines as l')
            ->leftJoin('tblWireDrawQCCheck as q', function ($join) {
                $join->on('l.intJobNumber', '=', 'q.intJobNumber')->on('l.intStand', '=', 'q.intStand');
            })
            ->whereNull('q.intJobNumber')
            ->whereNull('q.intStand')
            ->where('l.intJobNumber', $validated['intJobNumber'])
            ->select('l.intJobNumber', 'l.intStand', 'l.intRodId')
            ->get();

        // If there are any untested lines
        if ($untestedStands->isNotEmpty()) {

            // Find the last QC check for the same JobNumber
            $lastInsertedQC = DB::table('tblWireDrawQCCheck as qc')
                ->join('tblWireDrawLines as wdl', function ($join) {
                    $join->on('wdl.intJobNumber', '=', 'qc.intJobNumber')->on('wdl.intStand', '=', 'qc.intStand');
                })
                ->select('qc.*', 'wdl.intRodId')
                ->where('qc.intJobNumber', $validated['intJobNumber'])
                ->orderBy('created_at', 'desc')
                ->first();

            // Get the current Rod id for the Job
            $currentJobRod = DB::table('tblWireDrawRods as rd')
                ->select('rd.intRodId')
                ->where('rd.intJobNumber', $validated['intJobNumber'])->orderBy('created_at', 'desc')
                ->first();

            // dd($currentJobRod, $untestedStands,  $lastInsertedQC);

            // For each untested Line
            foreach ($untestedStands as $untestedStand) {
                $standData = $passData;
                $standData['intStand'] = $untestedStand->intStand;

                // If the current rod is equal to the untested rod, we insert the form data
                if ($currentJobRod->intRodId == $untestedStand->intRodId){
                    $standData['fltWireSize'] = $validated['fltWireSize'];
                    $standData['strTensileTicketNumber'] = $validated['strTensileTicketNumber'];
                    $standData['strMPATolerance'] = $validated['strMPATolerance'];
                // If  the current rod is not equal to the untested rod, we insert the previous rod's data
                }elseif ($untestedStand->intRodId == $lastInsertedQC->intRodId) {
                    $standData['fltWireSize'] = $lastInsertedQC->fltWireSize;
                    $standData['strTensileTicketNumber'] = $lastInsertedQC->strTensileTicketNumber;
                    $standData['strMPATolerance'] = $lastInsertedQC->strMPATolerance;
                // For safety sake, if we have missed anything, we will just insert the form data
                } else {
                    $standData['fltWireSize'] = $validated['fltWireSize'];
                    $standData['strTensileTicketNumber'] = $validated['strTensileTicketNumber'];
                    $standData['strMPATolerance'] = $validated['strMPATolerance'];
                }
                
                // dd($standData);
                
                // Insert the row.
                WireDrawQcScreen::create($standData);
            }
        } else {
            // dd($passData);
            
            // Insert the row.
            WireDrawQcScreen::create($passData);
        }

        return response()->json(['success' => true]);
    }
}
