
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
<h3>Customer Lookup</h3>
<div>

    <div class="dx-field-value" style="width: 100%;">
        <div style="width: 100%;" id="gridBox"></div>
    </div>
    <div id="gridContainer" style="height: 800px;"/>
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

        $.ajax({
            url: '{!!url("/customerarealookupjson")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {

                $("#gridContainer").dxDataGrid({
                    dataSource:data,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: true
                    }
                    ,columnWidth:200,
                    columnAutoWidth:true,        allowColumnResizing: true,       columnResizingMode: "nextColumn",
                    columns: [
                        // columns: ['Account', 'Name','areaname','RouteName','companyName'],
                        {
                            width: 90,
                            dataField: "Account",
                            caption: "Account Code",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            width: 300,
                            dataField: "Name",
                            caption: "StoreName",
                            visible:true

                        },
                        {
                            width: 300,
                            dataField: "areaname",
                            caption: "Area",
                            headerFilter: {
                                allowSearch: true,
                            }

                        }
                        ,{
                            width: 300,
                            dataField: "RouteName",
                            caption: "Route Name",
                            headerFilter: {
                                allowSearch: true,
                            }

                        }
                        ,{
                            width: 300,
                            dataField: "companyName",
                            caption: "Company Name",
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
