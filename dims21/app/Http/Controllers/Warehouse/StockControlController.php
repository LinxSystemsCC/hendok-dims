<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StockControlController extends Controller
{
    public function stockLocation(){
        $sageWarehouses = DB::connection('sqlsrv2')->select("SELECT Code, [Name] FROM [Hendok Distribution].dbo.WhseMst");
        $DCs = DB::connection('sqlsrv2')->select("SELECT intAutoId, strDCName FROM tblDCNames");
        return view('warehouse.stockcontrol.stockLocation')
            ->with('sageWarehouses', $sageWarehouses)
            ->with('DCs', $DCs);
    }

    public function getStockLocationSummary(Request $request){
        $intDCId = $request->get('intDCid');
        $data = DB::connection('sqlsrv2')->select("EXEC spGetStockSummary $intDCId");
        return response()->json($data);
    }

    public function getStockDetailsSummary(Request $request){
        $ItemCode = $request->get("ItemCode");
        $intDCId = $request->get('intDCid');
        $data = DB::connection('sqlsrv2')->select("EXEC spGetStockDetailSummary '$ItemCode', $intDCId");
        return response()->json($data);
    }

    public function stockAdjustment(){
        $products = DB::connection('sqlsrv2')->select("SELECT StockLink intStockLink, Code strPartNumber, Description_1 strPartDescription FROM tblSageFullStock");
        $dcs = DB::connection('sqlsrv2')->select("SELECT intAutoId intDcId, strDCName FROM tblDCNames");
        $locations = DB::connection('sqlsrv2')->select("SELECT intLocationNameId intLocationId, strLocationName FROM viewLocationNames");
        $bins = DB::connection('sqlsrv2')->select("SELECT intBinId, strBin FROM viewBinNames");
        
        return view('warehouse.stockcontrol.stockAdjustment')
            ->with('products', $products)
            ->with('dcs', $dcs)
            ->with('locations', $locations)
            ->with('bins', $bins);
    }


    public function ScanCode(){

        //stockLocation.blade
   // Fetching bin names from the viewBinNames table using sqlsrv2 connection
   $StockData = DB::connection('sqlsrv2')->table(table: 'viewBinNames')
   ->select('intBinId', 'strBin')
   ->get();

return view('warehouse.stockcontrol.StockScan', compact('StockData'));
    }

  
    public function storeScan(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
    
       // Validate input
                $request->validate([
                    'qr_code' => ['required', 'regex:/^\d+\|\d+$/'], // Any digits before and after "|", must have exactly one "|"
                    'bin_id' => 'required|integer',
                    'dtmItemScanned' => 'required|date'
                ]);
            // Get the correct user ID
            $userid = optional(Auth::user())->UserID ?? 0;  // Ensure it is not null
    
            // Debug User ID before inserting
            Log::info('Final User ID:', ['UserID' => $userid]);
    
            // Construct JSON Data as an array (NO `json_encode()` YET)
            $jsonData = [
                "Item" => $request->qr_code,
                "LocationFrom" => "0",
                "LocationTo" => $request->bin_id,
                "MoveType" => "Move",
                "UserId" => (int) $userid, // Ensure integer type
                "strUID" => (string) Str::uuid(),
                "dtmScanned" => now()->format("Y-m-d H:i:s"),
                "dtmItemScanned" => $request->dtmItemScanned
            ];
            Log::info('Received Request Data:', $request->all());

            // Debug JSON Data before inserting
            Log::info('Final JSON Data:', ['data' => $jsonData]);
    
            // Insert into Database (Laravel will automatically encode JSON correctly)
            DB::connection('sqlsrv2')->table('tblJsonDataStockMover')->insert([
                'strJsonData' => json_encode($jsonData), // Encode only once here
                'dteCreated' => now(),
                'intFlag' => 0
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Scan Insert Error: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
    public function getBinStockCount(Request $request){

        $intBinId = $request->get('intBinId');
        $intStockLink = $request->get('intStockLink');

        $data = DB::connection('sqlsrv2')->select("SELECT ISNULL((SELECT mnyOnHand FROM tblInventoryBin WHERE intBinId = $intBinId AND intStockLink = $intStockLink), 0) AS mnyOnHand");

        return response()->json($data);
    }

    public function processStockAdjustment(Request $request){
        $gridData = $request->get('gridData');
        $userId = Auth::user()->UserID;

        if (is_array($gridData)) {
            $xml = $this->toxml($gridData, "xml", array("result"));

            // dd("EXEC usp_C_processStockAdjustment '$xml', $userId");

            // Execute the stored procedure
            $response = DB::connection('sqlsrv2')->select("EXEC usp_C_processStockAdjustment '$xml', $userId");
        } else {
            $response = ['error' => 'Invalid grid data'];
        }

        return response()->json($response);
    }

    private static function getTabs($tabcount){
        $tabs = '';
        for ($i = 0; $i < $tabcount; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = array(), $tabcount = 0){
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

    public static function toxml($arr, $root = "xml", $elements = array()){
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }
}
