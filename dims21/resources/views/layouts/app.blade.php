<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{url('images/linx.jpg')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyShop') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/grid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/smoothcss.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scroller.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/tippop.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/jquery.inputpicker.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/datatablesblocked.css') }}" rel="stylesheet"  type='text/css'>

    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/excel-bootstrap-table-filter-style.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/contextMenu.css') }}" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('public/js/colResizable-1.6.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>


    <script src="{{ asset('js/jquery.mcautocomplete.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/commonScript.js') }}"></script>
    <script src="{{ asset('js/jquery.pleaseWait.js') }}"></script>
    <script src="{{ asset('js/jspdf.debug.js') }}"></script>
    <script src="{{ asset('js/jquery.tippop.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputpicker.js') }}"></script>
    <script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>
    <script src="{{ asset('js/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>

    <script src="{{ asset('js/sum().js') }}"></script>
    <script src="{{ asset('js/contextMenu.js') }}"></script>
    <!--<script src="https://use.fontawesome.com/0f659c6d48.js"></script>-->
    <script src="{{ asset('public/js/jqueryprint.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js//vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/tableSorter.js') }}"></script>



    <style>
        .hide-close-btn .ui-dialog-titlebar-close{
            display: none;
        }
        .ui-dialog-titlebar-close{
            display: none;
        }
        /*TAB*/
        .anonymouscols{

            height: 14px !important;
        }
        .anonymouscolsOff{

           display: none;
        }
        li div.tab-frame input{ display:none;}
        li div.tab-frame label{ display:block; float:left;padding:5px 10px; cursor:pointer}
        li div.tab-frame input:checked + label{ background:black; color:white; cursor:default}
        li div.tab-frame div.tab{ display:none; padding:5px 10px;clear:left}

        li div.tab-frame input:nth-of-type(1):checked ~ .tab:nth-of-type(1),
        li div.tab-frame input:nth-of-type(2):checked ~ .tab:nth-of-type(2),
        li div.tab-frame input:nth-of-type(3):checked ~ .tab:nth-of-type(3),
        li div.tab-frame input:nth-of-type(4):checked ~ .tab:nth-of-type(4){ display:block;}
        /*END OF TABS*/
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance:textfield;
        }
        .push_product{
            background: #c0dcd0;
        }
        .ngx-contextmenu > .dropdown-menu {
            z-index: 9899999999999999;
        }
        .hidden_row {
            display: none;
        }
        .table-condensed{
            font-size: 10px;
        }
        .table-condensed-footer{
            font-size: 11px;
            font-weight: 900;
            font-family: sans-serif;
            color: black;
            margin-bottom: 3px;
        }
        .green {
            background-color: green !important;
            color: wheat;
            font-weight: 600;
        }
        .up {
            background-color: #e0fa90 !important;
            color: black;
            font-weight: 600;
        }
        .down {
            background-color: #d5d5e5 !important;
            color: black;
            font-weight: 600;
        }
        .stopped {
            background-color: #f79b9b !important;
            color: black;
            font-weight: 600;
        }
        .circle {
            background-color: white !important;
            color: black;
            font-weight: 600;
        }
        .hiddenRule{
            display: none;
        }
        .unhiddenRule{
            display: block;
        }
        .dtablehide{
            display: none;
        }
        .flexdatalist-results li{
            padding: 0;
            font-size: 12px;
            font-weight: 900;
        }
        .flexdatalist-results{
            width: 24% !important;
        }
        #orderPatternIdTable_filter input{
            display: block !important;
        }
        thead th {
            font-size: 10px;
            padding: 1px !important;
            height: 15px;
        }
        .ui-helper-hidden-accessible{
            display: none;
        }
        .table-condensed>tbody>tr>td
        {
            padding: 1px;
            line-height: 1.1;
        }
        .dataTables_scrollBody{
            min-height: 300px;
        }


        .inputs{

        }
        .lst{

        }
        .addgreen{
            background: #84ff5b;
        }
        .resize-input-inside{
            width: 100%;
            height: 100%;
            font-family: sans-serif;

            border-right: 0;
            border-left: 0;
            /*border-top: 0;
            border-bottom: 0;*/

            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .set_autocomplete,#prodCode,#prodDesciption{
            font-family: sans-serif;
            width: 100%;
            height: 100%;
        }

        fieldset {
            min-width: 0;
            padding: 0;
            margin: 0;
            border: 0;
        }
        .well {
            min-height: 20px;
            padding: 5px;
            margin-bottom: 0px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        }
        .well-legend {
            display: block;
            font-size: 14px;
            width: auto;
            padding: 2px 7px 2px 5px;
            margin-bottom: 0px;
            line-height: inherit;
            color: #333;
            background: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        }
        .ui-dialog { z-index: 50000 !important ;}
        .rebuild_price_check>tbody>tr>td{
            padding:1px !important;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 1px;font-size: 9px;
        }
        .small {
            font-size: 55%;
        }
        .table>tbody>tr>td{
            padding: 0px;
        }
        .mask{
            display:none;
        }
        .mask .ajax {
            display: block;
            width: 100%;
            height: 100%;
            position: relative; /*required for z-index*/
            z-index: 100000;
        }
        .datatablerowhighlight {
            background-color: #ECFFB3 !important;
        }
        table td {
            position: relative;
        }
        table.dataTable tfoot th, table.dataTable tfoot td{
            padding: 0px 0px 0px 0px !important;
        }

        table td input {
            top:0;
            left:0;
            margin: 0;
            height: 100% !important;
            width: 100%;
            border-radius: 0 !important;
            border: none;
            padding: 2px;
            box-sizing: border-box;
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
            z-index: 999999999;
        }
        body.dragging, body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.5;
            z-index: 2000;
        }
        .dragging li.ui-state-hover {
            min-width: 240px;
        }
        .dragging .ui-state-hover a {
            color:green !important;
            font-weight: bold;
        }
        .connectedSortable tr, .ui-sortable-helper {
            cursor: move;
        }
        .connectedSortable tr:first-child {
            cursor: default;
        }
        #news2, #news2 option {
            font-family: Consolas, monospace;
        }
        tr.row_selected td{background-color:red !important;}
        tr.row_selectedYellowish td{background-color:#91ff00 !important;}
        inputrow_selectedYellowish {background-color:#91ff00 !important;}

        .calculator {
            /* width: 350px;
             height: 320px;*/
            background-color: #c0c0c0;
            box-shadow: 0px 0px 0px 10px #666;
            border: 5px solid black;
            border-radius: 10px;
        }
        #display {
            width: 270px;
            height: 40px;
            text-align: right;
            background-color: black;
            border: 3px solid white;
            font-size: 18px;
            left: 2px;
            top: 2px;
            color: #7fff00;
        }
        .btnTop{
            color: white;
            background-color: #6f6f6f;
            font-size: 14px;
            /*margin: auto;*/
            width: 50px;
            height: 25px;
        }
        .btnNum {
            color: white;
            background-color: black;
            font-size: 14px;
            /* margin: auto;*/
            width: 50px;
            height: 25px;
        }
        .btnMath {
            color: white;
            background-color: #ff4561;
            font-size: 14px;
            /*margin: auto;*/
            width: 50px;
            height: 25px;
        }
        .btnOpps {
            color: white;
            background-color: #ff9933;
            font-size: 14px;
            /*margin: auto;*/
            width: 50px;
            height: 25px;
        }
        .leftButton
        {
            margin-right: 370px !important;
            font-size:10px !important;
            /*display: none;*/

        }
        /**
        picking slip checkbox
         */
        .containercheckbox {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;

            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .containercheckbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .containercheckbox:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .containercheckbox input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .containercheckbox input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .containercheckbox .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        /**
        end of picking slips check
         */

        @media print {

            .navbar { display: none; }

        }
        .row{
            margin-right: 0;
            margin-left: 0;
        }


    </style>
    <script>


        function addChar(input, character) {
            if(input.value == null || input.value == "0")
                input.value = character
            else
                input.value += character
        }

        function cos(form) {
            form.display.value = Math.cos(form.display.value);
        }

        function sin(form) {
            form.display.value = Math.sin(form.display.value);
        }

        function tan(form) {
            form.display.value = Math.tan(form.display.value);
        }

        function sqrt(form) {
            form.display.value = Math.sqrt(form.display.value);
        }

        function ln(form) {
            form.display.value = Math.log(form.display.value);
        }

        function exp(form) {
            form.display.value = Math.exp(form.display.value);
        }

        function deleteChar(input) {
            input.value = input.value.substring(0, input.value.length - 1)
        }
        var val = 0.0;
        function percent(input) {
            val = input.value;
            input.value = input.value + "%";
        }

        function changeSign(input) {
            if(input.value.substring(0, 1) == "-")
                input.value = input.value.substring(1, input.value.length)
            else
                input.value = "-" + input.value
        }

        function compute(form) {
            //if (val !== 0.0) {
            // var percent = form.display.value;
            // percent = pcent.substring(percent.indexOf("%")+1);
            // form.display.value = parseFloat(percent)/100 * val;
            //val = 0.0;
            // } else
            form.display.value = eval(form.display.value);
        }


        function square(form) {
            form.display.value = eval(form.display.value) * eval(form.display.value)
        }

        function checkNum(str) {
            for (var i = 0; i < str.length; i++) {
                var ch = str.charAt(i);
                if (ch < "0" || ch > "9") {
                    if (ch != "/" && ch != "*" && ch != "+" && ch != "-" && ch != "."
                        && ch != "(" && ch!= ")" && ch != "%") {
                        alert("invalid entry!")
                        return false
                    }
                }
            }
            return true
        }
    </script>
</head>
<body style="color:black">

<div id="app">
    <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 1px">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>

                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse" style="line-height: 0;">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <?php
                        if ((Auth::guest()))
                            {

                            }else{
                    $v  =  new \App\Http\Controllers\SalesForm();
                    $things = $v->getThings(Auth::user()->GroupId,'Allow Call Logger');
                    $grid = $v->getThings(Auth::user()->GroupId,'User Grid');
                    $extras = $v->getThings(Auth::user()->GroupId,'AccesToMainExtras');
                    $groupspecialAccess = $v->getThings(Auth::user()->GroupId,'Extras Group Specials');
                    $overallspecial = $v->getThings(Auth::user()->GroupId,'Extras Overall Specials');
                    $backorders = $v->getThings(Auth::user()->GroupId,'Extras Back Orders');
                    $customerspecials = $v->getThings(Auth::user()->GroupId,'Extras Customer Specials');
                    $creditreport = $v->getThings(Auth::user()->GroupId,'Extra DIMS Credit Reports');
                    $console = $v->getThings(Auth::user()->GroupId,'Extras DIMS Management Console');

                    $messaging = $v->getThings(Auth::user()->GroupId,'Cpanel Messaging App');
                    $creditnotes = $v->getThings(Auth::user()->GroupId,'Cpanel Credit Notes');
                    $salesperformance = $v->getThings(Auth::user()->GroupId,'Cpanel Sales Performance');
                    $loyalty = $v->getThings(Auth::user()->GroupId,'Cpanel Layalty');
                    $routes = $v->getThings(Auth::user()->GroupId,'Cpanel Routes');
                    $transfers = $v->getThings(Auth::user()->GroupId,'Cpanel Transfers');
                    $drivers = $v->getThings(Auth::user()->GroupId,'Cpanel Drivers');
                    $trucks = $v->getThings(Auth::user()->GroupId,'Cpanel Trucks');
                    $ordertypes = $v->getThings(Auth::user()->GroupId,'Cpanel OrderTypes');
                    $loyalty = $v->getThings(Auth::user()->GroupId,'Loyalty Cards');
                    $pospanel = $v->getThings(Auth::user()->GroupId,'POS Panel');
                    $remoteorders = $v->getThings(Auth::user()->GroupId,'Remote Orders');
                     $briefcase = $v->getThings(Auth::user()->GroupId,'Briefcase');
                     $webstoremassage= $v->getThings(Auth::user()->GroupId,'Webstore Messages');
                     $released= $v->getThings(Auth::user()->GroupId,'released');
                     $printeredit= $v->getThings(Auth::user()->GroupId,'Edit Printer');
                   // $console = $v->getThings(Auth::user()->GroupId,'Extras DIMS Management Console');

                    }
                    ?>


                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><button type="button" id="orderListing" class="btn-warning btn-xs" style="width: 90px;">Order Listing</button></li>
                        <li><button type="button" id="reports" class="btn-primary btn-xs" style="width: 90px;display: none">Reports</button></li>
                        <li><button type="button" id="pricing" class="btn-success btn-xs" style="width: 90px;">Price Check</button></li>
                        <li><button type="button" id="pricingOnCustomer" class="btn-success btn-xs" style="width: 90px;">PL</button></li>
                        <li><button type="button" id="callList" class="btn-primary btn-xs" style="width: 90px;">Call List</button></li>
                        <li><button type="button" id="tabletLoadingApp" class="btn-primary btn-xs" style="display:none;">Reprint</button></li>
                        <li><button type="button" id="salesQuotebtn" class="btn-info btn-xs" style="width: 90px;display: none">Sales Quotes</button></li>
                        <li><button type="button" id="copyOrdersBtn" class="btn-info btn-xs" style="width: 90px;">Copy Orders</button></li>
                        <li><button type="button" id="routePlanning" class="btn-primary btn-xs" style="width: 90px;display: none">Route Plan</button></li>
                        <li><button type="button" id="salesOnOrder" class="btn-primary btn-xs" style="width: 90px;">On Order</button></li>
                        <li><button type="button" id="salesInvoiced" class="btn-warning btn-xs" style="width: 90px;">On Invoice</button></li>
                        <li><button type="button" id="posCashUp" class="btn-primary btn-xs" style="width: 90px;">Cash Up</button></li>
                        <li><button type="button" id="pricelist" class="btn-success btn-xs" style="width: 90px;display:none;">Price List</button></li>
                        <li><button type="button" id="returns" class="btn-success btn-xs" style="width: 90px;display: none;">Returns</button></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Extras <span class="caret"></span></a>
                            <ul class="dropdown-menu" >
                                <li>
                                    <a href='{!!url("/getAwaitingStockbycustomer")!!}' onclick="window.open(this.href, 'getAwaitingStock',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Awaiting Stock Orders</a>
                                </li>
                                <li>
                                    <a href='{!!url("/getAwaitingStock")!!}' onclick="window.open(this.href, 'getAwaitingStock',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Awaiting Stock Products</a>
                                </li>
                                <li>
                                    <a href='{!!url("/pickingmain")!!}' onclick="window.open(this.href, 'bulkpicking',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Bulk Picking</a>
                                </li>

                                @if($released !="0")
                                <li>
                                    <a href='{!!url("/getordertorelease")!!}' onclick="window.open(this.href, 'getordertorelease',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Order Release Screen</a>
                                </li>
                                @endif

                                <li>
                                    <a href='{!!url("/customerflexgrid")!!}' onclick="window.open(this.href, 'customerflexgrid',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Customers</a>
                                </li>
                                <li>
                                    <a href='{!!url("/massProducts")!!}' onclick="window.open(this.href, 'massp',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Products</a>
                                </li>
                                <li>
                                    <a href='{!!url("/stocksheetforstocktake")!!}' onclick="window.open(this.href, 'stocksheetforstocktake',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Stock Take Sheet</a>
                                </li>
                                <li>
                                    <a href='{!!url("/viewproductbydate")!!}' onclick="window.open(this.href, 'viewproductbydate',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Products By Date</a>
                                </li>
                                @if($customerspecials !="0")
                                <li>
                                    <a href='{!!url("/specials")!!}' onclick="window.open(this.href, 'specials',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Customer Special</a>
                                </li>
                                @endif
                                <li>
                                    <a href='{!!url("/import_excel")!!}' onclick="window.open(this.href, 'pricelistimport',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >DIMS Price List Import</a>
                                </li>
                                <!--Probably add some or other check from ENV file to make sure only KF sees this-->

                                <li>
                                    <a href='{!!url("/andNewSpecialKF")!!}' onclick="window.open(this.href, 'massGrid',
'left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" > Customer Specials</a>
                                </li>
                                <li>
                                    <a href='{!!url("/searchSpecialKF")!!}' onclick="window.open(this.href, 'searchSpecialKF',
'left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" > Search Customer Specials</a>
                                </li>
<!--
                                <li>
                                    <a href='{!!url("/massgridspecialscustomer")!!}' onclick="window.open(this.href, 'massGrid',
'left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" >Mass Customer Specials</a>
                                </li>
                -->
                                <li>
                                    <a href='{!!url("/pricelistview")!!}' onclick="window.open(this.href, 'pricelistview',
'left=20,top=20,width=1600,height=800,toolbar=1,resizable=0'); return false;" >Price List Information</a>
                                </li>

                                @if ($groupspecialAccess != "0")
                                <li>
                                    <a href='{!!url("/groupspecials")!!}' onclick="window.open(this.href, 'roupspecials',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Group Specials</a>
                                </li>
                                @endif

                                <li>
                                    <a href='{!!url("/overallspecials")!!}' onclick="window.open(this.href, 'overallspecials',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >Overall Specials</a>
                                </li>
                                <li>
                                    <a href='{!!url("/combospecials")!!}' onclick="window.open(this.href, 'combospecials',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;" >POS Combo Specials</a>
                                </li>

                                @if($console !="0")
                                <li>
                                    <a href='{!!url("/managementSearch")!!}' onclick="window.open(this.href, 'managementSearch',
'left=20,top=20,width=1500,height=1250,toolbar=1,resizable=0'); return false;" >Management Console</a>
                                </li>
                                @endif

                                <li>

                                    <a href='{!!url("/getreportLayout")!!}' onclick="window.open(this.href, 'reports',
