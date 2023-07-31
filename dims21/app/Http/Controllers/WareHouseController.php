<?php

/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 2018/11/21
 * Time: 15:25
 */

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class WareHouseController extends Controller
{
    public function createuserpage()
    {
        $groups = DB::connection('sqlsrv2')->select("select * from tblDIMSGROUPS");
        return view('warehouse/createuser')->with('groups', $groups);
    }

    public function createuser(Request $request)
    {
        $username =  $request->get("username");
        $email =  $request->get("email");
        $password =  $request->get("password");
        $groupID =  $request->get("groupID");
        $pincode =  $request->get("pincode");
        $tabletuser =  $request->get("tabletuser");
        $encrypted = bcrypt($password);

        $returnuser = DB::connection('sqlsrv2')
            ->select(
                'exec spCreateUsers ?,?,?,?,?,?,?',
                array($username, $email, $password, $groupID, $pincode, $tabletuser, $encrypted)
            );
        return response()->json($returnuser);
    }

    public function getusers()
    {
        $users = DB::connection('sqlsrv2')->select("EXEC spGetUsers ");
        return response()->json($users);
    }

    public function deleteUser(Request $request)
    {
        $ID = $request->get('ID');
        // dd($ID);
        $users = DB::connection('sqlsrv2')->select("EXEC spDisableUser ?", array($ID));
        return response()->json($users);
    }

    public function updateUser()
    {
        $users = DB::connection('sqlsrv2')->select("EXEC spUpdateUserInfo ");
        return response()->json($users);
    }

    public function getqc1()
    {
        $qc1 = DB::connection('sqlsrv2')->select("select * from viewQCPhase1Jobs");
        return response()->json($qc1);
    }

    public function getqc2()
    {
        $qc2 = DB::connection('sqlsrv2')->select("select * from viewQCPhase2Jobs");
        return response()->json($qc2);
    }

    public function getweigh()
    {
        $weigh = DB::connection('sqlsrv2')->select("select * from viewGalvWeigh");
        return response()->json($weigh);
    }

    public function getregrade()
    {
        $regrade = DB::connection('sqlsrv2')->select("select * from tblRegradeJobs");
        return response()->json($regrade);
    }

    public function getticketno(Request $request)
    {
        $customer = $request->get('customer');
        $product = $request->get('product');
        $ticket = DB::connection('sqlsrv2')->select("select TicketNo FROM tblCompletedJobs WHERE Customer = '" . $customer . "' and ProductName = '" . $product . "'");
        return response()->json($ticket);
    }

    public function getmasswmax(Request $request)
    {
        $ticket = $request->get('ticket');
        $mass = DB::connection('sqlsrv2')->select("select Weight FROM tblCompletedJobs WHERE TicketNo = '" . $ticket . "'");
        return response()->json($mass);
    }

    public function getSEno(Request $request)
    {
        $customer = $request->get('customer');
        $product = $request->get('product');
        $secode = DB::connection('sqlsrv2')->select("select SECode from tblProductsWmax where CustomerName = '" . $customer . "' and ProductName = '" . $product . "'");
        //dd($secode);
        return response()->json($secode);
    }

    public function getretest(Request $request)
    {
        $customer = $request->get('customer');
        $product = $request->get('product');
        $info = DB::connection('sqlsrv2')->select("select * from tblProductsWmax where CustomerName = '" . $customer . "' and ProductName = '" . $product . "'");
        //dd($info);
        return response()->json($info);
    }

    public function creategrouppage()
    {
        $groups = DB::connection('sqlsrv2')
            ->select("select * from tblDIMSGroups");
        return view('warehouse/creategroup')->with('groups', $groups);
    }

    public function warehouseInvetoryItems()
    {

        return view('dims/warehouse');
    }
    public function onOrderAdvanced()
    {

        $onorders = DB::connection('sqlsrv3')
            ->select("EXEC spOnOrderAdvanced ");
        return response()->json($onorders);
    }
    public function joblabelassign()
    {
        $userid =  Auth::user()->UserID;

        $returnmach = DB::connection('sqlsrv3')
            ->select(
                'exec spGetWarehousemachines ?',
                array($userid)
            );
        return view('warehouse/jobqrcode');
    }
    public function initiateproductonmachine()
    {
        $userid =  Auth::user()->UserID;

        $returnmach = DB::connection('sqlsrv3')->select('exec spGetProductByWarehouseDept ?', array($userid));
        return view('warehouse/initiateproducts');
    }
    public function createPalletConfig()
    {
        return view('warehouse/palletsconf');
    }
    public function areapage()
    {
        return view('warehouse/areas');
    }

    public function updateAreaName(Request $request)
    {
        $ID = $request->get('areaID');
        $Name = $request->get('areaName');
        $update = DB::connection('sqlsrv2')->select("exec spUpdateAreaName ?,?", array($ID, $Name));
        return response()->json($update);
    }

    public function deleteArea(Request $request)
    {
        $ID = $request->get('AreaID');
        $confirmation = DB::connection('sqlsrv2')->select("exec spDeleteArea ?", array($ID));
        return response()->json($confirmation);
    }

    public function labelspage()
    {
        $printers = DB::connection('sqlsrv2')->select("select * from tblPrinters");
        return view('warehouse/labels')->with("printers", $printers);
    }

    public function labelmapping()
    {
        $dept = DB::connection('sqlsrv2')->select("select * from tblDepartments");
        $label = DB::connection('sqlsrv2')->select("select * from tblPrinterLabels order by strLabelName");
        return view('warehouse/labelmapping')->with('dept', $dept)->with('label', $label);
    }

    public function getLabelInformation(Request $request)
    {
        $type = $request->get('type');
        $prompt = $request->get('prompt');

        $data = DB::connection('sqlsrv2')->select("exec spGetLabelInformation ?,?", array($type, $prompt));
        return response()->json($data);
    }

    public function genericproductlabels()
    {
        $dept = DB::connection('sqlsrv2')->select("select * from tblDepartments");
        $prodGroups = DB::connection('sqlsrv2')->select("select * from viewItemGroups order by ItemGroupDescription");

        return view('warehouse/genericproductlabels')->with('prodGroups', $prodGroups)->with('dept', $dept);
    }
    public function warehousepalletlabels()
    {
        $dept = DB::connection('sqlsrv2')->select("select * from tblDepartments");
        $prodGroups = DB::connection('sqlsrv2')->select("select * from viewItemGroups order by ItemGroupDescription");
        $scales = DB::connection('sqlsrv2')->select("exec spGetScalesByDeptName 'Warehouse'");
        $forklifts = DB::connection('sqlsrv2')->select("select * from viewTransitLocations");
        $areas = DB::connection('sqlsrv2')->select("select * from tblAreas");
        return view('warehouse/warehousepalletlabels')
            ->with('prodGroups', $prodGroups)
            ->with('dept', $dept)
            ->with('scales', $scales)
            ->with('forklifts', $forklifts)
            ->with('areas', $areas);
    }

    public function getproductbyjobid(Request $request)
    {

        $jobid = $request->get('jobid');
        $returndata = DB::connection('sqlsrv2')->select('exec spGetProductInformationBasedJobID ?', array($jobid));

        return response()->json($returndata);
    }

    public function printgenericpalletlabel(Request $request)
    {
        $dept = $request->get('dept');
        $prodcat = $request->get('prodcat');
        $prodname = $request->get('prodname');
        $palletconfid = $request->get('palletconfid');
        $qty = $request->get('qty');
        $weight = $request->get('weight');
        $barcode = $request->get('barcode');
        $operator = Auth::user()->UserName;
        $drivername = $request->get('drivername');
        $forkliftnumber = $request->get('forkliftnumber');
        $area = $request->get('area');
        $returndata = DB::connection('sqlsrv2')->select('exec spInsertPrintForPalletLabels ?,?,?,?,?,?,?,?,?,?,?', array($dept, $prodcat, $prodname, $palletconfid, $qty, $weight, $barcode, $operator, $drivername, $forkliftnumber, $area));

        return response()->json($returndata);
    }

    public function getMainWarehouseReport(Request $request)
    {
        $report = DB::connection('sqlsrv2')->select("SELECT * FROM viewMainWarehouseMovements ORDER BY intMoveId DESC");
        // dd($report);
        return response()->json($report);
    }

    public function getMainWarehouseReportByDate(Request $request)
    {
        $datefrom = $request->get('datefrom');
        $dateto = $request->get('dateto');
        $report = DB::connection('sqlsrv2')->select("EXEC spGetMainWarehouseMovementsByDate ?,?", array($datefrom, $dateto));
        // dd($report);
        return response()->json($report);
    }

    public function recievingwarehousereport()
    {
        return view('warehouse/recievingwarehousereport');
    }

    public function getProductInfo(Request $request)
    {
        $productCode = $request->get("productCode");
        $barcode = DB::connection('sqlsrv2')->select("exec spGetProductInformationBasedProductCode '$productCode'");
        // dd($barcode);
        return response()->json($barcode);
    }
    public function getProductInfoAppend(Request $request)
    {
        $productCode = $request->get("productCode");
        $appendinfo = DB::connection('sqlsrv2')->select("exec spGetPalletSizesPerProduct '$productCode'");
        // dd($barcode);
        return response()->json($appendinfo);
    }

    public function getProductBarcode(Request $request)
    {
        $productCode = $request->get("productCode");
        $barcode = DB::connection('sqlsrv2')->select("select BarCode from viewProductBarcode where PastelCode = '$productCode'");
        // dd($barcode);
        return response()->json($barcode);
    }

    public function getGalvWIPConsolidated()
    {
        $consolidatedgalvwip = DB::connection('sqlsrv2')->select("exec spConsolidatedGalvWIP");
        return response()->json($consolidatedgalvwip);
    }

    public function changeGalvJobStatus(Request $request)
    {
        $JobId = $request->get("JobId");
        $response = DB::connection('sqlsrv2')->select("exec spCompleteGalvJob ?", array($JobId));
        return response()->json($response);
    }

    public function checkForGalvUpdates(Request $request)
    {
        $checker = $request->get("checker");
        $response = DB::connection('sqlsrv2')->select("exec spCheckForGalvUpdates ?", array($checker));
        return response()->json($response);
    }

    public function deleteGalvChecker(Request $request)
    {
        $checker = $request->get("checker");
        $response = DB::connection('sqlsrv2')->select("exec spDeleteGalvChecker ?", array($checker));
        return response()->json($response);
    }

    public function printgenericlabel(Request $request)
    {
        $department = $request->get("department");
        $category = $request->get("category");
        $product = $request->get("product");
        $qty = $request->get("qty");
        $barcode = $request->get("barcode");
        $operator = Auth::user()->UserName;

        //dd($product,$category,$department,$qty);

        $returndata = DB::connection('sqlsrv2')->select('exec spInsertPrintForGenericLabels ?,?,?,?,?,?', array($product, $category, $department, $qty, $operator, $barcode));

        return response()->json($returndata);
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


    public function modifyuserleaderpage()
    {
        $baseusers = DB::connection('sqlsrv2')->select("Select * from tblDimsusers");
        $teamleaders = DB::connection('sqlsrv2')->select("Select * from tblDimsusers where strPickingTeams='TeamLeader'");
        return view('warehouse/modifyleaderusers')->with('teamleaders', $teamleaders)->with('baseusers', $baseusers);
    }
    public function modifyuserleader(Request $request)
    {
        $userid = $request->get('userid');
        DB::Connection('sqlsrv2')->statement("update tbldimsusers set strpickingteams='TeamLeader' where UserID =" . $userid . "");
    }
    public function deleteuserleader(Request $request)
    {
        $userid = $request->get('userid');
        DB::Connection('sqlsrv2')->statement("update tbldimsusers set strpickingteams='' where UserID =" . $userid . "");
    }

    public function userpermissions($userid)
    {
        $permissions = DB::connection('sqlsrv2')->select("select * from viewUserPermissions Where UserID =" . $userid . " and allowView <> 0");
        $username = DB::connection('sqlsrv2')->select("select UserName from tbldimsusers Where UserID =" . $userid . "");

        //dd($tableCols);

        if (count($permissions) == 0)
            DB::connection('sqlsrv2')->statement('exec spInsertUserPermissions ?', array($userid));

        DB::connection('sqlsrv2')->statement('exec spCheckUserPermissions ?', array($userid));

        //dd($userid);        
        return view('warehouse/userpermissions')->with("username", $username)->with("id", $userid)->with("permissions", $permissions);
    }


    public function getUpliftmentPage()
    {

        $companies = DB::connection('sqlsrv2')->select("select * from vwtblCompanies");
        $products = DB::connection('sqlsrv2')->select("select * from viewTblProductWeightedCalc");

        return view('warehouse/upliftments')->with('companies', $companies)->with('products', $products);
    }
    public function getUpliftmentDetails(Request $request)
    {
        $upliftmentNumber = $request->get('upliftmentNumber');

        $upliftdetails = DB::connection('sqlsrv2')->select("exec spGetUpliftmentDetails ?", array($upliftmentNumber));
        return response()->json($upliftdetails);
    }
    public function deleteUpliftmentPost(Request $request)
    {

        $UserID = Auth::user()->UserID;
        $intUpliftmentNumber = $request->get('intUpliftmentNumber');

        DB::connection('sqlsrv2')->statement('exec spUpliftmentDelete ?,?', array($intUpliftmentNumber, $UserID));
    }

    public function completeUpliftmentPost(Request $request)
    {

        $UserID = Auth::user()->UserID;
        $intUpliftmentNumber = $request->get('SelectedUpliftmentNumber');

        DB::connection('sqlsrv2')->statement('exec spUpliftmentComplete ?,?', array($intUpliftmentNumber, $UserID));
    }
    public function printUpliftmentPost(Request $request)
    {

        $UserID = Auth::user()->UserID;
        $intUpliftmentNumber = $request->get('SelectedUpliftmentNumber');

        DB::connection('sqlsrv2')->statement('exec spUpliftmentPrint ?,?', array($intUpliftmentNumber, $UserID));
    }

    public function denyUpliftmentPost(Request $request)
    {

        $UserID = Auth::user()->UserID;
        $intUpliftmentNumber = $request->get('SelectedUpliftmentNumber');

        DB::connection('sqlsrv2')->statement('exec spUpliftmentDeny ?,?', array($intUpliftmentNumber, $UserID));
    }
    public function upliftImageGetter($upliftmentnumber)
    {

        $returndata = DB::connection('sqlsrv2')->select("select image from tblUpliftmentPhotos where intUpliftment = " . $upliftmentnumber);
        foreach ($returndata as $row) {
            $base64Image = hex2bin($row->image);

            // Get the MIME type of the image from the base64-encoded string
            $finfo = finfo_open();
            $mimeType = finfo_buffer($finfo, $base64Image, FILEINFO_MIME_TYPE);
            finfo_close($finfo);

            // Generate the appropriate data URI scheme based on the MIME type of the image
            switch ($mimeType) {
                case 'image/png':
                    $uriScheme = 'data:image/png;base64,';
                    break;
                case 'image/jpeg':
                    $uriScheme = 'data:image/jpeg;base64,';
                    break;
                case 'image/gif':
                    $uriScheme = 'data:image/gif;base64,';
                    break;
                    // Add cases for other supported image formats here
                default:
                    $uriScheme = 'data:image/bmp;base64,';
                    break;
            }

            // Prefix the base64-encoded string with the appropriate data URI scheme
            $dataURI = $uriScheme . base64_encode($base64Image);

            // Replace the binary image data with the data URI in the row object
            $row->image = $dataURI;
        }
        return view('warehouse/upliftmentimagepage')->with('imagedata', $returndata);
    }
    public function upliftEnquiry($upliftmentID)
    {

        $upliftheaderdetails = DB::connection('sqlsrv2')->select("exec spGetUpliftmentEnquiryDetails ?", array($upliftmentID));

        $upliftmakerdata = DB::connection('sqlsrv2')->select("exec spGetUpliftmentEnquiryHistory ?", array($upliftmentID));
        return view('warehouse/upliftmentenquirypage')->with('upliftmakerdata', $upliftmakerdata)->with('headerdetails', $upliftheaderdetails);
    }
    public function upliftmentBacklog($upliftmentID)
    {

        $upliftbacklogdetails = DB::connection('sqlsrv2')->select("exec spGetUpliftmentBacklog ?", array($upliftmentID));

        return view('warehouse/upliftmentbacklog')->with('upliftbacklogdetails', $upliftbacklogdetails);
    }

    public function upliftmentMessagePost(Request $request)
    {
        $upliftmentNumber = $request->get('upliftmentNumber');
        $upliftmentMessage = $request->get('upliftmentMessage');

        $UserID = Auth::user()->UserID;

        DB::connection('sqlsrv2')->statement("exec spPostUpliftmentMessage ?,?,?", array($upliftmentNumber, $upliftmentMessage, $UserID));
    }
    public function getUpliftmentRecords()
    {

        $returndata = DB::connection('sqlsrv2')->select("select * from viewtblUpliftmentData");
        return response()->json($returndata);
    }
    public function getUpliftmentPrintPDFEmbed($upliftmentnumber)
    {
        $returndata = DB::connection('sqlsrv2')->select("exec spRetrieveDocumentUpliftment ? ",array($upliftmentnumber));
        foreach ($returndata as $row) {
            $base64Image = ($row->image);
            
            // Generate the appropriate data URI scheme based on the MIME type of the image
                    $uriScheme = 'data:application/pdf;base64,';

            // Prefix the base64-encoded string with the appropriate data URI scheme
            $dataURI = $uriScheme . base64_encode($base64Image);

            // Replace the binary image data with the data URI in the row object
            $row->image = $dataURI;
        }
        return view('warehouse/upliftmentpdfpage')->with('imagedata', $returndata);
    }
    public function insertUpliftmentAll(Request $request)
    {
        $file = $request->file('file1');

        if ($request->hasFile('file1') && $file->isValid()) {
            $varbinaryData = $file->get();
            $hexString1 = bin2hex($varbinaryData);
        } else {
            $hexString1 = null;
        }

        $file = $request->file('file2');

        if ($request->hasFile('file2') && $file->isValid()) {
            $varbinaryData = $file->get();
            $hexString2 = bin2hex($varbinaryData);
        } else {
            $hexString2 = null;
        }

        $file = $request->file('file3');

        if ($request->hasFile('file3') && $file->isValid()) {
            $varbinaryData = $file->get();
            $hexString3 = bin2hex($varbinaryData);
        } else {
            $hexString3 = null;
        }


        $dataxml = $request->input('dataxml');

        $UserID = Auth::user()->UserID;
        $invoice = $request->input('invoice');
        $reasonpickup = $request->input('reasonpickup');
        $area = $request->input('area');
        $address = $request->input('address');
        $customers = $request->input('customers');
        $company = $request->input('company');
        $date = $request->input('date');
        $date = (new \DateTime($date))->format('Y-m-d');
        $upliftmentaction = $request->input('upliftmentaction');
        $upliftreason = $request->input('upliftreason');

        DB::connection('sqlsrv2')->statement("exec spInsertUpliftmentAll ?,?,?,?,?,?,?,?,?,?,?,?,?,?", array($dataxml, $date, $address, $area, $company, $customers, $invoice, $upliftmentaction, $reasonpickup, $upliftreason, $hexString1, $hexString2, $hexString3, $UserID));
    }
    public function updateUpliftmentPost(Request $request)
    {
        $file = $request->file('file1');

        if ($request->hasFile('file1') && $file->isValid()) {
            $varbinaryData = $file->get();
            $hexString1 = bin2hex($varbinaryData);
        } else {
            $hexString1 = null;
        }

        $file = $request->file('file2');

        if ($request->hasFile('file2') && $file->isValid()) {
            $varbinaryData = $file->get();
            $hexString2 = bin2hex($varbinaryData);
        } else {
            $hexString2 = null;
        }

        $file = $request->file('file3');

        if ($request->hasFile('file3') && $file->isValid()) {
            $varbinaryData = $file->get();
            $hexString3 = bin2hex($varbinaryData);
        } else {
            $hexString3 = null;
        }

        $dataxml = $request->input('dataxml');

        $UserID = Auth::user()->UserID;
        $invoice = $request->input('invoice');
        $reasonpickup = $request->input('reasonpickup');
        $area = $request->input('area');
        $address = $request->input('address');
        $customers = $request->input('customers');
        $company = $request->input('company');
        $date = $request->input('date');
        $date = (new \DateTime($date))->format('Y-m-d');
        $upliftmentaction = $request->input('upliftmentaction');
        $upliftreason = $request->input('upliftreason');
        $SelectedUpliftmentNumber = $request->input('SelectedUpliftmentNumber');

        DB::connection('sqlsrv2')->statement("exec spUpdateUpliftmentAll ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?", array($dataxml, $date, $address, $area, $company, $customers, $invoice, $upliftmentaction, $reasonpickup, $upliftreason, $hexString1, $hexString2, $hexString3, $UserID, $SelectedUpliftmentNumber));
    }
    public function approveUpliftmentPost(Request $request)
    {

        $SelectedUpliftmentNumber = $request->input('SelectedUpliftmentNumber');
        $UserID = Auth::user()->UserID;

        DB::connection('sqlsrv2')->statement("exec spApproveUpliftment ?,?", array($SelectedUpliftmentNumber, $UserID));
    }
    public function getCustomerForSelectedCompany(Request $request)
    {


        $company = $request->get("company");
        $customers = DB::connection('sqlsrv2')->select("exec spGetCustomersCompanyName ?", array($company));
        return response()->json($customers);
    }
    public function getAreaAddressInvoiceInfoParam(Request $request)
    {

        $Customer = $request->get('customer');
        $company = $request->get('company');
        $addresses = DB::connection('sqlsrv3')
            ->select(
                " Exec spReturnCustomerAddressList ?,?",
                array($Customer, $company)
            );
        $areas = DB::connection('sqlsrv3')
            ->select(
                " Exec spReturnAreaCustomer ?,?",
                array($Customer, $company)
            );

        $routes = DB::connection('sqlsrv3')->select("select * from viewEvolutionGridAreas where company = '" . $company . "'");

        $invoices = DB::connection('sqlsrv3')
            ->select(
                " Exec spReturnCustomerInvoiceList ?,?",
                array($Customer, $company)
            );

        $i = 0;

        $output = array();
        $output2 = array();
        $output3 = array();
        $output4 = array();

        foreach ($areas as $val) {
            $output[$i]['Route'] = $val->Route;

            $i++;
        }
        $i = 0;
        foreach ($addresses as $val) {
            $output2[$i]['strAddress'] = $val->strAddress;

            $i++;
        }
        $i = 0;
        foreach ($invoices as $val) {
            $output3[$i]['InvNumber'] = $val->InvNumber;

            $i++;
        }
        $i = 0;
        foreach ($routes as $val) {
            $output4[$i]['Route'] = $val->Route;

            $i++;
        }
        $results['areas'] = $output;
        $results['addresses'] = $output2;
        $results['invoices'] = $output3;
        $results['routes'] = $output4;
        return $results;
    }
    public function aauptest($userid)
    {

        return view('warehouse/aauptest')->with("id", $userid);
    }

    public function xmlUserGridPermsPost(Request $request)
    {

        $UserID = $request->get("UserID");
        $gridResult = $request->get("gridResult");
        DB::connection('sqlsrv2')->statement("exec spUpdateUserPermissionsXML ?,?", array($UserID, $gridResult));
    }

    public function galvcustomer()
    {
        return view('warehouse/galvcustomers');
    }

    public function galvcreateprodspec()
    {
        $customers = DB::connection('sqlsrv2')->select("select * from tblCustomersWmax");
        $products = DB::connection('sqlsrv2')->select("select * from tblProductsWmax");
        return view('warehouse/galvcreateprodspec')->with('customers', $customers);
    }

    public function galveditprodspec()
    {
        $customers = DB::connection('sqlsrv2')->select("select * from tblCustomersWmax");
        $products = DB::connection('sqlsrv2')->select("select * from tblProductsWmax");
        return view('warehouse/galveditprodspec')->with('customers', $customers);
    }

    public function galvscale()
    {
        $dept = DB::connection('sqlsrv2')->select("select * from tblDepartments");
        return view('warehouse/galvscales')->with('departments', $dept);
    }

    public function qc1()
    {
        return view('warehouse/qc1');
    }

    public function qc2()
    {
        return view('warehouse/qc2');
    }

    public function wmaxweigh()
    {
        $scales = DB::connection('sqlsrv2')->select("exec spGetScalesByDeptName 'Galv Line 1 and 2'");
        return view('warehouse/wmaxweigh')->with('scales', $scales);
    }

    public function wmaxscrap()
    {
        return view('warehouse/wmaxscrap');
    }

    public function wmaxregrade()
    {
        $customers = DB::connection('sqlsrv2')->select("select * from tblCustomersWmax ");
        $products = DB::connection('sqlsrv2')->select("select * from tblProductsWmax ");
        return view('warehouse/wmaxregrade')->with('customers', $customers)->with('products', $products);
    }

    public function wmaxstockchange()
    {

        $customers = DB::connection('sqlsrv2')->select("select * from tblCustomersWmax");
        $products = DB::connection('sqlsrv2')->select("select * from tblProductsWmax");
        return view('warehouse/wmaxstockchange')->with('customers', $customers)->with('products', $products);
    }

    public function wmaxretest()
    {
        $scales = DB::connection('sqlsrv2')->select("select * From tblScales");
        $customers = DB::connection('sqlsrv2')->select("select * from tblCustomersWmax ");

        return view('warehouse/wmaxretest')->with('customers', $customers)->with('scales', $scales);
    }

    public function dashboard()
    {
        if (Auth::guest())
            return redirect()->route('login');
        else{
            $sessionUserId = Auth::user()->UserID;
            $GroupId= Auth::user()->GroupId;
                
            if($this->getThings($GroupId,'Has Auto Redirect')){
                $userDepartment =Auth::user()->strPickingTeams;
                $departmentMachines = explode('|', $userDepartment);

                $deptartmentID = DB::connection('sqlsrv2')->select("select intAutoID from tblDepartments where strDeptName = '".$departmentMachines[0]."'");

                $machineID = DB::connection('sqlsrv2')->select("select intAutoMachineID from tblMachines where strMachineName = '".$departmentMachines[1]."'");
                
                return redirect('/printpalletchoosproducttomake/'.$deptartmentID[0]->intAutoID.'/'.$machineID[0]->intAutoMachineID);
            }else{
                return view('warehouse/dashboard');
            }
        }
    }

    public function getThings($GroupId,$thing)
    {
        $things = 0;

        //$GroupId = Auth::user()->GroupId;
        $returnTrueOrFalse = DB::connection('sqlsrv3')
            ->select("select [dbo].[fnGetGroupThings](".$GroupId.",'".$thing."',0) as things");
        foreach ($returnTrueOrFalse as $val)
        {
            $things =  $val->things;
        }
        return $things;
    }

    public function departmentpage()
    {
        return view('warehouse/departments');
    }
    public function machinespage()
    {
        return view('warehouse/machines');
    }
    public function location()
    {
        $LocationTypes = DB::connection('sqlsrv2')
            ->select("select * from tblLocationTypes");
        $getBinLevel = DB::connection('sqlsrv2')
            ->select('Select * from tblBinLevel');

        $getBinRows = DB::connection('sqlsrv2')
            ->select('Select * from tblBinRows');

        $getLocations = DB::connection('sqlsrv2')
            ->select('Select * from tblLocationNames order by strLocationName');
        return view('warehouse/locations')->with('locationtypes', $LocationTypes)
            ->with('binrows', $getBinRows)
            ->with('locations', $getLocations)
            ->with('binlevel', $getBinLevel);
    }
    public function qrcodeimage($binlocation)
    {
        return view('warehouse/qrcodeimagebin')->with('ID', $binlocation);
    }
    public function qrcodereversepallet()
    {
        return view('warehouse/palletreverseqrcode');
    }
    public function qrcodebreakpallet()
    {
        return view('warehouse/palletbreak');
    }
    public function savenewbin(Request $request)
    {

        $binname = $request->get("binname");
        $intRowNumber = $request->get("intRowNumber");
        $intLevelNumber = $request->get("intLevelNumber");
        $locations = $request->get("locations");
        DB::connection('sqlsrv2')->table('tblBinNames')->insert(
            ['strBin' => $binname, 'intRowNumber' => $intRowNumber, 'intLevelNumber' => $intLevelNumber, 'intLocationId' => $locations]
        );
    }
    public function getLocationNamesAndTypes()
    {
        $locationname = DB::connection('sqlsrv2')
            ->select("select * from tblLocationNames inner join tblLocationTypes on tblLocationNames.intLocationTypeId = tblLocationTypes.intLocationTypeId  order by intLocationNameId ");

        $LocationTypes = DB::connection('sqlsrv2')
            ->select("select * from tblLocationTypes");

        $outPut["locationname"] = $locationname;
        $outPut["locationtypes"] = $LocationTypes;
        return response()->json($outPut);
    }
    public function createjobs()
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        $prodGroups = DB::connection('sqlsrv2')
            ->select("select * from viewItemGroups order by ItemGroupDescription");
        return view('warehouse/createjobs')->with('prodGroups', $prodGroups)->with('dept', $dept);
    }
    public function roofworkorders()
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        $prodGroups = DB::connection('sqlsrv2')
            ->select("select * from viewItemGroups order by ItemGroupDescription");

        $machines = DB::connection('sqlsrv2')->select("select * from viewRoofingMachines");
        // $machines = json_encode($machines);
        // dd($machines);

        return view('warehouse/roofworkorders')->with('machines', $machines);
    }

    public function getRoofingSalesOrders()
    {
        $salesOrders = DB::connection('sqlsrv2')
            ->select('EXEC spGetRoofingSalesOrdersToPlan');
        return response()->json($salesOrders);
    }

    public function getBinLocationsJson()
    {
        $getBins = DB::connection('sqlsrv2')
            ->select('Select * from tblBinNames n inner join tblLocationNames l on n.intLocationId = l.intLocationNameId');
        return response()->json($getBins);
    }
    public function getProdCategory(Request $request)
    {
        $ItemGroup = $request->get("ItemGroup");
        $strProductCategory = $request->get("strProductCategory");
        $prodCategory = DB::connection('sqlsrv2')
            ->select("select * from viewItemCategory where ItemGroup ='" . $ItemGroup . "' and strProductCategory='" . $strProductCategory . "' order by strProductCategory");
        return response()->json($prodCategory);
    }


    public function saveLocationType(Request $request)
    {
        $locationtype = $request->get("locationtype");

        $result = DB::connection('sqlsrv3')->table('tblLocationTypes')->insert(
            ['strLocationType' => $locationtype]
        );
        return response()->json($result);
    }
    public function saveLocationName(Request $request)
    {
        $locationtype = $request->get("locationtypeid");
        $strLocationName = $request->get("strLocationName");

        $result = DB::connection('sqlsrv3')->table('tblLocationNames')->insert(
            ['strLocationName' => $strLocationName, 'intLocationTypeId' => $locationtype]
        );
        return response()->json($result);
    }

    public function savepermissions(Request $request)
    {
        $UserID = $request->get("UserID");
        $permissions = $request->get("CheckBoxes");
        //dd($UserID);
        // dd($permissions);
        DB::connection('sqlsrv2')->statement("update tblDIMSUserPermissions set Selected = 0 where UserID = " . $UserID);

        foreach ($permissions as $permission)
            // dump($permission);
            $returndata = DB::connection('sqlsrv2')->statement('exec spUpdateUserPermissions ?,?', array($UserID, $permission));


        return response()->json($returndata);
    }



    public function getDepListToPlan(Request $request)
    {
        $ItemGroup = $request->get("ItemGroup");
        //$getUserByEmail = DB::select('SELECT * FROM users WHERE email = ?' , ['useremailaddress@email.com']);
        $strProductCategory = $request->get("strProductCategory");

        $prodCategory = DB::connection('sqlsrv2')->select("exec spGetDeptCategoryGroup ?", array($ItemGroup));
        //dd($prodCategory);

        return response()->json($prodCategory);
    }

    public function getProdListToPlan(Request $request)
    {
        $ItemGroup = $request->get("ItemGroup");
        //dd($ItemGroup);
        $strProductCategory = $request->get("strProductCategory");
        $prodCategory = DB::connection('sqlsrv2')
            ->select("select * from viewItemsToPlanJob where ItemGroup ='" . $ItemGroup . "' order by strItemName");
        //dd($prodCategory);
        return response()->json($prodCategory);
    }

    public function getsalesorderstoplan(Request $request)
    {
        $productname = $request->get("productname");
        $salesorders = DB::connection('sqlsrv2')->select("select * from [viewRoofingOrderLines] rl inner join tblRoofingSONumToPlan rp on rp.strSONum = rl.idInvoiceLines where Description_1 ='" . $productname . "'");
        //dd($salesorders);
        return response()->json($salesorders);
    }

    public function getqc1comments(Request $request)
    {
        $comments = DB::connection('sqlsrv2')->select("select * from tblQCPhase1Remarks");
        //dd($comments);

        return response()->json($comments);
    }

    public function getqc2comments(Request $request)
    {
        $comments = DB::connection('sqlsrv2')->select("select * from tblQCPhase2Remarks");
        //dd($comments);

        return response()->json($comments);
    }

    public function qc1pf(Request $request)
    {
        $Reference = $request->get("Reference");
        $CustomerName = $request->get("CustomerName");
        $ProductName = $request->get("ProductName");
        $DepartmentName = $request->get("DepartmentName");
        $MachineName = $request->get("MachineName");
        $JobNo = $request->get("JobNo");
        $WireSize = $request->get("WireSize");
        $MassRequired = $request->get("MassRequired");
        $testNo = $request->get("testNo");
        $zincTested = $request->get("zincTested");
        $mpaTested = $request->get("mpaTested");
        $castNo = $request->get("castNo");
        $wireSizeTested = $request->get("wireSizeTested");
        $stressTest = $request->get("stressTest");
        $elongBreakTest = $request->get("elongBreakTest");
        $torsionTest = $request->get("torsionTest");
        $wrapTest = $request->get("wrapTest");
        $coating = $request->get("coating");
        $comment1 = $request->get("comment1");
        $testpf = $request->get("testpf");
        $massProduced = $request->get("massProduced");
        $zincInitialMass = $request->get("zincInitialMass");
        $zincStripMass = $request->get("zincStripMass");
        $zincStripSize = $request->get("zincStripSize");
        $operator = Auth::user()->UserName;
        $comment2 = $request->get("comment2");
        $comment3 = $request->get("comment3");

        // dd($Reference, $CustomerName, $ProductName, $DepartmentName, $MachineName, $JobNo, $WireSize, $MassRequired, $testNo, $zincTested, $mpaTested, $castNo, $wireSizeTested, $stressTest, $elongBreakTest, $torsionTest, $wrapTest, $coating, $comment1, $testpf, $massProduced, $zincInitialMass, $zincStripMass, $zincStripSize, $operator, $comment2, $comment3);

        $testQC1 = DB::connection('sqlsrv2')->select(
            'exec spInsertIntoPicking ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array(
                $Reference, $CustomerName, $ProductName, $DepartmentName, $MachineName, $JobNo, $WireSize, $MassRequired, $testNo, $zincTested, $mpaTested, $castNo, $wireSizeTested, $stressTest, $elongBreakTest, $torsionTest, $wrapTest, $coating, $comment1, $testpf, $massProduced, $zincInitialMass, $zincStripMass, $zincStripSize, $operator, $comment2, $comment3
            )
        );

        return response()->json($testQC1);
    }

    public function qc2pf(Request $request)
    {
        $Reference = $request->get("Reference");
        $CustomerName = $request->get("CustomerName");
        $ProductName = $request->get("ProductName");
        $DepartmentName = $request->get("DepartmentName");
        $MachineName = $request->get("MachineName");
        $JobNo = $request->get("JobNo");
        $WireSize = $request->get("WireSize");
        $MassRequired = $request->get("MassRequired");
        $zincTested = $request->get("zincTested");
        $mpaTested = $request->get("mpaTested");
        $castNo = $request->get("castNo");
        $wireSizeTested = $request->get("wireSizeTested");
        $stressTest = $request->get("stressTest");
        $elongBreakTest = $request->get("elongBreakTest");
        $torsionTest = $request->get("torsionTest");
        $wrapTest = $request->get("wrapTest");
        $coating = $request->get("coating");
        $comment1 = $request->get("comment1");
        $massProduced = $request->get("massProduced");
        $zincInitialMass = $request->get("zincInitialMass");
        $zincStripMass = $request->get("zincStripMass");
        $zincStripSize = $request->get("zincStripSize");
        $operator = Auth::user()->UserName;
        $comment2 = $request->get("comment2");
        $comment3 = $request->get("comment3");
        $seqNo = $request->get("seqNo");
        $tensile = $request->get("tensile");
        $buttonMethod = $request->get("buttonMethod");
        $weight = '';
        $grossMass = 0;
        $tareMass = 0;

        //dd($Reference, $CustomerName, $ProductName, $DepartmentName, $MachineName, $JobNo, $WireSize, $MassRequired, $zincTested, $mpaTested, $castNo, $wireSizeTested, $stressTest, $elongBreakTest, $torsionTest, $wrapTest, $coating, $comment1, $massProduced, $zincInitialMass, $zincStripMass, $zincStripSize, $operator, $comment2, $comment3, $seqNo, $tensile, $buttonMethod, $weight, $grossMass, $tareMass);

        $testQC2 = DB::connection('sqlsrv2')->select(
            'exec spPassOrFailQCPhase2 ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array(
                $Reference, $CustomerName, $ProductName, $DepartmentName, $MachineName, $JobNo, $WireSize, $MassRequired, $zincTested, $mpaTested, $castNo, $wireSizeTested, $stressTest, $elongBreakTest, $torsionTest, $wrapTest, $coating, $comment1, $massProduced, $zincInitialMass, $zincStripMass, $zincStripSize, $operator, $comment2, $comment3, $seqNo, $tensile, $buttonMethod, $weight, $grossMass, $tareMass
            )
        );

        return response()->json($testQC2);
    }

    public function acceptholdweigh(Request $request)
    {
        $ref = $request->get("ref");
        $custnum = $request->get("custnum");
        $prod = $request->get("prod");
        $dept = $request->get("dept");
        $machine = $request->get("machine");
        $jobnum = $request->get("jobnum");
        $massProduced = $request->get("netmass");
        $zinc = $request->get("zinc");
        $mpa = $request->get("mpa");
        $castno = $request->get("castno");
        $wire = $request->get("wire");
        $passFail = 'P';
        $operator = Auth::user()->UserName;
        $sequm = $request->get("sequm");
        $tensile = $request->get("tensile");
        $netmass = $request->get("netmass");
        $GrossMass = $request->get("GrossMass");;
        $taremass = $request->get("taremass");;
        $buttonMethod = $request->get("buttonMethod");;

        //dd($ref, $custnum, $prod, $dept, $machine, $jobnum, $massProduced,$zinc, $mpa, $castno, $wire, $passFail, $operator,$sequm, $tensile, $netmass, $GrossMass, $taremass, $buttonMethod);

        $weigh = DB::connection('sqlsrv2')->select(
            'exec spWeighAcceptHold ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array(
                $ref, $custnum, $prod, $dept, $machine, $jobnum, $massProduced, $zinc, $mpa, $castno, $wire, $passFail, $operator, $sequm, $tensile, $netmass, $GrossMass, $taremass, $buttonMethod
            )
        );

        return response()->json($weigh);
    }

    public function regradeproduct(Request $request)
    {
        $ref = $request->get("ref");
        $custnum = $request->get("custnum");
        $prod = $request->get("prod");
        $dept = $request->get("dept");
        $machine = $request->get("machine");
        $jobnum = $request->get("jobnum");
        $zinc = $request->get("zinc");
        $mpa = $request->get("mpa");
        $wire = $request->get("wire");
        $operator = Auth::user()->UserName;
        $sequm = $request->get("sequm");
        $tensile = $request->get("tensile");
        $custnumfrom = $request->get("custnumfrom");
        $prodfrom = $request->get("prodfrom");


        //dd($ref, $custnum, $prod, $dept, $machine, $jobnum, $zinc, $mpa, $wire, $operator, $sequm, $tensile, $custnumfrom, $prodfrom);

        $regrade = DB::connection('sqlsrv2')->select(
            'exec spRegrades ?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array(
                $ref, $custnum, $prod, $dept, $machine, $jobnum, $zinc, $mpa, $wire, $operator, $sequm, $tensile, $custnumfrom, $prodfrom
            )
        );

        return response()->json($regrade);
    }

    public function savestockchangewmax(Request $request)
    {
        $newcustname = $request->get("newcustname");
        $newprodname = $request->get("newprodname");;
        $mass = $request->get("mass");
        $operator = Auth::user()->UserName;
        $ticketNo = $request->get("ticketNo");
        $SENo = $request->get("SENo");

        //dd($newcustname, $newprodname, $mass, $operator, $ticketNo, $SENo);

        $change = DB::connection('sqlsrv2')->select(
            'exec spStockChange ?,?,?,?,?,?',
            array($newcustname, $newprodname, $mass, $operator, $ticketNo, $SENo)
        );

        return response()->json($change);
    }

    public function saveretest(Request $request)
    {
        $custname = $request->get("custname");
        $prodname = $request->get("prodname");
        $zincTested = $request->get("zincTested");
        $MPATested = $request->get("MPATested");
        $wireSize = $request->get("wireSize");
        $remark = $request->get("remark");
        $operator = Auth::user()->UserName;
        $tensileTicket = $request->get("tensileTicket");
        $grossmass = $request->get("grossmass");
        $taremass = $request->get("taremass");
        $finalmass = $request->get("finalmass");

        //dd($custname, $prodname, $zincTested, $MPATested, $wireSize, $remark, $operator, $tensileTicket, $grossmass, $taremass, $finalmass);

        $retest = DB::connection('sqlsrv2')->select(
            'exec Retest ?,?,?,?,?,?,?,?,?,?,?',
            array(
                $custname, $prodname, $zincTested, $MPATested, $wireSize, $remark, $operator, $tensileTicket, $grossmass, $taremass, $finalmass
            )
        );

        return response()->json($retest);
    }

    public function addproductspec(Request $request)
    {
        $cutomername = $request->get("cutomername");
        $productname = $request->get("productname");
        $productapplication = $request->get("productapplication");
        $roddiameter = $request->get("roddiameter");
        $rodgrade = $request->get("rodgrade");
        $rodtreatment = $request->get("rodtreatment");
        $diametergalvwire = $request->get("diametergalvwire");
        $diametertolerancemin = $request->get("diametertolerancemin");
        $diametertolerancemax = $request->get("diametertolerancemax");

        $diametertolerance = "{$diametertolerancemin} - {$diametertolerancemax}";

        $tensilestrenghtmin = $request->get("tensilestrenghtmin");
        $tensilestrenghtmax = $request->get("tensilestrenghtmax");

        $tensilestrenght = "{$tensilestrenghtmin} - {$tensilestrenghtmax}";

        $stresstest = $request->get("stresstest");
        $elongation = $request->get("elongation");
        $leadbathdip = $request->get("leadbathdip");
        $zinccoatingtype = $request->get("zinccoatingtype");
        $zinccoatingmin = $request->get("zinccoatingmin");
        $zinccoatingmax = $request->get("zinccoatingmax");

        $zinccoating = "{$zinccoatingmin} - {$zinccoatingmax}";

        $coatinguniformity = $request->get("coatinguniformity");
        $coatingadhesion = $request->get("coatingadhesion");
        $speed = $request->get("speed");
        $mmcenitrosetting = $request->get("mmcenitrosetting");
        $nitrodiesize = $request->get("nitrodiesize");
        $labelling = $request->get("labelling");
        $maxwelds = $request->get("maxwelds");
        $packagingrequirements = $request->get("packagingrequirements");
        $specialinstructions = $request->get("specialinstructions");
        $diametertolerancestrict = $request->get("diametertolerancestrict");
        $tensilestrenghtstrict = $request->get("tensilestrenghtstrict");
        $stressteststrict = $request->get("stressteststrict");
        $elongationstrict = $request->get("elongationstrict");
        $zinccoatingstrict = $request->get("zinccoatingstrict");
        $maxweldsstrict = $request->get("maxweldsstrict");

        //dd($cutomername, $productname, $productapplication, $roddiameter, $rodgrade, $rodtreatment, $diametergalvwire, $diametertolerance, $tensilestrenght, $stresstest, $elongation, $leadbathdip, $zinccoatingtype, $zinccoating, $coatinguniformity, $coatingadhesion, $speed, $mmcenitrosetting, $nitrodiesize, $labelling, $maxwelds, $packagingrequirements, $specialinstructions, $diametertolerancestrict, $tensilestrenghtstrict, $stressteststrict, $elongationstrict, $zinccoatingstrict, $maxweldsstrict);



        $add = DB::connection('sqlsrv2')->select(
            'exec spAddgalvproduct ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array(
                $cutomername, $productname, $productapplication, $roddiameter, $rodgrade, $rodtreatment, $diametergalvwire, $diametertolerance, $tensilestrenght, $stresstest, $elongation, $leadbathdip, $zinccoatingtype, $zinccoating, $coatinguniformity, $coatingadhesion, $speed, $mmcenitrosetting, $nitrodiesize, $labelling, $maxwelds, $packagingrequirements, $specialinstructions, $diametertolerancestrict, $tensilestrenghtstrict, $stressteststrict, $elongationstrict, $zinccoatingstrict, $maxweldsstrict
            )
        );

        return response()->json($add);
    }

    public function editproductspec(Request $request)
    {
        $cutomername = $request->get("cutomername");
        $productname = $request->get("productname");
        $productapplication = $request->get("productapplication");
        $roddiameter = $request->get("roddiameter");
        $rodgrade = $request->get("rodgrade");
        $rodtreatment = $request->get("rodtreatment");
        $diametergalvwire = $request->get("diametergalvwire");
        $diametertolerancemin = $request->get("diametertolerancemin");
        $diametertolerancemax = $request->get("diametertolerancemax");

        $diametertolerance = "{$diametertolerancemin}-{$diametertolerancemax}";

        $tensilestrenghtmin = $request->get("tensilestrenghtmin");
        $tensilestrenghtmax = $request->get("tensilestrenghtmax");

        $tensilestrenght = "{$tensilestrenghtmin}-{$tensilestrenghtmax}";

        $stresstest = $request->get("stresstest");
        $elongation = $request->get("elongation");
        $leadbathdip = $request->get("leadbathdip");
        $zinccoatingtype = $request->get("zinccoatingtype");
        $zinccoatingmin = $request->get("zinccoatingmin");
        $zinccoatingmax = $request->get("zinccoatingmax");

        $zinccoating = "{$zinccoatingmin}-{$zinccoatingmax}";

        $coatinguniformity = $request->get("coatinguniformity");
        $coatingadhesion = $request->get("coatingadhesion");
        $speed = $request->get("speed");
        $mmcenitrosetting = $request->get("mmcenitrosetting");
        $nitrodiesize = $request->get("nitrodiesize");
        $labelling = $request->get("labelling");
        $maxwelds = $request->get("maxwelds");
        $packagingrequirements = $request->get("packagingrequirements");
        $specialinstructions = $request->get("specialinstructions");
        $diametertolerancestrict = $request->get("diametertolerancestrict");
        $tensilestrenghtstrict = $request->get("tensilestrenghtstrict");
        $stressteststrict = $request->get("stressteststrict");
        $elongationstrict = $request->get("elongationstrict");
        $zinccoatingstrict = $request->get("zinccoatingstrict");
        $maxweldsstrict = $request->get("maxweldsstrict");

        //dd($cutomername, $productname, $productapplication, $roddiameter, $rodgrade, $rodtreatment, $diametergalvwire, $diametertolerance, $tensilestrenght, $stresstest, $elongation, $leadbathdip, $zinccoatingtype, $zinccoating, $coatinguniformity, $coatingadhesion, $speed, $mmcenitrosetting, $nitrodiesize, $labelling, $maxwelds, $packagingrequirements, $specialinstructions, $diametertolerancestrict, $tensilestrenghtstrict, $stressteststrict, $elongationstrict, $zinccoatingstrict, $maxweldsstrict);



        $edit = DB::connection('sqlsrv2')->select(
            'exec spEditgalvproduct ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array(
                $cutomername, $productname, $productapplication, $roddiameter, $rodgrade, $rodtreatment, $diametergalvwire, $diametertolerance, $tensilestrenght, $stresstest, $elongation, $leadbathdip, $zinccoatingtype, $zinccoating, $coatinguniformity, $coatingadhesion, $speed, $mmcenitrosetting, $nitrodiesize, $labelling, $maxwelds, $packagingrequirements, $specialinstructions, $diametertolerancestrict, $tensilestrenghtstrict, $stressteststrict, $elongationstrict, $zinccoatingstrict, $maxweldsstrict
            )
        );

        return response()->json($edit);
    }

    //For printing pallets
    public function printpalletsselectdept()
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        return view('warehouse/printpalletcodes')->with('departments', $dept);
    }
    public function qrcodetracker()
    {
        return view('warehouse/qrcodetracker');
    }
    public function stocklocation()
    {
        /*$dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");*/

        $products = DB::connection('sqlsrv2')->select("select * from viewtblProducts");
        return view('warehouse/stocklocations')->with('products', $products);
    }

    public function stockdetails($productcode)
    {
        //dd($productcode);
        return view('warehouse/stockdetails')->with('productCode', $productcode);
    }

    public function exceptionmovementreport()
    {
        return view('warehouse/exceptionmovementreport');
    }

    public function printlocationqrcodes($location)
    {

        return view('warehouse/printlocationqrcodes')->with('ID', $location);
    }
    public function getviewGridStockSummary(Request $request)
    {

        $gridstock = DB::connection('sqlsrv2')
            ->select("select * from  viewWareHouseTransferStockQty");
        return response()->json($gridstock);
    }

    public function getpalletmovementreport(Request $request)
    {
        //$palletReport = DB::connection('sqlsrv2')->select("select * from viewPalletExceptionRpt");
        //return response()->json($palletReport);
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $returndata = DB::connection('sqlsrv2')->select('exec spPalletExceptionRpt ?,?', array($datefrom, $dateto));
        return response()->json($returndata);
        //spPalletExceptionRpt
    }

    public function getitemmovementreport(Request $request)
    {
        /*$itemreport = DB::connection('sqlsrv2')->select("select * from ");
        return response()->json($itemreport);*/
    }

    public function getpalletreversalreport(Request $request)
    {
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $reversalreport = DB::connection('sqlsrv2')->select("select * from viewPalletReversalRpt where dteTimeCreate between '$datefrom' and '$dateto'");
        return response()->json($reversalreport);
    }

    public function getviewGridStockBalance(Request $request)
    {
        $ItemCode = $request->get("ItemCode");
        $gridstock = DB::connection('sqlsrv2')
            ->select("select * from viewBinLocationDetailsBalance where  strErpItemCode ='" . $ItemCode . "'");
        return response()->json($gridstock);
    }

    public function getviewGridStockReport(Request $request)
    {
        $ItemCode = $request->get("ItemCode");
        $gridstock = DB::connection('sqlsrv2')
            ->select("select * from viewLastKnownMovement where  strErpItemCode ='" . $ItemCode . "' order by dteTimeCreate");
        return response()->json($gridstock);
    }

    public function getviewGridStockDetails(Request $request)
    {
        $ItemCode = $request->get("ItemCode");
        $gridstock = DB::connection('sqlsrv2')
            ->select("select * from viewLastKnownMovement where  strErpItemCode ='" . $ItemCode . "' order by dteTimeCreate");
        return response()->json($gridstock);
    }



    public function choosemachine($itemCode)
    {
        /*  $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);*/

        $machines = DB::connection('sqlsrv2')
            ->select(
                'exec spGetMachineByProduct ?',
                array($itemCode)
            );
        $palletsjson = DB::connection('sqlsrv2')
            ->select(
                "EXEC spSelectItemsConfigurations ? ",
                array($itemCode)
            );
        return view('warehouse/choosemachine')->with('machines', $machines)->with('pallets', $palletsjson);
    }
    public function printpalletchoosemachine($deparment)
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =" . $deparment);

        $machines = DB::connection('sqlsrv2')
            ->select(
                'exec spGetMachinesByDept ?',
                array($deparment)
            );

        //dd($machines);
        //dd($deparment);

        return view('warehouse/printpalletchoosemachine')->with('departments', $dept)->with('machines', $machines)->with('deparment', $deparment);
    }
    public function wmaxlanding()
    {
        $customers = DB::connection('sqlsrv2')->select("select * from tblCustomersWmax ");
        $dept = DB::connection('sqlsrv2')->select("select * from tblDepartments Where strDeptName in ('Galv Line 1','Galv Line 2')"); //TODO This could be refactored to work with Modules
        return view('warehouse/wmax')->with('customers', $customers)->with('dept', $dept);
    }

    public function wmaxreprint()
    {
        $jobs = DB::connection('sqlsrv2')->select("select * from tblCompletedJobs order by [DateTime] desc");
        return view('warehouse/wmaxreprint')->with('jobs',$jobs);
    }

    public function roofingreprint()
    {
        $jobs = DB::connection('sqlsrv2')->select("select * from viewRoofingJobsPrinted");
        return view('warehouse/roofingreprint')->with('jobs',$jobs);
    }

    public function wmaxgetcustomerproduct(Request $request)
    {
        $cust = $request->get("customers");
        $productlist = DB::connection('sqlsrv2')
            ->select("select * from tblProductsWmax where CustomerName ='" . $cust . "'");
        return response()->json($productlist);
    }

    public function wmaxgetproductinfo(Request $request)
    {
        $customer = $request->get("customer");
        $product = $request->get("product");
        //dd($customer, $product);

        $productinfo = DB::connection('sqlsrv2')
            ->select("select * from tblProductsWmax where CustomerName ='" . $customer . "' and ProductName ='" . $product . "'");
        return response()->json($productinfo);
    }

    public function wmaxgetproductwiresize(Request $request)
    {
        $ProductID = $request->get("productId");
        $productlistsize = DB::connection('sqlsrv2')
            ->select("select * from tblProductsWmax where ProductID =" . $ProductID);
        return response()->json($productlistsize);
    }
    public function wmaxdepartmentgalv()
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        return response()->json($dept);
    }
    public function wmaxdepartmentmachinesgalv(Request $request)
    {
        $deptId = $request->get("deptId");
        $machines = DB::connection('sqlsrv2')->select("EXEC spGetMachinesByDept  $deptId");
        return response()->json($machines);
    }

    public function getMachinesforselecteddept(Request $request)
    {
        $deparment = $request->get("deptId");
        $prodname = $request->get("prodname");
        $machines = DB::connection('sqlsrv2')
            ->select(
                'exec spGetMachinesByDept ?,?',
                array($deparment, $prodname)
            );
        return response()->json($machines);
    }
    public function getPalletForSelectedItem(Request $request)
    {
        $itemCode = $request->get("itemCode");
        $intMachine = $request->get("intMachine");
        $palletsjson = DB::connection('sqlsrv2')->select("EXEC spSelectItemsConfigurations ?,? ", array($itemCode, $intMachine));
        return response()->json($palletsjson);
    }
    public function startendjob(Request $request)
    {

        $jobid = $request->get("jobid");
        $finalisestatus = $request->get("finalisestatus");

        $JOBSTATUS = DB::connection('sqlsrv2')
            ->select(
                "EXEC spUpdateStartEndJob ?,? ",
                array($jobid, $finalisestatus)
            );
        return response()->json($JOBSTATUS);
    }
    public function validatepalletsplan(Request $request)
    {
        $intPalletId = $request->get("intPalletId");
        $qtyproduce = $request->get("qtyproduce");
        $palletconf = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = $intPalletId");

        return response()->json($palletconf);
    }

    public function mapmachinetoarea()
    {
        $area = DB::connection('sqlsrv2')
            ->select("select * from tblAreas");

        $machine = DB::connection('sqlsrv2')
            ->select('SELECT * FROM tblMachines WHERE intAutoMachineID NOT IN  (SELECT intMachineID FROM tblMapMachineToArea) ');

        //dd($area);
        //dd($machine);
        return view('warehouse/mapmachinetoarea')->with('area', $area)->with('machine', $machine);
    }

    public function mapmachinestodept()
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");

        $machines = DB::connection('sqlsrv2')
            ->select(
                'SELECT * FROM tblMachines WHERE intAutoMachineID NOT IN  (SELECT intMachineID FROM tblMapMachineToDept where intStatus = 1) '
            );
        return view('warehouse/mapmachinetodept')->with('departments', $dept)->with('machines', $machines);
    }
    public function choosproducttomake($qty, $itemcode, $palletid, $machinenid)
    {

        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines where intAutoMachineID = " . $machinenid);

        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = " . $palletid);


        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts where PastelCode = '" . $itemcode . "'");

        return view('warehouse/chooseproducttomake')->with('pallet', $pallets)->with('machines', $machines)->with('products', $products)->with('qty', $qty);
    }
    //print pallet
    public function printpalletchoosproducttomake($deparment, $machine)
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =" . $deparment);

        $machines = DB::connection('sqlsrv2')
            ->select("select strMachineName,intAutoMachineID intMachineID from tblMachines where intAutoMachineID =" . $machine);
        /* $machines = DB::connection('sqlsrv2')
            ->select('exec spGetMachinesByDept ?',
                array($deparment)
            );*/
        $products = DB::connection('sqlsrv2')
            ->select(
                'exec spGetProductsToPrint ?,?',
                array($machine, $deparment)
            );
        //    dd($products);
        return view('warehouse/printpalletchooseproducttomake')->with('departments', $dept)->with('machines', $machines)->with('products', $products)->with('departmentselected', $deparment);
    }
    public function getProductPlannedOnThatMachine(Request $request)
    {
        $machineid = $request->get("machineId");
        $productonmachine = DB::connection('sqlsrv2')
            ->select(
                'exec spGetProductCurrentlyPlannedOnSpecificMachine ? ',
                array($machineid)
            );
        return response()->json($productonmachine);
    }

    public function customergridlookup()
    {

        $customergrid = DB::connection('sqlsrv2')
            ->select('select * from  viewGridCustomerAreaLookUp');
        return view('warehouse/customerlookup')->with('customergrid', $customergrid);
    }
    public function galvmodulecomms()
    {

        $galvloggrid = DB::connection('sqlsrv2')
            ->select('select * from  viewGalvModuleLogConsole');
        return view('warehouse/galvmodulecomms')->with('galvloggrid', $galvloggrid);
    }

    public function issuestock(){
        $users = DB::connection('sqlsrv3')->select("SELECT EmployeeCode, FirstName, LastName FROM viewSage300Employees WHERE EmployeeStatusCode = 'A' ");
        $reference = DB::connection('sqlsrv3')->select("SELECT TOP 1 intAutoId FROM tblStockIssueHeader ORDER BY dteCreated DESC");
        $intAutoId = count($reference) > 0 ? $reference[0]->intAutoId : 0;
        $types = DB::connection('sqlsrv3')->select("SELECT * FROM tblStockIssueTypes");
        $groups = DB::connection('sqlsrv3')->select("SELECT DISTINCT strStockGroup, strStockGroupDesc FROM viewStockIssue");
        $stockItems = DB::connection('sqlsrv3')->select("SELECT * FROM viewStockIssue");
        $upkeepjobs = $this->getOpenUpkeepWorkOrders();
        $areas = DB::connection('sqlsrv3')->select("SELECT * FROM tblAreas");
        $departments = DB::connection('sqlsrv3')->select("SELECT * FROM tblDepartments");
        $subdepartments = DB::connection('sqlsrv3')->select("SELECT * FROM tblSubDepartments");
        $machines = DB::connection('sqlsrv3')->select("SELECT * FROM tblMachines");
        $pastelProjects = DB::connection('sqlsrv3')->select("SELECT ProjectCode FROM [Hendok Distribution].dbo.Project WHERE ActiveProject = 1");

        return view ('warehouse/issuestock')
        ->with('users', $users)
        ->with('intAutoId', $intAutoId)
        ->with('types', $types)
        ->with('groups', $groups)
        ->with('stockItems', $stockItems)
        ->with('upkeepjobs', $upkeepjobs)
        ->with('areas', $areas)
        ->with('departments', $departments)
        ->with('subdepartments', $subdepartments)
        ->with('machines', $machines)
        ->with('pastelProjects', $pastelProjects);
    }

    public function getStockItemsByGroup(Request $request){
        $itemGroup = $request->get('ItemGroup');
        $groups = DB::connection('sqlsrv3')->select("SELECT strPastelCode, strPastelDescription FROM viewStockIssue WHERE strStockGroup = '".$itemGroup."'");
        return response()->json($groups);
    }

    public function getMachinesByDepartment(Request $request){
        $DeptID = $request->get('DeptID');
        $machines = DB::connection('sqlsrv3')->select("EXEC spGetMachinesByDept ?",array($DeptID));
        return response()->json($machines);
    }

    public function savestockissue(Request $request){
        $reference = $request->get("reference");
        $assignedBy = Auth::user()->UserID;
        $assignedTo = $request->get("assignedTo");
        $lines = $request->get("lines");

        if (is_array($lines)) {
            $linesxml = $this->toxml($lines, "xml", array("result"));

            // dd($linesxml);
            $data = DB::connection('sqlsrv2')->statement('exec spInsertStockIssue ?,?,?,?', array($reference, $assignedBy, $assignedTo,$linesxml));

            // dd($data);
        }

        return response()->json($data);
    }


    // Upkeep API Integration Functions -----------------------------------------------------------------------------------------------
    public function getOpenUpkeepWorkOrders(){
        $curl = curl_init();
    
        $token = DB::connection('sqlsrv3')->table('tblHendokApiIntegration')->where('strHostName', 'Upkeep')->value('strSessionToken');
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.onupkeep.com/api/v2/work-orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Session-Token: ' . $token,
                'Cookie: upkeepsess=' . $token
            ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        $result = json_decode($response, true);
    
        $openWorkOrders = array();
    
        foreach ($result['results'] as $workOrder) {
            if ($workOrder['status'] !== 'complete') {
                $openWorkOrders[] = $workOrder;
            }
        }
        // dd($openWorkOrders);
        return $openWorkOrders;
    }

    public function getUpkeepJobAsset($ID){
        $curl = curl_init();

        $token = DB::connection('sqlsrv3')->table('tblHendokApiIntegration')->where('strHostName', 'Upkeep')->value('strSessionToken');

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.onupkeep.com/api/v2/assets/'.$ID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Session-Token: ' . $token,
                'Cookie: upkeepsess=' . $token
            ),
        ));
    
        $response = curl_exec($curl);
        curl_close($curl);    
        $result = json_decode($response, true);
    
        return $result;
    }

    public function getUpkeepJobLocation($ID){
        $token = DB::connection('sqlsrv3')->table('tblHendokApiIntegration')->where('strHostName', 'Upkeep')->value('strSessionToken');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.onupkeep.com/api/v2/locations/'.$ID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Session-Token: ' . $token,
                'Cookie: upkeepsess=' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);        
        $result = json_decode($response, true);
    
        return $result;
    }

    public function GetAreaDeptSubDeptByMachine(Request $request){
        $MachineName = $request->get('MachineName');
        $result =  DB::connection('sqlsrv3')->select("EXEC spGetAreaDeptSubDeptByMachine '$MachineName'");
        return response()->json($result);
    }

    // Upkeep API Integration Functions -----------------------------------------------------------------------------------------------

    public function getIssueStock(Request $request){
        $result =  DB::connection('sqlsrv3')->select('select * from viewStockIssue');
        return response()->json($result);
    }

    public function bulkMapping(){
        $mappings =  DB::connection('sqlsrv3')->select('EXEC spGetBulkMapping mappings');
        $areas =  DB::connection('sqlsrv3')->select('EXEC spGetBulkMapping areas');
        $departments =  DB::connection('sqlsrv3')->select('EXEC spGetBulkMapping departments');
        $subdepartments =  DB::connection('sqlsrv3')->select('EXEC spGetBulkMapping subdepartments');
        $machines =  DB::connection('sqlsrv3')->select('EXEC spGetBulkMapping machines');

        // dd($mappings, $areas, $departments, $subdepartments, $machines);

        return view('warehouse/bulkMapping')
            ->with('mappings',$mappings)
            ->with('areas',$areas)
            ->with('departments',$departments)
            ->with('subdepartments',$subdepartments)
            ->with('machines',$machines);
    }

    public function checkBulkMapping(Request $request){
        $ID = $request->get("ID");
        $prompt = $request->get("prompt");
        $data =  DB::connection('sqlsrv3')->select("EXEC spCheckBulkMapping $ID, $prompt");
        return response()->json($data);
    }

    public function bulkMappingCRUD(Request $request){
        $area = $request->get("area");
        $department = $request->get("department");
        $subdepartment = $request->get("subdepartment");
        $machine = $request->get("machine");
        $ID = $request->get("ID");
        $prompt = $request->get("prompt");
        $data =  DB::connection('sqlsrv3')->select("EXEC spBulkMappingCRUD $area, $department, $subdepartment, $machine, $ID, '$prompt'");
        return response()->json($data);
    }

    public function getBulkMappingAreaDeptSubDeptMachines(Request $request){
        $ID = $request->get("ID");
        $prompt = $request->get("prompt");
        print_r($ID, $prompt);
        $data =  DB::connection('sqlsrv3')->select("EXEC spGetBulkMappingAreaDeptSubDeptMachines $ID, '$prompt'"); 
        return response()->json($data);
    }

    public function nailsInner(){
        $nails =  DB::connection('sqlsrv3')->select("SELECT * FROM tblNailsInner"); 
        return view('warehouse/nailsInner')->with('nails',$nails);
    }

    public function nailsInnerCrud(Request $request){
        $code = $request->get("code");
        $description = $request->get("description");
        $group = $request->get("group");
        $labelDescription = $request->get("labelDescription");
        $size = $request->get("size");
        $packsize = $request->get("packsize");
        $packaging = $request->get("packaging");
        $coating = $request->get("coating");
        $barcode = $request->get("barcode");
        $prompt = $request->get("prompt");
        $ID = $request->get("ID");
        $UserID = Auth::user()->UserID;
        
        // dd($code,$description,$group,$labelDescription,$size,$packsize,$packaging,$coating,$barcode,$prompt,$ID,$UserID);

        $nails =  DB::connection('sqlsrv3')->select("EXEC spNailsInnerCrud ?,?,?,?,?,?,?,?,?,?,?,?", 
        array($code,$description,$group,$labelDescription,$size,$packsize,$packaging,$coating,$barcode,$prompt,$ID,$UserID));
        
        return response()->json($nails);
    }

    public function endjob(Request $request){
        $jobid = $request->get("jobid");
        $endjob = $request->get("endjob");
        $endjob = (new \DateTime($endjob))->format('Y-m-d H:i:s');
        $result =  DB::connection('sqlsrv2')->table('tblJobQrcodeAllocation')
            ->where('intJobId', $jobid)
            ->update(['dteJobEnded' => $endjob]);
        return response()->json($result);
    }
    public function updatestartdate(Request $request)
    {
        $jobid = $request->get("jobid");
        $startdate = $request->get("startdate");
        $startdate = (new \DateTime($startdate))->format('Y-m-d');
        $result =  DB::connection('sqlsrv2')->table('tblJobQrcodeAllocation')
            ->where('intJobId', $jobid)
            ->update(['dteStartDate' => $startdate]);

        $sessionUserId = Auth::user()->UserID;
        $UserName = Auth::user()->UserName;

        DB::connection('sqlsrv3')->table('tblManagementConsol')->insert(
            [
                'ConsoleTypeId' => 818, 'Importance' => 1, 'LoggedBy' => $UserName, 'Message' => "Estimated Start Date Changeb by " . $UserName . " For Job NO# " . $jobid . " To " . $startdate,
                'UserId' => $sessionUserId, 'OrderId' => $jobid, 'DocNumber' => $jobid
            ]
        );
        return response()->json($result);
    }
    public function getWIP(Request $request)
    {

        $productonmachine = DB::connection('sqlsrv2')
            ->select(
                'exec spGetProductCurrentlyPlanned '
            );
        return response()->json($productonmachine);
    }

    public function getRoofWIP(Request $request)
    {
        $wip = DB::connection('sqlsrv2')->select('exec spGetRoofWIP ');
        return response()->json($wip);
    }

    public function getGalvWIP(Request $request)
    {

        $productonmachine = DB::connection('sqlsrv2')->select("select distinct * from tblNewJobs Where Completed <> 'Y'");
        return response()->json($productonmachine);
    }

    public function getroofingWIP(Request $request)
    {
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $getdata = DB::connection('sqlsrv2')->select('exec spGetRoofinSoNumByDate ?,?', array($datefrom, $dateto));
        return response()->json($getdata);
    }


    public function roofingReport(Request $request)
    {
        $data = DB::connection('sqlsrv2')->select('SELECT * FROM viewRoofingReport');
        return view('warehouse/roofingReport')->with('data', $data);
    }
    public function galvReport(Request $request)
    {
        $data = DB::connection('sqlsrv2')->select('SELECT * FROM viewGalvReport');
        return view('warehouse/galvReport')->with('data', $data);
    }

    public function galvProducts(Request $request)
    {
        $data = DB::connection('sqlsrv2')->select('SELECT * FROM tblProductsWmax');
        return view('warehouse/galvProducts')->with('data', $data);
    }

    public function updateGalvProduct(Request $request)
    {
        $ProductID = $request->get('ProductID');
        $ProductName = $request->get('ProductName');
        $WireSize = $request->get('WireSize');
        $SizeTolerance = $request->get('SizeTolerance');
        $Type = $request->get('Type');
        $MPATolerance = $request->get('MPATolerance');
        $ZincSpec = $request->get('ZincSpec');
        $Gas = $request->get('Gas');
        $LedDip = $request->get('LedDip');
        $DV = $request->get('DV');
        $RodSize = $request->get('RodSize');
        $RodType = $request->get('RodType');
        $SECode = $request->get('SECode');
        $CustomerName = $request->get('CustomerName');
        $WDBlackTol = $request->get('WDBlackTol');
        $GalvRPM = $request->get('GalvRPM');
        $QCStrict = $request->get('QCStrict');
        $strProductApplication = $request->get('strProductApplication');
        $strRodTreatment = $request->get('strRodTreatment');
        $intStressTest = $request->get('intStressTest');
        $intElongation = $request->get('intElongation');
        $strLeadBathDip = $request->get('strLeadBathDip');
        $strZincCoatingMinMax = $request->get('strZincCoatingMinMax');
        $strCoatingUniformity = $request->get('strCoatingUniformity');
        $strCoatingAdhesion = $request->get('strCoatingAdhesion');
        $strLabelling = $request->get('strLabelling');
        $intMaxWelds = $request->get('intMaxWelds');
        $strPackagingRequirements = $request->get('strPackagingRequirements');
        $strSpecialInstructions = $request->get('strSpecialInstructions');
        $boolStrictDiameterTolerance = $request->get('boolStrictDiameterTolerance');
        $boolStrictTensileStrength = $request->get('boolStrictTensileStrength');
        $boolStrictStressTest = $request->get('boolStrictStressTest');
        $boolStrictElongation = $request->get('boolStrictElongation');
        $boolStrictZincCoatingMinMax = $request->get('boolStrictZincCoatingMinMax');
        $intNitroDieSize = $request->get('intNitroDieSize');
        $boolStrictMaxWelds = $request->get('boolStrictMaxWelds');

        $response = DB::connection('sqlsrv2')->select("EXEC spUpdateGalvProduct '$ProductID', '$ProductName', '$WireSize', '$SizeTolerance', '$Type', '$MPATolerance', '$ZincSpec', '$Gas', '$LedDip', '$DV', '$RodSize', '$RodType', '$SECode', '$CustomerName', '$WDBlackTol', '$GalvRPM', '$QCStrict', '$strProductApplication', '$strRodTreatment', '$intStressTest', '$intElongation', '$strLeadBathDip', '$strZincCoatingMinMax', '$strCoatingUniformity', '$strCoatingAdhesion', '$strLabelling', '$intMaxWelds', '$strPackagingRequirements', '$strSpecialInstructions', '$boolStrictDiameterTolerance', '$boolStrictTensileStrength', '$boolStrictStressTest', '$boolStrictElongation', '$boolStrictZincCoatingMinMax', '$intNitroDieSize', '$boolStrictMaxWelds'");
        return response()->json($response);
    }

    public function getWIPjobstarted(Request $request)
    {

        $productonmachine = DB::connection('sqlsrv2')
            ->select(
                'exec spGetProductInProgress '
            );
        return response()->json($productonmachine);
    }
    public function getjobsdatajson(Request $request)
    {
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $returndata = DB::connection('sqlsrv2')
            ->select(
                'exec spGetProductInProgressdate ?,?',
                array($datefrom, $dateto)
            );
        return response()->json($returndata);
    }

    public function getgenericlabelprintscreen(Request $request)
    {
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $returndata = DB::connection('sqlsrv2')
            ->select(
                'exec spReturnGenericLabelPrintScreen ?,?',
                array($datefrom, $dateto)
            );
        return response()->json($returndata);
    }
    public function getJobStarted()
    {
        return view('warehouse/wip');
    }
    public function getjobsdata()
    {
        return view('warehouse/getjobsdata');
    }



    public function goprintfirstqrcode($deparment, $machine, $productcode, $palletid, $qty)
    {
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =" . $deparment);
        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines where intAutoMachineID = " . $machine);

        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = " . $palletid);


        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts where PastelCode = '" . $productcode . "'");

        return view('warehouse/goprintfirstqrcode')->with('departments', $dept)->with('machines', $machines)->with('qty', $qty)
            ->with('products', $products)->with('pallets', $pallets);
    }

    public function startprintingjob($qty, $machine, $productcode, $palletid, $start)
    {
        /* $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);
        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines where intAutoMachineID = ".$machine);

        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = ".$palletid);


        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts where PastelCode = '".$productcode."'");*/
        $start = (new \DateTime($start))->format('Y-m-d');

        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spInsertNewJob ?,?,?,?,?,?',
                array($productcode, $machine, $palletid, $qty, "12345", $start)
            );
        $htmlqrcode = "";
        foreach ($returnmach as $val) {
            /*$htmlqrcode .="Item Code :".$val->strItemCode."<br>";
           $htmlqrcode .="Required :".$val->mnyQtyRequired."<br>";
           $htmlqrcode .="Machine  :".$val->strMachineName."<br>";
           $htmlqrcode .="Department  :".$val->strDeptName."<br>";
           $htmlqrcode .="Time Created  :".$val->dteJobCreated."<br>";
           $htmlqrcode .="By:".$val->strOperator."<br>";*/
            $htmlqrcode .= "JOB NO :" . $val->intJobId . ":D" . $val->strDeptName . ":M" . $val->strMachineName . "By:" . $val->strOperator . ":T" . $val->dteJobCreated;
        }

        return view('warehouse/joblabel')->with('qrcodeothers', $returnmach)->with('qrcode', $htmlqrcode);
    }
    public function sendLabelToThePrinter(Request $request)
    {
        $qty = $request->get('qty');
        $type = $request->get('type');
        $jobid = $request->get('jobid');
        $isNEW = $request->get('isnew');

        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;

        for ($i = 0; $i < $qty; $i++) {
            DB::connection('sqlsrv2')
                ->statement(
                    'exec spInserPalletLabelToPrint ?,?,?',
                    array($type, $jobid, $ID)
                );
        }
        if ($isNEW != "reprint") {
            DB::connection('sqlsrv2')
                ->statement(
                    'exec spUpdateUnitsProduced ?,?',
                    array($type, $jobid)
                );
        }

        $v  =  new \App\Http\Controllers\SalesForm();
        $GroupId = Auth::user()->GroupId;
        if ($v->getThings($GroupId, 'Print Pallet')) {
        }

        return "Success";
    }

    public function sendRoofingLabelToThePrinter(Request $request)
    {
        $deptname = 'Roofing';
        $qty = $request->get('qty');
        $jobId  = $request->get('jobId');
        $operator  = Auth::user()->UserName;
        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;

        // dd($deptname,$jobId,$operator,$ID,$qty);

        $print = DB::connection('sqlsrv2')->statement('exec spInsertPrintRoofingLabels ?,?,?,?,?', array($deptname, $jobId, $operator, $ID, $qty));

        return response()->json($print);
    }

    public function printAdditionalRoofingLabels(Request $request)
    {
        $deptname = 'Roofing';
        $qty = $request->get('qty');
        $jobId  = $request->get('JobId');
        $operator  = Auth::user()->UserName;
        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;

        // dd($deptname,$jobId,$operator,$ID,$qty);

        $print = DB::connection('sqlsrv2')->select('exec spPrintAdditionalRoofingLabels ?,?,?,?,?', array($deptname, $jobId, $operator, $ID, $qty));

        return response()->json($print);
    }

    public function doneprintingpallet()
    {
        return view('warehouse/doneprintingpallet');
    }

    public function jobupdateprint($jobid)
    {
        /*$returnmach = DB::connection('sqlsrv2')->select('exec spInsertNewJob ?,?,?,?,?,?',array($productcode,$machine,$palletid,$qty,"12345",$start));*/
        $jobdata = DB::connection('sqlsrv3')->select('exec spGetProductPlannedDetails ?', array($jobid));
        return view('warehouse/updatejob')->with("jobdata", $jobdata)->with("id", $jobid);
    }

    public function roofingSOUpdate($reference, $machine)
    {
        return view('warehouse/updateroofingjob')->with("reference", $reference)->with("machine", $machine);
    }

    public function getRoofingSOtoUpdate(Request $request)
    {
        $reference = $request->get("reference");
        $machine = $request->get("machine");
        // dump($reference,$machine);
        $jobdata = DB::connection('sqlsrv3')->select('exec spGetRoofingSOHeader ?,?', array($reference, $machine));
        // dd($jobdata);
        return response()->json($jobdata);
    }

    public function changeRoofingSOStatus(Request $request)
    {
        $reference = $request->get("reference");
        $machine = $request->get("machine");
        $status = $request->get("status");

        $data = DB::connection('sqlsrv3')->select('exec spUpdateRoofingSOStatus ?,?,?', array($reference, $machine, $status));
        return response()->json($data);
    }

    public function changeRoofingInvoiceStatus(Request $request){
        $reference = $request->get("reference");
        $machine = $request->get("machine");
        $SONumber = $request->get("SONumber");
        $InvNumber = $request->get("InvNumber");
        $status = $request->get("status");

        $data = DB::connection('sqlsrv3')->select('exec spUpdateRoofingInvoiceStatus ?,?,?,?,?',array($reference, $machine, $SONumber, $InvNumber, $status));
        return response()->json($data);
    }

    public function sendProductionCommunication(Request $request){
        $sendTo = $request->get("sendTo");
        $subject = $request->get("subject");
        $body = $request->get("body");
        $type = $request->get("type");

        // dd($sendTo, $subject, $body, $type);

        $data = DB::connection('sqlsrv3')->select('exec spInsertProductionCommunication ?,?,?,?',array($sendTo, $subject, $body, $type));
        return response()->json($data);
    }

    public function deletesalesorders(Request $request)
    {
        $reference = $request->get("reference");
        $userID = Auth::user()->UserID;
        $userName =  Auth::user()->UserName;

        //dd($reference, $userID, $userName);

        $jobdata = DB::connection('sqlsrv3')->select("exec spDeleteRoofingRef ?,?,?", array($reference, $userID, $userName));
        return response()->json($jobdata);
    }

    public function getsalesorders(Request $request)
    {
        $reference = $request->get("reference");
        $salesorders = DB::connection('sqlsrv3')->select("select * from tblRoofingSONumToPlan where strReference ='" . $reference . "'");
        return response()->json($salesorders);
    }

    public function getroofingheaders(Request $request)
    {
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $headers = DB::connection('sqlsrv3')->select("exec spRoofingPlannedHeaders ?,?", array($datefrom, $dateto));
        return response()->json($headers);
    }

    public function getroofinglines(Request $request)
    {
        $ID = $request->get("ID");
        $lines = DB::connection('sqlsrv3')->select("exec spRoofingPlannedLines ?", array($ID));
        return response()->json($lines);
    }

    public function deleteRoofingBatch(Request $request){
        $ID = $request->get("ID");
        $userid =  Auth::user()->UserID;

        $result = DB::connection('sqlsrv3')->statement("exec spDeleteRoofingBatch ?,?", array($ID, $userid));
        return response()->json($result);
    }

    public function deleteRoofingSO(Request $request){
        $ID = $request->get("ID");
        $userid =  Auth::user()->UserID;

        $result = DB::connection('sqlsrv3')->statement("exec spDeleteRoofingSO ?,?", array($ID, $userid));
        return response()->json($result);
    }


    public function getjobcard($jobid)
    {
        $jobdata = DB::connection('sqlsrv3')->select('exec spGetProductPlannedDetails ?', array($jobid));
        //dd($jobdata);
        return view('warehouse/jobcard')->with("jobdata", $jobdata)->with("id", $jobid);
    }

    public function getallactivejobs()
    {
        $jobdata = DB::connection('sqlsrv3')->select('exec spGetFullProductPlannedDetails');
        //dd($jobdata);
        return view('warehouse/jobcard')->with("jobdata", $jobdata);
    }

    public function getgalvcreateproductspecsheet()
    {
        //$jobdata = DB::connection('sqlsrv3')->select('exec spGetFullProductPlannedDetails');
        //dd($jobdata);
        return view('warehouse/galvproductspecsheet');
    }

    public function syncing(){
        return view('warehouse/syncing');
    }

    public function syncPastelStockTable(){
        $response = DB::connection('sqlsrv3')->statement('exec spSyncBvStockFull');
        return response()->json($response);
    }

    public function stockIssueTypes (){
        return view('warehouse/stockissuetypes');
    }

    public function getStockIssueTypes(){
        $response = DB::connection('sqlsrv3')->select('SELECT * FROM tblStockIssueTypes');
        return response()->json($response);
    }

    public function saveStockIssueType(Request $request){
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'CREATE';

        $response = DB::connection('sqlsrv3')->statement('spStockIssueTypesCRUD ?,?,?', array($ID, $Name, $Operation));
        return response()->json($response);
    }

    public function updateStockIssueType(Request $request){
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'UPDATE';

        $response = DB::connection('sqlsrv3')->statement('spStockIssueTypesCRUD ?,?,?', array($ID, $Name, $Operation));
        return response()->json($response);
    }

    public function deleteStockIssueType(Request $request){
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'DELETE';

        $response = DB::connection('sqlsrv3')->statement('spStockIssueTypesCRUD ?,?,?', array($ID, $Name, $Operation));
        return response()->json($response);
    }

    public function subDepartments (){
        return view('warehouse/subdepartments');
    }

    public function getSubDepartments(){
        $response = DB::connection('sqlsrv3')->select('SELECT * FROM tblSubDepartments');
        return response()->json($response);
    }

    public function saveSubDepartment(Request $request){
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'CREATE';

        $response = DB::connection('sqlsrv3')->statement('spSubDepartmentCRUD ?,?,?', array($ID, $Name, $Operation));
        return response()->json($response);
    }

    public function updateSubDepartment(Request $request){
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'UPDATE';

        $response = DB::connection('sqlsrv3')->statement('spSubDepartmentCRUD ?,?,?', array($ID, $Name, $Operation));
        return response()->json($response);
    }

    public function deleteSubDepartment(Request $request){
        $ID = $request->get('ID');
        $Name = $request->get('Name');
        $Operation = 'DELETE';

        $response = DB::connection('sqlsrv3')->statement('spSubDepartmentCRUD ?,?,?', array($ID, $Name, $Operation));
        return response()->json($response);
    }

    public function getgalvlabel($customer, $product, $ticketno, $status)
    {
        $jobdata = DB::connection('sqlsrv2')->select("select *,'" . $status . "' as buttonStatus from tblCompletedJobs where Customer ='" . $customer . "' and ProductName ='" . $product . "' and TicketNo = '" . $ticketno . "'");
        //dd($jobdata);
        return view('warehouse/galvlabel')->with("id", $customer)->with("id", $product)->with("ticketno", $ticketno)->with("jobdata", $jobdata);
    }

    public function insertIntoJobTable(Request $request)
    {
        $deptId = $request->get("deptId");
        $prodgroup = "0"; //$request->get("prodgroup");
        $productcategory = $request->get("productcategory");
        $prodname = $request->get("prodname");
        $machinename = $request->get("machinename");
        $qty = $request->get("qty");
        $palletconfig = $request->get("palletconfig");
        //$startdate = $request->get("startdate");

        $startdate = (new \DateTime($request->get('startdate')))->format('Y-m-d');

        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spInsertNewJob ?,?,?,?,?,?,?,?',
                array($deptId, $prodgroup, $productcategory, $prodname, $machinename, $qty, $startdate, $palletconfig)
            );
        return response()->json($returnmach);
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

    public function insertPrePlannedSO(Request $request)
    {
        $orderlines = $request->get("orderlines");
        $operator = Auth::user()->UserID;
        $reference = $request->get("reference");

        if (is_array($orderlines)) {
            $orderlinesxml = $this->toxml($orderlines, "xml", array("result"));
        }

        //dd($orderlinesxml);

        $data = DB::connection('sqlsrv2')->select('exec spXMLInsertRoofinSoNumToPlan ?,?,?', array($orderlinesxml, $operator, $reference));

        return response()->json($data);
    }

    public function updateRoofLines(Request $request)
    {
        $workOrders = $request->get("workOrders");
        $batchID = $request->get("batchID");
        $batchReference = $request->get("batchReference");
        $userName = Auth::user()->UserName;
        $userID = Auth::user()->UserID;
        // dd($workOrders);

        if (is_array($workOrders)) {
            $orderlinesxml = $this->toxml($workOrders, "xml", array("result"));

            // dd($orderlinesxml);
            $data = DB::connection('sqlsrv2')->select('exec spUpdateRoofLines ?,?,?,?,?', array($orderlinesxml, $userName, $userID, $batchID, $batchReference));
        }

        return response()->json($data);
    }

    public function updateRoofLinesSequence(Request $request)
    {
        $workOrders = $request->get("workOrders");

        if (is_array($workOrders)) {
            $orderlinesxml = $this->toxml($workOrders, "xml", array("result"));

            // dd($orderlinesxml);
            $data = DB::connection('sqlsrv2')->select('exec spUpdateRoofLinesSequence ?', array($orderlinesxml));
        }
        dd($data);

        return response()->json($data);
    }

    //Start Generating The Qr code
    public function startgenratingqrcodeforpallet($jobId, $isroofing = "None")
    {
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spInsertNewPalletPrint ?,?',
                array($jobId, $isroofing)
            );
        $htmlqrcode = "";
        $dept = 0;
        foreach ($returnmach as $val) {
            /*$htmlqrcode .="Item Code :".$val->strItemCode."<br>";
            $htmlqrcode .="Required :".$val->mnyQtyRequired."<br>";
            $htmlqrcode .="Machine  :".$val->strMachineName."<br>";
            $htmlqrcode .="Department  :".$val->strDeptName."<br>";
            $htmlqrcode .="Time Created  :".$val->dteJobCreated."<br>";
            $htmlqrcode .="By:".$val->strOperator."<br>";*/
            $htmlqrcode .= "JOB NO :" . $val->intJobId . ": P" . $val->palletJobPrint . ":M" . $val->strMachineName . ":T" . $val->dteJobCreated;
            $dept = $val->strDeptName;
        }

        switch ($dept) {
            case ('Roofing'):
                return view('warehouse/roofingjoblabel')->with('qrcodeothers', $returnmach)->with('qrcode', $htmlqrcode)->with('jobid', $jobId);

                break;

            default:
                return view('warehouse/palletjoblabel')->with('qrcodeothers', $returnmach)->with('qrcode', $htmlqrcode)->with('jobid', $jobId);
        }
    }

    public function mapitemstopallet()
    {
        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf");


        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts");
        return view('warehouse/mapitemstopallet')->with('pallets', $pallets)->with('products', $products);
    }

    public function saveLabels(Request $request)
    {
        $labelname = $request->get("labelname");
        $printerID = $request->get("printerID");
        $statement = "INSERT";
        $config = $request->get("config");
        $return = DB::connection('sqlsrv2')->select('exec spSaveLabel ?,?,?,?', array($labelname, $printerID, $statement, $config));
        // dd($return);
        return response()->json($return);
    }

    public function updateSavedLabels(Request $request)
    {
        $labelname = $request->get("labelname");
        $labelID = $request->get("labelID");
        $statement = "UPDATE";
        $config = "";
        // dd($labelname,$labelID,$statement);
        $return = DB::connection('sqlsrv2')->select('exec spSaveLabel ?,?,?,?', array($labelname, $labelID, $statement, $config));
        // dd($return);
        return response()->json($return);
    }
    public function deleteSavedLabelMapping(Request $request)
    {
        $labelID = $request->get("labelID");
        DB::connection('sqlsrv2')->statement('exec spDeleteMappedLabel ?', array($labelID));
    }
    public function deleteSavedLabels(Request $request)
    {
        $labelname = $request->get("labelname");
        $labelID = $request->get("labelID");
        $statement = "DELETE";
        $config = "";
        // dd($labelname,$labelID,$statement);
        $return = DB::connection('sqlsrv2')->select('exec spSaveLabel ?,?,?,?', array($labelname, $labelID, $statement, $config));
        // dd($return);
        return response()->json($return);
    }

    public function mapLabelToProdCat(Request $request)
    {
        $productcategory = $request->get("productcategory");
        $labelname = $request->get("labelname");
        $intAutoLinkedCatLabelId = 0;
        $statement = "INSERT";

        $return = DB::connection('sqlsrv2')->select("EXEC spMapProdCatToLabelType ?,?,?,?", array($productcategory, $labelname, $intAutoLinkedCatLabelId, $statement));
        return response()->json($return);
    }

    public function deleteMappedLabels(Request $request)
    {
        $productcategory = '';
        $labelname = '';
        $intAutoLinkedCatLabelId = $request->get("labelid");
        $statement = "DELETE";
        //dd($productcategory,$labelname);

        $return = DB::connection('sqlsrv2')->select("EXEC spMapProdCatToLabelType ?,?,?,?", array($productcategory, $labelname, $intAutoLinkedCatLabelId, $statement));
        return response()->json($return);
    }


    public function mapdeptitem()
    {
        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines");

        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts");
        return view('warehouse/mapitemstomachineanddept')->with('products', $products)->with('machines', $machines);
    }
    public function getMappedItemstoPalletJson()
    {
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spMappedItemsToPallets ");
        return response()->json($palletsjson);
    }
    public function getMappedDepartmentsMachinesItemasJson()
    {
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spMappedDepartmentMachineItems");
        return response()->json($palletsjson);
    }

    public function getProductsMappedToMachine()
    {
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetProductsMappedToMachine");
        return response()->json($palletsjson);
    }

    public function getPallets()
    {
        $palletsjson = DB::connection('sqlsrv2')->select("EXEC spGetPalletsConfig");
        return response()->json($palletsjson);
    }
    public function getMachinemappedtoarea()
    {
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC  spGetMappedMachineToArea");
        return response()->json($palletsjson);
    }

    public function getMachinesmappedtodept()
    {
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetMappedMachinesToDept ");
        return response()->json($palletsjson);
    }
    public function getDeptname()
    {
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetDepNames ");
        return response()->json($palletsjson);
    }

    public function getAreaname()
    {
        $palletsjson = DB::connection('sqlsrv2')->select("EXEC spGetAreaNames");
        return response()->json($palletsjson);
    }


    public function getMappedLabels()
    {
        $strProdCat = "test";
        $labelType = 0;
        $intAutoLinkedCatLabelId = 0;
        $statement = "SELECT";

        $mappedlabels = DB::connection('sqlsrv2')->select("EXEC spMapProdCatToLabelType ?,?,?,?", array($strProdCat, $labelType, $intAutoLinkedCatLabelId, $statement));
        return response()->json($mappedlabels);
    }

    public function getLabels()
    {
        $labels = DB::connection('sqlsrv2')->select("Select * from viewLabelsMappedToPrinter");
        return response()->json($labels);
    }

    public function getCustomername()
    {
        $customernames = DB::connection('sqlsrv2')->select("select * from tblCustomersWmax");
        //dd($customernames);
        return response()->json($customernames);
    }

    public function getScales()
    {
        $scales = DB::connection('sqlsrv2')->select("exec spGetScales");
        //dd($scaleNames);
        return response()->json($scales);
    }

    public function getTare()
    {
        $scales = DB::connection('sqlsrv2')->select("select * from tblWeighStands");
        return response()->json($scales);
    }

    public function listenToScale(Request $request)
    {
        $scaleID = $request->get("scaleID");

        if (!empty($scaleID)){
            $scales = DB::connection('sqlsrv2')->select("select strIP, strPort from tblScales where intAutoId = '" . $scaleID . "'");

            // dd($scales);

            $host = $scales[0]->strIP;
            $port =  $scales[0]->strPort;

            // dd($host,$port);
            // $host = "192.168.100.232";
            // $port = 23;
            set_time_limit(0);

            $socket = socket_create(AF_INET, SOCK_STREAM, 0);
            socket_connect($socket, $host, $port);
            $input = socket_read($socket, 4096);
            // socket_recv($socket, $input, 1024, 0);
            socket_close($socket);

            // dd(($input));

            // $replaced = str::replaceArray('ST,GS,+', [''], $input);
            // $replaced = str::replaceArray('US,GS,+', [''], $input);

            // $input = trim($input, );
            // $input = trim($input, "UT,GS,");
            // $input = trim($input, "WN");
            // $input = trim($input, "+");
            // $input = trim($input, "-");
            // $input = trim($input, "kg");

            // Remove Illegal values
            $input = str_replace(array("\r", "\n", "ST,GS,", "UT,GS,", "WN", "+", "-", "kg", " "), "", $input);
            $input = ltrim($input);
            $input = intval($input);

            return response()->json($input);
        }
    }


    public function getpalletconfforitems(Request $request)
    {
        $productcode = $request->get("productcode");
        $palletsjson = DB::connection('sqlsrv2')
            ->select(
                "EXEC spSelectItemsConfigurations ? ",
                array($productcode)
            );
        return response()->json($palletsjson);
    }

    public function getMachines()
    {
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetMachines ");
        return response()->json($palletsjson);
    }

    public function getgroupname()
    {
        $groupsjson = DB::connection('sqlsrv2')->select("EXEC spGetGroupNames ");
        return response()->json($groupsjson);
    }

    public function getgroupsetting()
    {
        $groupsettingsjson = DB::connection('sqlsrv2')->select("EXEC spGetGroupSettings ");
        return response()->json($groupsettingsjson);
    }

    public function savesPallet(Request $request)
    {
        $palletqty = $request->get("palletqty");
        $pallettypedesc = $request->get("pallettypedesc");
        $return = DB::connection('sqlsrv2')->select('exec spCreatePalletConf ?,?', array($palletqty, $pallettypedesc));
        return response()->json($return);
    }

    public function updatePalletConfig(Request $request)
    {
        $palletID = $request->get('palletID');
        $PalletDesc = $request->get('palletDesc');
        $PalletQty = $request->get('palletQty');
        // dd($palletID, $PalletDesc, $PalletQty);
        $return = DB::connection('sqlsrv2')->select('exec spUpdatePalletConfig ?,?,?', array($palletID, $PalletDesc, $PalletQty));
        return response()->json($return);
    }

    public function deletePalletConfig(Request $request)
    {
        $palletID = $request->get('PalletID');
        // dd($palletID);
        $return = DB::connection('sqlsrv2')->select('exec spDeletePalletConfig ?', array($palletID));
        return response()->json($return);
    }



    public function savesMachinetoarea(Request $request)
    {
        $machineid = $request->get("machineid");
        $areaid = $request->get("areaid");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spMapMachineToArea ?,?',
                array($machineid, $areaid)
            );
        return response()->json($returnmach);
    }

    public function savesMachinemaptodept(Request $request)
    {
        $machineid = $request->get("machineid");
        $deptid = $request->get("deptid");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec [spMapMachinesToDept] ?,?',
                array($machineid, $deptid)
            );
        return response()->json($returnmach);
    }
    public function savesdeptname(Request $request)
    {
        $deptname = $request->get("deptname");

        //
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spCreateDepartment ?',
                array($deptname)
            );
        return response()->json($returnmach);
    }

    public function savesareaname(Request $request)
    {
        $areaname = $request->get("areaname");

        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spCreateArea ?',
                array($areaname)
            );
        return response()->json($returnmach);
    }

    public function savescustomername(Request $request)
    {
        $customername = $request->get("customername");
        $customertype = $request->get("customertype");
        //dd($customername);

        $data = DB::connection('sqlsrv2')->select('exec spSaveGalvCustomer ?,?', array($customername, $customertype));
        return response()->json($data);
    }

    public function savesscale(Request $request)
    {
        $scalename = $request->get("scalename");
        $departmentID = $request->get("departmentID");
        $IP = $request->get("IP");
        $port = $request->get("port");

        // dd($scalename,$scalemass,$departmentID,$IP,$port);

        $returnmach = DB::connection('sqlsrv2')->select('exec spSaveScale ?,?,?,?', array($scalename, $departmentID, $IP, $port));
        return response()->json($returnmach);
    }

    public function savesmachine(Request $request)
    {
        $machine = $request->get("machinename");
        $return = DB::connection('sqlsrv2')->select('exec spCreateMachines ?', array($machine));
        return response()->json($return);
    }
    public function savespalletstoitems(Request $request)
    {

        $pallettypedesc = $request->get("pallettypedesc");
        $productcode = $request->get("productcode");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spMapPalletsToItems ?,?',
                array($productcode, $pallettypedesc)
            );
        return response()->json($returnmach);
    }
    public function savesmachinedeptitems(Request $request)
    {

        $machine = $request->get("machine");
        $department = $request->get("department");
        $productcode = $request->get("productcode");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spMapDeptMachineItems ?,?,?',
                array($productcode, $machine, $department)
            );
        return response()->json($returnmach);
    }

    public function mapProductToMachine(Request $request){
        $machine = $request->get("machine");
        $productcode = $request->get("productcode");

        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spMapItemToMachine ?,?',
                array($productcode, $machine)
            );
        return response()->json($returnmach);
    }

    public function savesgroupname(Request $request)
    {
        $groupname = $request->get("groupname");

        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spCreateGroupName ?',
                array($groupname)
            );
        return response()->json($returnmach);
    }

    public function savessettingname(Request $request)
    {

        $groupID = $request->get("groupID");
        $settingname = $request->get("settingname");
        $value = 1;

        //dd($groupID);
        //dd($settingname);

        //
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spCreateGroupSetting ?,?,?',
                array($groupID, $settingname, $value)
            );
        return response()->json($returnmach);
    }

    public function updateDeptName(Request $request)
    {
        $deptName = $request->get("deptName");
        $deptID = $request->get("deptID");
        $return = DB::connection('sqlsrv2')->select('exec spUpdateDepartments ?,?', array($deptID, $deptName));
        return response()->json($return);
    }

    public function deleteDept(Request $request)
    {
        $deptID = $request->get("deptID");
        $return = DB::connection('sqlsrv2')->select('exec spDeleteDepartment ?', array($deptID));
        return response()->json($return);
    }

    public function updateLabelMapping(Request $request)
    {
        $departmentName = $request->get("departmentName");
        $printerName = $request->get("printerName");
        $return = DB::connection('sqlsrv2')->select('exec spUpdatePrinterMapping ?,?', array($departmentName, $printerName));
        return response()->json($return);
    }

    public function deleteLabelMapping(Request $request)
    {
        $departmentName = $request->get("departmentName");
        $printerName = $request->get("printerName");
        $return = DB::connection('sqlsrv2')->select('exec spDeletePrinterMapping ?,?', array($departmentName, $printerName));
        return response()->json($return);
    }

    public function update(Request $request)
    {

        $theAreaname = $request->get("theAreaname");
        $palletid = $request->get("palletid");
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spUpdateAreas ?,?',
                array($palletid, $theAreaname)
            );
        return response()->json($returnmach);
    }

    public function deleteCustomerName(Request $request)
    {
        $CustomerID = $request->get("CustomerID");
        $returnmach = DB::connection('sqlsrv2')->select('exec spDeleteGalvCustomer ?', array($CustomerID));
        return response()->json($returnmach);
    }

    public function updateGalvCustomer(Request $request)
    {
        $CustomerID = $request->get("CustomerID");
        $CustomerName = $request->get("CustomerName");
        $CustomerType = $request->get("Type");

        $data = DB::connection('sqlsrv2')->select('exec spUpdateGalvCustomer ?,?,?', array($CustomerID, $CustomerName, $CustomerType));
        return response()->json($data);
    }

    public function deleteScale(Request $request)
    {
        $ScaleId = $request->get("ScaleId");
        //dd($ScaleId);
        $returnmach = DB::connection('sqlsrv2')->select('exec spDeleteScale ?', array($ScaleId));
        return response()->json($returnmach);
    }

    public function updateMachineName(Request $request)
    {
        $MachineID = $request->get("MachineID");
        $MachineName = $request->get("MachineName");
        $return = DB::connection('sqlsrv2')->select('exec spUpdateMachines ?,?', array($MachineID, $MachineName));
        return response()->json($return);
    }

    public function deleteMachine(Request $request)
    {
        $MachineID = $request->get("MachineID");
        $return = DB::connection('sqlsrv2')->select('exec spDeleteMachine ?', array($MachineID));
        return response()->json($return);
    }

    public function updateupdategroupname(Request $request)
    {

        $thegroupname = $request->get("thegroupname");
        $GroupID = $request->get("GroupID");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select(
                'exec spUpdateMachines ?,?',
                array($GroupID, $thegroupname)
            );
        return response()->json($returnmach);
    }

    public function removemapping(Request $request)
    {

        $mappingId = $request->get("mappingId");
        DB::connection('sqlsrv2')->table('tblMapItemsToPallets')
            ->where('intMappingId', $mappingId)
            ->update(['intStatus' => 2]);
    }
    public function unmapmachinefromdept(Request $request)
    {

        $mappingId = $request->get("mappingId");
        DB::connection('sqlsrv2')->table('tblMapMachineToDept')
            ->where('intAutoMappedMachineDept', $mappingId)
            ->update(['intStatus' => 2]);
    }
    public function removemappingdeptmachitems(Request $request)
    {

        $mappingId = $request->get("mappingId");
        DB::connection('sqlsrv2')->table('tblMappedDeptMachinesItems')
            ->where('intAutoMappedDeptMachItemID', $mappingId)
            ->update(['intStatus' => 2]);
    }

    public function pickersandloadersdashboard()
    {
        return view('warehouse/pickersandloadersdashboard');
    }

    public function getpickersandloadersdashboard()
    {
        $data = DB::connection('sqlsrv2')->select('select * from viewPickingAndLoadingDashboard');
        // dd($data);
        return response()->json($data);
    }

    public function pickingticketmanager($ref)
    {
        $allproducts = DB::connection('sqlsrv3')
            ->select(
                'exec spGetPickingReferenceProducts ?',
                array($ref)
            );

        $getsequence = DB::connection('sqlsrv3')
            ->select(
                'exec spGetPickingReferenceToSequence ?',
                array($ref)
            );
        $pickingheader = DB::connection('sqlsrv3')
            ->select(
                'exec spGetPickingSheetHeader ?',
                array($ref)
            );
        $trucks = DB::connection('sqlsrv3')
            ->select('Select * from tblTrucks where intType=2');

        $teamleaders = DB::connection('sqlsrv3')
            ->select("Select * from tblDimsusers where strPickingTeams='TeamLeader'");

        return view('warehouse/pickingticketmanager')->with('teamleaders', $teamleaders)->with('pickingheader', $pickingheader)
            ->with('listproducts', $allproducts)->with('ref', $ref)->with('sequence', $getsequence)->with('trucks', $trucks);
    }

    public function teamleadermanage($ref)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            // If not authenticated, redirect to the login page
            return redirect()->route('login'); // 'login' should be replaced with your actual login route name
        }
        
        $allproducts = DB::connection('sqlsrv3')->select('exec spGetPickingReferenceProducts ?', array($ref));
        $horses = DB::connection('weights')->select("SELECT DISTINCT VEHICLE_REGISTRATION TruckId, VEHICLE_REGISTRATION TruckName FROM dims_trucks WHERE VEHICLE_TYPE = 'Horse'");
        $trailors = DB::connection('weights')->select("SELECT DISTINCT VEHICLE_REGISTRATION TruckId, VEHICLE_REGISTRATION TruckName FROM dims_trucks WHERE VEHICLE_TYPE = 'Trailer'");
        $pickers = DB::connection('sqlsrv2')->select("SELECT UserID, UserName FROM tblDimsusers");
        $stagingAreas = DB::connection('sqlsrv2')->select("SELECT * FROM tblStagingAreas");
        $tickets = DB::connection('weights')->select("SELECT TICKET_NUMBER strTicket FROM WB_Ticket_Trans WHERE SECOND_WEIGH_OPERATOR IS NULL");

        return view('warehouse/teamleadermanage')->with('ref', $ref)->with('listproducts', $allproducts)->with('horses', $horses)->with('trailors', $trailors)->with('pickers', $pickers)->with('stagingAreas', $stagingAreas)->with('tickets', $tickets);
    }

    public function getTeamLeaderPlans(Request $request){
        $date = $request->get('date');
        $userID = 8;//Auth::user()->UserID;
        $data = DB::connection('sqlsrv3')->select("exec spGetTeamLeaderPlans '$date',$userID");
        return response()->json($data);
    }

    public function teamLeaderAssign(Request $request){
        $ref = $request->get('ref');
        $horse = $request->get('horse');
        $trailorOne = $request->get('trailorOne');
        $trailorTwo = $request->get('trailorTwo');
        $picker = $request->get('picker');
        $loader = $request->get('loader');
        $staging = $request->get('staging');
        $ticket = $request->get('ticket');
        $userID = Auth::user()->UserID;

        $data = DB::connection('sqlsrv3')->select("exec spTeamLeaderAssignment '$ref', '$horse', '$trailorOne', '$trailorTwo', '$picker', '$loader', '$staging', '$ticket',$userID");
        return response()->json($data);
    }

    public function teamLeaderEquipmentAssign(Request $request){
        $ref = $request->get('ref');
        $belts = $request->get('belts');
        $ratchets = $request->get('ratchets');
        $tarps = $request->get('tarps');
        $dunnages = $request->get('dunnages');
        $pallets = $request->get('pallets');
        $plates = $request->get('plates');
        $nets = $request->get('nets');
        $stands = $request->get('stands');

        $data = DB::connection('sqlsrv3')->select("exec spTeamLeaderEquipmentAssign '$ref', $belts, $ratchets, $tarps, $dunnages, $pallets, $plates, $nets, $stands");

        return response()->json($data);
    }

    public function teamLeaderGetPickingPlanData(Request $request){
        $ref = $request->get('ref');
        $data = DB::connection('sqlsrv3')->select("exec spTeamLeaderGetAssignmentEquipmentNotifications '$ref'");
        return response()->json($data);
    }

    public function teamLeaderGetNotifications(Request $request){
        $ref = $request->get('ref');
        $data = DB::connection('sqlsrv3')->select("select * from viewTeamLeaderNotifications WHERE strUnickReference = '$ref'");
        return response()->json($data);
    }

    public function teamLeaderApproveNotification(Request $request){
        $id = $request->get('id');
        $approvedBy = Auth::user()->UserID;

        $data = DB::connection('sqlsrv3')->select("EXEC spTeamLeaderApproveNotification $id, $approvedBy");
        return response()->json($data);
    }

    public function teamLeaderGetInstructions(Request $request){
        $ref = $request->get('ref');

        $data = DB::connection('sqlsrv3')->select("EXEC spTeamLeaderGetInstructions '$ref'");
        return response()->json($data);
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
