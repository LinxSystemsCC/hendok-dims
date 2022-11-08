<?php
if ((Auth::guest()))
{

}else{
    $v  =  new \App\Http\Controllers\SalesForm();
    $createPalletConfig = $v->getThings(Auth::user()->GroupId,'createPalletConfig');
    $mapitemstopallet = $v->getThings(Auth::user()->GroupId,'mapitemstopallet');
    $departmentpage = $v->getThings(Auth::user()->GroupId,'departmentpage');
    $machines = $v->getThings(Auth::user()->GroupId,'machines');
    $mapmachinestodept = $v->getThings(Auth::user()->GroupId,'mapmachinestodept');
    $bmapitemsmachinesdept = $v->getThings(Auth::user()->GroupId,'mapitemsmachinesdept');
    $createjobs = $v->getThings(Auth::user()->GroupId,'createjobs');
    $printpalletsselectdept = $v->getThings(Auth::user()->GroupId,'printpalletsselectdept');
    $location = $v->getThings(Auth::user()->GroupId,'location');
    $stocklocation = $v->getThings(Auth::user()->GroupId,'stocklocation');
    $getJobStarted = $v->getThings(Auth::user()->GroupId,'getJobStarted');
    $getjobsdata = $v->getThings(Auth::user()->GroupId,'getjobsdata');
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

<a href='{!!url("/areapage")!!}' class="areas">Areas</a> 

@if($departmentpage !="0")
<a href='{!!url("/departmentpage")!!}' class="departments">Departments</a>
@endif

@if($machines !="0")
<a href='{!!url("/machines")!!}'class="machines">Machines</a>
@endif

@if($createPalletConfig !="0")
<a href='{!!url("/createPalletConfig")!!}' class="palletConfig">Pallets Configurations</a>
@endif

<a href='{!!url("/mapmachinetoarea")!!}' class="mapMachineToArea">Map Machine To Area</a> 

@if($mapmachinestodept !="0")
<a href='{!!url("/mapmachinestodept")!!}' class="mapMachineToDept">Map Machines To Dept</a>
@endif

@if($bmapitemsmachinesdept !="0")
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

@if($getJobStarted !="0")
<a href='{!!url("/getJobStarted")!!}' class="WIP">WIP</a>
@endif

@if($stocklocation !="0")
<a href='{!!url("/stocklocation")!!}' class="stock">Stock</a>
@endif

@if($getjobsdata !="0")
<a href='{!!url("/getjobsdata")!!}' class="WOD">Work Orders Data</a>
@endif

<a href='{!!url("/qrcodereversepallet")!!}' class="palletReversal">Pallet Reversal Code</a>

@endif
@if($printpalletsselectdept !="0")
<a href='{!!url("/printpalletsselectdept")!!}' class="paletLabel">Print Pallet Labels</a>
@endif

<a href='{!!url("/exceptionmovementreport")!!}' class="report">Exception Mvmnt Rpt</a>





