
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
<h3>Flex Picking Plan</h3>
<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

<div id="gridContainer" style="height: 800px;width: 100% !important;"/>

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
        $.ajax({
            url: '{!!url("/jsonWarehouseGrid")!!}',
            type: "GET",
            data: {
                routeId: 1
            },
            success: function (data) {
            $("#gridContainer").dxDataGrid({
            dataSource:data,
            showBorders: true,
            selection: {
                mode: 'multiple',
            },

            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            paging: {
                enabled: true
            }
            ,
            editing: {
                mode: "cell",
                allowUpdating: true,
                selectTextOnEditStart: true,
                startEditAction: 'click',
                allowDeleting: false,
                confirmDelete: false
            }
            ,columnWidth:200,
            columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
            columns: [
                {
                    width: 90,
                    dataField: "Code",
                    caption: "Item Code",
                    visible: false

                },
                {
                    width: 300,
                    dataField: "productName",
                    caption: "Product Name"

                },
                {
                    width:300,
                    dataField: "groupone",
                    groupIndex: 0,
                    caption: "Group 1",

                    headerFilter: {
                        allowSearch: true,
                    }

                },
                {
                    width:300,
                    dataField: "grouptwo",

                    caption: "Group 2",

                    headerFilter: {
                        allowSearch: true,
                    }

                },

                {
                    width: 80,
                    dataField: "groupthree",
                    caption: "Group 3",

                    headerFilter: {
                        allowSearch: true,
                    },

                }, {
                    dataField: "dteExpiryDate",
                    caption: "Expiry Date", width: 80, dataType: "date"

                }
                ,{
                    width: 80,
                    dataField: "QtyOnHand",
                    caption: "OnHand",dataType:"number"

                }
                ,
                {
                    width:100,
                    dataField: "scannedLocation",
                    caption: "Scanned Location",
                    headerFilter: {
                        allowSearch: true,
                    }

                }

            ] ,
            onRowClick: function (e) {



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
    });

</script>
</div>
</body>
</html>
