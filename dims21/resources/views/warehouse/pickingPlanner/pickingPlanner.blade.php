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
            overflow: hidden;
        }

        .panel-container {
            display: flex;
            flex-direction: row;
            height: 90%;
        }

        .panel-left {
            flex: 0 0 auto;
            width: 50%;
            min-height: 100%;
            min-width: 150px;
            max-width: calc(100% - 150px);
            padding: 10px;
        }

        .splitter {
            flex: 0 0 auto;
            width: 2px;
            cursor: col-resize;
            background: var(--hendok-red);
        }

        .panel-right {
            flex: 1 1 auto;
            min-height: 100%;
            min-width: 150px;
            max-width: calc(100% - 150px);
            padding: 10px;
        }
    </style>

    <div class="col-12 h-100">
        <div class="row gx-0 w-100">
            <div class="col-6">
                <div class="row gx-0">
                    <div class="col-4 px-1">
                        <div id="btnHome"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="selectDateRange"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="selectDC"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="selectRoute"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="selectProductGroup"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="btnGetOrders"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row gx-0">
                    <div class="col-4 px-1 mb-2">
                        <div id="inputUnickReference"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="selectTrailer"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="selectTeamLeader"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="inputLoadName"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="selectLoadType"></div>
                    </div>
                    <div class="col-4 px-1">
                        <div id="btnSavePlan"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-container">
            <div class="panel-left">
                <div id="gridPlannable"></div>
            </div>

            <div class="splitter"></div>

            <div class="panel-right">
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
                resizeHeight: false, // Prevent height resizing
                resizeWidth: true, // Allow width resizing
                minWidth: 150, // Minimum width constraint
                maxWidth: '100%', // Maximum width constraint (you can adjust as needed)
                disableSelection: true,
                containment: 'parent', // Contain the resizing within the parent element
                grid: [1, 0], // Optional: Snap to grid for more controlled resizing
            });

            var dcs = ({!! json_encode($dcs) !!});
            var routes = ({!! json_encode($routes) !!});
            var productGroups = [];

            var loadTypes = [{
                "value": "Hendok Tranport / CC",
                "display": "Hendok Tranport / CC",
            }, {
                "value": "Other",
                "display": "Other",
            }];

            var trailerTypes = ({!! json_encode($trailerTypes) !!});
            var teamleaders = ({!! json_encode($teamleaders) !!});

            let selectedDateFrom;
            let selectedDateTo;
            let selectedDC;
            let selectedRoutes;
            let selectedProductGroup;
            let selectedLoadType;

            let originalData = [];
            let plannableDetails = [];
            let plannableMaster = [];
            let plannedMaster = [];
            let bulkAdd = false;

            const btnHome = $('#btnHome').dxButton({
                stylingMode: 'contained',
                text: 'Home',
                type: 'normal',
                icon: 'fa fa-home',
                width: '100%',
                onClick() {
                    window.location.href = '{!! url('/') !!}';
                },
            }).dxButton("instance");

            const selectDateRange = $("#selectDateRange").dxDateRangeBox({
                displayFormat: 'yyyy-MM-dd',
                showClearButton: true,
                width: '100%',
                onValueChanged: function(e) {
                    if (e.value.length > 1 && e.value[0] != null && e.value[1] != null) {
                        selectedDateFrom = formatDate(e.value[0]);
                        selectedDateTo = formatDate(e.value[1]);
                    }
                },
            }).dxValidator({
                validationGroup: "getData",
                validationRules: [{
                    type: 'required',
                    message: 'Date is required',
                }],
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
            }).dxValidator({
                validationGroup: "getData",
                validationRules: [{
                    type: 'required',
                    message: 'DC is required',
                }],
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
            }).dxValidator({
                validationGroup: "getData",
                validationRules: [{
                    type: 'required',
                    message: 'Route is required',
                }],
            }).dxTagBox("instance");

            const selectProductGroup = $("#selectProductGroup").dxTagBox({
                dataSource: productGroups,
                valueExpr: 'ItemGroupDescription',
                displayExpr: 'ItemGroupDescription',
                placeholder: 'Proudct Group',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                multiline: false,
                searchEnabled: true,
                onValueChanged: function(e) {
                    const selectedValues = e.value;

                    if (selectedValues.length === 0) {
                        setAllGridData(originalData, plannedMaster)
                        return;
                    }

                    const filteredDetails = originalData.filter(function(detail) {
                        return selectedValues.includes(detail.ItemGroupDescription);
                    });

                    setAllGridData(filteredDetails, plannedMaster)
                },
            }).dxTagBox("instance");

            const btnGetOrders = $('#btnGetOrders').dxButton({
                stylingMode: 'contained',
                text: 'SEARCH',
                type: 'normal',
                width: '100%',
                icon: 'fa fa-search',
                validationGroup: "getData",
                onClick: function(e) {
                    var result = e.validationGroup.validate();
                    if (result.isValid) {
                        getSalesOrdersToPlan();
                    }
                }
            }).dxButton("instance");

            const inputUnickReference = $("#inputUnickReference").dxTextBox({
                placeholder: 'Ref',
                showSelectionControls: true,
                disabled: true,
                width: '100%',
                onValueChanged: function(e) {},
            }).dxTextBox("instance");

            const selectTrailer = $("#selectTrailer").dxSelectBox({
                dataSource: trailerTypes,
                valueExpr: 'TruckId',
                displayExpr: 'TruckName',
                placeholder: 'Trailer Type',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {

                },
            }).dxValidator({
                validationGroup: "saveData",
                validationRules: [{
                    type: 'required',
                    message: 'Trailer is required',
                }],
            }).dxSelectBox("instance");

            const selectTeamLeader = $("#selectTeamLeader").dxSelectBox({
                dataSource: teamleaders,
                valueExpr: 'UserID',
                displayExpr: 'FullName',
                placeholder: 'Team Leader',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {},
            }).dxValidator({
                validationGroup: "saveData",
                validationRules: [{
                    type: 'required',
                    message: 'Team Leader is required',
                }],
            }).dxSelectBox("instance");

            const inputLoadName = $("#inputLoadName").dxTextBox({
                placeholder: 'Load Name',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function(e) {},
            }).dxValidator({
                validationGroup: "saveData",
                validationRules: [{
                    type: 'required',
                    message: 'Load Name is required',
                }],
            }).dxTextBox("instance");

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
            }).dxValidator({
                validationGroup: "saveData",
                validationRules: [{
                    type: 'required',
                    message: 'Load Type is required',
                }],
            }).dxSelectBox("instance");

            const btnSavePlan = $('#btnSavePlan').dxButton({
                stylingMode: 'contained',
                text: 'SAVE',
                type: 'success',
                width: '100%',
                icon: 'fa fa-save',
                validationGroup: "saveData",
                onClick: function(e) {
                    var result = e.validationGroup.validate();
                    if (result.isValid) {
                        prepareToSave();
                    }
                }
            }).dxButton("instance");

            const gridPlannable = $("#gridPlannable").dxDataGrid({
                dataSource: [],
                showBorders: true,
                showRowLines: true,
                keyExpr: 'GroupKey',
                showColumnLines: true,
                height: '100%',
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
                        const index = plannedMaster.findIndex(item => item.OrderNo === e.itemData
                            .OrderNo && item.LineId === e.itemData.LineId);

                        if (index > -1) {
                            plannedMaster.splice(index, 1);
                        }
                        plannableDetails.push(e.itemData);

                        setAllGridData(plannableDetails, plannedMaster);
                    },
                },
                masterDetail: {
                    enabled: true,
                    autoExpandAll: false,
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
                                        const index = plannedMaster.findIndex(item => item
                                            .OrderNo === e.itemData.OrderNo && item
                                            .LineId === e.itemData.LineId);

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
                                        dataField: "intorderdetailId",
                                        caption: "OrderDetailId",
                                        visible: false,
                                    },
                                    {
                                        dataField: "strInstruction",
                                        caption: "Instruction"
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
                                    },
                                    {
                                        dataField: "OwnerID",
                                        caption: "Owner",
                                        visible: false,
                                    }
                                ],
                                onRowPrepared(e) {
                                    if (e.data) {
                                        if (e.data.strRowColor != null) {
                                            e.rowElement.css("background-color", e.data
                                                .strRowColor);
                                        }
                                    }
                                },
                            });
                    }
                },
                toolbar: {
                    items: [{
                        location: 'before',
                        widget: 'dxButton',
                        options: {
                            icon: 'expand',
                            onClick: function(e) {
                                const allExpanded = gridPlannable.option(
                                    'masterDetail.autoExpandAll');
                                gridPlannable.option('masterDetail.autoExpandAll', !
                                    allExpanded);
                                gridPlannable.refresh();
                                e.component.option('icon', allExpanded ? 'expand' : 'collapse');
                            }
                        }
                    }]
                },
                summary: {
                    recalculateWhileEditing: true,
                    totalItems: [{
                        column: "mnyTons",
                        summaryType: "sum",
                        displayFormat: 'Tons: {0}',
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 4
                        }
                    }]
                },
                onRowPrepared(e) {
                    if (e.data) {
                        if (e.data.strRowColor != null) {
                            e.rowElement.css("background-color", e.data
                                .strRowColor);
                        }
                    }
                },
            }).dxDataGrid('instance');

            const gridPlanned = $("#gridPlanned").dxDataGrid({
                dataSource: [],
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                height: '100%',
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
                        if (!bulkAdd) {
                            const index = plannableDetails.findIndex(item => item.OrderNo === e.itemData
                                .OrderNo && item.LineId === e.itemData.LineId);

                            if (index > -1) {
                                plannableDetails.splice(index, 1);
                            }
                            plannedMaster.push(e.itemData);

                        } else {
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
                        dataField: "StoreName",
                        caption: "Customer Name",
                        groupIndex: 0,
                        allowEditing: false,
                        groupCellTemplate: function(container, options) {
                            const storeName = options.value;
                            const groupItems = options.data.items || options.data.collapsedItems;
                            const itemCount = groupItems.length;
                            const initialIntSequence = groupItems.length > 0 ? groupItems[0]
                                .intSequence : null;

                            const intSequenceEditor = $("<div>").dxNumberBox({
                                value: initialIntSequence,
                                onValueChanged: function(e) {
                                    const newIntSequence = e.value;
                                    groupItems.forEach(item => {
                                        item.intSequence = newIntSequence;
                                    });
                                    setAllGridData(plannableDetails, plannedMaster);
                                }
                            });

                            // Create a flex container for alignment
                            const flexContainer = $("<div>").css({
                                display: "flex",
                                alignItems: "center", // Vertically align items in the center
                                justifyContent: "space-between", // Space between storeName and intSequenceEditor
                                height: "100%" // Make the div's height match the container
                            });

                            // Create and append the store name div
                            const storeNameDiv = $("<div>").text(
                                `${storeName} (${itemCount} lines)`).css({
                                flexGrow: 1, // Allow it to take up the remaining space
                                textAlign: "left"
                            });

                            // Create a wrapper for the sequence editor and label
                            const sequenceWrapper = $("<div>").css({
                                display: "flex",
                                alignItems: "center" // Vertically align the editor and label
                            });

                            // Append the sequence label
                            const sequenceLabel = $("<div>").text("Seq").css({
                                marginRight: "10px"
                            });

                            // Append the number box to the wrapper
                            sequenceWrapper.append(sequenceLabel).append(intSequenceEditor);

                            // Append the store name div and sequence wrapper to the flex container
                            flexContainer.append(storeNameDiv).append(sequenceWrapper);

                            // Append the flex container to the cell container
                            container.append(flexContainer);

                            // Set specific styling for the number box
                            container.find(".dx-numberbox").css("width", "150px");
                        }

                    }, {
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
                        dataField: "intorderdetailId",
                        caption: "OrderDetailId",
                        visible: false,
                    },
                    {
                        dataField: "strInstruction",
                        caption: "Instruction"
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
                        // visible: false,
                    },
                    {
                        dataField: "mnyTons",
                        caption: "Tons",
                        sColor: "Red",
                        format: "#0.####",
                        dataType: "number",
                        calculateCellValue: function(rowData) {
                            return rowData.mnyTonsProduct * rowData.mnyToPlan;
                        },
                        cellTemplate: function(element, info) {
                            element.append("<div>" + info.text + "</div>")
                                .css("background", "#152b4d73")
                                .css("color", "#fff")
                                .css("font-size", "16px")
                                .css("font-weight", "900");
                        }
                    },
                    {
                        dataField: "OwnerID",
                        caption: "Owner",
                        visible: false,
                    },
                    {
                        dataField: "intSequence",
                        caption: "Sequence",
                        dataType: "number",
                        alignment: "center",
                        allowEditing: true,
                    },
                ],
                onRowPrepared(e) {
                    if (e.data) {
                        if (e.data.strRowColor != null) {
                            e.rowElement.css("background-color", e.data.strRowColor);
                        }
                    }
                },
                toolbar: {
                    items: [{
                        location: 'before',
                        widget: 'dxButton',
                        options: {
                            icon: 'collapse',
                            onClick: function(e) {
                                const allExpanded = gridPlanned.option(
                                    'grouping.autoExpandAll');
                                gridPlanned.option('grouping.autoExpandAll', !allExpanded);
                                e.component.option('icon', allExpanded ? 'expand' : 'collapse');
                            }
                        }
                    }]
                },
                grouping: {
                    autoExpandAll: true
                },
                sortByGroupSummaryInfo: [{
                    summaryItem: 'count',
                }],
                summary: {
                    recalculateWhileEditing: true,
                    groupItems: [{
                        column: 'mnyToPlan',
                        summaryType: 'sum',
                        displayFormat: 'Total: {0}',
                        showInGroupFooter: true,
                    }, {
                        column: 'mnyTons',
                        summaryType: 'sum',
                        displayFormat: 'Tons: {0}',
                        showInGroupFooter: true,
                        valueFormat: {
                            type: "fixedPoint",
                            precision: 4
                        }
                    }],
                    totalItems: [{
                            column: "mnyToPlan",
                            summaryType: "sum",
                            displayFormat: 'Plan: {0}',
                        },
                        {
                            column: "mnyTons",
                            summaryType: "sum",
                            displayFormat: 'Tons: {0}',
                            valueFormat: {
                                type: "fixedPoint",
                                precision: 4
                            }
                        }
                    ]
                },
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
                            mnyTons: 0
                        };
                    }

                    groupedData[key].mnyTons += parseFloat(item.mnyTonsProduct * item.mnyToPlan);
                });

                return $.map(groupedData, function(value, key) {
                    return value;
                });
            }

            function prepareToSave() {

                gridPlanned.saveEditData();
                const plannedLines = gridPlanned.option('dataSource');

                console.debug("Planned Lines");
                console.debug(plannedLines);

                if (Array.isArray(plannedLines)) {
                    const linesWithPlannedQty = plannedLines.filter(element =>
                        parseFloat(element.mnyAlreadyPlanned) > 0
                    );
                    console.debug("Planned Lines is an array.");

                    if (linesWithPlannedQty.length > 0) {
                        console.debug("Lines have already been planned");
                        let confirmationMessage = "<p class='fw-bold'>These lines have already been planned:</p>";
                        linesWithPlannedQty.forEach(element => {
                            confirmationMessage +=
                                `[ ${element.OrderNo} ] ${element.PastelDescription}<br>`;
                        });

                        confirmationMessage += "<br><p class='fw-bold'>Are you sure you want to proceed?</p>";

                        DevExpress.ui.dialog.confirm(confirmationMessage, "Confirmation").done(function(confirmed) {
                            if (confirmed) {
                                savePickingPlan(plannedLines);
                            } else {
                                return;
                            }
                        });
                    } else {
                        console.debug("No Lines have already been planned");
                        savePickingPlan(plannedLines);
                    }
                }
            }

            function savePickingPlan(plannedLines) {
                const lines = [];

                plannedLines.forEach(value => {
                    const mnyToPlan = Number(value.mnyToPlan);

                    if (mnyToPlan !== 0) {
                        let strPickingType = '';

                        if (value.strInstruction === 'Upliftment-DIMS') {
                            strPickingType = 'upliftment';
                        } else {
                            strPickingType = 'priority';
                        }

                        lines.push({
                            'intorderdetailId': value.intorderdetailId,
                            'mnyQty': mnyToPlan.toFixed(4),
                            'strPickingType': strPickingType,
                            'intOwnerID': value.OwnerID,
                            'strUnickReference': inputUnickReference.option(
                                'value'),
                            'intSequence': value.intSequence,
                        });
                    }
                });

                loadingPanel.option('visible', true);

                $.ajax({
                    url: '{!! url('/savePickingPlan') !!}',
                    type: "POST",
                    data: {
                        lines: lines,
                        strUnickReference: inputUnickReference.option('value'),
                        intDc: selectDC.option('value'),
                        intTrailerType: selectTrailer.option('value'),
                        intTeamLeaderId: selectTeamLeader.option('value'),
                        loadName: inputLoadName.option('value'),
                        loadType: selectLoadType.option('value'),
                    },
                    success: function(data) {
                        window.open('{!! url('/pickingplanlist') !!}/' +
                            inputUnickReference.option('value'),
                            "strUnickReference",
                            "location=1,status=1,scrollbars=1, width=1200,height=850"
                        );

                        selectDateRange.option('value', []);
                        selectDC.option('value', '');
                        selectRoute.option('value', []);
                        selectProductGroup.option('value', '');
                        selectProductGroup.option('dataSource', []);

                        inputUnickReference.option('value', '');
                        selectTrailer.option('value', '');
                        selectTeamLeader.option('value', '');
                        inputLoadName.option('value', '');
                        selectLoadType.option('value', '');

                        gridPlannable.option('dataSource', []);
                        gridPlannable.refresh();
                        gridPlanned.option('dataSource', []);
                        gridPlanned.refresh();

                        DevExpress.validationEngine.resetGroup("getData");
                        DevExpress.validationEngine.resetGroup("saveData");

                    },
                    error: function() {
                        DevExpress.ui.notify("Error fetching data.", "error",
                            3000);
                    },
                    complete: function() {
                        // Hide the loading panel
                        loadingPanel.option('visible', false);
                    }
                });
            }

            function getSalesOrdersToPlan() {
                loadingPanel.option('visible', true);

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
                        originalData = data.orders;
                        setAllGridData(data.orders, plannedMaster);
                        inputUnickReference.option('value', data.strUnickReference);
                        setItemGroupData(data.orders);
                    },
                    error: function() {
                        DevExpress.ui.notify("Error fetching data.", "error", 3000);
                    },
                    complete: function() {
                        // Hide the loading panel
                        loadingPanel.option('visible', false);
                    }
                });
            }

            function setAllGridData(plannableData, plannedData) {
                plannedMaster = plannedData;

                plannableDetails = plannableData.filter(plannableItem => {
                    return !plannedMaster.some(plannedItem => {
                        return (
                            plannableItem.CustomerPastelCode === plannedItem
                            .CustomerPastelCode &&
                            plannableItem.StoreName === plannedItem.StoreName &&
                            plannableItem.Area === plannedItem.Area &&
                            plannableItem.Route === plannedItem.Route &&
                            plannableItem.OrderDate === plannedItem.OrderDate &&
                            plannableItem.DeliveryDate === plannedItem.DeliveryDate &&
                            plannableItem.OrderNo === plannedItem.OrderNo &&
                            plannableItem.LineId === plannedItem.LineId &&
                            plannableItem.PastelCode === plannedItem.PastelCode &&
                            plannableItem.PastelDescription === plannedItem.PastelDescription &&
                            plannableItem.mnyQtyOutstanding === plannedItem.mnyQtyOutstanding
                        );
                    });
                });

                plannableMaster = groupData(plannableDetails);


                let expandedRowKeys = gridPlannable.option("masterDetail.expandedRowKeys");
                gridPlannable.option('dataSource', plannableMaster);
                gridPlannable.refresh();
                gridPlannable.option("masterDetail.expandedRowKeys", expandedRowKeys);

                gridPlanned.option('dataSource', plannedMaster);
                gridPlanned.refresh();
            }

            function setItemGroupData(data) {
                $.each(data, function(index, item) {
                    var existingGroup = $.grep(productGroups, function(group) {
                        return group.ItemGroupDescription === item.ItemGroupDescription;
                    });
                    if (existingGroup.length === 0) {
                        productGroups.push({
                            ItemGroupDescription: item.ItemGroupDescription,
                        });
                    }
                });
                selectProductGroup.option('items', productGroups);
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
