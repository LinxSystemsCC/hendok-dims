<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'DIMS Hendok')</title>
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <link rel="stylesheet" href="{{asset('public/css/colors.css')}}">
    <link rel="stylesheet" href="{{ asset('public/css/jobmodulestyle_final.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/myicons.css') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}"/>

    <!--  Select 2 Bootstrap Theme -->
    <link rel="stylesheet" href="{{ asset('public/css/select2-bootstrap-5-theme.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-icons.css') }}"/>

    <!-- DevExtreme theme Light-->
    <link rel="stylesheet" href="{{ asset('public/css/dx.material.orange.light.compact.css') }}">

    <!-- Multiselect -->
    <link rel="stylesheet" href="{{ asset('public/css/jquery.multiselect.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('public/css/general.css') }}"/>

    <!-- Excel -->
    <script src="{{ asset('public/js/exceljs.min.js') }}"></script>

    <!-- File Saver -->
    <script src="{{ asset('public/js/FileSaver.min.js') }}"></script>

    <!-- jsPDF -->
    <script src="{{ asset('public/js/jspdf.umd.min.js') }}"></script>

    <style>
        .dx-datagrid .dx-link {
            color: var(--hendok-red) !important;
        }

        .dx-pager .dx-page-sizes .dx-selection, .dx-pager .dx-pages .dx-selection {
            background-color: var(--hendok-red) !important;
            color: var(--hendok-light);
        }

        .dx-button-mode-text.dx-button-default {
            color: var(--hendok-red) !important;
        }

        .dx-datagrid-filter-panel .dx-datagrid-filter-panel-clear-filter, .dx-datagrid-filter-panel .dx-datagrid-filter-panel-text {
            color: var(--hendok-red) !important;
        }

        .dx-datagrid-filter-panel .dx-icon-filter {
            color: var(--hendok-red) !important;
        }

        .dx-checkbox-checked .dx-checkbox-icon {
            color: var(--hendok-light);
            background-color: var(--hendok-red) !important;
        }

        .dx-checkbox-indeterminate .dx-checkbox-icon {
            color: var(--hendok-light);
            background-color: var(--hendok-red) !important;
        }

        .dx-selection{
            background-color: var(--hendok-red-highlight) !important;
        }

        .text-green{
            color: #028A0F;
            font-weight: 500;
        }

        .text-yellow{
            color: #ffd700;
            font-weight: 500;
        }

        .text-red{
            color: #b90e0a;
            font-weight: 500;
        }

        .map-icon-label i {
            font-size: 24px;
            color: #FFFFFF;
            line-height: 55px;
            text-align: center;
            white-space: nowrap;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent dark background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure it's above other content */
            color: white;
        }

        :root {
            --point-color: White;
            --size: 5px;
        }

        .loader {
            background-color: var(--main-color);
            overflow: hidden;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            align-items: center;
            align-content: center;
            justify-content: center;
            z-index: 100000;
        }

        .loader__element {
            border-radius: 100%;
            border: var(--size) solid var(--point-color);
            margin: calc(var(--size)*1);
        }

        .loader__element:nth-child(1) {
            animation: preloader .6s ease-in-out alternate infinite;
        }
        .loader__element:nth-child(2) {
            animation: preloader .6s ease-in-out alternate .2s infinite;
        }

        .loader__element:nth-child(3) {
            animation: preloader .6s ease-in-out alternate .4s infinite;
        }

        @keyframes preloader {
            100% { transform: scale(1.3); }
        }

    </style>

</head>
<body class="vh-100 h-100">
    <div id="overlay" hidden>
        <div class="loader d-flex">
            <span class="loader__element"></span>
            <span class="loader__element"></span>
            <span class="loader__element"></span>
        </div>
    </div>

    <div class="col-12 d-flex px-0 mh-100"  style="background: white;">
        @if(isset($includeMenu) && $includeMenu)
            <div class="col-custom-2"  style="background: white;">
                <div class="vertical-menu">
                    @include('warehouse.menu')
                </div>
            </div>
            <div class="col-custom-10 p-3 w-100 ms-2 me-2" >
                @yield('page')
            </div>
        @else
            <div class="col-12 p-3" >
                @yield('page')
            </div>
        @endif
    </div>
</body>

<!-- Bootstrap -->
<script src="{{ asset('public/js/bootstrap.bundle.min.js') }}"></script>

<!-- Jquery -->
<script src="{{ asset('public/js/jquery.min.js') }}"></script>

<!-- DevExtreme library -->
<script type="text/javascript" src="{{ asset('public/js/dx.all.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('public/js/select2.min.js') }}"></script>

<!-- Excel -->
<script src="{{ asset('public/js/xlsx.full.min.js') }}"></script>

<!-- File Saver -->
<script src="{{ asset('public/js/FileSaver.min.js') }}"></script>

<!-- Multiselect -->
<script src="{{ asset('public/js/jquery.multiselect.js') }}"></script>

<script src="{{ asset('public/js/general.js') }}"></script>

<script>
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.sidebar ul li a').click(function(){
        var id = $(this).attr('id');
        $('nav ul li ul.item-show-'+id).toggleClass("show");
        $('nav ul li #'+id+' span').toggleClass("rotate");

    });

    $('nav ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
    });

</script>

@yield('scripts')

</html>
