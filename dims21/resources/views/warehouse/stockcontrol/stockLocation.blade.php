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
            let locations = {!! json_encode($locations) !!};
            let selectedDC = -1;
            let selectedLocation = -1;

            let selectLocation;

            dcs.unshift({
                'intAutoId': -1,
                'strDCName': 'All',
            });

            locations.unshift({
                'intLocationId': -1,
                'strLocationName': 'All',
            });

            let filteredLocations = locations;

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
                stateStoring: {
                    enabled: true,
                    type: "localStorage",
                    storageKey: "gridStockLocationSummary"
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
                }, {
                    dataField: "decTotalWeightInStock",
                    caption: "Total Weight",
                    dataType: "number",
                    format: customColFormat,
                }, {
                    dataField: "decTotalQuantityAvailable",
                    caption: "Total Available",
                    dataType: "number",
                    format: customColFormat,
                }, {
                    dataField: "MinLevel",
                    caption: "Min Level",
                }, {
                    dataField: "MaxLevel",
                    caption: "Max Level",
                }],
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
                                                intLocationId: selectedLocation
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
                                columnAutoWidth: true,
                                allowColumnResizing: true,
                                columnResizingMode: "widget",
                                columnFixing: {
                                    enabled: true,
                                },
                                columns: [{
                                    dataField: "strPartNumber",
                                    caption: "Item Code",
                                }, {
                                    dataField: "decTotalQuantityInStock",
                                    caption: "Total On Hand",
                                    dataType: "number",
                                    format: customColFormat,
                                }, {
                                    dataField: "decTotalWeightInStock",
                                    caption: "Total Weight",
                                    dataType: "number",
                                    format: customColFormat,
                                }, {
                                    dataField: "decTotalQuantityAvailable",
                                    caption: "Total Available",
                                    dataType: "number",
                                    format: customColFormat,
                                }, {
                                    dataField: "decSingleQuantityInStock",
                                    caption: "Single Qty In Stock",
                                    dataType: "number",
                                    format: customColFormat,
                                }, {
                                    dataField: "decBundleQuantityInStock",
                                    caption: "Bundle Qty In Stock",
                                    dataType: "number",
                                    format: customColFormat,
                                }, {
                                    dataField: "decPalletQuantityInStock",
                                    caption: "Pallet Qty In Stock",
                                    dataType: "number",
                                    format: customColFormat,
                                }, {
                                    dataField: "strLocationName",
                                    caption: "Location",
                                }, {
                                    dataField: "strDCName",
                                    caption: "DC",
                                }, {
                                    dataField: "strBin",
                                    caption: "Bin",
                                }]
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
                            dataSource: filteredLocations,
                            displayExpr: 'strLocationName',
                            valueExpr: 'intLocationId',
                            value: -1,
                            onInitialized: function(e) {
                                selectLocation = e.component;
                            },
                            onValueChanged: function(e) {
                                selectedLocation = e.value;
                                gridStockLocationSummary.refresh();
                            }
                        },
                        locateInMenu: 'auto', 
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
                                
                                if (parseInt(selectedDC) === -1) {
                                    filteredLocations = locations;
                                } else {
                                    filteredLocations = locations.filter(location => parseInt(location.intDcId) === parseInt(selectedDC));
                                }

                                selectLocation.option('dataSource', filteredLocations);
                                gridStockLocationSummary.refresh();
                            }
                        },
                        locateInMenu: 'auto', 
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
