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
                ->join('tblProductsWireDraw','tblWireDrawHeaders.intProductId','=','tblProductsWireDraw.intProductId')
                ->leftJoin('tblMachines','tblWireDrawHeaders.intWireDrawMachineId','=','tblMachines.intAutoMachineID')
                ->select('tblCustomersWireDraw.strCustomerName','tblCustomersWireDraw.intCustomerId','tblProductsWireDraw.intProductId','tblProductsWireDraw.strProductName',DB::raw("CONCAT('WD', tblWireDrawHeaders.intHeaderId) AS intHeaderIdcustom"),
                        'tblWireDrawHeaders.intHeaderId','tblWireDrawHeaders.strReference',DB::raw("FORMAT(tblWireDrawHeaders.dtDateStart, 'yyyy-MM-dd HH:mm:ss') as dtDateStart"),DB::raw("FORMAT(tblWireDrawHeaders.dtDateEnd, 'yyyy-MM-dd HH:mm:ss') as dtDateEnd"),'tblWireDrawHeaders.fltMassRequired','tblWireDrawHeaders.fltMassProduced','tblWireDrawHeaders.intNoOfStand',
                        'tblMachines.strMachineName','tblMachines.intAutoMachineID'
                    )
                ->where('strJobStatus','!=','Completed')
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
        $passData = [
            'intJobNumber' => $validated['intJobNumber'],
            'intProductId' => $validated['intProductId'],
            'fltWireSize' => $validated['fltWireSize'],
            'intStand' => $validated['intStand'],
            'strTensileTicketNumber' => $validated['strTensileTicketNumber'],
            'strMPATolerance' => $validated['strMPATolerance'],
            'dtQCDateTime' => Carbon::now()->format('Y-m-d H:i:m'),
            'intUserId' => Auth::user()->UserID
        ];
        $blankStands = DB::table('tblWireDrawLines as l')
            ->leftJoin('tblWireDrawQCCheck as q', function ($join) {
                $join->on('l.intJobNumber', '=', 'q.intJobNumber')
                    ->on('l.intStand', '=', 'q.intStand');
            })
            ->whereNull('q.intJobNumber')
            ->whereNull('q.intStand')
            ->where('l.intJobNumber', $validated['intJobNumber'])
            ->select('l.intJobNumber', 'l.intStand', 'l.intRodId')
            ->get();

        if ($blankStands->isNotEmpty()) {
            $lastLineRod = $blankStands->last()->intRodId;
            $isNotSameStand = false;
            foreach ($blankStands as $blankStand) {
                if ($blankStand->intRodId != $lastLineRod) {
                    $isNotSameStand = true;
                }
            }
            $lastInsertedQcScreen = null;
            if ($isNotSameStand) {
                $lastInsertedQcScreen = WireDrawQcScreen::where('intJobNumber', $validated['intJobNumber'])
                    ->orderBy('created_at', 'desc')
                    ->first();
            }
            foreach ($blankStands as $blankStand) {
                $passData['intStand'] = $blankStand->intStand;
                if ($blankStand->intRodId != $lastLineRod && $lastInsertedQcScreen) {
                    $passData['fltWireSize'] = $lastInsertedQcScreen->fltWireSize;
                    $passData['strTensileTicketNumber'] = $lastInsertedQcScreen->strTensileTicketNumber;
                    $passData['strMPATolerance'] = $lastInsertedQcScreen->strMPATolerance;
                }
                WireDrawQcScreen::create($passData);
            }
        } else {
            WireDrawQcScreen::create($passData);
        }

        return response()->json(['success' => true]);
    }
}
