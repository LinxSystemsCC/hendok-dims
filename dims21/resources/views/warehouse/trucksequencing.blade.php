<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.compact.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <style>
        .dx-datagrid-table{
            font-size:15px;
        }

        .dx-datagrid .dx-link {
            color: #df2413;
        }

        .dx-pager .dx-page-sizes .dx-selection, .dx-pager .dx-pages .dx-selection {
            font-weight: 500;
            background-color: #df2413;
            color: #fff;
        }

        .dx-datagrid-filter-panel .dx-datagrid-filter-panel-text {
            color: #df2413;
            font-size: 14px;
            line-height: 18px;
        }

        #gridContainer{
            height: calc(100vh - 87px);
            max-height: calc(100vh - 87px);
        }

        .dx-selection {
            font-weight: 700;
            /* Additional styles */
        }

        .master-detail-caption {
            padding: 0 0 5px 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .customPadding {
            padding: 3px !important;
        }

    </style>

</head>
<body>
    <div class="col-12 d-flex px-0"  style="background: white;">
        <div class="col-custom-2"  style="background: white;">
            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>
        <div class="col p-3" >
            <div class="col-lg-12 d-inline-flex mb-1" >
                <h3 style="flex-grow: 1; padding-left: 15px;">Truck Loads</h3>


            </div>

            <div id="gridContainer"></div>

        </div>
    </div>


</body>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Excel Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
<script src="https://cdn3.devexpress.com/jslib/22.2.3/js/dx.aspnet.data.js"></script>


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
            getData();
        });


    });

    function getData(){
        var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization

        $.ajax({
            url: '{!!url("/jsongettrucksequencingbyteamleader")!!}',
            type: "GET",
            data: {
                date: $('#from').val(),
                teamleaderId: $('#to').val()
            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
                    dataSource:data,
                    keyExpr: 'strUnickReference',
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: false
                    },
                    selection: {
                        mode: "single",
                    },
                    columnAutoWidth:true,
                    allowColumnResizing: true,
                    columnResizingMode: "nextColumn",
                    columns: [
                        {
                            dataField: "dtm",
                            caption: "Time Created",
                        },
                        {
                            dataField: "intAutoPickingHeader",
                            caption: "Load No.",
                            calculateCellValue: function(data) {
                                return "TL" + data.intAutoPickingHeader;
                            },
                        },
                        {
                            dataField: "strUnickReference",
                            caption: "Ref No.",
                            visible: false,
                        },
                        {
                            width: 150,
                            dataField: "strPickingNickname",
                            caption: "Route Name",
                        },
                        {
                            dataField: "intTeamLeaderId",
                            caption: "Team Leader ID",
                            visible: false,
                        },
                        {
                            dataField: "strTeamLeader",
                            caption: "Team Leader",
                        },
                        {
                            dataField: "strTrailorNo",
                            caption: "Horse",
                        },
                        {
                            dataField: "strTrailorone",
                            caption: "Trailor One",
                        },
                        {
                            dataField: "strTrailortwo",
                            caption: "Trailor Two",
                        },
                        {
                            dataField: "intDriverOne",
                            caption: "Driver One",
                            visible: false,
                        },
                        {
                            dataField: "strDriverOne",
                            caption: "Driver One",
                        },
                        {
                            dataField: "intDriverTwo",
                            caption: "Driver Two",
                            visible: false,
                        },
                        {
                            dataField: "strDriverTwo",
                            caption: "Driver Two",
                        },
                        {
                            dataField: "strTicket",
                            caption: "Ticket Number",
                        },
                        {
                            dataField: "statustext",
                            caption: "Status",
                            cellTemplate: function(element, info) {
                                element.append("<div>" + info.text + "</div>")
                                    .css("font-size", "16px")
                                    .css("font-weight", "900");
                            }
                        },
                        {
                            dataField: "intStatus",
                            caption: "Completed",
                            cellTemplate: function (container, options) {
                                const value = options.data.intStatus;
                                // console.log(value);
                                container.addClass("customPadding"); // Add the no-padding class to the container

                                if (value === "0") {
                                    const button = $("<button class='btn btn-secondary btn-sm w-100'>").text("Complete").on("click", function() {
                                        completeTruckLoad(options.data.strUnickReference);
                                    });
                                    container.append(button);
                                } else {
                                    const button = $("<button class='btn btn-secondary btn-sm w-100' disabled>").text("Complete")
                                    container.append(button);
                                }
                            },
                            width: 100,
                        },
                    ],
                    masterDetail: {
                        enabled: true,
                        template(container, options) {
                            const lineData = options.data;
                            const detailGrid = $('<div>')
                            .dxDataGrid({
                                dataSource: {
                                    load: function(loadOptions) {
                                        return $.ajax({
                                            url: '{!!url("/teamLeaderGetPickingPlanToInvoice")!!}',
                                            method: 'GET',
                                            data: { ref: options.data.strUnickReference },
                                            xhrFields: { withCredentials: true },
                                        });
                                    },
                                    update: function (key, values) {
                                        detailGrid.dxDataGrid('instance').refresh();
                                    },
                                },
                                editing: {
                                    mode: 'batch',
                                    allowUpdating: true,
                                },
                                showBorders: true,
                                columns: [
                                    {
                                        dataField: "intAutoPicking",
                                        caption: "ID",
                                        visible: false,
                                    },
                                    {
                                        dataField: "StoreName",
                                        caption: "Store Name",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "areas",
                                        caption: "Area",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "OrderDate",
                                        caption: "Order Date",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "OrderNum",
                                        caption: "SO Number",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "ExtOrderNum",
                                        caption: "Instructions",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "iLineID",
                                        caption: "Line No",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "PastelCode",
                                        caption: "Code",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "PastelDescription",
                                        caption: "Description",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "mnyQty",
                                        caption: "Quantity",
                                        allowEditing: false,
                                    },
                                    {
                                        dataField: "weightPlanned",
                                        caption: "Weight",
                                        allowEditing: false,
                                    },
                                    {
                                        // dataField: "ubARIBT",
                                        dataField: "mnyLoadedQty",
                                        caption: "To Invoice",
                                        allowEditing: false,
                                    },{
                                        dataField: "isPriorityLine",
                                        caption: "Priority",
                                        lookup: {
                                            dataSource: [
                                                { value: '1', text: 'Yes' },
                                                { value: '0', text: 'No' },
                                            ],
                                            valueExpr: "value",
                                            displayExpr: "text",
                                        },
                                    },
                                ],
                                onRowPrepared: function(e) {

                                    if (e.rowType === "data") {
                                        if (e.rowIndex % 2 === 0) {
                                            e.rowElement.css("background-color", "#e6e6e6"); // Even row background color
                                        } else {
                                            e.rowElement.css("background-color", "#c3c3c3"); // Odd row background color
                                        }
                                    }
                                },
                                onRowUpdating: function(e) {

                                    $.ajax({
                                        url: '{!!url("/truckLoadUpdatePriortiyStatus")!!}',
                                        method: 'POST', // or 'POST' depending on your API design
                                        data: {
                                            intAutoPicking: e.oldData.intAutoPicking,
                                            isPriorityLine:  e.newData.isPriorityLine,
                                        },
                                        success: function(response) {

                                        },
                                    });

                                }
                            }).appendTo(container);
                        },
                    },
                    onRowPrepared(e) {
                        if (e.rowType == 'data' && e.data.isCancelled ==1) {
                            e.rowElement.css('background', 'red');
                        }
                    },
                    onRowClick: function (e) {
                        // console.log(e.data);

                        getInstructions(e.data.strUnickReference).then(function(instructions) {
                            // console.log(instructions);
                            instructions.forEach(function(instruction) {
                                if (instruction.strType == 'Notes') {
                                    $("#notes").val(instruction.strInstruction);
                                }else if(instruction.strType == 'Delivery'){
                                    $("#deliveryInstructions").val(instruction.strInstruction);
                                }
                            });
                        });

                        var currentID = currentSelectedRow[0];
                        var clickedID = e.data.intAutoPickingHeader;

                        if (clickedID === currentID){
                            currentSelectedRow = [];
                            e.component.clearSelection();

                            $("#btnTeamLeader").prop("disabled", true);
                            $("#btnHorse").prop("disabled", true);
                            $("#btnTrailor").prop("disabled", true);
                            $("#btnDriver").prop("disabled", true);
                            $("#btnTicket").prop("disabled", true);
                            $("#btnInstructions").prop("disabled", true);
                        }else{
                            currentSelectedRow = [];
                            currentSelectedRow.push(clickedID);

                            $("#btnTeamLeader").prop("disabled", false);
                            $("#btnHorse").prop("disabled", false);
                            $("#btnTrailor").prop("disabled", false);
                            $("#btnDriver").prop("disabled", false);
                            $("#btnTicket").prop("disabled", false);
                            $("#btnInstructions").prop("disabled", false);

                            $('#teamLeader').val(e.data.intTeamLeaderId).trigger('change');
                            $('#horse').val(e.data.strTrailorNo).trigger('change');
                            $('#trailorOne').val(e.data.strTrailorone).trigger('change');
                            $('#trailorTwo').val(e.data.strTrailortwo).trigger('change');
                            $('#driverOne').val(e.data.intDriverOne).trigger('change');
                            $('#driverTwo').val(e.data.intDriverTwo).trigger('change');
                            $('#ticket').val(e.data.strTicket).trigger('change');
                        }
                    },
                    onSelectionChanged: function(e) {

                    },
                    onRowDblClick: function (e) {
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
    };

    function completeTruckLoad(ref){
        $.ajax({
            url: '{!!url("/completeTruckLoad")!!}',
            type: "POST",
            data: {
                ref: ref,
            },
            success: function (data) {
                getData();
            }
        });
    };

    function assignInstruction(ref, instruction, type){
        $.ajax({
            url: '{!!url("/assignInstruction")!!}',
            type: "POST",
            data: {
                ref: ref,
                instruction: instruction,
                type: type,
            },
            success: function (data) {
                getData();
                $("#closeInstructionsModal").click();
            }
        });
    }

</script>

</div>
</body>
</html>
