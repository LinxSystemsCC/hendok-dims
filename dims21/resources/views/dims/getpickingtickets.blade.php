@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Truck Loads')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <div class="col-lg-12">
        <div class="col-lg-12 d-inline-flex mb-2" >
            <h3 class="col-6 text-nowrap">Truck Loads</h3>

            <div class="col-6 d-flex justify-content-end">
                {{-- <label class="d-flex align-items-center px-2 text-nowrap" >Date From</label> 
                <input class="form-control px-2" type="date" id='from'>
                <label class="d-flex align-items-center px-2 text-nowrap" >Date To</label>
                <input class="form-control px-2" type="date" id='to'>
                <button class="btn btn-success w-100 ms-2" id="getdata">SEARCH</button> --}}
            </div>
        </div>

        <div class="col-lg-12 d-inline-flex">
            <button class="btn btn-primary mb-2 w-100" data-bs-toggle="modal" data-bs-target="#teamLeaderModal" id="btnTeamLeader" disabled>TEAM LEADER</button>
            <button class="btn btn-primary mb-2 w-100 ms-2" data-bs-toggle="modal" data-bs-target="#horseModal" id="btnHorse" disabled>HORSE</button>
            <button class="btn btn-primary mb-2 w-100 ms-2" data-bs-toggle="modal" data-bs-target="#trailorModal" id="btnTrailor" disabled>TRAILER</button>
            <button class="btn btn-primary mb-2 w-100 ms-2" data-bs-toggle="modal" data-bs-target="#driverModal" id="btnDriver" disabled>DRIVER</button>
            <button class="btn btn-primary mb-2 w-100 ms-2" data-bs-toggle="modal" data-bs-target="#ticketModal" id="btnTicket" disabled>TICKET</button>
            <button class="btn btn-primary mb-2 w-100 ms-2" data-bs-toggle="modal" data-bs-target="#instructionsModal" id="btnInstructions" disabled>INSTRUCTIONS</button>
            <button class="btn btn-primary mb-2 w-100 ms-2" data-bs-toggle="modal" data-bs-target="#timeModal" id="btnTimeRequired" disabled>TIME REQ</button>
            <button class="btn btn-primary mb-2 w-100 ms-2" data-bs-toggle="modal" data-bs-target="#departureModal" id="btnDepartureTime" disabled>DEPARTURE TIME</button>
            <button class="btn btn-success mb-2 w-100 ms-2" id="btnComplete" disabled>COMPLETE</button>
        </div>

        <div id="gridTruckLoads" class="col-lg-12"></div>

        <div id="toggleCheckbox"></div>

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
                            <label for="teamLeaderOne" class="col-form-label">Shift 1 Team Leader</label>
                            <select class="form-select mx-2" type="text" id='teamLeaderOne'>
                                <option></option>
                                @foreach ($teamleaders as $teamleader)
                                    <option value="{{ $teamleader->UserID }}">{{ $teamleader->FullName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="teamLeaderTwo" class="col-form-label">Shift 2 Team Leader</label>
                            <select class="form-select mx-2" type="text" id='teamLeaderTwo'>
                                <option></option>
                                @foreach ($teamleaders as $teamleader)
                                    <option value="{{ $teamleader->UserID }}">{{ $teamleader->FullName }}</option>
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
                                <option value=" ">UNASSIGN</option>
                                @foreach ($horses as $horse)
                                    <option value="{{ $horse->TruckId }}">
                                        {{ $horse->TruckName }} @if ($horse->intInUse == 1) - IN USE @endif
                                    </option>
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
                                <option value=" ">UNASSIGN</option>
                                @foreach ($trailors as $trailorOne)
                                    <option value="{{ $trailorOne->TruckId }}">
                                        {{ $trailorOne->TruckName }} @if ($trailorOne->intInUse == 1) - IN USE @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="trailorTwo" class="col-form-label">Trailer Two</label>
                            <select class="form-select mx-2" type="text" id='trailorTwo'>
                                <option value=" ">UNASSIGN</option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}">
                                        {{ $trailorTwo->TruckName }}  @if ($trailorTwo->intInUse == 1)- IN USE @endif
                                    </option>
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

    <!-- Instructions -->
    <div class="modal fade" id="instructionsModal" aria-labelledby="instructionsModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="instructionsModal">Assign Instructions</h1>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="notes" class="col-form-label">Notes</label>
                            <textarea class="form-control" id="notes" rows="5"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="deliveryInstructions" class="col-form-label">Delivery Instructions</label>
                            <textarea class="form-control" id="deliveryInstructions" rows="5"></textarea>
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeInstructionsModal">Close</button>
                    <button type="button" id="saveInstructions" class="btn btn-success" >Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Time -->
    <div class="modal fade" id="timeModal" aria-labelledby="timeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="timeModal">Time Requirements</h1>
                </div>
    
                <div class="modal-body">
                    <div class="col-md-12 mb-3">
                        <label for="picking" class="col-form-label">Picking Time</label>
                        <div class="d-inline-flex">
                            <input placeholder="Hours" type="number" class="form-control timeInput" id="pickingHours">
                            <input placeholder="Minutes" type="number" class="form-control timeInput ms-2" id="pickingMins">
                        </div>
                        <label for="loading" class="col-form-label">Loading Time</label>
                        <div class="d-inline-flex">
                            <input placeholder="Hours" type="number" class="form-control timeInput" id="loadingHours">
                            <input placeholder="Minutes" type="number" class="form-control timeInput ms-2" id="loadingMins">
                        </div>
                        <label for="total" class="col-form-label">Total Time</label>
                        <div class="d-inline-flex">
                            <input placeholder="Hours" type="number" class="form-control" id="totalHours">
                            <input placeholder="Minutes" type="number" class="form-control ms-2" id="totalMins">
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeTimeModal">Close</button>
                    <button type="button" id="saveTimeRequirements" class="btn btn-success" >Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Departure -->
    <div class="modal fade" id="departureModal" aria-labelledby="departureModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="departureModal">Departure Time</h1>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="d-inline-flex w-100">
                            <input type="date" class="form-control" id="dispatchDate">
                            <input type="time" class="form-control ms-2" id="dispatchTime">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeDepartureModal">Close</button>
                    <button type="button" id="saveDepartureTime" class="btn btn-success" >Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <style>
        #gridTruckLoads{
            height: calc(100vh - 152px);
            max-height: calc(100vh - 152px);
        }

        .master-detail-caption {
            padding: 0 0 5px 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .customPadding {
            padding: 3px !important;
        }

        .dx-header-row{
            color: black;
        }

    </style>

    

    <script>

        // const detailGrid = $('<div>')
        // .dxDataGrid({
        //     dataSource: {
        //         load: function(loadOptions) {
        //             return $.ajax({
        //                 url: '{!!url("/teamLeaderGetPickingPlanToInvoice")!!}',
        //                 method: 'GET',
        //                 data: { ref: options.data.strUnickReference },
        //                 xhrFields: { withCredentials: true },
        //             });
        //         },
        //         update: function (key, values) {
        //             detailGrid.dxDataGrid('instance').refresh();
        //         },
        //     },                        
        //     editing: {
        //         mode: 'batch',
        //         allowUpdating: true,
        //     },
        //     showBorders: true,     
        //     columns: [
        //         {
        //             dataField: "intAutoPicking",
        //             caption: "ID",
        //             visible: false,
        //         },
        //         {
        //             dataField: "StoreName",
        //             caption: "Store Name",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "areas",
        //             caption: "Area",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "OrderDate",
        //             caption: "Order Date",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "OrderNum",
        //             caption: "SO Number",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "ExtOrderNum",
        //             caption: "Instructions",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "iLineID",
        //             caption: "Line No",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "PastelCode",
        //             caption: "Code",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "PastelDescription",
        //             caption: "Description",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "mnyQty",
        //             caption: "Quantity",
        //             allowEditing: false,
        //         },
        //         {
        //             dataField: "weightPlanned",
        //             caption: "Weight",
        //             allowEditing: false,
        //         },
        //         {
        //             // dataField: "ubARIBT",
        //             dataField: "mnyLoadedQty",
        //             caption: "To Invoice",
        //             allowEditing: false,
        //         },{
        //             dataField: "isPriorityLine",
        //             caption: "Priority",
        //             lookup: {
        //                 dataSource: [
        //                     { value: '1', text: 'Yes' },
        //                     { value: '0', text: 'No' },
        //                 ],
        //                 valueExpr: "value",
        //                 displayExpr: "text",
        //             },
        //         },
        //     ],
        //     onRowPrepared: function(e) {
                
        //         if (e.rowType === "data") {
        //             if (e.rowIndex % 2 === 0) {
        //                 e.rowElement.css("background-color", "#e6e6e6"); // Even row background color
        //             } else {
        //                 e.rowElement.css("background-color", "#c3c3c3"); // Odd row background color
        //             }
        //         }
        //     },
        //     onRowUpdating: function(e) {

        //         $.ajax({
        //             url: '{!!url("/truckLoadUpdatePriortiyStatus")!!}',
        //             method: 'POST', // or 'POST' depending on your API design
        //             data: {
        //                 intAutoPicking: e.oldData.intAutoPicking,
        //                 isPriorityLine:  e.newData.isPriorityLine,
        //             },
        //             success: function(response) {
                        
        //             },
        //         });

        //     }
        // }).appendTo(container);
        $(document).ready(function() {
            var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization

            const gridTruckLoads = $("#gridTruckLoads").dxDataGrid({
                dataSource:[],
                keyExpr: 'strUnickReference',
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                rowAlternationEnabled: true,
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
                        dataField: "bitHidden",
                        caption: "is invoiced",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "date",
                        caption: "Date Created",
                        calculateCellValue: function (rowData) {
                            // Extract the date part from the "dtm" field
                            const dtm = new Date(rowData.dtm);
                            return dtm.toLocaleDateString("en-ZA");
                        },
                    },
                    {
                        dataField: "time",
                        caption: "Time Created",
                        calculateCellValue: function (rowData) {
                            // Extract the time part from the "dtm" field
                            const dtm = new Date(rowData.dtm);
                            return dtm.toLocaleTimeString();
                        },
                    },
                    {
                        dataField: "intAutoPickingHeader",
                        caption: "Load No.",
                        fixed: true,
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
                        caption: "Team Leader One ID",
                        visible: false,
                    },
                    {
                        dataField: "intTeamLeaderTwoId",
                        caption: "Team Leader ID",
                        visible: false,
                    },
                    {
                        dataField: "strTeamLeaderOne",
                        caption: "Team Leader One",
                    },
                    {
                        dataField: "strTeamLeaderTwo",
                        caption: "Team Leader Two",
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
                ],
                masterDetail: {
                    enabled: true,
                    template: function (container, options) {
                        const detailGridContainer = $("<div>");

                        // Load the external HTML content into the detailGridContainer
                        $.ajax({
                            url: '{!!url("/teamleaderUpdatePickingLoadingTable")!!}', // Replace with the actual URL
                            dataType: 'html',
                            method: 'GET',
                            data: {
                                ref: options.data.strUnickReference,
                            },
                            success: function (data) {
                                detailGridContainer.html(data);
                            },
                            error: function (error) {
                                console.error('Error loading content: ' + error);
                            }
                        });

                        // Append the loaded content to the detail grid's container
                        container.append(detailGridContainer);
                    }
                },
                onRowPrepared(e) {
                    if (e.rowType == 'data' && e.data.isCancelled ==1) {
                        e.rowElement.css('background', 'red');
                    }
                },
                onRowClick: function (e) {
                    // console.log(e.data);

                    getTimeRequirements(e.data.strUnickReference).then(function(times) {
                        // console.log(times);
                        $("#pickingHours").val('');
                        $("#pickingMins").val('');
                        
                        $("#loadingHours").val('');
                        $("#loadingMins").val('');
                        
                        $("#totalHours").val('');
                        $("#totalMins").val('');

                        times.forEach(function(time) {
                            if (time){
                                $("#pickingHours").val(time.intPickingHour);
                                $("#pickingMins").val(time.intPickingMin);
                                
                                $("#loadingHours").val(time.intLoadingHour);
                                $("#loadingMins").val(time.intLoadingMin);
                                
                                $("#totalHours").val(time.intTotalHour);
                                $("#totalMins").val(time.intTotalMin);
                            }e
                        });
                    });

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
                        $("#btnComplete").prop("disabled", true);
                        $("#btnTimeRequired").prop("disabled", true);
                        $("#btnDepartureTime").prop("disabled", true);
                    }else{
                        currentSelectedRow = [];
                        currentSelectedRow.push(clickedID);

                        $("#btnTeamLeader").prop("disabled", false);
                        $("#btnHorse").prop("disabled", false);
                        $("#btnTrailor").prop("disabled", false);
                        $("#btnDriver").prop("disabled", false);
                        $("#btnTicket").prop("disabled", false);
                        $("#btnInstructions").prop("disabled", false);
                        $("#btnComplete").prop("disabled", false);
                        $("#btnTimeRequired").prop("disabled", false);
                        $("#btnDepartureTime").prop("disabled", false);

                        $('#teamLeaderOne').val(e.data.intTeamLeaderId).trigger('change');
                        $('#teamLeaderTwo').val(e.data.intTeamLeaderTwoId).trigger('change');
                        $('#horse').val(e.data.strTrailorNo).trigger('change');
                        $('#trailorOne').val(e.data.strTrailorone).trigger('change');
                        $('#trailorTwo').val(e.data.strTrailortwo).trigger('change');
                        $('#driverOne').val(e.data.intDriverOne).trigger('change');
                        $('#driverTwo').val(e.data.intDriverTwo).trigger('change');
                        $('#ticket').val(e.data.strTicket).trigger('change');

                        if (e.data.dtmDeparted != null) {
                            var parts = e.data.dtmDeparted.split(' ');
                            var datePart = parts[0];
                            var timePart = parts[1];

                            $('#dispatchDate').val(datePart);
                            $('#dispatchTime').val(timePart);
                        }
                        else{
                            var currentDate = new Date();

                            // Extract date components
                            var year = currentDate.getFullYear();
                            var month = currentDate.getMonth() + 1; // Note: Month is zero-based
                            var day = currentDate.getDate();

                            // Extract time components
                            var hours = currentDate.getHours();
                            var minutes = currentDate.getMinutes();
                            var seconds = currentDate.getSeconds();

                            // Format date and time as needed
                            var formattedDate = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
                            var formattedTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;

                            $('#dispatchDate').val(formattedDate);
                            $('#dispatchTime').val(formattedTime);
                        }

                        // console.log(e.data);
                    }
                },
                onSelectionChanged: function(e) {
                    // console.debug("");
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
                },
                onContentReady: function(e) {
                    // Hide rows where bitHidden is equal to 1 initially
                    e.component.beginUpdate();
                    e.component.getDataSource().filter(["bitHidden", "=", 0]);
                    e.component.endUpdate();
                }
            }).dxDataGrid('instance');

            $("#toggleCheckbox").dxCheckBox({
                text: "View Invoiced Loads",
                onValueChanged: function(e) {
                    if (e.value) {
                        // Show rows where bitHidden is equal to 1
                        gridTruckLoads.getDataSource().filter(["bitHidden", "=", 1]);
                        gridTruckLoads.refresh();
                    } else {
                        // Hide rows where bitHidden is equal to 1
                        gridTruckLoads.getDataSource().filter(["bitHidden", "=", 0]);
                        gridTruckLoads.refresh();
                    }
                }
            });

            $('#teamLeaderOne').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#teamLeaderModal'),
            });

            $('#teamLeaderTwo').select2({
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

            $('#pickingMins').on('blur', function() {
                // Get the current values for hours and minutes
                var hours = parseInt($('#pickingHours').val()) || 0;
                var minutes = parseInt($(this).val()) || 0;

                // Calculate the total number of minutes
                var totalMinutes = hours * 60 + minutes;

                // Calculate the remainder when dividing by 5 (5-minute increments)
                var remainder = totalMinutes % 5;

                // Determine whether to round up or down based on the remainder
                var roundedValue;
                if (remainder <= 2.5) {
                    // Round down to the nearest multiple of 5
                    roundedValue = totalMinutes - remainder;
                } else {
                    // Round up to the nearest multiple of 5
                    roundedValue = totalMinutes + (5 - remainder);
                }

                // Update hours and minutes fields with the adjusted values
                hours = Math.floor(roundedValue / 60);
                minutes = roundedValue % 60;

                $('#pickingHours').val(hours);
                $(this).val(minutes);
            });

            $('#loadingMins').on('blur', function() {
                // Get the current values for hours and minutes
                var hours = parseInt($('#loadingHours').val()) || 0;
                var minutes = parseInt($(this).val()) || 0;

                // Calculate the total number of minutes
                var totalMinutes = hours * 60 + minutes;

                // Calculate the remainder when dividing by 5 (5-minute increments)
                var remainder = totalMinutes % 5;

                // Determine whether to round up or down based on the remainder
                var roundedValue;
                if (remainder <= 2.5) {
                    // Round down to the nearest multiple of 5
                    roundedValue = totalMinutes - remainder;
                } else {
                    // Round up to the nearest multiple of 5
                    roundedValue = totalMinutes + (5 - remainder);
                }

                // Update hours and minutes fields with the adjusted values
                hours = Math.floor(roundedValue / 60);
                minutes = roundedValue % 60;

                $('#loadingHours').val(hours);
                $(this).val(minutes);
            });

            $('#totalMins').on('blur', function() {
                // Get the current values for hours and minutes
                var hours = parseInt($('#totalHours').val()) || 0;
                var minutes = parseInt($(this).val()) || 0;

                // Calculate the total number of minutes
                var totalMinutes = hours * 60 + minutes;

                // Calculate the remainder when dividing by 5 (5-minute increments)
                var remainder = totalMinutes % 5;

                // Determine whether to round up or down based on the remainder
                var roundedValue;
                if (remainder <= 2.5) {
                    // Round down to the nearest multiple of 5
                    roundedValue = totalMinutes - remainder;
                } else {
                    // Round up to the nearest multiple of 5
                    roundedValue = totalMinutes + (5 - remainder);
                }

                // Update hours and minutes fields with the adjusted values
                hours = Math.floor(roundedValue / 60);
                minutes = roundedValue % 60;

                $('#totalHours').val(hours);
                $(this).val(minutes);
            });

            $('#saveTimeRequirements').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ref = selectedItem.strUnickReference;
                var ID = selectedItem.intAutoPickingHeader;
                
                var pickingHours = $('#pickingHours').val();
                var pickingMins = $('#pickingMins').val();

                var loadingHours = $('#loadingHours').val();
                var loadingMins = $('#loadingMins').val();

                var totalHours = $('#totalHours').val();
                var totalMins = $('#totalMins').val();

                $.ajax({
                    url: '{!!url("/assignTimeToPickingTicket")!!}',
                    type: "POST",
                    data: {
                        ref: ref,
                        ID: ID,
                        pickingHours: pickingHours,
                        pickingMins: pickingMins,
                        loadingHours: loadingHours,
                        loadingMins: loadingMins,
                        totalHours: totalHours,
                        totalMins: totalMins,
                    },
                    success: function (data) {
                        getData();
                    }
                });
            });

            $('#saveDepartureTime').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ref = selectedItem.strUnickReference;
                
                var date = $('#dispatchDate').val();
                var time = $('#dispatchTime').val();

                var dateTime = date + ' ' + time;
                console.log(dateTime)

                $.ajax({
                    url: '{!!url("/assignDepartureTimeToPickingTicket")!!}',
                    type: "POST",
                    data: {
                        ref: ref,
                        dateTime: dateTime,
                    },
                    success: function (data) {
                        getData();
                    }
                });
            });

            $('#getdata').click(function(){
                getData();
            });

            $('#saveTeamLeader').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!!url("/assignTeamLeaderToPickingTicket")!!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        teamLeaderOne: $('#teamLeaderOne').val(),
                        teamLeaderTwo: $('#teamLeaderTwo').val(),
                    },
                    success: function (data) {
                        $("#closeTeamLeaderModal").click();
                        getData();
                    }
                });
            });

            $('#saveHorse').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!!url("/assignHorseToPickingTicket")!!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        horse: $('#horse').val(),
                    },
                    success: function (data) {
                        getData();
                        $("#closeHorseModal").click();
                    }
                });
            });

            $('#saveTrailor').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!!url("/assignTrailorToPickingTicket")!!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        trailorOne: $('#trailorOne').val(),
                        trailorTwo: $('#trailorTwo').val(),
                    },
                    success: function (data) {
                        getData();
                        $("#closeTrailorModal").click();
                    }
                });
            });

            $('#saveDriver').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
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
                        getData();
                        $("#closeDriverModal").click();
                    }
                });
            });

            $('#saveTicket').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!!url("/assignTicketToPickingTicket")!!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        ticket: $('#ticket').val(),
                    },
                    success: function (data) {
                        getData();
                        $("#closeTicketModal").click();
                    }
                });
            });

            $('#btnComplete').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ref = selectedItem.strUnickReference;
                completeTruckLoad(ref)
            });

            $('#saveInstructions').click(function(){
                var selectedItem = gridTruckLoads.getSelectedRowsData()[0];
                var ref = selectedItem.strUnickReference;
                var notes = $("#notes").val();
                var type = 'Notes';
                assignInstruction(ref, notes, type)
                var delivery = $("#deliveryInstructions").val();
                type = 'Delivery';
                assignInstruction(ref, delivery, type)
            });

            $("#closeInstructionsModal").click(function(){
                $("#notes").val("");
                $("#deliveryInstructions").val("");
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

            function getInstructions(ref) {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: '{!!url("/getInstructions")!!}',
                        type: "GET",
                        data: {
                            ref: ref,
                        },
                        success: function(data) {
                            resolve(data); // Resolve the promise with the received data
                        },
                        error: function(xhr, status, error) {
                            reject(error); // Reject the promise with the error message
                        }
                    });
                });
            }

            function getTimeRequirements(ref) {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: '{!!url("/getTimeRequirements")!!}',
                        type: "GET",
                        data: {
                            ref: ref,
                        },
                        success: function(data) {
                            resolve(data); // Resolve the promise with the received data
                        },
                        error: function(xhr, status, error) {
                            reject(error); // Reject the promise with the error message
                        }
                    });
                });
            }

            function getData(){
                $.ajax({
                    url: '{!!url("/getIncompletePickingTickets")!!}',
                    type: "GET",
                    data: {
                        from: $('#from').val(),
                        to: $('#to').val()
                    },
                    success: function (data) {
                        gridTruckLoads.option('dataSource', data);
                        gridTruckLoads.refresh();
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
        });
    </script>

@endsection