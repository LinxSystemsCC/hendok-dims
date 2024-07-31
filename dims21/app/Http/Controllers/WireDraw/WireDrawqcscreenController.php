<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawQcRequest;
use App\Models\WireDraw\WireDrawQcScreen;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WireDrawqcscreenController extends Controller
{
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
        WireDrawQcScreen::create([
            'intJobNumber' => $validated['intJobNumber'],
            'intProductId' => $validated['intProductId'],
            'fltWireSize' => $validated['fltWireSize'],
            'intStand' => $validated['intStand'],
            'strTensileTicketNumber' => $validated['strTensileTicketNumber'],
            'strMPATolerance' => $validated['strMPATolerance'],
            'dtQCDateTime' => Carbon::now()->format('Y-m-d H:i:m'),
            'intUserId' => Auth::user()->UserID
        ]);

        return response()->json(['success' => true]);
    }
}