'left=20,top=20,width=1500,height=1000,toolbar=1,resizable=0'); return false;" >Reports</a>
                                </li>

                                @if($backorders !="0")
                                <li>
                                    <a href='{!!url("/remoteordersbackorders")!!}'  onclick="window.open(this.href, 'remoteordersbackorders',
'left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;">Back Orders</a>
                                </li>
                                @endif

                                <li>
                                    <a href='{!!url("/routeplanner")!!}' target="_blank">Route Plan</a>
                                </li>


                                <li>
                                    <a href='{!!url("/customersalespage")!!}' onclick="window.open(this.href, 'salescustomers',
'left=20,top=20,width=1200,height=950,toolbar=1,resizable=0'); return false;">Customer Sales</a>
                                </li>

                                <li>
                                    <a href='{!!url("/getdriverscashoff")!!}' onclick="window.open(this.href, 'getdriverscashoff',
'left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Drivers Cashoff</a>
                                </li>

                                <li>
                                    <a href='{!!url("/viewdailycash")!!}' onclick="window.open(this.href, 'viewdailycash',
'left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Daily Sales</a>
                                </li>


                                @if ($things != "0")
                                <li>
                                    <a href='{!!url("/getViewCallLogger")!!}' onclick="window.open(this.href, 'viewdailycash',
