<!doctype html>
<html lang="en">
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
		<title>Orders</title>
		<link rel="icon" href="{{asset('images/1024.png')}}" type="image/icon type">
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
        <!-- DevExtreme theme -->
        {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet">
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

        <style>
            .dx-datagrid-rowsview .dx-selection.dx-row:not(.dx-row-focused):not(.dx-row-removed) > td {
                background-color: rgb(248, 243, 155);
                color: unset;
            }
        </style>


	</head>
	<body>
        <div class="col-md-12 ms-sm-auto col-lg-12" style="padding:0px !important; height:95vh;">
            <header style="height:7%;" class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 pr-3 shadow">
                <h1 id="stats" style="padding: 10px;">ORDERS</h1><br>
                <button class="btn btn-success mx-3" id="commit">COMMIT ORDER</button>
            </header>

            <div id="orderheader" style="width: 100% !important; height:43%;">
            </div>

            <header style="height:7%;" id="orderlinesheader" class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 pr-3 shadow">
                <h1 style="padding: 10px;">ORDER LINES</h1>  
            </header>

            <div id="orderlines" style="width: 100% !important; height:43%;">
            </div>

		</div>

	</body>
</html>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="{{asset('js/main.js')}}"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('focus', ':input', function() {
        $(this).attr('autocomplete', 'off');
    });
	
    $(document).ready(function() {     
        $('#orderlinesheader').hide();

        ordersFunction();

        $('#commit').click(function() {
            var lines = $("#orderheader").dxDataGrid("instance");
            var row = lines.getSelectedRowKeys();
            // console.debug(row);
            alert("Order '"+row[0]["ID"]+"' Line will be committed");
        });
        
	});

    function ordersFunction(){
        $.ajax({
            url: '{!!url("/getBriefcaseBackorderHeaders")!!}',
            type: "GET",
            data: {
            },
            success: function (data) {
                $("#orderheader").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    noDataText: 'Orders have not been placed between the date range specified',
                    scrolling: {
                        mode: 'infinite',
                    },
                    paging:{
                        pageSize: 20,
                    },
                    selection: {
                        mode: 'single',
                    },

                    columns: [
                        {
                            dataField: "ID",
                            caption: "ID",
                        }, 
                        {
                            dataField: "CustomerCode",
                            caption: "Customer Code",
                        }, 
                        {
                            dataField: "StoreName",
                            caption: "Store Name",
                        }, 
                        {
                            dataField: "DeliveryDate",
                            caption: "Delivery Date",
                            dataType: "date",
                            format: 'dd-MM-yyyy',
                        },
                        {
                            dataField: "OrderNumber",
                            caption: "Order Number",
                        },
                        {
                            dataField: "UserName",
                            caption: "User Name",
                        },
                        {
                            dataField: "Notes",
                            caption: "Notes",
                        },
                        {
                            dataField: "DeliveryAddressID",
                            caption: "Delivery Address ID",
                        },
                        {
                            dataField: "Route",
                            caption: "Route",
                        },
                        {
                            dataField: "OrigOrderID",
                            caption: "Original Order ID",
                        },
                        {
                            dataField: "bitBackOrder",
                            caption: "is Back Order",
                        },
                    ],

                    onRowClick:function(e){
                        $('#orderlinesheader').show();
                        var headerID = e.data.ID

                        $.ajax({
                            url: '{!!url("/getBriefcaseBackorderLines")!!}',
                            type: "GET",
                            data: {
                                ID : headerID,
                            },
                            success: function (data) {
                                //console.debug(data);
                                
                                const orderlines = $("#orderlines").dxDataGrid({
                                    dataSource:data, //as json
                                    showBorders: true,
                                    hoverStateEnabled: true,
                                    filterRow: { visible: true },
                                    filterPanel: { visible: true },
                                    headerFilter: { visible: true },
                                    allowColumnResizing: true,
                                    columnAutoWidth: true,
                                    scrolling: {
                                        mode: 'infinite',
                                    },
                                    paging:{
                                        pageSize: 20,
                                    },
                                    selection: {
                                        mode: 'single',
                                    },

                                    columns: [
                                        {
                                            dataField: "strPartNumber",
                                            caption: "Part Number",
                                        }, 
                                        {
                                            dataField: "PastelDescription",
                                            caption: "Description",
                                        }, 
                                        {
                                            dataField: "OrigQty",
                                            caption: "Original Quantity",
                                        },
                                        {
                                            dataField: "Quantity",
                                            caption: "Qty",
                                        }, 
                                        {
                                            dataField: "Price",
                                            caption: "Price",
                                        }, 
                                        {
                                            dataField: "Vat",
                                            caption: "Vat",
                                        },
                                        {
                                            dataField: "VatPrice",
                                            caption: "Vat Price",
                                        },
                                        {
                                            dataField: "LineTotal",
                                            caption: "Total",
                                        },
                                        {
                                            dataField: "strComment",
                                            caption: "Comments",
                                        },
                                    ],
                                });
                            }
                        });
                    },
                    onRowPrepared: function(e) {
                        if (e.rowType === "data") {
                            if (e.data.UserName !== "FoodSupplyNetwork") {
                            e.rowElement.css("backgroundColor", "rgb(155, 236, 248)");
                            }
                        }
                    },
                });
            }
        });
    };
</script>

<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>

