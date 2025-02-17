@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Summary')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <div id="gridStockLocationSummary" class="col-lg-12"></div>

@endsection

@section('scripts')

    <style>
        #gridStockLocationSummary {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <script>
        $(document).ready(function() {
            let loadTracking = [];

            let dcs = {!! json_encode($DCs) !!};
            let selectedDC = -1;

            dcs.unshift({
                'intAutoId': -1,
                'strDCName': 'All',
            });

            let customColFormat = {
                type: "custom",
                formatter: function(value) {
                    return (Math.round(value * 10000) / 10000).toFixed(4).replace(
                        /\.?0+$/, '');
                }
            };

            const gridStockLocationSummary = $("#gridStockLocationSummary").dxDataGrid({
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
                selection: {
                    mode: "single",
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
                columns: [{
                        dataField: "strPartNumber",
                        caption: "Item Code",

                    }, {
                        dataField: "strItemDescription",
                        caption: "Item Name",

                    }, {
                        dataField: "strItemGroupDescription",
                        caption: "Item Group",

                    }, {
                        dataField: "decTotalQuantityInStock",
                        caption: "Total On Hand",
                        dataType: "number",
                        format: customColFormat,
                    },{
                        dataField: "decTotalQuantityAvailable",
                        caption: "Total Available",
                        dataType: "number",
                        format: customColFormat,
                    }, {
                        dataField: "decSingleQuantityInStock",
                        caption: "Single On Hand",
                        dataType: "number",
                        format: customColFormat,
                    },{
                        dataField: "decBundleQuantityInStock",
                        caption: "Bundle On Hand",
                        dataType: "number",
                        format: customColFormat,
                    },{
                        dataField: "decPalletQuantityInStock",
                        caption: "Pallet On Hand",
                        dataType: "number",
                        format: customColFormat,
                    },{
                        dataField: "MinLevel",
                        caption: "Min Level",

                    }, {
                        dataField: "MaxLevel",
                        caption: "Max Level",

                    }, {
                        dataField: "mnySageInStock",
                        caption: "Sage Qty",

                    }
                ],
                masterDetail: {
                    enabled: true,
                    template(container, options) {
                        const ItemCode = options.data.strPartNumber;
                        const gridStockDetailSummary = $('<div>')
                            .dxDataGrid({
                                dataSource: {
                                    load: function(loadOptions) {
                                        return $.ajax({
                                            url: '{!! url('/getStockDetailsSummary') !!}',
                                            method: 'GET',
                                            data: {
                                                ItemCode: ItemCode,
                                                intDCid: selectedDC,
                                            },
                                            xhrFields: {
                                                withCredentials: true
                                            },
                                        });
                                    },
                                    update: function(key, values) {
                                        gridStockDetailSummary.dxDataGrid('instance').refresh();
                                    },
                                    insert: function(key, values) {
                                        gridStockDetailSummary.dxDataGrid('instance').refresh();
                                    },
                                },
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
                                paging: {
                                    enabled: false
                                },
                                onContentReady: function(e) {
                                    e.component.columnOption('intBinId', 'visible', false);
                                    e.component.columnOption('intBinId', 'allowEditing', false);

                                    e.component.columnOption('intLocationId', 'visible', false);
                                    e.component.columnOption('strLocationName', 'caption', 'Location Name');
                                    e.component.columnOption('strLocationName', 'allowEditing', false);

                                    e.component.columnOption('intDcId', 'visible', false);
                                    e.component.columnOption('strDCName', 'caption', 'DC Name');
                                    e.component.columnOption('strDCName', 'allowEditing', false);

                                    e.component.columnOption('strBin', 'caption', 'Bin Name');
                                    e.component.columnOption('strBin', 'allowEditing', false);

                                    e.component.columnOption('mnyBinCapacity', 'caption', 'Capacity');
                                    e.component.columnOption('mnyBinCapacity', 'dataType', 'number');
                                    e.component.columnOption('mnyBinCapacity', 'format', customColFormat);

                                    e.component.columnOption('decTotalQuantityInStock', 'caption', 'Total On Hand');
                                    e.component.columnOption('decTotalQuantityInStock', 'dataType', 'number');
                                    e.component.columnOption('decTotalQuantityInStock', 'format', customColFormat);

                                    e.component.columnOption('decTotalQuantityAvailable', 'caption', 'Total Available');
                                    e.component.columnOption('decTotalQuantityAvailable', 'dataType', 'number');
                                    e.component.columnOption('decTotalQuantityAvailable', 'format', customColFormat);

                                    e.component.columnOption('decSingleQuantityInStock', 'caption', 'Single On Hand');
                                    e.component.columnOption('decSingleQuantityInStock', 'dataType', 'number');
                                    e.component.columnOption('decSingleQuantityInStock', 'format', customColFormat);

                                    e.component.columnOption('decBundleQuantityInStock', 'caption', 'Bundle On Hand');
                                    e.component.columnOption('decBundleQuantityInStock', 'dataType', 'number');
                                    e.component.columnOption('decBundleQuantityInStock', 'format', customColFormat);

                                    e.component.columnOption('decPalletQuantityInStock', 'caption', 'Pallet On Hand');
                                    e.component.columnOption('decPalletQuantityInStock', 'dataType', 'number');
                                    e.component.columnOption('decPalletQuantityInStock', 'format', customColFormat);

                                    e.component.columnOption('strPartNumber', 'caption', 'Item Code');
                                    e.component.columnOption('strPartNumber', 'allowEditing',false);
                                },
                            }).appendTo(container);
                    },
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3 class="ps-3">').text('Stock Location Summary');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: 'dxSelectBox',
                        options: {
                            dataSource: dcs,
                            displayExpr: 'strDCName',
                            valueExpr: 'intAutoId',
                            value: -1,
                            onValueChanged: function(e) {
                                selectedDC = e.value;
                                getStockLocationSummary();
                            }
                        },
                        locateInMenu: 'auto', // Adjust as needed
                    });
                }
            }).dxDataGrid('instance');

            function clearInputsAndSelect() {
                $('.form-control').val('');
                $('.form-select').val('').trigger('change');
            }

            // Event listener for modal dismiss
            $('.modal').on('hidden.bs.modal', function(e) {
                clearInputsAndSelect();
            });

            getStockLocationSummary()

            function getStockLocationSummary() {
                $.ajax({
                    url: "{!! url('/getStockLocationSummary') !!}",
                    type: "GET",
                    data: {
                        intDCid: selectedDC,
                    },
                    success: function(data) {
                        const gridData = {
                            store: new DevExpress.data.CustomStore({
                                key: "strPartNumber",
                                loadMode: "raw",
                                load: function() {
                                    return data;
                                }
                            }),
                            paginate: true,
                        };
                        gridStockLocationSummary.option('dataSource', gridData);
                        gridStockLocationSummary.refresh();
                    }
                });
            }
        });
    </script>

@endsection
