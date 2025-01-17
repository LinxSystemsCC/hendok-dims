@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Counts')


{{-- Set to show navbar --}}
@php
    $includeMenu = false;
@endphp

@section('page')

    <div id="gridStockCount"></div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            let counts = {!! json_encode($counts) !!};

            const gridStockCount = $("#gridStockCount").dxDataGrid({
                dataSource: counts,
                showBorders: true,
                width: '100%',
                heigh: '100vh',
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                editing: {
                    mode: 'cell',
                    allowUpdating: true,
                },
                paging: {
                    enabled: false
                },
                selection: {
                    mode: 'multiple',
                },
                columns: [{
                    dataField: "intAutoCountId",
                    caption: "intAutoCountId",
                    visible: false,
                    allowEditing: false,
                }, {
                    dataField: "intMainStockCountID",
                    caption: "intMainStockCountID",
                    visible: false,
                    allowEditing: false,
                }, {
                    dataField: "strStockTakeName",
                    caption: "Name",
                    allowEditing: false,
                }, {
                    dataField: "strItemCode",
                    caption: "Item Code",
                    allowEditing: false,
                }, {
                    dataField: "intBinId",
                    caption: "Bin ID",
                    visible: false,
                    allowEditing: false,
                }, {
                    dataField: "strBinName",
                    caption: "Bin Name",
                    allowEditing: false,
                }, {
                    dataField: "strLastCountBy",
                    caption: "Counted By",
                    allowEditing: false,
                }, {
                    dataField: "mnySingle",
                    caption: "Single",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: true,
                }, {
                    dataField: "mnyPallet",
                    caption: "Pallet",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: true,
                }, {
                    dataField: "mnyTotal",
                    caption: "Total",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    calculateCellValue: function(rowData) {
                        const mnySingle = parseFloat(rowData
                            .mnySingle) || 0;
                        const mnyPallet = parseFloat(rowData
                            .mnyPallet) || 0;
                        const mnyPalletFactor = parseFloat(rowData
                            .mnyPalletFactor) || 0;
                        const mnyTotal = mnySingle + (
                            mnyPallet * mnyPalletFactor) || 0;
                        const mnyOnHand = parseFloat(rowData
                            .mnyOnHand) || 0;
                        return mnyTotal;
                    },
                }, {
                    dataField: "mnyOnHand",
                    caption: "On Hand",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    fixed: true,
                    fixedPosition: "right",
                }, {
                    dataField: "mnyVariance",
                    caption: "Variance",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    fixed: true,
                    fixedPosition: "right",
                    calculateCellValue: function(rowData) {
                        const mnySingle = parseFloat(rowData
                            .mnySingle) || 0;
                        const mnyPallet = parseFloat(rowData
                            .mnyPallet) || 0;
                        const mnyPalletFactor = parseFloat(rowData
                            .mnyPalletFactor) || 0;
                        const mnyTotal = mnySingle + (
                            mnyPallet * mnyPalletFactor) || 0;
                        const mnyOnHand = parseFloat(rowData
                            .mnyOnHand) || 0;
                        return mnyTotal - mnyOnHand;
                    },
                }, {
                    dataField: "strRowColor",
                    caption: "strRowColor",
                    visible: false,
                    allowEditing: false,
                }, {
                    dataField: "mnyPalletFactor",
                    caption: "Pallet Factor",
                    allowEditing: false,
                    visible: false,
                }, {
                    dataField: "mnyPalletInSingles",
                    caption: "Pallets in Singles",
                    allowEditing: false,
                    visible: false,
                }, {
                    dataField: "bitCanApprove",
                    caption: "bitCanApprove",
                    visible: false,
                    allowEditing: false,
                }, ],
                onCellPrepared: function(e) {
                    if (e.rowType === "data" && (e.column.dataField ===
                            "mnySingle" || e.column.dataField ===
                            "mnyPallet")) {
                        e.cellElement.css("background-color", "#a1acff")
                            .css("background", "#152b4d73")
                            .css("color", "#fff")
                            .css("font-weight", "900");
                    }
                },
                onRowPrepared: function(e) {
                    if (e.data) {
                        if (e.data.strRowColor != null) {
                            e.rowElement.css("background-color", e.data
                                .strRowColor);
                            // e.rowElement.css("color", "white");
                        }
                    }
                },
                onEditorPreparing: function(e) {
                    if (e.row && e.row.data.bitCanApprove == "0") {
                        e.editorOptions.disabled = true;
                    }
                },
                onSelectionChanged: function(e) {
                    const selectedKeys = e.selectedRowKeys;
                    const data = e.component.getDataSource().items();

                    selectedKeys.forEach(key => {
                        const rowData = data.find(row => row.intAutoCountId === key
                            .intAutoCountId);
                        if (rowData && rowData.bitCanApprove === "0") {
                            e.component.deselectRows([key]);
                        }
                    });
                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.push({
                        location: 'before',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-plus-circle",
                            text: "Re-count",
                            type: 'default',
                            stylingMode: 'contained',
                            onClick: function(args) {
                                const selectedData = gridStockCount.getSelectedRowsData();

                                if (selectedData.length <= 0){
                                    DevExpress.ui.notify("Please select lines to recount", "error", 6000);
                                    return;
                                }

                                recountItems(selectedData);
                            },
                        },
                    });

                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-plus-circle",
                            text: "APPROVE",
                            type: 'default',
                            stylingMode: 'contained',
                            onClick: function(args) {
                                const selectedData = gridStockCount.getSelectedRowsData();

                                if (selectedData.length <= 0){
                                    DevExpress.ui.notify("Please select lines to approve", "error", 6000);
                                    return;
                                }

                                selectedData.forEach(row => {
                                    row.mnyTotal = parseFloat(row
                                        .mnyPalletInSingles) + parseFloat(row
                                        .mnySingle);
                                    row.mnyVariance = parseFloat(row.mnyTotal) -
                                        parseFloat(row.mnyOnHand);
                                });

                                approveVarianceAdjustment(selectedData);
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            function approveVarianceAdjustment(gridData) {
                let filteredArray = gridData.map(item => ({
                    jquery: item.jquery,
                    intAutoCountId: item.intAutoCountId,
                    strItemCode: item.strItemCode,
                    intMainStockCountID: item.intMainStockCountID,
                    mnySingle: item.mnySingle,
                    mnyPallet: item.mnyPallet,
                    mnyTotal: item.mnyTotal,
                    mnyOnHand: item.mnyOnHand,
                    intBinId: item.intBinId,
                    strBinName: item.strBinName,
                    mnyVariance: item.mnyVariance
                }));

                $.ajax({
                    url: '{!! url('/approveVarianceAdjustment') !!}',
                    type: "POST",
                    data: {
                        gridData: filteredArray,
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }

            function recountItems(gridData) {
                let filteredArray = gridData.map(item => ({
                    jquery: item.jquery,
                    intAutoCountId: item.intAutoCountId,
                    strItemCode: item.strItemCode,
                    intMainStockCountID: item.intMainStockCountID,
                    strStockTakeName: item.strStockTakeName
                }));

                $.ajax({
                    url: '{!! url('/StockTakeRecountItems') !!}',
                    type: "POST",
                    data: {
                        gridData: filteredArray,
                        intStockTakeId: '{{ $ID }}',
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        });
    </script>

@endsection
