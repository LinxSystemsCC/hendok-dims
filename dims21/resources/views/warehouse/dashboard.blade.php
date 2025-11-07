<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <title>DIMS Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 90vh;
            margin: 0;
        }

        .full-height {
            height: 90vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
            width: 100%;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

</head>
<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >
        <div class="flex-center position-ref full-height">
            <div class="content">
                @if(Auth::user()->UserID == 0)
                    <div class="card p-3 mb-3">
                        <form method="GET" action="{{ route('dashboard') }}">
                            <label class="form-label fw-bold">Select Menu Type for All Users:</label>
                            <select name="menu_type" class="form-select w-auto d-inline-block">
                                <option value="old" {{ config('app.menu_type') == 'old' ? 'selected' : '' }}>Old Menu</option>
                                <option value="new" {{ config('app.menu_type') == 'new' ? 'selected' : '' }}>New Menu</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                        </form>
                    </div>
                @endif
                <div class="title m-b-md">
                    <img  src="public/images/dimslogo.png" style="height: 100px;">
                    <strong>Welcome to DIMS</strong>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Excel Saver -->
<script src="{{ asset('js/exceljs.min.js') }}"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="{{ asset('js/dx.all.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {

        $('.sidebar ul li a').on(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");

        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");

        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

    });
</script>
