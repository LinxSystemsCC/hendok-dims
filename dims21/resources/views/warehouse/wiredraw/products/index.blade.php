@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'WireDraw Customers')

@php
    $includeMenu = true;
@endphp

@section('page')

    <div class="row">
        <div class="col-lg-12 d-inline-flex">
            <h3 style="flex-grow: 1; padding-left: 15px;">Wiredraw Products</h3>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newproduct">
                New Products
            </button>
        </div>
        <div id="gridContainer" style=""></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newproduct" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">Create New Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- General error message will be displayed here if needed -->
                    <div id="general-error"></div>

                    <div class="form-group">
                        <label class="control-label" for="productname"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strProductName"
                            name="strProductName">

                        <label class="control-label" for="wiresize"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Wire Size</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="ftlWireSize" name="ftlWireSize">
                        <label class="control-label" for="sizetolerance"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Size Tolerance</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strSizeTolerance"
                            name="strSizeTolerance">
                        <label class="control-label" for="MPATolerance"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">MPA Tolerance</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strMPATolerance"
                            name="strMPATolerance">
                        <label class="control-label" for="Customer ID"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Customer ID</label>
                        <select class="form-select" type="text" id='strCustomerName'>
                            <option value="select" selected>Select Customer</option>
                            @foreach ($customers as $val)
                                <option value="{{ $val->strCustomerName }}">{{ $val->strCustomerName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="savescustomername" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignPrinter" tabindex="-1" aria-labelledby="assignPrinterLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="assignPrinterLabel">Assigned Printers</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div id="checkboxContainer">

                        </div>
                        <input id='userId' hidden>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="updatePrinters" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });
        $(document).ready(function() {

            $('#savescustomername').click(function() {
                $.ajax({
                    url: '{{ route('wire-draw.products.index') }}',
                    type: "POST",
                    data: {
                        strProductName: $('#strProductName').val(),
                        ftlWireSize: $('#ftlWireSize').val(),
                        strSizeTolerance: $('#strSizeTolerance').val(),
                        strMPATolerance: $('#strMPATolerance').val(),
                        strCustomerName: $('#strCustomerName').val()
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


            var customers = {!! json_encode($customers) !!};

            $.ajax({
                url: '{{ route('wire-draw.products.get-products') }}',
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
                            mode: 'popup',
                            allowUpdating: true,
                            // allowAdding: true,
                            allowDeleting: true,
                            useIcons: true,
                        },
                        export: {
                            enabled: true,
                        },
                        onExporting(e) {
                            var currentDate = new Date();
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('Wiredraw Products');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], {
                                            type: 'application/octet-stream'
                                        }), 'Wiredraw Products - ' +
                                        currentDate + '.xlsx');
                                });
                            });
                            e.cancel = true;
                        },
                        columns: [{
                                dataField: 'intProductId',
                                caption: 'Product ID',
                                dataType: 'int'
                            },
                            {
                                dataField: 'strCustomerName',
                                caption: 'Customer Name',
                                dataType: 'int',
                                lookup: {
                                    dataSource: customers,
                                    valueExpr: "intCustomerId",
                                    displayExpr: "strCustomerName",
                                },
                            },
                            {
                                dataField: 'strProductName',
                                caption: 'Name',
                                dataType: 'string'
                            },
                            {
                                dataField: 'ftlWireSize',
                                caption: 'Wire Size',
                                dataType: 'float',
                            },
                            {
                                dataField: 'strSizeTolerance',
                                caption: 'Size Tolerance',
                                dataType: 'string'
                            },
                            {
                                dataField: 'strMPATolerance',
                                caption: 'MPA Tolerance',
                                dataType: 'string'
                            },

                        ],

                        onRowClick: function(e) {},
                        onRowRemoved(e) {

                        },
                        onRowUpdated(e) {
                            // console.log(e);

                            var intProductId = e.data.intProductId
                            var strProductName = e.data.strProductName
                            var ftlWireSize = e.data.ftlWireSize
                            var strSizeTolerance = e.data.strSizeTolerance
                            var strMPATolerance = e.data.strMPATolerance
                            var strCustomerName = e.data.strCustomerName

                            $.ajax({
                                url: '{!! url('wire-draw/products') !!}' + '/' + intProductId,
                                type: "PUT",
                                data: {
                                    intProductId: intProductId,
                                    strProductName: strProductName,
                                    ftlWireSize: ftlWireSize,
                                    strCustomerName: strCustomerName,
                                    strSizeTolerance: strSizeTolerance,
                                    strMPATolerance: strMPATolerance
                                },
                                success: function(data) {
                                    location.reload();
                                }

                            });

                        },
                        onRowRemoved(e) {
                            var intProductId = e.data.intProductId;
                            console.log(intProductId);
                            $.ajax({
                                url: '{!! url('wire-draw/products') !!}' + '/' + intProductId,
                                type: "DELETE",
                                data: {
                                    intProductId: intProductId
                                },
                                success: function(data) {
                                    location.reload();
                                },
                            });
                        },
                    });
                }
            })
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
