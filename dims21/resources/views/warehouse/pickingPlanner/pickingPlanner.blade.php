@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Picking Planner')

{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <style>
        html,
        body {
            height: 100%;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            padding: 0;
            margin: 0;
            overflow: auto;
        }

        .panel-container {
            display: flex;
            flex-direction: row;
            overflow: hidden;
            height: 100%;
        }

        .panel-left {
            flex: 0 0 auto;
            width: 50%;
            min-height: 100%;
            min-width: 150px;
            max-width: calc(100% - 150px);
            overflow-y: auto;
        }

        .splitter {
            flex: 0 0 auto;
            width: 3px;
            cursor: col-resize;
            background: var(--hendok-red);
        }

        .panel-right {
            flex: 1 1 auto;
            min-height: 100%;
            min-width: 150px;
            max-width: calc(100% - 150px);
            overflow-y: auto;
        }

        .panel-left p,
        .panel-right p {
            white-space: normal;
            word-wrap: break-word;
        }
    </style>

    <div class="col-12 h-100">
        <div class="panel-container">
            <div class="panel-left">
                <div class="row">
                    <div class="col-4 px-1">
                        <div id="selectDateRange"></div>
                    </div>
                    <div class="col-2 px-1">
                        <div id="selectDC"></div>
                    </div>
                    <div class="col-2 px-1">
                        <div id="selectRoute"></div>
                    </div>
                    <div class="col-2 px-1">
                        <div id="selectLoadType"></div>
                    </div>
                    <div class="col-2 px-1">
                        <div id="btnGetOrders"></div>
                    </div>
                </div>
                <div id="gridPlannable"></div>
            </div>

            <div class="splitter"></div>

            <div class="panel-right">
                <div class="row">
                    <div class="col-3 px-1">
                        <div id="inputTLNumber"></div>
                    </div>
                    <div class="col-3 px-1">
                        <div id="selectTrailer"></div>
                    </div>
                    <div class="col-3 px-1">
                        <div id="selectTeamLeader"></div>
                    </div>
                    <div class="col-3 px-1">
                        <div id="inputLoadName"></div>
                    </div>
                </div>
                <div id="gridPlanned"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $(".panel-left").resizable({
                handleSelector: ".splitter",
                resizeHeight: false,
                disableSerialization: true,
            });

            var dcs = ({!! json_encode($dcs) !!});
            var routes = ({!! json_encode($routes) !!});
            var loadTypes = [{
                "value": "Hendok Tranport / CC",
                "display": "Hendok Tranport / CC",
            }, {
                "value": "Other",
                "display": "Other",
            }];

            let selectedDateFrom, selectedDateTo, selectedDC, selectedRoutes, selectedLoadType;

            const selectDateRange = $("#selectDateRange").dxDateRangeBox({
                displayFormat: 'yyyy-MM-dd',
                showClearButton: true,
                width: '100%',
                onValueChanged: function(e) {
                    if (e.value.length > 1 && e.value[0] != null && e.value[1] != null) {
                        selectedDateFrom = formatDate(e.value[0]);
                        selectedDateTo = formatDate(e.value[1]);
                    }
                }
            }).dxDateRangeBox("instance");

            const selectDC = $("#selectDC").dxSelectBox({
                dataSource: dcs,
                valueExpr: 'intAutoId',
                displayExpr: 'strDCName',
                placeholder: 'DC',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {
                    selectedDC = e.value;
                },
            }).dxSelectBox("instance");

            const selectRoute = $("#selectRoute").dxTagBox({
                dataSource: routes,
                valueExpr: 'Routeid',
                displayExpr: 'Route',
                displayExpr: function(item) {
                    return item && item.Route + ' : ' + parseInt(item.m, 10);
                },
                placeholder: 'Route',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                multiline: false,
                searchEnabled: true,
                onValueChanged: function(e) {
                    selectedRoutes = e.value;
                },
            }).dxTagBox("instance");

            const selectLoadType = $("#selectLoadType").dxSelectBox({
                dataSource: loadTypes,
                valueExpr: 'value',
                displayExpr: 'display',
                placeholder: 'Load Type',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {
                    selectedLoadType = e.value;
                },
            }).dxSelectBox("instance");

            const btnGetOrders = $('#btnGetOrders').dxButton({
                stylingMode: 'contained',
                text: 'SEARCH',
                type: 'success',
                width: '100%',
                onClick() {
                    getSalesOrdersToPlan();
                },
            }).dxButton("instance");

            const inputTLNumber = $("#inputTLNumber").dxTextBox({
                placeholder: 'TL number',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {},
            }).dxTextBox("instance");

            const selectTrailer = $("#selectTrailer").dxSelectBox({
                dataSource: [],
                valueExpr: 'intAutoId',
                displayExpr: 'strDCName',
                placeholder: 'Trailer Type',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {},
            }).dxSelectBox("instance");

            const selectTeamLeader = $("#selectTeamLeader").dxSelectBox({
                dataSource: [],
                valueExpr: 'intAutoId',
                displayExpr: 'strDCName',
                placeholder: 'Trailer Type',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {},
            }).dxSelectBox("instance");

            const inputLoadName = $("#inputLoadName").dxTextBox({
                placeholder: 'Load Name',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {},
            }).dxTextBox("instance");

            let detailData = [];
            let plannedData = [];

            const gridPlannable = $("#gridPlannable").dxDataGrid({
                dataSource: [],
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
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
                    mode: "single"
                },
                columnFixing: {
                    enabled: true
                },
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "nextColumn",
                columns: [{
                        dataField: "CustomerPastelCode",
                        caption: "Customer Code"
                    },
                    {
                        dataField: "StoreName",
                        caption: "Customer Name"
                    },
                    {
                        dataField: "Area",
                        caption: "Area"
                    },
                    {
                        dataField: "Route",
                        caption: "Route"
                    },
                    {
                        dataField: "OrderDate",
                        caption: "Order Date"
                    },
                    {
                        dataField: "DeliveryDate",
                        caption: "Delivery Date"
                    },
                    {
                        dataField: "mnyTons",
                        caption: "Tons"
                    }
                ],
                masterDetail: {
                    enabled: true,
                    template: function(container, options) {
                        const masterRow = options.data;
                        const lineData = detailData.filter(detail =>
                            detail.CustomerPastelCode === masterRow.CustomerPastelCode &&
                            detail.StoreName === masterRow.StoreName &&
                            detail.Area === masterRow.Area &&
                            detail.Route === masterRow.Route &&
                            detail.OrderDate === masterRow.OrderDate &&
                            detail.DeliveryDate === masterRow.DeliveryDate
                        );

                        $("<div>")
                            .appendTo(container)
                            .dxDataGrid({
                                dataSource: lineData,
                                showBorders: true,
                                rowDragging: {
                                    group: 'taskGroup',
                                    onDragStart: function(e) {
                                        e.itemData = e.itemData; // Store the dragged data
                                    },
                                    onDragEnd: function(e) {
                                        if (e.fromComponent === gridPlannable && e
                                            .toComponent === gridPlanned) {
                                            const removedItem = e.itemData;
                                            const masterRowKey = generateMasterRowKey(
                                                removedItem);

                                            // Remove the item from detailData
                                            detailData = detailData.filter(detail =>
                                                generateMasterRowKey(detail) !==
                                                masterRowKey
                                            );

                                            // Add the item to plannedData
                                            if (!plannedData.some(item => generateMasterRowKey(
                                                    item) === masterRowKey)) {
                                                plannedData.push(removedItem);
                                            }

                                            // Refresh grids
                                            refreshGrids();
                                        }
                                    }
                                },
                                columns: [{
                                        dataField: "OrderNo",
                                        caption: "Order No"
                                    },
                                    {
                                        dataField: "LineId",
                                        caption: "Line Id"
                                    },
                                    {
                                        dataField: "PastelCode",
                                        caption: "Pastel Code"
                                    },
                                    {
                                        dataField: "PastelDescription",
                                        caption: "Pastel Description"
                                    },
                                    {
                                        dataField: "mnyQtyOutstanding",
                                        caption: "Qty Outstanding"
                                    },
                                    {
                                        dataField: "qtyAlreadyPlanned",
                                        caption: "Qty Planned"
                                    },
                                    {
                                        dataField: "mnyAvail",
                                        caption: "Available"
                                    }
                                ]
                            });
                    }
                }
            }).dxDataGrid('instance');

            const gridPlanned = $("#gridPlanned").dxDataGrid({
                dataSource: plannedData,
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                paging: {
                    enabled: false
                },
                selection: {
                    mode: "single"
                },
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "nextColumn",
                columns: [{
                        dataField: "OrderNo",
                        caption: "Order No"
                    },
                    {
                        dataField: "LineId",
                        caption: "Line Id"
                    },
                    {
                        dataField: "PastelCode",
                        caption: "Pastel Code"
                    },
                    {
                        dataField: "PastelDescription",
                        caption: "Pastel Description"
                    },
                    {
                        dataField: "mnyQtyOutstanding",
                        caption: "Qty Outstanding"
                    },
                    {
                        dataField: "qtyAlreadyPlanned",
                        caption: "Qty Planned"
                    },
                    {
                        dataField: "mnyAvail",
                        caption: "Available"
                    }
                ],
                rowDragging: {
                    group: 'taskGroup',
                    onDragStart: function(e) {
                        e.itemData = e.itemData; // Store the dragged data
                    }
                }
            }).dxDataGrid('instance');

            function generateMasterRowKey(item) {
                return item.CustomerPastelCode + '_' + item.StoreName + '_' + item.Area + '_' +
                    item.Route + '_' + item.OrderDate + '_' + item.DeliveryDate;
            }

            function refreshGrids() {
                // Refresh the master-detail data for gridPlannable
                gridPlannable.option('dataSource', groupData(detailData));
                gridPlannable.refresh();

                // Refresh the data for gridPlanned
                gridPlanned.option('dataSource', plannedData);
                gridPlanned.refresh();
            }

            function groupData(data) {
                var groupedData = {};

                $.each(data, function(index, item) {
                    var key = generateMasterRowKey(item);

                    if (!groupedData[key]) {
                        groupedData[key] = {
                            CustomerPastelCode: item.CustomerPastelCode,
                            StoreName: item.StoreName,
                            Area: item.Area,
                            Route: item.Route,
                            OrderDate: item.OrderDate,
                            DeliveryDate: item.DeliveryDate,
                            Tons: 0 // Initialize Tons
                        };
                    }

                    groupedData[key].Tons += item.Tons;
                });

                return $.map(groupedData, function(value, key) {
                    return value;
                });
            }

            // Fetch initial data
            function getSalesOrdersToPlan() {
                $.ajax({
                    url: '{!! url('/getSalesOrdersToPlanOptimized') !!}',
                    type: "POST",
                    data: {
                        DeliveryDateFrom: selectedDateFrom,
                        DeliveryDateTo: selectedDateTo,
                        intDcId: selectedDC,
                        routeIds: selectedRoutes.join(','),
                    },
                    success: function(data) {
                        detailData = data;
                        refreshGrids();
                    }
                });
            }

            function formatDate(date) {
                if (!date) {
                    return '';
                }

                // Check if the date is already in the correct format (yyyy-MM-dd)
                const datePattern = /^\d{4}-\d{2}-\d{2}$/;
                if (datePattern.test(date)) {
                    return date;
                }

                // Parse the date string into a Date object
                const parsedDate = new Date(date);
                if (isNaN(parsedDate)) {
                    // If the date is invalid, return an empty string or handle the error as needed
                    return '';
                }

                // Format the date to yyyy-MM-dd
                const returnFormat = parsedDate.toLocaleDateString("en-ZA", {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });

                return returnFormat.replace(/\//g, '-');
            }
        });
    </script>

@endsection
