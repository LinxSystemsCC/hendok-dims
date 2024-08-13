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
    <div class="col-12 h-100" style="display: flex; flex-direction: column;">
        <div class="col-12 mb-2" id="tabs">
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
                <button type="button" id="btnaddrod" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addrod" disabled>
                    Add ROD
                </button>
            @endif
        </div>

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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="closeFinaliseJob">Close</button>
                        <button class="btn btn-danger" id="completesave">Complete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Creation Job Modal -->
        <div title="Job Creation" id="createjob" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-labelledby="createjob" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create A Wire Draw Work Order</h5>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label" for="reference" style="font-weight: 700;font-size: 15px;">Reference</label>
                                <input type="text" maxlength="15" class="form-control" id="strReference" required>
                            </div>
                            <div class="col-md-6">
                                <label for="customers" class="col-form-label" style="font-weight: 700;font-size: 15px;">Customer</label>
                                <select class="form-select dims-select2" id="intCustomerId" required>
                                    <option value="" selected>Select Customer</option>
                                    @foreach ($customers as $val)
                                        <option value="{{ $val->intCustomerId }}">{{ $val->strCustomerName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="wiresize" style="font-weight: 700;font-size: 15px;">Machine</label>
                                <select class="form-select dims-select2" id="intWireDrawMachineId" required>
                                    <option value="" selected>Select Machine</option>
                                    @foreach ($machines as $val)
                                        <option value="{{ $val->intMachineID }}">{{ $val->strMachineName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="prodname" style="font-weight: 700;font-size: 15px;">Product</label>
                                <select class="form-select dims-select2" id="intProductId" required>
                                    <option value="" selected>Select Product</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Mass Required</label>
                                <input type="number" class="form-control" id="fltMassRequired" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-target="#createjob"
                            data-bs-toggle="modal" id="cancelCreateJob">
                            Close
                        </button>
                        <button type="button" id="wiredraw" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Rods Modal -->
        <div id="addrod" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-labelledby="addrodLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="h5addrod">Add Wire Draw ROD</h5>
                        <button type="button" class="btn-close rodsclose" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label" for="supplier" style="font-weight: 700;font-size: 15px;">Rod Supplier</label>
                                <select class="form-select dims-select3" type="text" id="intRodSupplier">
                                    <option value="" selected>Select Rod Supplier</option>
                                    @foreach ($suppliers as $val)
                                        <option value="{{ $val->intRodSupplierId }}">{{ $val->strRodSupplierName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="rodcode" style="font-weight: 700;font-size: 15px;">Rod Code</label>
                                <select class="form-select dims-select3" type="text" id='strRodCode'>
                                    <option value="" selected>Select Rod Code</option>
                                    @foreach ($rodcodes as $val)
                                        <option value="{{ $val->strPartNumber }}">{{ $val->strPartDescription }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="strCastNumber" class="col-form-label" style="font-weight: 700;font-size: 15px;">Cast Number</label>
                                <input type="text" class="form-control" id="strCastNumber" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="wiresize" style="font-weight: 700;font-size: 15px;">Serial Number</label>
                                <input type="text" class="form-control" id="strSerialNumber" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Batch Number</label>
                                <input type="text" class="form-control" id="strBatchNumber" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Rod Elongation</label>
                                <input type="number" class="form-control" id="fltRodElongation" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Rod MPa</label>
                                <input type="number" class="form-control" id="fltRodMpa" required>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Rod Weigh</label>
                                <input type="number" class="form-control" id="fltRodWeigh" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rodsclose" data-bs-target="#addrod"
                            data-bs-toggle="modal" id="canceladdrod">Close</button>
                        <button type="button" id="addrodsave" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="toastContainer"></div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.dims-select2').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#createjob'),
            });

            $(document).on('focus', ':input', function() {
                $(this).attr('autocomplete', 'off');
            });

            $('#strType').change(function() {
                if ($('#strType').val() == 'internal') {
                    $('#intCustomerId').attr('disabled', true);
                } else {
                    $('#intCustomerId').attr('disabled', false);
                }
            });

            $('#intCustomerId').change(function() {
                $('#intProductId').children().not('option:first').remove();
                var customerId = $('#intCustomerId').val();
                $.ajax({
                    url: '{{ route('wire-draw.headers.getproduct', ':getproduct') }}'.replace(
                        ':getproduct', customerId),
                    type: "GET",
                    data: {
                        intCustomerID: customerId
                    },
                    success: function(data) {
                        for (let index = 0; index < data.length; index++) {
                            $('#intProductId').append($('<option>', {
                                value: data[index].intProductId,
                                text: data[index].strProductName
                            }));
                        }
                    }

                });
            });

            $('.dims-select3').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addrod'),
            });

            $('#completesave').click(function() {
                $.ajax({

                    url: '{!! url('wire-draw/changeJobStatus') !!}',
                    type: "GET",
                    data: {
                        JobId: getJobId(),
                    },
                    success: function(data) {
                        alert("Job Completed!");
                        if (data.success) {
                            location.reload();
                        }
                    }
                });
            });

            function getJobId() {
                var selectedItem = $("#gridWorkInProgress").dxDataGrid("instance").getSelectedRowsData()[0];
                var intHeaderId = selectedItem.intHeaderId;
                var jobId = intHeaderId.replace('WD', '');
                var parsedJobId = parseInt(jobId);

                return parsedJobId;
            }

            $('#wiredraw').click(function() {

                $.ajax({
                    url: '{!! url('wire-draw/headers') !!}',
                    type: "POST",
                    data: {
                        intCustomerId: $('#intCustomerId').val(),
                        intProductId: $('#intProductId').val(),
                        intWireDrawMachineId: $('#intWireDrawMachineId').val(),
                        fltMassRequired: $('#fltMassRequired').val(),
                        strReference: $('#strReference').val()
                    },
                    success: function(data) {
                        if (data.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#createjob"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });

            });

            $('#addrodsave').click(function() {
                var jobId = getJobId();
                var intJobNumber = parseInt(jobId);
                $.ajax({
                    url: '{!! url('wire-draw/headers/add-rod') !!}',
                    type: "POST",
                    data: {
                        intJobNumber: intJobNumber,
                        intRodSupplier: $('#intRodSupplier').val(),
                        strRodCode: $('#strRodCode').val(),
                        strCastNumber: $('#strCastNumber').val(),
                        strSerialNumber: $('#strSerialNumber').val(),
                        strBatchNumber: $('#strBatchNumber').val(),
                        fltRodElongation: $('#fltRodElongation').val(),
                        fltRodMpa: $('#fltRodMpa').val(),
                        fltRodWeigh: $('#fltRodWeigh').val()
                    },
                    success: function(data) {
                        $("#addrod").modal("hide");
                        $("#toastContainer").dxToast({
                            message: "Data saved successfully!",
                            type: "success",
                            width: 230,
                            height: 50,
                            position: {
                                my: 'top right',
                                at: 'top right',
                            },
                            visible: true
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#addrod"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });

            });

            $('#addrod').on('hidden.bs.modal', function() {
                $(this).find('.errorClass').hide();
                $('#general-error').hide();
                $('#addrod').find('input').val('');
                $('#intRodSupplier').val('').trigger('change');
                $('#strRodCode').val('').trigger('change');
            });

            $('#createjob').on('hidden.bs.modal', function() {
                $(this).find('.errorClass').hide();
                $('#general-error').hide();
            });

            var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization
            $.ajax({
                url: '{{ route('wire-draw.headers.get-headers') }}',
                type: "GET",
                success: function(data) {
                    const gridWorkInProgress = $("#gridWorkInProgress").dxDataGrid({
                        dataSource: data,
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
                                dataField: "fltMassProduced",
                                caption: "Mass Produced",
                            },
                            {
                                dataField: "intNoOfStand",
                                caption: "No Of Stand",
                            },
                            {
                                dataField: "strJobStatus",
                                caption: "Job Status",
                            },
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
                                $("#btnaddrod").prop("disabled", true);
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
                                $("#btnaddrod").prop("disabled", false);
                            }
                        },
                    }).dxDataGrid('instance');
                }
            });
        });
    </script>
@endsection
