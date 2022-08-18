<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 2018/11/21
 * Time: 15:25
 */

namespace App\Http\Controllers;
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
    public function createjobs(){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        return view('warehouse/createjobs')->with('departments',$dept);
    }
    //For printing pallets
    public function printpalletsselectdept(){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");
        return view('warehouse/printpalletcodes')->with('departments',$dept);
    }
    public function choosemachine($deparment){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);

          $machines = DB::connection('sqlsrv2')
              ->select('exec spGetMachinesByDept ?',
                  array($deparment)
              );
        return view('warehouse/choosemachine')->with('departments',$dept)->with('machines',$machines);
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
    public function mapmachinestodept(){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments");

          $machines = DB::connection('sqlsrv2')
              ->select('SELECT * FROM tblMachines WHERE intAutoMachineID NOT IN  (SELECT intMachineID FROM tblMapMachineToDept where intStatus = 1) '
              );
        return view('warehouse/mapmachinetodept')->with('departments',$dept)->with('machines',$machines);
    }
    public function choosproducttomake($deparment,$machine){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);
        $machines = DB::connection('sqlsrv2')
            ->select('exec spGetMachinesByDept ?',
                array($deparment)
            );
        $products = DB::connection('sqlsrv2')
            ->select('exec spGetProdByDeptByMachines ?,?',
                array($deparment,$machine)
            );
        return view('warehouse/chooseproducttomake')->with('departments',$dept)->with('machines',$machines)->with('products',$products);
    }
    //print pallet
    public function printpalletchoosproducttomake($deparment,$machine){
        $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);
        $machines = DB::connection('sqlsrv2')
            ->select('exec spGetMachinesByDept ?',
                array($deparment)
            );
        $products = DB::connection('sqlsrv2')
            ->select('exec spGetProductsToPrint ?,?',
                array($machine,$deparment)
            );
    //    dd($products);
        return view('warehouse/printpalletchooseproducttomake')->with('departments',$dept)->with('machines',$machines)->with('products',$products)->with('departmentselected',$deparment);
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
    public function startprintingjob($deparment,$machine,$productcode,$palletid,$qty,$estimatedpallets,$operatornumber){
       /* $dept = DB::connection('sqlsrv2')
            ->select("select * from tblDepartments where intAutoID =".$deparment);
        $machines = DB::connection('sqlsrv2')
            ->select("select * from tblMachines where intAutoMachineID = ".$machine);

        $pallets = DB::connection('sqlsrv2')
            ->select("select * from tblPalletConf where intPalletId = ".$palletid);


        $products = DB::connection('sqlsrv2')
            ->select("select * from viewtblProducts where PastelCode = '".$productcode."'");*/


        $returnmach = DB::connection('sqlsrv2')
            ->select('exec spInsertNewJob ?,?,?,?,?,?,?',
                array($productcode,$machine,$deparment,$palletid,$qty,$operatornumber,$estimatedpallets)
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

        return view('warehouse/palletjoblabel')->with('qrcodeothers',$returnmach)->with('qrcode',$htmlqrcode);
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
