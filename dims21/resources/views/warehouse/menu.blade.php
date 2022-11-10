<?php
if ((Auth::guest()))
{

}else{
    /*$v  =  new \App\Http\Controllers\SalesForm();
    $areaspage = $v->getThings(Auth::user()->GroupId,'areas');
    $departmentpage = $v->getThings(Auth::user()->GroupId,'departmentpage');
    $machines = $v->getThings(Auth::user()->GroupId,'machines');
    $createPalletConfig = $v->getThings(Auth::user()->GroupId,'createPalletConfig');
    
    $mapmachinestodept = $v->getThings(Auth::user()->GroupId,'mapmachinestodept');
    $bmapitemsmachinesdept = $v->getThings(Auth::user()->GroupId,'mapitemsmachinesdept');
    $mapitemstopallet = $v->getThings(Auth::user()->GroupId,'mapitemstopallet');
    $location = $v->getThings(Auth::user()->GroupId,'location');
    $createjobs = $v->getThings(Auth::user()->GroupId,'createjobs');
    $getJobStarted = $v->getThings(Auth::user()->GroupId,'getJobStarted');
    $stocklocation = $v->getThings(Auth::user()->GroupId,'stocklocation');
    $getjobsdata = $v->getThings(Auth::user()->GroupId,'getjobsdata');
    $printpalletsselectdept = $v->getThings(Auth::user()->GroupId,'printpalletsselectdept');*/

    $v  =  new \App\Http\Controllers\SalesForm();
    $areaspage = $v->getThings(Auth::user()->GroupId,'areaspage');
    $departmentpage = $v->getThings(Auth::user()->GroupId,'departmentpage');
    $machines = $v->getThings(Auth::user()->GroupId,'machines');
    $createPalletConfig = $v->getThings(Auth::user()->GroupId,'createPalletConfig');
    $mapmachinestoarea = $v->getThings(Auth::user()->GroupId,'mapmachinetoarea');
    $mapmachinestodept = $v->getThings(Auth::user()->GroupId,'mapmachinestodept');
    $mapitemsmachinesdept = $v->getThings(Auth::user()->GroupId,'mapitemsmachinesdept');
    $mapitemstopallet = $v->getThings(Auth::user()->GroupId,'mapitemstopallet');
    $location = $v->getThings(Auth::user()->GroupId,'location');
    $createjobs = $v->getThings(Auth::user()->GroupId,'createjobs');
    $palletreversal = $v->getThings(Auth::user()->GroupId,'palletreversal');
    $getJobStarted = $v->getThings(Auth::user()->GroupId,'getJobStarted');
    $stocklocation = $v->getThings(Auth::user()->GroupId,'stocklocation');
    $getjobsdata = $v->getThings(Auth::user()->GroupId,'getjobsdata');
    $printpalletsselectdept = $v->getThings(Auth::user()->GroupId,'printpalletsselectdept');
    $exceptionmvmntrpt = $v->getThings(Auth::user()->GroupId,'exceptionmovementreport');
    $creategroup = $v->getThings(Auth::user()->GroupId,'creategroup');
    $createuser = $v->getThings(Auth::user()->GroupId,'createuser');
    
}
?>
<a href= "{{ route('logout') }}"
   onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" style="background: #007bff;color: white;">
    Logout
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

@if($areaspage !="0")
<a href='{!!url("/areapage")!!}' class="areas">Areas</a> 
@endif

@if($departmentpage !="0")
<a href='{!!url("/departmentpage")!!}' class="departments">Departments</a>
@endif

@if($machines !="0")
<a href='{!!url("/machines")!!}'class="machines">Machines</a>
@endif

@if($createPalletConfig !="0")
<a href='{!!url("/createPalletConfig")!!}' class="palletConfig">Pallets Configurations</a>
@endif

@if($mapmachinestoarea !="0")
<a href='{!!url("/mapmachinetoarea")!!}' class="mapMachineToArea">Map Machine To Area</a> 
@endif

@if($mapmachinestodept !="0")
<a href='{!!url("/mapmachinestodept")!!}' class="mapMachineToDept">Map Machines To Dept</a>
@endif

@if($mapitemsmachinesdept !="0")
<a href='{!!url("/mapitemsmachinesdept")!!}' class="mapMachineDeptProd">Map Machines,Dept & Prod</a>
@endif

@if($mapitemstopallet !="0")
<a href='{!!url("/mapitemstopallet")!!}' class="mapPalletsToItems">Map Pallet To Items</a>
@endif

@if($location !="0")
<a href='{!!url("/location")!!}' class="locations">Locations</a>
@endif

@if($createjobs !="0")
<a href='{!!url("/createjobs")!!}' class="workOrders">Work Orders</a>
@endif

@if($getJobStarted !="0")
<a href='{!!url("/getJobStarted")!!}' class="WIP">WIP</a>
@endif

@if($stocklocation !="0")
<a href='{!!url("/stocklocation")!!}' class="stock">Stock</a>
@endif

@if($getjobsdata !="0")
<a href='{!!url("/getjobsdata")!!}' class="WOD">Work Orders Data</a>
@endif

@if($palletreversal !="0")
<a href='{!!url("/qrcodereversepallet")!!}' class="palletReversal">Pallet Reversal Code</a>
@endif

@if($printpalletsselectdept !="0")
<a href='{!!url("/printpalletsselectdept")!!}' class="paletLabel">Print Pallet Labels</a>
@endif

@if($exceptionmvmntrpt !="0")
<a href='{!!url("/exceptionmovementreport")!!}' class="report">Exception Mvmnt Rpt</a>
@endif

@if($creategroup !="0")
<a href='{!!url("/creategrouppage")!!}' class="creategroup">Create Groups</a>
@endif

@if($createuser !="0")
<a href='{!!url("/createuserpage")!!}' class="createuser">Create Users</a>
@endif