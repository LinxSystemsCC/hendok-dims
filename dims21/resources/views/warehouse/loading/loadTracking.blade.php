@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Load Tracking')


{{-- Set to show navbar --}}
@php
    $includeMenu = false;
@endphp

@section('page')

    <div id="gridLoadTracking" class="col-lg-12"></div>

    <div class="modal fade modal-md" id="planDepartureModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
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

    <div class="modal fade modal-md" id="tripStatusModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
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
                        dataField: "date",
                        caption: "Date Created",
                        calculateCellValue: function(rowData) {
                            // Extract the date part from the "dtm" field
                            const dtm = new Date(rowData.dtm);
                            return dtm.toLocaleDateString("en-ZA");
                        },
                    },
                    {
                        dataField: "time",
                        caption: "Time Created",
                        calculateCellValue: function(rowData) {
                            // Extract the time part from the "dtm" field
                            const dtm = new Date(rowData.dtm);
                            return dtm.toLocaleTimeString();
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
                        dataField: "strDestination",
                        caption: "Destination",
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

                        // $("#inputPlannedDate").val(e.data.dtmPlannedDeparture);
                        // $("#inputPlannedTime").val(e.data.dtmPlannedDeparture);

                        // $("#inputActualDate").val(e.data.dtmActualDeparture);
                        // $("#inputActualTime").val(e.data.dtmActualDeparture);

                        // $("#selectStatus").text(e.data.strLoadStatus).trigger("change");;
                        // $("#selectReasonType").val(e.data.intReasonType).trigger("change");;

                        // console.log(e.data);
                    }
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3 class="ps-3">').text('Load Tracking');
                        }
                    });
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
                            icon: "fa fa-clock",
                            disabled: this.isBtnDisabled,
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
                            text: "TRIP STATUS",
                            onClick: function(args) {
                                $('#tripStatusModal').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-question-circle",
                            disabled: this.isBtnDisabled,
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
        });
    </script>

@endsection
