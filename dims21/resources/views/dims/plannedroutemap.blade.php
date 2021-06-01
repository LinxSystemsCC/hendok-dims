@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%;display:none;">

    </div>
    <div class="col-lg-12">

        <div id="map" style="height: 95%;" class="col-lg-8"></div>
        <div id="myplan" style="height: 80%;background: white;overflow: scroll;" class="col-lg-4">
            <h4 style="text-align: center" >My Plan</h4>

            <table id="tblplannedprogress" class="table table-bordered">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Product Name</th>
                    <th>Quantity</th>

                </tr>
                </thead>
                <tbody id="plannedprogress">

                </tbody>
            </table>
        </div>
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

    var getlocations =[['Lolest',-25.322148485607237, 28.365571847526194]];

    window.onstorage = event => { // same as window.addEventListener('storage', event => {

        if (event.key == 'updateplanmap'){
            getlocations =[['Lolest',-25.322148485607237, 28.365571847526194]];
            console.debug(event.key + ':' + event.newValue + " at " + event.url);
            let loc = JSON.parse(event.newValue);
            var index = 0;
            for(var p= 0; p < JSON.parse(event.newValue).locations.length;p++)
            {

                getlocations[index] = ['testing',loc.locations[p][1], loc.locations[p][2],loc.locations[p][3],loc.locations[p][4],loc.locations[p][5],loc.locations[p][6]];
                index++;
            }
            console.debug(getlocations);
            initMap()
            var trHTML = '';
            $('#plannedprogress').empty();

            for(var z=0;z <getlocations.length;z++){
                trHTML +='<tr style="font-size: 12px;color: black;background: lightgrey;font-family: Roboto;font-weight: normal;" ><td><input type="checkbox" name ="uniqueallproducts" style="height: 20px !important;width: 50px !important;"  class="unique" value="' +getlocations[z][4] + '" checked /></td>'+
                    '<td style="">'+getlocations[z][5]+'</td>'+
                    '<td>'+
                    '<input type="number" min="0" style="height: 28px !important;font-weight: 900;" class="Qty" value="' + parseFloat(getlocations[z][6]).toFixed(2) + '" style=""  >' +
                    '<input type="hidden" id ="orderdetailId" class="orderdetailId" value="' +getlocations[z][4] + '" /></td>' +
                    '' +
                    '</tr>';
            }




            $('#plannedprogress').append(trHTML);

        }


    };
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

        $('#refresh').click(function(){
            //    initMap();
            getMultiRoutSelected();
        });






    });
    function initMap() {


        console.debug(getlocations );
        var mapCanvas = document.getElementById('map');
        var myLatLng = {
            lat: -29.7010308,
            lng: 30.9727855
        };
        var mapOptions = {
            center: new google.maps.LatLng(-29.70241380322234, 31.006679369429087),
            zoom: 6.25,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);

        var marker, i;

        for (i = 0; i < getlocations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(getlocations[i][1], getlocations[i][2]),
                map: map
            });
            var infowindow = new google.maps.InfoWindow({
                content:"" + i,
                maxWidth: 200
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(getlocations[i][2]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
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

        $.ajax({
            url: '{!!url("/getcustomergeneralplanmap")!!}',
            type: "POST",
            data: {
                routeId: $('#rouTabletLoadingtesonPlanning').val(),

            },
            success: function (data) {

                var i = 1;
                locations[0] =[['Lolest',-25.322148485607237, 28.365571847526194]];
                $.each(data.coord, function (key, value) {
                    // console.debug(value.fltLatitude+','+value.fltLongitude);
                    locations[i] = ['Test',value.fltLatitude,value.fltLongitude];
                    i++;
                });

                initMap();
                //coord

            }
        });
    }




</script>
<script>

</script>
