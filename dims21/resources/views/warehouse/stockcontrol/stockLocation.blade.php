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
                columns: [
                    {
                        dataField: "strPartNumber",
                        caption: "Item Code",

                    }, {
                        dataField: "strItemDescription",
                        caption: "Item Name",

                    }, {
                        dataField: "strItemGroupDescription",
                        caption: "Item Group",

                    }, {
                        dataField: "mnyOnHand",
                        caption: "On Hand",
                        dataType:"number",
                        format: "#0",

                    },{
                        dataField: "mnyOnHandPallet",
                        caption: "On Hand Pallet",
                        dataType:"number",
                        format: "#0",

                    },{
                        dataField: "mnyAvail",
                        caption: "Avail.",
                        dataType:"number",
                        format: "#0",

                    },{
                        dataField: "mnyAvailPallet",
                        caption: "Avail Pallet",
                        dataType:"number",
                        format: "#0",

                    }, {
                        dataField: "mnyOnHandWeight",
                        caption: "On Hand Weight",

                    }, {
                        dataField: "mnyAvailWeight",
                        caption: "Avail Weight",

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
                                        url: '{!!url("/getStockDetailsSummary")!!}',
                                        method: 'GET',
                                        data: { 
                                            ItemCode: ItemCode,
                                            intDCid: selectedDC,
                                        },
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
                                e.component.columnOption('mnyOnHand', 'caption', 'On Hand Qty');
                                e.component.columnOption('mnyOnHandPallet', 'caption', 'On Hand Pallet Qty');
                                e.component.columnOption('mnyAvail', 'caption', 'Avail Qty');
                                e.component.columnOption('mnyAvailPallet', 'caption', 'Avail Pallet Qty');
                                e.component.columnOption('mnyOnHandWeight', 'caption', 'On Hand Weigh');
                                e.component.columnOption('mnyAvailWeight', 'caption', 'Avail Weight');
                                e.component.columnOption('strPartNumber', 'caption', 'Item Code');
                                e.component.columnOption('strPartNumber', 'allowEditing', false);
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
                            onValueChanged: function (e) {
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
                                load: function () {
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
