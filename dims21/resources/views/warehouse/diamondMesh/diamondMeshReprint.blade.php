@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Diamond Mesh Re-Print')

@php
    $includeMenu = true;
@endphp

@section('page')

    <style>
        #gridReprintJobs {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <div class="row overflow-auto mh-100">
        <div id="gridReprintJobs"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalPrinter" tabindex="-1" aria-labelledby="modalPrinterLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalPrinterLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="selectPrinter">Printer</label>
                        <select id="selectPrinter" class="form-select">
                            <option></option>
                            @foreach ($printers as $printer)
                                <option value="{{ $printer->intPrinterId }}">{{ $printer->strPrinter }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="inputQty">Quantity To Print</label>
                        <input id="inputQty" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnPrintLabel">Print</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            var jobs = ({!! json_encode($jobs) !!});
            let intJobId;

            $("#gridReprintJobs").dxDataGrid({
                dataSource: jobs, //as json
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
                    pageSize: 10,
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
                        dataField: "intJobId",
                        caption: "Id",
                    }, {
                        dataField: "strRef",
                        caption: "SO Number",
                    }, {
                        dataField: "strCustomerName",
                        caption: "Customer Name",
                    },
                    {
                        dataField: "strItemCode",
                        caption: "Product Code",
                    },
                    {
                        dataField: "Description_1",
                        caption: "Product Description",
                    },
                    {
                        dataField: "intPackSize",
                        caption: "Pack Size",
                    },
                    {
                        dataField: "dteJobCreated",
                        caption: "Date",
                    },
                ],

                onRowDblClick: function(e) {
                    intJobId = e.data.intJobId;
                    $('#modalPrinter').modal('toggle');
                },
                onRowClick: function(e) {

                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3 class="ps-3">').text('Reprint Diamond Mesh Jobs');
                        }
                    });
                },
            });

            $('#btnPrintLabel').click(function() {
                $.ajax({
                    url: '{!! url('/diamondMeshInsertReprint') !!}',
                    type: "POST",
                    data: {
                        intJobId: intJobId,
                        intPrinterId: $("#selectPrinter").val(),
                        qty: $("#inputQty").val(),
                    },
                    success: function(data) {
                        if (data[0].Result == "SUCCESS") {
                            alert('Succesful Printout.');
                            location.reload();
                        } else {
                            alert(data[0].Result);
                        }
                    }
                });
            });
        });
    </script>

@endsection
