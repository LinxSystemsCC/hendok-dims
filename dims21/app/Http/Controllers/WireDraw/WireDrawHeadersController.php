<?php

namespace App\Http\Controllers\WireDraw;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostWireDrawAddRowRequest;
use App\Http\Requests\StorePostWireDrawHeadersRequest;
use App\Models\WireDraw\WireDrawRod;
use App\Models\WireDraw\WireDrawHeaders;
use App\Models\WireDraw\WireDrawCustomer;
use App\Models\WireDraw\WireDrawProduct;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\UtilityTrait;

class WireDrawHeadersController extends Controller
{
    use UtilityTrait;

    /**
     * This function is used for return view and disply data
     */
    public function index()
    {
        $customers = WireDrawCustomer::select('strCustomerName', 'intCustomerId')
            ->get();
        $products = WireDrawProduct::select('strProductName', 'intProductId')
            ->get();
        $dept = DB::connection('sqlsrv2')
                ->select("select * from tblDepartments Where strDeptName in ('Wire Draw')");
        $wireDrawDepartmentId = 0;
        if (isset($dept[0]->intAutoID)) {
            $wireDrawDepartmentId = $dept[0]->intAutoID;
        }
        $machines = DB::connection('sqlsrv2')
                ->select("EXEC spGetBulkMappingAreaDeptSubDeptMachines $wireDrawDepartmentId, 'DepartmentMachines'");

        $rodcodes = $this->getRodCodesList();
        $suppliers = $this->getSuppliersList();

        return view('warehouse.wiredraw.headers.index', compact('customers', 'products', 'machines','suppliers','rodcodes'));
    }

    /**
     * This function is used for save the new job
     *
     * @param obj $request
     */
    public function store(StorePostWireDrawHeadersRequest $request)
    {
        $validated = $request->validated();
        WireDrawHeaders::create([
            'intCustomerId' => $validated['intCustomerId'],
            'intProductId' => $validated['intProductId'],
            'intWireDrawMachineId' => $validated['intWireDrawMachineId'],
            'fltMassRequired' => $validated['fltMassRequired'],
            'strReference' => $validated['strReference'],
            'intUserId' => Auth::user()->UserID,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * This function is used for get the headers list
     */
    public function getheaders()
    {
        $data = DB::table('tblWireDrawHeaders')
            ->leftJoin('tblCustomersWireDraw', 'tblWireDrawHeaders.intCustomerId', '=', 'tblCustomersWireDraw.intCustomerId')
            ->join('tblProductsWireDraw','tblWireDrawHeaders.intProductId','=','tblProductsWireDraw.intProductId')
            ->leftJoin('tblMachines','tblWireDrawHeaders.intWireDrawMachineId','=','tblMachines.intAutoMachineID')
            ->select('tblCustomersWireDraw.strCustomerName',
                        'tblCustomersWireDraw.intCustomerId',
                        'tblProductsWireDraw.intProductId',
                        'tblProductsWireDraw.strProductName',
                    DB::raw("CONCAT('WD', tblWireDrawHeaders.intHeaderId) AS intHeaderId"),
                    'tblWireDrawHeaders.strReference',
                    DB::raw("FORMAT(tblWireDrawHeaders.dtDateEnd, 'yyyy-MM-dd HH:mm:ss') as dtDateEnd"),
                    DB::raw("FORMAT(tblWireDrawHeaders.dtDateStart, 'yyyy-MM-dd HH:mm:ss') as dtDateStart"),
                    'tblWireDrawHeaders.fltMassRequired','tblWireDrawHeaders.fltMassProduced','tblWireDrawHeaders.intNoOfStand',
                    'tblMachines.strMachineName','tblMachines.intAutoMachineID','tblWireDrawHeaders.strJobStatus'
                )
            ->where('strJobStatus','!=','Completed')
            ->latest('intHeaderId')
            ->get();

        return response()->json($data);
    }

    /**
     * This function is used for change JobS tatus
     *
     * @param obj $request
     */
    public function changeJobStatus(Request $request)
    {
        $jobId = $request->input('JobId');
        $header = WireDrawHeaders::find($jobId);
        $header->update([
            'dtDateEnd' => Carbon::now(),
            'strJobStatus' => 'Completed',
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * This function is used for save the add rod
     *
     * @param obj $request
     */
    public function addrod(StorePostWireDrawAddRowRequest $request)
    {
        $validated = $request->validated();
        WireDrawRod::create([
            'dtmDate' => date('Y-m-d H:i:s'),
            'intJobNumber' => $validated['intJobNumber'],
            'intRodSupplier' => $validated['intRodSupplier'],
            'strRodCode' => $validated['strRodCode'],
            'strCastNumber' => $validated['strCastNumber'],
            'strSerialNumber' => $validated['strSerialNumber'],
            'strBatchNumber' => $validated['strBatchNumber'],
            'fltRodElongation' => $validated['fltRodElongation'],
            'fltRodMpa' => $validated['fltRodMpa'],
            'fltRodWeigh' => $validated['fltRodWeigh'],
            'intUserId' => Auth::user()->UserID,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * This function is used for get the product list base on customer id
     *
     *  @param obj $request
     */
    public function getproduct(Request $request)
    {
        $products = DB::table('tblProductsWireDraw')
            ->select('intProductId', 'strProductName')
            ->where('intCustomerId', '=', $request->get('intCustomerID'))
            ->get();

        return response()->json($products);
    }
}


