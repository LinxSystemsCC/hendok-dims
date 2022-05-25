<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
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
                        <?php
                            if ((Auth::guest()))
                            {

                            }else{
                                    $v  =  new \App\Http\Controllers\SalesForm();
                                    $invoice = $v->getThings(Auth::user()->GroupId,'Can Final Invoice Load');
                            }
                        ?>
<div class="container">
    <div style="display: flex;">
        <div style="width: 10%" id="qrs">
    {!! QrCode::size(60)->generate($ref); !!}<br>
            <i style="font-size: 7px;">{{$ref}}</i>
        </div>
        <div style="width: 90%">
            @foreach($pickingheader as $value)
            //
            @if($value->isReadyForInvoicing == 1)
<button  id="driversheet">Print Driver Sheet</button>
                @endif

            @endforeach

    <table style="font-size: 11px;">
        <tbody>
        <tr>
            <td  class="col-xs-2">Date Loaded</td>
            <td  class="col-xs-2" style="width: 117px;"> </td>
            <td  class="col-xs-2">Dunnages #</td>
            <td  class="col-xs-2" style="width: 117px;"> @foreach($pickingheader as $value) {{$value->intDunnages}} @endforeach</td>
            <td  class="col-xs-2">Load Completed</td>
            <td  class="col-xs-2" style="width: 117px;"> @foreach($pickingheader as $value) {{$value->strLoadComplete}} @endforeach</td>
        </tr>
        <tr>
            <td  class="col-xs-2">Time Loaded</td>
            <td  class="col-xs-2"> </td>
            <td  class="col-xs-2">Straps #</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->intStraps}} @endforeach</td>
            <td  class="col-xs-2">Load Secured</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->strLoadSecured}} @endforeach</td>
        </tr>
        <tr>
            <td  class="col-xs-2">Team Leader</td>

            <td  class="col-xs-2"> @foreach($pickingheader as $value) {{$value->UserName}} @endforeach </td>
            <td  class="col-xs-2">Pallets #</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->intPallets}} @endforeach</td>
            <td  class="col-xs-2">Team Leader Signed</td>
            <td  class="col-xs-2"></td>
        </tr>
        <tr>
            <td  class="col-xs-2">Checker Name</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->strCheckerName}} @endforeach </td>
            <td  class="col-xs-2">Plastic Corners #</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->intPlasticCorners}} @endforeach</td>
            <td  class="col-xs-2"></td>
            <td  class="col-xs-2"></td>
        </tr>
        <tr>
            <td  class="col-xs-2">Ticket #</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->strTicket}} @endforeach </td>
            <td  class="col-xs-2">Tarps #</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->intTarps}} @endforeach</td>
            <td  class="col-xs-2">Stands #</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->intStans}} @endforeach</td>
        </tr>
        <tr>
            <td  class="col-xs-2">Driver Name</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->drivers}} @endforeach </td>
            <td  class="col-xs-2">Trailer Type</td>
            <td  class="col-xs-2"> @foreach($pickingheader as $value) {{$value->TruckName}}  @endforeach</td>
            <td  class="col-xs-2">Falcon Sign</td>
            <td  class="col-xs-2"></td>
        </tr>
        <tr>
            <td  class="col-xs-2">Horse Reg#</td>
            <td  class="col-xs-2"> </td>
            <td  class="col-xs-2">Trailer Reg #</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->RegNo}} @endforeach</td>
            <td  class="col-xs-2">Trailer No.</td>
            <td  class="col-xs-2">@foreach($pickingheader as $value) {{$value->strTrailorNo}} @endforeach</td>
        </tr>

        </tbody>
    </table>

        </div>
    </div>
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
            <?php   $externalCount = 0;        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
            $t=time();
            $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
            $ID = $t.$randomString;  ?>
            @if($count == 0 )
                <tr style="background: darkgray;color: white; font-weight: 900;" id="{{$ID}}">
                    <td>STOP :{{$val->intSequence}}</td>
                    <td> </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> </td>

                    <td></td>
                </tr>
                @endif
            <?php $Grandtotal = $Grandtotal + floatval($val->weightPlanned);?>
            @if($storenames != $val->StoreName )

                @if($count > 0 )
                    <tr style="background: darkgray;color: white; font-weight: 900;">
                        <td>STOP :{{$val->intSequence}}</td>
                        <td> </td>
                        <td>NEXT</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{$subtotal}} </td>

                        <td></td>
                    </tr>
                    <?php $subtotal = 0;$count = 0; ?>
                @endif

                @if(  $val->isLineInvoiced == 1)
                    <tr id="rtrr{{$ID}}" style="background: #0091EA">
                    @else
                <tr id="rtrr{{$ID}}">
                    @endif

                    <td>{{ $val->StoreName}}</td>
                    <td>{{ $val->areas}}</td>



                    <td>{{ $val->OrderDate}}</td>
                    <td>{{ $val->OrderNum}} @if($val->isReadyForInvoicing == 1)
                            <button style="background: #0BA008;color: white;" class="invoicethis" value="{{$val->OrderId}}">Invoice {{ $val->OrderNum}}</button><input type="hidden" class="refid" value="{{$val->strUnickReference}}"> <input type="hidden" class="ownerid" value="{{$val->intOwnerID}}"> <input type="hidden" class="OrderNumdim" value="{{$val->OrderNum}}">
                                                <input type="hidden" class="rowids" value="{{$ID}}">  <input type="hidden" class="strTicket" value="{{ $val->strTicket}}">
                        @endif</td>
                    <td>{{ $val->ExtOrderNum}}</td>
                    <td>{{ $val->iLineID}}</td>
                    <td>{{ $val->PastelDescription}}</td>
                    <td style="font-size: 14px;background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                    <td>{{ floatval($val->weightPlanned)}}</td>


                    <td>{{ floatval($val->Toinvoice)}}</td>


                </tr><?php $istrue = true; $storenames = $val->StoreName;$subtotal = $subtotal + floatval($val->weightPlanned);  $orderNumber =  $val->OrderNum;$area =  $val->areas;$orderdate = $val->OrderDate  ?>

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
                        <td>{{$val->OrderNum}} @if($val->isReadyForInvoicing == 1)
                              <button style="background: #0BA008;color: white;" class="invoicethis" value="{{$val->OrderId}}">Invoice {{ $val->OrderNum}}</button><input type="hidden" class="refid" value="{{$val->strUnickReference}}"> <input type="hidden" class="ownerid" value="{{$val->intOwnerID}}"> <input type="hidden" class="OrderNumdim" value="{{$val->OrderNum}}">
                                @endif</td>
                    @else
                        <td style="">

                        </td>
                    @endif
                    <td>{{ $val->ExtOrderNum}}</td>
                    <td>{{ $val->iLineID}}</td>
                    <td>{{ $val->PastelDescription}}</td>
                    <td  style="font-size: 14px;background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                    <td>{{ floatval($val->weightPlanned)}}</td>


                    <td>{{ floatval($val->Toinvoice)}}</td>


                </tr>
                <?php $storenames = $val->StoreName;$subtotal = $subtotal + floatval($val->weightPlanned);  $orderNumber =  $val->OrderNum;$area =  $val->areas;
                if($storenames == $val->StoreName){
                    $istrue = true;
                }
                ?>
            @endif
            <?php $count++; ?>
        @endforeach
        <tr style="background: darkgray;color: white; font-weight: 900;">
            <td></td>
            <td> </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$subtotal}} </td>

            <td></td>
        </tr>
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
    <div>
        @foreach($pickingheader as $value) {{$value->strNotesandInstructions}} @endforeach
    </div>
