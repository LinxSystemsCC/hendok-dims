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
                    mode: 'overflow'
                },
                columns: [
                    {
                        dataField: "strErpItemCode",
                        caption: "Item Code",

                    }, {
                        dataField: "Description_1",
                        caption: "Item Name",

                    }, {
                        dataField: "ItemGroupDescription",
                        caption: "Item Group",

                    }, {
                        dataField: "mnyEstimatedPallets",
                        caption: "Qty",
                        dataType:"number",
                        format: "#0",

                    }, {
                        dataField: "mnyWeight",
                        caption: "Weight",

                    },{
                        dataField: "MinLevel",
                        caption: "Min Level",

                    }, {
                        dataField: "MaxLevel",
                        caption: "Max Level",

                    }, {
                        dataField: "QtyInStock",
                        caption: "Sage Qty",

                    }
                ],
                masterDetail: {
                    enabled: true,
                    template(container, options) {
                        const ItemCode = options.data.strErpItemCode;
                        const gridStockDetailSummary = $('<div>')
                        .dxDataGrid({
                            dataSource: {
                                load: function(loadOptions) {
                                    return $.ajax({
                                        url: '{!!url("/getStockDetailsSummary")!!}',
                                        method: 'GET',
                                        data: { ItemCode: ItemCode},
                                        xhrFields: { withCredentials: true },
                                    });
                                },
                                update: function (key, values) {
                                    gridStockDetailSummary.dxDataGrid('instance').refresh();
                                },
                                insert: function (key, values) {
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
                            onContentReady: function (e) {
                                // This event is triggered when the content is ready, including the data
                                // You can perform actions here after the data source is loaded
                                // For example, hide the 'intBinId' column
                                e.component.columnOption('intBinId', 'visible', false);
                                e.component.columnOption('intBinId', 'allowEditing', false);
                                e.component.columnOption('strLocationName', 'caption', 'Location Name');
                                e.component.columnOption('strLocationName', 'allowEditing', false);
                                e.component.columnOption('strDCName', 'caption', 'DC Name');
                                e.component.columnOption('strDCName', 'allowEditing', false);
                                e.component.columnOption('strBin', 'caption', 'Bin Name');
                                e.component.columnOption('strBin', 'allowEditing', false);
                                e.component.columnOption('mnyBinCapacity', 'caption', 'Capacity');
                                e.component.columnOption('mnyBinCapacity', 'dataType', 'number');
                                e.component.columnOption('mnyEstimatedPallets', 'caption', 'Qty');
                                e.component.columnOption('mnyEstimatedPallets', 'allowEditing', false);
                                e.component.columnOption('strErpItemCode', 'caption', 'Item Code');
                                e.component.columnOption('strErpItemCode', 'allowEditing', false);
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
                    data: {},
                    success: function(data) {
                        gridStockLocationSummary.option('dataSource', data);
                        gridStockLocationSummary.refresh();
                    }
                });
            }
        });
    </script>

@endsection
