@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Wiredraw Headers')



{{-- Set to show navbar --}}
@php
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
        $nwo = $v->getThingsUserPermissions(Auth::user()->UserID, 'New Work Order');
    }

    $includeMenu = true;

@endphp

@section('page')

    <style>
        #grid {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>


    <div class="col-12 h-100" style="display: flex; flex-direction: column;">
        <div class="col-12" id="tabs">
            @if ($nwo != '0')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createjob">
                    Create Job
                </button>
            @endif

            @if ($nwo != '0')
                <button type="button" id="completejob" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#finalisejob" disabled>
                    Complete Job
                </button>
            @endif

            @if ($nwo != '0')
                <button type="button" id="jobCard" class="btn btn-success" disabled>
                    QC Job Card
                </button>
            @endif
        </div>

        <div id="gridShiftData" style="width: 100% !important;"></div>

        <div id="gridWorkInProgress" style="width: 100% !important; flex-grow: 1;"></div>

        <!-- Finalise Job Modal -->
        <div class="modal fade" id="finalisejob" aria-labelledby="finalisejob" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="finalisejob">Complete Job</h5>
                    </div>
                    <div class="modal-body">
                        <h6 id="JobEndTextMessage">ARE YOU SURE YOU WANT TO COMPLETE THIS JOB?</h6>
                    </div>
                    <div class="modal-footer d-inline">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="closeFinaliseJob">CLOSE</button>
                        <button class="btn btn-danger" id="completesave">COMPLETE</button>
                    </div>
                </div>
            </div>
        </div>

        <div title="Job Creation" id="createjob" class="modal modal-xl fade" tabindex="-1" role="dialog"
            aria-labelledby="createjob" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createjob">Create A Work Order</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label" for="reference">References</label>
                                <input type="text" maxlength="15" class="form-control" id="strReference" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="department">Type</label>
                                <select class="form-select" id="strType" required>
                                    <option value="select" selected>Select Type</option>
                                    <option value="customer">Customer</option>
                                    <option value="internal">Internal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="customers" class="col-form-label">Customer</label>
                                <select class="form-select" type="text" id='intCustomerId'>
                                    <option value="select" selected>Select Customer</option>
                                    @foreach ($customers as $val)
                                        <option value="{{ $val->intCustomerId }}">{{ $val->strCustomerName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="wiresize">Select Machine</label>
                                <select class="form-select" id="intWireDrawMachineId" required>
                                    <option value="select" selected>select Machine</option>
                                    @foreach ($data as $val)
                                        <option value="{{ $val->intMachineID }}">{{ $val->strMachineName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="prodname">Product</label>
                                <select class="form-select" id="intProductId" required>
                                    <option value="select" selected>Select Product</option>
                                    @foreach ($products as $val)
                                        <option value="{{ $val->intProductId }}">{{ $val->strProductName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="qty">Mass Required</label>
                                <input type="text" class="form-control" id="fltMassRequired" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" id="saveGalvJob" style="width: 100%;">SAVE</button> --}}
                        <button type="button" class="btn btn-secondary" data-bs-target="#createjob" data-bs-toggle="modal"
                            id="cancelCreateJob">CANCEL</button>
                        <button type="button" id="saveGalvJob" class="btn btn-success" data-bs-target="#createjob"
                            data-bs-toggle="modal">SAVE</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            var max_length = 15;
            $('#reference').keyup(function() {
                var len = max_length - $(this).val().length;
            });

            $('#products').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#createjob'),
            });

            $('#strType').change(function() {
                if ($('#strType').val() == 'internal') {
                    $('#intCustomerId').attr('disabled', true)
                } else {
                    $('#intCustomerId').attr('disabled', false)
                }
            });

            $('#prodname').change(function() {
                $.ajax({

                    url: '{!! url('/wmaxgetproductwiresize') !!}',
                    type: "GET",
                    data: {
                        productId: $("#prodname").val()
                    },
                    success: function(data) {
                        var toAppend = '';
                        $("#wiresize").empty();
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + parseFloat(o.WireSize)
                                .toFixed(2) + '">' + parseFloat(o.WireSize).toFixed(2) +
                                '</option>';
                        });

                        $("#wiresize").append(toAppend);
                        $("#wiresize").select2({
                            theme: 'bootstrap-5',
                            dropdownParent: $('#createjob'),
                        });


                    }
                });
            });

            $('#department').change(function() {

                $.ajax({

                    url: '{!! url('/wmaxdepartmentmachinesgalv') !!}',
                    type: "GET",
                    data: {
                        deptId: $('#department').val(),
                    },
                    success: function(data) {
                        console.log(data);
                        var data = data.filter(function(item) {
                            return item.strMachineName.includes("Take-Up");
                        });

                        var toAppend = '';
                        $("#strMachineName").empty();
                        toAppend += '<option value="None"></option>';
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + o.intWireDrawMachineId +
                                '">' + o
                                .strMachineName + '</option>';
                        });
                        $("#strMachineName").append(toAppend);
                        $("#strMachineName").select2({
                            theme: 'bootstrap-5',
                            dropdownParent: $('#createjob'),
                        });

                    }

                });
            });

            $('#completesave').click(function() {

                var selectedItem = $("#gridWorkInProgress").dxDataGrid("instance").getSelectedRowsData()[0];
                var JobId = selectedItem.JobNo;
                // console.log(JobId);
                $.ajax({

                    url: '{!! url('/changeGalvJobStatus') !!}',
                    type: "GET",
                    data: {
                        JobId: JobId,
                    },
                    success: function(data) {
                        alert("Job Completed!");
                        getWorkInProgress();
                        getShiftData();
                    }
                });
            });

            $('#saveGalvJob').click(function() {

                $(this).prop("disabled", true);
                var textbox = $('#strReference').val();
                var intCustomerId = $('#intCustomerId').val();
                length = textbox.length;
                if ($('#strType').val() == 'internal') {
                    intCustomerId = 0;
                }

                $.ajax({
                    url: '{!! url('wire-draw/headers') !!}',
                    type: "POST",
                    data: {
                        intCustomerId: intCustomerId,
                        intProductId: $('#intProductId').val(),
                        intWireDrawMachineId: $('#intWireDrawMachineId').val(),
                        strType: $('#strType').val(),
                        fltMassRequired: $('#fltMassRequired').val(),
                        strReference: $('#strReference').val()
                    },
                    success: function(data) {
                        if (data.success) {
                            location.reload();
                        }
                    },
                });

            });

            var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization
            var customers = {!! json_encode($customers) !!};
            console.log(customers);

            $.ajax({
                url: '{{ route('wire-draw.headers.get-headers') }}',
                type: "GET",
                success: function(data) {
                    const gridWorkInProgress = $("#gridWorkInProgress").dxDataGrid({
                        dataSource: data.headers,
                        hoverStateEnabled: true,
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
                        allowColumnResizing: true,
                        columnAutoWidth: true,
                        scrolling: {
                            rowRenderingMode: 'infinite',
                        },
                        paging: {
                            pageSize: 20,
                        },
                        pager: {
                            visible: true,
                            allowedPageSizes: [5, 10, 20, 50, 'all'],
                            showPageSizeSelector: true,
                            showInfo: true,
                            showNavigationButtons: true,
                        },
                        selection: {
                            mode: "single",
                            rowCssClass: 'custom-selected-row'
                        },
                        columns: [{
                                dataField: "intHeaderId",
                                caption: "Job No.",
                            },
                            {
                                dataField: "strReference",
                                caption: "Reference",
                            },
                            {
                                dataField: "strCustomerName",
                                caption: "Customer Name",
                            },
                            {
                                dataField: "dtDateStart",
                                caption: "Date Start",
                            },
                            {
                                dataField: "dtDateEnd",
                                caption: "Date End",
                            },
                            {
                                dataField: "strMachineName",
                                caption: "Wire Draw Machine",
                            },
                            {
                                dataField: "strProductName",
                                caption: "Product",
                            },
                            {
                                dataField: "fltMassRequired",
                                caption: "Mass Required",
                            },
                            {
                                dataField: "intMassProduced",
                                caption: "Mass Produced",
                            },
                            {
                                dataField: "intNoOfStands",
                                caption: "No Of Stands",
                            }
                        ],
                        onRowDblClick: function(e) {
                            // Handle double click event here
                        },
                        onRowClick: function(e) {
                            var currentID = currentSelectedRow[0];
                            var clickedID = e.data.intHeaderId;

                            if (clickedID === currentID) {
                                currentSelectedRow = [];
                                e.component.clearSelection();
                                $("#completejob").prop("disabled", true);
                                $("#jobCard").prop("disabled", true);
                            } else {
                                currentSelectedRow = [];
                                currentSelectedRow.push(clickedID);

                                $("#JobEndTextMessage").css("white-space", "pre-wrap");
                                $("#JobEndTextMessage").text(
                                    "ARE YOU SURE YOU WANT TO COMPLETE JOB: " +
                                    clickedID +
                                    "? \nTHE JOB WILL NO LONGER BE ACCESSIBLE ANYMORE"
                                );
                                $("#completejob").prop("disabled", false);
                                $("#jobCard").prop("disabled", false);
                            }
                        },
                    }).dxDataGrid('instance');
                }
            });

            const gridShiftData = $("#gridShiftData").dxDataGrid({
                dataSource: [], //as json
                hoverStateEnabled: true,
                showBorders: true,
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                selection: {
                    mode: 'single',
                },

                columns: [{
                        dataField: "MachineName",
                        caption: "Machine Group",
                        //width: 80,

                    }, {
                        dataField: "DayWeight",
                        caption: "Day Shift Weights",
                        //width: 100,

                    },
                    {
                        dataField: "NightWeight",
                        caption: "Night Shift Weights",
                        //width: 250,

                    },
                    {
                        dataField: "DayCount",
                        caption: "Day Shift Holds",
                        //width: 300,

                    },
                    {
                        dataField: "NightCount",
                        caption: "Night Shift Holds",
                        //width: 600,

                    },
                ]

            }).dxDataGrid('instance');

            getWorkInProgress();
            getShiftData();

            function getWorkInProgress() {
                $('#saveGalvJob').prop("disabled", false);

                $.ajax({
                    url: '{!! url('/getGalvWIP') !!}',
                    type: "GET",
                    data: {
                        machineId: $('#machineid').val()
                    },
                    success: function(data) {
                        gridWorkInProgress.option('dataSource', data);
                        gridWorkInProgress.refresh();

                        gridData = gridWorkInProgress.option("dataSource");
                    },

                });
            };

            $('#jobCard').click(function() {
                var selectedRowsData = gridWorkInProgress.getSelectedRowsData();

                var JobNo = selectedRowsData[0].JobNo;
                window.open('{!! url('/galvQCJobCard') !!}/' + JobNo, "_blank",
                    "location=1,status=1,scrollbars=1, width=1200,height=850");
            });

            function getShiftData() {
                $.ajax({
                    url: '{!! url('/getGalvWIPConsolidated') !!}',
                    type: "GET",
                    success: function(data) {
                        gridShiftData.option('dataSource', data);
                        gridShiftData.refresh();

                        gridData = gridShiftData.option("dataSource");
                    },

                });
            };

            doacheck();

            function doacheck() {
                setInterval(checkforchanges, 10000);
            };

            function checkforchanges() {
                $.ajax({
                    url: '{!! url('/checkForGalvUpdates') !!}',
                    type: "GET",
                    data: {
                        checker: "NEWJOB",
                    },
                    success: function(data) {
                        // console.log(data[0].Result);
                        if (data[0].Result == "Reload") {
                            console.log("deleting record and reloading");
                            //runs store procedure to delete the record
                            $.ajax({
                                url: '{!! url('/deleteGalvChecker') !!}',
                                type: "GET",
                                data: {
                                    checker: "NEWJOB",
                                },
                                success: function(data) {
                                    getWorkInProgress();
                                    getShiftData();
                                }
                            });
                        } else {
                            // console.log("as you where young lad");
                        }
                    }
                });
            };

        });
    </script>
@endsection
