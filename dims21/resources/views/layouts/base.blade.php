<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'DIMS Hendok')</title>
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <link rel="stylesheet" href="{{asset('css/colors.css')}}">
    <link rel="stylesheet" href="{{ asset('resources\css\jobmodulestyle.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/myicons.css') }}">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>

    <!--  Select 2 Bootstrap Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- DevExtreme theme Light-->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.1.6/css/dx.material.orange.light.compact.css">

    <!-- Multiselect --> 
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet"  type='text/css'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

    <!-- File Saver -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.0.0/jspdf.umd.min.js"></script>

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

    <div class="col-12 d-flex px-0"  style="background: white;">
        @if(isset($includeMenu) && $includeMenu)
            <div class="col-custom-2"  style="background: white;">
                <div class="vertical-menu">
                    @include('warehouse.menu')
                </div>
            </div>
            <div class="col-custom-10 p-3" >
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<!-- Jquery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>

<!-- DevExtreme library -->
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.1.6/js/dx.all.js"></script>

<!-- Select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<!-- File Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

<!-- Multiselect -->
<script src="{{ asset('js/jquery.multiselect.js') }}"></script>

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