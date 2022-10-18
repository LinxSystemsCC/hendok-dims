
<!DOCTYPE html>

<html>
<head>
    <script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ... -->
    <!-- DevExtreme themes -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <link rel="stylesheet" href="{{ asset('css/jquery-ui2.min.css') }}" type="text/css" />
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


    <style>
        .dx-datagrid{
            font:10px verdana;
        }

    </style>
</head>
<body style="font-family: Sans-serif">
<h3>Awaiting Stock By Customer</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

<div style="display: flex;">
    <div id="gridorders" style="height: 800px;width: 100% !important;"></div>
    <div>
        <label>Machine</label>

    </div>


</div>
<script>

    $( document ).on( 'focus', ':input', function(){

        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#refresh").click(function () {
            location.reload();

        });
        getIemToInitiate();



    });

    function getIemToInitiate(){

        $.ajax({
            url: '{!!url("/jsoninitiateitems")!!}',
            type: "GET",
            data: {
                productId:1
            },
            success: function (data) {
                //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});

                $("#gridorders").dxDataGrid({
                    dataSource:data,
                    showBorders: true,

                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: false
                    }
                    ,columnWidth:200,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        {
                            width: 100,
                            dataField: "itemCode",
                            caption: "Item Cdoe",
                        },
                        {
                            width: 100,
                            dataField: "ItemDescription",
                            caption: "Item Description",

                        },
                        {
                            width: 150,
                            dataField: "PalletSize",
                            caption: "Pallet Size",


                        }
                    ] ,
                    onRowClick: function (e) {

                        console.debug("Rather beeeeeeeeeeeeeeeeeeeee onClick");
                        console.debug(e);
                        // getordersmappedtoproduct(e.data.orderid)

                    },
                    onCellClick: function (e) {
                        console.debug("cell beeeeeeeeeeeeeeeeeeeee double click ");
                        console.debug(e.data);
                        // Handles the "cellClick" event
                    },

                    onInitNewRow: function(e) {
                        console.debug("InitNewRow");
                    },
                    onRowInserting: function(e) {
                        console.debug("RowInserting");
                    },
                    onRowInserted: function(e) {
                        console.debug("RowInserted");
                    },
                    onRowUpdating: function(e) {
                        console.debug("RowUpdating");
                    }
                });

            }
        });
    }
</script>
</div>
</body>
</html>
