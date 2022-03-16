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
                <div class="form-group  col-md-1"  style="margin-top: 15px; margin-left: -14px;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <a href='{!!url("/planningusingflex")!!}' target="_blank" style="font-size: 16px;text-decoration: underline;float: right">Flex Planning</a>

                </div>
                <div class="form-group  col-md-2"  style="margin-top: 15px; margin-left: -14px;margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                    <a href='#' style="font-size: 16px;text-decoration: underline;float: right"    onclick="window.open('{!!url("/customerarealookup")!!}','name','width=1200,height=500')">Customer Lookup</a>
                </div>
                <div class="col-lg-12">

                    <form>
                        <fieldset class="well">
                            <legend class="well-legend">Create</legend>
                            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">.
                                <label class="control-label" for="deliveryDatesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
                                <input name="deliveryDatesonPlanning" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning" value="{{$selectedDelivDate}}" >
                            </div>
                            <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="deliveryDatesonPlanning2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
                                <input name="deliveryDatesonPlanning2" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning2" value="{{$selectedDelivDate}}" >
                            </div>
                            <div class="form-group  col-md-1"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="orderTypesTabletLoadingonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Delivery Type</label>
                                <select name="orderTypesTabletLoadingonPlanning" class="form-control input-sm col-xs-1" id="orderTypesTabletLoadingonPlanning" style="height:30px;font-size: 10px;">

                                    @foreach($orderTypeSelected  as $values)
                                        <option value="{{$values->OrderTypeId}}">{{$values->OrderType}}</option>
                                    @endforeach
                                    <option value="-99">All</option>

                                </select>
                            </div>

                            <div class="form-group  col-md-1"  style="margin-bottom: 0px;font-weight: 700;font-size: 17px;">
                                <br>
                                <a href='{!!url("/arealook")!!}' onclick="window.open(this.href, 'arealook',