</div>
<div id="seqpopup">
    <a href='{!!url("/ticketsdept")!!}/{{$ref}}' onclick="window.open(this.href, 'ticketsdept',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;" style="background: #13b0bb;padding:2px;color: black;font-weight: 900" >Assign Transport</a>
    <br>
    <br>
    <br>
    @foreach($pickingheader as $value)
        @if($value->isCancelled == "0")
        <button class="planstatus" value="1" style="background: #bb1523;float: right;">Delete This Plan</button>
        @endif

            @if($value->isCancelled == "1")
                <button class="planstatus" value="0" style="background: #0BA008;float: right;">Re-Activate This Plan</button>
            @endif
    @endforeach

    <input type="hidden"  id="refno" value="{{$ref}}">
    <table id="sequences" style="font-size: 12px;">
        <tbody>
    @foreach($sequence as $val )
     <tr>
         <td> {{$val->StoreName}}</td>
         <td><input type="hidden" value="{{$val->OrderNum}}" class="onum">{{$val->OrderNum}}</td>
         <td>  <input type="number"  name="ordernumber[]" class="qty" value="{{$val->intSequence}}"></td>
     </tr>

        @endforeach
        </tbody>
        </table>
    <hr>
    Team Leader<br>
    <select id="teamleaders">
        @foreach($teamleaders as $value)
            <option value="{{$value->UserID}}">{{$value->UserName}}</option>
            @endforeach
    </select><br>
    Trailor Type<br>
    <select id="truckname">
        @foreach($trucks as $value)
            <option value="{{$value->TruckId}}">{{$value->TruckName}}</option>
        @endforeach
    </select><br>
    <label>Any Instructions</label>
    <textarea maxlength="1900" id="someinstruction">

    </textarea>
    <button class="btn-lg btn-success" id="saveseq">SAVE</button>
