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

<style>
	.vertical-menu {
		padding: 0px;
	}

	.vertical-menu a {
		background-color: #eee;
		color: black;
		display: block;
		padding: 12px;
		text-decoration: none;
		font-size: 13px;
	}

	.vertical-menu a:hover {
		background-color: #ccc;
	}

	.vertical-menu a.active {
		background-color: #04AA6D;
		color: white;
	}

	.card-body {
		padding: 0px;
	}

    .btn{
        text-decoration: none;
    }

    .mb-0{
        margin: 0px;
    }
    
    .card{
        
        margin-bottom: 1px;
    }
</style>

<div>
    <a href= "{{ route('logout') }}"
    onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="background: #007bff;color: white; border-color:rgb(190, 190, 190)"> Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- Add Components -->
	<div class="card">
		
        <h5 class="mb-0">
            <a data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="background-color:rgb(190, 190, 190)"> Add Components </a>
        </h5>
		
		<div id="collapseOne" class="collapse" aria-labelledby="headingOne">
			<div class="card-body"> 
                @if($areaspage !="0") 
                <a href='{!!url("/areapage")!!}' class="areas">Areas</a> 
                @endif 
                
                @if($departmentpage !="0") 
                <a href='{!!url("/departmentpage")!!}' class="departments">Departments</a> 
                @endif 
                
                @if($machines !="0") 
                <a href='{!!url("/machines")!!}' class="machines">Machines</a>
                @endif 
                
                @if($createPalletConfig !="0") 
                <a href='{!!url("/createPalletConfig")!!}' class="palletConfig">Pallets Configurations</a>
                @endif 

                @if($location !="0")
                <a href='{!!url("/location")!!}' class="locations">Locations</a>
                @endif
            </div>
		</div>
	</div>

    <!-- Map Components -->
	<div class="card">

			<h5 class="mb-0">
				<a data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  style="background-color:rgb(190, 190, 190)"> Map Components </a>
			</h5>
		
		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo">
			<div class="card-body"> 
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
            </div>
		</div>
	</div>

    <!-- Job Data -->
	<div class="card">
		
			<h5 class="mb-0">
				<a data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"  style="background-color:rgb(190, 190, 190)"> Job Data </a>
			</h5>
		
		<div id="collapseThree" class="collapse" aria-labelledby="headingThree">
			<div class="card-body">
                @if($createjobs !="0")
                <a href='{!!url("/createjobs")!!}' class="workOrders">Work Orders</a>
                @endif

                @if($getJobStarted !="0")
                <a href='{!!url("/getJobStarted")!!}' class="WIP">WIP</a>
                @endif

                @if($getjobsdata !="0")
                <a href='{!!url("/getjobsdata")!!}' class="WOD">Work Orders Data</a>
                @endif
            </div>
		</div>
	</div>

    <!-- Stock -->
    <div class="card">
		
			<h5 class="mb-0">
				<a data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"  style="background-color:rgb(190, 190, 190)"> Stock </a>
			</h5>
		
		<div id="collapseFour" class="collapse" aria-labelledby="headingFour">
			<div class="card-body">
                @if($stocklocation !="0")
                <a href='{!!url("/stocklocation")!!}' class="stock">Stock Location</a>
                @endif
                
                @if($exceptionmvmntrpt !="0")
                <a href='{!!url("/exceptionmovementreport")!!}' class="report">Exception Mvmnt Rpt</a>
                @endif

            </div>
		</div>
	</div>

    <!-- Users -->
    <div class="card">
		
			<h5 class="mb-0">
				<a data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"  style="background-color:rgb(190, 190, 190)"> Users </a>
			</h5>
		
		<div id="collapseFive" class="collapse" aria-labelledby="headingFive">
			<div class="card-body">
                @if($creategroup !="0")
                <a href='{!!url("/creategrouppage")!!}' class="creategroup">Create Groups</a>
                @endif

                @if($createuser !="0")
                <a href='{!!url("/createuserpage")!!}' class="createuser">Create Users</a>
                @endif
            </div>
		</div>
	</div>

    <!-- Miscellaneous -->
    <div class="card">
		
			<h5 class="mb-0">
				<a data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"  style="background-color:rgb(190, 190, 190)"> Miscellaneous </a>
			</h5>
		
		<div id="collapseSix" class="collapse" aria-labelledby="headingSix">
			<div class="card-body">
                @if($palletreversal !="0")
                <a href='{!!url("/qrcodereversepallet")!!}' class="palletReversal">Pallet Reversal Code</a>
                @endif

                @if($printpalletsselectdept !="0")
                <a href='{!!url("/printpalletsselectdept")!!}' class="paletLabel">Print Pallet Labels</a>
                @endif
            </div>
		</div>
	</div>
</div>
