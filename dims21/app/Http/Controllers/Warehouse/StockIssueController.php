<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockIssueController extends Controller
{
    public function issuestock()
    {
        $users = DB::connection('sqlsrv3')->select("SELECT EmployeeCode, FirstName, LastName FROM viewSage300Employees WHERE EmployeeStatusCode = 'A'");
        $reference = DB::connection('sqlsrv3')->select('SELECT TOP 1 intAutoId FROM tblStockIssueHeader ORDER BY dteCreated DESC');
        $intAutoId = count($reference) > 0 ? $reference[0]->intAutoId : 0;
        $types = DB::connection('sqlsrv3')->select('SELECT * FROM tblStockIssueTypes');
        $requestTypes = DB::connection('sqlsrv3')->select('SELECT * FROM tblStockIssueRequestTypes');
        $groups = DB::connection('sqlsrv3')->select('SELECT DISTINCT strStockGroup, strStockGroupDesc FROM viewStockIssue');
        $stockItems = DB::connection('sqlsrv3')->select('SELECT * FROM viewStockIssue');
        $upkeepjobs = $this->getOpenUpkeepWorkOrders();
        $areas = DB::connection('sqlsrv3')->select('SELECT * FROM tblAreas');
        $departments = DB::connection('sqlsrv3')->select('SELECT * FROM tblDepartments');
        $subdepartments = DB::connection('sqlsrv3')->select('SELECT * FROM tblSubDepartments');
        $machines = DB::connection('sqlsrv3')->select('SELECT * FROM tblMachines');
        $pastelProjects = DB::connection('sqlsrv3')->select('SELECT ProjectCode FROM [Hendok Distribution].dbo.Project WHERE ActiveProject = 1');
        $reasons = DB::connection('sqlsrv3')->select('SELECT * FROM tblStockIssueReasons');

        return view('warehouse.issuestock')->with('users', $users)->with('intAutoId', $intAutoId)->with('types', $types)->with('requestTypes', $requestTypes)->with('groups', $groups)->with('stockItems', $stockItems)->with('upkeepjobs', $upkeepjobs)->with('areas', $areas)->with('departments', $departments)->with('subdepartments', $subdepartments)->with('machines', $machines)->with('pastelProjects', $pastelProjects)->with('reasons', $reasons);
    }

    public function getIssueStock(Request $request)
    {
        $result = DB::connection('sqlsrv3')->select('select * from viewStockIssue');
        return response()->json($result);
    }

    public function stockIssueTypes()
    {
        return view('warehouse/stockissuetypes');
    }

    public function getStockIssueTypes()
    {
        $response = DB::connection('sqlsrv3')->select('SELECT * FROM tblStockIssueTypes');
        return response()->json($response);
    }

    public function saveStockIssueType(Request $request)
    {
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'CREATE';

        $response = DB::connection('sqlsrv3')->statement('spStockIssueTypesCRUD ?,?,?', [$ID, $Name, $Operation]);
        return response()->json($response);
    }

    public function saveStockIssue(Request $request)
    {
        $reference = $request->get('reference');
        $assignedBy = Auth::user()->UserID;
        $assignedTo = $request->get('assignedTo');
        $lines = $request->get('lines');

        if (is_array($lines)) {
            $linesxml = $this->toxml($lines, 'xml', ['result']);

            // dd("EXEC usp_C_InsertStockIssue '$reference', $assignedBy,'$assignedTo','$linesxml'");
        }

        $data = DB::connection('sqlsrv2')->select("EXEC usp_C_InsertStockIssue '$reference', $assignedBy,'$assignedTo','$linesxml'");

        $jsonResponse = [
            'lines' => []
        ];

        foreach ($data as $row) {
            $jsonResponse['lines'][] = [
                'strPastelCode' => $row->strPastelCode,
                'strPastelDescription' => $row->strPastelDescription,
                'strReference' => $row->strReference,
                'dtmCreated' => $row->dtmCreated,
                'decAdjustmentQty' => $row->decAdjustmentQty,
                'strWarehouse' => $row->strWarehouse
            ];
        }

        
        return response()->json($data);

        // dd(json_encode($jsonResponse, JSON_PRETTY_PRINT));

        // $postAdjustment = $this->postInventoryAdjustment($data);

        // return response()->json($postAdjustment);
    }

    public function issueStockRecieve(Request $request)
    {
        $intHeaderId = $request->get('intHeaderId');
        $intLineId = $request->get('intLineId');
        $oldQtyReturned = $request->get('oldQtyReturned');
        $newQtyReturned = $request->get('newQtyReturned');
        $UserId = Auth::user()->UserID;

        $data = DB::connection('sqlsrv2')->select("EXEC usp_CU_IssueStockRecieve $intHeaderId, $intLineId, $oldQtyReturned,$newQtyReturned, $UserId");

        $jsonResponse = [
            'lines' => []
        ];

        foreach ($data as $row) {
            $jsonResponse['lines'][] = [
                'strPastelCode' => $row->strPastelCode,
                'strPastelDescription' => $row->strPastelDescription,
                'strReference' => $row->strReference,
                'dtmCreated' => $row->dtmCreated,
                'decAdjustmentQty' => $row->decAdjustmentQty,
                'strWarehouse' => $row->strWarehouse
            ];
        }

        return response()->json($data);

        // dd(json_encode($jsonResponse, JSON_PRETTY_PRINT));

        // $postAdjustment = $this->postInventoryAdjustment($data);

        // return response()->json($postAdjustment);
    }

    public function updateStockIssueType(Request $request)
    {
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'UPDATE';

        $response = DB::connection('sqlsrv3')->statement('spStockIssueTypesCRUD ?,?,?', [$ID, $Name, $Operation]);
        return response()->json($response);
    }

    public function deleteStockIssueType(Request $request)
    {
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'DELETE';

        $response = DB::connection('sqlsrv3')->statement('spStockIssueTypesCRUD ?,?,?', [$ID, $Name, $Operation]);
        return response()->json($response);
    }

    public function getIssuedStock(Request $request)
    {
        $data = DB::connection('sqlsrv2')->select('SELECT * FROM viewIssuedStock');
        return response()->json($data);
    }

    function postInventoryAdjustment($json)
    {
        $IP = env('FG_API_IP');
        $Key = env('FG_API_KEY');
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $IP.'InventoryAdjustment/V1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Key='.$Key
            ),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        dd($response);
    }

    // Upkeep API Integration Functions -----------------------------------------------------------------------------------------------
    public function getOpenUpkeepWorkOrders()
    {
        $curl = curl_init();

        $token = DB::connection('sqlsrv3')->table('tblHendokApiIntegration')->where('strHostName', 'Upkeep')->value('strSessionToken');

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.onupkeep.com/api/v2/work-orders?isComplete=0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Session-Token: ' . $token, 'Cookie: upkeepsess=' . $token],
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            // Handle cURL error
            $error = curl_error($curl);
            // Log or handle the error
            return []; // Return an empty array or handle the error differently
        }

        curl_close($curl);

        $result = json_decode($response, true);

        if ($result === null) {
            // Handle JSON decoding error
            $jsonError = json_last_error_msg();
            // Log or handle the error
            return []; // Return an empty array or handle the error differently
        }

        // Check if the expected structure exists in the result
        if (!isset($result['results'])) {
            // Handle unexpected response format
            return []; // Return an empty array or handle the error differently
        }

        $openWorkOrders = [];

        foreach ($result['results'] as $workOrder) {
            $openWorkOrders[] = $workOrder;
        }

        // dd($openWorkOrders);
        return $openWorkOrders;
    }

    public function getUpkeepJobAsset($ID)
    {
        $curl = curl_init();

        $token = DB::connection('sqlsrv3')->table('tblHendokApiIntegration')->where('strHostName', 'Upkeep')->value('strSessionToken');

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.onupkeep.com/api/v2/assets/' . $ID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Session-Token: ' . $token, 'Cookie: upkeepsess=' . $token],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);

        return $result;
    }

    public function getUpkeepJobLocation($ID)
    {
        $token = DB::connection('sqlsrv3')->table('tblHendokApiIntegration')->where('strHostName', 'Upkeep')->value('strSessionToken');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.onupkeep.com/api/v2/locations/' . $ID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Session-Token: ' . $token, 'Cookie: upkeepsess=' . $token],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);

        return $result;
    }

    // Upkeep API Integration Functions -----------------------------------------------------------------------------------------------

    private static function getTabs($tabcount)
    {
        $tabs = '';
        for ($i = 0; $i < $tabcount; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = [], $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach ($arr as $key => $val) {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= '<' . $element . '>';
            if (!is_array($val)) {
                $result .= $val;
            } else {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount + 1);
                $result .= $tabs;
            }
            $result .= '</' . $element . ">\r\n";
        }
        return $result;
    }

    public static function toxml($arr, $root = 'xml', $elements = [])
    {
        $result = '';
        $result .= '<' . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= '</' . $root . ">\r\n";
        return $result;
    }
}
