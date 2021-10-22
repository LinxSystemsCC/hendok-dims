@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;display:none;">

    </div>
    <div class="col-lg-12">


        <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="deliveryDatesonPlanning"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">From</label>
            <input name="deliveryDatesonPlanning" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning"  >
        </div>
        <div class="form-group  col-md-2" style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">
            <label class="control-label" for="deliveryDatesonPlanning2"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">To</label>
            <input name="deliveryDatesonPlanning2" class="form-control input-sm col-xs-1" id="deliveryDatesonPlanning2"  >
        </div>
        <button id="refresh" class="btn-success btn-lg btn">GET</button>
        <input id="referenceno" readonly>
        <br>
    </div>
    <div class="col-lg-12">

        <div id="map" style="height: 100%;" class="col-lg-8"></div>
        <div id="info"  class="col-lg-4">
            <div style="height: 45%;overflow-y: scroll;background: white;font-family: sans-serif;font-weight: normal">
            <table id="tblonthatcluster" class="table table-bordered">
                <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Weight</th>

                </tr>
                </thead>
                <tbody id="onthatcluster">

                </tbody>
            </table>
        </div>
            <div style="height: 50%;overflow-y: scroll;">
                <h4>Products On A Marker</h4>
                <input id="customername" style="font-family: Roboto;font-weight: bold;color: black;" class="form-control input-sm col-xs-1">
                <table id="tblonamaker" class="table table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Order Id</th>
                        <th>Customer Name</th>
                        <th>Qty</th>
                        <th>Weight</th>

                    </tr>
                    </thead>
                    <tbody id="onamarker">

                    </tbody>
                </table>

                <button id="planorder" class="btn btn-primary btn-lg pull-right">Plan This Order</button>
            </div>

        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5vAgb-nawregIa5gRRG34wnabasN3blk&callback=initMap&libraries=&v=weekly"
            async></script>
    <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>

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

    var locations =[['Lolest',-25.322148485607237, 28.365571847526194]];
    var routes ='';

    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) return false;
    });
    window.onstorage = event => { // same as window.addEventListener('storage', event => {

        if (event.key == 'routeplanner'){
            console.debug(event.key + ':' + event.newValue + " at " + event.url);
            let dates = JSON.parse(event.newValue);

            $("#deliveryDatesonPlanning").val(dates.deliveryDate);
            $("#deliveryDatesonPlanning2").val(dates.deliveryDateTo);
            $("#referenceno").val(dates.reference);
            routes = dates.routeId;
            getMultiRoutSelected();
        }


    };
    $(document).ready(function() {



        //localStorage.setItem('now', Date.now());
        //alert( localStorage.getItem('test') );
        //$('#routePlanningPopUp').hide();
        $('#orderListing').hide();
        $('#planorder').hide();
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

        $("#deliveryDatesonPlanning,#deliveryDatesonPlanning2").datepicker({
            changeMonth: true,//this option for allowing user to select month
            changeYear: true,
            dateFormat: 'yy-mm-dd' });
        //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        getMultiRoutSelected();
        $('#refresh').click(function(){
            //    initMap();
                getMultiRoutSelected();
        });

        $('#planorder').click(function(){
            //    initMap();

            var checkedLines = new Array();

            $('[name="uniqueallproducts"]:checked').each(function(checkbox) {
                // selected.push(checkbox);
                var id = $(this).val();
                checkedLines.push({
                    'orderdetail': id,
                    'qty': $(this).closest('tr').find('.Qty').val(),
                    'pickingtype':'priority',
                    'ownerId':$(this).closest('tr').find('.ownerId').val(),
                    'referenceNo':$('#referenceno').val()
                });

            });
            console.debug(checkedLines);
            $.ajax({
                url: '{!!url("/saveplan")!!}',
                type: "POST",
                data: {

                    referenceno: $('#referenceno').val(),
                    priority: checkedLines
                },
                success: function (data) {

                    var dialog = $('<p><strong style="color:red">Data Saved</strong></p>').dialog({
                        height: 200, width: 700,modal: true,containment: false,
                        buttons: {
                            "Okay": function () {
                                $('#onamarker').empty();
                                dialog.dialog('close');
                            }
                        }
                    });


                }
            });
         /*  var storages = [];
                var returnVal = 0;var vol = 0 ;var i = 0;    //locations[0] =[['here',-25.322148485607237, 28.365571847526194]];
                $('[name="uniqueallproducts"]:checked').each(function(checkbox) {
                    storages[i] = ['testing',$(this).closest('tr').find('.lat').val() , $(this).closest('tr').find('.lon').val(),$(this).closest('tr').find('.PastelDescription').val(),$(this).val(),
                        $(this).closest('tr').find('.PastelDescription').val(),$(this).closest('tr').find('.Qty').val()];
                    i++;
                });
                localStorage.removeItem('updateplanmap');
                localStorage.setItem('updateplanmap', JSON.stringify({storages}));*/


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
            zoom: 6,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);

        var marker, i;
        var markers = [];
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                mass: locations[i][3],
                storename: locations[i][4]
            });
            var infowindow = new google.maps.InfoWindow({
                content:"" + i,
                maxWidth: 200
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][4]);
                    infowindow.open(map, marker);
                    $('#customername').val(locations[i][4]);
                    console.debug(this);
                    console.debug(locations);
                    this.setIcon(pinSymbol('blue'));
                    getProductsOnAMarker(locations[i][5],locations[i][1], locations[i][2]);
                    //onamarker
                }
            })(marker, i));

           /* var markerCluster = new MarkerClusterer(map, marker, {
                averageCenter: true,
            });*/
            markers.push(marker);
        }
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});


        google.maps.event.addListener(markerCluster, "click", function (c) {
            console.debug("click: ");
            console.debug("&mdash;Center of cluster: " + c.getCenter());
            console.debug("&mdash;Number of managed markers in cluster: " + c.getSize());

            var m = c.getMarkers();

            var p = [];
            $('#onthatcluster').empty();
            var trHTML = '';
            for (var i = 0; i < m.length; i++) {




                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey" >'+
                        '<td style="">'+m[i].storename+'</td>'+
                        '<td>'+m[i].mass+'</td>'+
                        '</tr>';




                console.debug(m[i]);
                p.push(m[i].getPosition());
            }

            $('#onthatcluster').append(trHTML);
            console.debug("&mdash;Locations of managed markers: " + p.join(", "));
        });
        google.maps.event.addListener(markerCluster, "mouseover", function (c) {
            /*console.debug("mouseover: ");
            console.debug("&mdash;Center of cluster: " + c.getCenter());
            console.debug("&mdash;Number of managed markers in cluster: " + c.getSize());*/
        });
        google.maps.event.addListener(markerCluster, "mouseout", function (c) {
           /* console.debug("mouseout: ");
            console.debug("&mdash;Center of cluster: " + c.getCenter());
            console.debug("&mdash;Number of managed markers in cluster: " + c.getSize());*/
        });
        //  addMarker(myLatLng, map);

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

        console.debug(routes);
        locations = [];
        $.ajax({
            url: '{!!url("/getcustomergeneralplanmap")!!}',
            type: "POST",
            data: {
                From: $('#deliveryDatesonPlanning').val(),
                To: $('#deliveryDatesonPlanning2').val(),
                routeId: routes

            },
            success: function (data) {

                var i = 1;
                locations[0] =[['Lolest',-25.322148485607237, 28.365571847526194,'0','']];
                $.each(data.coord, function (key, value) {
                    // console.debug(value.fltLatitude+','+value.fltLongitude);
                    locations[i] = ['Test',value.fltLatitude,value.fltLongitude,value.Mass,value.StoreName,value.orderId];
                    i++;
                });

                initMap();
                //coord

            }
        });
    }
    function pinSymbol(color) {
        return {
            path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
            fillColor: color,
            fillOpacity: 1,
            strokeColor: '#000',
            strokeWeight: 2,
            scale: 1
        };
    }
    function getProductsOnAMarker(orderid,lat,lon)
    {
        $.ajax({
            url: '{!!url("/productsonamarker")!!}',
            type: "POST",
            data: {

                orderid:  orderid

            },
            success: function (data) {

                var trHTML = '';

                $('#onamarker').empty();
                $('#planorder').show();
                $.each(data, function (key, value) {
                    trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey;font-family: Roboto;font-weight: normal" ><td><input type="checkbox" name ="uniqueallproducts" style="height: 20px !important;width: 50px !important;"  class="unique" value="' +value.OrderDetailId + '" checked /></td>'+
                        '<td style="">'+value.OrderId+'</td>'+
                        '<td style="">'+value.PastelDescription+'</td>'+
                        '<td>'+
                        '<input type="number" min="0" style="height: 25px !important;font-weight: 900" class="Qty" value="' + parseFloat(value.mnyQtyRemaining).toFixed(2) + '" style="" >' +
                        '<input type="hidden" id ="orderdetailId" class="orderdetailId" value="' +value.OrderDetailId + '" /><input type="hidden" id ="lat" class="lat" value="' +lat + '" /><input type="hidden" id ="ownerId" class="ownerId" value="' +value.ownerId + '" /><input type="hidden" id ="lon" class="lon" value="' +lon + '" /></td>' +
                        '<input type="hidden" id ="PastelDescription" class="PastelDescription" value="' +value.PastelDescription + '" /><td style="">'+ parseFloat(value.weights).toFixed(2)+'</td>'+
                        '</tr>';

                });

                $('#onamarker').append(trHTML);
            }
        });
    }


</script>
<script>

</script>
