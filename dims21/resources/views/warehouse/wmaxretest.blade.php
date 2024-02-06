@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Re-Test')

{{-- Set to show navbar --}}
@php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        // $permission = $v->getThingsUserPermissions(Auth::user()->UserID,'Permission');
    }

    $includeMenu = true;
    
@endphp

@section('page')


    <h3>Re-Test</h3>

    <div class="d-flex">
        {{-- Left Div --}}
        <div style="padding: 20px;">

            {{-- scales --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="scales">Scales</label>
                <select  class="form-control input-sm col-xs-1 " id="scales" style="width: 100%; height:38px !important;" required>
                    <option></option>
                    @foreach($scales as $val)
                        <option value="{{$val->intAutoId}}">{{$val->strName}}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- customer --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="customers">Customer</label>
                <select  class="form-control input-sm col-xs-1 " id="customers" style="width: 100%; height:38px !important;" required>
                    <option></option>
                    @foreach($customers as $val)
                        <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                    @endforeach
                </select>
            </div>

            {{-- Product --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="prodname">Product Name </label>
                <select  class="form-control input-sm col-xs-1" id="prodname" style="width: 100%; height:38px !important;" required>
                    <option></option>
                </select>
            </div>

            {{-- Zinc Spec --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="zincspec">Zinc</label>
                <input type="text" class="form-control input-sm col-xs-1" id="zincspec" required disabled>
            </div>

            {{-- MPA Spec --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="mpaspec">MPA Spec</label>
                <input type="text" class="form-control input-sm col-xs-1" id="mpaspec" required disabled>
            </div>

            {{-- Blank --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="blank"></label>
                <input type="text" class="form-control input-sm col-xs-1" id="blank" required disabled style="visibility: hidden;">
            </div>

            {{-- Wire Size Spec --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="wirespec">Wire Size Spec</label>
                <input type="text" class="form-control input-sm col-xs-1" id="wirespec" required disabled>
            </div>

        </div>

        {{-- Right Div --}}
        <div style="padding: 20px;">

            {{-- Blank --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="blank"></label>
                <input type="number" class="form-control input-sm col-xs-1" id="blank" required disabled style="visibility: hidden;">
            </div>

            {{-- Blank --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="blank"></label>
                <input type="number" class="form-control input-sm col-xs-1" id="blank" required disabled style="visibility: hidden;">
            </div>

            {{-- SE Code --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="SECode">SE no.</label>
                <input type="text" class="form-control input-sm col-xs-1" id="SECode" required disabled>
            </div>
            

            {{-- Zinc Tested --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="zinctested">Actual Zinc Tested</label>
                <input type="number" class="form-control input-sm col-xs-1" id="zinctested" required>
            </div>

            {{-- MPA Tested --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="mpatested">Actual MPA Tested</label>
                <input type="number" class="form-control input-sm col-xs-1" id="mpatested" required>
            </div>

            {{-- Tensile Ticket--}}
            <div class="form-group">
                <label class="control-label fw-bold" for="tensileticket">Tensile Ticket No</label>
                <input type="number" class="form-control input-sm col-xs-1" id="tensileticket" required>
            </div>
            
            {{-- Wire Size --}}
            <div class="form-group">
                <label class="control-label fw-bold" for="wiresize">Actual Wire Size</label>
                <input type="number" class="form-control input-sm col-xs-1" id="wiresize" required>
            </div>

        </div>
    </div>
    {{-- Remarks --}}
    <div class="form-group">
        <label class="control-label fw-bold" for="remark">Remarks</label>
        <textarea  type="text" rows="3" class="form-control input-sm col-xs-1" id="remark" required></textarea>
    </div>

    {{-- Tare Mass --}}
    <div class="form-group">
        <label class="control-label fw-bold" for="tare">Tare Mass</label>
        <select  class="form-control input-sm col-xs-1" id="tare" required>
            <option>
            </option>
        </select>
    </div>

    {{-- Gross Mass --}}
    <div class="form-group">
        <label class="control-label fw-bold" for="mass">Mass</label>
        <input type="number" class="form-control input-sm col-xs-1" id="mass" required>
    </div>

    {{-- Final Mass --}}
    <div class="form-group">
        <label class="control-label fw-bold" for="final">Final Mass</label>
        <input type="number" class="form-control input-sm col-xs-1" id="final" required disabled>
    </div>
    
    <button class="btn btn-success" id="save" style="width: 100%;">SAVE</button>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        
        $("#tare").change(function() {
            //console.debug($('#tare').val());
            finalweight = ($("#mass").val()-$('#tare').val());
            $('#final').val(finalweight);
        });
        
        $("#mass").change(function() {
            finalweight = ($("#mass").val()-$('#tare').val());
            $('#final').val(finalweight);
        });

        //Get Scales
        $.ajax({
            url: '{!!url("/getTare")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                // $("#tare").select2({ data:result });
                // console.log(data.length);
                // console.log(data);

                for (let i = 0; i < data.length; i++) {
                    // console.log(data[i].StandName);
                    name = data[i].StandName;
                    mass = data[i].StandMass;

                    $('#tare').append(`<option value="${mass}">${name}</option>`);
                }
            }
        });

        $("#customers").change(function () {

            $.ajax({

                url: '{!!url("/wmaxgetcustomerproduct")!!}',
                type: "GET",
                data: {
                    customers: $("#customers").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.ProductName+'">'+o.ProductName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();
                }
            });

        });


        $("#prodname").change(function () {
            $.ajax({

                url: '{!!url("/getretest")!!}',
                type: "GET",
                data: {
                    customer: $("#customers").val(),
                    product: $("#prodname option:selected").text(),
                },
                success: function (data) {
                    $('#zincspec').val(data[0].ZincSpec);
                    $('#mpaspec').val(data[0].MPATolerance);
                    $('#wirespec').val(data[0].SizeTolerance);
                    $('#SECode').val(data[0].SECode);
                }
            });
        });

        $('#save').click(function(){
            $.ajax({
                url: '{!!url("/saveretest")!!}',
                type: "POST",
                data: {
                    custname  : $('#customers option:selected').val(),
                    prodname  : $('#prodname option:selected').val(),
                    zincTested  : $('#zinctested').val(),
                    MPATested  : $('#mpatested').val(),
                    tensileTicket  : $('#tensileticket').val(),
                    wireSize  : $('#wiresize').val(),
                    remark  : $('#remark').val(),
                    taremass  : $('#tare option:selected').val(),
                    grossmass  : $('#mass').val(),
                    finalmass  : $('#final').val(),

                },
                success: function (data) {
                    if (data[0].Result = "Success"){
                        var ticket =  data[0].TicketNo;

                        window.open('{!!url("/printGalvLabel")!!}/'+ticket,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");
                        location.reload();
                    }else{
                        alert("error saving re-test. Please try again.");
                        location.reload();
                    }
                }

                });
        });
        
    });

</script>

@endsection
