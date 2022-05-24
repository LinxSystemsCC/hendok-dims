@extends('layouts.app')

@section('content')
    <div class="col-lg-12"  style="background: white;    font-family: 'Helvetica Neue', arial, sans-serif;">
        <h3 style="text-align: center;">Customer Specials</h3>
        <fieldset class="well">
            <legend class="well-legend">Add Filters</legend>
            <form>
                <div class="col-md-12">
                    <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="inputCustAcc"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Account</label>
                        <input type="text" name="custCode" class="form-control input-sm col-xs-1" id="inputCustAcc" style="height:22px;font-size: 10px;font-weight: 900;    color: black;">
                        <input type="hidden" name="customerId" class="form-control input-sm col-xs-1" id="customerId" style="height:22px;font-size: 10px;font-weight: 900;    color: black;" required>
                    </div>

                    <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="inputCustName"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Customer Name</label>
                        <input type="text" name="custDescription" class="form-control input-sm col-xs-1" id="inputCustName" style="height:22px;font-size: 10px;font-weight: 900;    color: black;" required>
                    </div>
                    <div class="form-group col-md-2 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="custheadid"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Contract ID</label>
                        <select  class="form-control input-sm col-xs-1" id="custheadid" style="font-weight: 900;    color: black;font-size: 13px;">

                        </select>
                    </div>
                    <div class="form-group col-md-1 itCanHide"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateFrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date From</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateFrom" style="font-weight: 900;    color: black;font-size: 13px;">
                    </div>
                    <div class="form-group col-md-1 "  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                        <label class="control-label" for="dateTo"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date To</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="dateTo" style="font-weight: 900;    color: black;font-size: 13px;">

                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label" for="submitFiltersOnCreatingCustSpecial"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;"></label>
                        <button type="button" id="submitFiltersOnCreatingCustSpecial" class="btn-xs btn-success" style="padding: 2px 49px;">Submit</button>
                        
    <button type="button" id="deletelines" class="btn-danger btn-xs" style="float:right;">Delete All - Lines</button>
    <button type="button" id="deleteall" class="btn-danger btn-xs" style="float:right;">Delete Contract </button>
                    </div>
                  

                </div>


            </form>
            <div class="col-md-12" style="margin-top: 25px;">

                <div class="col-md-8">

                    <button type="button" id="addinHistory" class="btn-xs btn-primary" style="padding: 2px 49px;">Get History</button>
                    <button type="button" id="pricelist1convert" class="btn-xs btn-primary" style="padding: 2px 25px;">Price List 1</button>
                    <button type="button" id="pricelist2convert" class="btn-xs btn-primary" style="padding: 2px 25px;">Price List 2</button>
                    <button type="button" id="getContractDetails" class="btn-xs btn-primary " style="padding: 2px 19px;">Get Contract Details</button>
                    <button type="button" id="copyContractIntoLines" class="btn-xs btn-primary " style="padding: 2px 19px;">Copy Contract</button>

                </div>
                <button type="button" id="importexcel" class="btn-xs btn-primary" style = "float:right">Import Excel</button>
                

                <button type="button" id="exportexcel" class="btn-xs btn-primary" style = "float:right">Export Excel</button>
            </div>

        </fieldset>
    </div>
    <div class="col-lg-12" id="afterFilter" style="    font-family: 'Helvetica Neue', arial, sans-serif;">
        <div class="col-lg-12" style="background: white;height: 60%;overflow-y: scroll">

            <button class="btn-success btn-xs" id="addLine">Add Line</button>
                    
            <table id ="tblCreateNewSpecial" class="tablesorter table table-bordered table-condensed table-intel">

                <thead>
                <tr style="font-size: 12px;" >
                    <!--<th style="background: aquamarine;">Code</th>
                    <th style="background: aquamarine;">Description</th>
                    <th style="background: aquamarine;">DtFrom</th>
                    <th style="background: aquamarine;">DtTo</th>
                    <th style="background: aquamarine;">Price</th>
                    <th style="background: aquamarine;">Qty</th>
                    <th style="background: aquamarine;">Cost</th>
                    <th style="background: aquamarine;">GP</th>
                    <th style="background: aquamarine;">Less 10%</th>
                    -->
                    <th>Code</th>
                    <th >Description</th>
                    <th >DtFrom</th>
                    <th >DtTo</th>
                    <th >Price</th>
                    <th >Qty</th>
                    <th >Cost</th>
                    <th>GP</th>
                    <th >Less 10%</th>
                    <th >Pricelist 1</th>
                    <th >Pricelist 2</th>
                    <th >Pricelist 3</th>
                    <th >Pricelist 4</th>
                    <th >Pricelist 5</th>
                    <th >Pricelist 6</th>
                    <th >C.S Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="clusterize-scroll"></tbody>

            </table>

        </div>
        <div class="col-lg-12" style="background: white;">
            <button id="doneCreating" class="btn-xs btn-success">Done</button>
        </div>


    </div>
    <div title="Items having duplicate specials. Press Yes to push the products, No closes the dialog" id="duplicatespecials">
        <h2>These lines have duplicate specials.</h2>
        <form>

            <div class="form-group  col-md-12" >
                <table class="table2 table-bordered  dataTable">
                    <thead>
                    <tr>
                        <td>Item Code</td>
                        <td>Item Name</td>
                        <td>Price</td>
                        <td>Date From</td>
                        <td>Date To</td>
                        <td>Contract ID</td>
                    </tr>
                    </thead>
                    <tbody id="gridduplicatespecials">

                    </tbody>
                </table>

            </div>
        </form>

    </div>
    <div title="Copy Contract" id="dialogcopycontracts">
        <h3>Copy Contract From </h3>
        <form>
            <div class="col-md-12">
                <div class="form-group  col-md-12" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="custcodeto"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Enter Contact ID You Want To Copy From</label>
                    <input class="form-control input-sm col-md-4 auto-complete-off" name="entercontracts" id="entercontracts" style="height:30px;font-size: 10px;"></input>
                </div>
                <div class="col-md-12">
                    <button type="button" id="validateConTractId" class="btn-warning btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Validate The Contract ID</button>

                </div>
                <div class="col-md-12" id="messagevalidatingthecontract">

                </div>
                <div class="col-md-12">
                    <button type="button" id="finalisecopy" class="btn-success btn-xs pull-right" style="margin-top: 29px;margin-right: 15px;">Finalise Copying</button>
                </div>
            </div>
        </form>
    </div>
  

