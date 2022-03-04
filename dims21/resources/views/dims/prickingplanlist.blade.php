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
        table, td, th {
            border: 1px solid #ddd;
            text-align: left;
        }
        table {
            border-collapse: collapse;
            width: 100%;
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
        <table id="orderHeaderPrint" style="font-size: 11px;">
            <thead>
            <tr style="    background: black;    color: white;" >
                <th class="col-xs-2">Storename</th>
                <th class="col-xs-1">Area</th>
                <th class="col-xs-2" style="width: 80px">Order Date</th>
                <th class="col-xs-2">Sales Order No</th>
                <th class="col-xs-2">Instruction</th>
                <th class="col-xs-2">Line No</th>
                <th class="col-xs-2">Description</th>
                <th class="col-xs-2" style="width: 80px;" >Quantity</th>
                <th class="col-xs-2" >Weights</th>


                <th class="col-xs-2" >To Invoice</th>


            </tr>
            </thead>
            <tbody >
            <?php $storenames = "";$orderNumber=""; $subtotal=0;$Grandtotal=0;$area = "";$orderdate=""; $istrue = true;$count = 0; ?>
            @foreach($listproducts as $val )
            <?php $subtotal = $subtotal + floatval($val->weightPlanned);    ?>
                <?php $Grandtotal = $Grandtotal + floatval($val->weightPlanned);?>
            @if($storenames != $val->StoreName )
                @if($count > 0 )
                <tr style="background: darkgray;color: white; font-weight: 900;">
                    <td></td>
                    <td> </td>
                    <td>NEXT</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> {{$subtotal}}</td>

                    <td></td>
                </tr>
                    <?php $subtotal = 0;$count = 0; ?>
                @endif
                <tr>

                    <td>{{ $val->StoreName}}</td>
                    <td>{{ $val->areas}}</td>



                    <td>{{ $val->OrderDate}}</td>
                    <td>{{ $val->OrderNum}}</td>
                    <td>{{ $val->ExtOrderNum}}</td>
                    <td>{{ $val->iLineID}}</td>
                    <td>{{ $val->PastelDescription}}</td>
                    <td style="font-size: 14px;background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                    <td>{{ floatval($val->weightPlanned)}}</td>


                    <td></td>


                </tr><?php $istrue = true; $storenames = $val->StoreName; $orderNumber =  $val->OrderNum;$area =  $val->areas;$orderdate = $val->OrderDate  ?>

                @else
                <tr>

                    @if($storenames != $val->StoreName )
                        <td>{{ $val->StoreName}}</td>

                    @else
                        <td>

                        </td>
                    @endif
                    @if($area !=  $val->areas)
                    <td>{{ $val->areas}}</td>
                        @else
                        <td></td>
                        @endif
                        @if($orderdate != $val->OrderDate)
                    <td>{{ $val->OrderDate}}</td>
                        @else
                            <td></td>
                            @endif

                        @if($orderNumber != $val->OrderNum)
                    <td>{{$val->OrderNum}}</td>
                        @else
                            <td style="">

                            </td>
                            @endif
                    <td>{{ $val->ExtOrderNum}}</td>
                    <td>{{ $val->iLineID}}</td>
                    <td>{{ $val->PastelDescription}}</td>
                    <td  style="font-size: 14px;background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                    <td>{{ floatval($val->weightPlanned)}}</td>


                    <td></td>


                </tr>
                <?php $storenames = $val->StoreName; $orderNumber =  $val->OrderNum;$area =  $val->areas;
                if($storenames == $val->StoreName){
                    $istrue = true;
                }
                ?>
                @endif
            <?php $count++; ?>
            @endforeach
            <tr style="background: grey;color: white;font-weight: 900">
                <td> Grand Total</td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>{{ $Grandtotal}}</td>

                <td> </td>
            </tr>

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
    /*tbody tr:nth-child(odd) {
        background-color: #efefef;
    }
    th, td {
        text-align: left;
        padding: 2px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }*/
</style>
<script>
    $(document).ready(function (){

        $('#continue').click(function(){
            window.location = '{!!url("/home")!!}';
        });

    });

</script>
