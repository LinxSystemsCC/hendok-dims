@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;display:none;">

    </div>
    <div class="col-lg-12">

        <div   class="col-lg-8">
            <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1" name="multicheckbox[]" multiple="multiple" >

                @foreach($cats as $values)
                    <option value="{{$values->CategoryId}}">{{$values->Category}}</option>
                @endforeach

            </select>
        </div>
        <div  class="col-lg-4">
            <button class="btn btn-primary btn-success" id="getproducts">GET</button>
        </div>
    </div>
    <div class="col-lg-12">
        <div id="items" style="height: 80%;background: white;overflow: scroll;" >


            <table id="tblProducts" class="table table-bordered">
                <thead>
                <tr>
                    <th><input type="checkbox" id="checkall" class="form-control input-sm col-xs-1"></th>
                    <th>Item Code</th>
                    <th>Item Name</th>

                </tr>
                </thead>
                <tbody id="products">

                </tbody>
            </table>
        </div>
        <button id="submitbtn" class="btn btn-primary btn-primary">Submit</button>
    </div>

    <script src="{{ asset('public/js/tableSorter.js') }}"></script>
@endsection
<style>
    .onDrag {
        height: 26px !important;
    }
    .backgroudcolor{
        background:red;
    }
    .lockedbackgroudcolor{
        background:#9b9bdc;
    }
    .backgroudcolorOffloadedHighNotification{
        background: rgba(4, 255, 31, 0.54);
    }
    #map {
        height: 100%;
    }
    .flex-container {
        display: flex;
        background: white;
        overflow: scroll;
        height:60%
    }
    .flex-container2{
        display: flex;

    }

    .flex-child {
        flex: 1;
        border: 2px solid #969494;
    }
    .flex-child2 {
        flex: 1;

    }

    .flex-child:first-child {
        margin-right: 20px;
    }
</style>

<script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>



<script>


    $(document).ready(function() {



        //localStorage.setItem('now', Date.now());
        //alert( localStorage.getItem('test') );
        //$('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#salesQuotebtn').hide();
        $('#afterFiltering').hide();
        //$('#doneSorting').hide();
        $('#updateSorting').hide();
        $('#popUpForNewTruckControlSheetHeader').hide();
        $('#messageNB').hide();
        $('#straightForwardPrintThtTruckControlId').hide();
        $('#instantPrint').hide();
        $('#trucSheetViewPopUp').hide();
        $('#popupmoveThis').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#salesInvoiced').hide();
        $('#confirmMove').hide();
        $("#creditOnHold").hide();
        $("#returns").hide();
        $("#customerPlanned").hide();
        //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#rouTabletLoadingtesonPlanning').multiselect({
            columns: 1,
            placeholder: 'Select Categories',
            search: true,
            selectAll: true
        });


        $('#getproducts').click(function(){
            getProductsCat();
        });

        $('#submitbtn').click(function(){
            var checkedLines = new Array();

            $('[name="ProductId"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                checkedLines.push({
                    'productid': id
                });

            });

            localStorage.removeItem('products');
            //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});
            localStorage.setItem('products', JSON.stringify({productId: checkedLines}));
        });


    });

    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class
                "close" : "ui-icon-circle-close",
                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
    function getProductsCat()
    {

        $.ajax({
            url: '{!!url("/jsongetproductbycat")!!}',
            type: "POST",
            data: {
                categories: $('#rouTabletLoadingtesonPlanning').val(),

            },
            success: function (data) {
                var trHTML = '';

                $('#products').empty();
                $('#products').show();
                $.each(data, function (key, value) {
                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey;font-family: Roboto;font-weight: normal" ><td><input type="checkbox" name ="ProductId" style="height: 20px !important;width: 50px !important;"  class="ProductId" value="' +value.ProductId + '"/></td>'+
                        '<td style="">'+value.PastelCode+'</td>'+
                        '<td style="">'+value.PastelDescription+'</td>'+

                        '</tr>';

                });

                $('#products').append(trHTML);

            }
        });
    }




</script>
<script>

</script>
