<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

class DiamondMeshController extends Controller
{
    public function diamondMeshWorkOrders()
    {
        $machines = DB::connection('sqlsrv2')
            ->select("select * from viewDiamondMeshMachines");

        return view('warehouse.diamondMesh.diamondMeshWorkOrders')->with('machines', $machines);
    }

    public function getDiamondMeshSalesOrders()
    {
        $salesOrders = DB::connection('sqlsrv2')
            ->select('EXEC spGetDiamondMeshSalesOrdersToPlan');

        return response()->json($salesOrders);
    }

    public function createDiamondMeshPlan(Request $request)
    {
        $orderlines = $request->get("orderlines");
        $operator = Auth::user()->UserID;
        $reference = $request->get("reference");

        if (is_array($orderlines)) {
            $orderlinesxml = $this->toxml($orderlines, "xml", array("result"));
        }

        // dd($orderlinesxml);

        $data = DB::connection('sqlsrv2')
            ->select('exec spXMLCreateDiamondMeshPlan ?,?,?', array($orderlinesxml, $operator, $reference));

        return response()->json($data);
    }

    public function getDiamondMeshHeaders(Request $request)
    {
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $headers = DB::connection('sqlsrv3')
            ->select("exec spGetDiamondMeshHeaders ?,?", array($datefrom, $dateto));

        return response()->json($headers);
    }

    public function getDiamondMeshLines(Request $request)
    {
        $ID = $request->get("ID");
        $lines = DB::connection('sqlsrv3')
            ->select("exec spGetDiamondMeshLines ?", array($ID));

        return response()->json($lines);
    }

    public function getDiamondMeshWorkInProgress(Request $request)
    {
        $wip = DB::connection('sqlsrv2')
            ->select('exec spGetDiamondMeshWorkInProgress');

        return response()->json($wip);
    }

    public function updateDiamondMeshLines(Request $request)
    {
        $workOrders = $request->get("workOrders");
        $batchID = $request->get("batchID");
        $batchReference = $request->get("batchReference");
        $userID = Auth::user()->UserID;

        if (is_array($workOrders)) {
            $orderlinesxml = $this->toxml($workOrders, "xml", array("result"));

            // dd($orderlinesxml);
            $data = DB::connection('sqlsrv2')
                ->select("EXEC spUpdateDiamondMeshLines '$orderlinesxml', $userID, $batchID,'$batchReference'");
        }

        return response()->json($data);
    }

    public function updateDiamondMeshJobStatus($reference, $machine)
    {
        return view('warehouse.DiamondMesh.updateDiamondMeshJobStatus')
            ->with("reference", $reference)
            ->with("machine", $machine);
    }

    public function getDiamondMeshLinesByReference(Request $request)
    {
        $reference = $request->get("reference");
        $machine = $request->get("machine");
        $jobdata = DB::connection('sqlsrv3')
            ->select("exec spGetDiamondMeshLinesByReferenceAndMachine '$reference', '$machine'");

        return response()->json($jobdata);
    }

    public function changeDiamondMeshJobStatus(Request $request)
    {
        $reference = $request->get("reference");
        $machine = $request->get("machine");
        $SONumber = $request->get("SONumber");
        $InvNumber = $request->get("InvNumber");
        $status = $request->get("status");

        // dd("exec spUpdateDiamondMeshJobStatus '$reference', '$machine', '$SONumber','$InvNumber', '$status'");

        $data = DB::connection('sqlsrv3')
            ->select("exec spUpdateDiamondMeshJobStatus '$reference', '$machine', '$SONumber','$InvNumber', '$status'");

        return response()->json($data);
    }

    public function updateDiamondMeshLinesSequence(Request $request)
    {
        $workOrders = $request->get("workOrders");

        if (is_array($workOrders)) {
            $orderlinesxml = $this->toxml($workOrders, "xml", array("result"));

            // dd($orderlinesxml);
            $data = DB::connection('sqlsrv2')
                ->select("EXEC spUpdateDiamondMeshLinesSequence '$orderlinesxml'");
        }
        // dd($data);

        return response()->json($data);
    }

    public function sendDiamondMeshLabelToThePrinter(Request $request)
    {
        $deptname = 'Diamond Mesh';
        $qty = $request->get('qty');
        $jobId  = $request->get('jobId');
        $operator  = Auth::user()->UserName;
        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;

        // dd($deptname,$jobId,$operator,$ID,$qty);

        $print = DB::connection('sqlsrv2')
            ->statement('exec spInsertPrintDiamondMeshLabels ?,?,?,?,?', array($deptname, $jobId, $operator, $ID, $qty));

        return response()->json($print);
    }

    public function diamondMeshReprint()
    {
        $userId = Auth::user()->UserID;
        $printers = DB::connection('sqlsrv3')->select("SELECT * FROM viewUserPrinters WHERE UserID = $userId");
        $jobs = DB::connection('sqlsrv2')->select("select * from viewDiamondMeshJobsPrinted");

        // dd($printers);

        return view('warehouse.diamondMesh.diamondMeshReprint')
            ->with('jobs',$jobs)
            ->with('printers',$printers);
    }

    public function diamondMeshInsertReprint(Request $request)
    {
        $intJobId = $request->get('intJobId');
        $intPrinterId = $request->get('intPrinterId');
        $qty = $request->get('qty');
        $userId = Auth::user()->UserID;

        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;

        // dd("EXEC spReprintDiamondMeshLabel $intJobId, $intPrinterId, $qty, '$ID', $userId");

        $request = DB::connection('sqlsrv2')->select("EXEC spReprintDiamondMeshLabel $intJobId, $intPrinterId, $qty, '$ID', $userId");

        return response()->json($request);
    }

    public function diamondMeshReport(Request $request)
    {
        $data = DB::connection('sqlsrv2')->select('SELECT * FROM viewDiamondMeshReport');
        return view('warehouse.diamondMesh.diamondMeshReport')->with('data', $data);
    }

    public function deleteDiamondMeshBatch(Request $request){
        $ID = $request->get("ID");
        $userid =  Auth::user()->UserID;

        $result = DB::connection('sqlsrv3')->statement("exec spDeleteDiamondMeshBatch ?,?", array($ID, $userid));
        return response()->json($result);
    }

    public function deleteDiamondMeshSO(Request $request){
        $ID = $request->get("ID");
        $userid =  Auth::user()->UserID;

        $result = DB::connection('sqlsrv3')->statement("exec spDeleteDiamondMeshSO ?,?", array($ID, $userid));
        return response()->json($result);
    }

    private static function getTabs($tabcount)
    {
        $tabs = '';
        for ($i = 0; $i < $tabcount; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = array(), $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach ($arr as $key => $val) {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= "<" . $element . ">";
            if (!is_array($val))
                $result .= $val;
            else {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount + 1);
                $result .= $tabs;
            }
            $result .= "</" . $element . ">\r\n";
        }
        return $result;
    }

    public static function toxml($arr, $root = "xml", $elements = array())
    {
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }
}
