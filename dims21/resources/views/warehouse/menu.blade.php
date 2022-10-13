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
@if($createPalletConfig !="0")
<a href='{!!url("/createPalletConfig")!!}'>Pallets Configurations</a>
@endif
@if($mapitemstopallet !="0")
<a href='{!!url("/mapitemstopallet")!!}' >Map Pallet To Items</a>
@endif
@if($departmentpage !="0")
<a href='{!!url("/departmentpage")!!}'>Departments</a>
@endif
@if($machines !="0")
<a href='{!!url("/machines")!!}'>Machines</a>
@endif
@if($mapmachinestodept !="0")
<a href='{!!url("/mapmachinestodept")!!}' >Map Machines To Dept</a>
@endif
@if($bmapitemsmachinesdept !="0")
<a href='{!!url("/mapitemsmachinesdept")!!}'>Map Machines,Dept & Prod</a>
@endif
@if($createjobs !="0")
<a href='{!!url("/createjobs")!!}'   >Create Jobs</a>
@endif
@if($printpalletsselectdept !="0")
<a href='{!!url("/printpalletsselectdept")!!}' >Print Pallet Labels</a>
@endif
@if($location !="0")
<a href='{!!url("/location")!!}'  >Locations</a>
@endif
@if($stocklocation !="0")
<a href='{!!url("/stocklocation")!!}' >Stock</a>
@endif
@if($getJobStarted !="0")
<a href='{!!url("/getJobStarted")!!}'>WIP</a>
@endif
<a href="#">Jobs Data</a>