'left=20,top=20,width=1000,height=1000,toolbar=1,resizable=0'); return false;"  style="font-size: 17px;text-decoration: underline;">View Areas</a>
                                 <input id="prodexclude" class="form-control input-sm col-xs-1" value="-1" readonly style="display: none;">
                            </div>
                            <div class="form-group col-md-3"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
                                <label class="control-label" for="rouTabletLoadingtesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 14px;">Route</label>
                                <select  id="rouTabletLoadingtesonPlanning" class="form-control input-sm col-xs-1" name="multicheckbox[]" multiple="multiple" style="width:300px; height:300px;" >

                                    @foreach($routes as $values)
                                        <option value="{{$values->Routeid}}">{{$values->Route}} ( Mass:{{round($values->m,2)}} )</option>
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
                            <h4 style="text-align: center">Priority</h4>
                            <table class="table table-bordered" >
                                <thead>
                                <tr>

                                    <th>Customer Name</th>
                                    <th>OrderId</th>
                                    <th>Order Date</th>
                                    <th>Delivery Date</th>
                                    <th>OrderNo</th>
                                </tr>
                                </thead>
                                <tbody id="priority">

                                </tbody>
                            </table>


                        </div>


                        <div class="flex-child " style="overflow-y: scroll;">
                            <h4 style="text-align: center" >Products on Orders</h4>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Available</th>

                                </tr>
                                </thead>
                                <tbody id="allproducts">

                                </tbody>
                            </table>
                        </div>



                    </div>

                </div>
                <div class="col-lg-12" style="background: #9ab5bb; height:50px;">
                    <label>Assign Route</label>
                    <select id="temppickingroute">
                        <option value="-99">Select Route</option>
                        @foreach($routes as $values)
                            <option value="{{$values->Routeid}}">{{$values->Route}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-lg-12">
                    <div class="flex-container2">
                        <div class="flex-child2 " style="text-align: center">


                            <button id="planpriority" class="btn-success btn-lg btn">Save & Plan</button><br><br>
                            Total Weight: <input id="totalweightcust" >
                            Total Vol: <input id="totalvolcust" >
                        </div>

                        <div class="flex-child2 " style="text-align: center">
                            <button id="planallproducts" class="btn-success btn-lg btn">Save & Plan</button><br><br>

                            Total Weight: <input id="totalweight" >
                            Total Vol: <input id="totalvol" >
                        </div>

                    </div>
                </div>


                <div class="col-lg-12" style="background: orange; height:100px;">

                    <div class="col-lg-6">
                        <a href='{!!url("/getmycustroutemap")!!}' style="color:black;font-weight:900;text-decoration: underline; padding: 3px;float: left;" onclick="window.open(this.href, 'getmycustroutemap',
'left=20,top=20,width=1000,height=950,toolbar=1,resizable=0'); return false;">Customers Map</a>
                        <br>
                    </div>
                    <div class="col-lg-6">
                        <button id="previewplan" class="btn-sm btn-danger">Preview Plan</button>
                        <br><br>
                        <button id="viewpickingticket" class="btn-lg btn-primary" >View Planning Ref Tickets</button>
                        <button class="btn-sm btn-primary pull-right" id="topup">Top Up</button>

                    </div>

                </div>


            </div>

        </div>
        <div class="col-lg-12" style="background: greenyellow">


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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5vAgb-nawregIa5gRRG34wnabasN3blk&callback=initMap&libraries=&v=weekly"
            async></script>
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
        height:70%
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

    var locations =[['Lolest',-25.322148485607237, 28.365571847526194]];
    var prodList = '';
    window.onstorage = event => { // same as window.addEventListener('storage', event => {
        if (event.key == 'products') {
            console.debug(event.key + ':' + event.newValue + " at " + event.url);
            let products = JSON.parse(event.newValue);
            console.debug(products.productId.length);
            var string = [];
           for(var i=0; i<products.productId.length;i++){
               console.debug(products.productId[i].productid);
               string[i] = products.productId[i].productid;
             //  console.debug(products.productId[i][0].productid);
           }
             $('#prodexclude').val(string.join(","));


        }
        //console.debug(event.key + ':' + event.newValue + " at " + event.url);
    };


    localStorage.setItem('now', Date.now());
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

        $("#temppickingroute").change(function () {
            var id = this.value;
            var firstDropVal = $( "#temppickingroute option:selected" ).text();;
            var dialog = $('<p><strong style="color:green">Are you sure that you want to assign '+firstDropVal+'</strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    "YES": function () {
                        dialog.dialog('close');
                        $.ajax({
                            url: '{!!url("/updatepickingheaderonthefly")!!}',
                            type: "POST",
                            data: {
                                routeid: id,
                                refno: $('#referenceno').val()
                            },
                            success: function (data) {
                                localStorage.removeItem('routechosen');
                                //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});
                                localStorage.setItem('routechosen', JSON.stringify({routes: firstDropVal }));
                            }
                        });
                    },
                    "NO": function () {
                        dialog.dialog('close');
                    }
                }
            });
        });

        $('#viewpickingticket').click(function(){

            window.open('{!!url("/pickingtickets")!!}', 'picktickets', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });
        $('#previewplan').click(function(){
            var ref = $('#referenceno').val();
            window.open('{!!url("/previewplan")!!}/'+ref, 'previewplan', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });

        var Odate = new Date();
        var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
        $('#lplan').click(function(){
            window.open('{!!url("/ligisticsplan")!!}/'+newODate, 'SAMPLEV', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });
         $('#prodexclude').click(function(){
            window.open('{!!url("/getProductToSelect")!!}', 'ProductsList', "location=1,status=1,scrollbars=1, width=1500,height=850");
        });

         $('#topup').click(function(){
             var ref = $('#referenceno').val();
            window.open('{!!url("/topuppickingplan")!!}/'+ref, 'topuppickingplan', "location=1,status=1,scrollbars=1, width=1500,height=850");
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
            selectAll: true,
            searchable:true,
            input:'<input type="text" maxLength="20" placeholder="Search">'

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

            var dialog = $('<p><strong style="color:red">NOT SAVED DATA WILL BE DELETED</strong></p>').dialog({
                height: 200, width: 700,modal: true,containment: false,
                buttons: {
                    "CANCEL": function () {
                        dialog.dialog('close');
                    },
                    "OKAY": function () {
                        $('#afterFiltering').hide();
                        $('#doneSorting').show();
                        $('#updateSorting').hide();
                        $('#messageNB').show();
                        $('#instantPrint').hide();
                        getMultiRoutSelected();
                        dialog.dialog('close');
                    }
                }
            });



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

            var routeSelect = $('#temppickingroute').val();
            if(routeSelect != -99){
                var checkedLines = new Array();

                $('[name="unique"]:checked').each(function(checkbox) {
                    // selected.push(checkbox);
                    var id = $(this).val();
                    checkedLines.push({
                        'orderdetail': id,
                        'qty': $(this).closest('tr').find('.remaining').val(),
                        'pickingtype':'priority',
                        'ownerId':$(this).closest('tr').find('.OwnerID').val(),
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
                        console.debug("Plan Priority");

                        var nname = data[0].nickname; console.debug(nname);
                        if (nname == "aegona"){
                            var dialog2 = $('<input type="text" placeholder="Picking Nickname" class="thisplannickname" style="border: 2px solid black;height:50px !important">').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "SAVE": function () {
                                        dialog2.dialog('close');
                                        $.ajax({
                                            url: '{!!url("/pickingNickName")!!}',
                                            type: "POST",
                                            data: {
                                                referenceno: $('#referenceno').val(),
                                                nickname: $('.thisplannickname').val()
                                            },
                                            success: function (data) {

                                            } });

                                    }
                                }
                            });
                        }
                        var dialog = $('<p><strong>Would you like to refresh your priority list?</strong></p>').dialog({
                            height: 200, width: 700,modal: true,containment: false,
                            buttons: {
                                "YES": function () {

                                    $.ajax({
                                        url: '{!!url("/getPriotyCustOnly")!!}',
                                        type: "POST",
                                        data: {
                                            routeId: $('#rouTabletLoadingtesonPlanning').val(),
                                            deliveryDate: $('#deliveryDatesonPlanning').val(),
                                            OrderType: $('#orderTypesTabletLoadingonPlanning').val(),
                                            deliveryDateTo: $('#deliveryDatesonPlanning2').val(),
                                            dateTo: $('#deliveryDatesonPlanning2').val(),
                                            status: $('#statusRoutePlanner').val(),
                                            productId: $('#prodexclude').val(),
                                        },
                                        success: function (data) {
                                            var trHTML = '';
                                            var style = '';
                                            var classes = 'onDrag';
                                            $('#priority').empty();

                                            var inv = 'id';
                                            var counter = 0;
                                            console.debug("**************  referenceNo "+data.referenceNo);

                                            $.each(data.priority, function (key, value) {

                                                if (inv != value.CustomerId)
                                                {
                                                    var k = parseInt(counter)+parseInt(1);
                                                    trHTML +='<tr ondblclick="this.style.display = none" class="fast_remove" style="font-size: 14px;font-weight: 600;" onclick="show_hide_row(\'hidden_row1'+ k +'\') ;"><td>'+
                                                        value.StoreName +'</td><td>'+
                                                        value.orderid +'</td><td>'+
                                                        value.OrderDate +'</td><td>'+
                                                        value.DeliveryDate +'</td><td>'+
                                                        value.OrderNo +'<input type="hidden" class="dontTakeme" value="thisIsIt"></td></tr>';
                                                    counter++;

                                                }
                                                trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" class="hidden_row1'+counter+' hidden_row"><td style="padding: 0px;width: 10%;">'+
                                                    '<input type="checkbox" name="unique" id ="unique" style="height: 20px !important;width: 50px !important;"  class="unique" value="' +value.OrderDetailId + '" /></td>' +
                                                    '<td style="padding: 0px;width: 30%;">'+value.PastelDescription+'</td>'+
                                                    '<td>'+
                                                    '<input type="number" min="0" style="height: 26px !important; width: 76px;" class="remaining" value="' + parseFloat(value.mnyQtyRemaining).toFixed(2) + '" style="" ><input type="hidden" class="volume" value="' +value.volumes + '" />' +
                                                    '<input type="hidden" id ="OrderDetailId" class="OrderDetailId" value="' +value.OrderDetailId + '" /> <input type="hidden" class="prodmass" value="' +value.weights + '" /><input type="hidden" class="fltLatitude" value="' +value.fltLatitude + '" /><input type="hidden" class="fltLongitude" value="' +value.fltLongitude + '" /><input type="hidden" class="OwnerID" value="' +value.OwnerID + '" /></td>' +

                                                    '<td style="padding: 0px;width: 100px;color:red;"> Avl '+ parseFloat(value.Available).toFixed(0)+'</td>'+
                                                    '<td style="padding: 0px;width: 100px;">'+value.pallaetQty+'</td><input type="hidden" class="infowindow" value="' +value.infowindow + '" /><input type="hidden" class="PastelDescription" value="' +value.PastelDescription + '" />'+
                                                    '<td style="padding: 0px;width: 100px;"> Wgt '+parseFloat(value.weights).toFixed(1)+'</td>'+
                                                    '<td style="padding: 0px;width: 100px;"> Vol '+value.volume+'</td>'+
                                                    '</tr>';
//
                                                inv = value.CustomerId


                                            });
                                            $('#priority').append(trHTML);
                                        }
                                    });
                                    dialog.dialog('close');
                                },
                                "NO": function () {
                                    dialog.dialog('close');
                                }
                            }
                        });


                        //getPriotyCustOnly
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
            }else{

                var dialog = $('<p><strong style="color:red">Please Assign Route First</strong></p>').dialog({
                    height: 200, width: 700,modal: true,containment: false,
                    buttons: {
                        "Okay": function () {
                            dialog.dialog('close');
                        }
                    }
                });
            }


        });


        $('#planallproducts').on('click',function(){


            var routeSelect = $('#temppickingroute').val();
            if(routeSelect != -99){
                var checkedLinesPriority = new Array();
                $('[name="uniqueallproducts"]:checked').each(function(checkbox) {
                    // selected.push(checkbox);
                    var id = $(this).val();
                    checkedLinesPriority.push({
                        'orderdetail': id,
                        'qty': $(this).closest('tr').find('.remaining').val(),
                        'ownerId': $(this).closest('tr').find('.ownerId').val(),
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

                        var nname = data[0].nickname; console.debug(nname);
                        if (nname == "aegona"){
                            var dialog2 = $('<input type="text" placeholder="Picking Nickname" class="thisplannickname" style="border: 2px solid black;height:50px !important">').dialog({
                                height: 200, width: 700,modal: true,containment: false,
                                buttons: {
                                    "SAVE": function () {
                                        dialog2.dialog('close');
                                        $.ajax({
                                            url: '{!!url("/pickingNickName")!!}',
                                            type: "POST",
                                            data: {
                                                referenceno: $('#referenceno').val(),
                                                nickname: $('.thisplannickname').val()
                                            },
                                            success: function (data) {

                                            } });

                                    }
                                }
                            });
                        }

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

            }else{
                var dialog = $('<p><strong style="color:red">Please Assign Route First</strong></p>').dialog({
                    height: 200, width: 700,modal: true,containment: false,
                    buttons: {
                        "Okay": function () {
                            dialog.dialog('close');
                        }
                    }
                });
            }
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
        $('#plantheroute').click(function(){
            var Odate = new Date();
            var todayDate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));

            var orderType = 1;
            var route = 2;
            window.open ('{!!url("/planroute")!!}/'+todayDate+'/'+orderType+'/'+route+'/'+3);

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
    function initMap() {


        console.debug(locations );
        var mapCanvas = document.getElementById('map');
        var myLatLng = {
            lat: -29.7010308,
            lng: 30.9727855
        };
        var mapOptions = {
            center: new google.maps.LatLng(-25.322148485607237, 28.365571847526194),
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            var infowindow = new google.maps.InfoWindow({
                content:"" + i,
                maxWidth: 200
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][3]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
        //  addMarker(myLatLng, map);

    }
    function addMarker(location, map) {
        var marker = new google.maps.Marker({
            position: location,
            title: 'Home Center',
            map:map
        });
    }
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
            url: '{!!url("/getRouteDataMultiSelected")!!}',
            type: "POST",
            data: {
                routeId: $('#rouTabletLoadingtesonPlanning').val(),
                deliveryDate: $('#deliveryDatesonPlanning').val(),
                OrderType: $('#orderTypesTabletLoadingonPlanning').val(),
                deliveryDateTo: $('#deliveryDatesonPlanning2').val(),
                dateTo: $('#deliveryDatesonPlanning2').val(),
                status: $('#statusRoutePlanner').val(),
                productId: $('#prodexclude').val(),
            },
            success: function (data) {
                $('#referenceno').val(data.referenceNo);
                localStorage.removeItem('routeplanner');
                //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});
                localStorage.setItem('routeplanner', JSON.stringify({deliveryDate: $('#deliveryDatesonPlanning').val(),
                    deliveryDateTo: $('#deliveryDatesonPlanning2').val(),routeId: $('#rouTabletLoadingtesonPlanning').val() ,'reference':$('#referenceno').val() }));

                var trHTML = '';
                var style = '';
                var classes = 'onDrag';
                $('#priority').empty();

                var inv = 'id';
                var counter = 0;
                console.debug("**************  referenceNo "+data.referenceNo);

                $.each(data.priority, function (key, value) {

                    if (inv != value.CustomerId)
                    {
                        var k = parseInt(counter)+parseInt(1);
                        trHTML +='<tr ondblclick="this.style.display = none" class="fast_remove" style="font-size: 14px;font-weight: 600;" onclick="show_hide_row(\'hidden_row1'+ k +'\') ;"><td>'+
                            value.StoreName +'</td><td>'+
                            value.orderid +'</td><td>'+
                            value.OrderDate +'</td><td>'+
                            value.DeliveryDate +'</td><td>'+
                            value.OrderNo +'<input type="hidden" class="dontTakeme" value="thisIsIt"></td></tr>';
                        counter++;

                    }
                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" class="hidden_row1'+counter+' hidden_row"><td style="padding: 0px;width: 10%;">'+
                        '<input type="checkbox" name="unique" id ="unique" style="height: 20px !important;width: 50px !important;"  class="unique" value="' +value.OrderDetailId + '" /></td>' +
                        '<td style="padding: 0px;width: 30%;">'+value.PastelDescription+'</td>'+
                        '<td>'+
                        '<input type="number" min="0" style="height: 26px !important; width: 76px;" class="remaining" value="' + parseFloat(value.mnyQtyRemaining).toFixed(2) + '" style="" ><input type="hidden" class="volume" value="' +value.volumes + '" />' +
                        '<input type="hidden" id ="OrderDetailId" class="OrderDetailId" value="' +value.OrderDetailId + '" /> <input type="hidden" class="prodmass" value="' +value.weights + '" /><input type="hidden" class="fltLatitude" value="' +value.fltLatitude + '" /><input type="hidden" class="fltLongitude" value="' +value.fltLongitude + '" /><input type="hidden" class="OwnerID" value="' +value.OwnerID + '" /></td>' +

                        '<td style="padding: 0px;width: 100px;color:red;"> Avl '+ parseFloat(value.Available).toFixed(0)+'</td>'+
                        '<td style="padding: 0px;width: 100px;">'+value.pallaetQty+'</td><input type="hidden" class="infowindow" value="' +value.infowindow + '" /><input type="hidden" class="PastelDescription" value="' +value.PastelDescription + '" />'+
                        '<td style="padding: 0px;width: 100px;"> Wgt '+parseFloat(value.weights).toFixed(1)+'</td>'+
                        '<td style="padding: 0px;width: 100px;"> Vol '+value.volume+'</td>'+
                        '</tr>';
//
                    inv = value.CustomerId


                });
                $('#priority').append(trHTML);
                var trHTML = '';

                $('#allproducts').empty();

                var inv = 'id';
                var counter = 0;
                var qtytotal = 0;
                $.each(data.products, function (key, value) {

                    if (inv != value.ProductId)
                    {
                        var k = parseInt(counter)+parseInt(1);
                        trHTML +='<tr ondblclick="this.style.display = none" class="fast_remove" style="font-size: 14px;" onclick="show_hide_row(\'hidden_row2'+ k +'\') ;"><td style="font-weight: 600;background: '+value.fine+'">'+
                            value.PastelDescription +' </td><td style="color:red"> '+ parseFloat(value.Available).toFixed(0)+
                            '<input type="hidden" class="dontTakeme" value="thisIsIt"></td>'+

                            +'</tr>';
                        counter++;

                    }
                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" class="hidden_row2'+counter+' hidden_row">'+
                        '<td style="padding: 0px;width:50%;">'+value.StoreName+'</td>'+
                        '<td>'+
                        '<input type="number" min="0" style="height: 50px !important;width: 50px;" class="remaining" value="' + parseFloat(value.mnyQtyRemaining).toFixed(2) + '" style="" ></td><td>' +
                        '<input type="hidden" id ="OrderDetailId" class="OrderDetailId" value="' +value.OrderDetailId + '" /> <input type="hidden" id ="ownerId" class="ownerId" value="' +value.OwnerID + '" /><input type="hidden" class="prodmass" value="' +value.weights + '" /><input type="hidden" class="fltLatitude" value="' +value.fltLatitude + '" /><input type="hidden" class="fltLongitude" value="' +value.fltLongitude + '" /></td><td>' +
                        '<input type="checkbox" name ="uniqueallproducts" style="height: 20px !important;width: 50px !important;"  class="unique" value="' +value.OrderDetailId + '" /><input type="hidden" class="volume" value="' +value.volumes + '" /></td>' +
                        '<td style="padding: 0px;width: 100px;">Pallet Qty'+value.pallaetQty+'</td><input type="hidden" class="infowindow" value="' +value.infowindow + '" /> <input type="hidden" class="PastelDescription" value="' +value.PastelDescription + '" />'+
                        '<td style="padding: 0px;width: 100px;"> Wgt '+parseFloat(value.weights).toFixed(1)+'</td>'+
                        '<td style="padding: 0px;width: 100px;"> Vol '+value.volume+'</td>'+
                        '</tr>';

                    qtytotal= qtytotal + parseFloat(value.mnyQtyRemaining).toFixed(2);
                    inv = value.ProductId


                });
                $('#allproducts').append(trHTML);

                $('[name="uniqueallproducts"]').change(function(event) {
                    var returnVal = 0;var vol = 0 ;var i = 0;    //locations[0] =[['here',-25.322148485607237, 28.365571847526194]];
                    $('[name="uniqueallproducts"]:checked').each(function(checkbox) {
                        console.debug($(this).closest('tr').find('.remaining').val());
                        console.debug($(this).closest('tr').find('.prodmass').val());
                        console.debug($(this).closest('tr').find('.PastelDescription').val());

                        returnVal =returnVal + parseFloat($(this).closest('tr').find('.remaining').val()) * parseFloat($(this).closest('tr').find('.prodmass').val());
                        vol = vol + parseFloat($(this).closest('tr').find('.volume').val()) ;
                        console.debug(returnVal);
                        console.debug(vol);

                        $('#totalweight').val(returnVal);
                        $('#totalvol').val(vol);

//infowindow

                        locations[i] = ['testing',$(this).closest('tr').find('.fltLatitude').val() , $(this).closest('tr').find('.fltLongitude').val(),$(this).closest('tr').find('.infowindow').val(),$(this).val(),
                            $(this).closest('tr').find('.PastelDescription').val(),$(this).closest('tr').find('.remaining').val()];
                        i++;
                    });
                    localStorage.removeItem('updateplanmap');
                    localStorage.setItem('updateplanmap', JSON.stringify({locations}));

                  //  initMap();
                });


                $('[name="unique"]').change(function(event) {
                    var returnVal = 0;var vol = 0 ;var i = 0;    //locations[0] =[['Lolest',-25.322148485607237, 28.365571847526194]];
                    $('[name="unique"]:checked').each(function(checkbox) {
                        console.debug($(this).closest('tr').find('.remaining').val());
                        console.debug($(this).closest('tr').find('.prodmass').val());

                        returnVal =returnVal + parseFloat($(this).closest('tr').find('.remaining').val()) * parseFloat($(this).closest('tr').find('.prodmass').val());
                        vol = vol + parseFloat($(this).closest('tr').find('.volume').val()) ;
                        console.debug(returnVal);
                        console.debug(vol);
                        $('#totalweightcust').val(parseFloat(returnVal*1000).toFixed(2));
                        $('#totalvolcust').val(vol);

                        locations[i] = ['testing',$(this).closest('tr').find('.fltLatitude').val() , $(this).closest('tr').find('.fltLongitude').val(),$(this).closest('tr').find('.infowindow').val(),$(this).val(),
                            $(this).closest('tr').find('.PastelDescription').val(),$(this).closest('tr').find('.remaining').val()];
                        i++;
                    });
                    localStorage.removeItem('updateplanmap');
                    localStorage.setItem('updateplanmap', JSON.stringify({locations}));
                     //initMap();
                });


                //coord

            }
        });
    }
    function show_hide_row(row)
    {
        $("."+row).toggle();
    }
    // google.maps.event.addDomListener(window, 'load', initialize);

</script>
<script>

</script>
