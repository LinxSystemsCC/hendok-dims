<!DOCTYPE html>
<html>
<head>
 <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <script src="{{ asset('js/ag_grid.js') }}"></script>
    <script src="{{ asset('public/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />

    <style>
        .rag-red {
            background-color: lightcoral;
        }
        .rag-green {
            background-color: lightgreen;
        }
        .rag-amber {
            background-color: lightsalmon;
        }

        .rag-red-outer .rag-element {
            background-color: lightcoral;
        }

        .rag-green-outer .rag-element {
            background-color: lightgreen;
        }

        .rag-amber-outer .rag-element {
            background-color: lightsalmon;
        }

    </style>
</head>
<body>
<div class="col-md-12" >
 <div class="col-md-3">
    <h5>{{$ot}}</h5>
    <h5>{{$route}}</h5>
    <label>Driver Name</label><br>
 <select id="driverid" >
     @foreach($drivers as $val)
     <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
         @endforeach
 </select><br>
    <label>Van Assistant</label><br>
    <select id="assistantid" >
        @foreach($drivers as $val)
            <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
        @endforeach
    </select><br>
    <label>Truck Name</label><br>
    <select id="truckid" >
        @foreach($trucks as $val)
            <option value="{{$val->TruckId}}">{{$val->RegNo}}</option>
        @endforeach
    </select><br>
    <label>Dispatch Area</label><br>
    <select id="dispatchid" >
        @foreach($dispatch as $val)
            <option value="{{$val->intAutodispatchlocations}}">{{$val->strDoorName}}</option>
        @endforeach
    </select><br>
    <button id="finish" class="btn-success btn-md" value="{{$routingId}}">SUBMIT</button>
	</div>
    <div class="col-md-3">
        <table>
            <tr>
                <td>Driver signed for stock</td>
                <td>Data still Loading</td>
            </tr>
            <tr>
                <td>KM OUT</td>
                <td>Data still Loading</td>
            </tr>
            <tr>
                <td>KM IN</td>
                <td>Data still Loading</td>
            </tr>
            <tr>
                <td>Time Ended The Trip</td>
                <td>Data still Loading</td>
            </tr>
        </table>

    </div>
	  <div class="col-md-6">
        <h5>ROUTE INFORMATION</h5>
        @foreach($routinginfo as $val)
        <input type="text" name="routename" id="routename" value="{{$val->Route}}">
        <input type="text" name="ordertype" id="ordertype" value="{{$val->OrderType}}">
        <input type="text" name="deliverytype" id="deliverytype" value="{{$val->DeliveryDate}}">
        @endforeach

        <table id="infotable">
            <thead>
            <th>STOP NAME</th>
            <th>OFFLOADED TIME</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="col-md-12" >
<div id="myGrid" style="height: 700px;width:95%;" class="ag-theme-balham"></div>
</div>

<script type="text/javascript" charset="utf-8">

    $(document).ready(function() {


        $('#finish').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{!!url("/updatelogisticsinformation")!!}',
                type: "GET",
                data: {
                    routingid: $('#finish').val(),
                    driverid: $('#driverid').val(),
                    assistantid: $('#assistantid').val(),
                    truckid: $('#truckid').val(),
                    dispatchid: $('#dispatchid').val()
                },
                success: function (data) {
					alert("Please don't forget to click SUBMIT button to refresh data");
                    close();

                   /* console.debug(data.length);
                    if(data.length > 0)
                    {
                        alert("Deleted");
                        close();
                    }
                    console.debug(data[0].Result);*/
                    //
                    //location.reload(true);

                }
            });
        });
		
		  routeInfo($('#routename').val(),$('#ordertype').val(),$('#deliverytype').val());
    });

	function routeInfo(route,ordertype,deldate)
    {
//infotable
			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            url: '{!! url("/getLiveDriversInfo") !!}',
            type: "POST",
            data: {

                route: route,
                ordertype: ordertype,
                deldate: deldate

            },success: function (data) {
                var trHTML = '';
                $('#infotable tbody').empty();

                $.each(data, function (key, value) {
                    var classes = 'onDrag';

                    if (value.offloaded ==1)
                    {
                        classes = 'onDrag backgroudcolorOffloaded';
                    }
                    trHTML += '<tr class="'+classes+'" style="font-size: 15px;color:black"><td>' +
                        value.StoreName + '</td><td>' +
                        value.dteOffloadedTime + '</td>' +
                        '</tr>';

                });
                $('#infotable tbody').append(trHTML);
            }
        });
    }
	 var columnDefs = [
        {headerName: "OrderId", field: "OrderId",width: 90},
        {headerName: "Item Code", field: "PastelCode",width: 180},
        {headerName: "Description", field: "PastelDescription",width: 200},
        {headerName: "Reason", field: "strCustomerReason",width: 100},
        {headerName: "Return Qty", field: "returnQty",width: 90},
        {headerName: "Qty", field: "Qty",width: 90},
        {headerName: "Qty Picked", field: "fltQtyPicked",width: 90},
        {headerName: "StoreName", field: "StoreName",width: 90},
        {headerName: "Customer Code", field: "CustomerPastelCode",width: 150},
        {headerName: "Route(Area)", field: "Route",width: 150},
        {headerName: "Type", field: "OrderType",width: 150},
        {headerName: "Reg No", field: "RegNo",width: 150},
        {headerName: "Driver Name", field: "DriverName",width: 150},
        {headerName: "Dispatch Auth By", field: "strDispatchReturnsAuthBy",width: 150},
        {headerName: "Order Offloaded Time", field: "dteOffloadedTime",width: 100},
        {headerName: "Requisition server time", field: "dteLineRequisition",width: 100},
        {headerName: "OrderDetailId", field: "OrderDetailId",width: 100,hide: true},
    ];

    // let the grid know which columns and what data to use
    var gridOptions = {
        columnDefs: columnDefs,
        floatingFilter: true,
        enableSorting: true,
        enableFilter: true,
        enableColResize: true,
        onRowDoubleClicked: doSomething
    };
    var Odate = new Date();
    var newODate = $.datepicker.formatDate('dd-mm-yy', new Date(Odate));
    var eGridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(eGridDiv, gridOptions);
    var routingid = $('#finish').val();

    fetch('{!!url("/driverreq_perrouteJson")!!}/' + routingid).then(function (response) {
        return response.json();
    }).then(function (data) {
        gridOptions.api.setRowData(data);
    });
    function doSomething(row){
        console.log(row);
        console.log(row.data.OrderDetailId);
        var OrderDetailId = row.data.OrderDetailId;

        window.open('{!!url("/checkingDriversStockAndComment")!!}/'+OrderDetailId , OrderDetailId, "location=1,status=1,scrollbars=1, width=1200,height=850");

    }

</script>
</body>
</html>