<?php
if ((Auth::guest()))
{

}else{
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

<nav class="sidebar">
	<ul class="main_side">
        <li>
			<a href="#" id="1">Add Components <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-1">
				<li>
					@if($areaspage !="0") 
                    <a href='{!!url("/areapage")!!}' class="areas">Areas</a> 
                    @endif 
				</li>
				<li>
					@if($departmentpage !="0") 
                    <a href='{!!url("/departmentpage")!!}' class="departments">Departments</a> 
                    @endif 
				</li>
                <li>
                    @if($machines !="0") 
                    <a href='{!!url("/machines")!!}' class="machines">Machines</a>
                    @endif 
                </li>
                <li>
                    @if($createPalletConfig !="0") 
                    <a href='{!!url("/createPalletConfig")!!}' class="palletConfig">Pallet Configurations</a>
                    @endif 
                </li>
                <li>
                    @if($location !="0")
                    <a href='{!!url("/location")!!}' class="locations">Locations</a>
                    @endif
                </li>
			</ul>
		</li>

		<li>
			<a href="#" id="2">Map Components <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-2">
				<li>
					@if($mapmachinestoarea !="0") 
                    <a href='{!!url("/mapmachinetoarea")!!}' class="mapMachineToArea">Map Machine To Area</a> 
                    @endif 
				</li>
				<li>
					@if($mapmachinestodept !="0")
                    <a href='{!!url("/mapmachinestodept")!!}' class="mapMachineToDept">Map Machines To Department</a> 
                    @endif 
				</li>
                <li>
					@if($mapitemsmachinesdept !="0") 
                    <a href='{!!url("/mapitemsmachinesdept")!!}' class="mapMachineDeptProd">Map Machines, Deptartment & Product</a>
                    @endif 
				</li>
				<li>
					@if($mapitemstopallet !="0")
                    <a href='{!!url("/mapitemstopallet")!!}' class="mapPalletsToItems">Map Pallet To Items</a> 
                    @endif
				</li>
			</ul>
		</li>

        <li>
			<a href="#" id="3">Job Data <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-3">
				<li>
					@if($createjobs !="0")
                    <a href='{!!url("/createjobs")!!}' class="workOrders">Work Orders</a>
                    @endif
				</li>
				<li>
					@if($getJobStarted !="0")
                    <a href='{!!url("/getJobStarted")!!}' class="WIP">Work In Progress</a>
                    @endif
				</li>
                <li>
                    @if($getjobsdata !="0")
                    <a href='{!!url("/getjobsdata")!!}' class="WOD">Work Orders Data</a>
                    @endif
                </li>
			</ul>
		</li>

        <li>
			<a href="#" id="4">Stock <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-4">
				<li>
					@if($stocklocation !="0")
                    <a href='{!!url("/stocklocation")!!}' class="stock">Stock Location</a>
                    @endif
				</li>
				<li>
					@if($exceptionmvmntrpt !="0")
                    <a href='{!!url("/exceptionmovementreport")!!}' class="report">Exception Movement Report</a>
                    @endif
				</li>
			</ul>
		</li>

        <li>
			<a href="#" id="5">Users <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-5">
				<li>
					@if($creategroup !="0")
                    <a href='{!!url("/creategrouppage")!!}' class="creategroup">Create Groups</a>
                    @endif
				</li>
				<li>
					@if($createuser !="0")
                    <a href='{!!url("/createuserpage")!!}' class="createuser">Create Users</a>
                    @endif
				</li>
			</ul>
		</li>

        <li>
			<a href="#" id="6">Miscellaneous <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-6">
				<li>
					@if($palletreversal !="0")
                    <a href='{!!url("/qrcodereversepallet")!!}' class="palletReversal">Pallet Reversal Code</a>
                    @endif
				</li>
				<li>
					@if($printpalletsselectdept !="0")
                    <a href='{!!url("/printpalletsselectdept")!!}' class="paletLabel">Print Pallet Labels</a>
                    @endif
				</li>
			</ul>
		</li>

        <li style="position:absolute; bottom:0; width:95%;">
            <a href= "{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <img  src="{{url('/images/logo-02.png')}}" style="height: 70px; width: 95%; padding:12px;">
        </li>

        <li>
            
        </li>


	</ul>
</nav>