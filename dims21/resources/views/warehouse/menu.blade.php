<?php

use Illuminate\Support\Facades\Auth;
if ((Auth::guest()))
{
    
}else{
    $v  =  new \App\Http\Controllers\SalesForm();
    /*$areaspage = $v->getThings(Auth::user()->GroupId,'areaspage');
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
    $createuser = $v->getThings(Auth::user()->GroupId,'createuser');*/

    //--------------------------First Level Options---------------------------------
    $workorders = $v->getThingsUserPermissions(Auth::user()->UserID,'Work Orders');
    $dispatch = $v->getThingsUserPermissions(Auth::user()->UserID,'Dispatch');
    $stockcontrol = $v->getThingsUserPermissions(Auth::user()->UserID,'Stock Control');
    $inventory = $v->getThingsUserPermissions(Auth::user()->UserID,'Inventory');
    $setup = $v->getThingsUserPermissions(Auth::user()->UserID,'Setup');
    $sales = $v->getThingsUserPermissions(Auth::user()->UserID,'Sales');
    $ppl = $v->getThingsUserPermissions(Auth::user()->UserID,'Print Pallet Labels');
    $gpl = $v->getThingsUserPermissions(Auth::user()->UserID,'Generic Product Labels');
    $wgpl = $v->getThingsUserPermissions(Auth::user()->UserID,'Warehouse Generic Product Labels');

    
    //--------------------------Second Level Options--------------------------------
    //Work Order Options
    $barbed = $v->getThingsUserPermissions(Auth::user()->UserID,'Barbed Wire');
    $galv = $v->getThingsUserPermissions(Auth::user()->UserID,'Galv');
    $roof = $v->getThingsUserPermissions(Auth::user()->UserID,'Roof');
    $productioncapture = $v->getThingsUserPermissions(Auth::user()->UserID,'Production Capture');

    //Dispatch Options
    $loadplanning = $v->getThingsUserPermissions(Auth::user()->UserID,'Load Planning');
    $pickingslips = $v->getThingsUserPermissions(Auth::user()->UserID,'Picking Slips');
    $settlement = $v->getThingsUserPermissions(Auth::user()->UserID,'Settlement');
    $authorisation = $v->getThingsUserPermissions(Auth::user()->UserID,'Authorisation');

    //Stock Controll Options

    //Inventory Options
    $stockonhand = $v->getThingsUserPermissions(Auth::user()->UserID,'Stock On Hand');
    $stockcount = $v->getThingsUserPermissions(Auth::user()->UserID,'Stock Count');

    //Setup Options
    $usergroups = $v->getThingsUserPermissions(Auth::user()->UserID,'Users/Groups');
    $setupdispatch = $v->getThingsUserPermissions(Auth::user()->UserID,'Setup Dispatch');
    $setupworkorders = $v->getThingsUserPermissions(Auth::user()->UserID,'Setup Work Orders');

    //Sales Options

    //--------------------------Third Level Options--------------------------------
    //Work Order - Barbed Wire
    $barbedcreateworkorder = $v->getThingsUserPermissions(Auth::user()->UserID,'Barbed Create Work Order');
    $barbedWIP = $v->getThingsUserPermissions(Auth::user()->UserID,'Barbed WIP');
    $barbedWOD = $v->getThingsUserPermissions(Auth::user()->UserID,'Barbed WOD');

    //Work Order - Galv
    $galvcreateworkorder = $v->getThingsUserPermissions(Auth::user()->UserID,'Galv Create Work Order');
    $qc1 = $v->getThingsUserPermissions(Auth::user()->UserID,'QC Phase 1');
    $qc2 = $v->getThingsUserPermissions(Auth::user()->UserID,'QC Phase 2');
    $weight = $v->getThingsUserPermissions(Auth::user()->UserID,'Weight');
    $print = $v->getThingsUserPermissions(Auth::user()->UserID,'Print');
    $regrade = $v->getThingsUserPermissions(Auth::user()->UserID,'Regrade');
    $sc = $v->getThingsUserPermissions(Auth::user()->UserID,'Stock Change');
    $retest = $v->getThingsUserPermissions(Auth::user()->UserID,'Retest');
    $scrapWeigh = $v->getThingsUserPermissions(Auth::user()->UserID,'Scrap Weigh');

    //Work Orders Roofing
    $roofcreateworkorder = $v->getThingsUserPermissions(Auth::user()->UserID,'Roof Create Work Order');

    //Work Orders Roofing
    $diamondMeshCreateWorkOrder = $v->getThingsUserPermissions(Auth::user()->UserID,'Diamond Mesh Create Work Order');
    
    //Dispatch - Load Planning
    $customergridlookup=$v->getThingsUserPermissions(Auth::user()->UserID,'Customer Grid Lookup');
    $pickingplanner = $v->getThingsUserPermissions(Auth::user()->UserID,'Picking Planner');
    $routestoinvoice = $v->getThingsUserPermissions(Auth::user()->UserID,'Routes To Invoice');

    //Dispatch - Picking Slips
    $pickingstatus = $v->getThingsUserPermissions(Auth::user()->UserID,'Picking Status');
    $pickingtickets = $v->getThingsUserPermissions(Auth::user()->UserID,'Picking Tickets');
    $loadTracking = $v->getThingsUserPermissions(Auth::user()->UserID,'Load Tracking');
    $assignweighttickets = $v->getThingsUserPermissions(Auth::user()->UserID,'Assign Weight Tickets');
    $authorisepicking = $v->getThingsUserPermissions(Auth::user()->UserID,'Authorise Picking');

    //Inventory - Stock On Hand
    $stocklocation = $v->getThingsUserPermissions(Auth::user()->UserID,'Stock Location');

    //Inventory - Stock Count
    $exceptionreport = $v->getThingsUserPermissions(Auth::user()->UserID,'Exception Movement Report');

    //Reports

    $galvmodulelogs = $v->getThingsUserPermissions(Auth::user()->UserID,'Galv Module Logs');

    //Setup - Users/Groups
    $creategroups = $v->getThingsUserPermissions(Auth::user()->UserID,'Create Groups');
    $createusers = $v->getThingsUserPermissions(Auth::user()->UserID,'Create Users');
    $modifyuserleaders = $v->getThingsUserPermissions(Auth::user()->UserID,'Modify User Leaders');

    //Setup - Dispatch
    $drivers = $v->getThingsUserPermissions(Auth::user()->UserID,'Drivers');
    $trucks = $v->getThingsUserPermissions(Auth::user()->UserID,'Trucks');
    $routes = $v->getThingsUserPermissions(Auth::user()->UserID,'Routes');

    //Setup - Work Orders
    $areas = $v->getThingsUserPermissions(Auth::user()->UserID,'Areas');
    $departments = $v->getThingsUserPermissions(Auth::user()->UserID,'Departments');
    $machines = $v->getThingsUserPermissions(Auth::user()->UserID,'Machines');
    $palletconfig = $v->getThingsUserPermissions(Auth::user()->UserID,'Pallet Configurations');
    $locations = $v->getThingsUserPermissions(Auth::user()->UserID,'Locations');
    $mm2a = $v->getThingsUserPermissions(Auth::user()->UserID,'Map Machine To Area');
    $mm2d = $v->getThingsUserPermissions(Auth::user()->UserID,'Map Machine To Department');
    $mmdp = $v->getThingsUserPermissions(Auth::user()->UserID,'Map Machines Dept & Product');
    $mp2i = $v->getThingsUserPermissions(Auth::user()->UserID,'Map Pallet To Item');
    $galvcustomers = $v->getThingsUserPermissions(Auth::user()->UserID,'Galv Customers');
    $galvscales = $v->getThingsUserPermissions(Auth::user()->UserID,'Scales');
    $nailsInner = $v->getThingsUserPermissions(Auth::user()->UserID,'Nails Inner');
    // $bulkmapping = $v->getThingsUserPermissions(Auth::user()->UserID,'Bulk Mapping');
    
}   
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="{{ asset('/css/myicons.css') }}">

