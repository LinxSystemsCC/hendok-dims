@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;display:none;">

        <div class="row">
            <button id="startPlanning" class="btn-success btn-md center-block" style="margin-top: 20px;width: 103px;padding: 28px;">START</button>
            <button id="ordersNotCorrect" class="btn-success btn-md center-block" style="margin-top: 20px;width: 103px;">ROUTES DIFFERENCES</button>
            <button id="visualise" class="btn-success btn-md center-block" style="display:none;margin-top: 20px;width: 103px;padding: 28px;">Search</button>
            <button id="printTruckSheet" class="btn-success btn-md center-block" style="display:none;margin-top: 20px;width: 103px;padding: 28px;">Print</button>
        </div>
    </div>

    <div id="routePlanningPopUp" title="Route Planning" style="font-weight: 900;color: black;font-family: 'Helvetica Neue', arial, sans-serif">
        <div class="col-lg-12">
            <div class="col-lg-12" >
                <div class="col-lg-12">
                    <form>
                        <fieldset class="well">
                            <legend class="well-legend">Route Planning</legend>
                            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="deliveryDatesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                                <input name="deliveryDatesonPlanning" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning" value="{{$selectedDelivDate}}" >
                            </div>
                            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="deliveryDatesonPlanning2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
                                <input name="deliveryDatesonPlanning2" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning2" value="{{$selectedDelivDate}}" >
                            </div>
                            <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="orderTypesTabletLoadingonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                                <select name="orderTypesTabletLoadingonPlanning" class="form-control input-sm col-xs-1" id="orderTypesTabletLoadingonPlanning" style="height:30px;font-size: 10px;">

                                    @foreach($orderTypeSelected  as $values)
                                        <option value="{{$values->OrderTypeId}}">{{$values->OrderType}}</option>
                                    @endforeach
                                    <option value="-99">All</option>

                                </select>
                            </div>
                            <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="rouTabletLoadingtesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                                <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1" name="multicheckbox[]" multiple="multiple" >

                                    @foreach($routes as $values)
                                        <option value="{{$values->Routeid}}">{{$values->Route}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="statusRoutePlanner"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Status @if (Auth::guest()) [<i style="color:red;">LOGGED OUT</i>] @endif</label>
                                <select  id="statusRoutePlanner" class="form-control input-sm col-xs-1" >

                                    @if ($status == 1)
                                        <option value="1">Invoiced</option>
                                    @else
                                        <option value="0">Not Invoiced</option>
                                    @endif
                                    @if ($status == 3)
                                        <option value="3">All</option>
                                    @endif
                                    <option value="3">All</option>
                                    <option value="0">Not Invoiced</option>
                                    <option value="1">Invoiced</option>
                                </select>
                            </div>

                            <div class="form-group  col-md-1"  style="margin-top: 15px; margin-left: -14px;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <button type="button" id="tabletLoadingGoonPlanning" class="btn-sm btn-success">Orders </button>
                            </div>
                            <div class="form-group  col-md-1"  style="display:none;margin-top: 15px; margin-left: -14px;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <button type="button" id="tabletLoadingGoonProducts" class="btn-sm btn-success">Products </button>
                            </div>


                        </fieldset>
                    </form>

                </div>

            </div>

        </div>
        <div class="col-lg-12"  style="font-weight: 900;color: black;font-family: 'Helvetica Neue', arial, sans-serif">
            Planning Ref:<input id="referenceno">
            <div class="row tabbable">
                <div class="col-xs-12" id="theunsequencedInfo" >

                    <div class="flex-container">

                        <div class="flex-child magenta" style="overflow-y: scroll;">
                            <h4 style="text-align: center">Planned Orders</h4>
                            <table class="table table-bordered" >
                                <thead>
                                <tr>

                                    <th>Customer Name</th>
                                    <th>OrderId</th>

                                </tr>
                                </thead>
                                <tbody id="priority">

                                </tbody>
                            </table>

                        </div>


                        <div class="flex-child " style="overflow-y: scroll;">
                            <h4 style="text-align: center" >MAP</h4>

                        </div>



                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="flex-container2">
                        <div class="flex-child2 " style="text-align: center">

                        </div>

                        <div class="flex-child2 " style="text-align: center">

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-12" style="background: greenyellow">


        </div>
    </div>
    <div id="popupmoveThis" title="Order Change">
        <h5>Please move an order by chosing below</h5>
        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="truckNameSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
                <select name="eRouteName" class="form-control input-sm col-sm-1"  id="eRouteName" style="font-size: 14px;" >
                    @foreach($routes as $value)
                        <option value="{{$value->Routeid}}">{{$value->Route}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="deliveryTypeRun"  style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">Delivery Type(Run)</label>
                <select name="deliveryTypeRun" class="form-control input-sm col-sm-1" id="deliveryTypeRun" style="font-size: 14px;">
                    @foreach($orderTypes as $value)
                        <option value="{{$value->OrderTypeId}}">{{$value->OrderType}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="delDateChange"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                <input name="delDateChange" class="form-control input-sm col-xs-1" id="delDateChange" >
            </div>

        </form>
        <div class="form-group col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">
            <button class="btn-success btn-xs" id="submitChanges">submit</button>
        </div>
    </div>
    <div style="display:none;">
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateCreateForControlSheetSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Date Created</label>
            <input id="dateCreateForControlSheetSheetMaster" class="form-control input-sm col-xs-1" name="dateCreateForControlSheetSheetMaster" style="height:21px;font-size: 8px;" >
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="dateCreateForControlSheetSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
            <input id="delvDateForControlSheetSheetMaster" class="form-control input-sm col-xs-1" name="dateCreateForControlSheetSheetMaster" style="height:21px;font-size: 8px;" >
        </div>
        <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="routeSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>
            <select id="routeSheetMaster" class="form-control input-sm col-xs-1" name="routeSheetMaster" style="height:21px;font-size: 8px;" ></select>
        </div><button id="doneWithTruckSheetMasterData" class="btn-success btn-md center-block">Submit</button>
    </div>

    </div>
    <div id="straightForwardPrintThtTruckControlId" class="col-lg-12" title="Print Truck Control Sheet">
        <div class="col-lg-12">

            <fieldset class="well">
                <legend class="well-legend">Filters</legend>
                <div class="form-group col-md-4"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="truckControlIDsOnPrintButton"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck Id Search</label>
                    <input type="text" name="truckControlIDsOnPrintButton" class="form-control input-sm col-md-3" id="truckControlIDsOnPrintButton" >
                    <input type="hidden" name="truckControlKeeper" id="truckControlKeeper">
                </div>
                <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="delivDateFilter" id="lrecentTruckIDOnPrintButton"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Truck Control IDs</label>
                    <select name="recentTruckIDOnPrintButton" class="form-control input-sm col-md-3"  id="recentTruckIDOnPrintButton"  ></select>
                </div>
            </fieldset>
            <p id="truckCotrolMessageAfterPrint"></p>

        </div>
    </div>
    <div id="trucSheetViewPopUp" title="Truck Control Sheet">
        <button id="printTruckSheet" class="btn-sm btn-success">Print TruckSheet</button>
    </div>
    <div id="confirmMove">Finished moving the Orders
        <button class="btn-md" id="okayclose">Okay</button>
    </div>
    <div id="creditOnHold">Account is currently on Hold ,Report to Accounts Department Please .
        <button class="btn-md" id="reportOnHold">Okay</button>
    </div>
    <div  id="customerPlanned" title="Customers Mapped To The Planned Product.">
        <h4 style="text-align: center" >Product <input type="text" class="form-control input-sm col-md-3" id="prod" readonly></h4>
        <input type="hidden" id="productIds">

        <table id="tblplannedline" class="table table-bordered">
            <thead>
            <tr>
                <th>Customer Name</th>
                <th>Quantity</th>

            </tr>
            </thead>
            <tbody id="plannedline">

            </tbody>
        </table>
        <button id="submit" class="btn-success btn-lg btn" >Save</button>
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

    var jArrayOrderTypes = JSON.stringify({!! json_encode($orderTypes) !!});
    var jArraydelivDates = JSON.stringify({!! json_encode($delivDates) !!});
    var jArraydelivroutes = JSON.stringify({!! json_encode($routes) !!});
    var jArraydDrivers = JSON.stringify({!! json_encode($drivers) !!});
    var jArraydtrucks = JSON.stringify({!! json_encode($trucks) !!});

    var computerName = '<?php echo gethostname() ?>';
    var loggedIn = '{{ auth()->check() ? 'true' : 'false' }}';
    $(document).ready(function() {
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

        var Odate = new Date();
        var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
        $('#lplan').click(function(){
            window.open('{!!url("/ligisticsplan")!!}/'+newODate, 'SAMPLEV', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });

        $("#unsequenced").tablesorter();


        var toAppendOrderTypes = '';
        $.each(JSON.parse(jArrayOrderTypes),function(i,o){
            toAppendOrderTypes += '<option value="'+o.OrderTypeId+'">'+o.OrderType+'</option>';
        });
        $('#orderTypesTabletLoadingonPlanning').append(toAppendOrderTypes);
        // $('#deliveryTypeRun').append(toAppendOrderTypes);

        var toAppenddelvdates = '';
        $.each(JSON.parse(jArraydelivDates),function(i,o){
            toAppenddelvdates += '<option value="'+o.DeliveryDate+'">'+o.DeliveryDate+'</option>';
        });
        // $('#deliveryDatesonPlanning').append(toAppenddelvdates);

        var toAppendRecentTruckIdFilter = '<option value=""></option>';


        $('#recentTruckIDOnPrintButton').append(toAppendRecentTruckIdFilter);
        $('#rouTabletLoadingtesonPlanning').multiselect({
            columns: 1,
            placeholder: 'Select Route(s)',
            selectAll: true
        });

        //DRIVERS
        var toAppendDrivers = '';
        $.each(JSON.parse(jArraydDrivers),function(i,o){
            toAppendDrivers += '<option value="'+o.DriverId+'">'+o.DriverName+'</option>';
        });
        $('#driver').append(toAppendDrivers);
        $('#driverSheetMaster').append(toAppendDrivers);
        $('#assistant').append(toAppendDrivers);
        $('#assistantSheetMaster').append(toAppendDrivers);

        var toAppendroute = '';
        $.each(JSON.parse(jArraydelivroutes),function(i,o){
            toAppendroute += '<option value="'+o.Routeid+'">'+o.Route+'</option>';
        });
        // $('#rouTabletLoadingtesonPlanning').append(toAppendroute);

        //$('#eRouteName').append(toAppendroute);
        // $('#routeSheetMaster').append(toAppendroute);
        //TRUCKS
        var toAppendTrucks = '';
        $.each(JSON.parse(jArraydtrucks),function(i,o){
            toAppendTrucks += '<option value="'+o.TruckId+'">'+o.TruckName+'</option>';
        });
        $('#truckName').append(toAppendTrucks);
        $('#truckNameSheetMaster').append(toAppendTrucks);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




        $tabs = $("#unsequenced");
        $( "tbody.connectedSortable" )
            .sortable({
                containerSelector: 'table',
                connectWith: ".connectedSortable",
                items: "tr",
                appendTo: $tabs,
                helper:"clone",
                zIndex: 99999999,
                start: function(e, ui ){ ui.placeholder.height(ui.helper.outerHeight());$tabs.addClass("dragging") },
                stop: function(){ $tabs.removeClass("dragging") }
            })
            .disableSelection()
        ;

        $('#unsequenced tbody').on('dblclick', 'tr', function () {
            var orderId = $(this).closest('tr').find('td:eq(5)').text();
            var orderType = $(this).closest('tr').find('td:eq(6)').text();
            var orderTypeID = $(this).closest('tr').find('td:eq(7)').text();
            var routeId = $(this).closest('tr').find('td:eq(8)').text();
            var routeName = $(this).closest('tr').find('td:eq(2)').text();
            var invoiceNo = $(this).closest('tr').find('td:eq(4)').text();

            if(($.trim(invoiceNo)).length < 5)
            {
                //showDialog('#popupmoveThis','60%',220);
                $('#submitChanges').click(function(){
                    $.ajax({
                        url: '{!!url("/moveTheOrder")!!}',
                        type: "POST",
                        data: {orderTypeId:$('#deliveryTypeRun').val(),routeId:$('#eRouteName').val(),orderId:orderId},
                        success: function (data) {

                            //$('#tabletLoadingGoonPlanning').click();
                            showDialog('#confirmMove','60%',220);//
                            $('#okayclose').click(function(){
                                $("#popupmoveThis").dialog('close');
                                $("#confirmMove").dialog('close');
                                window.location = '{!!url("/routePlannerExtParam")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/1085/'+$('#statusRoutePlanner').val();

                                //
                                //$('#tabletLoadingGoonPlanning').click();
                                // $('#unsequenced').scrollTop();
                            });

                        }
                    });
                });
            }
            else
            {
                alert("SORRY ,THIS IS ALREADY INVOICED YOU CAN NOT MOVE IT");
            }

            //popupmoveThis
        });
        $('#ordersNotCorrect').click(function(){

            window.open ('{!!url("/ordersNotONDefaultRoutes")!!}', "ordersNotOnDefaultRoute",'left=20,top=20,width=1250,height=1250,toolbar=1,resizable=0');

        });
        $('#printTruckSheet').click(function(){

            $('#straightForwardPrintThtTruckControlId').show();
            showDialog('#straightForwardPrintThtTruckControlId','60%',620);
        });
        $('#suggestions').click(function(){

            var orderType =$('#orderTypesTabletLoadingonPlanning').val();
            var routeId =$('#rouTabletLoadingtesonPlanning').val();
            if(orderType !='-99' && routeId !='-99'){
                window.open('{!!url("/routePlannerSuggestions")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val()+'/'+$('#statusRoutePlanner').val());
            }
        });
        $('#serchInvBtn').click(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Order Header

        });
        getMultiRoutSelected();

        $('#tabletLoadingGoonPlanning').click(function(){

            $('#afterFiltering').hide();
            $('#doneSorting').show();
            $('#updateSorting').hide();
            $('#messageNB').show();
            $('#instantPrint').hide();


            //console.debug($('#rouTabletLoadingtesonPlanning').val());
            getMultiRoutSelected();

            //routesToSequence();
        });
        $('#notifypickers').click(function(){

            $.ajax({
                url: '{!!url("/notifypickers")!!}',
                type: "POST",
                data: {
                    routeId: $('#rouTabletLoadingtesonPlanning').val(),
                    deliveryDate: $('#deliveryDatesonPlanning').val(),
                    OrderType: $('#orderTypesTabletLoadingonPlanning').val(),
                    dateTo: $('#deliveryDatesonPlanning2').val()

                },
                success: function (data) {

                    var dialog = $('<p><strong style="color:black"> <i>You Have Nofitied the Pickers to Pick </i>'+data+'</strong></p>').dialog({
                        height: 200, width: 900, modal: true, containment: false,
                        buttons: {
                            "Okay": function () {
                                dialog.dialog('close');
                            },

                        }
                    });
                }
            });

        });
        $('#tabletLoadingGoonProducts').click(function(){
            if (($('#deliveryDatesonPlanning').val()).length > 6)
            {
                window.open('{!!url("/listallProductsRoutePlanner")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val(), "products", "width=760, height=500, scrollbars=yes")

            }
            else {
                alert("Please select Date")
            }

        });


        $('#updateSorting').click(function(){
            var UnsortedOrderIds = new Array();
            var updateSort = new Array();
            var stringyFy = '';
            $('#unsequenced > tbody ').each(function() {
                var data = $(this);
                var index =  $(this).closest('tr').index();
                UnsortedOrderIds.push({'index':index,'orderId': $(data).find('td:eq(4)').text(),'seq':$(data).find('td:eq(9)').text()});

            });
            $('#sequenced > tbody  > tr:not(:first)').each(function() {
                var dataSeq = $(this);
                var index =  $(this).closest('tr').index();
                updateSort.push({'index':index,'orderId': $(dataSeq).find('td:eq(4)').text(),'seq':$(dataSeq).find('td:eq(6)').text()});

            });
            $.ajax({
                url: '{!!url("/stopsUnmapped")!!}',
                type: "POST",
                data: {ordersToStop:UnsortedOrderIds,updateSort:updateSort,truckControlKeeper:$('#truckControlKeeper').val()},
                success: function (data) {
                    var dialog = $('<p><strong style="color:red">'+data.updateSort+'</strong>Finished Updating ,You can <button id="printThisTruckControl" class="btn-success btn-xs" value="'+data.truckId+'">Print</button> here.</p>').dialog({height:200,width:700,
                        buttons: {
                            "Close": function() { dialog.dialog('close')  }
                        }
                    });
                    $('#printThisTruckControl').click(function () {

                        printTruckSheetOrders('{!!url("/printTruckControlIDOrders")!!}',$('#printThisTruckControl').val());

                        // location.reload(true);
                    });
                }
            });

        });
        $("#deliveryDatesonPlanning,#deliveryDatesonPlanning2,#delDateChange,#dispatchdate").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: 'yy-mm-dd' });
        $('#doneSorting').click(function(){
            var sortedOrderIds = new Array();
            var stringyFy = '';
            $('#unsequenced > tbody > tr').each(function() {
                var data = $(this);
                var index =  $(this).closest('tr').index();
                sortedOrderIds.push({'index':index,'orderId': $(data).find('td:eq(5)').text()});//
            });
            console.debug(sortedOrderIds);
            $.ajax({
                url: '{!!url("/sequencingTheStops")!!}',
                type: "POST",
                data: {ordersToStop:sortedOrderIds},
                success: function (data) {
                    var dialog = $('<p><strong style="color:red">'+data.count+'</strong> Stops being Sequenced' +' </p>').dialog({height:200,width:700,
                        buttons: {
                            "Okay": function() { dialog.dialog('close');location.reload(true);  }
                        }
                    });

                }
            });
            // });
            //console.debug(sortedOrderIds);

        });
        $('#printPriview').click(function(){
            window.location = '{!!url("/routePlannerPrintPreview")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#deliveryDatesonPlanning2').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val()+'/'+$('#statusRoutePlanner').val();
        });
        $('#unsequenced').on('click', 'button', function (e) {
            var $this = $(this);
            var row_index = $this.closest('tr').index();
            var row_closestTrColumns = $this.closest('tr');
            var orderId = row_closestTrColumns.find('td:eq(5)').text();
            console.debug("**********************orderId "+orderId);
            window.open('{!!url("/productontheminiorderform")!!}/'+orderId, "productsontheorder", "width=760, height=500, scrollbars=yes")

        });

        $('#selectAll').on('click',function(){
            var filters = [];
            var allchecked = [];
            $($("input[name='caseProd[]']")).each(function(){
                $(this).prop('checked',true);
                var newFilter = $(this).closest('tr').find('td:eq(3)').text();
                $(this).closest('tr').find('td:eq(3)').css('background-color', '#ffcccc');
                //#ffcccc;
                if(!$(this).is(":checked"))
                {
                    $(this).closest('tr').find('td:eq(3)').css('background-color', 'yellow');
                    //alert('you are unchecked ' + );
                    var found = jQuery.inArray(newFilter, allchecked);
                    if (found >= 0) {
                        // Element was found, remove it.
                        allchecked.splice(found, 1);
                    }
                }else
                {
                    allchecked.push(newFilter);

                }
                var filters = [];
                $.each(allchecked, function(i, el){
                    if($.inArray(el, filters) === -1) filters.push(el);
                });

                console.debug("all   +"+allchecked.length);
                console.debug(" fil +"+filters.length);
                console.debug(filters);
                $("#totalorders").empty();
                $("#totalorders").append('N/STOPS :'+filters.length);
            });


        });


        $('#planpriority').on('click',function(){

            var checkedLines = new Array();

            $('[name="unique"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                checkedLines.push({
                    'orderdetail': id,
                    'qty': $(this).closest('tr').find('.remaining').val(),
                    'pickingtype':'priority',
                    'referenceNo':$('#referenceno').val()
                });

            });

            $.ajax({
                url: '{!!url("/saveplan")!!}',
                type: "POST",
                data: {

                    referenceno: $('#referenceno').val(),
                    priority: checkedLines
                },
                success: function (data) {
                    console.debug(data);
                    // upDateOrderHeaderAndPOS();

                    $.ajax({
                        url: '{!!url("/getProgressPlan")!!}',
                        type: "GET",
                        data: {

                            referenceno: $('#referenceno').val(),

                        },
                        success: function (data) {
                            console.debug(data);
                            var trHTML = '';
                            var counter = 0;
                            $('#plannedprogress').empty();
                            $.each(data, function (key, value) {
                                trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" >'+
                                    '<td style="">'+value.PastelDescription+'</td>'+
                                    '<td>'+
                                    '<input type="number" min="0" style="height: 50px !important;" class="Qty" value="' + parseFloat(value.Qty).toFixed(2) + '" style="" >' +
                                    '<input type="hidden" id ="ProductId" class="ProductId" value="' +value.ProductId + '" /></td>' +
                                    '' +
                                    '</tr>';
                                counter++;
                            });

                            $('#plannedprogress').append(trHTML);

                        }
                    });



                }
            });

        });


        $('#planallproducts').on('click',function(){
            var checkedLinesPriority = new Array();
            $('[name="uniqueallproducts"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                checkedLinesPriority.push({
                    'orderdetail': id,
                    'qty': $(this).closest('tr').find('.remaining').val(),
                    'pickingtype':'productsonorders',
                    'referenceNo':$('#referenceno').val()
                });

            });
            console.debug(checkedLinesPriority);
            $.ajax({
                url: '{!!url("/saveplan")!!}',
                type: "POST",
                data: {

                    referenceno: $('#referenceno').val(),
                    priority: checkedLinesPriority
                },
                success: function (data) {
                    console.debug(data);
                    // upDateOrderHeaderAndPOS();

                    $.ajax({
                        url: '{!!url("/getProgressPlan")!!}',
                        type: "GET",
                        data: {

                            referenceno: $('#referenceno').val(),

                        },
                        success: function (data) {
                            console.debug(data);
                            var trHTML = '';
                            var counter = 0;
                            $('#plannedprogress').empty();
                            $.each(data, function (key, value) {
                                trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" >'+
                                    '<td style="">'+value.PastelDescription+'</td>'+
                                    '<td>'+
                                    '<input type="number" min="0" style="height: 50px !important;" class="Qty" value="' + parseFloat(value.Qty).toFixed(2) + '" style="" >' +
                                    '<input type="hidden" id ="ProductId" class="ProductId" value="' +value.ProductId + '" /></td>' +
                                    '' +
                                    '</tr>';
                                counter++;
                            });

                            $('#plannedprogress').append(trHTML);

                        }
                    });



                }
            });
        });

        $('#doneplanning').click(function(){
            $.ajax({
                url: '{!!url("/doneplanning")!!}',
                type: "POST",
                data: {

                    dispatchdate: $('#dispatchdate').val(),
                    eRouteNamedispatch: $('#eRouteNamedispatch').val(),
                    orderTypesTabletLoadingonPlanningdispatch: $('#orderTypesTabletLoadingonPlanningdispatch').val(),
                    referenceno: $('#referenceno').val()
                },
                success: function (data) {
                    var dialog = $('<p><strong style="color:red">Data Saved</strong></p>').dialog({
                        height: 200, width: 700,modal: true,containment: false,
                        buttons: {
                            "Okay": function () {
                                dialog.dialog('close');
                            }
                        }
                    });
                }
            });

        });

        //plannedprogress

        $(document).on("dblclick","#tblplannedprogress tbody tr",function() {
            // alert('Row dblclicked');
            //$('#callListTable tbody').on('dblclick', 'tr', function () {
            // var productCode = $(this).find(".foo").val();
            var $this = $(this);
            var row = $this.closest("tr");

            var desc = row.find('td:eq(0)').text();

            var prodId = row.find(".ProductId").val();//

            $('#prod').val(desc);
            showDialog('#customerPlanned','60%',620);

            $.ajax({
                url: '{!!url("/getProgressPlanCustByProducts")!!}',
                type: "GET",
                data: {

                    referenceno: $('#referenceno').val(),
                    prodId: prodId,

                },
                success: function (data) {
                    console.debug(data);
                    var trHTML = '';
                    var counter = 0;
                    $('#plannedline').empty();
                    $('#productIds').val(prodId);

                    $.each(data, function (key, value) {
                        trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" >'+
                            '<td style="">'+value.StoreName+'</td>'+
                            '<td>'+
                            '<input type="number" name="mnyQty" min="0" style="height: 50px !important;" class="mnyQty" value="' + parseFloat(value.mnyQty).toFixed(2) + '" style="" >' +
                            '<input type="hidden" id ="intAutoPicking" class="intAutoPicking" value="' +value.intAutoPicking + '" /></td>' +
                            '' +
                            '</tr>';
                        counter++;
                    });

                    $('#plannedline').append(trHTML);

                    $('#submit').click(function () {


                        var updates = new Array();

                        $('[name="mnyQty"]').each(function(checkbox) {
                            // selected.push(checkbox);
                            var id = $(this).val();
                            updates.push({
                                'mnyQty': id,
                                'intAutoPicking': $(this).closest('tr').find('.intAutoPicking').val()

                            });

                            $.ajax({
                                url: '{!!url("/updateplan")!!}',
                                type: "POST",
                                data: {

                                    referenceno: $('#referenceno').val(),
                                    updates: updates
                                },
                                success: function (data) {
                                    console.debug(data);
                                    $('#customerPlanned').dialog("close");

                                    $.ajax({
                                        url: '{!!url("/getProgressPlan")!!}',
                                        type: "GET",
                                        data: {

                                            referenceno: $('#referenceno').val(),

                                        },
                                        success: function (data) {
                                            console.debug(data);
                                            var trHTML = '';
                                            var counter = 0;
                                            $('#plannedprogress').empty();
                                            $.each(data, function (key, value) {
                                                trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" >'+
                                                    '<td style="">'+value.PastelDescription+'</td>'+
                                                    '<td>'+
                                                    '<input type="number" min="0" style="height: 50px !important;" class="Qty" value="' + parseFloat(value.Qty).toFixed(2) + '" style="" >' +
                                                    '<input type="hidden" id ="ProductId" class="ProductId" value="' +value.ProductId + '" /></td>' +
                                                    '' +
                                                    '</tr>';
                                                counter++;
                                            });

                                            $('#plannedprogress').append(trHTML);

                                        }
                                    });
                                }

                            });

                        });

                    });

                }
            });


        });



    });

    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("unsequenced");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
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
    function getMultiRoutSelected()
    {

        $.ajax({
            url: '{!!url("/getCustomerPlannedForPicking")!!}',
            type: "POST",
            data: {
                routeId: $('#rouTabletLoadingtesonPlanning').val(),
                deliveryDate: $('#deliveryDatesonPlanning').val(),
                OrderType: $('#orderTypesTabletLoadingonPlanning').val(),
                deliveryDateTo: $('#deliveryDatesonPlanning2').val(),
                dateTo: $('#deliveryDatesonPlanning2').val(),
                status: $('#statusRoutePlanner').val()
            },
            success: function (data) {
                var trHTML = '';
                var style = '';
                var classes = 'onDrag';
                $('.priority').empty();

                var inv = 'id';
                var counter = 0;
                console.debug("**************  referenceNo "+data.referenceNo);
                $('#referenceno').val(data.referenceNo);
                $.each(data.priority, function (key, value) {

                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" class="hidden_row1'+counter+' hidden_row">'+
                        '<td style="padding: 0px;width: 100px;">'+value.StoreName+'</td>'+
                        '<td>'+value.OrderId+
                       '</td></tr>';

                });
                $('#priority').append(trHTML);
                var trHTML = '';

                $('#allproducts').empty();


            }
        });
    }
    function show_hide_row(row)
    {
        $("."+row).toggle();
    }


</script>
<script>

</script>
