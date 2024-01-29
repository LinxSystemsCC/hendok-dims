@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Change')

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

<div class="col-12">
    <h3>Stock Change</h3>

    {{-- Initial customer --}}
    <div class="row">
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="customers">Customer</label>
            <select  class="form-control input-sm col-xs-1" style="width: 100% !important;"  id="customers" required>
                <option></option>
                @foreach($customers as $val)
                    <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                @endforeach
            </select>
        </div>

        {{-- Initial Product --}}
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="prodname">Product Name </label>
            <select  class="form-control input-sm col-xs-1" style="width: 100% !important;" id="prodname" required>
                <option></option>
            </select>
        </div>

        {{-- Ticket Number --}}
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="ticketNo">Ticket Number </label>
            <select  class="form-control input-sm col-xs-1" style="width: 100% !important;" id="ticketNo" required>
                <option></option>
            </select>
        </div>

        {{-- Mass --}}
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="mass">Mass</label>
            <input type="number" class="form-control input-sm col-xs-1" style="width: 100% !important;" id="mass" required disabled>
        </div>

        {{-- New Customer --}}
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="newcustomers">New Customer</label>
            <select  class="form-control input-sm col-xs-1" style="width: 100% !important;" id="newcustomers" required>
                <option></option>
                @foreach($customers as $val)
                    <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                @endforeach
            </select>
        </div>

        {{-- New Product Name --}}
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="newprodname">New Product Name </label>
            <select  class="form-control input-sm col-xs-1" style="width: 100% !important;" id="newprodname" required>
                <option></option>
            </select>
        </div>

        {{-- SE Code --}}
        <div class="form-group mb-2">
            <label class="control-label fw-bold" for="SECode">SE no.</label>
            <input type="text" class="form-control input-sm col-xs-1" style="width: 100% !important;" id="SECode" required disabled>
        </div>

        <div class="form-group mb-2">
            <button class="btn btn-success mb-2 w-100" id="save">SAVE</button>
        </div>
    </div>

</div>

@endsection

@section('scripts')

<script>

    $(document).ready(function() {
        $('#customers').select2({
            theme: 'bootstrap-5',
            containerCssClass: 'w-100',
            // dropdownParent: $('#modal'),
        });

        $('#newcustomers').select2({
            theme: 'bootstrap-5',
            // dropdownParent: $('#modal'),
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
                    $('#prodname').select2({
                        theme: 'bootstrap-5',
                        // dropdownParent: $('#modal'),
                    });
                    
                }
            });

        });

        $("#newcustomers").change(function () {

            $.ajax({

                url: '{!!url("/wmaxgetcustomerproduct")!!}',
                type: "GET",
                data: {
                    customers: $("#newcustomers").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#newprodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.ProductName+'">'+o.ProductName+'</option>';
                    });
                    $("#newprodname").append(toAppend);
                    $('#newprodname').select2({
                        theme: 'bootstrap-5',
                        // dropdownParent: $('#modal'),
                    });
                }
            });
        });

        $("#prodname").change(function () {
            $.ajax({

                url: '{!!url("/getticketno")!!}',
                type: "GET",
                data: {
                    customer: $("#customers").val(),
                    product: $("#prodname option:selected").text(),
                },
                success: function (data) {
                    var toAppend = '';
                    $("#ticketNo").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.TicketNo+'">'+o.TicketNo+'</option>';
                    });
                    $("#ticketNo").append(toAppend);
                    $('#ticketNo').select2({
                        theme: 'bootstrap-5',
                        // dropdownParent: $('#modal'),
                    });
                }
            });
        });
        
        $("#ticketNo").change(function () {
            $.ajax({

                url: '{!!url("/getmasswmax")!!}',
                type: "GET",
                data: {
                    ticket: $("#ticketNo option:selected").text(),
                },
                success: function (data) {
                    mass = data[0].Weight;
                    $('#mass').val(mass);
                }
            });
        });

        $("#newprodname").change(function () {
            $.ajax({

                url: '{!!url("/getSEno")!!}',
                type: "GET",
                data: {
                    customer: $("#newcustomers").val(),
                    product: $("#newprodname option:selected").text(),
                },
                success: function (data) {
                    SECode = data[0].SECode;
                    console.debug(SECode);
                    $('#SECode').val(SECode);
                }
            });
        });

        $('#save').click(function(){
            $.ajax({
                url: '{!!url("/savestockchangewmax")!!}',
                type: "POST",
                data: {
                    ticketNo : $('#ticketNo option:selected').val(),
                    mass : $('#mass').val(),
                    newcustname : $('#newcustomers option:selected').val(),
                    newprodname : $('#newprodname option:selected').val(),
                    SENo : $('#SECode').val(),
                },
                success: function (data) {
                    var ticket =  data[0].TicketNo;
                    window.open('{!!url("/printGalvLabel")!!}/'+ticket,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");
                    location.reload();
                }
            });
        });
    });

</script>

@endsection
