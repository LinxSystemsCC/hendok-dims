@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Picking Planner')

{{-- Set to show navbar --}}
@php
    $includeMenu = false;
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

        .dx-datagrid .dx-row > td{
            padding: 5px !important;
        }
    </style>

    <div class="col-12 h-100">
        <div class="panel-container h-100">
            <div class="panel-left">
                <div class="row">
                    <div class="col-1 px-1 ms-3">
                        <button id="btnHome" class="btn btn-sm btn-secondary">
                            Home
                        </button>
                    </div>
                    <div class="col px-1">
                        <div id="selectDateRange"></div>
                    </div>
                    <div class="col px-1">
                        <div id="selectDC"></div>
                    </div>
                    <div class="col px-1">
                        <div id="selectRoute"></div>
                    </div>
                    <div class="col px-1">
                        <div id="selectProductGroup"></div>
                    </div>
                    <div class="col px-1">
                        <div id="btnGetOrders"></div>
                    </div>
                </div>
                <div id="gridPlannable" style="height: 90%;"></div>
            </div>

            <div class="splitter"></div>

            <div class="panel-right">
                <div class="row">
                    <div class="col px-1">
                        <div id="inputUnickReference"></div>
                    </div>
                    <div class="col px-1">
                        <div id="selectTrailer"></div>
                    </div>
                    <div class="col px-1">
                        <div id="selectTeamLeader"></div>
                    </div>
                    <div class="col px-1">
                        <div id="inputLoadName"></div>
                    </div>
                    <div class="col px-1">
                        <div id="selectLoadType"></div>
                    </div>
                </div>
                <div id="gridPlanned" style="height: 90%;"></div>
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

            $('#btnHome').click(function() {
                // Replace '/your-laravel-route' with the actual URL or route name
                window.location.href = '{!! url('/') !!}';
            });

            var dcs = ({!! json_encode($dcs) !!});
            var routes = ({!! json_encode($routes) !!});
            var productGroups = ({!! json_encode($productGroups) !!});
            var loadTypes = [{
                "value": "Hendok Tranport / CC",
                "display": "Hendok Tranport / CC",
            }, {
                "value": "Other",
                "display": "Other",
            }];

            let selectedDateFrom = '2023-08-01';
            let selectedDateTo = '2023-08-30';
            let selectedDC = 1;
            let selectedRoutes = [10,12,25,63,20,29,41,52,57,35];
            let selectedProductGroup;
            let selectedLoadType;

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

            const selectProductGroup = $("#selectProductGroup").dxSelectBox({
                dataSource: productGroups,
                valueExpr: 'ItemGroupDescription',
                displayExpr: 'ItemGroupDescription',
                placeholder: 'Proudct Group',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {
                    selectedProductGroup = e.value;
                },
            }).dxSelectBox("instance");

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

            const inputUnickReference = $("#inputUnickReference").dxTextBox({
                placeholder: 'Ref',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
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
                placeholder: 'Team Leader',
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

            let plannableDetails = [];
            let plannableMaster = [];
            let plannedMaster = [];
            let bulkAdd = false;

            const gridPlannable = $("#gridPlannable").dxDataGrid({
                dataSource: [],
                showBorders: true,
                showRowLines: true,
                keyExpr: 'GroupKey',
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
                        caption: "Tons",
                        dataType: "number",
                        alignment: "center",
                        format: "#0.####",
                    }
                ],
                rowDragging: {
                    group: 'sharedGroup',
                    allowDragging: false,
                    onDragStart: function(e) {
                        e.itemData = e.itemData;
                        bulkAdd = true;
                    },
                    onAdd: function(e) {
                        const index = plannedMaster.findIndex(item => item.OrderNo === e.itemData.OrderNo && item.LineId === e.itemData.LineId);

                        if (index > -1) {
                            plannedMaster.splice(index, 1);
                        }
                        plannableDetails.push(e.itemData);

                        setAllGridData(plannableDetails, plannedMaster);
                    },
                },
                masterDetail: {
                    enabled: true,
                    template: function(container, options) {
                        const masterRow = options.data;
                        const masterDetailData = plannableDetails.filter(detail =>
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
                                dataSource: masterDetailData,
                                showBorders: true,
                                rowDragging: {
                                    group: 'sharedGroup',
                                    onDragStart: function(e) {
                                        e.itemData = e.itemData;
                                        bulkAdd = false;
                                    },
                                    onAdd: function(e) {
                                        const index = plannedMaster.findIndex(item => item.OrderNo === e.itemData.OrderNo && item.LineId === e.itemData.LineId);

                                        if (index > -1) {
                                            plannedMaster.splice(index, 1);
                                        }
                                        plannableDetails.push(e.itemData);

                                        setAllGridData(plannableDetails, plannedMaster);
                                    },
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
                                        dataField: "mnyOutstanding",
                                        caption: "Outstanding",
                                        dataType: "number",
                                        alignment: "center",
                                        format: "#0.####",
                                    },
                                    {
                                        dataField: "mnyAvail",
                                        caption: "Available",
                                        dataType: "number",
                                        alignment: "center",
                                        format: "#0.####",
                                    }
                                ]
                            });
                    }
                }
            }).dxDataGrid('instance');

            const gridPlanned = $("#gridPlanned").dxDataGrid({
                dataSource: [],
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                paging: {
                    enabled: false
                },
                editing: {
                    mode: 'batch',
                    allowUpdating: true,
                    useIcons: true,
                },
                selection: {
                    mode: "single"
                },
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "nextColumn",
                rowDragging: {
                    group: 'sharedGroup', // Ensure the group matches the one in gridPlannable's detail grid
                    allowReordering: true,
                    allowDropInsideItem: false,
                    onDragStart: function(e) {
                        e.itemData = e.itemData;
                    },
                    onAdd: function(e) {
                        if (!bulkAdd){
                            const index = plannableDetails.findIndex(item => item.OrderNo === e.itemData.OrderNo && item.LineId === e.itemData.LineId);

                            if (index > -1) {
                                plannableDetails.splice(index, 1);
                            }
                            plannedMaster.push(e.itemData);

                        }else{
                            var criteria = {
                                Area: e.itemData.Area,
                                CustomerPastelCode: e.itemData.CustomerPastelCode,
                                DeliveryDate: e.itemData.DeliveryDate,
                                OrderDate: e.itemData.OrderDate,
                                Route: e.itemData.Route,
                                StoreName: e.itemData.StoreName
                            };

                            var matchedItems = [];
                            var nonMatchedItems = [];

                            $.each(plannableDetails, function(index, item) {
                                if (item.Area === criteria.Area &&
                                    item.CustomerPastelCode === criteria.CustomerPastelCode &&
                                    item.DeliveryDate === criteria.DeliveryDate &&
                                    item.OrderDate === criteria.OrderDate &&
                                    item.Route === criteria.Route &&
                                    item.StoreName === criteria.StoreName) {
                                    matchedItems.push(item);
                                } else {
                                    nonMatchedItems.push(item);
                                }
                            });

                            plannableDetails = nonMatchedItems;

                            $.merge(plannedMaster, matchedItems);
                        }
                        
                        setAllGridData(plannableDetails, plannedMaster);
                    }
                },
                columns: [{
                        dataField: "OrderNo",
                        caption: "Order No",
                        allowEditing: false,
                    },
                    {
                        dataField: "LineId",
                        caption: "Line Id",
                        allowEditing: false,
                    },
                    {
                        dataField: "PastelCode",
                        caption: "Pastel Code",
                        allowEditing: false,
                    },
                    {
                        dataField: "PastelDescription",
                        caption: "Pastel Description",
                        allowEditing: false,
                    },
                    {
                        dataField: "mnyOutstanding",
                        caption: "Outstanding",
                        dataType: "number",
                        alignment: "center",
                        format: "#0.####",
                        allowEditing: false,
                    },
                    {
                        dataField: "mnyAvail",
                        caption: "Available",
                        dataType: "number",
                        alignment: "center",
                        format: "#0.####",
                        allowEditing: false,
                    },
                    {
                        dataField: "mnyToPlan",
                        caption: "Plan",
                        dataType: "number",
                        alignment: "center",
                        format: "#0.####",
                        cellTemplate: function(element, info) {
                            element.append("<div>" + info.text + "</div>")
                                .css("background", "#5c95c573")
                                .css("font-size", "16px")
                                .css("font-weight", "900");
                        }
                    },
                    {
                        dataField: "mnyAlreadyPlanned",
                        caption: "Already Planned",
                        dataType: "number",
                        alignment: "center",
                        format: "#0.####",
                        allowEditing: false,
                        visible: false,
                    },
                    {
                        dataField: "mnyTons",
                        caption: "Tons",
                        dataType: "number",
                        alignment: "center",
                        format: "#0.####",
                        allowEditing: false,
                    }
                ],
            }).dxDataGrid('instance');

            function groupData(data) {
                var groupedData = {};

                $.each(data, function(index, item) {
                    var key = item.CustomerPastelCode + '|' + item.StoreName + '|' + item.Area + '|' + item
                        .Route + '|' + item.OrderDate + '|' + item.DeliveryDate;

                    if (!groupedData[key]) {
                        groupedData[key] = {
                            GroupKey: key,
                            CustomerPastelCode: item.CustomerPastelCode,
                            StoreName: item.StoreName,
                            Area: item.Area,
                            Route: item.Route,
                            OrderDate: item.OrderDate,
                            DeliveryDate: item.DeliveryDate,
                            mnyTons: 0 // Initialize Tons
                        };
                    }

                    groupedData[key].mnyTons += parseFloat(item.mnyTons);
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
                        productGroup: selectedProductGroup,
                    },
                    success: function(data) {
                        setAllGridData(data.orders, []);
                        inputUnickReference.option('value', data.strUnickReference);
                    }
                });
            }

            function setAllGridData(plannableData, plannedData) {
                plannableDetails = plannableData;
                plannableMaster = groupData(plannableData);
                plannedMaster = plannedData;

                let expandedRowKeys = gridPlannable.option("masterDetail.expandedRowKeys");
                gridPlannable.option('dataSource', plannableMaster);
                gridPlannable.refresh();
                gridPlannable.option("masterDetail.expandedRowKeys", expandedRowKeys);

                gridPlanned.option('dataSource', plannedMaster);
                gridPlanned.refresh();
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