@endsection
<style>
    .tablesorter thead tr .header {
        background-image:url({{asset('images/bg.gif')}});
        background-repeat: no-repeat;
        background-position: center right;

    }
    .table thead th {
         position: sticky;
          top: 0;
          background:white;
        }
    .tablesorter thead tr .headerSortDown {
        background-image: url({{asset('images/asc.gif')}});
    }
    .tablesorter thead tr .headerSortDown {
        background-image: url({{asset('images/desc.gif')}});
    }
    .clusterize-scroll{
        max-height: 600px;
        overflow: auto;
    }

    /**
     * Avoid vertical margins for extra tags
     * Necessary for correct calculations when rows have nonzero vertical margins
     */
    .clusterize-extra-row{
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* By default extra tag .clusterize-keep-parity added to keep parity of rows.
     * Useful when used :nth-child(even/odd)
     */
    .clusterize-extra-row.clusterize-keep-parity{
        display: none;
    }

    /* During initialization clusterize adds tabindex to force the browser to keep focus
     * on the scrolling list, see issue #11
     * Outline removes default browser's borders for focused elements.
     */
    .clusterize-content{
        outline: 0;
        counter-reset: clusterize-counter;
    }

    /* Centering message that appears when no data provided
     */
    .clusterize-no-data td{
        text-align: center;
    }
</style>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy  + '-' +mm  + '-' +dd ;
    console.debug(today);
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    var jArray = JSON.stringify({!! json_encode($products) !!});
    var jArrayCustomer = JSON.stringify({!! json_encode($customers) !!});
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var finalDataProduct = $.map(JSON.parse(jArray), function (item) {
        return {
            value: item.PastelCode,
            PastelCode: item.PastelCode,
            PastelDescription: item.PastelDescription,
            UnitSize: item.UnitSize,
            Tax: item.Tax,
            Cost: parseFloat(item.Cost).toFixed(2),
            QtyInStock: item.QtyInStock,
            avgQty: item.avgQty,
            Margin: item.Margin,
            Alcohol: item.Alcohol,
            Available: parseFloat(item.Available).toFixed(2),
            PriceList1: parseFloat(item.PL1).toFixed(2),
            PriceList2: parseFloat(item.PL2).toFixed(2),
            PriceList3: parseFloat(item.PL3).toFixed(2),
            PriceList4: parseFloat(item.PL4).toFixed(2),
            PriceList5: parseFloat(item.PL5).toFixed(2),
            PriceList6: parseFloat(item.PL6).toFixed(2)
        }

    });
    var finalDataProductDescription = $.map(JSON.parse(jArray), function (item) {
        return {
            value: item.PastelDescription,
            PastelCode: item.PastelCode,
            PastelDescription: item.PastelDescription,
            UnitSize: item.UnitSize,
            Tax: item.Tax,
            Cost: parseFloat(item.Cost).toFixed(2),
            QtyInStock: item.QtyInStock,
            avgQty: item.avgQty,
            Margin: item.Margin,
            Alcohol: item.Alcohol,
            Available: parseFloat(item.Available).toFixed(2),
            PriceList1: parseFloat(item.PL1).toFixed(2),
            PriceList2: parseFloat(item.PL2).toFixed(2),
            PriceList3: parseFloat(item.PL3).toFixed(2),
            PriceList4: parseFloat(item.PL4).toFixed(2),
            PriceList5: parseFloat(item.PL5).toFixed(2),
            PriceList6: parseFloat(item.PL6).toFixed(2)
        }

    });
    var finalData =$.map(JSON.parse(jArrayCustomer), function(item) {

        return {
            BalanceDue:item.BalanceDue,
            CustomerPastelCode:item.CustomerPastelCode,
            StoreName:item.StoreName,
            UserField5:item.UserField5,
            CustomerId:item.CustomerId,
            CreditLimit:item.CreditLimit,
            Email:item.Email,
            Routeid:item.Routeid,
            Discount:item.Discount,
            OtherImportantNotes:item.OtherImportantNotes,
            Routeid:item.Routeid,
            strRoute:item.strRoute
        }

    });

    $(document).ready(function() {
/*
            $('#messagevalidatingthecontract').empty();

            console.debug("customerid-----------"+$('#custheadid').val()+"---------dFrom-----"+dFrom.length+"------------"+dateTo.length);
            if($('#custheadid').val() == "-99" && dFrom.length < 8 && dateTo.length < 8  )
*/
$('#importexcel').click(function(){
    

var dFromImporting =$('#dateFrom').val();
var dFromExporting =$('#dateTo').val();
    if($("#custheadid").val() == "-99" || dFromImporting.length < 8 || dFromExporting.length < 8){
        var dialog = $('<p><strong style="color:red">Contract ID Empty or Dates not selected yet</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
    }else{
   // window.location = '{!!url("/export")!!}/'+$('#custheadid').val();
    window.open('{!!url("/dialogtoimportspecials")!!}/' + $('#customerId').val()+"/"+ $('#custheadid').val() + "/" +$('#dateFrom').val()+ "/" + $('#dateFrom').val(), "Contract Id" + $('#custheadid').val(), "location=1,status=1,scrollbars=1, width=500,height=500");
    $('#importexcel').css('background-color','green');}
//
//showDialogWithoutClose('#uploaddocument',400,400);
});

        $("table").tablesorter({
           headers:{ 
           0: { sorter: false},
           4: { sorter: "digit"} , 
           6: { sorter: "digit"} , 
           7: { sorter: "digit"} , 
           8: { sorter: "digit"} , 
           9: { sorter: "digit"} , 
           10: { sorter: "digit"} , 
           11: { sorter: "digit"} , 
           12: { sorter: "digit"} , 
           13: { sorter: "digit"} , 
           14: { sorter:"digit"} , 
           15: { sorter: "digit"} 
            } 
        });
        $('#orderListing').hide();
        $('#addinCurrentPrices').hide();
        $('#addinHistory').hide();
        $('#pricing').hide();
        $('#pricingOnCustomer').hide();
        $('#callList').hide();
        $('#tabletLoadingApp').hide();
        $('#copyOrdersBtn').hide();
        $('#salesOnOrder').hide();
        $('#salesInvoiced').hide();
        $('#posCashUp').hide();
        $('#duplicatespecials').hide();
        $('#dialogcopycontracts').hide();
        $('#exportexcel').hide();
        $('#uploaddocument').hide();
        $('#exportexcel').click(function()
        {
            window.location = '{!!url("/export")!!}/'+$('#custheadid').val();
        });

        var inputCustAccount = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        inputCustAccount.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerId').val(data.CustomerId);
           // $('#customerIdfile').val(data.CustomerId);

        });
        var inputCustNumber = $('#inputCustAcc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'CustomerPastelCode',
            data: finalData
        });
        var inputCustName = $('#inputCustName').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            searchContain:true,
            focusFirstResult: true,
            visibleProperties: ["CustomerPastelCode","StoreName"],
            searchIn: 'StoreName',
            data: finalData
        });
        inputCustNumber.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerId').val(data.CustomerId);
            //start option population here async
            $.ajax({
                url: '{!!url("/getContractsPerCustomerID")!!}',
                type: "POST",
                data: {
                    customerid: $('#customerId').val()
                },
                success: function (data) {
                    $('#tblCreateNewSpecial tbody').empty();
                    var trHTML = "";
                    $("#custheadid").empty();
                    trHTML+='<option value="-99">Select a Contract ID</option>';
                    $.each(data, function (key, value) {

                        trHTML +=
                            '<option value="'+value.SpecialHeaderId+'">'+value.SpecialHeaderId+' ['+value.DateFrom+' TO '+value.DateTo+']' +'</option>';

                    });
                    $("#custheadid").append(trHTML);
                }
            });


        });
        inputCustName.on('select:flexdatalist', function (event, data) {

            $('#inputCustAcc').val(data.CustomerPastelCode);
            $('#inputCustName').val(data.StoreName);
            $('#customerId').val(data.CustomerId);
           // $('#customerIdfile').val(data.CustomerId);
            $.ajax({
                url: '{!!url("/getContractsPerCustomerID")!!}',
                type: "POST",
                data: {
                    customerid: $('#customerId').val()
                },
                success: function (data) {
                    $('#tblCreateNewSpecial tbody').empty();
                    var trHTML = "";
                    $("#custheadid").empty();
                    trHTML+='<option value="-99">Select a Contract ID</option>';
                    $.each(data, function (key, value) {

                        trHTML +=
                            '<option value="'+value.SpecialHeaderId+'">'+value.SpecialHeaderId+' ['+value.DateFrom+' TO '+value.DateTo+']' +'</option>';

                    });
                    $("#custheadid").append(trHTML);
                }
            });


        });
        $('#deletelines').click(function(){
            var dialog = $('<p><strong style="color:red">Are you sure you want to delete all lines?</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Yes": function () {
                                    $.ajax({
    url: '{!!url("/deletecontractlines")!!}',
    type: "POST",
    data: {
        contractid: $('#custheadid').val(),
       
    },
    success: function (data) {
        $('#tblCreateNewSpecial tbody').empty();
    }
});
                                    dialog.dialog('close');
                                },
                                "No": function(){
                                    dialog.dialog('close');
                                }
                            }
                        });
            


});
$('#deleteall').click(function(){

            
    var dialog = $('<p><strong style="color:red">Are you sure you want to delete the whole contract?</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Yes": function () {
                                    $.ajax({
    url: '{!!url("/deleteALLBasedContract")!!}',
    type: "POST",
    data: {
        contractid: $('#custheadid').val(),
       
    },
    success: function (data) {
        $('#tblCreateNewSpecial tbody').empty();
    }
});
                                    dialog.dialog('close');
                                },
                                "No": function(){
                                    dialog.dialog('close');
                                }
                            }
                        });
            



});
        $('#addLine').click(function(){

            generateALine2();
        });
        $("#dateFrom,#dateTo").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#submitFiltersOnCreatingCustSpecial').click(function(){

            $('#addinCurrentPrices').show();
            $('#addinHistory').show();
            $('#afterFilter').show();
            $('#tblCreateNewSpecial tbody').empty();
            if($("#custheadid").val() == "-99"){
                //create
                $.ajax({
                url: '{!!url("/createnewcustomercontract")!!}',
                type: "POST",
                data: {
                    customerId: $('#customerId').val(),
                    dateFrom: $('#dateFrom').val(),
                    dateTo: $('#dateTo').val()
                },
                success: function (data) {
                        console.log(data[0].result);
                        $('#custheadid').prepend('<option value="'+data[0].result+'" selected="selected">'+data[0].result+' ['+$('#dateFrom').val()+' TO '+$('#dateTo').val()+']' +'</option>');

                        $('#exportexcel').show();
                  

                }
            });
            }
        });
        $("#custheadid").change(function(){   // 1st way

        $('#exportexcel').show();
            var end = this.value;
            $('#contractIdfile').val(end);
            $.ajax({
                url: '{!!url("/getcontractDates")!!}',
                type: "POST",
                data: {
                    contractId: end
                },
                success: function (data) {

                    $('#dateFrom').val($.datepicker.formatDate('dd-mm-yy', new Date( data[0].DateFrom)) );
                    $('#dateTo').val( $.datepicker.formatDate('dd-mm-yy', new Date( data[0].DateTo))  );

                }
            });

        });
        $('#copyContractIntoLines').click(function(){

            //copy contract
            var dFrom =$('#dateFrom').val();
            var dateTo =$('#dateTo').val();
            $('#messagevalidatingthecontract').empty();

            console.debug("customerid-----------"+$('#custheadid').val()+"---------dFrom-----"+dFrom.length+"------------"+dateTo.length);
            if($('#custheadid').val() == "-99" && dFrom.length < 8 && dateTo.length < 8  )
            {
                var dialog = $('<p>Sorry <strong style="color:red"> Please put in the dates, or make sure you have selected the contract ID</strong></p>').dialog({
                    height: 200, width: 700,
                    buttons: {
                        "OK": function () {

                            dialog.dialog('close');
                        }
                    }
                });
            }else{
                $('#entercontracts').val("");
                $('#dialogcopycontracts').show();
                showDialogWithoutClose('#dialogcopycontracts',400,400);
            }

        });
        $('#finalisecopy').click(function(){

            //copy contract
            var contractidtouse = $('#entercontracts').val();
            //	@contructId as bigint,

            if( contractidtouse.length < 2 )
            {
                var dialog = $('<p>Sorry <strong style="color:red">Please Put In The Contract ID You Want To Copy The Data From </strong></p>').dialog({
                    height: 200, width: 700,
                    buttons: {
                        "OK": function () {

                            dialog.dialog('close');
                        }
                    }
                });
            }else{
                $.ajax({
                    url: '{!!url("/copycontract")!!}',
                    type: "POST",
                    data: {
                        contructId: contractidtouse,
                        customerIdToCopyTo: $('#customerId').val(),
                        contractIdToCopyTo: $('#custheadid').val(),
                        dateFrom: $('#dateFrom').val(),
                        dateTo: $('#dateTo').val()

                    },
                    success: function (data) {
                        console.debug(data[0].result);
                        if( data[0].result=="Success"){
                            // $('#dialogcopycontracts').dialog('close');
                            // $('#getContractDetails').click();
                            //contractId
                            var dialog = $('<p> <strong style="color:red">Contract ID is '+data[0].contractId+' </strong></p>').dialog({
                                height: 200, width: 700,
                                buttons: {
                                    "OK": function () {
                                        dialog.dialog('close');
                                        location.reload();
                                    }
                                }
                            });

                        }

                    }
                });
            }


        });
        $('#validateConTractId').click(function(){

            //copy contract
            $.ajax({
                url: '{!!url("/validatethecontractId")!!}',
                type: "GET",
                data: {
                    entercontracts: $('#entercontracts').val()
                },
                success: function (data) {
                    console.debug(data[0].result);
                    //$('#messagevalidatingthecontract').empty();
                    $('#messagevalidatingthecontract').append( data[0].result );
                    $('#messagevalidatingthecontract').dialog('close');

                }
            });
        });

        $('#pricelist2convert').click(function(){
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {

                var ID = $(this).attr('id');
                var jID = '#'+ID;
                var x = ID.indexOf("x");
                var get_token_number = ID.substring(x+1,ID.length); //gets the numbers successfully...
                $('#prodPrice_'+ get_token_number).val(roundquick($('#PL2_'+get_token_number).val()));
                $('#gp_'+get_token_number).val(roundquick(marginCalculator($('#cost_'+ get_token_number).val(),$('#prodPrice_'+ get_token_number).val())));

            });
        });
        $('#pricelist1convert').click(function(){
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {

                var ID = $(this).attr('id');
                var jID = '#'+ID;
                var x = ID.indexOf("x");
                var get_token_number = ID.substring(x+1,ID.length); //gets the numbers successfully...
                $('#prodPrice_'+ get_token_number).val(roundquick($('#PL1_'+get_token_number).val()));
                $('#gp_'+get_token_number).val(roundquick(marginCalculator($('#cost_'+ get_token_number).val(),$('#prodPrice_'+ get_token_number).val())));
            });
        });
        $('#addinHistory').click(function(){

            var theVal = this.value;
            $.ajax({
                url: '{!!url("/getCurrentHistoryCustomerSpecialsKF")!!}',
                type: "POST",
                data: {
                    customercode:$('#inputCustAcc').val(),
                    customerId: $('#customerId').val(),
                    contractid: $('#custheadid').val()
                },
                success: function (data) {
                    var trHTML = '';
                    $.each(data, function (key, value) {
                        var contractFrom = $('#dateFrom').val();
                        var contractTo = $('#dateTo').val();
                        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
                        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                            '<td contenteditable="false" class="col-sm-1"> <i style="font-size: 0px">'+value.PastelCode+'"</i> <input name="theProductCode" id ="prodCode_'+tokenId+'"  value="'+value.PastelCode+'" class="theProductCode_ set_autocomplete inputs"></td>' +
                            '<td contenteditable="false"  class="col-md-3"><i style="font-size: 0px">'+value.PastelDescription+'"</i> <input name="prodDescription_" id ="prodDescription_'+tokenId+'"value="'+value.PastelDescription+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
                            '<td  contenteditable="false" class="col-md-1"><i style="font-size: 0px">'+contractFrom+'"</i><input type="text" name="dateFrom" id ="dateFrom'+tokenId+'" value= "'+contractFrom+'"  title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
                            '<td contenteditable="false" class="col-md-1"><i style="font-size: 0px">'+contractTo+'"</i><input type="text" name="dateTo"  id ="dateTo'+tokenId+'" value= "'+contractTo+'" class="dateTo resize-input-inside inputs"></td>' +
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+value.PriceLookedUp+'"</i> <input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'"value="'+parseFloat(value.PriceLookedUp).toFixed(2)+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs lst" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false"  ><i style="font-size: 0px">'+value.avgQty+'"</i> <input type="text" name="avgQty_" id ="avgQty_'+tokenId+'"value="'+value.avgQty+'" onkeypress="return isFloatNumber(this,event)" class="avgQty_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false" ><i style="font-size: 0px">'+value.Cost+'"</i> <input type="text" name="cost_" id ="cost_'+tokenId+'"value="'+value.Cost+'" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false"  ><i style="font-size: 0px">'+parseFloat( marginCalculator(value.Cost,value.PriceLookedUp).toFixed(2))+'"</i> <input type="text" name="gp_" id ="gp_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+value.PriceLookedUp+'"</i> <input type="text" name="less10perc_" id ="less10perc_'+tokenId+'"value="'+parseFloat(value.PriceLookedUp*0.9).toFixed(2)+'" onkeypress="return isFloatNumber(this,event)" class="less10perc_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL1+'"</i> <input type="text" name="PL1_" id ="PL1_'+tokenId+'"value="'+roundquick(value.PL1)+'" onkeypress="return isFloatNumber(this,event)" class="PL1_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL2+'"</i> <input type="text" name="PL2_" id ="PL2_'+tokenId+'"value="'+roundquick(value.PL2)+'" onkeypress="return isFloatNumber(this,event)" class="PL2_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL3+'"</i> <input type="text" name="PL3_" id ="PL3_'+tokenId+'"value="'+roundquick(value.PL3)+'" onkeypress="return isFloatNumber(this,event)" class="PL3_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL4+'"</i> <input type="text" name="PL4_" id ="PL4_'+tokenId+'"value="'+roundquick(value.PL4)+'" onkeypress="return isFloatNumber(this,event)" class="PL4_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL5+'"</i> <input type="text" name="PL5_" id ="PL5_'+tokenId+'"value="'+roundquick(value.PL5)+'" onkeypress="return isFloatNumber(this,event)" class="PL5_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL6+'"</i> <input type="text" name="PL6_" id ="PL6_'+tokenId+'"value="'+roundquick(value.PL6)+'" onkeypress="return isFloatNumber(this,event)" class="PL6_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+value.PriceLookedUp+'"</i> <input type="text" name="prodPriceB_" id ="prodPriceB_'+tokenId+'"value="'+parseFloat(value.PriceLookedUp).toFixed(2)+'" onkeypress="return isFloatNumber(this,event)" class="prodPriceB_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
                        $('#tblCreateNewSpecial tbody')
                            .append( $row )
                            .trigger('addRows', [ $row, false ]);
                        if(!$('.lst').is(":focus"))
                        {
                            $('#prodCode_' + tokenId).focus();

                            if ($('#checkboxDescription').is(':checked')) {
                                $('#prodDescription_' + tokenId).focus();
                            }
                        }
                        var resort  = true;
                        $('#tblCreateNewSpecial').trigger('update',[resort]);
                        $('#gp_'+ tokenId).val( parseFloat( marginCalculator(value.Cost,$('#prodPrice_'+tokenId).val()).toFixed(2)));
                        $('input').on('click keyup' ,function(){
                            // $('input').click(function(){
                            var ID = $(this).attr('id');
                            var jID = '#'+ID;
                            var x = ID.indexOf("_");
                            var get_token_number = ID.substring(x+1,ID.length);

                            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                                $(""+jID+"").mcautocomplete({
                                    source: finalDataProductDescription,
                                    columns:columnsD,
                                    autoFocus: true,
                                    minlength: 2,
                                    delay: 0,
                                    multiple: true,
                                    multipleSeparator: ",",
                                    select:function (e, ui) {
                                        console.log(ui.item);
                                        var n = ID.indexOf("_");
                                        var token_number = ID.substring(n + 1, ID.length);

                                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                                        {
                                            $('#prodQty_'+token_number).val('0');
                                            $('#prodPrice_'+token_number).val('0');
                                        }
                                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                                        $('#avgQty_' + token_number).val(ui.item.avgQty);
                                        $('#cost_' + token_number).val(ui.item.Cost);
                                        $('#prodPrice_' + token_number).val('');
                                        $('#PL1_' + token_number).val(ui.item.PriceList1);
                                        $('#PL2_' + token_number).val(ui.item.PriceList2);
                                        $('#PL3_' + token_number).val(ui.item.PriceList3);
                                        $('#PL4_' + token_number).val(ui.item.PriceList4);
                                        $('#PL5_' + token_number).val(ui.item.PriceList5);
                                        $('#PL6_' + token_number).val(ui.item.PriceList6);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        productPrice(token_number);


                                    }
                                });

                            }

                            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                                    ,
                                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                                $("" + jID + "").mcautocomplete({
                                    source: finalDataProduct,
                                    columns:columnsC,
                                    minlength: 1,
                                    autoFocus: true,
                                    delay: 0,
                                    select:function (e, ui) {
                                        console.log(ui.item);
                                        var n = ID.indexOf("_");
                                        var token_number = ID.substring(n + 1, ID.length);
                                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                                        {
                                            $('#prodQty_'+token_number).val('0');
                                            $('#prodPrice_'+token_number).val('0');
                                        }
                                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                                        $('#prodPrice_' + token_number).val('');
                                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                                        $('#avgQty_' + token_number).val(ui.item.avgQty);
                                        $('#cost_' + token_number).val(ui.item.Cost);
                                        $('#PL1_' + token_number).val(ui.item.PriceList1);
                                        $('#PL2_' + token_number).val(ui.item.PriceList2);
                                        $('#PL3_' + token_number).val(ui.item.PriceList3);
                                        $('#PL4_' + token_number).val(ui.item.PriceList4);
                                        $('#PL5_' + token_number).val(ui.item.PriceList5);
                                        $('#PL6_' + token_number).val(ui.item.PriceList6);
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        productPrice(token_number);

                                    }

                                });
                            }
                            //calculator();

                        });

                        $(".dateTo,.dateFrom").datepicker({
                            changeMonth: true,//this option for allowing user to select month
                            changeYear: true, //this option for allowing user to select from year range
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#tblCreateNewSpecial').on('click', 'button', function (e) {
                            var $this = $(this);
                            $this.closest('tr').remove();
                        });
                    });

                }
            });

        });
        $('#pricelist1convert').click(function(){
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {

                var ID = $(this).attr('id');
                var jID = '#'+ID;
                var x = ID.indexOf("x");
                var get_token_number = ID.substring(x+1,ID.length); //gets the numbers successfully...
                $('#prodPrice_'+ get_token_number).val(roundquick($('#PL1_'+get_token_number).val()));
                $('#gp_'+get_token_number).val(roundquick(marginCalculator($('#cost_'+ get_token_number).val(),$('#prodPrice_'+ get_token_number).val())));
            });
        });
        $('#getContractDetails').click(function(){
            $('#addinCurrentPrices').show();
            $('#addinHistory').show();
            $('#afterFilter').show();
            var theVal = this.value;
            $.ajax({
                url: '{!!url("/getCurrentContractCustomerSpecialsKF")!!}',
                type: "POST",
                data: {
                    contractid:$('#custheadid').val()
                },
                success: function (data) {
                    var trHTML = '';
                    $('#tblCreateNewSpecial tbody').empty();
                    $.each(data, function (key, value) {
                        var contractFrom = $('#dateFrom').val();
                        var contractTo = $('#dateTo').val();
                        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
                        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
                            '<td contenteditable="false" class="col-sm-1"><i style="font-size: 0px">'+value.PastelCode+'"</i> <input name="theProductCode" id ="prodCode_'+tokenId+'"  value="'+value.PastelCode+'" class="theProductCode_ set_autocomplete inputs"></td>' +
                            '<td contenteditable="false"  class="col-md-3"><i style="font-size: 0px">'+value.PastelDescription+'"</i> <input name="prodDescription_" id ="prodDescription_'+tokenId+'"value="'+value.PastelDescription+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
                            '<td  contenteditable="false" class="col-md-1"><i style="font-size: 0px">'+value.Date+'"</i> <input type="text" name="dateFrom" id ="dateFrom'+tokenId+'" value= "'+value.Date+'"  title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
                            '<td contenteditable="false" class="col-md-1"><i style="font-size: 0px">'+value.DateTo+'"</i> <input type="text" name="dateTo"  id ="dateTo'+tokenId+'" value= "'+value.DateTo+'" class="dateTo resize-input-inside inputs"></td>' +
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+value.PriceLookedUp+'"</i> <input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'"value="'+parseFloat(value.PriceLookedUp).toFixed(2)+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs lst" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+value.avgQty+'"</i> <input type="text" name="avgQty_" id ="avgQty_'+tokenId+'"value="'+value.avgQty+'" onkeypress="return isFloatNumber(this,event)" class="avgQty_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+value.Cost+'"</i> <input type="text" name="cost_" id ="cost_'+tokenId+'"value="'+roundquick(value.Cost)+'" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+parseFloat( marginCalculator(value.Cost,value.PriceLookedUp).toFixed(2))+'"</i> <input type="text" name="gp_" id ="gp_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
                            '<td contenteditable="false"  class="col-md-1"><i style="font-size: 0px">'+value.PriceLookedUp+'"</i> <input type="text" name="less10perc_" id ="less10perc_'+tokenId+'"value="'+parseFloat(value.PriceLookedUp*0.9).toFixed(2)+'" onkeypress="return isFloatNumber(this,event)" class="less10perc_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL1+'"</i> <input type="text" name="PL1_" id ="PL1_'+tokenId+'"value="'+roundquick(value.PL1)+'" onkeypress="return isFloatNumber(this,event)" class="PL1_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL2+'"</i> <input type="text" name="PL2_" id ="PL2_'+tokenId+'"value="'+roundquick(value.PL2)+'" onkeypress="return isFloatNumber(this,event)" class="PL2_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL3+'"</i> <input type="text" name="PL3_" id ="PL3_'+tokenId+'"value="'+roundquick(value.PL3)+'" onkeypress="return isFloatNumber(this,event)" class="PL3_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL4+'"</i> <input type="text" name="PL4_" id ="PL4_'+tokenId+'"value="'+roundquick(value.PL4)+'" onkeypress="return isFloatNumber(this,event)" class="PL4_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL5+'"</i> <input type="text" name="PL5_" id ="PL5_'+tokenId+'"value="'+roundquick(value.PL5)+'" onkeypress="return isFloatNumber(this,event)" class="PL5_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PL6+'"</i> <input type="text" name="PL6_" id ="PL6_'+tokenId+'"value="'+roundquick(value.PL6)+'" onkeypress="return isFloatNumber(this,event)" class="PL6_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td contenteditable="false"  class="col-md-2"><i style="font-size: 0px">'+value.PriceLookedUp+'"</i> <input type="text" name="prodPriceB_" id ="prodPriceB_'+tokenId+'"value="'+parseFloat(value.PriceLookedUp).toFixed(2)+'" onkeypress="return isFloatNumber(this,event)" class="prodPriceB_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
                            '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
                        $('#tblCreateNewSpecial tbody')
                            .append( $row )
                            .trigger('addRows', [ $row, false
                            ]);
                        if(!$('.lst').is(":focus"))
                        {
                            $('#prodCode_' + tokenId).focus();

                            if ($('#checkboxDescription').is(':checked')) {
                                $('#prodDescription_' + tokenId).focus();
                            }
                        }
                        var resort  = true;
                        $('#tblCreateNewSpecial').trigger('update',[resort]);
                        $('#gp_'+ tokenId).val( parseFloat( marginCalculator(value.Cost,$('#prodPrice_'+tokenId).val()).toFixed(2)));
                        $('input').on('click keyup' ,function(){
                            // $('input').click(function(){
                            var ID = $(this).attr('id');
                            var jID = '#'+ID;
                            var x = ID.indexOf("_");
                            var get_token_number = ID.substring(x+1,ID.length);

                            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                                $(""+jID+"").mcautocomplete({
                                    source: finalDataProductDescription,
                                    columns:columnsD,
                                    autoFocus: true,
                                    minlength: 2,
                                    delay: 0,
                                    multiple: true,
                                    multipleSeparator: ",",
                                    select:function (e, ui) {
                                        console.log(ui.item);
                                        var n = ID.indexOf("_");
                                        var token_number = ID.substring(n + 1, ID.length);

                                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                                        {
                                            $('#prodQty_'+token_number).val('0');
                                            $('#prodPrice_'+token_number).val('0');
                                        }
                                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                                        $('#cost_' + token_number).val(ui.item.Cost);
                                        $('#prodPrice_' + token_number).val('');
                                        $('#avgQty_' + token_number).val(ui.item.avgQty);
                                        $('#PL1_' + token_number).val(ui.item.PriceList1);
                                        $('#PL2_' + token_number).val(ui.item.PriceList2);
                                        $('#PL3_' + token_number).val(ui.item.PriceList3);
                                        $('#PL4_' + token_number).val(ui.item.PriceList4);
                                        $('#PL5_' + token_number).val(ui.item.PriceList5);
                                        $('#PL6_' + token_number).val(ui.item.PriceList6);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        productPrice(token_number);


                                    }
                                });

                            }

                            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                                    ,
                                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                                $("" + jID + "").mcautocomplete({
                                    source: finalDataProduct,
                                    columns:columnsC,
                                    minlength: 1,
                                    autoFocus: true,
                                    delay: 0,
                                    select:function (e, ui) {
                                        console.log(ui.item);
                                        var n = ID.indexOf("_");
                                        var token_number = ID.substring(n + 1, ID.length);
                                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                                        {
                                            $('#prodQty_'+token_number).val('0');
                                            $('#prodPrice_'+token_number).val('0');
                                        }
                                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                                        $('#prodPrice_' + token_number).val('');
                                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                                        $('#avgQty_' + token_number).val(ui.item.avgQty);
                                        $('#cost_' + token_number).val(ui.item.Cost);
                                        $('#PL1_' + token_number).val(ui.item.PriceList1);
                                        $('#PL2_' + token_number).val(ui.item.PriceList2);
                                        $('#PL3_' + token_number).val(ui.item.PriceList3);
                                        $('#PL4_' + token_number).val(ui.item.PriceList4);
                                        $('#PL5_' + token_number).val(ui.item.PriceList5);
                                        $('#PL6_' + token_number).val(ui.item.PriceList6);
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        productPrice(token_number);

                                    }

                                });
                            }
                            //calculator();

                        });

                        $(".dateTo,.dateFrom").datepicker({
                            changeMonth: true,//this option for allowing user to select month
                            changeYear: true, //this option for allowing user to select from year range
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#tblCreateNewSpecial').on('click', 'button', function (e) {
                            var $this = $(this);
                            $this.closest('tr').remove();
                        });
                    });

                }
            });

        });

        $('#doneCreating').click(function()
        {
            var productsLinesOnPicking = new Array();
            $('#tblCreateNewSpecial > tbody  > tr').each(function() {
                
                    productsLinesOnPicking.push({
                        'productCode': escapeHtml($(this).closest('tr').find('.theProductCode_').val()),
                        'price': $(this).closest('tr').find('.prodPrice_').val(),
                        'dateFrom':  dateReturn($(this).closest('tr').find('.dateFrom').val()) ,
                        'dateTo': dateReturn( $(this).closest('tr').find('.dateTo').val()),
                        'cost_': $(this).closest('tr').find('.cost_').val(),
                        'gp_': $(this).closest('tr').find('.gp_').val(),
                        'customerid': $('#customerId').val(),
                        'contractid': $('#custheadid').val()
                    });
                    

             
            });
            $.ajax({
                url: '{!!url("/XmlCreateCustomerSpecialsKFValid")!!}', // createCustomerSpecials
                type: "POST",
                data: {
                    customerCode: $('#inputCustAcc').val(),
                    customerId: $('#customerId').val(),
                    contractDateFrom: $('#dateFrom').val(),
                    contractDateTo: $('#dateTo').val(),
                    contractid: $('#custheadid').val(),
                    orderDetails: productsLinesOnPicking
                },
                success: function (data) {
                    console.log("data tag " + data);
                    console.log("data result tag " +data.result);
                    var duplicateresult = data.result;
                    if (data.result.length ==0) // so if there is nothing  do the following
                    {
                        $.ajax({
                            url: '{!!url("/XmlCreateCustomerSpecialsKF")!!}', // createCustomerSpecials
                            type: "POST",
                            data: {
                                customerCode: $('#inputCustAcc').val(),
                                customerId: $('#customerId').val(),
                                contractDateFrom: $('#dateFrom').val(),
                                contractDateTo: $('#dateTo').val(),
                                contractid: $('#custheadid').val(),
                                orderDetails: productsLinesOnPicking
                            },success: function (data) {
                                var dialog = $('<p>Special Created!</p>').dialog({
                                    height: 200, width: 700, modal: true, containment: false,
                                    buttons: {
                                        "OKAY": function () {
                                            location.reload(true);
                                            dialog.dialog('close');
                                        }
                                    }
                                });
                            }
                        });
                    }else{// so if there is nothing  do the following

                        var trHTML = "";

                        $('#gridduplicatespecials').empty();
                        $('#duplicatespecials').show(); //table
                        var dialog = $("#duplicatespecials").dialog({
                            height: 800, modal: true, closeOnEscape: true,
                            width: 800, buttons: {
                                "NO": function () {
                                    dialog.dialog('close');
                                },
                                "YES": function () {
                                    $.ajax({
                                        url: '{!!url("/XmlCreateCustomerSpecialsKF")!!}', // createCustomerSpecials
                                        type: "POST",
                                        data: {
                                            customerCode: $('#inputCustAcc').val(),
                                            customerId: $('#customerId').val(),
                                            contractDateFrom: $('#dateFrom').val(),
                                            contractDateTo: $('#dateTo').val(),
                                            contractid: $('#custheadid').val(),
                                            orderDetails: productsLinesOnPicking
                                        },success: function (data) {
                                            var dialog = $('<p>Special Created!</p>').dialog({
                                                height: 200, width: 700, modal: true, containment: false,
                                                buttons: {
                                                    "OKAY": function () {
                                                        location.reload();
                                                        //dialog.dialog('close');
                                                    }
                                                }
                                            });
                                        }
                                    });

                                }
                            },containment: false,
                        }).dialogExtend({
                            "closable": true, // enable/disable close button
                            "maximizable": false, // enable/disable maximize button
                            "minimizable": true, // enable/disable minimize button
                            "collapsable": true, // enable/disable collapse button
                            "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                            "titlebar": false, // false, 'none', 'transparent'
                            "minimizeLocation": "right", // sets alignment of minimized dialogues
                            "icons": { // jQuery UI icon class
                                "close": "ui-icon-circle-close",
                                "maximize": "ui-icon-circle-plus",
                                "minimize": "ui-icon-circle-minus",
                                "collapse": "ui-icon-triangle-1-s",
                                "restore": "ui-icon-bullet"
                            },
                            "load": function (evt, dlg) {
                            }, // event
                            "beforeCollapse": function (evt, dlg) {
                            }, // event
                            "beforeMaximize": function (evt, dlg) {
                            }, // event
                            "beforeMinimize": function (evt, dlg) {
                            }, // event
                            "beforeRestore": function (evt, dlg) {
                            }, // event
                            "collapse": function (evt, dlg) {
                            }, // event
                            "maximize": function (evt, dlg) {
                            }, // event
                            "minimize": function (evt, dlg) {
                            }, // event
                            "restore": function (evt, dlg) {
                            } // event
                        });
                        $.each(duplicateresult, function (key, value) {
                            //p.PastelCode,p.PastelDescription,cs.SpecialHeaderId as [Contract] ,ts.dateFrom, ts.dateTo, CustomerPastelCode, p.PastelCode, p.PastelDescription AS Pdesc, cs.Price
                            trHTML += '<tr style="font-size: 13px !important;color: black;background: lightgrey;font-weight: normal" >' +
                                '<td style="">' + value.PastelCode + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.PastelDescription + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.Price + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.dateFrom + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.dateTo + '</td>' +
                                '<td style="font-size: 13px !important;">' + value.Contract + '</td>' +
                                '</tr>';


                        });
                        $('#gridduplicatespecials').append(trHTML);

                    }



                }
            });
        });

        $(document).on('click', '.PL1_', function(e) {
            var costing = $(this).closest('tr').find('.cost_').val();
            $(this).closest('tr').find('.prodPrice_').val($(this).val());
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,$(this).val())).toFixed(2));
        });
        $(document).on('click', '.PL2_', function(e) {

            var costing = $(this).closest('tr').find('.cost_').val();
            $(this).closest('tr').find('.prodPrice_').val($(this).val());
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,$(this).val())).toFixed(2));
        });
        $(document).on('click', '.PL3_', function(e) {

            var costing = $(this).closest('tr').find('.cost_').val();
            $(this).closest('tr').find('.prodPrice_').val($(this).val());
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,$(this).val())).toFixed(2));
        });
        $(document).on('click', '.PL4_', function(e) {
            var costing = $(this).closest('tr').find('.cost_').val();
            $(this).closest('tr').find('.prodPrice_').val($(this).val());
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,$(this).val())).toFixed(2));
        });
        $(document).on('click', '.PL5_', function(e) {
            var costing = $(this).closest('tr').find('.cost_').val();
            $(this).closest('tr').find('.prodPrice_').val($(this).val());
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,$(this).val())).toFixed(2));
        });
        $(document).on('click', '.PL6_', function(e) {
            var costing = $(this).closest('tr').find('.cost_').val();
            $(this).closest('tr').find('.prodPrice_').val($(this).val());
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,$(this).val())).toFixed(2));
        });

        $(document).on('click', '.less10perc_', function(e) {
            var costing = $(this).closest('tr').find('.cost_').val();
            $(this).closest('tr').find('.prodPrice_').val($(this).val());
            $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,$(this).val())).toFixed(2));
        });


    });
    function marginCalculator(cost,onCellVal)
    {
        return (1-(cost/onCellVal))*100;
    }
    function generateALine2()
    {
        var contractFrom = $('#dateFrom').val();
        var contractTo = $('#dateTo').val();
        var tokenId=Math.floor(Math.pow(10, 9-1) + Math.random() * 9 * Math.pow(10, 9-1));
        var $row = $('<tr id="new_row_ajax'+tokenId+'" class="fast_remove" style="font-weight: 600;font-size: 11px;">' +
            '<td contenteditable="false" class="col-sm-1"><input name="theProductCode" id ="prodCode_'+tokenId+'" class="theProductCode_ set_autocomplete inputs"></td>' +
            '<td contenteditable="false" class="col-md-3"><input name="prodDescription_" id ="prodDescription_'+tokenId+'" class="prodDescription_ set_autocomplete inputs" tabindex="-1"></td>' +
            '<td  contenteditable="false" class="col-md-1"><input type="text" name="dateFrom" id ="dateFrom'+tokenId+'" value= "'+contractFrom+'"  title="in stock" class="dateFrom resize-input-inside inputs"></td>' +
            '<td contenteditable="false" class="col-md-1"><input type="text" name="dateTo"  id ="dateTo'+tokenId+'" value= "'+contractTo+'" class="dateTo resize-input-inside inputs"></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPrice_" id ="prodPrice_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPrice_ resize-input-inside inputs lst" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="avgQty_" id ="avgQty_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="avgQty_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="cost_" id ="cost_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="cost_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="gp_" id ="gp_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="gp_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>' +
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="less10perc_" id ="less10perc_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="less10perc_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="PL1_" id ="PL1_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="PL1_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="PL2_" id ="PL2_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="PL2_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="PL3_" id ="PL3_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="PL3_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="PL4_" id ="PL4_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="PL4_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="PL5_" id ="PL5_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="PL5_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="PL6_" id ="PL6_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="PL6_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td contenteditable="false"  class="col-md-1"><input type="text" name="prodPriceB_" id ="prodPriceB_'+tokenId+'" onkeypress="return isFloatNumber(this,event)" class="prodPriceB_ resize-input-inside inputs" style="font-weight: 800;width: 100%;" ></td>'+
            '<td><button type="button" id="cancelThis" class="btn-danger btn-xs cancel" style="height: 16px;padding: 0px 5px;font-size: 9px;">Cancel</button></td></tr>');
        $('#tblCreateNewSpecial tbody')
            .append( $row )
            .trigger('addRows', [ $row, false ]);
        if(!$('.lst').is(":focus"))
        {
            $('#prodCode_' + tokenId).focus();

            if ($('#checkboxDescription').is(':checked')) {
                $('#prodDescription_' + tokenId).focus();
            }
        }
        $('input').on('click keyup' ,function(){
            // $('input').click(function(){
            var ID = $(this).attr('id');
            var jID = '#'+ID;
            var x = ID.indexOf("_");
            var get_token_number = ID.substring(x+1,ID.length);

            if ($(this).hasClass("prodDescription_") && $(this).hasClass("set_autocomplete")) {
                var columnsD = [{name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'},
                    {name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'}
                    ,{name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $(""+jID+"").mcautocomplete({
                    source: finalDataProductDescription,
                    columns:columnsD,
                    autoFocus: true,
                    minlength: 2,
                    delay: 0,
                    multiple: true,
                    multipleSeparator: ",",
                    select:function (e, ui) {
                        console.log(ui.item);
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);

                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        $('#avgQty_' + token_number).val(ui.item.avgQty);
                        $('#PL1_' + token_number).val(ui.item.PriceList1);
                        $('#PL2_' + token_number).val(ui.item.PriceList2);
                        $('#PL3_' + token_number).val(ui.item.PriceList3);
                        $('#PL4_' + token_number).val(ui.item.PriceList4);
                        $('#PL5_' + token_number).val(ui.item.PriceList5);
                        $('#PL6_' + token_number).val(ui.item.PriceList6);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        productPrice(token_number);
                        $('#gp_' + token_number).val(marginCalculator(ui.item.Cost,$('#prodPrice_'+ token_number).val()));
                        var placeholderclick = '#PL1_'+ token_number;

                    }
                });

            }

            if ($(this).hasClass("theProductCode_") && $(this).hasClass("set_autocomplete")) {
                var columnsC = [{name: 'PastelCode', minWidth: '90px',valueField: 'PastelCode'},
                    {name: 'PastelDescription', minWidth:'230px',valueField: 'PastelDescription'}
                    ,
                    {name: 'Available', minWidth:'20px',valueField: 'Available'}];
                $("" + jID + "").mcautocomplete({
                    source: finalDataProduct,
                    columns:columnsC,
                    minlength: 1,
                    autoFocus: true,
                    delay: 0,
                    select:function (e, ui) {
                        console.log(ui.item);
                        var n = ID.indexOf("_");
                        var token_number = ID.substring(n + 1, ID.length);
                        if(ui.item.PastelCode == "MISC2" || ui.item.PastelDescription == "MISC - NOTE" || ui.item.PastelDescription =="MISC" || ui.item.PastelCode =="misc")
                        {
                            $('#prodQty_'+token_number).val('0');
                            $('#prodPrice_'+token_number).val('0');
                        }
                        $('#prodDescription_' + token_number).val(ui.item.PastelDescription);
                        $('#prodCode_' + token_number).val(ui.item.PastelCode);
                        $('#cost_' + token_number).val(ui.item.Cost);
                        avgQty(token_number);
                        $('#PL1_' + token_number).val(ui.item.PriceList1);
                        $('#PL2_' + token_number).val(ui.item.PriceList2);
                        $('#PL3_' + token_number).val(ui.item.PriceList3);
                        $('#PL4_' + token_number).val(ui.item.PriceList4);
                        $('#PL5_' + token_number).val(ui.item.PriceList5);
                        $('#PL6_' + token_number).val(ui.item.PriceList6);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        productPrice(token_number);
                        $('#gp_' + token_number).val(marginCalculator(ui.item.Cost,$('#prodPrice_'+ token_number).val()));

                    }

                });
            }
            //calculator();

        });

        $(".dateTo,.dateFrom").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true, //this option for allowing user to select from year range
            dateFormat: 'dd-mm-yy'
        });
        $('#tblCreateNewSpecial').on('click', 'button', function (e) {
            var $this = $(this);
            $this.closest('tr').remove();
        });

    }


    function roundquick(val)
    {
        return parseFloat(val).toFixed(2);
    }
    function productPrice(token_number)
    {
        $.ajax({
            url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
            type: "POST",
            data: {
                customerID: $('#inputCustAcc').val(),
                deliveryDate:today,
                productCode: $('#prodCode_' + token_number).val(),
                warehouseid:1
            },
            success: function (data) {
                $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                $('#prodPriceB_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                $('#less10perc_' + token_number).val(parseFloat(data[0].Price*0.9).toFixed(2));
                $('#gp_'+token_number).val(roundquick(marginCalculator(data[0].Cost,data[0].Price)));
            }
        });
    }
    function avgQty(token_number)
    {
        $.ajax({
            url: '{!!url("/getCustomerAvgQty")!!}',
            type: "POST",
            data: {
                customerID: $('#customerId').val(),
                deliveryDate:today,
                productCode: $('#prodCode_' + token_number).val(),
                warehouseid:1
            },
            success: function (data) {
                $('#avgQty_' + token_number).val(data[0].Qty);
            }
        });
    }
    function productPriceForHistories(token_number)
    {
        $.ajax({
            url: '{!!url("/getCutomerPriceOnOrderForm")!!}',
            type: "POST",
            data: {
                customerID: $('#inputCustAcc').val(),
                deliveryDate:today,
                productCode: $('#prodCode_' + token_number).val(),
                warehouseid:1
            },
            success: function (data) {
                $('#prodPrice_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                $('#prodPriceB_' + token_number).val(parseFloat(data[0].Price).toFixed(2));
                $('#less10perc_' + token_number).val(parseFloat(data[0].Price*0.9).toFixed(2));
            }
        });
    }
    $(document).on('keydown', '#tblCreateNewSpecial', function(e) {
        var $table = $(this);

        var $active = $('input:focus,select:focus,li:focus',$table);
        var $next = null;
        var focusableQuery = 'input:visible,select:visible,textarea:visible,li:visible';
        var position = parseInt( $active.closest('td').index()) + 1;
        var $celltheProductCode_ = $active.closest('td').find(".theProductCode_").val();

        switch(e.keyCode){
            case 37: // <Left>
                $next = $active.parent('td').prev().find(focusableQuery);
                break;
            case 33: // <Up>
                c
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .prev()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }

                break;
            case 38: // <Up>
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .prev()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }
                break;
            case 34: // <Right>
                $next = $active.closest('td').next().find(focusableQuery);
                break;
            case 40: // <Down>
                if ($celltheProductCode_.length < 1) {
                    $next = $active
                        .closest('tr')
                        .next()
                        .find('td:nth-child(' + position + ')')
                        .find(focusableQuery)
                    ;
                }
                console.debug('$celltheProductCode_******** DOWN'+$celltheProductCode_);
                break;

        }
        if($next && $next.length)
        {
            $next.focus();
        }
    });
    $(document).on('keydown', '.inputs', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        var testLst = $(this).closest('tr');
        if ((code == 13 || code == 39)) {
            var index = $('.inputs').index(this) + 1;
            $('.inputs').eq(index).focus();
        }
        if (code == 37) {
            var index = $('.inputs').index(this) - 1;
            $('.inputs').eq(index).focus();
        }
        var closesttr =  $(this).closest('tr');
        var prodClosest = closesttr.find(".theProductCode_").val();
        var prodDescClosest = closesttr.find(".prodDescription_").val();
        var prodPriceClosest = closesttr.find(".prodPrice_").val();
        if ( (code == 34 || code == 13 || code == 39 ) && $.trim(prodClosest.length) > 0 && prodDescClosest.length > 0 &&  prodPriceClosest.length > 0) {
            generateALine2();

        }
    });
    $(document).on('keyup', '.lst', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13 || code == 9) {
            var index = $('.inputs').index(this);

            $('.lst').eq(index).focus();
            generateALine2();

        }
    });
    $(document).on('keyup', '.prodPrice_', function(e) {
        /*  var key = (e.keyCode ? e.keyCode : e.which);
         var $isAuth = $(this).closest("tr").find(".title").attr("id");
         var $priceToken = $(this).closest("tr").find(".prodPrice_").attr("id");*/

        var costing = $(this).closest("tr").find(".cost_").val();
        var prodPriceVal =  $(this).closest("tr").find(".prodPrice_").val();
        $(this).closest("tr").find(".gp_").val( parseFloat( marginCalculator(costing,prodPriceVal)).toFixed(2));


    });
    function dateReturn(dates)
    {
        //27-02-2019
        var datearray = dates.split("-");
        if (datearray[0].length > 2){
            var newdateDelivDate = dates;
        }
        else {
            var newdateDelivDate = datearray[2] + '-' + datearray[1] + '-' + datearray[0];
        }


        return newdateDelivDate
    }
    function isFloatNumber(item,evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode==46)
        {
            var regex = new RegExp(/\./g)
            var count = $(item).val().match(regex).length;
            if (count > 1)
            {
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function showDialogWithoutClose(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: true,
            width: width,containment: false}).dialogExtend({
            "closable" : false, // enable/disable close button
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
        $('#authorisations').keydown(function(event) {
            if (event.keyCode == 27) {
                return false;
            }
        });


    }
    function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }


</script>
