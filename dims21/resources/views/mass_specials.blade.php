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
    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/excel-bootstrap-table-filter-style.css') }}" rel="stylesheet"  type='text/css'>
    <link href="{{ asset('css/contextMenu.css') }}" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
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
    <script src="https://use.fontawesome.com/0f659c6d48.js"></script>
    <script src="{{ asset('public/js/jqueryprint.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js//vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>


</head>
<body>
    {!! $grid !!}
</body>
</html>

<style>
    table tr td{
        padding: 1px !important;
    }
</style>
