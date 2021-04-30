@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
        <a href='{!!url("/invoicesnotprinting")!!}' onclick="window.open(this.href, 'invoicesnotprinting',
'left=20,top=20,width=500,height=600,toolbar=1,resizable=0'); return false;" style="color:black;font-size: 15px;font-weight:900;background: red;padding: 2px;">Check Why Invoices Not Printing</a>
        <button id="amalgamate" class="pull-right" style="background: #260ee8;color: white;font-weight: 900;font-size: 19px;    padding: 2px;display: none;">Amalgamate</button>
    <div id="routePlanningPopUp" title="Route Planning">
        <div class="col-lg-12">
            <div class="col-lg-12" >
                <div class="col-lg-12">
                    <form>
                        <fieldset class="well">
                            <legend class="well-legend">Create</legend>
                            <div class="form-group  col-md-3" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="deliveryDatesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Date</label>
                                <input name="deliveryDatesonPlanning" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning" >
                            </div>

                            <div class="form-group  col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="orderTypesTabletLoadingonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                                <select name="orderTypesTabletLoadingonPlanning" class="form-control input-sm col-xs-1" id="orderTypesTabletLoadingonPlanning" style="height:30px;font-size: 10px;">
                                    <option value="-99">------All------</option>
                                    @foreach($orderTypeSelected  as $values)
                                        <option value="{{$values->OrderTypeId}}">{{$values->OrderType}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="rouTabletLoadingtesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Route</label>

                                <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1" name="multicheckbox[]" multiple="multiple" >

                                    @foreach($routeSelected  as $values)
                                        <option value="{{$values->Routeid}}">{{$values->Route}}</option>
                                        @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="rouTabletLoadingtesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Status</label>
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


                            <input type="text"  class="form-control input-sm col-xs-1" id="myInput" onkeyup="myFunction()" placeholder="Search for customers based on your criteria.">
                        </fieldset>
                    </form>
                    <div >
                        <div style="display: inline-block;"><input name="mass" class="form-control input-sm col-xs-1" id="mass" style="color:blue;font-size:15px;font-weight: 900;" ></div>
                        <div style="display: inline-block;"> <input name="ordervaluetot" class="form-control input-sm col-xs-1" id="ordervaluetot" style="color:red;font-size:15px;font-weight: 900;" ></div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-lg-12">

            <div class="row tabbable">
                <div class="col-xs-12" id="theunsequencedInfo" >

                    <div style="overflow-y: scroll;font-size: 8px;height: 58%; background: white;">

                        <table class="table tablesorter" id="unsequenced" style="overflow-y: scroll;height: 60%">
                            <thead>
                            <tr>
                                <th style="font-size: 10px;">Delv date</th>
                                <th style="font-size: 10px;">InvNO</th>
                                <th style="font-size: 10px;">OrderID</th>
                                <th style="font-size: 7px;width:1px;display: none;">Ignore</th>
                                <th style="font-size: 7px;width:1px;display: none;">Ignor2</th>
                                <th style="font-size: 10px;">Seq</th>
                                <th style="font-size: 10px;color:blue;">Mass</th>
                                <th>Action</th>
                                <th>OrderNO</th>
                                <th style="font-size: 10px;">Delivery Type</th>
                                <th style="font-size: 10px;">Route</th>
                                <th class="col-md-4" style="font-size: 10px;">Customer</th>
                                <th >TripId</th>
                                <th>Select</th>
                            </tr>
                            </thead>

                            <tbody class="connectedSortable">

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>
        <div class="col-lg-12" style="background: greenyellow">
            <div class="col-lg-1">
                <button id="requence" class="btn-md center-block" style="margin-top: 20px;background: black;color: white;font-weight: 900;">Resequence</button>
            </div>

            <div class="col-lg-1">
                <button id="doneSorting" class="btn-success btn-md center-block" style="margin-top: 20px;">Finished</button>
            </div>

            <div class="col-lg-1">
                <button id="moveSelectedOrders" class="btn-primary btn-md center-block" style="margin-top: 20px;">Move Orders</button>
            </div>
            <div class="col-lg-1">
                <button id="selectAll" class="btn-danger btn-md " style="margin-top: 20px;">Select All</button>
            </div>
            <div class="col-lg-1">
                <button id="Deselectselect" class="btn-primary btn-md " style="margin-top: 20px;">Deselect</button>
            </div>
            <div class="col-lg-1">
                <button id="printPriview" class="btn-success btn-md pull-right" style="margin-top: 20px;">Print Sequence</button>
            </div>
            <div class="col-lg-1">
                <button id="suggestions" class="btn-success btn-md pull-right" style="margin-top: 20px;">Suggestions</button>
            </div>
            <div class="col-lg-1">
                <h1 id="totalorders"></h1>
            </div>


            <button id="updateSorting" class="btn-success btn-md center-block" style="margin-top: 20px;">Update</button>

            <a href='#' id="lplan">Logistic Plan</a>
            <br>
            <a href='{!!url("liveBulkPicking")!!}'  id="livebulk" style="color: #0c0c0c;font-weight: 900">Live BulkPicking</a>

        </div>
    </div>
    </div>
    <div id="popupmoveThis" title="Order Change">
        <h5>Please choose the route and order type</h5>
        <form>
            <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                <label class="control-label" for="truckNameSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">Route</label>
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
    <div id="movingOrders" title="You are about to move the below orders." style="background:gray;">
        <div id="movingOrdesBtn" class="form-group  col-md-12">

            <button class="btn-md btn-success" id="continuemove">Continue</button>
        </div>
        <div id="listoforders" class="form-group  col-md-12">


        </div>
    </div>
    <div title="numberpad" id="numberpad">
        <input type="number" id="filledinseq" ><br>
        <input type="hidden" id="orderid" ><br>
        <button id="submitpad" class="btn-sm btn-primary">Submit</button>

    </div>
    <div title="Amalgamation" id="combineroutes">
        <h4>Planned Routes</h4>
        <table id="tablewithseq" class="table-bordered">
            <thead>
            <tr>
                <th>Routeid</th>
                <th>Delivery Type Id</th>
                <th>Route</th>
                <th>Order Type</th>
                <th>Delivery Date</th>
                <th>Number Of Stops</th>
                <th>Sequence</th>
            </tr>
            </thead>
            <tbody id="mergeroutes">

            </tbody>

        </table>
        <hr style="border: 1px solid black;">
        <div style="background: yellow;">
            <h3>Select New Route and Delivery Type.</h3>
            <form style="background: yellow;">
                <div class="form-group  col-md-4" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="truckNameSheetMaster"  style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">Route</label>
                    <select name="eRouteName" class="form-control input-sm col-sm-1"  id="routenew" style="font-size: 14px;" >
                        @foreach($routes as $value)
                            <option value="{{$value->Routeid}}">{{$value->Route}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="deliveryTypeRun"  style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">Delivery Type(Run)</label>
                    <select name="deliveryTypeRun" class="form-control input-sm col-sm-1" id="ordertypenew" style="font-size: 14px;">
                        @foreach($orderTypes as $value)
                            <option value="{{$value->OrderTypeId}}">{{$value->OrderType}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group  col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <label class="control-label" for="deliveryTypeRun"  style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">Date</label>
                     <input type="date" class="form-control input-sm col-sm-1" id="dateto">
                </div>

            </form>
        </div>
        <br>
        <div id="savebutton">

        </div>
    </div>
    <script src="{{ asset('public/js/tableSorter.js') }}"></script>
@endsection
<style>
    .onDrag {
        height: 26px !important;
    }
    .backgroudcolor{
        background:#83c8f9;
    }
    .backgroudcolorOffloaded{
        background:#fd00ff8a;
    }
    .backgroudcolorOrange{
        background:darkorange;
    }
    .backgroudcolorBlue{
        background:mediumslateblue;
    }
    .backgroudcolorOffloadedHighNotification{
        background: rgba(4, 255, 31, 0.54);
    }
    .backgroudcolorBadCredit{
        background: rgba(0, 0, 0, 0.97);
        color:#6f9af0;
    }
    .backgroudcolorLoadingProgress{
        background: rgba(212, 176, 13, 0.97);
    }
   /* .backgroudcolorBlockedAcc{
        background: rgba(212, 0, 4, 0.97);
        color:#6f9af0;
    }*/
</style>
<script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
<script>

    var jArrayOrderTypes = JSON.stringify({!! json_encode($orderTypes) !!});
    var jArraydelivDates = JSON.stringify({!! json_encode($delivDates) !!});
    var jArraydelivroutes = JSON.stringify({!! json_encode($routes) !!});
    var jArraydDrivers = JSON.stringify({!! json_encode($drivers) !!});
    var jArraydtrucks = JSON.stringify({!! json_encode($trucks) !!});
    var authdialogMoveOrder = "<?php  echo env('APP_AUTH_ORDER_MOVE_DIALOG'); ?>";

    var computerName = '<?php echo gethostname() ?>';

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
        $('#movingOrders').hide();
        $('#numberpad').hide();
        $('#combineroutes').hide();
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
        $('#rouTabletLoadingtesonPlanning').append(toAppendroute);
        //$('#eRouteName').append(toAppendroute);
        // $('#routeSheetMaster').append(toAppendroute);
        //TRUCKS
        var toAppendTrucks = '';
        $.each(JSON.parse(jArraydtrucks),function(i,o){
            toAppendTrucks += '<option value="'+o.TruckId+'">'+o.TruckName+'</option>';
        });
        $('#truckName').append(toAppendTrucks);
        $('#truckNameSheetMaster').append(toAppendTrucks);

        $('#rouTabletLoadingtesonPlanning').multiselect({
            columns: 1,
            placeholder: 'Select Route(s)',
            selectAll: true
        });

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
            var orderId = $(this).closest('tr').find('td:eq(2)').text();
            var orderType = $(this).closest('tr').find('td:eq(5)').text();
            var orderTypeID = $(this).closest('tr').find('td:eq(6)').text();
            var routeId = $(this).closest('tr').find('td:eq(7)').text();
            var routeName = $(this).closest('tr').find('td:eq(1)').text();
            var invoiceNo = $(this).closest('tr').find('td:eq(1)').text();

            if(($.trim(invoiceNo)).length < 5)
            {

                    $.ajax({
                        url: '{!!url("/sequenceOrdersByMode")!!}',
                        type: "POST",
                        data: {mode:1,orderId:orderId,seq:0},
                        success: function (data) {
                                console.debug(data);
                                $('#tabletLoadingGoonPlanning').click();
                        }

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

        $('#amalgamate').click(function(){
            //combineroutes
            $('#combineroutes').show();
            showDialog('#combineroutes','60%',620);
            $('.onDrag').remove();

            $.ajax({
                url: '{!!url("/amalgamation")!!}',
                type: "get",
                data: {deldate:$('#deliveryDatesonPlanning').val()},
                success: function (data) {
                    var trHTML = '';

                    $.each(data, function (key, value) {
                        var classes = 'onDrag';


                        trHTML += '<tr role="row" class="'+classes+'" style="height: 26px !important;"  ><td>' +
                            value.RouteId + '</td><td>' +
                            value.LateOrder + '</td><td>' +
                            value.Route + '</td><td>' +
                            value.OrderType + '</td><td>' +
                            value.DeliveryDate + '</td>' +
                            '<td><input type="hidden" calss="routeid" style="height:20px;width:30px" value="'+value.RouteId+'"><input type="hidden" calss="ordertypeid" style="height:20px;width:30px" value="'+value.LateOrder+'"></td>' +
                            '<td contenteditable="true"></td>' +
                            '</tr>';
                    });
                    $('#mergeroutes').append(trHTML);
                    $('#savebutton').append("<button id='saveamalga'>Save</button>");


                    $('#saveamalga').click(function(){
                        var productsLinesOnPickingOneOrder = new Array();
                        $('#tablewithseq > tbody  > tr').each(function() {
                            var data = $(this);
                            console.debug(data);
                            console.debug( $(this).closest('tr').find('td:eq(0)').text());
                            console.debug( $(this).closest('tr').find('td:eq(1)').text());
                            console.debug( $(this).closest('tr').find('td:eq(6)').text());
                            if ( ( $(this).closest('tr').find('td:eq(6)').text()).length > 0) {
                                productsLinesOnPickingOneOrder.push({
                                    'routeid': $(this).closest('tr').find('td:eq(0)').text(),
                                    'ordertypeid': $(this).closest('tr').find('td:eq(2)').text(),
                                    'date': $(this).closest('tr').find('td:eq(5)').text(),
                                    'sequence': $(this).closest('tr').find('td:eq(6)').text(),

                                });
                            }

                        });
                        $.ajax({
                            url: '{!!url("/combineroutes")!!}',
                            type: "POST",
                            data: {
                                routenew: $('#routenew').val(),
                                ordertypenew: $('#ordertypenew').val(),
                                dateto: $('#date').val(),
                                sequence: productsLinesOnPickingOneOrder
                            },
                            success: function (data) {
                                console.debug(data);
                                // upDateOrderHeaderAndPOS();
                            }
                        });

                    });
                }

            });

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

            $('#printPriview').click(function(){
                window.open('{!!url("/routePlannerPrintPreview")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val()+'/'+$('#statusRoutePlanner').val() , "products", "width=760, height=500, scrollbars=yes");
            });

        $('#suggestions').click(function(){

            var orderType =$('#orderTypesTabletLoadingonPlanning').val();
            var routeId =$('#rouTabletLoadingtesonPlanning').val();
            if(orderType !='-99' && routeId !='-99'){
                window.open('{!!url("/routePlannerSuggestions")!!}/'+$('#deliveryDatesonPlanning').val()+'/'+$('#orderTypesTabletLoadingonPlanning').val()+'/'+$('#rouTabletLoadingtesonPlanning').val()+'/'+$('#statusRoutePlanner').val());
            }
        });
            $('#requence').click(function(){
                var orderType =$('#orderTypesTabletLoadingonPlanning').val();
                var routeId =$('#rouTabletLoadingtesonPlanning').val();
                if(orderType !='-99' && routeId !='-99'){
                    $.ajax({
                        url: '{!!url("/resequenceOrders")!!}',
                        type: "POST",
                        data: {deldate:$('#deliveryDatesonPlanning').val(),orderType:orderType,routeId:routeId},
                        success: function (data) {
                            console.debug(data);
                            $('#tabletLoadingGoonPlanning').click();
                        }

                    });
                }

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
        $("#deliveryDatesonPlanning").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: 'yy-mm-dd' });
        var dt_to = $.datepicker.formatDate('yy-mm-dd', new Date());
        $("#deliveryDatesonPlanning").val(dt_to);
        $('#doneSorting').click(function(){
            var sortedOrderIds = new Array();
            var stringyFy = '';
            $('#unsequenced > tbody > tr').each(function() {
                var data = $(this);
                var index =  $(this).closest('tr').index();
                sortedOrderIds.push({'index':index,'orderId': $(data).find('td:eq(2)').text()});//

            });

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
        $('#unsequenced').on('click', 'button', function (e) {
            var $this = $(this);
            var row_index = $this.closest('tr').index();
            var row_closestTrColumns = $this.closest('tr');
            var orderId = row_closestTrColumns.find('td:eq(2)').text();
            console.debug("**********************orderId "+orderId);
            window.open('{!!url("/productontheminiorderform")!!}/'+orderId, "productsontheorder", "width=760, height=500, scrollbars=yes")

        });
        $('#moveSelectedOrders').on('click',function(){
            var valuesProd = new Array();
            $('#listoforders').empty();
            var htmls = '';
            $.each($("input[name='caseProd[]']:checked"),
                function () {
                    var data = $(this).parents('tr:eq(0)');
                    valuesProd.push({ 'orderId':$(data).find('td:eq(2)').text()});
                    htmls += '<h5>' +$(data).find('td:eq(2)').text()+' - '+ $(data).find('td:eq(11)').text() + '</h5>' ;
                });
            $('#listoforders').append(htmls);
            if (valuesProd.length > 0 && authdialogMoveOrder === 'LTRUE')
            {
                $('#movingOrders').show();
                showDialog('#movingOrders','60%',500);
            }
            if(authdialogMoveOrder === 'LTRUE') {
                $('#continuemove').click(function () {
                    showDialog('#popupmoveThis', '60%', 220);
                    $('#submitChanges').click(function () {
                        console.debug("after clicking submit****************" + valuesProd);
                        //

                        $.ajax({
                            url: '{!!url("/moveTheOrderArray")!!}',
                            type: "POST",
                            data: {
                                orderTypeId: $('#deliveryTypeRun').val(),
                                routeId: $('#eRouteName').val(),
                                orderId: valuesProd
                            },
                            success: function (data) {

                                //$('#tabletLoadingGoonPlanning').click();
                                showDialog('#confirmMove', '60%', 220);//
                                $('#okayclose').click(function () {
                                    $("#popupmoveThis").dialog('close');
                                    $("#confirmMove").dialog('close');
                                    location.reload(true);
                                });
                            }
                        });
                    });
                });
            }else{
                showDialog('#popupmoveThis', '60%', 220);
                $('#submitChanges').click(function () {
                    console.debug("after clicking submit****************" + valuesProd);
                    //

                    $.ajax({
                        url: '{!!url("/moveTheOrderArray")!!}',
                        type: "POST",
                        data: {
                            orderTypeId: $('#deliveryTypeRun').val(),
                            routeId: $('#eRouteName').val(),
                            orderId: valuesProd
                        },
                        success: function (data) {

                            //$('#tabletLoadingGoonPlanning').click();
                            showDialog('#confirmMove', '60%', 220);//
                            $('#okayclose').click(function () {
                                $("#popupmoveThis").dialog('close');
                                $("#confirmMove").dialog('close');
                                location.reload(true);
                            });
                        }
                    });
                });
            }

        });
        $('#selectAll').on('click',function(){
            $($("input[name='caseProd[]']")).each(function(){
                $(this).prop('checked',true);
            });
        });

        $('#Deselectselect').on('click',function(){
            $($("input[name='caseProd[]']")).each(function(){
                $(this).prop('checked',false);
            });
        });
        //
      /*  $(document).on('click', '.DeliverySequence', function(e) {
            //numberpad
            var orderId = $(this).closest('tr').find('td:eq(2)').text();
            var invoiceNo = $(this).closest('tr').find('td:eq(1)').text();
            $('#numberpad').show();
            showDialog('#numberpad', '60%', 220);//
            $('#filledinseq').val('');
            $('#submitpad').click(function () {
                if(($.trim(invoiceNo)).length < 5)
                {
                    $.ajax({

                        type: "POST",
                        data: {mode:2,orderId:orderId,seq:$('#filledinseq').val()},
                        success: function (data) {
                            console.debug(data);
                            $( "#numberpad" ).dialog('close');
                            $('#tabletLoadingGoonPlanning').click();
                        }

                    });
                }
                else
                {
                    alert("SORRY ,THIS IS ALREADY INVOICED YOU CAN NOT MOVE IT");
                    $("#numberpad").dialog('close');
                }

            });

        });*/
        $(document).on('keyup', '.DeliverySequence', function(e) {
            //numberpad
            var code = (e.keyCode ? e.keyCode : e.which);
            // var testLst = $(this).closest('tr');
            if ((code == 13 )) {


                var orderId = $(this).closest('tr').find('td:eq(2)').text();
                var invoiceNo = $(this).closest('tr').find('td:eq(1)').text();
                var valTyped = $(this).val();
                if (($.trim(invoiceNo)).length < 5) {
                    $.ajax({
                        url: '{!!url("/sequenceOrdersByMode")!!}',
                        type: "POST",
                        data: {mode: 2, orderId: orderId, seq: valTyped},
                        success: function (data) {
                            console.debug(data);

                            $('#tabletLoadingGoonPlanning').click();
                        }

                    });
                } else {
                    alert("SORRY ,THIS IS ALREADY INVOICED YOU CAN NOT MOVE IT");
                    $("#numberpad").dialog('close');
                }

            }


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
            td = tr[i].getElementsByTagName("td")[11];
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
        console.debug($('#deliveryDatesonPlanning').val());

        $.ajax({
            url: '{!!url("/getRouteDataMultiSelected")!!}',
            type: "POST",
            data: {
                routeId: $('#rouTabletLoadingtesonPlanning').val(),
                deliveryDate: $('#deliveryDatesonPlanning').val(),
                OrderType: $('#orderTypesTabletLoadingonPlanning').val(),
                status: $('#statusRoutePlanner').val()
            },
            success: function (data) {
                var trHTML = '';
                var style = '';
                var classes = 'onDrag';
                var columClass = '';
                $('.onDrag').remove();
                var massTotal = 0;
                var ordervalue = 0;
                $.each(data, function (key, value) {
                    var classes = 'onDrag';
                    var columClass = '';
                  /*  if (value.DeliveryDate ==0)
                    {
                        classes = 'onDrag backgroudcolor';
                    }*/
                    if (value.offloaded ==1)
                    {
                        classes = 'onDrag backgroudcolorOffloaded';
                    }
                    if (value.StatusId ==2)
                    {
                        classes = 'onDrag backgroudcolor';
                    }
                    if (value.courierColor =="blue")
                    {
                        classes = 'onDrag backgroudcolorBlue';
                    }
                    if (value.collectionColor =="orange")
                    {
                        classes = 'onDrag backgroudcolorOrange';
                    }
                    if(value.intNotification == 3)
                    {
                        classes = 'onDrag backgroudcolorOffloadedHighNotification';
                    }
                    if(value.limit == 1)
                    {
                        classes = 'onDrag backgroudcolorBadCredit';
                    }
                    if(value.Loaded == 1)
                    {
                        columClass = 'backgroudcolorLoadingProgress';
                    }

                    massTotal =  parseFloat(massTotal) + parseFloat(value.Mass);
                    ordervalue =  parseFloat(ordervalue) + parseFloat(value.OrderValue);
                    trHTML += '<tr role="row" class="'+classes+'" style="height: 26px !important;"  ><td>' +
                        value.DeliveryDate + '</td><td>' +

                        value.InvoiceNo + '</td><td>' +
                        value.OrderId + '</td>' +
                        '<td style="display: none;">' +
                        value.OrderTypeId + '</td><td style="display: none;">' +
                        value.RouteId + '</td><td style="width: 17px;">' +
                        '<input type="text" name="DeliverySequence" class="DeliverySequence" value="'+value.DeliverySequence+'" onkeypress="return isFloatNumber(this,event)" style="background: #a6f30e;font-weight: 900;" >'+
                        '</td><td style="color:blue">' +
                        parseFloat(value.Mass).toFixed(0) + '</td><td>' +
                        '<button class="btn-xs btn-success" style="width: 76px;height: 24px;font-size: 8px;"  value="'+value.OrderId+'">View Products</button></td>' +
                        '<td style="font-weight:900">' +
                        value.OrderNo + '</td>'+
                        '<td style="font-weight:900">' +
                        value.OrderType + '</td><td>'+
                        value.Route + '</td>' +
                        '<td style="background:yellow">' +

                    value.StoreName + '</td><td class="'+columClass+'">'+
                    value.DeliveryDateRoutingID + '</td>'+
                        '<td><input type="checkbox" name="caseProd[]" style="height:20px;width:30px" value="'+value.OrderId+'"></td>' +

                        '</tr>';
                });
                $('#unsequenced').append(trHTML);
                $('#mass').val(parseFloat(massTotal).toFixed(3));
                $('#ordervaluetot').val(parseFloat(ordervalue).toFixed(2));
                $("#unsequenced").trigger("update");

                var filters = [];
                var allchecked = [];
                $("input:checkbox").click(function() {
                    var newFilter = $(this).closest('tr').find('td:eq(11)').text();
                    $(this).closest('tr').find('td:eq(11)').css('background-color', '#ffcccc');
                    //#ffcccc;
                    if(!$(this).is(":checked"))
                    {
                        $(this).closest('tr').find('td:eq(11)').css('background-color', 'yellow');
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

                    if(filters.length > 40)
                    {
                        var dialog = $('<p><strong style="color:red">You have put too many stops, the limit is 40</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "Okay": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });
                    }
                    $("#totalorders").empty();
                    $("#totalorders").append('N/STOPS :'+filters.length);
                });

            }
        });
    }
    function printDoc(url,docType,docID,isDeliveryNote,invoiceNumber)
    {
        $.ajax({
            url: url ,
            type: "POST",
            data:{DocType:docType,DocId:docID,PrintDeliveryNote:isDeliveryNote,invoiceNumber:invoiceNumber},
            success: function(data){

            }
        });
    }

    function truckControlSheetHeaderOnFiltering(truckControlId)
    {
//getTruckControlSheetHeaderByTruckId
        $.ajax({
            url: '{!!url("/getTruckControlSheetHeaderByTruckId")!!}',
            type: "POST",
            data: {
                truckControlID: truckControlId
            },
            success: function (data) {
                $('#truckName').prepend('<option value="'+data[0].TruckId+'" selected="selected">'+data[0].TruckName+'</option>');
                $('#driver').prepend('<option value="'+data[0].DriverId+'" selected="selected">'+data[0].DriverName+'</option>');
                $('#assistant').prepend('<option value="'+data[0].assistantId+'" selected="selected">'+data[0].Assistant+'</option>');
                $('#dateCreateForControlSheet').val(data[0].DateCreated);
                $('#delvDateForControlSheet').val(data[0].DeliveryDate);
            }
        });
    }
    function truckControlSheetDetails(truckControlId)
    {
        $.ajax({
            url: '{!!url("/truckControlSheetDetails")!!}',
            type: "GET",
            data: {
                truckControlID: truckControlId
            },
            success: function (data) {
                var trHTML = '';
                // $('.onDrag').remove();
                $.each(data, function (key, value) {
                    trHTML += '<tr role="row" class="onDrag2"  style="font-size: 9px;color:black;height: 26px;"><td>' +
                        value.DeliveryDate + '</td><td>' +
                        value.Route + '</td><td>' +
                        value.StoreName + '</td><td>' +
                        value.InvoiceNo + '</td><td>' +
                        value.OrderId + '</td><td  style="font-weight:900">' +
                        value.OrderValue + '</td><td>' +
                        value.DeliverySequence + '</td><td>' +
                        '</tr>';
                });
                $('#sequenced').append(trHTML);
            }
        });
    }
    /**
     * Log data into tblManagementConsole
     * @param url
     * @param ConsoleTypeId
     * @param Importance
     * @param Message
     * @param Reviewed
     * @param OrderId
     * @param productid
     * @param CustomerId
     * @param OldQty
     * @param NewQty
     * @param OldPrice
     * @param NewPrice
     * @param ReferenceNo
     * @param DocType
     *  @param machine
     * @param DocNumber
     * @param ReturnId
     */
    function consoleManagement(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                               CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                ReviewedUserId:0,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,

            },
            success: function(data){
                //dd(data);
                //Try to use web sql
            }});

    }
    function consoleManagementAuths(url,ConsoleTypeId,Importance,Message,Reviewed,OrderId,productid,
                                    CustomerId,OldQty,NewQty,OldPrice,NewPrice,ReferenceNo,DocType,machine,DocNumber,ReturnId,userId,userName)
    {
        $.ajax({
            url:url,
            type: "POST",
            data:{ConsoleTypeId:ConsoleTypeId,
                Importance:Importance,
                Message:Message,
                Reviewed:Reviewed,
                OrderId:OrderId,
                productid:productid,
                CustomerId:CustomerId,
                OldQty:OldQty,
                NewQty:NewQty,
                ReviewedUserId:0,
                OldPrice:OldPrice,
                NewPrice:NewPrice,
                ReferenceNo:ReferenceNo,
                DocType:DocType,
                DocNumber:DocNumber,
                machine:machine,
                ReturnId:ReturnId,
                userId:userId,
                userName:userName,

            },
            success: function(data){
                // dd(data);
                //Try to use web sql
            }});

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
</script>