</div>

</body>

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

        $('#seqpopup').hide();
        $('#continue').click(function(){
            window.location = '{!!url("/home")!!}';
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.planstatus').click(function(){
            $.ajax({
                url: '{!!url("/markplandeleted")!!}',
                type: "GET",
                data: {
                    referenceno: $('#refno').val(),
                    planstatus:$('.planstatus').val()
                },
                success: function (data) {

                    alert("DONE UPDATING");
                    location.reload()
                }
            });
        });

        $('#driversheet').click(function(){
            window.open('{!!url("/printtripsheet")!!}/' + $('#refno').val(), "tripsheet" + $('#refno').val(), "location=1,status=1,scrollbars=1, width=1200,height=850");
        });

        $('#qrs').click(function(){
            alert("Open Info Dialog");
            $('#seqpopup').show();
            var dialog2 = $('#seqpopup').dialog({
                height: 800, width: 700, modal: true, containment: false
            });
            $('#saveseq').click(function(){
                var stopsseq = new Array();
                $('#sequences > tbody  > tr').each(function() {
              //      var onum = $(this).closest('tr').find('.onum').val();
                    stopsseq.push({
                        'onum': $(this).closest('tr').find('.onum').val(),
                        'Qty': $(this).closest('tr').find('.qty').val(),
                    });

                });

                console.debug(stopsseq);

                $.ajax({
                    url: '{!!url("/sequencepickingplans")!!}',
                    type: "post",
                    data: {
                        referenceno: $('#refno').val(),
                        stopsseq:stopsseq,
                        teamleaderId:$('#teamleaders').val(),
                        truckname:$('#truckname').val(),
                        someinstruction:$('#someinstruction').val()
                    },
                    success: function (data) {

                        location.reload();
                    }
                });
            });
        });

        $('#orderHeaderPrint').on('click', 'button', function (e) {
            var $this = $(this);

            var SONumber = $this.closest('tr').find('.OrderNumdim').val();
            var ownerid = $this.closest('tr').find('.ownerid').val();
            var invoiceid = $this.closest('tr').find('.invoicethis').val();
            var ref = $this.closest('tr').find('.refid').val();
            var rowId = $this.closest('tr').find('.rowids').val();
            var strTicket = $this.closest('tr').find('.strTicket').val();

            console.debug("rowId-*******************"+rowId);
            console.debug("SONumber-*******************"+SONumber);
            console.debug("invoiceid-*******************"+invoiceid);
            console.debug("ownerid-*******************"+ownerid);
            if(strTicket=="notick"){
                alert("Weighbridge Ticket Is Not Set");
            }else{
                $.ajax({
                    url: '{!!url("/individualInvoicing")!!}',
                    type: "get",
                    data: {
                        ownerid: ownerid,
                        SONumber:SONumber,
                        invoiceid:invoiceid,
                        ref:ref
                    },
                    success: function (data) {

                        $('#'+rowId).css('background', '#89CFF0');
                        $('#rtrr'+rowId).css('background', '#89CFF0');
                    }
                });
            }

        });

    });

</script>