<nav class="sidebar">
    <!-- logo --> 
    <a href = "{{url('/dashboard')}}">
        <img src="{{url('/images/HendokLogoTransparent.png')}}" style="height: 70px; width: 100%; padding: 15px 35px 0px 20px;">
    </a>
    
	<ul class="main_side" style="padding-right: 10px;">
        <!-- Work Orders -->
        <li>
			<!-- Fisrt Category -->
            @if($workorders !="0")
            <a class="firstmenu" id="1"><i class="fa fa-add"></i>Work Orders<span class="caret pull-down"></span></a>
            @endif
			
			<ul class="item-show-1">
                <li>
                    <!-- Second Category -->
                    @if($barbed !="0")
                    <a class="secondmenu" id="1a"><i class="fa mi-barb"></i>Barbed Wire<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-1a">
                        <!-- Item Links -->
                        <li>
                            @if($barbedcreateworkorder !="0")
                            <a href='{!!url("/createjobs")!!}'>Create Work Orders</a>
                            @endif
                        </li>
                        <li>
                            @if($barbedWIP !="0")
                            <a href='{!!url("/getJobStarted")!!}'>Work In Progress</a>
                            @endif
                        </li>
                        <li>
                            @if($barbedWOD !="0")
                            <a href='{!!url("/getjobsdata")!!}'>Work Orders Data</a>
                            @endif
                        </li>
                    </ul>

                    @if($galv !="0")
                    <a class="secondmenu" id="1b"><i class="fa mi-galv"></i>Galv<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-1b">
                        <!-- Item Links -->
                        <li>
                            @if($galvcreateworkorder !="0")
                            <a href='{!!url("/wmaxlanding")!!}'>Create Work Orders</a>
                            @endif
                        </li>

                        <li>
                            @if($qc1 !="0")
                            <a href='{!!url("/qc1")!!}'>QC Phase 1</a>
                            @endif
                        </li>

                        <li>
                            @if($qc2 !="0")
                            <a href='{!!url("/qc2")!!}'>QC Phase 2</a>
                            @endif
                        </li>

                        <li>
                            @if($weight !="0")
                            <a href='{!!url("/wmaxweigh")!!}'>Weigh</a>
                            @endif
                        </li>

                        <li>
                            @if($print !="0")
                            <a href='{!!url("/wmaxreprint")!!}'>Re-Print</a>
                            @endif
                        </li>

                        <li>
                            @if($regrade !="0")
                            <a href='{!!url("/wmaxregrade")!!}'>Regrade</a>
                            @endif
                        </li>

                        <li>
                            @if($sc !="0")
                            <a href='{!!url("/wmaxstockchange")!!}'>Stock Change</a>
                            @endif
                        </li>

                        <li>
                            @if($retest !="0")
                            <a href='{!!url("/wmaxretest")!!}'>Retest</a>
                            @endif
                        </li>

                        <li>
                            @if($scrapWeigh !="0")
                            <a href='{!!url("/wmaxscrap")!!}'>Scrap Weigh</a>
                            @endif
                        </li>

                        <li>
                            {{-- @if($retest !="0") --}}
                            <a href='{!!url("/galvReport")!!}'>QC Report</a> <!-- TODO Add user Permission for report -->
                            {{-- @endif --}}
                        </li>

                    </ul>

                    @if($roof !="0")
                    <a class="secondmenu" id="1c"><i class="fa mi-roof"></i>Roofing<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-1c">
                        <!-- Item Links -->
                        <li>
                            @if($roofcreateworkorder !="0")
                            <a href='{!!url("/roofworkorders")!!}'>Create Work Orders</a>
                            @endif
                        </li>
                        <li>
                            @if($roofcreateworkorder !="0")
                            <a href='{!!url("/roofingReport")!!}'>Roofing Report</a> <!-- TODO add userpermission for bulk roofing report -->
                            @endif
                        </li>
                        <li>
                            @if($roofcreateworkorder !="0")
                            <a href='{!!url("/roofingReprint")!!}'>Reprint Label</a> <!-- TODO add userpermission for roofing reprint -->
                            @endif
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1d"><i class="fa mi-wire"></i>White Mesh<span class="caret pull-down"></span><!-- TODO add userpermission for white mesh -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1d">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/White Mesh")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1e"><i class="fa mi-wire"></i>Black Mesh<span class="caret pull-down"></span><!-- TODO add userpermission for black mesh -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1e">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/Black Mesh")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1f"><i class="fa mi-wireFence"></i>Field Fence<span class="caret pull-down"></span><!-- TODO add userpermission for field fence -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1f">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/Field Fence")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1g"><i class="fa mi-nails"></i>Nails<span class="caret pull-down"></span><!-- TODO add userpermission for nails -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1g">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/Nails")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1h"><i class="fa mi-clips"></i>C Clips<span class="caret pull-down"></span><!-- TODO add userpermission for c clips -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1h">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/C Clips")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1i"><i class="fa mi-wire"></i>Netting<span class="caret pull-down"></span><!-- TODO add userpermission for netting -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1i">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/Netting")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1j"><i class="fa mi-wire"></i>Diamond Mesh<span class="caret pull-down"></span><!-- TODO add userpermission for diamond mesh -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1j">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($diamondMeshCreateWorkOrder !="0") --}}
                            <a href='{!!url("/diamondMeshWorkOrders")!!}'>Create Work Orders</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/Diamond Mesh")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                        <li>
                            {{-- @if($diamondMeshCreateWorkOrder !="0") --}}
                            <a href='{!!url("/diamondMeshReprint")!!}'>Reprint Label</a> <!-- TODO add userpermission for roofing reprint -->
                            {{-- @endif --}}
                        </li>
                        <li>
                            {{-- @if($diamondMeshCreateWorkOrder !="0") --}}
                            <a href='{!!url("/diamondMeshReport")!!}'>Diamond Mesh Report</a> <!-- TODO add userpermission for roofing reprint -->
                            {{-- @endif --}}
                        </li>
                        
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1k"><i class="fa mi-barb"></i>Galv Wire<span class="caret pull-down"></span><!-- TODO add userpermission for razor wire -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1k">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/Galv Wire")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    {{-- @if($roof !="0") --}}
                    <a class="secondmenu" id="1l"><i class="fa mi-barb"></i>Razor Wire<span class="caret pull-down"></span><!-- TODO add userpermission for razor wire -->
                    </a>
                    {{-- @endif --}}
                    <ul class="item-show-1l">
                        <!-- Item Links -->
                        <li>
                            {{-- @if($roofcreateworkorder !="0") --}}
                            <a href='{!!url("/printLabelPage/Razor")!!}'>Print Label</a> <!-- TODO add userpermission for printing label -->
                            {{-- @endif --}}
                        </li>
                    </ul>

                    @if($productioncapture !="0")
                    <a class="secondmenu" id="4c" href='{!!url("/productionCapture")!!}'>Production Capture</a>
                    @endif
                </li>
			</ul>
		</li>

        <!-- Dispatch -->
        <li>
			<!-- Fisrt Category -->
            @if($dispatch !="0")
            <a class="firstmenu" id="2"><i class="fa fa-truck"></i>Dispatch<span class="caret pull-down"></span>
			</a>
            @endif
			<ul class="item-show-2">
				<li>
                    <!-- Second Category -->
                    <li>
                        @if($customergridlookup !="0")
                        <a class="secondmenu" href='{!!url("/customergridlookup")!!}'>Customer Grid Lookup</a>
                        @endif
                    </li>
                    @if($loadplanning !="0")
                    <a class="secondmenu" id="2a">Load Planning<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-2a">
                        <!-- Item Links -->
                       
                        <li>
                            @if($pickingplanner !="0")
                            <a href='{!!url("/routeplanner")!!}'>Picking Planner</a>
                            @endif
                        </li>
                        <li>
                            @if($routestoinvoice !="0")
                            <a href='{!!url("/viewAwaitingtoinvoice")!!}'>Routes To Invoice</a>
                            @endif
                        </li>

                    </ul>

                    @if($pickingslips !="0")
                    <a class="secondmenu" id="2b">Loading<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-2b">
                        <!-- Item Links -->
                        <li>
                            @if($pickingstatus !="0")
                            <a href='{!!url("/liveBulkPicking")!!}'>Picking Status</a>
                            @endif
                        </li>
                        <li>
                            @if($pickingtickets !="0")
                            <a href='{!!url("/viewpickingtickets")!!}'>Truck Loading</a>
                            @endif
                        </li>
                        <li>
                            @if($loadTracking !="0")
                            <a href='{!!url("/loadTracking")!!}'>Truck Load Tracker</a>
                            @endif
                        </li>
                        {{-- <li>
                            @if($assignweighttickets !="0")
                            <a href='{!!url("/assignweighbridgeticket")!!}'>Assign Weight Tickets</a>
                            @endif
                        </li> --}}
                        {{-- <li>
                            @if($authorisepicking !="0")
                            <a href='{!!url("/getPickingAuth")!!}'>Authorise Picking</a>
                            @endif
                        </li> --}}
                    </ul>

                    @if($settlement !="0")
                    <a class="secondmenu" id="2c">Settlement<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-2c">
                        <!-- Item Links -->
                        <li>
                            Comming Soon
                        </li>
                    </ul>

                    @if($authorisation !="0")
                    <a class="secondmenu" id="2d">Authorisation<span class="caret pull-down"></span>
                    </a>
                    @endif
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
            @if($stockcontrol !="0")
            <a class="firstmenu" id="3"><i class="fa fa-line-chart"></i>Stock Control<span class="caret pull-down"></span>
			</a>
            @endif
			<ul class="item-show-3">
				<li>
                    <!-- Second Category -->
                    <a class="secondmenu" id="3a">Returns<span class="caret pull-down"></span>
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

                    <a class="secondmenu" id="3b">Upliftment Vouchers<span class="caret pull-down"></span>
                    </a>
                    <ul class="item-show-3b">
                        <!-- Item Links -->
                        <li>
                            <a href='{!!url("/getUpliftmentPage")!!}'>Upliftments</a>
                        </li>
                    </ul>

                    <li>
                        {{-- @if($ppl !="0") --}}
                        <a class="secondmenu" href='{!!url("/issuestock")!!}'><i class="fa fa-line-chart"></i>Stock Issue</a>
                        {{-- @endif --}}
                    </li>
                </li>
			</ul>
		</li>

        <!-- Inventory -->
        <li>
			<!-- Fisrt Category -->
            @if($inventory !="0")
            <a class="firstmenu" id="4"><i class="fa fa-archive"></i>Inventory<span class="caret pull-down"></span>
			</a>
            @endif
			<ul class="item-show-4">
				<li>
                    <!-- Second Category -->
                    @if($stockonhand !="0")
                    <a class="secondmenu" id="4a">Stock on Hand<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-4a">
                        <!-- Item Links -->
                        <li>
                            @if($stocklocation !="0")
                            <a href='{!!url("/stockLocation")!!}'>Stock Location</a>
                            @endif
                        </li>
                    </ul>

                    @if($stockcount !="0")
                    <a class="secondmenu" id="4b">Stock Count<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-4b">
                        <!-- Item Links -->
                        <li>
                            @if($exceptionreport !="0")
                            <a href='{!!url("/exceptionmovementreport")!!}'>Exception Movement Report</a>
                            @endif
                        <li>
                    </ul>

                    {{-- @if($exceptionreport !="0") --}}
                    <a class="secondmenu" id="4c" href='{!!url("/recievingwarehousereport")!!}'>Recieving Movement</a>
                    
                    @if($galvmodulelogs !="0")
                    <a class="secondmenu" id="4d" href='{!!url("/galvmodulecomms")!!}'>Galv Module Logs</a>
                    @endif
                    {{-- @endif --}}
                </li>
			</ul>
		</li>

        <!-- Setup -->
        <li>
			<!-- Fisrt Category -->
            @if($setup !="0")
            <a class="firstmenu" id="5"><i class="fa fa-cog"></i>Setup<span class="caret pull-down"></span>
			</a>
            @endif
			<ul class="item-show-5">
				<li>
                    <!-- Second Category -->
                    @if($usergroups !="0")
                    <a class="secondmenu" id="5a">Users/Groups<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-5a">
                        <!-- Item Links -->
                        <li>
                            @if($creategroups !="0")
                            <a href='{!!url("/creategrouppage")!!}'>Groups</a>
                            @endif
                        </li>
                        <li>
                            @if($createusers !="0")
                            <a href='{!!url("/createuserpage")!!}'>Users</a>
                            @endif
                        </li>
                        <li>
                            @if($modifyuserleaders !="0")
                            <a href='{!!url("/modifyuserleaderpage")!!}'>Leaders</a>
                            @endif
                        </li>
                    </ul>

                    @if($setupdispatch !="0")
                    <a class="secondmenu" id="5b">Dispatch<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-5b">
                        <!-- Item Links -->
                        <li>
                            @if($drivers !="0")
                            <a href='{!!url("/drivers")!!}'>Drivers</a>
                            @endif
                        </li>
                        <li>
                            @if($trucks !="0")
                            <a href='{!!url("/trucks")!!}'>Trucks</a>
                            @endif
                        </li>
                        <li>
                            @if($routes !="0")
                            <a href='{!!url("/routes1")!!}'>Routes</a>
                            @endif
                        </li>
                    </ul>

                    @if($setupworkorders !="0")
                    <a class="secondmenu" id="5c">Work Orders<span class="caret pull-down"></span>
                    </a>
                    @endif
                    <ul class="item-show-5c">
                        <!-- Item Links -->
                        <li>
                            @if($areas !="0") 
                            <a href='{!!url("/areapage")!!}'>Areas</a> 
                            @endif 
                        </li>
                        <li>
                            @if($departments !="0") 
                            <a href='{!!url("/departmentpage")!!}'>Departments</a> 
                            @endif 
                        </li>
                        <li>
                            @if($departments !="0") 
                            <a href='{!!url("/subDepartments")!!}'>Sub-Departments</a> 
                            @endif 
                        </li>
                        <li>
                            @if($machines !="0") 
                            <a href='{!!url("/machines")!!}'>Machines</a>
                            @endif 
                        </li>
                        <li>
                            {{-- @if($bulkMapping !="0") --}}
                            <a href='{!!url("/bulkMapping")!!}'>Bulk Mapping</a> <!-- TODO add userpermission for bulk mapping -->
                            {{-- @endif --}}
                        </li>
                        <li>
                            {{-- @if($nailsinner !="0") --}}
                            <a href='{!!url("/nailsInner")!!}'>Nails Inner</a> <!-- TODO add userpermission for nails Inner -->
                            {{-- @endif --}}
                        </li>
                        <li>
                            @if($palletconfig !="0") 
                            <a href='{!!url("/createPalletConfig")!!}'>Pallet Configurations</a>
                            @endif 
                        </li>
                        <li>
                            @if($locations !="0")
                            <a href='{!!url("/LocationsAndBins")!!}'>Locations & Bins</a>
                            @endif
                        </li>
                        <li>
                            {{-- @if($locations !="0") --}}
                            <a href='{!!url("/labelspage")!!}'>Labels</a> <!-- TODO add userpermission for labels -->
                            {{-- @endif --}}
                        </li>
                        {{-- <li>
                            @if($mm2a !="0") 
                            <a href='{!!url("/mapmachinetoarea")!!}'>Map Machine To Area</a> 
                            @endif 
                        </li> --}}
                        {{-- <li>
                            @if($mm2d !="0")
                            <a href='{!!url("/mapmachinestodept")!!}'>Map Machines To Department</a> 
                            @endif 
                        </li> --}}
                        <li>
                            @if($mmdp !="0") 
                            <a href='{!!url("/mapitemsmachinesdept")!!}'>Map Product To Machine</a>
                            @endif 
                        </li>
                        {{-- <li>
                            @if($mp2i !="0")
                            <a href='{!!url("/mapitemstopallet")!!}'>Map Pallet To Items</a> 
                            @endif
                        </li> --}}
                        <li>
                            {{-- @if($mp2i !="0") --}}
                            <a href='{!!url("/labelmapping")!!}'>Map Label to Product Category</a> <!-- TODO add userpermission for labelmapping -->
                            {{-- @endif --}}
                        </li>
                        <li>
                            @if($galvcustomers !="0")
                            <a href='{!!url("/galvcustomer")!!}'>Galv Customers</a> 
                            @endif
                        </li>

                        <li>
                            {{-- @if($galvcustomers !="0") --}}
                            <a href='{!!url("/galvProducts")!!}'>Galv Products</a> <!-- TODO add userpermission for products -->
                            {{-- @endif --}}
                        </li>

                        <li>
                            @if($galvscales !="0")
                            <a href='{!!url("/galvscale")!!}'>Scales</a> 
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/galvcreateprodspec")!!}'>Create Galv Product Spec</a> 
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/galveditprodspec")!!}'>Edit Galv Product Spec</a> 
                            @endif
                        </li>
                        <li>
                            @if("1" !="0")
                            <a href='{!!url("/stockIssueTypes")!!}'>Stock Issue Types</a> 
                            @endif
                        </li>

                        
                    </ul>

                    @if($setup !="0")
                    <a class="secondmenu" href='{!!url("/syncing")!!}'>Data Syncing</a>
                    @endif
                </li>
			</ul>
		</li>

        <!-- Sales -->
        <li class="disabled">
			<!-- Fisrt Category -->
            @if($sales !="0")
            <a class="firstmenu" id="6"><i class="fa fa-shopping-cart "></i>Sales<span class="caret"></span>
			</a>
            @endif
			<ul class="item-show-6">
				<li>
                    <!-- Second Category -->
                    <a class="secondmenu" id="f">Coming Soon <span class="caret pull-down"></span>
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
            @if($ppl !="0")
            <a class="firstmenu" href='{!!url("/printpalletsselectdept")!!}'><i class="fa mi-pallet"></i>Print Pallet Labels</a>
            @endif
        </li>

        <!-- Print Generic Product Labels -->
        
        <li>
            @if($gpl !="0")
            <a class="firstmenu" href='{!!url("/genericproductlabels")!!}'><i class="fa mi-coil"></i>Product Label Printing</a>
            @endif
        </li>
        <li>
            @if($gpl !="0")
            <a class="firstmenu" href='{!!url("/warehousepalletlabels")!!}'><i class="fa mi-warehouse"></i>Warehouse Printing</a>
            @endif
        </li>
    </ul>
</nav>
<!-- Logout -->
<nav class="sidebar" style="height: 20vh !important">
    <div style="position: absolute; bottom: 0;">
        <ul>
            <li>
                <a href= "{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i>Logout
                </a>
                <a class="text-light"> <i class="fa fa-user"></i>
                    @if(Auth::check())
                        Welcome {{ Auth::user()->UserName }}
                    @endif
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <img  src="{{url('/images/logo-02.png')}}" style="height: 70px; width: 95%; padding:12px;">
            </li>
        </ul>
    </div>
</nav>