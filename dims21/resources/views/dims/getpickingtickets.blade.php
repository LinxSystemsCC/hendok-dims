
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
<h3>List Picking Tickets</h3>

<div class="dx-field" style="display: none;">
    <div class="dx-field-label">DropDownBox with embedded DataGrid</div>
    <div class="dx-field-value">
        <div id="gridBox"></div>
    </div>
</div>

From<input type="date" id="from"> - To<input type="date" id="to"> <button class="" id="getdata">Submit</button>
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
        $('#getdata').click(function(){
            $.ajax({
                url: '{!!url("/jsongetpickingplan")!!}',
                type: "GET",
                data: {
                    from: $('#from').val(),
                    to: $('#to').val()
                },
                success: function (data) {
                    //localStorage.routeplanner = JSON.stringify({name: "John",routeId: $('#rouTabletLoadingtesonPlanning').val(),deliveryDate: $('#deliveryDatesonPlanning').val()});

                    $("#gridContainer").dxDataGrid({
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
                                width: 20,
                                dataField: "intAutoPickingHeader",
                                caption: "Picking ID",
                                visible:false

                            },
                            {
                                width: 150,
                                dataField: "strUnickReference",
                                caption: "Ref NO",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width: 150,
                                dataField: "strPickingNickname",
                                caption: "Picking Name",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width: 150,
                                dataField: "dtm",
                                caption: "Time Created",
                                headerFilter: {
                                    allowSearch: true,
                                }

                            },
                            {
                                width: 150,
                                dataField: "isCancelled",
                                caption: "Status",
                                headerFilter: {
                                    allowSearch: true,
                                },    cellTemplate: function(element, info) {
                                    element.append("<div>" + info.text + "</div>")
                                        .css("background", "#5c95c573")
                                        .css("font-size", "16px")
                                        .css("font-weight", "900");
                                }

                            }



                        ] ,
                        onRowPrepared(e) {
                            if (e.rowType == 'data' && e.data.isCancelled ==1) {
                                e.rowElement.css('background', 'red');
                            }


                        },
                        onRowClick: function (e) {
                            window.open('{!!url("/pickingplanlist")!!}/'+e.data.strUnickReference, "strUnickReference", "location=1,status=1,scrollbars=1, width=1200,height=850");
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
    });

</script>
</div>
</body>
</html>
