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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/smoothcss.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scroller.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/tippop.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/jquery.inputpicker.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet"  type='text/css'>
    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet"  type='text/css'>
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
    <script src="{{ asset('js/excel-bootstrap-table-filter-bundle.js') }}"></script>
    <script src="{{ asset('js/sum().js') }}"></script>
    <script src="{{ asset('js/contextMenu.js') }}"></script>
    <script src="https://use.fontawesome.com/0f659c6d48.js"></script>
    <script src="{{ asset('public/js/jqueryprint.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js//vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>


    <style>
        /*TAB*/
        li div.tab-frame input{ display:none;}
        li div.tab-frame label{ display:block; float:left;padding:5px 10px; cursor:pointer}
        li div.tab-frame input:checked + label{ background:black; color:white; cursor:default}
        li div.tab-frame div.tab{ display:none; padding:5px 10px;clear:left}

        li div.tab-frame input:nth-of-type(1):checked ~ .tab:nth-of-type(1),
        li div.tab-frame input:nth-of-type(2):checked ~ .tab:nth-of-type(2),
        li div.tab-frame input:nth-of-type(3):checked ~ .tab:nth-of-type(3),
        li div.tab-frame input:nth-of-type(4):checked ~ .tab:nth-of-type(4){ display:block;}
        /*END OF TABS*/
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

    <div id="main" class="row">

        @yield('content')

    </div>

</div>






<!-- Scripts -->


</body>
</html>
