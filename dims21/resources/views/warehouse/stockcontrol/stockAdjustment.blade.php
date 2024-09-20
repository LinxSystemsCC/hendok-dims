@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Adjustment')

{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <div id="gridAdjustment" class="col-lg-12 h-100"></div>

@endsection

@section('scripts')

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
            let bins = []; //({!! json_encode($bins) !!});

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

                        if (rowData.strAdjustmentType && rowData.mnyAdjustment) {
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
                    // e.toolbarOptions.items.push({
                    //     location: 'after',
                    //     widget: "dxButton",
                    //     options: {
                    //         icon: "edit",
                    //         text: "FORM INPUT",
                    //         type: 'success',
                    //         stylingMode: 'contained',
                    //         onClick: function(args) {
                    //             alert("Show Popup")
                    //         },
                    //     },
                    // }); // Coming Soon
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
