@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Diamond Mesh Report')

@php
    $includeMenu = true;
@endphp

@section('page')

    <div id="gridReport"></div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            var data = {!! json_encode($data) !!};

            const gridReport = $("#gridReport").dxDataGrid({
                dataSource: data, //as json
                showBorders: true,
                hoverStateEnabled: true,
                filterRow: {
                    visible: true
                },
                height: '100%',
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
                    // allowUpdating: true,
                    // allowAdding: true,
                    // allowDeleting: true,
                    useIcons: true,
                },
                export: {
                    enabled: true,
                },
                onExporting(e) {
                    var currentDate = new Date();
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('Diamond Mesh Report');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet,
                        autoFilterEnabled: true,
                    }).then(() => {
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'Diamond Mesh Report - ' + currentDate + '.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columns: [{
                        dataField: "ProductCode",
                        caption: "ProductCode",
                    }, {
                        dataField: "Product",
                        caption: "Product",
                    }, {
                        dataField: "UnitWeight",
                        caption: "UnitWeight",
                    }, {
                        dataField: "RawMat",
                        caption: "RawMat",
                    }, {
                        dataField: "BladeSize",
                        caption: "BladeSize",
                    }, {
                        dataField: "AccountNumber",
                        caption: "AccountNumber",
                    }, {
                        dataField: "CustomerName",
                        caption: "CustomerName",
                    }, {
                        dataField: "RepName",
                        caption: "RepName",
                    }, {
                        dataField: "CustomerStatus",
                        caption: "CustomerStatus",
                    }, {
                        dataField: "OrderNumber",
                        caption: "OrderNumber",
                    }, {
                        dataField: "idInvoiceLines",
                        caption: "idInvoiceLines",
                    }, {
                        dataField: "Company",
                        caption: "Company",
                    }, {
                        dataField: "OrderDate",
                        caption: "OrderDate",
                    }, {
                        dataField: "DueDate",
                        caption: "DueDate",
                    }, {
                        dataField: "QtyOrdered",
                        caption: "QtyOrdered",
                    }, {
                        dataField: "QtyOutstanding",
                        caption: "QtyOutstanding",
                    }, {
                        dataField: "Area",
                        caption: "Area",
                    }, {
                        dataField: "DeliveryInstructions",
                        caption: "DeliveryInstructions",
                    }, {
                        dataField: "strReference",
                        caption: "Reference",
                    }, {
                        dataField: "strCreatedBy",
                        caption: "CreatedBy",
                    }, {
                        dataField: "OrderComplete",
                        caption: "OrderComplete",
                    }, {
                        dataField: "DateStarted",
                        caption: "DateStarted",
                    }, {
                        dataField: "DateCompleted",
                        caption: "DateCompleted",
                    }, {
                        dataField: "NumberOfItemsMan",
                        caption: "NumberOfItemsMan",
                    }, {
                        dataField: "PartialMan",
                        caption: "PartialMan",
                    }, {
                        dataField: "LineID",
                        caption: "LineID",
                    }, {
                        dataField: "CatString",
                        caption: "CatString",
                    },
                ],
                summary: {
                    totalItems: [{
                        column: "QtyOutstanding",
                        summaryType: 'sum',
                        valueFormat: {
                            type: 'fixedPoint',
                            precision: 2
                        },
                        displayFormat: '{0}',
                    }, {
                        column: "TonsOutstanding",
                        summaryType: 'sum',
                        valueFormat: {
                            type: 'fixedPoint',
                            precision: 2
                        },
                        displayFormat: '{0}',
                    }]
                },

                onRowClick: function(e) {

                },
                onRowRemoved(e) {

                },
            });
        });
    </script>

@endsection
