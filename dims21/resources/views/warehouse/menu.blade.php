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
    <!-- logo --> 
    <img  src="{{url('/images/HendokLogoTransparent.png')}}" style="height: 70px; width: 100%; padding: 15px 35px 0px 20px;">

	<ul class="main_side">
        <!-- Work Orders -->
        <li>
			<!-- Fisrt Category -->
            <a href="#" id="1">Work Orders<span class="caret pull-down"></span>
			</a>
			<ul class="item-show-1">
				<li>
                    @if($createjobs !="0")
                    <a href='{!!url("/createjobs")!!}'>Create Work Orders</a>
                    @endif
                </li>
                <li>
                    @if($getJobStarted !="0")
                    <a href='{!!url("/getJobStarted")!!}'>Work In Progress</a>
                    @endif
                </li>
                <li>
                    @if($getjobsdata !="0")
                    <a href='{!!url("/getjobsdata")!!}'>Work Orders Data</a>
                    @endif
                </li>
			</ul>
		</li>

        <!-- Dispatch -->
        <li>
			<!-- Fisrt Category -->
            <a href="#" id="2">Dispatch<span class="caret pull-down"></span>
			</a>
			<ul class="item-show-2">
				<li>
                    <!-- Second Category -->
                    <a href="#" id="2a">Load Planning<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-2a">
                        <!-- Item Links -->
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/viewpickingtickets")!!}'>Picking Tickets</a>
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/routeplanner")!!}'>Picking Planner</a>
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/viewAwaitingtoinvoice")!!}'>Routes To Invoice</a>
                            @endif
                        </li>

                    </ul>

                    <a href="#" id="2b">Picking Slips<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-2b">
                        <!-- Item Links -->
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/liveBulkPicking")!!}'>Picking Status</a>
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/viewpickingtickets")!!}'>Picking Tickets</a>
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/assignweighbridgeticket")!!}'>Assign Weight Tickets</a>
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/getPickingAuth")!!}'>Authorise Picking</a>
                            @endif
                        </li>
                    </ul>

                    <a href="#" id="2c">Settlement<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-2c">
                        <!-- Item Links -->
                        <li>
                            Comming Soon
                        </li>
                    </ul>

                    <a href="#" id="2d">Authorisation<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-2d">
                        <!-- Item Links -->
                        <li>
                            Comming Soon
                        </li>
                    </ul>
                </li>
			</ul>
		</li>

        <!-- Stock Control -->
        <li>
			<!-- Fisrt Category -->
            <a href="#" id="3">Stock Control<span class="caret pull-down"></span>
			</a>
			<ul class="item-show-3">
				<li>
                    <!-- Second Category -->
                    <a href="#" id="3a">Returns<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-3a">
                        <!-- Item Links -->
                        <li>
                            1
                        </li>
                        <li>
                            2
                        </li>
                    </ul>

                    <a href="#" id="3b">Upliftment Vouchers<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-3b">
                        <!-- Item Links -->
                        <li>
                            1
                        </li>
                        <li>
                            2
                        </li>
                    </ul>
                </li>
			</ul>
		</li>

        <!-- Inventory -->
        <li>
			<!-- Fisrt Category -->
            <a href="#" id="4">Inventory<span class="caret pull-down"></span>
			</a>
			<ul class="item-show-4">
				<li>
                    <!-- Second Category -->
                    <a href="#" id="4a">Stock on Hand<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-4a">
                        <!-- Item Links -->
                        <li>
                            @if($stocklocation !="0")
                            <a href='{!!url("/stocklocation")!!}'>Stock Location</a>
                            @endif
                        </li>
                    </ul>

                    <a href="#" id="4b">Stock Count<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-4b">
                        <!-- Item Links -->
                        <li>
                            @if($exceptionmvmntrpt !="0")
                            <a href='{!!url("/exceptionmovementreport")!!}'>Exception Movement Report</a>
                            @endif
                        <li>
                    </ul>
                </li>
			</ul>
		</li>

        <!-- Setup -->
        <li>
			<!-- Fisrt Category -->
            <a href="#" id="5">Setup<span class="caret pull-down"></span>
			</a>
			<ul class="item-show-5">
				<li>
                    <!-- Second Category -->
                    <a href="#" id="5a">Users/Groups<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-5a">
                        <!-- Item Links -->
                        <li>
                            @if($creategroup !="0")
                            <a href='{!!url("/creategrouppage")!!}'>Create Groups</a>
                            @endif
                        </li>
                        <li>
                            @if($createuser !="0")
                            <a href='{!!url("/createuserpage")!!}'>Create Users</a>
                            @endif
                        </li>
                    </ul>

                    <a href="#" id="5b">Dispatch<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-5b">
                        <!-- Item Links -->
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/drivers")!!}'>Drivers</a>
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/trucks")!!}'>Trucks</a>
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/routes1")!!}'>Routes</a>
                            @endif
                        </li>
                    </ul>

                    <a href="#" id="5c">Stock<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-5c">
                        <!-- Item Links -->
                        <li>
                            @if($areaspage !="0") 
                            <a href='{!!url("/areapage")!!}'>Areas</a> 
                            @endif 
                        </li>
                        <li>
                            @if($departmentpage !="0") 
                            <a href='{!!url("/departmentpage")!!}'>Departments</a> 
                            @endif 
                        </li>
                        <li>
                            @if($machines !="0") 
                            <a href='{!!url("/machines")!!}'>Machines</a>
                            @endif 
                        </li>
                        <li>
                            @if($createPalletConfig !="0") 
                            <a href='{!!url("/createPalletConfig")!!}'>Pallet Configurations</a>
                            @endif 
                        </li>
                        <li>
                            @if($location !="0")
                            <a href='{!!url("/location")!!}'>Locations</a>
                            @endif
                        </li>
                        
                        <li>
                            @if($mapmachinestoarea !="0") 
                            <a href='{!!url("/mapmachinetoarea")!!}'>Map Machine To Area</a> 
                            @endif 
                        </li>
                        <li>
                            @if($mapmachinestodept !="0")
                            <a href='{!!url("/mapmachinestodept")!!}'>Map Machines To Department</a> 
                            @endif 
                        </li>
                        <li>
                            @if($mapitemsmachinesdept !="0") 
                            <a href='{!!url("/mapitemsmachinesdept")!!}'>Map Machines, Deptartment & Product</a>
                            @endif 
                        </li>
                        <li>
                            @if($mapitemstopallet !="0")
                            <a href='{!!url("/mapitemstopallet")!!}'>Map Pallet To Items</a> 
                            @endif
                        </li>
                    </ul>
                </li>
			</ul>
		</li>

        <!-- Sales -->
        <li>
			<!-- Fisrt Category -->
            <a href="#" id="6">Sales<span class="caret pull-down"></span>
			</a>
			<ul class="item-show-6">
				<li>
                    <!-- Second Category -->
                    <a href="#" id="f">Coming Soon <span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-f">
                        <!-- Item Links -->
                        <li>
                            1
                        </li>
                        <li>
                            2
                        </li>
                    </ul>
                </li>
			</ul>
		</li>

        <!-- Print Labels & Reverse Pallets -->
        <li>
            @if($palletreversal !="0")
            <a href='{!!url("/qrcodereversepallet")!!}'>Pallet Reversal Code</a>
            @endif
        </li>
        <li>
            @if($printpalletsselectdept !="0")
            <a href='{!!url("/printpalletsselectdept")!!}'>Print Pallet Labels</a>
            @endif
        </li>

        <!-- Logout -->
        <li>
            <a href= "{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <img  src="{{url('/images/logo-02.png')}}" style="height: 70px; width: 95%; padding:12px;">
        </li>
    
    </ul>
</nav>

<!--
		<li>
			<a href="#" id="2">Map Components <span class="caret pull-down"></span>
			</a>
			<ul class="item-show-2">

			</ul>
		</li>

        <li>
			<a href="#" id="3">Job Data <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-3">

			</ul>
		</li>

        <li>
			<a href="#" id="4">Stock <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-4">

				</li>
			</ul>
		</li>

        <li>
			<a href="#" id="5">Users <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-5">

			</ul>
		</li>

        <li>
			<a href="#" id="6">Miscellaneous <span class="fas fa-caret-down"></span>
			</a>
			<ul class="item-show-6">

				</li>
			</ul>
		</li>
-->