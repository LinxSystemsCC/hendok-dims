@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Load Tracking')


{{-- Set to show navbar --}}
@php
    $includeMenu = false;
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
    }

    $complete = $v->getThingsUserPermissions(Auth::user()->UserID, 'Complete Load');

    $updateHorse = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Horse');
    $updateTrailer = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Trailer');
    $updateDrivers = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Drivers');
    $updateTicket = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Ticket');
    $updatePlanDeparture = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Plan Departure');
    $updateActualDeparture = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Actual Departure');
    $updateFleetStatus = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Fleet Status');
    $updateSettlementStatus = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Settlement Status');
    $updateLostTime = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Lost Time');

@endphp

@section('page')

    <div id="gridLoadTracking" class="col-lg-12"></div>

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
                                        {{ $horse->TruckName }} @if ($horse->intInUse == 1)
                                            - IN USE
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btnCloseHorse">Close</button>
                    <button type="button" id="saveHorse" class="btn btn-success">Save</button>
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
                                        {{ $trailorOne->TruckName }} @if ($trailorOne->intInUse == 1)
                                            - IN USE
                                        @endif
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
                                        {{ $trailorTwo->TruckName }} @if ($trailorTwo->intInUse == 1)
                                            - IN USE
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btnCloseTrailor">Close</button>
                    <button type="button" id="saveTrailor" class="btn btn-success">Save</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btnCloseDriver">Close</button>
                    <button type="button" id="saveDriver" class="btn btn-success">Save</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="btnCloseTicket">Close</button>
                    <button type="button" id="saveTicket" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-md" id="planDepartureModal" tabindex="-1" aria-labelledby="newuserLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">PLANNED DEPARTURE</h1>
                    <button type="button" class="btn-close closePlanDepartureModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group mb-2 col-6">
                                <label class="control-label fw-bold" for="inputPlannedDate">Date</label>
                                <input type="date" class="form-control w-100" id="inputPlannedDate" required>
                            </div>

                            <div class="form-group mb-2 col-6">
                                <label class="control-label fw-bold" for="inputPlannedTime">Time</label>
                                <input type="time" class="form-control w-100" id="inputPlannedTime" required>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100" id="btnPlanDeparture">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-md" id="actualDepartureModal" tabindex="-1" aria-labelledby="newuserLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">ACTUAL DEPARTURE</h1>
                    <button type="button" class="btn-close closeActualDepartureModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group mb-2 col-6">
                                <label class="control-label fw-bold" for="inputActualDate">Date</label>
                                <input type="date" class="form-control w-100" id="inputActualDate" required>
                            </div>

                            <div class="form-group mb-2 col-6">
                                <label class="control-label fw-bold" for="inputActualTime">Time</label>
                                <input type="time" class="form-control w-100" id="inputActualTime" required>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100" id="btnActualDeparture">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-md" id="tripStatusModal" tabindex="-1" aria-labelledby="newuserLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">TRIP STATUS</h1>
                    <button type="button" class="btn-close closeTripStatusModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group mb-2 col-12">
                                <label class="control-label fw-bold" for="selectStatus">Status</label>
                                <select type="date" class="form-select w-100" id="selectStatus" required>
                                    <option></option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->strStatus }}"> {{ $status->strStatus }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100" id="btnTripStatus">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-md" id="reasonModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">REASON</h1>
                    <button type="button" class="btn-close closereasonModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group mb-2 col-12">
                                <label class="control-label fw-bold" for="selectReasonType">Reason Type</label>
                                <select type="date" class="form-select w-100" id="selectReasonType" required>
                                    <option></option>
                                    @foreach ($reasonTypes as $reasonType)
                                        <option value="{{ $reasonType->intAutoId }}"> {{ $reasonType->strReasonTypes }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-2 col-12">
                                <label class="control-label fw-bold" for="inputReason">Reason</label>
                                <input type="text" class="form-control w-100" id="inputReason" required>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100" id="btnReason">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <style>
        #gridLoadTracking {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <script>
        $(document).ready(function() {
            let loadTracking = [];
            var currentSelectedRow = [];

            $('#selectStatus').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#tripStatusModal'),
            });

            $('#selectReasonType').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#reasonModal'),
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

            const gridLoadTracking = $("#gridLoadTracking").dxDataGrid({
                dataSource: [],
                keyExpr: 'strUnickReference',
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                rowAlternationEnabled: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                paging: {
                    enabled: false
                },
                selection: {
                    mode: "single",
                },
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "widget",
                columnFixing: {
                    enabled: true,
                },
                scrolling: {
                    mode: 'overflow'
                },
                columns: [{
                        dataField: "intAutoPickingHeader",
                        caption: "Load No.",
                        // fixed: true,
                        calculateCellValue: function(data) {
                            return "TL" + data.intAutoPickingHeader;
                        },
                    },
                    {
                        dataField: "dtm",
                        caption: "Date Created",
                        dataType: 'datetime',
                        format: 'yyyy-MM-dd hh:mm:ss'
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
                        dataField: "strTicket",
                        caption: "Ticket",
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
                        dataField: "strTrailerType",
                        caption: "Trailor Type",
                    },
                    {
                        dataField: "intNoOfStops",
                        caption: "Stops",
                    },
                    {
                        dataField: "dtmPlannedDeparture",
                        caption: "Planned Departure",
                    },
                    {
                        dataField: "dtmActualDeparture",
                        caption: "Actual Departure",
                    },
                    {
                        dataField: "strStatus",
                        caption: "Status",
                    },
                    {
                        dataField: "intLostTime",
                        caption: "Lost Time",
                    },
                    {
                        dataField: "strReasonType",
                        caption: "Reason Type",
                    },
                    {
                        dataField: "strReason",
                        caption: "Reason",
                    },
                    {
                        dataField: "intReasonType",
                        visible: false,
                    },
                    {
                        dataField: "strLoadStatus",
                        visible: false,
                    },
                ],
                onRowClick: function(e) {
                    // console.log(e.data);

                    var currentID = currentSelectedRow[0];
                    var clickedID = e.data.intAutoPickingHeader;

                    if (clickedID === currentID) {
                        currentSelectedRow = [];
                        e.component.clearSelection();
                        // disableToolbarButtons(true);

                        this.isBtnDisabled = true;
                        gridLoadTracking.repaint();
                    } else {
                        currentSelectedRow = [];
                        currentSelectedRow.push(clickedID);
                        // disableToolbarButtons(true);

                        this.isBtnDisabled = false;
                        gridLoadTracking.repaint();
                    }
                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        widget: "dxButton",
                        options: {
                            icon: "home",
                            // text: "Home",
                            onClick: function(args) {
                                window.location.href = {!! json_encode(url('/dashboard')) !!};
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-truck",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateHorse }} != '0',
                            text: "HORSE",
                            onClick: function(args) {
                                $('#horseModal').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-trailer",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateTrailer }} != '0',
                            text: "TRAILER",
                            onClick: function(args) {
                                $('#trailorModal').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-user",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateDrivers }} != '0',
                            text: "DRIVERS",
                            onClick: function(args) {
                                $('#driverModal').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-ticket",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateTicket }} != '0',
                            text: "TICKET NO.",
                            onClick: function(args) {
                                $('#ticketModal').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-circle-check",
                            disabled: this.isBtnDisabled,
                            visible: {{ $complete }} != '0',
                            text: "COMPLETE",
                            onClick: function(args) {
                                var selectedItem = gridLoadTracking.getSelectedRowsData()[
                                    0];
                                var ref = selectedItem.strUnickReference;
                                DevExpress.ui.dialog.confirm(
                                    "Are You sure you want to complete this Truck Load?",
                                    "Confirmation").done(function(confirmed) {
                                    if (confirmed) {
                                        completeTruckLoad(ref);
                                    } else {
                                        return;
                                    }
                                });
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-clock",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updatePlanDeparture }} != '0',
                            text: "PLAN DEPARTURE",
                            onClick: function(args) {
                                $('#planDepartureModal').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-clock",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateActualDeparture }} != '0',
                            text: "ACTUAL DEPARTURE",
                            onClick: function(args) {
                                $('#actualDepartureModal').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-check-circle",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateFleetStatus }} != '0',
                            text: "FLEET STATUS",
                            onClick: function(args) {
                                $('#tripStatusModal').data('status-type',
                                    'Fleet Controller').modal('show');
                                filterStatuses();
                            },
                        },
                    });

                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-check-circle",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateSettlementStatus }} != '0',
                            text: "SETTLEMENT STATUS",
                            onClick: function(args) {
                                $('#tripStatusModal').data('status-type',
                                    'Settlement Controller').modal('show');
                                filterStatuses();
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-question-circle",
                            disabled: this.isBtnDisabled,
                            visible: {{ $updateLostTime }} != '0',
                            text: "LOST TIME REASON",
                            onClick: function(args) {
                                $('#reasonModal').modal('show');
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            gridLoadTracking.isBtnDisabled = true;
            gridLoadTracking.repaint();

            function clearInputsAndSelect() {
                $('.form-control').val('');
                $('.form-select').val('').trigger('change');
            }

            // Event listener for modal dismiss
            $('.modal').on('hidden.bs.modal', function(e) {
                clearInputsAndSelect();
            });

            getloadTracking()

            function getloadTracking() {
                $.ajax({
                    url: "{!! url('/getLoadTracking') !!}",
                    type: "GET",
                    data: {},
                    success: function(data) {
                        gridLoadTracking.isBtnDisabled = true;
                        gridLoadTracking.repaint();
                        gridLoadTracking.clearSelection();

                        gridLoadTracking.option('dataSource', data);
                        gridLoadTracking.refresh();

                        gridData = gridLoadTracking.option("dataSource");
                    }
                });
            }

            $('#saveHorse').click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!! url('/assignHorseToPickingTicket') !!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        horse: $('#horse').val(),
                    },
                    success: function(data) {
                        getloadTracking();
                        $("#btnCloseHorse").click();
                    }
                });
            });

            $('#saveTrailor').click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!! url('/assignTrailorToPickingTicket') !!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        trailorOne: $('#trailorOne').val(),
                        trailorTwo: $('#trailorTwo').val(),
                    },
                    success: function(data) {
                        getloadTracking();
                        $("#btnCloseTrailor").click();
                    }
                });
            });

            $('#saveDriver').click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!! url('/assignDriversToPickingTicket') !!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        driverOne: $('#driverOne').val(),
                        driverTwo: $('#driverTwo').val(),
                    },
                    success: function(data) {
                        getloadTracking();
                        $("#btnCloseDriver").click();
                    }
                });
            });

            $('#saveTicket').click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var ID = selectedItem.intAutoPickingHeader;
                $.ajax({
                    url: '{!! url('/assignTicketToPickingTicket') !!}',
                    type: "POST",
                    data: {
                        ID: ID,
                        ticket: $('#ticket').val(),
                    },
                    success: function(data) {
                        getloadTracking();
                        $("#btnCloseTicket").click();
                    }
                });
            });

            $("#btnPlanDeparture").click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var strUnickReference = selectedItem.strUnickReference;

                var date = $("#inputPlannedDate").val();
                var time = $("#inputPlannedTime").val();
                // console.log("Planned date: " + date + " " + time);
                $.ajax({
                    url: "{!! url('/postLoadTrackingUpdate') !!}",
                    type: "POST",
                    data: {
                        dtmPlannedDeparture: date + " " + time,
                        strUnickReference: strUnickReference,
                        command: "plannedDeparture"
                    },
                    success: function(data) {
                        getloadTracking();
                        $('#planDepartureModal').modal('hide');
                    }
                });
            });

            $("#btnActualDeparture").click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var strUnickReference = selectedItem.strUnickReference;

                var date = $("#inputActualDate").val();
                var time = $("#inputActualTime").val();
                // console.log("Actual date: " + date + " " + time);
                $.ajax({
                    url: "{!! url('/postLoadTrackingUpdate') !!}",
                    type: "POST",
                    data: {
                        dtmActualDeparture: date + " " + time,
                        strUnickReference: strUnickReference,
                        command: "actualDeparture"
                    },
                    success: function(data) {
                        getloadTracking();
                        $('#actualDepartureModal').modal('hide');
                    }
                });
            });

            $("#btnTripStatus").click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var strUnickReference = selectedItem.strUnickReference;

                var status = $("#selectStatus").val();
                $.ajax({
                    url: "{!! url('/postLoadTrackingUpdate') !!}",
                    type: "POST",
                    data: {
                        intStatus: status,
                        strUnickReference: strUnickReference,
                        command: "status"
                    },
                    success: function(data) {
                        getloadTracking();
                        $('#tripStatusModal').modal('hide');

                    }
                });
            });

            $("#btnReason").click(function() {
                var selectedItem = gridLoadTracking.getSelectedRowsData()[0];
                var strUnickReference = selectedItem.strUnickReference;

                var ReasonType = $("#selectReasonType").val();
                var Reason = $("#inputReason").val();
                $.ajax({
                    url: "{!! url('/postLoadTrackingUpdate') !!}",
                    type: "POST",
                    data: {
                        intReasonType: ReasonType,
                        strReason: Reason,
                        strUnickReference: strUnickReference,
                        command: "reason"
                    },
                    success: function(data) {
                        getloadTracking();
                        $('#reasonModal').modal('hide');
                    }
                });
            });

            function completeTruckLoad(ref) {
                $.ajax({
                    url: '{!! url('/completeTruckLoad') !!}',
                    type: "POST",
                    data: {
                        ref: ref,
                        bitForceComplete: {{ $complete }},
                    },
                    success: function(data) {
                        if (data[0].Result == "Success") {
                            DevExpress.ui.notify({
                                message: 'Sucessfully Completed Truck Load',
                                type: 'success', // 'info', 'success', 'warning'
                                displayTime: 3500,
                            });
                            getloadTracking();
                        } else {
                            DevExpress.ui.notify({
                                message: data[0].Result,
                                type: 'error', // 'info', 'success', 'warning'
                                displayTime: 5000,
                            });
                        }
                    }
                });
            };

            function filterStatuses() {
                let selectedType = $('#tripStatusModal').data('status-type'); // Get the selected type
                $('#selectStatus').empty().append('<option></option>'); // Clear existing options

                @foreach ($statuses as $status)
                    if ('{{ $status->strType }}' === selectedType) {
                        $('#selectStatus').append(
                            `<option value="{{ $status->strStatus }}">{{ $status->strStatus }}</option>`);
                    }
                @endforeach
            }
        });
    </script>

@endsection
