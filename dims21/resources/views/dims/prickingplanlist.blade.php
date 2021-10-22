<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .rag-red {
            background-color: #f00f0c;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }
        .rag-yellow {
            background-color: #f6ff23;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
    <div class="container">

        <table id="orderHeaderPrint">
            <thead>
            <tr >
                <th class="col-xs-2">Storename</th>
                <th class="col-xs-2">Code</th>
                <th class="col-xs-2">Description</th>
                <th class="col-xs-2" >Qty</th>
                <th class="col-xs-2" >Comments</th>
                <th class="col-xs-2" >Picked Qty</th>


            </tr>
            </thead>
            <tbody>
            @foreach($listproducts as $val )
                <tr>
                    <td>{{ $val->StoreName}}</td>
                    <td>{{ $val->PastelCode}}</td>
                    <td>{{ $val->PastelDescription}}</td>
                    <td>{{ $val->mnyQty}}</td>
                    <td></td>
                    <td></td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

</body>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<style>
    table {

        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }
    tbody tr:nth-child(odd) {
        background-color: #ccc;
    }
    th, td {
        text-align: left;
        padding: 2px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
<script>
    $(document).ready(function (){

        $('#continue').click(function(){
            window.location = '{!!url("/home")!!}';
        });

    });

</script>
