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

        <table>
            <tbody>
            <tr>
                <td  class="col-xs-2">Date Loaded</td>
                <td  class="col-xs-2" style="width: 117px;"> </td>
                <td  class="col-xs-2">Dunnages #</td>
                <td  class="col-xs-2" style="width: 117px;"></td>
                <td  class="col-xs-2">Load Completed</td>
                <td  class="col-xs-2" style="width: 117px;"></td>
            </tr>
            <tr>
                <td  class="col-xs-2">Time Loaded</td>
                <td  class="col-xs-2"> </td>
                <td  class="col-xs-2">Straps #</td>
                <td  class="col-xs-2"></td>
                <td  class="col-xs-2">Load Secured</td>
                <td  class="col-xs-2"></td>
            </tr>
            <tr>
                <td  class="col-xs-2">Team Leader</td>
                <td  class="col-xs-2"> </td>
                <td  class="col-xs-2">Pallets #</td>
                <td  class="col-xs-2"></td>
                <td  class="col-xs-2">Team Leader Signed</td>
                <td  class="col-xs-2"></td>
            </tr>
            <tr>
                <td  class="col-xs-2">Checker Name</td>
                <td  class="col-xs-2"> </td>
                <td  class="col-xs-2">Plastic Corners #</td>
                <td  class="col-xs-2"></td>
                <td  class="col-xs-2"></td>
                <td  class="col-xs-2"></td>
            </tr>
            <tr>
                <td  class="col-xs-2">Ticket #</td>
                <td  class="col-xs-2"> </td>
                <td  class="col-xs-2">Tarps #</td>
                <td  class="col-xs-2"></td>
                <td  class="col-xs-2">Stands #</td>
                <td  class="col-xs-2"></td>
            </tr>
            <tr>
                <td  class="col-xs-2">Driver Name</td>
                <td  class="col-xs-2"> </td>
                <td  class="col-xs-2">Trailer Type</td>
                <td  class="col-xs-2"></td>
                <td  class="col-xs-2">Falcon Sign</td>
                <td  class="col-xs-2"></td>
            </tr>
            <tr>
                <td  class="col-xs-2">Horse Reg#</td>
                <td  class="col-xs-2"> </td>
                <td  class="col-xs-2">Trailer Reg #</td>
                <td  class="col-xs-2"></td>
                <td  class="col-xs-2">Trailer No.</td>
                <td  class="col-xs-2"></td>
            </tr>

            </tbody>
        </table>
<hr><br>
        <table id="orderHeaderPrint">
            <thead>
            <tr >
                <th class="col-xs-2">Storename</th>
                <th class="col-xs-2">Code</th>
                <th class="col-xs-2">Description</th>
                <th class="col-xs-2" >Qty</th>
                <th class="col-xs-2" >Weights</th>

                <th class="col-xs-2" >Qty to Load</th>


            </tr>
            </thead>
            <tbody >
            <?php $storenames = ""; ?>
            @foreach($listproducts as $val )
                <tr>
                    @if($storenames != $val->StoreName )
                    <td>{{ $val->StoreName}}</td>
                        @else
                        <td></td>
                    @endif
                    <td>{{ $val->PastelCode}}</td>
                    <td>{{ $val->PastelDescription}}</td>
                    <td>{{ $val->mnyQty}}</td>
                    <td>{{ $val->weightPlanned}}</td>

                    <td></td>

                </tr>
                <?php $storenames = $val->StoreName; ?>
            @endforeach

            </tbody>
        </table>
    </div>

</body>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<style>
    table tbody {

        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }
    tbody tr:nth-child(odd) {
        background-color: #efefef;
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
