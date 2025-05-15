<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GalvController extends Controller
{
    public function galvJumboCoilsPrint()
    {
        $userId = Auth::user()->UserID;

        $printers = DB::connection('sqlsrv2')->select("EXEC spGetUserPrinters $userId");

        return view('warehouse.galv.galvJumboCoilsPrint')->with('printers', $printers);
    }

    public function getWmaxTickets(Request $request)
    {
        $searchTerm = $request->input('q');

        $ticketData = DB::connection('wmax')
            ->table('tblCompletedJobs')
            ->select('TicketNo')
            ->where('TicketNo', 'like', '%' . $searchTerm . '%')
            ->take(1000)
            ->get();

        return response()->json($ticketData);
    }

    public function galvPrintJumboCoil(Request $request)
    {
        $ticket = $request->get('ticket');
        $quantity = $request->get('quantity');
        $printer = $request->get('printer');

        $result = DB::connection('sqlsrv2')->select("EXEC spPrintGalvJumboCoil '$ticket', $quantity, '$printer'");

        return response()->json($result);
    }

    public function wmaxscrap()
    {
        $scales = DB::connection('sqlsrv2')->select("exec spGetScalesByDeptName 'Galv Line 1 and 2'");
        $scrapBins = DB::connection('sqlsrv2')->select('SELECT * FROM tblScrapBins ORDER BY strBinName');
        return view('warehouse.galv.wmaxscrap')->with('scales', $scales)->with('scrapBins', $scrapBins);
    }

    public function postScrapWeigh(Request $request)
    {
        $id = $request->get('id');
        $bin = $request->get('bin');
        $weight = $request->get('weight');
        $command = $request->get('command');

        $result = DB::connection('sqlsrv2')->select("EXEC spGalvScrapWeighCRUD $id, $bin, $weight, '$command'");

        return response()->json($result);
    }

    public function wmaxlanding()
    {
        $customers = DB::connection('sqlsrv2')->select('select * from tblCustomersWmax ');
        $dept = DB::connection('sqlsrv2')->select("select * from tblDepartments Where strDeptName in ('Galv Line 1','Galv Line 2')");
        return view('warehouse.galv.wmax')->with('customers', $customers)->with('dept', $dept);
    }

    public function qc1()
    {
        $scales = DB::connection('sqlsrv2')->select("exec spGetScalesByDeptName 'Galv Line 1 and 2'");
        return view('warehouse.galv.qc1')->with('scales', $scales);
    }

    public function qc2()
    {
        $scales = DB::connection('sqlsrv2')->select("exec spGetScalesByDeptName 'Galv Line 1 and 2'");
        return view('warehouse.galv.qc2')->with('scales', $scales);
    }

    public function getqc1comments(Request $request)
    {
        $comments = DB::connection('sqlsrv2')->select('select * from tblQCPhase1Remarks');
        //dd($comments);

        return response()->json($comments);
    }

    public function getqc2comments(Request $request)
    {
        $comments = DB::connection('sqlsrv2')->select('select * from tblQCPhase2Remarks');
        //dd($comments);

        return response()->json($comments);
    }

    public function qc1pf(Request $request)
    {
        $Reference = $request->get('Reference');
        $CustomerName = $request->get('CustomerName');
        $ProductName = $request->get('ProductName');
        $DepartmentName = $request->get('DepartmentName');
        $MachineName = $request->get('MachineName');
        $JobNo = $request->get('JobNo');
        $WireSize = $request->get('WireSize');
        $MassRequired = $request->get('MassRequired');
        $testNo = $request->get('testNo');
        $zincTested = $request->get('zincTested');
        $mpaTested = $request->get('mpaTested');
        $castNo = $request->get('castNo');
        $wireSizeTested = $request->get('wireSizeTested');
        $stressTest = $request->get('stressTest');
        $elongBreakTest = $request->get('elongBreakTest');
        $torsionTest = $request->get('torsionTest');
        $wrapTest = $request->get('wrapTest');
        $coating = $request->get('coating');
        $comment1 = $request->get('comment1');
        $testpf = $request->get('testpf');
        $massProduced = $request->get('massProduced');
        $zincInitialMass = $request->get('zincInitialMass');
        $zincStripMass = $request->get('zincStripMass');
        $zincStripSize = $request->get('zincStripSize');
        $operator = Auth::user()->UserName;
        $comment2 = $request->get('comment2');
        $comment3 = $request->get('comment3');

        // dd($Reference, $CustomerName, $ProductName, $DepartmentName, $MachineName, $JobNo, $WireSize, $MassRequired, $testNo, $zincTested, $mpaTested, $castNo, $wireSizeTested, $stressTest, $elongBreakTest, $torsionTest, $wrapTest, $coating, $comment1, $testpf, $massProduced, $zincInitialMass, $zincStripMass, $zincStripSize, $operator, $comment2, $comment3);

        $testQC1 = DB::connection('sqlsrv2')->select('exec spInsertIntoPicking ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?', [$Reference, $CustomerName, $ProductName, $DepartmentName, $MachineName, $JobNo, $WireSize, $MassRequired, $testNo, $zincTested, $mpaTested, $castNo, $wireSizeTested, $stressTest, $elongBreakTest, $torsionTest, $wrapTest, $coating, $comment1, $testpf, $massProduced, $zincInitialMass, $zincStripMass, $zincStripSize, $operator, $comment2, $comment3]);

        return response()->json($testQC1);
    }

    public function qc2pf(Request $request)
    {
        $Reference = $request->get('Reference');
        $CustomerName = $request->get('CustomerName');
        $ProductName = $request->get('ProductName');
        $DepartmentName = $request->get('DepartmentName');
        $MachineName = $request->get('MachineName');
        $JobNo = $request->get('JobNo');
        $WireSize = $request->get('WireSize');
        $MassRequired = $request->get('MassRequired');
        $zincTested = $request->get('zincTested');
        $mpaTested = $request->get('mpaTested');
        $castNo = $request->get('castNo');
        $wireSizeTested = $request->get('wireSizeTested');
        $stressTest = $request->get('stressTest');
        $elongBreakTest = $request->get('elongBreakTest');
        $torsionTest = $request->get('torsionTest');
        $wrapTest = $request->get('wrapTest');
        $coating = $request->get('coating');
        $comment1 = $request->get('comment1');
        $massProduced = $request->get('massProduced');
        $zincInitialMass = $request->get('zincInitialMass');
        $zincStripMass = $request->get('zincStripMass');
        $zincStripSize = $request->get('zincStripSize');
        $operator = Auth::user()->UserName;
        $comment2 = $request->get('comment2');
        $comment3 = $request->get('comment3');
        $seqNo = $request->get('seqNo');
        $tensile = $request->get('tensile');
        $buttonMethod = $request->get('buttonMethod');
        $weight = '';
        $grossMass = 0;
        $tareMass = 0;

        $coilID = $request->get('coilID');
        $coilOD = $request->get('coilOD');

        // dd("exec spPassOrFailQCPhase2 '$Reference', '$CustomerName', '$ProductName', '$DepartmentName', '$MachineName', '$JobNo', '$WireSize', '$MassRequired', '$zincTested', '$mpaTested', '$castNo', '$wireSizeTested', '$stressTest', '$elongBreakTest', '$torsionTest', '$wrapTest', '$coating', '$comment1', '$massProduced', '$zincInitialMass', '$zincStripMass', '$zincStripSize', '$operator', '$comment2', '$comment3', '$seqNo', '$tensile', '$buttonMethod', '$weight', '$grossMass', '$tareMass', $coilID, $coilOD");

        $testQC2 = DB::connection('sqlsrv2')->select('exec spPassOrFailQCPhase2 ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?', [$Reference, $CustomerName, $ProductName, $DepartmentName, $MachineName, $JobNo, $WireSize, $MassRequired, $zincTested, $mpaTested, $castNo, $wireSizeTested, $stressTest, $elongBreakTest, $torsionTest, $wrapTest, $coating, $comment1, $massProduced, $zincInitialMass, $zincStripMass, $zincStripSize, $operator, $comment2, $comment3, $seqNo, $tensile, $buttonMethod, $weight, $grossMass, $tareMass, $coilID, $coilOD]);

        return response()->json($testQC2);
    }

    public function getqc1()
    {
        $qc1 = DB::connection('sqlsrv2')->select('select * from viewQCPhase1Jobs');
        return response()->json($qc1);
    }

    public function getqc2()
    {
        $qc2 = DB::connection('sqlsrv2')->select('select * from viewQCPhase2Jobs');
        return response()->json($qc2);
    }

    public function checkForGalvUpdates(Request $request)
    {
        $checker = $request->get('checker');
        $response = DB::connection('sqlsrv2')->select('exec spCheckForGalvUpdates ?', [$checker]);
        return response()->json($response);
    }

    public function deleteGalvChecker(Request $request)
    {
        $checker = $request->get('checker');
        $response = DB::connection('sqlsrv2')->select('exec spDeleteGalvChecker ?', [$checker]);
        return response()->json($response);
    }

    public function wmaxgetcustomerproduct(Request $request)
    {
        $cust = $request->get('customers');
        $productlist = DB::connection('sqlsrv2')->select("select * from tblProductsWmax where CustomerName ='" . $cust . "'");
        return response()->json($productlist);
    }

    public function wmaxgetproductinfo(Request $request)
    {
        $customer = $request->get('customer');
        $product = $request->get('product');
        //dd($customer, $product);

        $productinfo = DB::connection('sqlsrv2')->select("select * from tblProductsWmax where CustomerName ='" . $customer . "' and ProductName ='" . $product . "'");
        return response()->json($productinfo);
    }

    public function wmaxgetproductwiresize(Request $request)
    {
        $ProductID = $request->get('productId');
        $productlistsize = DB::connection('sqlsrv2')->select('select * from tblProductsWmax where ProductID =' . $ProductID);
        return response()->json($productlistsize);
    }

    public function wmaxdepartmentgalv()
    {
        $dept = DB::connection('sqlsrv2')->select('select * from tblDepartments');
        return response()->json($dept);
    }

    public function wmaxdepartmentmachinesgalv(Request $request)
    {
        $deptId = $request->get('deptId');
        $machines = DB::connection('sqlsrv2')->select("EXEC spGetMachinesByDept  $deptId");
        return response()->json($machines);
    }

    public function getGalvWIP(Request $request)
    {
        $productonmachine = DB::connection('sqlsrv2')->select("select distinct * from tblNewJobs Where Completed <> 'Y'");
        return response()->json($productonmachine);
    }

    public function getGalvWIPConsolidated()
    {
        $consolidatedgalvwip = DB::connection('sqlsrv2')->select('exec spConsolidatedGalvWIP');
        return response()->json($consolidatedgalvwip);
    }

    public function changeGalvJobStatus(Request $request)
    {
        $JobId = $request->get('JobId');
        $response = DB::connection('sqlsrv2')->select('exec spCompleteGalvJob ?', [$JobId]);
        return response()->json($response);
    }

    public function insertIntoJobTableGalv(Request $request)
    {
        $prodname = $request->get("prodname");

        $wiresize = $request->get("wiresize");
        $department = $request->get("department");
        $machinename = $request->get("machinename");
        $qty = $request->get("qty");
        $reference = $request->get("reference");
        $customers = $request->get("customers");
        $UserName = Auth::user()->UserName;

        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spInsertNewJobGalv ?,?,?,?,?,?,?,?',
                array($customers, $prodname, $wiresize, $department, $machinename, $qty, $reference, $UserName)
            );
        return response()->json($returnmach);
    }

    public function getGalvReprints(Request $request)
    {
        $ticketNo = $request->get('ticketNo');
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');

        $query = "SELECT * FROM viewGalvReprint WHERE 1=1";

        if (!empty($ticketNo)) {
            $query .= " AND TicketNo LIKE ?";
            $bindings[] = '%' . $ticketNo . '%';
        }

        if (!empty($dateFrom) && !empty($dateTo)) {
            $query .= " AND [DateTime] BETWEEN ? AND ?";
            $bindings[] = $dateFrom;
            $bindings[] = $dateTo;
        }

        $query .= " ORDER BY [DateTime] DESC";

        $reprints = DB::connection('sqlsrv2')->select($query, $bindings ?? []);
        return response()->json($reprints);

    }

    public function printgalvlabel(Request $request)
    {
        $ticketno = $request->get("ticketno");
        $qty = $request->get("qty");
        $status = $request->get('status');

        //dd($ticketno,$qty,$type);

        $returndata = DB::connection('sqlsrv2')->statement('exec spInsertFinalGalvLabelJobToPrint ?,?,?', array($ticketno, $qty, $status));

        return response()->json($returndata);
    }

    public function galvReprintEdit(Request $request)
    {
        $TicketNo = $request->get("TicketNo");
        $ActualWireSize = $request->get("ActualWireSize");
        $TreatedMPA = $request->get("TreatedMPA");
        $TestedZinc = $request->get("TestedZinc");
        $Weight = $request->get("Weight");
        $Table = $request->get("Table");

        $result = DB::connection('sqlsrv2')->select("EXEC spUpdateGalvCompletedJob '$TicketNo', $ActualWireSize, $TreatedMPA, $TestedZinc, $Weight, '$Table'");
        return response()->json($result);
    }

    public function undoLastGalvWeigh(Request $request)
    {
        $UserName = Auth::user()->UserName;
        $result = DB::connection('sqlsrv2')->select("EXEC usp_U_UndoLastGalvWeigh '$UserName'");
        return response()->json($result);
    }

    public function wmaxreprint()
    {
        return view('warehouse.galv.wmaxreprint');
    }
}
