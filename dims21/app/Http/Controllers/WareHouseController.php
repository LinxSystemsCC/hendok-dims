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


class WareHouseController extends Controller
{

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
    public function joblabelassign(){
        $userid =  Auth::user()->UserID;

              $returnmach = DB::connection('sqlsrv3')
            ->select('exec spGetWarehousemachines ?',
                array($userid)
            );
        return view('warehouse/jobqrcode');
    }
    public function initiateproductonmachine(){
        $userid =  Auth::user()->UserID;

        $returnmach = DB::connection('sqlsrv3')
            ->select('exec spGetProductByWarehouseDept ?',
                array($userid)
            );
        return view('warehouse/initiateproducts');
    }
    public function createPalletConfig(){
        return view('warehouse/palletsconf');
    }
    public function departmentpage(){
        return view('warehouse/departments');
    }
    public function machinespage(){
        return view('warehouse/machines');
    }
    public function location(){
        $LocationTypes = DB::connection('sqlsrv2')
            ->select("select * from tblLocationTypes");
        $getBinLevel=DB::connection('sqlsrv2')
            ->select('Select * from tblBinLevel');

        $getBinRows=DB::connection('sqlsrv2')
            ->select('Select * from tblBinRows');

        $getLocations=DB::connection('sqlsrv2')
            ->select('Select * from tblLocationNames order by strLocationName');
        return view('warehouse/locations')->with('locationtypes',$LocationTypes)
            ->with('binrows',$getBinRows)
            ->with('locations',$getLocations)
            ->with('binlevel',$getBinLevel);
    }
    public function qrcodeimage($binlocation){
        return view('warehouse/qrcodeimagebin')->with('ID',$binlocation);
    }
    public function qrcodereversepallet(){
        return view('warehouse/palletreverseqrcode');
    }
    public function qrcodebreakpallet(){
        return view('warehouse/palletbreak');
    }
    public function savenewbin(Request $request){

        $binname = $request->get("binname");
        $intRowNumber = $request->get("intRowNumber");
        $intLevelNumber = $request->get("intLevelNumber");
        $locations = $request->get("locations");
        DB::connection('sqlsrv2')->table('tblBinNames')->insert(
            ['strBin' => $binname,'intRowNumber'=>$intRowNumber ,'intLevelNumber'=>$intLevelNumber,'intLocationId'=>$locations]
        );


    }
    public function getLocationNamesAndTypes(){
        $locationname = DB::connection('sqlsrv2')
            ->select("select * from tblLocationNames inner join tblLocationTypes on tblLocationNames.intLocationTypeId = tblLocationTypes.intLocationTypeId  order by intLocationNameId ");

        $LocationTypes = DB::connection('sqlsrv2')
            ->select("select * from tblLocationTypes");

        $outPut["locationname"] = $locationname;
        $outPut["locationtypes"] = $LocationTypes;
        return response()->json($outPut);
    }
    public function createjobs(){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        $prodGroups = DB::connection('sqlsrv2')
            ->select("select * from viewItemGroups order by ItemGroupDescription");
        return view('warehouse/createjobs')->with('prodGroups',$prodGroups)->with('dept',$dept);
    }
    public function getBinLocationsJson(){
        $getBins=DB::connection('sqlsrv2')
            ->select('Select * from tblBinNames n inner join tblLocationNames l on n.intLocationId = l.intLocationNameId');
        return response()->json($getBins);
    }
    public function getProdCategory(Request $request){
        $ItemGroup = $request->get("ItemGroup");
        $prodCategory = DB::connection('sqlsrv2')
            ->select("select * from viewItemCategory where ItemGroup ='".$ItemGroup."' order by strProductCategory");
        return response()->json($prodCategory);
    }
    public function saveLocationType(Request $request){
        $locationtype = $request->get("locationtype");

        $result = DB::connection('sqlsrv3')->table('tblLocationTypes')->insert(
            ['strLocationType' => $locationtype]);
        return response()->json($result);
    }
    public function saveLocationName(Request $request){
        $locationtype = $request->get("locationtypeid");
        $strLocationName = $request->get("strLocationName");

        $result = DB::connection('sqlsrv3')->table('tblLocationNames')->insert(
            ['strLocationName' => $strLocationName,'intLocationTypeId' => $locationtype]);
        return response()->json($result);
    }
    public function getProdListToPlan(Request $request){
        $ItemGroup = $request->get("ItemGroup");
        $strProductCategory = $request->get("strProductCategory");
        $prodCategory = DB::connection('sqlsrv2')
            //->select("select * from viewItemsToPlanJob where ItemGroup ='".$ItemGroup."' and strProductCategory='".$strProductCategory."' order by strItemName");
            ->select("select DISTINCT i.* from viewItemsToPlanJob i inner join tblMappedDeptMachinesItems mis on mis.strItemCode collate database_default = i.strItemCode  where ItemGroup ='".$ItemGroup."' order by strItemName");
        return response()->json($prodCategory);
    }
    //For printing pallets
    public function printpalletsselectdept(){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        return view('warehouse/printpalletcodes')->with('departments',$dept);
    }
    public function qrcodetracker(){
        return view('warehouse/qrcodetracker');
    }
    public function stocklocation(){
        /*$dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");*/

        $products = DB::connection('sqlsrv2')->select("select * from viewtblProducts");
        return view('warehouse/stocklocations')->with('products',$products);

    }

