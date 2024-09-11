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
                    <div class="col-4 d-inline-flex px-1 mb-2">
                        <input type="checkbox" value="0" id="checkDate">
                        <div id="selectDateRange"></div>
                    </div>
                    <div class="col-4 d-inline-flex px-1 mb-2">
                        <input type="checkbox" value="0" id="checkDC">
                        <div id="selectDC"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="selectRoute"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="selectType"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="btnGetOrders"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row gx-0">
                    <div class="col-4 d-inline-flex px-1 mb-2">
                        <div id="btnImportPlan"></div>
                        <div id="inputUnickReference"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="selectTrailer"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="selectTeamLeader"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="inputLoadName"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <div id="selectLoadType"></div>
                    </div>
                    <div class="col-4 px-1 mb-2">
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

        <div id="popupEditPlan">
            <div class="dx-field">
                <div class="dx-field-label">Select A Plan</div>
                <div class="dx-field-value">
                    <div id="selectPlan"></div>
                </div>
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
                resizeWidth: true,
                minWidth: 150,
                maxWidth: '100%',
                disableSelection: true,
                containment: 'parent',
                grid: [1, 0],
                stop: function(event, ui) {
                    gridPlannable.repaint();
                    gridPlanned.repaint();
                }
            });

            var dcs = ({!! json_encode($dcs) !!});
            var routes = ({!! json_encode($routes) !!});
            var TLNumbers = ({!! json_encode($TLNumbers) !!});

            var productGroups = [];
            var salesOrders = [];
            let selectProductGroup;
            let selectSalesOrder;

            var loadTypes = [{
                "value": "Hendok Transport",
                "display": "Hendok Transport",
            }, {
                "value": "Outside Transport",
                "display": "Outside Transport",
            }, {
                "value": "Customer Collection",
                "display": "Customer Collection",
            }, {
                "value": "IBT Hendok Transport",
                "display": "IBT Hendok Transport",
            }, {
                "value": "IBT Outside Transport",
                "display": "IBT Outside Transport",
            }];

            const orderTypes = [{
                "value": "DELIVERED",
                "display": "Delivery",
            }, {
                "value": "COLLECT",
                "display": "Collection",
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

            const selectType = $("#selectType").dxRadioGroup({
                items: orderTypes,
                valueExpr: 'value',
                displayExpr: 'display',
                value: orderTypes[0].value,
                layout: 'horizontal',
            }).dxRadioGroup("instance");

            const btnGetOrders = $('#btnGetOrders').dxButton({
                stylingMode: 'contained',
                text: 'SEARCH',
                type: 'normal',
                width: '100%',
                icon: 'fa fa-search',
                validationGroup: "getData",
                onClick: function(e) {
                    setStorageData();
                    var result = e.validationGroup.validate();
                    if (result.isValid) {
                        getSalesOrdersToPlan();
                    }
                }
            }).dxButton("instance");

            const btnImportPlan = $('#btnImportPlan').dxButton({
                stylingMode: 'contained',
                type: 'normal',
                icon: 'edit',
                onClick: function(e) {
                    popupEditPlan.show();
                }
            }).dxButton("instance");

            const inputUnickReference = $("#inputUnickReference").dxTextBox({
                placeholder: 'Ref',
                showSelectionControls: true,
                disabled: true,
                width: '100%',
                onValueChanged: function(e) {

                },
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
                            detail.Route === masterRow.Route
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
                                        dataField: "OrderDate",
                                        caption: "Order Date"
                                    },
                                    {
                                        dataField: "DeliveryDate",
                                        caption: "Delivery Date"
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
                                        dataField: "mnyTons",
                                        caption: "Tons",
                                        format: "#0.####",
                                        dataType: "number",
                                        calculateCellValue: function(rowData) {
                                            return rowData.mnyTonsProduct * rowData
                                                .mnyToPlan;
                                        },
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
                    }, {
                        location: 'after',
                        widget: 'dxTagBox',
                        options: {
                            dataSource: salesOrders,
                            valueExpr: 'OrderNo',
                            displayExpr: 'OrderNo',
                            placeholder: 'Sales Order',
                            showSelectionControls: true,
                            showClearButton: true,
                            width: '300px',
                            multiline: false,
                            searchEnabled: true,
                            onInitialized: function(e) {
                                selectSalesOrder = e.component;
                            },
                            onValueChanged: function(e) {
                                const selectedValues = e.value;

                                if (selectedValues.length === 0) {
                                    setAllGridData(originalData, plannedMaster)
                                    return;
                                }

                                const filteredDetails = originalData.filter(function(detail) {
                                    return selectedValues.includes(detail.OrderNo);
                                });

                                setAllGridData(filteredDetails, plannedMaster)
                            },
                        },
                    }, {
                        location: 'after',
                        widget: 'dxTagBox',
                        options: {
                            dataSource: productGroups,
                            valueExpr: 'ItemGroupDescription',
                            displayExpr: 'ItemGroupDescription',
                            placeholder: 'Proudct Group',
                            showSelectionControls: true,
                            showClearButton: true,
                            width: '300px',
                            multiline: false,
                            searchEnabled: true,
                            onInitialized: function(e) {
                                selectProductGroup = e.component;
                            },
                            onValueChanged: function(e) {
                                const selectedValues = e.value;

                                if (selectedValues.length === 0) {
                                    setAllGridData(originalData, plannedMaster)
                                    return;
                                }

                                const filteredDetails = originalData.filter(function(detail) {
                                    return selectedValues.includes(detail
                                        .ItemGroupDescription);
                                });

                                setAllGridData(filteredDetails, plannedMaster)
                            },
                        },
                    }, ]
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
                    group: 'sharedGroup',
                    allowReordering: true,
                    allowDropInsideItem: false,
                    onDragStart: function(e) {
                        if (e.itemData.bitCanEdit == "0") {
                            e.cancel = true;
                        }
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
                                Route: e.itemData.Route,
                                StoreName: e.itemData.StoreName
                            };

                            var matchedItems = [];
                            var nonMatchedItems = [];

                            $.each(plannableDetails, function(index, item) {
                                if (item.Area === criteria.Area &&
                                    item.CustomerPastelCode === criteria.CustomerPastelCode &&
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
                onEditorPreparing: function(e) {
                    if (e.row && e.row.data.bitCanEdit == "0") {
                        e.editorOptions.disabled = true;
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
                        var itemTonnage = groupItems.reduce(function(sum, item) {
                            var tons = parseFloat(item.mnyTonsProduct) * parseFloat(item
                                .mnyToPlan);
                            return sum + (isNaN(tons) ? 0 : tons);
                        }, 0);

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
                            `${storeName} (${itemCount} lines) - ${groupItems[0].Area} [ ${itemTonnage.toFixed(4)} Tons ]`
                        ).css({
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
                }, {
                    dataField: "Area",
                    caption: "Area",
                    visible: false,
                }, {
                    dataField: "Route",
                    caption: "Route",
                    visible: false,
                }, {
                    dataField: "LineId",
                    caption: "Line Id",
                    allowEditing: false,
                }, {
                    dataField: "intorderdetailId",
                    caption: "OrderDetailId",
                    visible: false,
                }, {
                    dataField: "strInstruction",
                    caption: "Instruction"
                }, {
                    dataField: "OrderDate",
                    caption: "Order Date"
                }, {
                    dataField: "DeliveryDate",
                    caption: "Delivery Date"
                }, {
                    dataField: "PastelCode",
                    caption: "Pastel Code",
                    allowEditing: false,
                    visible: false,
                }, {
                    dataField: "PastelDescription",
                    caption: "Pastel Description",
                    allowEditing: false,
                }, {
                    dataField: "mnyOutstanding",
                    caption: "Outstanding",
                    dataType: "number",
                    alignment: "center",
                    format: "#0.####",
                    allowEditing: false,
                }, {
                    dataField: "mnyAvail",
                    caption: "Available",
                    dataType: "number",
                    alignment: "center",
                    format: "#0.####",
                    allowEditing: false,
                }, {
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
                }, {
                    dataField: "mnyAlreadyPlanned",
                    caption: "Already Planned",
                    dataType: "number",
                    alignment: "center",
                    format: "#0.####",
                    allowEditing: false,
                    visible: false,
                }, {
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
                }, {
                    dataField: "OwnerID",
                    caption: "Owner",
                    visible: false,
                }, {
                    dataField: "intSequence",
                    caption: "Sequence",
                    dataType: "number",
                    alignment: "center",
                    allowEditing: true,
                }, {
                    dataField: "bitCanEdit",
                    caption: "Editable",
                    visible: false,
                }, ],
                onRowPrepared(e) {
                    if (e.data) {
                        if (e.data.strRowColor != null) {
                            e.rowElement.css("background-color", e.data.strRowColor);
                        }
                        if (e.data.bitCanEdit == "0") {
                            e.rowElement.css({
                                "background-color": "#d3d3d3",
                                "pointer-events": "none",
                                "opacity": "0.6"
                            });
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
                    }, {
                        location: 'after',
                        widget: 'dxButton',
                        options: {
                            icon: 'clearformat',
                            onClick: function(e) {
                                setAllGridData(originalData, []);
                            }
                        }
                    }]
                },
                grouping: {
                    autoExpandAll: true
                },
                groupPanel: {
                    visible: true, // Show the group panel to drag and drop group fields
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

            const selectPlan = $("#selectPlan").dxSelectBox({
                dataSource: {
                    store: TLNumbers,
                    paginate: true,
                    pageSize: 100
                },
                valueExpr: 'intAutoPickingHeader',
                displayExpr: 'strTLNum',
                placeholder: 'TL Number',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
            }).dxSelectBox("instance");

            let btnEdit;

            const popupEditPlan = $('#popupEditPlan').dxPopup({
                showTitle: true,
                title: 'Edit Picking Plan',
                hideOnOutsideClick: true,
                showCloseButton: true,
                width: 500,
                height: 600,
                height: 'auto',
                onHidden: function(e) {

                },
                toolbarItems: [{
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options: {
                        icon: "edit",
                        text: "EDIT PLAN",
                        onInitialized: function(e) {
                            btnEdit = e.component;
                        },
                        onClick: function(args) {
                            btnEdit.option('disabled', true);
                            var truckLoadNumber = selectPlan.option('value');

                            getPickingPlanToEdit(truckLoadNumber);
                            popupEditPlan.hide();
                        },
                    },
                }],
            }).dxPopup("instance");

            function groupData(data) {
                var groupedData = {};

                $.each(data, function(index, item) {
                    var key = item.CustomerPastelCode + '|' + item.StoreName + '|' + item.Area + '|' + item
                        .Route;

                    if (!groupedData[key]) {
                        groupedData[key] = {
                            GroupKey: key,
                            CustomerPastelCode: item.CustomerPastelCode,
                            StoreName: item.StoreName,
                            Area: item.Area,
                            Route: item.Route,
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

                if (Array.isArray(plannedLines)) {
                    const linesWithPlannedQty = plannedLines.filter(element =>
                        parseFloat(element.mnyAlreadyPlanned) > 0
                    );

                    if (linesWithPlannedQty.length > 0) {
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
                        orderType: selectType.option('value'),
                    },
                    success: function(data) {
                        if (data[0].Result == "Success") {
                            window.open('{!! url('/pickingplanlist') !!}/' +
                                inputUnickReference.option('value'),
                                "strUnickReference",
                                "location=1,status=1,scrollbars=1, width=1200,height=850"
                            );

                            location.reload();
                        } else {
                            var message = data[0].Result.replace(/\r\n/g, '<br>')
                            .replace(/\n/g, '<br>');
                            message += "<br><b>Would you like to proceed?</b>";

                            DevExpress.ui.dialog.confirm(message, "Alert").done(function(confirmed) {
                                if (confirmed) {
                                    window.open('{!! url('/pickingplanlist') !!}/' +
                                        inputUnickReference.option('value'),
                                        "strUnickReference",
                                        "location=1,status=1,scrollbars=1, width=1200,height=850"
                                    );
                                    location.reload();
                                } else {
                                    return;
                                }
                            });
                        }



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
                        orderType: selectType.option('value'),
                    },
                    success: function(data) {
                        originalData = data.orders;
                        setAllGridData(data.orders, plannedMaster);
                        if (inputUnickReference.option('value') == '') {
                            inputUnickReference.option('value', data.strUnickReference);
                        }

                        setItemGroupData(data.orders);
                        setItemSalesOrderData(data.orders);
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
                gridPlannable.repaint();
            }

            function setItemSalesOrderData(data) {
                $.each(data, function(index, item) {
                    var existingGroup = $.grep(salesOrders, function(group) {
                        return group.OrderNo === item.OrderNo;
                    });
                    if (existingGroup.length === 0) {
                        salesOrders.push({
                            OrderNo: item.OrderNo,
                        });
                    }
                });
                selectProductGroup.option('items', salesOrders);
                gridPlannable.repaint();
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

            function getPickingPlanToEdit(intAutoHeaderId) {
                loadingPanel.option('visible', true);

                $.ajax({
                    url: '{!! url('/getPickingPlanToEdit') !!}',
                    type: "POST",
                    data: {
                        intAutoHeaderId: intAutoHeaderId,
                    },
                    success: function(data) {
                        setAllGridData([], data.orders);
                        inputUnickReference.option('value', data.strUnickReference);
                        selectTeamLeader.option('value', data.intTeamLeaderId);
                        selectTrailer.option('value', data.intTrailerType);
                        inputLoadName.option('value', data.strPickingNickname);
                        selectLoadType.option('value', data.strLoadType);
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

            getStorageData();

            function getStorageData() {
                if (typeof(Storage) !== "undefined") {
                    var datecheck = localStorage.getItem("datecheck");
                    var dccheck = localStorage.getItem("dccheck");

                    var dateval = localStorage.getItem("dateval");
                    var dcval = localStorage.getItem("dcval");

                    var dateval = dateval.split(',');

                    if (datecheck && datecheck === "1") {
                        selectDateRange.option('value', dateval);
                        $("#checkDate").prop("checked", true);
                    }
                    if (dccheck && dccheck === "1") {
                        selectDC.option('value', dcval);
                        $("#checkDC").prop("checked", true);
                    }
                } else {
                    DevExpress.ui.notify(
                        "Sorry, your browser does not support local storage and you wont be able to store date, shift, department, and machine",
                        "error", 5000
                    );
                }
            };

            function setStorageData() {
                var datecheck = $("#checkDate").prop("checked") ? "1" : "0";
                var dccheck = $("#checkDC").prop("checked") ? "1" : "0";

                var dateval = selectDateRange.option('value');
                var dcval = selectDC.option('value');

                localStorage.setItem("datecheck", datecheck);
                localStorage.setItem("dccheck", dccheck);

                localStorage.setItem("dateval", dateval);
                localStorage.setItem("dcval", dcval);
            };
        });
    </script>

@endsection
