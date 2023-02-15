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
    <script src="{{ asset('public/js/jquery.easy-autocomplete.min.js') }}"></script>
    <script src="{{ asset('js/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>

    <script src="{{ asset('js/sum().js') }}"></script>
    <script src="{{ asset('js/contextMenu.js') }}"></script>
    <script src="{{ asset('public/js/jqueryprint.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('public/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js//vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/tableSorter.js') }}"></script>

    {{-- Added By Kyle 20230214 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <style>
        .fa-xl {
            line-height: 30px !important;
        }

        .btn{
            font-weight: bold !important;
            margin-left: 10px !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
        }

        .offcanvas-body {
            /* overflow-y: unset !important; */
            height: 80%;
        }

        a{
            font-size: 12px !important;
            text-decoration: none !important;
        }

        span{
            margin-rigth: 10px !important;
        }

        li{
            padding: 3px !important;
            text-decoration: none !important;
            text-transform: uppercase !important;
        }

        span::before{
            padding:10px !important;
        }

        .offcanvas.offcanvas-start {
            width: 300px !important;
        }
    </style>
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
</head>

<body style="color:black">
    <div id="app">
        @include('layouts.nav')

        <header class="navbar flex-md-nowrap flex-sm-nowrap p-3" style="background-color: rgb(255, 255, 255);">
            <a class="btn position-absolute float-start" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="background-color: rgb(255, 255, 255); color: grey;"><span class="fa fa-bars fa-xl"></span>
            </a>

            <ul class="nav d-flex justify-content-center align-items-center w-90 px-1">
                <!-- Authentication Links -->

                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li>
                        <button type="button" id="orderListing" class="btn btn-warning" style="width: 110px;">ORDER LISTING</button>
                    </li>
                    <li style="display: none">
                        <button type="button" id="reports" class="btn btn-primary" style="width: 110px;display: none">REPORTS</button>
                    </li>
                    <li>
                        <button type="button" id="pricing" class="btn btn-success" style="width: 110px;">Price Check</button>
                    </li>
                    <li>
                        <button type="button" id="pricingOnCustomer" class="btn btn-success" style="width: 110px;">PL</button>
                    </li>
                    <li>
                        <button type="button" id="callList" class="btn btn-primary" style="width: 110px;">Call List</button>
                    </li>
                    <li style="display: none">
                        <button type="button" id="tabletLoadingApp" class="btn btn-primary" style="display:none;">Reprint</button>
                    </li>
                    <li style="display: none">
                        <button type="button" id="salesQuotebtn" class="btn btn-info" style="width: 110px;display: none">Sales Quotes</button>
                    </li>
                    <li style="display: none">
                        <button type="button" id="copyOrdersBtn" class="btn btn-info" style="width: 110px;">Copy Orders</button>
                    </li>
                    <li style="display: none">
                        <button type="button" id="routePlanning" class="btn btn-primary" style="width: 110px;display: none">Route Plan</button>
                    </li>
                    <li>
                        <button type="button" id="salesOnOrder" class="btn btn-primary" style="width: 110px;">On Order</button>
                    </li>
                    <li>
                        <button type="button" id="salesInvoiced" class="btn btn-warning" style="width: 110px;">On Invoice</button>
                    </li>
                    <li>
                        <button type="button" id="posCashUp" class="btn btn-primary" style="width: 110px;">Cash Up</button>
                    </li>
                    <li style="display: none">
                        <button type="button" id="pricelist" class="btn btn-success" style="width: 110px;display:none;">Price List</button>
                    </li>
                    <li style="display: none">
                        <button type="button" id="returns" class="btn btn-success" style="width: 110px;display: none;">Returns</button>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"aria-haspopup="true" aria-expanded="false">
                            <b>{{ Auth::user()->UserName }}</b>
                        </a>
                        <ul class="dropdown-menu" style="height:83px !important;">
                            <li>
                                <a href= "{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
                        <i class="fa fa-calculator fa-2xl" aria-hidden="true" id="tamaraCalculatorId" aria-hidden="true" style="color: deeppink;"></i>
                    </li>
                @endif
            </ul>
        </header>
        
        <div id="main" class="row h-100">
            @yield('content')
        </div>
    </div>
</body>

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

        $('#offcanv').click(function(){
            $('#offcanvas').toggle();
        });
    });
</script>

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

</html>
