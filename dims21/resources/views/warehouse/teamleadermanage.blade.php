@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Team Leaders')


{{-- Set to show navbar --}}
@php
    $includeMenu = false;
@endphp

@php
    $includePriority = false;
@endphp

@section('page')

    <!-- Multiselect -->
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet" type='text/css'>

    <style>
        .red-cell {
            background-color: red;
            color: white;
        }

        .customPadding {
            padding: 3px !important;
        }

        #gridManagementTable {
            height: 100%;
            max-height: 100%;
        }
    </style>

    <div class="col-md-12 h-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 d-flex">
                    {{-- <a id="logout" class="text-nowrap p-2"><i class="fa fa-sign-out p-0 text-dark h5" aria-hidden="true"></i></a> --}}
                    <a class="text-nowrap p-2" href= "{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i
                            class="fa fa-sign-out p-0 text-dark h5"></i></a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                    <h3 class="px-3">Team Leader Management - {{ Auth::user()->UserName }}</h3>
                </div>
                <div class="col-md-6">
                    <h4 id="loadId" class="float-end"></h4>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            @if ($ref == 0)
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1" role="tab"
                        aria-controls="content1" aria-selected="true">Management</a>
                </li>
            @else
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab1" data-bs-toggle="tab" href="#content1" role="tab"
                        aria-controls="content1" aria-selected="true">Management</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab2" data-bs-toggle="tab" href="#content2" role="tab"
                        aria-controls="content2" aria-selected="true">Pick - Load</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3" role="tab"
                        aria-controls="content3" aria-selected="false">Assign</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#content4" role="tab"
                        aria-controls="content4" aria-selected="false">Equipment</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#content5" role="tab"
                        aria-controls="content5" aria-selected="false">Notifications</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab6" data-bs-toggle="tab" href="#content6" role="tab"
                        aria-controls="content6" aria-selected="false">Instructions</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab7" data-bs-toggle="tab" href="#content7" role="tab"
                        aria-controls="content7" aria-selected="false">Status</a>
                </li>
            @endif
        </ul>

        <div class="tab-content h-auto py-3" id="tabs">
            @if ($ref == 0)
                <!-- Management -->
                <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1"
                    style="height: calc(100vh - 150px); overflow-y: auto;">
                    {{-- <div class="d-inline-flex mb-2">
                    <label class="d-flex align-items-center px-2" >Delivery Date</label>
                    <input class="form-control px-2" type="date" id='date'>
                    <button class="btn btn-success ms-1" id="getdata">SEARCH</button>
                </div> --}}

                    <div id='gridManagementTable'></div>
                </div>
            @else
                <!-- Management -->
                <div class="tab-pane fade show" id="content1" role="tabpanel" aria-labelledby="tab1"
                    style="height: calc(100vh - 150px); overflow-y: auto;">
                    <div class="d-inline-flex mb-2">
                        {{-- <label class="d-flex align-items-center px-2 text-nowrap" >Delivery Date</label>
                    <input class="form-control px-2" type="date" id='date'>
                    <button class="btn btn-success ms-1" id="getdata">SEARCH</button> --}}

                        <button class="btn btn-success ms-1 text-nowrap" id="hold">HOLD</button>
                        <button class="btn btn-secondary ms-1 text-nowrap" id="rollover" data-bs-toggle="modal"
                            data-bs-target="#rolloverModal">ROLL OVER</button>
                        <button class="btn btn-success ms-1 text-nowrap" id="complete">COMPLETE</button>
                        <button class="btn btn-primary ms-1 text-nowrap" id="invoice">INVOICE</button>
                    </div>

                    <div id='gridManagementTable'></div>
                </div>

                <!-- Pick Load -->
                <div class="tab-pane fade show active" id="content2" role="tabpanel" aria-labelledby="tab2"
                    style="height: calc(100vh - 150px); overflow-y: auto;">
                    <div id="table-container">
                        @include('warehouse/teamleaderpickloadtable')
                    </div>
                    <button class="btn btn-success mx-2" id="refresh-button" hidden>REFRESH</button>
                </div>

                <!-- Assign -->
                <div class="tab-pane fade" id="content3" role="tabpanel" aria-labelledby="tab3">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col mb-3">
                                <label for="horse" class="col-form-label">Ridgid Horse</label>
                                <select class="form-select" type="text" id='horse'>
                                    <option>
                                        @foreach ($horses as $horse)
                                    <option value="{{ $horse->TruckId }}"
                                        @if ($horse->intInUse == 1) disabled @endif>
                                        {{ $horse->TruckName }} @if ($horse->intInUse == 1)
                                            - IN USE
                                        @endif
                                    </option>
            @endforeach
            </select>
        </div>
        <div class="col mb-3">
            <label for="horse" class="col-form-label">Articulated Horse</label>
            <input class="form-control" type="text" id='horse' disabled />
        </div>
        <div class="col mb-3">
            <label for="trailorOne" class="col-form-label">Trailer One</label>
            <select class="form-select" type="text" id='trailorOne'>
                <option></option>
                @foreach ($trailors as $trailorOne)
                    <option value="{{ $trailorOne->TruckId }}" @if ($trailorOne->intInUse == 1) disabled @endif>
                        {{ $trailorOne->TruckName }} @if ($trailorOne->intInUse == 1)
                            - IN USE
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col mb-3">
            <label for="trailorTwo" class="col-form-label">Trailer Two</label>
            <select class="form-select" type="text" id='trailorTwo'>
                <option></option>
                @foreach ($trailors as $trailorTwo)
                    <option value="{{ $trailorTwo->TruckId }}" @if ($trailorTwo->intInUse == 1) disabled @endif>
                        {{ $trailorTwo->TruckName }} @if ($trailorTwo->intInUse == 1)
                            - IN USE
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col mb-3">
            <label for="ticket" class="col-form-label">Weighbridge Ticket</label>
            <select class="form-select" type="text" id='ticket'>
                <option></option>
                @foreach ($tickets as $ticket)
                    <option value="{{ $ticket->strTicket }}">{{ $ticket->strTicket }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="picker" class="col-form-label">Pickers</label>
            <select class="form-select" type="text" id='picker' multiple="multiple">
                @foreach ($pickers as $picker)
                    <option value="{{ $picker->UserID }}">{{ $picker->SageName }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-3">
            <label for="loader" class="col-form-label">Loaders</label>
            <select class="form-select" type="text" id='loader' multiple="multiple">
                @foreach ($loaders as $loader)
                    <option value="{{ $loader->UserID }}">{{ $loader->SageName }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-3">
            <label for="staging" class="col-form-label">Staging / Loading Areas</label>
            <select class="form-select" type="text" id='staging' multiple="multiple">
                @foreach ($stagingAreas as $stagingArea)
                    <option value="{{ $stagingArea->intAutoStagingId }}">{{ $stagingArea->strAreaName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="container-fluid p-0">
        <button class="btn btn-success float-end px-5 py-3" id="assign">ASSIGN</button>
    </div>
    </div>
    </div>

    <!-- Equipment -->
    <div class="tab-pane fade" id="content4" role="tabpanel" aria-labelledby="tab4">
        <div class="container-fluid">
            <div class="row">

                <div class="col mb-3">
                    <label for="belts" class="col-form-label">Belts</label>
                    <input id="belts" class="form-control" type="number">
                </div>
                <div class="col mb-3">
                    <label for="ratchets" class="col-form-label">Ratchets</label>
                    <input id="ratchets" class="form-control" type="number">
                </div>
                <div class="col mb-3">
                    <label for="tarps" class="col-form-label">Tarps</label>
                    <input id="tarps" class="form-control" type="number">
                </div>
                <div class="col mb-3">
                    <label for="dunnages" class="col-form-label">Dunnage</label>
                    <input id="dunnages" class="form-control" type="number">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="pallets" class="col-form-label">Pallets</label>
                    <input id="pallets" class="form-control" type="number">
                </div>
                <div class="col mb-3">
                    <label for="plates" class="col-form-label">Corner Plates</label>
                    <input id="plates" class="form-control" type="number">
                </div>
                <div class="col mb-3">
                    <label for="nets" class="col-form-label">Nets</label>
                    <input id="nets" class="form-control" type="number">
                </div>
                <div class="col mb-3">
                    <label for="stands" class="col-form-label">Stands</label>
                    <input id="stands" class="form-control" type="number">
                </div>
            </div>
            <div class="container-fluid p-0">
                <button class="btn btn-success float-end px-5 py-3" id="assignEquipment">ASSIGN</button>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="tab-pane fade" id="content5" role="tabpanel" aria-labelledby="tab5"
        style="height: calc(100vh - 150px); overflow-y: auto;">
        <div id="gridNotificationsTable"></div>
    </div>

    <!-- Instructions -->
    <div class="tab-pane fade" id="content6" role="tabpanel" aria-labelledby="tab6"
        style="height: calc(100vh - 150px); overflow-y: auto;">
        {{-- <div id="instructionsTable"></div> --}}
        @foreach ($instructions as $instruction)
            <h4>{{ $instruction->strType }}</h4>
            <textarea class="form-control" id="{{ $instruction->strType }}" rows="5" readonly>{{ $instruction->strInstruction }}</textarea>
        @endforeach
    </div>

    <!-- Status -->
    <div class="tab-pane fade" id="content7" role="tabpanel" aria-labelledby="tab7"
        style="height: calc(100vh - 150px); overflow-y: auto;">
        <div id="gridStatusTable"></div>
    </div>
    @endif
    </div>

    </div>

    <!-- Modal Select Printer -->
    <div class="modal modal-xl fade" id="printerModal" aria-labelledby="printerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="printerModal">Select Printer</h1>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="printer">Issued to</label>
                        <select class="form-select mx-2" type="text" id='printer'>
                            <option value="None" selected disabled></option>
                            @foreach ($printers as $printer)
                                <option value="{{ $printer->intPrinterId }}">{{ $printer->strPrinter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closePrinterModal">Close</button>
                    <button type="button" id="btnPrint" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Select Rollover Teamleader -->
    <div class="modal fade" id="rolloverModal" aria-labelledby="rolloverModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="rolloverModal">Roll Over</h1>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="printer">Team Leader</label>
                        <select class="form-select" type="text" id='teamLeader'>
                            <option value="None" selected disabled></option>
                            @foreach ($teamleaders as $teamleader)
                                <option value="{{ $teamleader->UserID }}">{{ $teamleader->FullName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closePrinterModal">Close</button>
                    <button type="button" id="btnRolloverTeamleader" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <!-- Multiselect -->
    <script src="{{ asset('js/jquery.multiselect.js') }}"></script>

    <script>
        var data = [];
        let intInvoiceStatus;
        let holdStatus;
        let teamleadertwo;

        $(document).ready(function() {
            $('#horse').select2({
                theme: 'bootstrap-5',
            });

            $('#trailorOne').select2({
                theme: 'bootstrap-5',
            });

            $('#trailorTwo').select2({
                theme: 'bootstrap-5',
            });

            $('#teamLeader').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#rolloverModal'),
            });

            $('#picker').multiselect({
                columns: 5,
                placeholder: 'Select Pickers',
                selectAll: true,
            });

            $('#loader').multiselect({
                columns: 5,
                placeholder: 'Select Loader',
                selectAll: true,
            });

            $('#staging').multiselect({
                columns: 5,
                placeholder: 'Select Staging Area',
                selectAll: true,
            });

            $('#ticket').select2({
                theme: 'bootstrap-5',
            });

            var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization

            const gridManagementTable = $('#gridManagementTable').dxDataGrid({
                dataSource: data, //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    mode: 'virtual', // Enable infinite scrolling
                },
                paging: {
                    pageSize: 10,
                },
                selection: {
                    mode: "single",
                },
                columns: [{
                        dataField: "intSequenceLoad",
                        caption: "Seq",
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
                        caption: "Reference",
                        visible: false,
                    },
                    {
                        dataField: "intLoadID",
                        caption: "Assigned Loads",
                        calculateCellValue: function(data) {
                            return "TL" + data.intLoadID;
                        },
                    }, {
                        dataField: "strRouteName",
                        caption: "Route Name",
                    },
                    {
                        dataField: "intItemsAssigned",
                        caption: "Items Assigned",
                        cellTemplate: function(container, options) {
                            const value = options.data.intItemsAssigned;
                            if (value == 0) {
                                container.addClass("bg-danger text-white");
                                container.text('Not Assigned');

                            } else if (value == 1) {
                                container.addClass("bg-success text-white");
                                container.text('Assigned');
                            }

                        },
                    },
                    {
                        dataField: "intEquipmentAssigned",
                        caption: "Equipment Assigned",
                        cellTemplate: function(container, options) {
                            const value = options.data.intEquipmentAssigned;
                            if (value == 0) {
                                container.addClass("bg-danger text-white");
                                container.text('Not Assigned');

                            } else if (value == 1) {
                                container.addClass("bg-success text-white");
                                container.text('Assigned');
                            }

                        },
                    },
                    {
                        dataField: "intNotifications",
                        caption: "Outstanding Notifications",
                        cellTemplate: function(container, options) {
                            const value = options.data.intNotifications;
                            if (value == 0) {
                                container.addClass("bg-danger text-white");
                                container.text('Outstanding');

                            } else if (value == 1) {
                                container.addClass("bg-success text-white");
                                container.text('None Outstanding');
                            }

                        },
                    },
                    {
                        dataField: "strLoadStatus",
                        caption: "Status",
                        // visible: false,
                    },
                    {
                        dataField: "intStatus",
                        caption: "Status",
                        visible: false,
                    },
                    {
                        dataField: "intInvoiceStatus",
                        caption: "Status",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "intTeamLeaderTwoId",
                        caption: "team Leader Two",
                        dataType: "number",
                        visible: false,
                    },


                ],
                onRowClick: function(e) {

                },
                onRowDblClick: function(e) {
                    window.location.href = '{!! url('/teamleadermanage') !!}/' + e.data.strUnickReference;
                },
                onInitNewRow: function(e) {
                    console.debug(e);
                },
                onRowInserting: function(e) {
                    console.debug(e);
                },
                onRowInserted: function(e) {
                    console.debug(e);
                },
                onRowUpdating: function(e) {
                    console.debug(e);
                },
                // onToolbarPreparing: function (e) {
                //     e.toolbarOptions.items.push({
                //         location: 'before',
                //         widget: "dxButton",
                //         options: {
                //             icon: "fa-regular fa-circle-pause",
                //             text: "hold",
                //             elementAttr: {
                //                 id: "hold",
                //             },
                //         },
                //     });
                //     e.toolbarOptions.items.push({
                //         location: 'before',
                //         widget: "dxButton",
                //         options: {
                //             icon: "fa-solid fa-right-left",
                //             text: "ROLL OVER",
                //             onClick: function(e) {
                //                 $('#rolloverModal').modal('show');
                //             },
                //         },
                //     });
                //     e.toolbarOptions.items.push({
                //         location: 'before',
                //         widget: "dxButton",
                //         options: {
                //             icon: "fa-regular fa-circle-check",
                //             text: "COMPLETE",
                //             elementAttr: {
                //                 id: "complete",
                //             },
                //         },
                //     });
                //     e.toolbarOptions.items.push({
                //         location: 'before',
                //         widget: "dxButton",
                //         options: {
                //             icon: "fa-regular fa-file-lines",
                //             text: "INVOICE",
                //             elementAttr: {
                //                 id: "invoice",
                //             },
                //         },
                //     });
                // }
            }).dxDataGrid('instance');

            const gridNotificationsTable = $("#gridNotificationsTable").dxDataGrid({
                dataSource: data,
                showBorders: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                selection: {
                    mode: "single",
                },
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging: {
                    pageSize: 2000,
                },
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "nextColumn",
                columns: [{
                        dataField: "intAutoID",
                        caption: "ID",
                        visible: false,
                    }, {
                        dataField: "strUnickReference",
                        caption: "Reference",
                        visible: false,
                    }, {
                        dataField: "intAutoPickingHeader",
                        caption: "Truck Load",
                        calculateCellValue: function(data) {
                            return "TL" + data.intAutoPickingHeader;
                        },
                        visible: false,

                    }, {
                        dataField: "intOrderID",
                        caption: "Order ID",
                        visible: false,
                    }, {
                        dataField: "createdBy",
                        caption: "Created By",

                    }, {
                        dataField: "dtmCreated",
                        caption: "Date Created",

                    }, {
                        dataField: "strItemCode",
                        caption: "Product Code",

                    }, {
                        dataField: "strStatus",
                        caption: "Status",

                    }, {
                        dataField: "strSONumber",
                        caption: "SO Number",

                    }, {
                        dataField: "mnyQty",
                        caption: "Qty",

                    }, {
                        dataField: "strMessage",
                        caption: "Message",

                    }, {
                        dataField: "approvedBy",
                        caption: "Team Leader",

                    }, {
                        dataField: "dtmApproved",
                        caption: "Date Approved",

                    }, {
                        dataField: "bitApproved",
                        caption: "Approved / Unaprove",
                        cellTemplate: function(container, options) {
                            const value = options.data.bitApproved;
                            if (value == null) {
                                const buttonApprove = $(
                                        "<button class='btn btn-success w-50 rounded-0 rounded-start'>"
                                    )
                                    .html("<i class='fa-regular fa-thumbs-up'></i>")
                                    .on("click", function() {
                                        approveNotification(options.data.intAutoID);
                                    });
                                const buttonUnapprove = $(
                                        "<button class='btn btn-danger w-50 rounded-0 rounded-end'>"
                                    )
                                    .html("<i class='fa-regular fa-thumbs-down'></i>")
                                    .on("click", function() {
                                        unapproveNotification(options.data.intAutoID);
                                    });
                                container.append(buttonApprove);
                                container.append(buttonUnapprove);
                                container.addClass("customPadding");

                            } else if (value == 1) {
                                const txtApproved = $("<p>Approved</p>")

                                const buttonReverse = $("<button class='btn btn-danger'>")
                                    .html("<i class='fa-solid fa-rotate-left'></i>")
                                    .on("click", function() {
                                        reverseApproval(options.data.intAutoID);
                                    });

                                container.text('Approved').css("margin", "auto");
                                container.append(buttonReverse);
                                container.addClass("bg-success text-white");

                                buttonReverse.css("float", "right");

                            } else if (value == 0) {
                                container.text('Unaproved');
                                container.addClass("bg-danger text-white");
                            }

                        },
                    },

                ],
                onRowPrepared(e) {

                },
                onRowClick: function(e) {

                },
                onRowDblClick: function(e) {

                },
                onInitNewRow: function(e) {

                },
                onRowInserting: function(e) {

                },
                onRowInserted: function(e) {

                },
                onRowUpdating: function(e) {

                }
            }).dxDataGrid('instance');

            const gridStatusTable = $('#gridStatusTable').dxDataGrid({
                dataSource: [], //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    mode: 'virtual', // Enable infinite scrolling
                },
                paging: {
                    pageSize: 10,
                },
                columns: [{
                        dataField: 'strLoadStatus',
                        caption: 'Load Status',
                    },
                    {
                        dataField: 'strPickingStatus',
                        caption: 'Picking Status',
                        dataType: 'number',
                        cellTemplate: function(container, options) {
                            $('<div>')
                                .appendTo(container)
                                .text(options.value.toFixed(2) + '%');
                        }
                    },
                    {
                        dataField: 'strPickingTimeRequired',
                        caption: 'Picking Time Req',
                    },
                    {
                        dataField: 'dtmStartPicking',
                        caption: 'Picking Time Start',
                    },
                    {
                        dataField: 'dtmEndPicking',
                        caption: 'Picking Time Finish',
                    },
                    {
                        dataField: 'strLoadingStatus',
                        caption: 'Loading Status',
                        dataType: 'number',
                        cellTemplate: function(container, options) {
                            $('<div>')
                                .appendTo(container)
                                .text(options.value.toFixed(2) + '%');
                        }
                    },
                    {
                        dataField: 'strLoadingTimeRequired',
                        caption: 'Loading Time Req',
                    },
                    {
                        dataField: 'dtmStartLoading',
                        caption: 'Loading Time Start',
                    },
                    {
                        dataField: 'dtmEndLoading',
                        caption: 'Loading Time Finish',
                    },

                ],
                onRowDblClick: function(e) {
                    console.debug(e);
                },
                onInitNewRow: function(e) {
                    console.debug(e);
                },
                onRowInserting: function(e) {
                    console.debug(e);
                },
                onRowInserted: function(e) {
                    console.debug(e);
                },
                onRowUpdating: function(e) {
                    console.debug(e);
                },
            }).dxDataGrid('instance');

            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
            var day = ("0" + currentDate.getDate()).slice(-2);
            var formattedDate = year + "-" + month + "-" + day;

            $('#date').val(formattedDate);

            if ('{{ $ref }}' != '0') {
                getPickingPlanData('{{ $ref }}');
                getNotifications('{{ $ref }}');
                getStatus('{{ $ref }}');
            }

            $('#getdata').click(function() {
                getData();
            });

            getData();

            $('#invoice').click(function() {
                var ref = '{{ $ref }}';
                // alert('invoicing');
                initInvoice(ref);
            });

            $('#rolloverBtn').click(function() {
                var ref = '{{ $ref }}';
                rollover(ref);
            });

            $('#hold').click(function() {
                var ref = '{{ $ref }}';
                var currentStatus = holdStatus;

                if (currentStatus == 2) {
                    var status = 0;
                } else {
                    var status = 2;
                }

                updateHoldStatus(ref, status);
            });

            $('#assign').click(function() {
                const ref = '{{ $ref }}';
                const horse = $('#horse').val();
                const trailorOne = $('#trailorOne').val();
                const trailorTwo = $('#trailorTwo').val();
                const picker = $('#picker').val();
                const loader = $('#loader').val();
                const staging = $('#staging').val();
                const ticket = $('#ticket').val();
                const prompt = 'update';
                const stringPickers = picker.join(',');
                const stringLoaders = loader.join(',');
                const stringStaging = staging.join(',');

                AssignData(ref, horse, trailorOne, trailorTwo, stringPickers, stringLoaders, stringStaging,
                    ticket, prompt);
            });

            $('#assignEquipment').click(function() {
                const ref = '{{ $ref }}';
                const belts = $('#belts').val() || 'null';
                const ratchets = $('#ratchets').val() || 'null';
                const tarps = $('#tarps').val() || 'null';
                const dunnages = $('#dunnages').val() || 'null';
                const pallets = $('#pallets').val() || 'null';
                const plates = $('#plates').val() || 'null';
                const nets = $('#nets').val() || 'null';
                const stands = $('#stands').val() || 'null';

                assignEquipment(ref, belts, ratchets, tarps, dunnages, pallets, plates, nets, stands);
            });

            $('#complete').click(function() {
                const ref = '{{ $ref }}';
                completeTruckLoad(ref);
            });

            $('.btnFinishPickingWeighted').click(function() {
                var id = $(this).val();
                completeLoad(id);
            });

            $('#refresh-button').on('click', function() {
                updatePickingLoading('{{ $ref }}');
            });

            $('#btnRolloverTeamleader').click(function() {
                var ref = '{{ $ref }}';
                rollover(ref);
            });
            $('#pickLoadTable tbody').on('dblclick', 'tr', function() {
                var intAutoPickinghidden = $(this).find('.intAutoPickinghidden').val();
                var producutDescr = $(this).closest("tr").find('td:eq(2)').text();
                var hasLabel = $(this).find('.hasLabel').val();
                console.debug("intAutoPickinghidden++++" + intAutoPickinghidden);
                console.debug("hasLabel++++" + hasLabel);
                if (hasLabel == 0) {
                    //Basic manual input
                    const userInput = prompt(producutDescr, "");
                    if (userInput !== null && userInput.trim() !== "" && intAutoPickinghidden !== null &&
                        intAutoPickinghidden.trim() !== "") {
                        $.ajax({
                            url: '{!! url('/updatemanualloadingifitemhasnolabelatall') !!}',
                            type: "POST",
                            data: {
                                userInput: userInput,
                                intAutoPickinghidden: intAutoPickinghidden

                            },
                            success: function(data) {
                                // console.log(data);
                                if (data.Result == "SUCCESS") {
                                    location.reload();
                                }

                            },
                            error: function(error) {
                                console.error("Error loading data: ", error);
                            }
                        });
                    } else {
                        console.debug("You clicked Cancel or closed the dialog.");
                    }
                }
            });

            $('#loadId').on('dblclick', function() {
                // Code to be executed when the element is double-clicked

                var tls = $('#loadId').text();
                tls = tls.replace("TL", '');

                const userInputYesNo = prompt("Please Type in the word YES for " + $('#loadId').text(), "");
                if (userInputYesNo !== null && userInputYesNo.trim() !== "" && userInputYesNo.trim()
                    .toUpperCase() === "YES") {
                    $.ajax({
                        url: '{!! url('/printtripsheetmobile') !!}',
                        type: "POST",
                        data: {
                            userInput: userInputYesNo,
                            truckloadno: tls

                        },
                        success: function(data) {
                            // console.log(data);
                            if (data[0].Result == "SUCCESS") {
                                alert("Check your printer");
                                location.reload();
                            }

                        },
                        error: function(error) {
                            console.error("Error loading data: ", error);
                        }
                    });
                } else {
                    console.debug("You clicked Cancel or closed the dialog.");
                }
            });

            function getData() {
                $.ajax({
                    url: '{!! url('/getTeamLeaderPlans') !!}',
                    type: "GET",
                    data: {
                        date: $('#date').val(),
                    },
                    success: function(data) {
                        gridManagementTable.option('dataSource', data);
                        gridManagementTable.refresh();

                        var currentRef = '{{ $ref }}';

                        var result = $.grep(data, function(obj) {
                            return obj.strUnickReference === currentRef;
                        });

                        if (result.length > 0) {
                            intInvoiceStatus = result[0].intInvoiceStatus;
                            holdStatus = result[0].intStatus;
                            teamLeadertwo = result[0].intTeamLeaderTwoId;
                            $('#teamLeader').val(teamLeadertwo).trigger('change');
                        }

                        if (intInvoiceStatus == 1) {
                            $("#invoice").prop("disabled", false);
                        } else {
                            $("#invoice").prop("disabled", true);
                        }

                        // if (holdStatus == 2){
                        //     var holdButton = $("#hold").dxButton("instance");
                        //     holdButton.option("text", "UNHOLD");
                        //     holdButton.option("icon", "fa-regular fa-circle-play");


                        // }else{
                        //     var holdButton = $("#hold").dxButton("instance");
                        //     holdButton.option("text", "HOLD");
                        //     holdButton.option("icon", "fa-regular fa-circle-pause");
                        // }

                        if (holdStatus == 2) {
                            $("#hold").addClass("btn-danger", true);
                            $("#hold").removeClass("btn-success", true);
                            $("#hold").text('UNHOLD');
                        } else {
                            $("#hold").addClass("btn-success", true);
                            $("#hold").removeClass("btn-danger", true);
                            $("#hold").text('HOLD');
                        }
                    },
                    error: function(error) {
                        console.error("Error loading data: ", error);
                    }
                });
            };

            function getStatus(ref) {
                $.ajax({
                    url: '{!! url('/teamLeaderGetStatus') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                    },
                    success: function(data) {
                        // console.log(data);
                        gridStatusTable.option('dataSource', data);
                        gridStatusTable.refresh();
                    },
                    error: function(error) {
                        console.error("Error loading data: ", error);
                    }
                });
            };


            function updatePickingLoading(ref) {
                $.ajax({
                    url: '{!! url('/teamleaderUpdatePickingLoadingTable') !!}',
                    method: 'GET',
                    data: {
                        ref: ref,
                    },
                    success: function(data) {
                        // Update the $listproducts variable with the new data
                        var newListProducts = data; // Assuming 'data' contains the new list of products

                        // Update the included view with the new data
                        $('#table-container').html(newListProducts);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            function getPickingPlanData(ref) {
                $.ajax({
                    url: '{!! url('/teamLeaderGetPickingPlanData') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                    },
                    success: function(data) {
                        if (data[0]) {
                            let pickersList;
                            if (data[0]['strPicking'] == null) {
                                pickersList = null;
                            } else {
                                const pickers = data[0]['strPicking'];
                                pickersList = pickers.split(",");
                            }

                            let loadersList;
                            if (data[0]['strLoading'] == null) {
                                loadersList = null;
                            } else {
                                const loaders = data[0]['strLoading'];
                                loadersList = loaders.split(",");
                            }

                            let stagingList;
                            if (data[0]['strStagingArea'] == null) {
                                stagingList = null;;
                            } else {
                                const staging = data[0]['strStagingArea'];
                                stagingList = staging.split(",");
                            }

                            $('#loadId').text('TL' + data[0]['intAutoPickingHeader']);
                            $('#date').val(data[0]['dtm']);

                            $("#horse option[value='" + data[0].strTrailorNo + "']").prop('disabled',
                                false);
                            $('#horse').val(data[0].strTrailorNo).trigger('change');

                            $("#trailorOne option[value='" + data[0].strTrailorone + "']").prop(
                                'disabled', false);
                            $('#trailorOne').val(data[0]['strTrailorone']).trigger('change');

                            $("#trailorTwo option[value='" + data[0].strTrailortwo + "']").prop(
                                'disabled', false);
                            $('#trailorTwo').val(data[0]['strTrailortwo']).trigger('change');

                            $('#staging').val(data[0]['']).trigger('change');
                            $('#ticket').val(data[0]['strTicket']).trigger('change');
                            $('#belts').val(data[0]['intBelts']);
                            $('#ratchets').val(data[0]['intStraps']);
                            $('#tarps').val(data[0]['intTarps']);
                            $('#dunnages').val(data[0]['intDunnages']);
                            $('#pallets').val(data[0]['intPallets']);
                            $('#plates').val(data[0]['intPlasticCorners']);
                            $('#nets').val(data[0]['intNets']);
                            $('#stands').val(data[0]['intStans']);

                            for (var i in pickersList) {
                                var val = pickersList[i];
                                $("#picker").find("option[value=" + val + "]").prop("selected",
                                    "selected");
                            }
                            $("#picker").multiselect('reload');

                            for (var i in loadersList) {
                                var val = loadersList[i];
                                $("#loader").find("option[value=" + val + "]").prop("selected",
                                    "selected");
                            }
                            $("#loader").multiselect('reload');

                            for (var i in stagingList) {
                                var val = stagingList[i];
                                $("#staging").find("option[value=" + val + "]").prop("selected",
                                    "selected");
                            }
                            $("#staging").multiselect('reload');
                            getData();
                        }
                    }
                });
            };

            function getNotifications(ref) {
                $.ajax({
                    url: '{!! url('/teamLeaderGetNotifications') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                    },
                    success: function(data) {
                        // console.log(gridNotificationsTable);
                        gridNotificationsTable.option('dataSource', data);
                        gridNotificationsTable.refresh();

                        var hasRowWithBitApprovedZero = false;

                        // Iterate through your data array
                        for (var i = 0; i < data.length; i++) {
                            // Assuming 'bitApproved' is a property in each object
                            var bitApproved = data[i].bitApproved;

                            if (bitApproved == null) {
                                hasRowWithBitApprovedZero = true;
                                break; // Exit the loop if we find a row with bitApproved equal to 0
                            }
                        }

                        // Add or remove 'bg-warning' class based on the result
                        if (hasRowWithBitApprovedZero) {
                            $('#tab5').addClass('bg-warning');
                        } else {
                            $('#tab5').removeClass('bg-warning');
                        }
                    }
                });
            };

            function AssignData(ref, horse, trailorOne, trailorTwo, picker, loader, staging, ticket, prompt) {
                $.ajax({
                    url: '{!! url('/teamLeaderAssign') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                        horse: horse,
                        trailorOne: trailorOne,
                        trailorTwo: trailorTwo,
                        picker: picker,
                        loader: loader,
                        staging: staging,
                        ticket: ticket,
                        prompt: prompt,
                    },
                    success: function(data) {
                        // location.reload();
                        alert('Updated');
                        getData();
                    }
                });
            };

            function assignEquipment(ref, belts, ratchets, tarps, dunnages, pallets, plates, nets, stands) {
                $.ajax({
                    url: '{!! url('/teamLeaderEquipmentAssign') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                        belts: belts,
                        ratchets: ratchets,
                        tarps: tarps,
                        dunnages: dunnages,
                        pallets: pallets,
                        plates: plates,
                        nets: nets,
                        stands: stands
                    },
                    success: function(data) {
                        alert('Updated');
                        getData();
                    }
                });
            };

            function approveNotification(id) {
                $.ajax({
                    url: '{!! url('/teamLeaderApproveNotification') !!}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        alert('Updated');
                        getData();
                        getNotifications('{{ $ref }}');
                    }
                });
            };

            function unapproveNotification(id) {
                $.ajax({
                    url: '{!! url('/teamLeaderUnapproveNotification') !!}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        alert('Updated');
                        getData();
                        getNotifications('{{ $ref }}');
                    }
                });
            };

            function reverseApproval(id) {
                $.ajax({
                    url: '{!! url('/teamLeaderReveseApprovedNotification') !!}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        alert('Updated');
                        getData();
                        getNotifications('{{ $ref }}');
                    }
                });
            };

            function getPickingPlanToInvoice(ref) {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: '{!! url('/teamLeaderGetPickingPlanToInvoice') !!}',
                        type: "get",
                        data: {
                            ref: ref,
                        },
                        success: function(data) {
                            resolve(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            reject(errorThrown);
                        }
                    });
                });
            };

            function initInvoice(strUnickReference) {
                getPickingPlanToInvoice(strUnickReference)
                    .then(function(pickingplan) {
                        $('#invoice').prop('disabled', true);
                        // console.log(pickingplan);
                        var invoiceList = $.map(pickingplan, function(item) {
                            return {
                                intOwnerID: item.intOwnerID,
                                OrderNum: item.OrderNum,
                                OrderId: item.OrderId,
                                strUnickReference: item.strUnickReference,
                                UserId: {{ Auth::user()->UserID }},
                                UserName: '{{ Auth::user()->UserName }}'
                            };
                        });

                        // Function to check if all properties in the objects are the same
                        function areAllPropertiesEqual(obj1, obj2) {
                            for (const key in obj1) {
                                if (obj1.hasOwnProperty(key)) {
                                    if (obj1[key] !== obj2[key]) {
                                        return false;
                                    }
                                }
                            }
                            return true;
                        }

                        // Function to remove rows with all properties being the same
                        function removeDuplicateRows(arr) {
                            return arr.filter((item, index) => {
                                // Keep the first occurrence of each row
                                return index === arr.findIndex((obj) => areAllPropertiesEqual(obj,
                                    item));
                            });
                        }

                        // Call the function to remove duplicate rows from the data array
                        invoiceList = removeDuplicateRows(invoiceList);

                        invoiceOut(invoiceList);
                        // alert('Disabled by the developer for testing')
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                    });
            };

            function invoiceOut(inputdata) {
                // Create a Set to track unique keys
                let seen = new Set();

                // Filter out duplicates based on key fields
                let uniqueInputData = inputdata.filter(item => {
                    let key = `${item.intOwnerID}-${item.OrderNum}-${item.OrderId}-${item.strUnickReference}`;
                    if (seen.has(key)) return false;
                    seen.add(key);
                    return true;
                });

                // Process only unique items
                $.each(uniqueInputData, function(index, item) {
                    var ownersId = item.intOwnerID;
                    var SoNumber = item.OrderNum;
                    var invoiceid = item.OrderId;
                    var ref = item.strUnickReference;
                    var userid = item.UserId;
                    var userName = item.UserName;

                    $.ajax({
                        url: '{!! url('/individualInvoicingAPI') !!}' + '/' + ownersId + '/' + SoNumber + '/' +
                            invoiceid + '/' + ref + '/' + userid + '/' + userName,
                        type: "get",
                        success: function(outputData) {
                            console.debug(outputData);

                            if (outputData === "Credit Limit") {
                                alert("CREDIT LIMIT ISSUES");
                            } else {
                                printTripSheet(ref);
                            }
                        }
                    });
                });
            }


            function printTripSheet(ref) {
                $.ajax({
                    url: '{!! url('/teamLeaderPrintTripSheet') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                    },
                    success: function(data) {
                        alert('Invoiced and printed sucessfully.');
                        getData();
                        getNotifications('{{ $ref }}');
                    }
                });
            };

            function completeLoad(id) {
                $.ajax({
                    url: '{!! url('/teamLeaderCompleteLoad') !!}',
                    type: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            };

            function completeTruckLoad(ref) {
                $.ajax({
                    url: '{!! url('/completeTruckLoad') !!}',
                    type: "POST",
                    data: {
                        ref: ref,
                    },
                    success: function(data) {
                        if (data[0].Result == "Success") {
                            location.reload();
                        } else {
                            alert(data[0].Result);
                        }
                    }
                });
            };

            function updateHoldStatus(ref, status) {
                $.ajax({
                    url: '{!! url('/teamleaderupdateholdstatus') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                        status: status,
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            };

            function rollover(ref) {
                $.ajax({
                    url: '{!! url('/teamleaderollover') !!}',
                    type: "GET",
                    data: {
                        ref: ref,
                        teamLeader: $('#teamLeader').val(),

                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            };

        });
    </script>

@endsection