'left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Call Logger</a>
                                </li>
                                @endif

                                <li style="display: none;">
                                    <a href='{!!url("/gridPickingSlipCollectios")!!}'  onclick="window.open(this.href, 'gridPickingSlipCollectios',
'left=20,top=20,width=1500,height=500,toolbar=1,resizable=0'); return false;">Picking Slips</a>
                                </li>
                                @if(env('APP_STOCK_COUNT_PALLADIUM') =='TRUE')
                                <li>
                                    <a href='{!!url("/getPickingDeptPalladium")!!}'  onclick="window.open(this.href, 'getPickingDept',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Stock Sheet</a>
                                </li>
                                    @else
                                    <li>
                                        <a href='{!!url("/getPickingDept")!!}'  onclick="window.open(this.href, 'getPickingDept',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Stock Sheet</a>
                                    </li>
                                @endif
                                @if ($creditreport != "0")
                                <li>
                                    <a href='{!!url("/creditNoteReasonsView")!!}'  onclick="window.open(this.href, 'creditNoteReasonsView',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Credit Note Report</a>
                                </li>
                                @endif
                                <li>
                                    <a href='{!!url("/viewBlockedAccount")!!}'  onclick="window.open(this.href, 'viewBlockedAccount',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Blocked Orders</a>
                                </li>
                                <li>
                                    <a href='{!!url("/getNoStockItem")!!}'  onclick="window.open(this.href, 'viewBlockedAccount',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">No Stock Item</a>
                                </li>
                                <li>
                                    <a href='{!!url("/viewStatusReport")!!}'  onclick="window.open(this.href, 'viewBlockedAccount',
