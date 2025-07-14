@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Pro Weigh')


@php
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
        $includeMenu = true;
    }
@endphp


@section('page')

    <div id="gridProWeigh"></div>
    <div id="popupProWeighEdit"></div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var data = ({!! json_encode($data) !!});
            var horses = ({!! json_encode($horses) !!});
            var trailers = ({!! json_encode($trailers) !!});

            let dateRange;

            let dateFrom = "{{ $dateFrom }}";
            let dateTo = "{{ $dateTo }}";

            const gridProWeigh = $("#gridProWeigh").dxDataGrid({
                dataSource: data,
                height: '97vh',
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
                columnFixing: {
                    enabled: true,
                },
                paging: {
                    pageSize: 50,
                },
                pager: {
                    visible: true,
                    allowedPageSizes: [5, 10, 20, 50, 'all'],
                    showPageSizeSelector: true,
                    showInfo: true,
                    showNavigationButtons: true,
                },
                columnAutoWidth: true,
                allowColumnResizing: true,
                columnResizingMode: "widget",
                onRowDblClick: function(e) {
                    const rowData = e.data;
                    showPopup(rowData);
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('PRO WEIGHT');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxDateRangeBox",
                        options: {
                            displayFormat: 'yyyy-MM-dd',
                            showClearButton: true,
                            width: '100%',
                            value: [dateFrom, dateTo],
                            onInitialized: function(e) {
                                DateRange = e.component;
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-user",
                            text: "GET DATA",
                            onClick: function(args) {
                                getProWeighData();
                            },
                        },
                    });
                },
            }).dxDataGrid('instance');

            function showPopup(rowData) {
                $("#popupProWeighEdit").dxPopup({
                    title: "Edit Weighbridge Entry",
                    width: 400,
                    height: 'auto',
                    showCloseButton: true,
                    closeOnOutsideClick: true,
                    contentTemplate: function(contentElement) {
                        contentElement.empty();

                        const $selectBox = $("<div>").dxSelectBox({
                            dataSource: horses,
                            value: rowData.REG_NUMBER,
                            valueExpr: 'TruckId',
                            displayExpr: 'TruckId',
                            label: "Select Horse",
                            labelMode: "floating",
                            searchEnabled: true,
                            onValueChanged: function(e) {
                                rowData.REG_NUMBER = e.value;
                            }
                        });

                        const $weightBox = $("<div>").dxNumberBox({
                            value: rowData.FIRST_WEIGHT,
                            label: "Weight",
                            labelMode: "floating",
                            showSpinButtons: true,
                            min: 0,
                            onValueChanged: function(e) {
                                rowData.FIRST_WEIGHT = e.value;
                            }
                        });

                        const $updateButton = $("<div>").dxButton({
                            text: "Update",
                            type: "success",
                            width: "100%",
                            onClick: function() {
                                // Example: send AJAX update to server
                                $.ajax({
                                    url: '{!! url('/updateProWeighData') !!}',
                                    method: "POST",
                                    data: {
                                        TICKET_NUMBER: rowData.TICKET_NUMBER,
                                        REG_NUMBER: rowData.REG_NUMBER,
                                        FIRST_WEIGHT: rowData.FIRST_WEIGHT,
                                    },
                                    success: function(resp) {
                                        DevExpress.ui.notify("Updated!", "success", 1000);
                                        $("#popupProWeighEdit").dxPopup("instance").hide();
                                        getProWeighData();
                                    }
                                });
                            }
                        });

                        contentElement.append($selectBox, $("<br>"), $weightBox, $("<br>"),
                            $updateButton);
                    }
                }).dxPopup("instance").show();
            }

            function getProWeighData() {
                $.ajax({
                    url: '{!! url('/getProWeighData') !!}',
                    type: "GET",
                    data: {
                        dateFrom: formatDate(DateRange.option('value')[0]),
                        dateTo: formatDate(DateRange.option('value')[1]),
                    },
                    success: function(data) {
                        gridProWeigh.option('dataSource', data);
                        gridProWeigh.refresh();
                    },
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
