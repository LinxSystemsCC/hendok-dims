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
                columns: [{
                    dataField: "intMainStockCountID",
                    caption: "intMainStockCountID",
                    visible: false,
                    allowEditing: false,
                }, {
                    dataField: "strStockTakeName",
                    caption: "Name",
                    allowEditing: false,
                    width: 150,
                }, {
                    dataField: "strItemCode",
                    caption: "Item Code",
                    allowEditing: false,
                    width: 250,
                }, {
                    dataField: "intBinId",
                    caption: "Bin ID",
                    visible: false,
                    allowEditing: false,
                }, {
                    dataField: "strBinName",
                    caption: "Bin Name",
                    allowEditing: false,
                    width: 250,
                }, {
                    dataField: "mnyBlueSingle",
                    caption: "Blue Single",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                }, {
                    dataField: "mnyRedSingle",
                    caption: "Red Single",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                }, {
                    dataField: "mnyManagerSingle",
                    caption: "Manager Single",
                    dataType: 'number',
                    alignment: 'center',
                    width: 150,
                }, {
                    dataField: "mnyBluePallet",
                    caption: "Blue Pallet",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                }, {
                    dataField: "mnyRedPallet",
                    caption: "Red Pallet",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                }, {
                    dataField: "mnyManagerPallet",
                    caption: "Manager Pallet",
                    dataType: 'number',
                    alignment: 'center',
                    width: 150,
                }, {
                    dataField: "mnyBlueTotal",
                    caption: "Blue Total",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                }, {
                    dataField: "mnyRedTotal",
                    caption: "Red Total",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                }, {
                    dataField: "mnyManagerTotal",
                    caption: "Manager Total",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                    fixed: true,
                    fixedPosition: "right",
                    calculateCellValue: function(rowData) {
                        const mnyManagerSingle = parseFloat(rowData
                            .mnyManagerSingle) || 0;
                        const mnyManagerPallet = parseFloat(rowData
                            .mnyManagerPallet) || 0;
                        const mnyPalletFactor = parseFloat(rowData
                            .mnyPalletFactor) || 0;
                        return mnyManagerSingle + (mnyManagerPallet *
                            mnyPalletFactor);
                    },
                }, {
                    dataField: "mnyOnHand",
                    caption: "On Hand",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                    fixed: true,
                    fixedPosition: "right",
                }, {
                    dataField: "mnyVariance",
                    caption: "Variance",
                    dataType: 'number',
                    alignment: 'center',
                    allowEditing: false,
                    width: 150,
                    fixed: true,
                    fixedPosition: "right",
                    calculateCellValue: function(rowData) {
                        const mnyManagerSingle = parseFloat(rowData
                            .mnyManagerSingle) || 0;
                        const mnyManagerPallet = parseFloat(rowData
                            .mnyManagerPallet) || 0;
                        const mnyPalletFactor = parseFloat(rowData
                            .mnyPalletFactor) || 0;
                        const mnyManagerTotal = mnyManagerSingle + (
                            mnyManagerPallet * mnyPalletFactor) || 0;
                        const mnyOnHand = parseFloat(rowData
                            .mnyOnHand) || 0;
                        return mnyManagerTotal - mnyOnHand;
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
                }],
                onCellPrepared: function(e) {
                    if (e.rowType === "data" && (e.column.dataField ===
                            "mnyManagerSingle" || e.column.dataField ===
                            "mnyManagerPallet")) {
                        e.cellElement.css("background-color", "#4287f5");
                        e.cellElement.css("color", "white");
                    }
                },
                onRowPrepared: function(e) {
                    if (e.data) {
                        if (e.data.strRowColor != null) {
                            e.rowElement.css("background-color", e.data
                                .strRowColor);
                            e.rowElement.css("color", "white");
                        }
                    }
                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-plus-circle",
                            text: "APPROVE",
                            type: 'default',
                            disabled: {{ $isApproved }} == "1",
                            stylingMode: 'contained',
                            onClick: function(args) {
                                const visibleRows = gridStockCount.getVisibleRows();

                                const currentData = visibleRows.map(
                                    row => {
                                        const rowData = row.data;

                                        const mnyManagerSingle = parseFloat(rowData
                                            .mnyManagerSingle) || 0;
                                        const mnyManagerPallet = parseFloat(rowData
                                            .mnyManagerPallet) || 0;
                                        const mnyPalletFactor = parseFloat(rowData
                                            .mnyPalletFactor) || 0;
                                        const mnyOnHand = parseFloat(rowData
                                            .mnyOnHand) || 0;

                                        const mnyManagerTotal = mnyManagerSingle + (
                                            mnyManagerPallet * mnyPalletFactor);
                                        const mnyVariance = mnyManagerTotal - mnyOnHand;

                                        return {
                                            ...rowData,
                                            mnyManagerTotal,
                                            mnyVariance
                                        };
                                    }
                                );

                                approveVarianceAdjustment(currentData);
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            function approveVarianceAdjustment(gridData) {
                let filteredArray = gridData.map(item => ({
                    jquery: item.jquery,
                    strItemCode: item.strItemCode,
                    intMainStockCountID: item.intMainStockCountID,
                    mnyManagerSingle: item.mnyManagerSingle,
                    mnyManagerPallet: item.mnyManagerPallet,
                    mnyManagerTotal: item.mnyManagerTotal,
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
        });
    </script>

@endsection
