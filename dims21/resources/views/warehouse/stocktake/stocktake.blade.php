@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Take')

{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <div id="gridStockTake" class="col-lg-12"></div>
    <div id="popupCreate">
        <div class="dx-field">
            <div class="dx-field-label">Reference</div>
            <div class="dx-field-value">
                <div id="inputReference"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Location</div>
            <div class="dx-field-value">
                <div id="selectLocations"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Bins</div>
            <div class="dx-field-value">
                <div id="selectBins"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Product Groups</div>
            <div class="dx-field-value">
                <div id="selectProductGroups"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Select Stock Take Teams</div>
            <div class="dx-field-value">
                <div id="selectTeams"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <style>
        #gridStockTake {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <script>
        $(document).ready(function() {
            let locations = {!! json_encode($locations) !!};
            let bins = []
            let productGroups = {!! json_encode($productGroups) !!};
            let locationIds;
            let stockTakeDetailsData = [];

            var today = new Date();
            var formattedToday = formatDate(today);

            const inputReference = $("#inputReference").dxAutocomplete({
                dataSource: [],
                valueExpr: 'InvoiceNo',
                showClearButton: true,
                searchEnabled: true,
                disabled: true,
                onValueChanged: function(e) {},
            }).dxAutocomplete("instance");

            const selectLocations = $("#selectLocations").dxSelectBox({
                dataSource: locations,
                valueExpr: 'intLocationNameId',
                displayExpr: 'strLocationName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                onValueChanged: function(e) {
                    locationIds = e.value;
                    getBinsForLocations();
                },
            }).dxSelectBox("instance");

            const selectBins = $("#selectBins").dxTagBox({
                dataSource: bins,
                valueExpr: 'intBinId',
                displayExpr: 'strBin',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                multiline: false,
                onValueChanged: function(e) {

                },
            }).dxTagBox("instance");

            const selectProductGroups = $("#selectProductGroups").dxTagBox({
                dataSource: productGroups,
                valueExpr: 'ItemGroup',
                displayExpr: 'ItemGroupDescription',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                multiline: false,
                onValueChanged: function(e) {

                },
            }).dxTagBox("instance");

            const selectTeams = $("#selectTeams").dxTagBox({
                dataSource: {
                    store: [{
                        'strTeamName': 'RedTeam',
                        'strDisplayName': 'Red Team',
                    }, {
                        'strTeamName': 'BlueTeam',
                        'strDisplayName': 'Blue Team',
                    }],
                    paginate: true,
                    pageSize: 100
                },
                valueExpr: 'strTeamName',
                displayExpr: 'strDisplayName',
                applyValueMode: 'useButtons',
                showSelectionControls: true,
                showClearButton: true,
                searchEnabled: true,
                multiline: false,
                onValueChanged: function(e) {

                },
            }).dxTagBox("instance");

            let btnCreate;

            // Note from Kyle - If you add to the popup, make sure you initialize the components before the popup
            const popupCreate = $("#popupCreate").dxPopup({
                showTitle: true,
                title: 'Create Stock Take',
                hideOnOutsideClick: true,
                showCloseButton: true,
                width: 500,
                height: 600,
                height: 'auto',
                onHidden: function(e) {
                    inputReference.option('value', null);
                    selectLocations.option('value', null);
                    selectBins.option('value', null);
                    selectProductGroups.option('value', null);
                    selectTeams.option('value', null);
                },
                toolbarItems: [{
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options: {
                        icon: "fa-solid fa-add",
                        text: "CREATE STOCK TAKE",
                        onInitialized: function(e) {
                            btnCreate = e.component;
                        },
                        onClick: function(args) {
                            btnCreate.option('disabled', true);
                            
                            var reference = inputReference.option('value');
                            var locations = selectLocations.option('value');
                            var bins = selectBins.option('value');
                            var productGroups = selectProductGroups.option('value');
                            var teams = selectTeams.option('value');

                            createStockTake(reference, locations, bins.join(','), productGroups
                                .join(','), teams.join(','))
                        },
                    },
                }],
            }).dxPopup("instance");

            const gridStockTake = $("#gridStockTake").dxDataGrid({
                dataSource: [], // Your data source here
                showBorders: true,
                keyExpr: 'intAutoId',
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
                editing: {
                    mode: 'cell',
                    allowUpdating: true,
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
                    dataField: "intAutoId",
                    caption: "ID",
                    allowEditing: false,
                }, {
                    dataField: "strStockTakeName",
                    caption: "Stock Take Name",
                    allowEditing: false,
                }, {
                    dataField: "stockTakeLocation",
                    caption: "Stock Take Location",
                    allowEditing: false,
                }, {
                    dataField: "dtmCreated",
                    caption: "Date Created",
                    allowEditing: false,
                }, {
                    dataField: "blnIsOpened",
                    caption: "Is Active",
                    lookup: {
                        dataSource: [{
                            "value": "1",
                            "display": "Active"
                        }, {
                            "value": "0",
                            "display": "In-Active"
                        }],
                        valueExpr: 'value',
                        displayExpr: 'display',
                    },
                }],
                onRowUpdated: function(e) {
                    var stockTakeId = e.data.intAutoId;
                    var statusId = e.data.blnIsOpened;
                    updateStockTakeStatus(stockTakeId, statusId); // Your function to update status
                },
                onRowDblClick: function(e) {
                    var id = e.data.intAutoId;
                    window.open('{!! url('/stockCounts') !!}/' + id, "_blank",
                        "location=1,status=1,scrollbars=1, width=1200,height=850");
                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3 class="ps-3">').text('Stock Takes');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxDateRangeBox",
                        options: {
                            width: 300,
                            class: "myDateRangeBox",
                            displayFormat: 'yyyy-MM-dd',
                            value: [formattedToday,
                                formattedToday
                            ], // Set the initial date range
                            elementAttr: {
                                id: "dateRange"
                            },
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-search",
                            text: "SEARCH",
                            onClick: function(args) {
                                getStockTakes(); // Your function to get stock takes
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-add",
                            text: "ADD",
                            onClick: function(args) {
                                getNextStockTakeId();
                                popupCreate.show(); 
                                btnCreate.option('disabled', false);
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            getStockTakes();

            function getStockTakes() {
                // Get the dxDateRangeBox widget instance using the CSS class
                var dateRangeBox = $("#dateRange").dxDateRangeBox("instance");
                var selectedValues = dateRangeBox.option("value");

                var dateFrom = selectedValues[0];
                var dateTo = selectedValues[1];

                $.ajax({
                    url: '{!! url('/getStockTakes') !!}',
                    type: "GET",
                    data: {
                        datefrom: dateFrom,
                        dateto: dateTo
                    },
                    success: function(gridData) {
                        gridStockTake.option('dataSource', gridData);
                        gridStockTake.refresh();

                        const distinctIntAutoIds = [...new Set(gridData.map(item => item.intAutoId))];
                        const IDs = distinctIntAutoIds.join(',');
                    }
                });
            }

            // formats date to yyyy-MM-dd
            function formatDate(date) {
                returnFormat = date.toLocaleDateString("en-ZA", {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });

                return returnFormat.replace(/\//g, '-');
            }

            function getBinsForLocations() {
                $.ajax({
                    url: '{!! url('/getBinsForLocations') !!}',
                    type: "GET",
                    data: {
                        locationIds: locationIds,
                    },
                    success: function(binsData) {
                        selectBins.option('dataSource', binsData);
                        selectBins.repaint();
                    }
                });
            }

            function createStockTake(reference, locations, bins, productGroups, teams) {
                $.ajax({
                    url: '{!! url('/createStockTake') !!}',
                    type: "POST",
                    data: {
                        reference: reference,
                        locations: locations,
                        bins: bins,
                        productGroups: productGroups,
                        teams: teams,
                    },
                    success: function(data) {
                        getStockTakes();
                        popupCreate.hide();
                        DevExpress.ui.notify({
                            message: 'Stock Take Creation Successful',
                            type: 'success', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });
                    },
                });
            }

            function updateStockTakeStatus(stockTakeId, statusId) {
                $.ajax({
                    url: '{!! url('/updateStockTakeStatus') !!}',
                    type: "POST",
                    data: {
                        stockTakeId: stockTakeId,
                        statusId: statusId,
                    },
                    success: function(data) {
                        getStockTakes();
                    }
                });
            }

            function getNextStockTakeId() {
                $.ajax({
                    url: '{!! url('/getNextStockTakeId') !!}',
                    type: "GET",
                    success: function(result) {
                        inputReference.option('value', result);
                    }
                });
            }
        });
    </script>

@endsection
