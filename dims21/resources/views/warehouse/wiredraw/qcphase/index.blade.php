@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'QC Phase')



{{-- Set to show navbar --}}
@php
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
        // $permission = $v->getThingsUserPermissions(Auth::user()->UserID,'Permission');
    }

    $includeMenu = true;

@endphp

@section('page')

    <style>
        #gridQcPhase1 {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <div id="gridQcPhase1"></div>

    <!-- Modal New Item -->
    <div class="modal modal-lg fade" id="saveQcData" aria-labelledby="saveQcData" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="qc1TestTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="CloseModal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="stripmass">Job Number</label>
                            <input type="text" class="form-control" id="intJobNumber" required disabled>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="stripsize">Product</label>
                            <input type="text" class="form-control" id="intProductId" required disabled>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="zinc">Stand #</label>
                            <input type="text" class="form-control" id="intStand" required disabled>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="wiresize">Tensile Ticket Number</label>
                            <input type="text" class="form-control" id="strTensileTicketNumber" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="stresstest">Mpa Tolerance</label>
                            <input type="text" class="form-control" id="strMPATolerance" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="elongation">Wire Size</label>
                            <input type="number" class="form-control" id="fltWireSize" required>
                        </div>

                        <div class="modal-footer mt-2">
                            <div class="d-inline-flex gap-2">
                                <button class="btn btn-success" id="save">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    id="addProductcloseBtn">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endsection

        @section('scripts')

            <script>
                $(document).ready(function() {

                    $('#zinc').prop("disabled", true);

                    $("#wiresize").change(function() {
                        $(this).val(parseFloat($(this).val()).toFixed(2));
                    });

                    $('#wiresize').on('input', function() {
                        var inputValue = $(this).val();

                        if (inputValue.length > 4) {
                            $(this).val(inputValue.slice(0, 4)); // Truncate the input to four characters
                        }
                    });
                    // Clear inputs and selects within the modal
                    $("#saveQcData").on("hidden.bs.modal", function() {
                        $("#saveQcData input, #saveQcData select").val("");
                    })

                    $.ajax({
                        url: '{{ route('wire-draw.qcscreen.get-qcscreen') }}',
                        type: "GET",
                        success: function(data) {
                            const gridWorkInProgress = $("#gridQcPhase1").dxDataGrid({
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
                                    enabled: false
                                },
                                export: {
                                    enabled: true
                                },
                                selection: {
                                    mode: 'single',
                                },
                                onExporting(e) {
                                    const workbook = new ExcelJS.Workbook();
                                    const worksheet = workbook.addWorksheet('qc1');

                                    DevExpress.excelExporter.exportDataGrid({
                                        component: e.component,
                                        worksheet,
                                        autoFilterEnabled: true,
                                    }).then(() => {
                                        workbook.xlsx.writeBuffer().then((buffer) => {
                                            saveAs(new Blob([buffer], {
                                                type: 'application/octet-stream'
                                            }), 'qc1.xlsx');
                                        });
                                    });
                                    e.cancel = true;
                                },
                                columns: [{
                                        dataField: "intHeaderIdcustom",
                                        caption: "Job No"
                                    },
                                    {
                                        dataField: "strReference",
                                        caption: "Reference"
                                    },
                                    {
                                        dataField: "strCustomerName",
                                        caption: "Customer Name"
                                    },
                                    {
                                        dataField: "strProductName",
                                        caption: "Product"
                                    },
                                    {
                                        dataField: "dtDateStart",
                                        caption: "Date Start"
                                    },
                                    {
                                        dataField: "dtDateEnd",
                                        caption: "Date End"
                                    },
                                    {
                                        dataField: "strMachineName",
                                        caption: "Machine"
                                    },
                                    {
                                        dataField: "intNoOfStand",
                                        caption: "Stand #"
                                    }
                                ],
                                onRowDblClick: function(e) {
                                    $('#saveQcData').modal('toggle');
                                    var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
                                    var selectedRowsData = dataGrid.getSelectedRowsData();
                                    if (selectedRowsData.length > 0) {
                                        var productName = selectedRowsData[0].strProductName;
                                        var headerId = selectedRowsData[0].intHeaderIdcustom;
                                        var stand = selectedRowsData[0].intNoOfStand;

                                        $('#intProductId').val(productName);
                                        $('#intJobNumber').val(headerId);
                                        $('#intStand').val(stand);
                                    }
                                },
                                onToolbarPreparing: function(e) {
                                    e.toolbarOptions.items.unshift({
                                        location: 'before',
                                        template: function() {
                                            return $('<h3>').text('QC PHASE');
                                        }
                                    });
                                },

                            }).dxDataGrid('instance');
                        }
                    });

                    $('#save').click(function() {
                        $(this).prop("disabled", true);
                        var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
                        var selectedRowsData = dataGrid.getSelectedRowsData();
                        console.log(selectedRowsData[0]);
                        $.ajax({
                            url: '{!! url('wire-draw/qcscreen') !!}',
                            type: "POST",
                            data: {
                                intJobNumber: selectedRowsData[0].intHeaderId,
                                intProductId: selectedRowsData[0].intProductId,
                                fltWireSize: $('#fltWireSize').val(),
                                intStand: $('#intStand').val(),
                                strTensileTicketNumber: $('#strTensileTicketNumber').val(),
                                strMPATolerance: $('#strMPATolerance').val(),
                            },
                            success: function(data) {
                                location.reload();
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    modalSetValidation($("#newproduct"), xhr);
                                } else {
                                    console.error('An unexpected error occurred:', xhr);
                                }
                            }
                        });
                    });
                });
            </script>

        @endsection