'left=20,top=20,width=1800,height=750,toolbar=1,resizable=0'); return false;">Progress and Status Report</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">C-Panel <span class="caret"></span></a>
                            <ul class="dropdown-menu" >

                                @if($drivers !="0")
                                <li>
                                    <a href='{!!url("/drivers")!!}'  onclick="window.open(this.href, 'drivers',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Drivers</a>
                                </li>
                                @endif
                                @if($grid !=0)
                                <li>
                                    <a href='{!!url("/grid_Users")!!}'  onclick="window.open(this.href, 'users',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Users</a>
                                </li>
                                @endif
                                @if($transfers !="0")
                                <li>
                                    <a href='{!!url("/transfersstatus")!!}'  onclick="window.open(this.href, 'transfersstatus',
'left=20,top=20,width=1600,height=999,toolbar=1,resizable=0'); return false;">Transfers </a>
                                </li>
                                @endif
                                <li>
                                    <a href='{!!url("/assets")!!}'  onclick="window.open(this.href, 'assets',
'left=20,top=20,width=1600,height=999,toolbar=1,resizable=0'); return false;">Assets</a>
                                </li>
                                    @if($trucks !="0")
                                <li>
                                    <a href='{!!url("/trucks")!!}'  onclick="window.open(this.href, 'trucks',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Trucks</a>
                                </li>
                                    @endif
                                @if($routes !="0")
                                <li>
                                    <a href='{!!url("/routes1")!!}'  onclick="window.open(this.href, 'routes',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Routes</a>
                                </li>
                                @endif
                                <li>
                                    <a href='{!!url("/glcodes")!!}'  onclick="window.open(this.href, 'routes',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">GL Codes</a>
                                </li>
                                <li style="display: none;">
                                    <a href='{!!url("/usersCrud")!!}'  onclick="window.open(this.href, 'users',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Users</a>
                                </li>
                                    @if($ordertypes !="0")
                                <li>
                                    <a href='{!!url("/ordertypes")!!}'  onclick="window.open(this.href, 'ordertypes',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Order Types</a>
                                </li>
                                    @endif
                                <li>
                                    <a href='{!!url("/getuseractionsBydate")!!}'  onclick="window.open(this.href, 'getuseractionsBydate',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">User Actions</a>
                                </li>
                                    <li>
                                    <a href='{!!url("/liveBulkPicking")!!}'  onclick="window.open(this.href, 'liveBulkPicking',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Picking Screen</a>
                                </li>
                                @if($salesperformance !="0")
                                <li>
                                    <a href='{!!url("/salesPerformanceview")!!}'  onclick="window.open(this.href, 'telesalesperformance',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Sales Performance</a>
                                </li>
                                @endif
                                @if($creditnotes !=0)
                                <li>
                                    <a href='{!!url("/viewCreditLimit")!!}'  onclick="window.open(this.href, 'creditLimitNotes',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Credit Limit Notes</a>
                                </li>
                                @endif

                                <li>
                                    <a href='{!!url("/getProductsStopedBuying")!!}'  onclick="window.open(this.href, 'getProductsStopedBuying',
