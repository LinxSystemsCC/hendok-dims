@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Wire Draw Products')

@php
    $includeMenu = true;
@endphp

@section('page')

    <div class="row">
        <div class="col-lg-12 d-inline-flex">
            <h3 style="flex-grow: 1; padding-left: 15px;">Wire Draw Products</h3>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newproduct" id="#newproduct">
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
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="addProductDiv">
                    <!-- General error message will be displayed here if needed -->
                    <div id="general-error"></div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="productname" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strProductName" name="strProductName">
                    </div>
                    <div class="form-group mt-2">
                        <label class="control-label" for="wiresize" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Wire Size</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="ftlWireSize" name="ftlWireSize">
                    </div>
                    <div class="form-group mt-2">
                        <label class="control-label" for="sizetolerance" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Size Tolerance</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strSizeTolerance" name="strSizeTolerance">
                    </div>
                    <div class="form-group mt-2">
                        <label class="control-label" for="MPATolerance" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">MPA Tolerance</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strMPATolerance" name="strMPATolerance">
                    </div>
                    <div class="form-group mt-2">
                        <label class="control-label" for="Customer ID" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Customer</label>
                        <select class="form-select" type="text" id='intCustomerId'>
                            <option value="" selected>Select Customer</option>
                            <!-- Assuming $customers is an array of objects containing ID and Name -->
                            @foreach ($customers as $val)
                                <option value="{{ $val->ID }}">{{ $val->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Ensure the button has the correct classes and IDs -->
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" id="addProductcloseBtn">Close</button>
                    <button type="button" id="savesProductName" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        
        $('#intCustomerId').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newproduct'),
        });

        $(document).ready(function() {

            $('#savesProductName').click(function() {
                $.ajax({
                    url: '{{ route('wire-draw.products.index') }}',
                    type: "POST",
                    data: {
                        strProductName: $('#strProductName').val(),
                        ftlWireSize: $('#ftlWireSize').val(),
                        strSizeTolerance: $('#strSizeTolerance').val(),
                        strMPATolerance: $('#strMPATolerance').val(),
                        intCustomerId: $('#intCustomerId').val()
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

            $(document).on('focus', ':input', function() {
                $(this).attr('autocomplete', 'off');
            });

            $('.close').click(function() {
                $('#addProductDiv').find('.errorClass').hide();
                $('#general-error').hide()
            })

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
                        columns: [
                            {
                                dataField: 'intProductId',
                                caption: 'Product ID',
                                allowEditing: false
                            },
                            {
                                dataField: 'intCustomerId',
                                caption: 'Customer Name',
                                lookup: {
                                    dataSource: customers,
                                    displayExpr: 'Name',
                                    valueExpr: 'ID',
                                },
                            },
                            {
                                dataField: 'strProductName',
                                caption: 'Product Name',
                                dataType: 'string',
                            },
                            {
                                dataField: 'ftlWireSize',
                                caption: 'Wire Size',
                                dataType: 'number',
                                alignment: "left",
                                format: {
                                    type: "fixedPoint",
                                    precision: 2
                                }

                            },
                            {
                                dataField: 'strSizeTolerance',
                                caption: 'Size Tolerance',
                                dataType: 'string',
                            },
                            {
                                dataField: 'strMPATolerance',
                                caption: 'MPA Tolerance',
                                dataType: 'string',
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
                            var intCustomerId = e.data.intCustomerId

                            $.ajax({
                                url: '{!! url('wire-draw/products') !!}' + '/' + intProductId,
                                type: "PUT",
                                data: {
                                    intProductId: intProductId,
                                    strProductName: strProductName,
                                    ftlWireSize: ftlWireSize,
                                    intCustomerId: intCustomerId,
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
