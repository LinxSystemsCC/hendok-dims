@extends('layouts.app')

@section('content')
<label class="control-label" for="machine"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Machine</label>

<br>
<select name = "machine" type="text"  id="machine" style="width:500px;height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

<option value="0" disabled>-- Please Choose a Machine--</option>
@foreach($machines as $val)
        <option value="{{$val->strMachineName}}">{{$val->strMachineDescription}}</option>
@endforeach

</select>

<br>
<label class="control-label" for="productCode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Product Code</label>
<br>
<input type="text"  id="productCode" style="width:500px;height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

<br>
<label class="control-label" for="lineNumber"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Line Number</label>
<br>
<input type="number"  id="lineNumber" style="width:500px;height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

<br>
<label class="control-label" for="quantity"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Quantity</label>
<br>
<input type="number" id="quantity" style="width:500px;height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">

<br>

<button type = "button"id = "saveTransfer">Save</button>



@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      $(document).ready(function() {
        //TABS
        $('#returns').hide();
        $('#salesInvoiced').hide();
        $('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#afterFiltering').hide();
        $('#doneSorting').hide();
        $('#updateSorting').hide();
        $('#popUpForNewTruckControlSheetHeader').hide();
        $('#messageNB').hide();
        $('#straightForwardPrintThtTruckControlId').hide();
        $('#instantPrint').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        
        $('#saveTransfer').click(function()
        {
            
            $.ajax({
                url: '{!!url("/saveTransfer")!!}',
                type: "POST",
                data: {
                    machine: $('#machine').val(),
                    prodcode: $('#productCode').val(),
                    linenumber:$('#lineNumber').val() ,
                    qty:$('#quantity').val()
                },
                success: function (data) {
                   window.location.reload();
                }
            });
        });
      });
    </script>