'left=20,top=20,width=1200,height=1000,toolbar=1,resizable=0'); return false;">Stopped Buying</a>
                                </li>

                                <li>
                                    <a href='{!!url("/brands")!!}'  onclick="window.open(this.href, 'brands',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Brands</a>
                                </li>
                                <li>
                                    <a href='{!!url("/groups")!!}'  onclick="window.open(this.href, 'groups',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Groups</a>
                                </li>
                                <li style="display: none;">
                                    <a href='{!!url("/taxes")!!}'  onclick="window.open(this.href, 'taxes',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Taxes</a>
                                </li>
                                <li>
                                    <a href='{!!url("/pickingteam")!!}'  onclick="window.open(this.href, 'pickingteam',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Picking Team</a>
                                </li>
                                <li>
                                    <a href='{!!url("/groupbrands")!!}'  onclick="window.open(this.href, 'groupbrands',
'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0'); return false;">Group Brands</a>
                                </li>
                                <li>
                                    <a href='{!!url("/webstore")!!}'  onclick="window.open(this.href, 'webstore',
'left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;">Web Store</a>
                                </li>
                                    @if($remoteorders !=0)
                                <li>
                                    <a href='{!!url("/remoteorders")!!}'  onclick="window.open(this.href, 'webstore',
'left=20,top=20,width=900,height=900,toolbar=1,resizable=0'); return false;">Remote Orders</a>
                                </li>
                                    @endif
                                    @if($briefcase !=0)
                                <li>
                                    <a href='{!!url("/missedvisit")!!}'  onclick="window.open(this.href, 'briefcase',
