<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawQcRequest;
use App\Models\WireDraw\WireDrawProduct;
use App\Models\WireDraw\WireDrawQcScreen;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class WireDrawqcscreenController extends Controller
{
    public function index()
    {
        return view('warehouse.wiredraw.qcphase.index');
    }

    public function getqc()
    {
        $data = DB::table('tblWireDrawHeaders')
        ->leftJoin('tblCustomersWireDraw', 'tblWireDrawHeaders.intCustomerId', '=', 'tblCustomersWireDraw.intCustomerId')
        ->join('tblProductsWireDraw','tblWireDrawHeaders.intProductId','=','tblProductsWireDraw.intProductId')
        ->leftJoin('tblMachines','tblWireDrawHeaders.intWireDrawMachineId','=','tblMachines.intAutoMachineID')

        ->select('tblCustomersWireDraw.strCustomerName','tblCustomersWireDraw.intCustomerId','tblProductsWireDraw.intProductId','tblProductsWireDraw.strProductName',DB::raw("CONCAT('WD', tblWireDrawHeaders.intHeaderId) AS intHeaderIdcustom"),
        'tblWireDrawHeaders.intHeaderId','tblWireDrawHeaders.strReference','tblWireDrawHeaders.dtDateEnd','tblWireDrawHeaders.dtDateStart','tblWireDrawHeaders.fltMassRequired','tblWireDrawHeaders.fltMassProduced','tblWireDrawHeaders.intNoOfStand',
        'tblMachines.strMachineName','tblMachines.intAutoMachineID')

        ->get();

        return response()->json($data);
    }

    public function store(StorePostWireDrawQcRequest $request)
    {
        $validated = $request->validated();
        $testQC =WireDrawQcScreen::create([
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