    public function stockdetails($productcode){
        //dd($productcode);
        return view('warehouse/stockdetails')->with('productCode',$productcode);
    }

    public function exceptionmovementreport(){
        return view('warehouse/exceptionmovementreport');
    }

    public function printlocationqrcodes($location){

        return view('warehouse/printlocationqrcodes')->with('ID',$location);
    }
    public function getviewGridStockSummary(Request $request){

        $gridstock = DB::connection('sqlsrv2')
            ->select("select * from  viewWareHouseTransferStockQty");
        return response()->json($gridstock);
    }

    public function getpalletmovementreport(Request $request){
        //$palletReport = DB::connection('sqlsrv2')->select("select * from viewPalletExceptionRpt");
        //return response()->json($palletReport);
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $returndata = DB::connection('sqlsrv2') ->select('exec spPalletExceptionRpt ?,?', array($datefrom,$dateto));
        return response()->json($returndata);
        //spPalletExceptionRpt
    }

    public function getitemmovementreport(Request $request){
        /*$itemreport = DB::connection('sqlsrv2')->select("select * from ");
        return response()->json($itemreport);*/
    }

    public function getpalletreversalreport(Request $request){
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $reversalreport = DB::connection('sqlsrv2')->select("select * from viewPalletReversalRpt where dteTimeCreate between '$datefrom' and '$dateto'");
        return response()->json($reversalreport);
    }

    public function getviewGridStockBalance(Request $request){
        $ItemCode = $request->get("ItemCode");
        $gridstock = DB::connection('sqlsrv2')
            ->select("select * from viewBinLocationDetailsBalance where  strErpItemCode ='".$ItemCode."'");
        return response()->json($gridstock);
    }

    public function getviewGridStockReport(Request $request){
        $ItemCode = $request->get("ItemCode");
        $gridstock = DB::connection('sqlsrv2')
            ->select("select * from viewLastKnownMovement where  strErpItemCode ='".$ItemCode."' order by dteTimeCreate");
        return response()->json($gridstock);
    }