'left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;">Salesman Briefcase</a>
                                </li>
                                    @endif
                                    @if($loyalty !=0)
                                <li>
                                    <a href='{!!url("/registercards")!!}'  onclick="window.open(this.href, 'registercards',
'left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;">Business Loyalty Cards</a>
                                </li>
                                <li>
                                    <a href='{!!url("/registercardswalking")!!}'  onclick="window.open(this.href, 'registercardswalking',
'left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;">Personal Loyalty Cards</a>
                                </li>
                                    @endif
@if($pospanel !=0)
                                <li>
                                    <a href='{!!url("/viewassignuserstotill")!!}/{{(new \DateTime())->format('Y-m-d')}}'  onclick="window.open(this.href, 'viewassignuserstotill',
'left=20,top=20,width=1650,height=900,toolbar=1,resizable=0'); return false;"> POS Panel</a>
                                </li>
                                    @endif

                                @if($messaging !=0)
                                <li>
                                    <a href='http://linxsystems.co.za/Publish/DIMS%20-%20Network%20Messenger/DIMS%20-%20Network%20Messenger.application'  onclick="window.open(this.href, 'messageapp',
'left=20,top=20,width=500,height=400,toolbar=1,resizable=0'); return false;">Download Messaging App</a>
                                </li>
                                @endif
                                    @if($webstoremassage !=0)
                                    <li>
                                        <a href='{!!url("/WebstoreMessages")!!}' onclick="window.open(this.href, 'WebstoreMessages',
