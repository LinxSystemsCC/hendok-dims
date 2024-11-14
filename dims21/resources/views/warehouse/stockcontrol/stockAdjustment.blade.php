@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Adjustment')

{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <div id="gridAdjustment" class="col-lg-12 h-100"></div>
    <input type="file" id="csvFileInput" accept=".csv" style="display: none;" />

@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.2/papaparse.min.js"></script>

    <script>
        $(document).ready(function() {
            let products = ({!! json_encode($products) !!});

            let docTypes = [{
                "docType": "Invoice"
            }, {
                "docType": "Goods Received"
            }, {
                "docType": "Credit Note"
            }, {
                "docType": "Issue Stock"
            }, {
                "docType": "Stock Adjustment"
            }];

            let dcs = ({!! json_encode($dcs) !!});
            let locations = ({!! json_encode($locations) !!});
            let bins = ({!! json_encode($bins) !!});

            let countTypes = [{
                "value": "+",
                "display": "Add"
            }, {
                "value": "-",
                "display": "Subtract"
            }, {
                "value": "=",
                "display": "Set"
            }];

            const gridAdjustment = $("#gridAdjustment").dxDataGrid({
                dataSource: [],
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
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "widget",
                columnFixing: {
                    enabled: true,
                },
                scrolling: {
                    mode: 'virtual'
                },
                editing: {
                    mode: 'cell',
                    allowUpdating: true,
                    allowAdding: true,
                    allowDeleting: true,
                },
                export: {
                    enabled: true
                },
                onExporting(e) {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('StockIssues');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet,
                        autoFilterEnabled: true,
                    }).then(() => {
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'StockIssues.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columns: [{
                    dataField: "intStockLink",
                    caption: "Code",
                    lookup: {
                        dataSource: {
                            store: products,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'intStockLink',
                        displayExpr: 'strPartNumber',
                    },
                    width: 150,
                }, {
                    dataField: "strDocType",
                    caption: "Document Type",
                    lookup: {
                        dataSource: {
                            store: docTypes,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'docType',
                        displayExpr: 'docType',
                    },
                }, {
                    dataField: "intDcId",
                    caption: "DC",
                    lookup: {
                        dataSource: {
                            store: dcs,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'intDcId',
                        displayExpr: 'strDCName',
                    },
                    width: 200,
                }, {
                    dataField: "intLocationId",
                    caption: "Warehouse",
                    lookup: {
                        dataSource: {
                            store: locations,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'intLocationId',
                        displayExpr: 'strLocationName',
                    },
                    width: 200,
                }, {
                    dataField: "intBinId",
                    caption: "Bin",
                    lookup: {
                        dataSource: {
                            store: bins,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'intBinId',
                        displayExpr: 'strBin',
                    },
                    width: 150,
                }, {
                    dataField: "mnyOnHand",
                    caption: "On Hand",
                    allowEditing: false,
                    dataType: "number",
                    alignment: "center",
                    format: "#0.####",
                    cellTemplate: function(element, info) {
                        element.append("<div>" + info.text + "</div>")
                            .css("background", "#7c8d9c73")
                            .css("font-weight", "900");
                    }
                }, {
                    dataField: "strAdjustmentType",
                    caption: "Count Type",
                    lookup: {
                        dataSource: {
                            store: countTypes,
                            paginate: true,
                            pageSize: 100
                        },
                        valueExpr: 'value',
                        displayExpr: 'display',
                    },
                }, {
                    dataField: "mnyAdjustment",
                    caption: "Adjustment",
                    dataType: "number",
                    alignment: "center",
                    format: "#0.####",
                }, {
                    dataField: "mnyNewOnHand",
                    caption: "New Count",
                    allowEditing: false,
                    dataType: "number",
                    alignment: "center",
                    format: "#0.####",
                    calculateCellValue: function(rowData) {
                        let newOnHandValue = parseFloat(rowData.mnyOnHand);

                        if (rowData.strAdjustmentType) {
                            if (rowData.strAdjustmentType === "+") {
                                newOnHandValue = parseFloat(rowData.mnyOnHand) + rowData
                                    .mnyAdjustment;
                            } else if (rowData.strAdjustmentType === "-") {
                                newOnHandValue = parseFloat(rowData.mnyOnHand) - rowData
                                    .mnyAdjustment;
                            } else if (rowData.strAdjustmentType === "=") {
                                newOnHandValue = rowData.mnyAdjustment;
                            }
                        }

                        // Store the calculated value in rowData so it gets included in the dataset
                        rowData.mnyNewOnHand = newOnHandValue;
                        return newOnHandValue;
                    },
                    cellTemplate: function(element, info) {
                        element.append("<div>" + info.text + "</div>")
                            .css("background", "#2f9e4073")
                            .css("font-size", "16px")
                            .css("font-weight", "900");
                    }
                }, {
                    dataField: "strDocReference",
                    caption: "Reference",
                }, {
                    dataField: "strDocReference2",
                    caption: "Reference 2",
                }, ],
                onEditorPreparing: function(e) {
                    if (e.parentType === 'dataRow' && e.dataField === 'intLocationId') {
                        let rowData = e.row.data;

                        e.editorOptions.onValueChanged = function(args) {
                            let selectedLocationId = args.value;

                            getBins(selectedLocationId);
                            rowData.intLocationId = selectedLocationId;
                            gridAdjustment.refresh();
                        };
                    }

                    if (e.parentType === 'dataRow' && e.dataField === 'intBinId') {
                        let rowData = e.row.data;

                        e.editorOptions.onValueChanged = function(args) {
                            let selectedBinId = args.value;
                            let intStockLink = rowData.intStockLink;

                            getBinStockCount(selectedBinId, intStockLink, function(onHand) {
                                rowData.intBinId = selectedBinId;
                                rowData.mnyOnHand = onHand[0]["mnyOnHand"];
                                gridAdjustment.refresh();
                            });

                        };
                    }
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('Stock Adjustment');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "upload",
                            text: "IMPORT CSV",
                            type: 'default',
                            stylingMode: 'contained',
                            onClick: function() {
                                $("#csvFileInput").click();
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "upload",
                            text: "SUBMIT",
                            type: 'default',
                            stylingMode: 'contained',
                            onClick: function(args) {
                                adjustStock();
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            $("#csvFileInput").on('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    Papa.parse(file, {
                        header: true,
                        dynamicTyping: true,
                        skipEmptyLines: true,
                        complete: function(results) {

                            // We need to process the data asynchronously because of the AJAX call
                            const processData = results.data.map(function(row) {
                                return new Promise((resolve, reject) => {
                                    // Match intDcId
                                    const dc = dcs.find(dc => dc.strDCName ===
                                        row['DC']);
                                    const intDcId = dc ? dc.intDcId : null;

                                    // Match intStockLink
                                    const product = products.find(product =>
                                        product.strPartNumber === row[
                                            'Code']);
                                    const intStockLink = product ? product
                                        .intStockLink : null;

                                    // Match intLocationId
                                    const location = locations.find(location =>
                                        location.strLocationName === row[
                                            'Warehouse']);
                                    const intLocationId = location ? location
                                        .intLocationId : null;

                                    // Match intBinId
                                    const bin = bins.find(bin => bin.strBin ===
                                        row['Bin']);
                                    const intBinId = bin ? bin.intBinId : null;

                                    // Match strAdjustmentType
                                    const countType = countTypes.find(type =>
                                        type.display === row['Count Type']);
                                    const strAdjustmentType = countType ?
                                        countType.value : null;

                                    // Fetch the onHand value using getBinStockCount
                                    getBinStockCount(intBinId, intStockLink,
                                        function(onHand) {
                                            resolve({
                                                intStockLink: intStockLink,
                                                strDocType: row['Document Type'],
                                                intDcId: intDcId,
                                                intLocationId: intLocationId,
                                                intBinId: intBinId,
                                                mnyOnHand: onHand[0]["mnyOnHand"],
                                                strAdjustmentType: strAdjustmentType,
                                                mnyAdjustment: row['Adjustment'],
                                                mnyNewOnHand: row['New Count'],
                                                strDocReference: row['Reference'],
                                                strDocReference2: row['Reference 2']
                                            });
                                        });
                                });
                            });

                            // Wait for all data to be processed before updating the grid
                            Promise.all(processData).then(function(finalData) {
                                gridAdjustment.option('dataSource', finalData);
                            });
                        }
                    });
                }
            });

            function getBinStockCount(selectedBinId, intStockLink, callback) {
                $.ajax({
                    url: '{!! url('/getBinStockCount') !!}',
                    type: 'GET',
                    data: {
                        intBinId: selectedBinId,
                        intStockLink: intStockLink,
                    },
                    success: function(onHand) {
                        callback(onHand);
                    },
                    error: function() {
                        DevExpress.ui.notify('Failed to load onHandQty.', 'error', 3500);
                    }
                });
            }

            function getBins(selectedLocationId) {
                $.ajax({
                    url: '{!! url('/getBinsForLocations') !!}',
                    type: 'GET',
                    data: {
                        locationIds: selectedLocationId
                    },
                    success: function(binsData) {
                        const binColumn = gridAdjustment.columnOption('intBinId');
                        binColumn.lookup.dataSource = binsData;
                        gridAdjustment.refresh();
                    },
                    error: function() {
                        DevExpress.ui.notify('Failed to load bins.', 'error', 3500);
                    }
                });
            }

            function adjustStock() {
                var gridData = gridAdjustment.getDataSource().items();

                console.log(gridData);

                $.ajax({
                    url: '{!! url('/processStockAdjustment') !!}',
                    type: 'POST',
                    data: {
                        gridData: gridData,
                    },
                    success: function(binsData) {
                        gridAdjustment.option('dataSource', []);
                    },
                    error: function() {
                        DevExpress.ui.notify('Failed adjust Stock', 'error', 3500);
                    }
                });
            }

        });
    </script>

@endsection