    public function choosemachine($itemCode){
      /*  $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);*/

          $machines = DB::connection('sqlsrv2')
              ->select('exec spGetMachineByProduct ?',
                  array($itemCode)
              );
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spSelectItemsConfigurations ? ",
                array($itemCode)
            );
        return view('warehouse/choosemachine')->with('machines',$machines)->with('pallets',$palletsjson);
    }
    //
    public function printpalletchoosemachine($deparment){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);

          $machines = DB::connection('sqlsrv2')
              ->select('exec spGetMachinesByDept ?',
                  array($deparment)
              );
        return view('warehouse/printpalletchoosemachine')->with('departments',$dept)->with('machines',$machines);
    }

    public function getMachinesforselecteddept(Request $request){
        $deparment = $request->get("deptId");
        $prodname = $request->get("prodname");
        $machines = DB::connection('sqlsrv2')
            ->select('exec spGetMachinesByDept ?,?',
                array($deparment,$prodname)
            );
        return response()->json($machines);
    }
    public function getPalletForSelectedItem(Request $request){

        $itemCode = $request->get("itemCode");
        $intMachine = $request->get("intMachine");
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spSelectItemsConfigurations ?,? ",
                array($itemCode,$intMachine)
            );
        return response()->json($palletsjson);
    }
    public function startendjob(Request $request){

        $jobid= $request->get("jobid");
        $finalisestatus = $request->get("finalisestatus");

        $JOBSTATUS = DB::connection('sqlsrv2')
            ->select("EXEC spUpdateStartEndJob ?,? ",
                array($jobid,$finalisestatus)
            );
        return response()->json($JOBSTATUS);
    }
    public function validatepalletsplan(Request $request){
        $intPalletId = $request->get("intPalletId");
        $qtyproduce = $request->get("qtyproduce");
        $palletconf = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = $intPalletId") ;

        return response()->json($palletconf);
    }
    public function mapmachinestodept(){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");

          $machines = DB::connection('sqlsrv2')
              ->select('SELECT * FROM tblMachines WHERE intAutoMachineID NOT IN  (SELECT intMachineID FROM tblMapMachineToDept where intStatus = 1) '
              );
        return view('warehouse/mapmachinetodept')->with('departments',$dept)->with('machines',$machines);
    }
    public function choosproducttomake($qty,$itemcode,$palletid,$machinenid){

        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines where intAutoMachineID = ".$machinenid);

        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = ".$palletid);


        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts where PastelCode = '".$itemcode."'");

        return view('warehouse/chooseproducttomake')->with('pallet',$pallets)->with('machines',$machines)->with('products',$products)->with('qty',$qty);
    }
    //print pallet
    public function printpalletchoosproducttomake($deparment,$machine){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);

        $machines = DB::connection('sqlsrv2')
            ->select("select strMachineName,intAutoMachineID intMachineID from tblMachines where intAutoMachineID =".$machine);
       /* $machines = DB::connection('sqlsrv2')
            ->select('exec spGetMachinesByDept ?',
                array($deparment)
            );*/
        $products = DB::connection('sqlsrv2')
            ->select('exec spGetProductsToPrint ?,?',
                array($machine,$deparment)
            );
    //    dd($products);
        return view('warehouse/printpalletchooseproducttomake')->with('departments',$dept)->with('machines',$machines)->with('products',$products)->with('departmentselected',$deparment);
    }
    public function getProductPlannedOnThatMachine(Request $request){
        $machineid = $request->get("machineId");
        $productonmachine = DB::connection('sqlsrv2')
            ->select('exec spGetProductCurrentlyPlannedOnSpecificMachine ? ',
                array($machineid)
            );
        return response()->json($productonmachine);
    }
    public function endjob(Request $request){
        $jobid = $request->get("jobid");
        $endjob = $request->get("endjob");
        $endjob= (new \DateTime($endjob))->format('Y-m-d H:i:s') ;
        $result =  DB::connection('sqlsrv2')->table('tblJobQrcodeAllocation')
            ->where('intJobId',$jobid )
            ->update(['dteJobEnded' => endjob ]);
        return response()->json($result);
    }
    public function updatestartdate(Request $request){
        $jobid = $request->get("jobid");
        $startdate = $request->get("startdate");
        $startdate = (new \DateTime($startdate))->format('Y-m-d') ;
        $result =  DB::connection('sqlsrv2')->table('tblJobQrcodeAllocation')
            ->where('intJobId',$jobid )
            ->update(['dteStartDate' => $startdate ]);

        $sessionUserId = Auth::user()->UserID;
        $UserName = Auth::user()->UserName;

        DB::connection('sqlsrv3')->table('tblManagementConsol')->insert(
            ['ConsoleTypeId' => 818, 'Importance' => 1,'LoggedBy' => $UserName,'Message' => "Estimated Start Date Changeb by ".$UserName." For Job NO# ".$jobid." To ".$startdate,
                'UserId' => $sessionUserId,'OrderId' => $jobid,'DocNumber'=>$jobid]);
        return response()->json($result);
    }
    public function getWIP(Request $request){

        $productonmachine = DB::connection('sqlsrv2')
            ->select('exec spGetProductCurrentlyPlanned '
            );
        return response()->json($productonmachine);
    }
    public function getWIPjobstarted(Request $request){

        $productonmachine = DB::connection('sqlsrv2')
            ->select('exec spGetProductInProgress '
            );
        return response()->json($productonmachine);
    }
    public function getjobsdatajson(Request $request){
        $datefrom = $request->get("datefrom");
        $dateto = $request->get("dateto");
        $datefrom = (new \DateTime($datefrom))->format('Y-m-d');
        $dateto = (new \DateTime($dateto))->format('Y-m-d');

        $returndata = DB::connection('sqlsrv2')
            ->select('exec spGetProductInProgressdate ?,?',
                array($datefrom,$dateto)
            );
        return response()->json($returndata);
    }
    public function getJobStarted(){
        return view('warehouse/wip');
    }
    public function getjobsdata(){
        return view('warehouse/getjobsdata');
    }
    public function goprintfirstqrcode($deparment,$machine,$productcode,$palletid,$qty){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);
        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines where intAutoMachineID = ".$machine);

        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = ".$palletid);


        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts where PastelCode = '".$productcode."'");

        return view('warehouse/goprintfirstqrcode')->with('departments',$dept)->with('machines',$machines)->with('qty',$qty)
            ->with('products',$products)->with('pallets',$pallets);
    }

    public function startprintingjob($qty,$machine,$productcode,$palletid,$start){
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
            ->select('exec spInsertNewJob ?,?,?,?,?,?',
                array($productcode,$machine,$palletid,$qty,"12345",$start)
            );
        $htmlqrcode = "";
        foreach ($returnmach as $val){
           /*$htmlqrcode .="Item Code :".$val->strItemCode."<br>";
           $htmlqrcode .="Required :".$val->mnyQtyRequired."<br>";
           $htmlqrcode .="Machine  :".$val->strMachineName."<br>";
           $htmlqrcode .="Department  :".$val->strDeptName."<br>";
           $htmlqrcode .="Time Created  :".$val->dteJobCreated."<br>";
           $htmlqrcode .="By:".$val->strOperator."<br>";*/
           $htmlqrcode .="JOB NO :".$val->intJobId.":D".$val->strDeptName.":M".$val->strMachineName."By:".$val->strOperator.":T".$val->dteJobCreated;
        }

        return view('warehouse/joblabel')->with('qrcodeothers',$returnmach)->with('qrcode',$htmlqrcode);
    }
    public function sendLabelToThePrinter(Request $request){
        $qty = $request->get('qty');
        $type= $request->get('type');
        $jobid= $request->get('jobid');
        $isNEW= $request->get('isnew');

        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t=time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t.$randomString;

        for($i = 0;$i < $qty ;$i++)
        {
             DB::connection('sqlsrv2')
                ->statement('exec spInserPalletLabelToPrint ?,?,?',
                    array($type,$jobid,$ID)
                );
        }
        if($isNEW != "reprint"){
            DB::connection('sqlsrv2')
                ->statement('exec spUpdateUnitsProduced ?,?',
                    array($type,$jobid)
                );
        }

        $v  =  new \App\Http\Controllers\SalesForm();
        $GroupId= Auth::user()->GroupId;
        if($v->getThings($GroupId,'Print Pallet')){
        }

        return "Success";
    }
    public function doneprintingpallet(){
        return view('warehouse/doneprintingpallet');
    }

    public function jobupdateprint($jobid){
        //
     /*   $returnmach = DB::connection('sqlsrv2')
            ->select('exec spInsertNewJob ?,?,?,?,?,?',
                array($productcode,$machine,$palletid,$qty,"12345",$start)
            );*/
        $jobdata = DB::connection('sqlsrv3')
            ->select('exec spGetProductPlannedDetails ?',
                array($jobid));
        return view('warehouse/updatejob')->with("jobdata",$jobdata)->with("id",$jobid);
    }
    public function insertIntoJobTable(Request $request){
        $deptId = $request->get("deptId");
        $prodgroup = "0"; //$request->get("prodgroup");
        $productcategory= $request->get("productcategory");
        $prodname = $request->get("prodname");
        $machinename = $request->get("machinename");
        $qty = $request->get("qty");
        $palletconfig = $request->get("palletconfig");
        //$startdate = $request->get("startdate");

        $startdate = (new \DateTime($request->get('startdate')))->format('Y-m-d');

        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spInsertNewJob ?,?,?,?,?,?,?,?',
                array($deptId,$prodgroup,$productcategory,$prodname,$machinename,$qty,$startdate,$palletconfig)
            );
        return response()->json($returnmach);

    }
    //Start Generating The Qr code
    public function startgenratingqrcodeforpallet($jobId){
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spInsertNewPalletPrint ?',
                array($jobId)
            );
        $htmlqrcode = "";
        foreach ($returnmach as $val){
           /*$htmlqrcode .="Item Code :".$val->strItemCode."<br>";
           $htmlqrcode .="Required :".$val->mnyQtyRequired."<br>";
           $htmlqrcode .="Machine  :".$val->strMachineName."<br>";
           $htmlqrcode .="Department  :".$val->strDeptName."<br>";
           $htmlqrcode .="Time Created  :".$val->dteJobCreated."<br>";
           $htmlqrcode .="By:".$val->strOperator."<br>";*/
           $htmlqrcode .="JOB NO :".$val->intJobId.": P".$val->palletJobPrint.":M".$val->strMachineName.":T".$val->dteJobCreated;
        }

        return view('warehouse/palletjoblabel')->with('qrcodeothers',$returnmach)->with('qrcode',$htmlqrcode)->with('jobid',$jobId);
    }
    public function mapitemstopallet(){
        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf");
            

        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts");
            return view('warehouse/mapitemstopallet')->with('pallets',$pallets)->with('products',$products);
    }
    public function mapdeptitem(){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");

        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines");

        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts");
        return view('warehouse/mapitemstomachineanddept')->with('departments',$dept)->with('products',$products)->with('machines',$machines);
    }
    public function getMappedItemstoPalletJson(){
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spMappedItemsToPallets ");
        return response()->json($palletsjson);
    }
    public function getMappedDepartmentsMachinesItemasJson(){
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spMappedDepartmentMachineItems ");
        return response()->json($palletsjson);
    }
    public function getPalletsJson(){
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetPalletsConfig ");
        return response()->json($palletsjson);
    }
    public function getMachinesmappedtodept(){
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetMappedMachinesToDept ");
        return response()->json($palletsjson);
    }
    public function getDeptname(){
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetDepNames ");
        return response()->json($palletsjson);
    }
    public function getpalletconfforitems(Request $request){
        $productcode= $request->get("productcode");
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spSelectItemsConfigurations ? ",
                array($productcode)
            );
        return response()->json($palletsjson);
    }
    public function getMachines(){
        $palletsjson = DB::connection('sqlsrv2')
            ->select("EXEC spGetMachines ");
        return response()->json($palletsjson);
    }
    public function savesPalletsPost(Request $request){
        $palletquantity = $request->get("palletquantity");
        $pallettypedesc = $request->get("pallettypedesc");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spCreatePalletConf ?,?',
                array($palletquantity,$pallettypedesc)
            );
        return response()->json($returnmach);
    }
    public function savesMachinemaptodept(Request $request){
        $machineid = $request->get("machineid");
        $deptid = $request->get("deptid");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec [spMapMachinesToDept] ?,?',
                array($machineid,$deptid)
            );
        return response()->json($returnmach);
    }
    public function savesdeptname(Request $request){
        $deptname = $request->get("deptname");

        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spCreateDepartment ?',
                array($deptname)
            );
        return response()->json($returnmach);
    }
    public function savesmachines(Request $request){
        $machines = $request->get("machinenames");

        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spCreateMachines ?',
                array($machines)
            );
        return response()->json($returnmach);
    }
    public function savespalletstoitems(Request $request){

        $pallettypedesc = $request->get("pallettypedesc");
        $productcode = $request->get("productcode");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spMapPalletsToItems ?,?',
                array($productcode,$pallettypedesc)
            );
        return response()->json($returnmach);
    }
    public function savesmachinedeptitems(Request $request){

        $machine = $request->get("machine");
        $department = $request->get("department");
        $productcode = $request->get("productcode");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spMapDeptMachineItems ?,?,?',
                array($productcode,$machine,$department)
            );
        return response()->json($returnmach);
    }
    public function updateDeptName(Request $request){

        $thedeptname = $request->get("thedeptname");
        $palletid = $request->get("palletid");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spUpdateDepartments ?,?',
                array($palletid,$thedeptname)
            );
        return response()->json($returnmach);
    }
    public function updateMachineName(Request $request){

        $themachinename = $request->get("themachinename");
        $machineid= $request->get("machineid");
        //
        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spUpdateMachines ?,?',
                array($machineid,$themachinename)
            );
        return response()->json($returnmach);
    }
    public function removemapping(Request $request){

        $mappingId = $request->get("mappingId");
        DB::connection('sqlsrv2')->table('tblMapItemsToPallets')
            ->where('intMappingId',$mappingId )
            ->update(['intStatus' => 2]);


    }
    public function unmapmachinefromdept(Request $request){

        $mappingId = $request->get("mappingId");
        DB::connection('sqlsrv2')->table('tblMapMachineToDept')
            ->where('intAutoMappedMachineDept',$mappingId )
            ->update(['intStatus' => 2]);


    }
    public function removemappingdeptmachitems(Request $request){

        $mappingId = $request->get("mappingId");
        DB::connection('sqlsrv2')->table('tblMappedDeptMachinesItems')
            ->where('intAutoMappedDeptMachItemID',$mappingId )
            ->update(['intStatus' => 2]);
    }


}