'left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Webstore Messages</a>
                                    </li>
                                    @endif
                                    @if($printeredit !=0)
                                    <li>
                                        <a href='{!!url("/PathEditor")!!}' onclick="window.open(this.href, 'PathEditor',
'left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Edit Printer Paths</a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href='{!!url("/viewDeletedOrders")!!}' onclick="window.open(this.href, 'viewDeletedOrders',
'left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Deleted Orders</a>
                                    </li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle"
                               data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->UserName }}
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" style="height:83px !important;">
                                <li>
                                    <a href= "{{ route('logout') }}"
                                       onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                <li>
                                    <button class="btn-md btn-primary" id="clearlocks" value="{{ Auth::user()->UserId }}" style="height: 30px;    width: 98%;">Clear Locks</button>


                                </li>
                            </ul>
                        </li>
                        <li>
                            <i class="fa fa-calculator" aria-hidden="true" id="tamaraCalculatorId" aria-hidden="true" style="color: deeppink;"></i>
                        </li>

                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div id="main" class="row">

        @yield('content')

    </div>

</div>


<!-- Scripts -->
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
$('#clearlocks').click(function(){
    //console.debug($('#orderId').val());
    if($('#orderId').val().length < 3) {
        $.ajax({
            url: '{!!url("/deleteuserOrderLocks")!!}',
            type: "POST",
            data: {
                userId: $('#clearlocks').val()
            },
            success: function (data) {

            }
        });
    }else {
        var dialog = $('<p>Please Reload you DIMS before clearing your locks and also make sure everything is saved.</p>').dialog({
            height: 200, width: 700, modal: true, containment: false,
            buttons: {
                "OKAY": function () {

                    dialog.dialog('close');

                }
            }
        });
    }
});
});

</script>


</body>
</html>
