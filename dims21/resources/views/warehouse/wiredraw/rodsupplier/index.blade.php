@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Wire Draw Rod Supplier')

@php
    $includeMenu = true;
@endphp

@section('page')

    <div class="row">
        <div class="col-lg-12 d-inline-flex">
            <h3 style="flex-grow: 1; padding-left: 15px;">Wire Draw Rod Supplier</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newsupplier">
                New Supplier
            </button>
        </div>
        <div id="gridContainer" style="min-width: 100%;"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newsupplier" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">Create New Rod Supplier</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- General error message will be displayed here if needed -->
                    <div id="general-error"></div>

                    <div class="form-group" id="addCustomerDiv">
                        <label class="control-label" for="strRodSupplierName"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Supplier Name</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strRodSupplierName"
                            name="strRodSupplierName">
                        <!-- Error message will be appended here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal"
                        id="close">Close</button>
                    <button type="button" id="savescustomername" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });

        $(document).ready(function() {
            $('#savescustomername').click(function() {
                $.ajax({
                    url: '{{ route('wire-draw.rod-supplier.index') }}',
                    type: "POST",
                    data: {
                        strRodSupplierName: $('#strRodSupplierName').val(),
                    },
                    success: function(data) {
                        if (data.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#newsupplier"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });
            });

            $('.close').click(function() {
                $('#addCustomerDiv').find('.errorClass').hide()
                $('#general-error').hide()
            });

            $.ajax({
                url: '{{ route('wire-draw.rod-supplier.get-rodsupplier') }}',
                type: "GET",
                success: function(data) {
                    $("#gridContainer").dxDataGrid({
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
                            rowRenderingMode: 'infinite',
                        },
                        paging: {
                            pageSize: 10,
                        },
                        pager: {
                            visible: true,
                            allowedPageSizes: [5, 10, 20, 50, 'all'],
                            showPageSizeSelector: true,
                            showInfo: true,
                            showNavigationButtons: true,
                        },
                        editing: {
                            mode: 'form',
                            allowUpdating: true,
                            // allowAdding: true,
                            allowDeleting: true,
                            useIcons: true,
                        },
                        export: {
                            enabled: true,
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('Wiredraw RodSupplier');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], {
                                        type: 'application/octet-stream'
                                    }), 'Wiredraw RodSupplier.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [{
                                dataField: "intRodSupplierId",
                                caption: "ID",
                                allowEditing: false,
                                alignment: "left",
                                width: '10%',
                            },
                            {
                                dataField: "strRodSupplierName",
                                caption: "Supplier Name",
                                alignment: "left",
                            },
                        ],
                        onRowRemoved(e) {
                            var intRodSupplierId = e.data.intRodSupplierId;
                            console.log(intRodSupplierId);
                            $.ajax({

                                url: '{!! url('wire-draw/rod-supplier') !!}' + '/' + intRodSupplierId,
                                type: "DELETE",
                                data: {
                                    intRodSupplierId: intRodSupplierId
                                },
                                success: function(data) {
                                    location.reload();
                                },

                            });
                        },
                        onRowUpdated(e) {
                            var intRodSupplierId = e.data.intRodSupplierId;
                            console.log(e.data);
                            var strRodSupplierName = e.data.strRodSupplierName;

                            $.ajax({
                                url: '{!! url('wire-draw/rod-supplier') !!}' + '/' + intRodSupplierId,
                                type: "PUT",
                                data: {
                                    intRodSupplierId: intRodSupplierId,
                                    strRodSupplierName: strRodSupplierName,
                                },
                                success: function(data) {
                                    location.reload();
                                },
                            });
                        },
                        onRowDblClick: function(e) {

                        },
                        onRowClick: function(e) {},
                    });
                }
            });
        });

        function showDialog(tag, width, height) {
            $(tag).dialog({
                height: height,
                modal: false,
                width: width,
                containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": false, // false, 'none', 'transparent'
                "minimizeLocation": "right", // sets alignment of minimized dialogues
                "icons": { // jQuery UI icon class

                    "maximize": "ui-icon-circle-plus",
                    "minimize": "ui-icon-circle-minus",
                    "collapse": "ui-icon-triangle-1-s",
                    "restore": "ui-icon-bullet"
                },
                "load": function(evt, dlg) {}, // event
                "beforeCollapse": function(evt, dlg) {}, // event
                "beforeMaximize": function(evt, dlg) {}, // event
                "beforeMinimize": function(evt, dlg) {}, // event
                "beforeRestore": function(evt, dlg) {}, // event
                "collapse": function(evt, dlg) {}, // event
                "maximize": function(evt, dlg) {}, // event
                "minimize": function(evt, dlg) {}, // event
                "restore": function(evt, dlg) {} // event
            });
        }
    </script>

@endsection
