<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

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
    
        .dx-datagrid {
            height: calc(100vh - 87px);
            max-height: calc(100vh - 87px);
        }

        .dx-selection {
            font-weight: 700;
            /* Additional styles */
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

                <div class="d-inline-flex">
                    <label class="d-flex align-items-center px-2" >Date From</label> 
                    <input class="form-control px-2" type="date" id='from'>
                    <label class="d-flex align-items-center px-2" >Date To</label>
                    <input class="form-control px-2" type="date" id='to'>
                    <button class="btn btn-success mx-2" id="getdata">SEARCH</button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#teamLeaderModal" id="btnTeamLeader" disabled>TEAM LEADER</button>
                    <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#horseModal" id="btnHorse" disabled>HORSE</button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trailorModal" id="btnTrailor" disabled>TRAILER</button>
                    <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#driverModal" id="btnDriver" disabled>DRIVER</button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ticketModal" id="btnTicket" disabled>TICKET</button>
                    
                </div>
            </div>

            <div id="gridContainer"></div>
            
        </div>
    </div>

    <!-- Team Leader Modal -->
    <div class="modal fade" id="teamLeaderModal" aria-labelledby="teamLeaderModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="teamLeaderModal">Assign Team Leader</h1>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="teamLeader" class="col-form-label">Team Leader</label>
                            <select class="form-select mx-2" type="text" id='teamLeader'>
                                <option></option>
                                @foreach ($teamleaders as $teamleader)
                                    <option value="{{ $teamleader->UserID }}">{{ $teamleader->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeCreateNewStockIssue">Close</button>
                    <button type="button" id="saveTeamLeader" class="btn btn-success" >Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Horse Modal -->
    <div class="modal fade" id="horseModal" aria-labelledby="horseModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="horseModal">Assign Horse</h1>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="horse" class="col-form-label">Horse</label>
                            <select class="form-select mx-2" type="text" id='horse'>
                                <option>
                                @foreach ($horses as $horse)
                                    <option value="{{ $horse->TruckId }}">{{ $horse->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeCreateNewStockIssue">Close</button>
                    <button type="button" id="saveHorse" class="btn btn-success" >Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Trailor Modal -->
    <div class="modal fade" id="trailorModal" aria-labelledby="trailorModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="trailorModal">Assign Trailer</h1>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="trailorOne" class="col-form-label">Trailer One</label>
                            <select class="form-select mx-2" type="text" id='trailorOne'>
                                <option></option>
                                @foreach ($trailors as $trailorOne)
                                    <option value="{{ $trailorOne->TruckId }}">{{ $trailorOne->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="trailorTwo" class="col-form-label">Trailer Two</label>
                            <select class="form-select mx-2" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}">{{ $trailorTwo->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeCreateNewStockIssue">Close</button>
                    <button type="button" id="saveTrailor" class="btn btn-success" >Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Driver Modal -->
    <div class="modal fade" id="driverModal" aria-labelledby="driverModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="driverModal">Assign To Picking Ticket</h1>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="driverOne" class="col-form-label">Driver One</label>
                            <select class="form-select mx-2" type="text" id='driverOne'>
                                <option></option>
                                @foreach ($drivers as $driverOne)
                                    <option value="{{ $driverOne->DriverId }}">{{ $driverOne->DriverName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="driverTwo" class="col-form-label">Driver Two</label>
                            <select class="form-select mx-2" type="text" id='driverTwo'>
                                <option></option>
                                @foreach ($drivers as $driverTwo)
                                    <option value="{{ $driverTwo->DriverId }}">{{ $driverTwo->DriverName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeCreateNewStockIssue">Close</button>
                    <button type="button" id="saveDriver" class="btn btn-success" >Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Modal -->
    <div class="modal fade" id="ticketModal" aria-labelledby="ticketModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ticketModal">Assign To Picking Ticket</h1>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="ticket" class="col-form-label">Weighbridge Ticket</label>
                            <select class="form-select mx-2" type="text" id='ticket'>
                                <option></option>
                                @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->strTicket }}">{{ $ticket->strTicket }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeCreateNewStockIssue">Close</button>
                    <button type="button" id="saveTicket" class="btn btn-success" >Save</button>
                </div>
            </div>
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


        $('#teamLeader').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#teamLeaderModal'),
        });

        $('#horse').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#horseModal'),
        });

        $('#trailorOne').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#trailorModal'),
        });

        $('#trailorTwo').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#trailorModal'),
        });

        $('#driverOne').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#driverModal'),
        });

        $('#driverTwo').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#driverModal'),
        });

        $('#ticket').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ticketModal'),
        });

        var currentDate = new Date();
        var year = currentDate.getFullYear();
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        var day = ("0" + currentDate.getDate()).slice(-2);
        var formattedDate = year + "-" + month + "-" + day;
        
        $('#from').val(formattedDate);
        $('#to').val(formattedDate);

        getData();

        $('#getdata').click(function(){
            getData();
        });

        $('#saveTeamLeader').click(function(){
            var selectedItem = $("#gridContainer").dxDataGrid("instance").getSelectedRowsData()[0];
            var ID = selectedItem.intAutoPickingHeader;
            $.ajax({
                url: '{!!url("/assignTeamLeaderToPickingTicket")!!}',
                type: "POST",
                data: {
                    ID: ID,
                    teamLeader: $('#teamLeader').val(),
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('#saveHorse').click(function(){
            var selectedItem = $("#gridContainer").dxDataGrid("instance").getSelectedRowsData()[0];
            var ID = selectedItem.intAutoPickingHeader;
            $.ajax({
                url: '{!!url("/assignHorseToPickingTicket")!!}',
                type: "POST",
                data: {
                    ID: ID,
                    horse: $('#horse option:selected').text(),
                    trailorOne: $('#trailorOne option:selected').text(),
                    trailorTwo: $('#trailorTwo option:selected').text(),
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('#saveTrailor').click(function(){
            var selectedItem = $("#gridContainer").dxDataGrid("instance").getSelectedRowsData()[0];
            var ID = selectedItem.intAutoPickingHeader;
            $.ajax({
                url: '{!!url("/assignTrailorToPickingTicket")!!}',
                type: "POST",
                data: {
                    ID: ID,
                    trailorOne: $('#trailorOne option:selected').text(),
                    trailorTwo: $('#trailorTwo option:selected').text(),
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('#saveDriver').click(function(){
            var selectedItem = $("#gridContainer").dxDataGrid("instance").getSelectedRowsData()[0];
            var ID = selectedItem.intAutoPickingHeader;
            $.ajax({
                url: '{!!url("/assignDriversToPickingTicket")!!}',
                type: "POST",
                data: {
                    ID: ID,
                    driverOne: $('#driverOne').val(),
                    driverTwo: $('#driverTwo').val(),
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('#saveTicket').click(function(){
            var selectedItem = $("#gridContainer").dxDataGrid("instance").getSelectedRowsData()[0];
            var ID = selectedItem.intAutoPickingHeader;
            $.ajax({
                url: '{!!url("/assignTicketToPickingTicket")!!}',
                type: "POST",
                data: {
                    ID: ID,
                    ticket: $('#ticket').val(),
                },
                success: function (data) {
                    location.reload();
                }
            });
        });

        $('.sidebar ul li a').on(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });
        
        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });
    });

    function getData(){
        var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization
        $.ajax({
            url: '{!!url("/jsongetpickingplan")!!}',
            type: "GET",
            data: {
                from: $('#from').val(),
                to: $('#to').val()
            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
                    dataSource:data,
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
                            dataField: "strDriverOne",
                            caption: "Driver One",
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
                        }
                    ] ,
                    onRowPrepared(e) {
                        if (e.rowType == 'data' && e.data.isCancelled ==1) {
                            e.rowElement.css('background', 'red');
                        }
                    },
                    onRowClick: function (e) {
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
                        }else{
                            currentSelectedRow = [];
                            currentSelectedRow.push(clickedID);

                            $("#btnTeamLeader").prop("disabled", false);
                            $("#btnHorse").prop("disabled", false);
                            $("#btnTrailor").prop("disabled", false);
                            $("#btnDriver").prop("disabled", false);
                            $("#btnTicket").prop("disabled", false);
                        }
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

</script>

</div>
</body>
</html>
