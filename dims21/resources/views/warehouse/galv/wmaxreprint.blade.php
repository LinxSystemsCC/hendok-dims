@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Galv Reprint')

{{-- Set to show navbar --}}
@php
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
        $Edit = $v->getThingsUserPermissions(Auth::user()->UserID, 'Reprint Edit');

        $canEdit = $Edit == 1 ? true : false;
    }

    $includeMenu = true;

@endphp

@section('page')

    <style>
        #gridReprint {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }

        .customPadding {
            padding: 0px 1rem !important;
        }
    </style>

    <div id="gridReprint" style="width: 100% !important;"></div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {

            let TicketNo, DateRange;

            const gridReprint = $("#gridReprint").dxDataGrid({
                dataSource: [], //as json
                hoverStateEnabled: true,
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
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging: {
                    pageSize: 20,
                },
                pager: {
                    visible: true,
                    allowedPageSizes: [5, 10, 20, 50, 'all'],
                    showPageSizeSelector: true,
                    showInfo: true,
                    showNavigationButtons: true,
                },
                editing: {
                    mode: 'row',
                    allowUpdating: '{{ $canEdit }}',
                },
                selection: {
                    mode: "single",
                    rowCssClass: 'custom-selected-row'
                    // showCheckBoxesMode: "onClick"
                },
                columns: [{
                        cellTemplate: function(container, options) {
                            container.addClass("customPadding");
                            $("<div>")
                                .dxButton({
                                    icon: "fa fa-print",
                                    text: "",
                                    onClick: function(e) {
                                        // options.data.TicketNo
                                        window.open('{!! url('/printGalvLabel') !!}/' + options
                                            .data.TicketNo, "_blank",
                                            "location=1,status=1,scrollbars=1, width=1200,height=850"
                                            );
                                    }
                                })
                                .appendTo(container);
                        }
                    },
                    {
                        dataField: "TicketNo",
                        caption: "Ticket",
                        allowEditing: false,
                    }, {
                        dataField: "SequenceNo",
                        caption: "Seq",
                        alignment: "center",
                        allowEditing: false,
                    }, {
                        dataField: "JobNo",
                        caption: "Job No",
                        allowEditing: false,
                        groupIndex: 0,
                    }, {
                        dataField: "Customer",
                        caption: "Customer",
                        allowEditing: false,
                    },
                    {
                        dataField: "Department",
                        caption: "Department",
                        allowEditing: false,
                    },
                    {
                        dataField: "Machine",
                        caption: "Machine",
                        allowEditing: false,
                    },
                    {
                        dataField: "ProductName",
                        caption: "Product",
                        allowEditing: false,
                    },
                    {
                        dataField: "ActualWireSize",
                        caption: "Tested Wire Size",
                        dataType: "number",
                        alignment: "center",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                    },
                    {
                        dataField: "TreatedMPA",
                        caption: "Tested MPA",
                        alignment: "center",
                    },
                    {
                        dataField: "TestedZinc",
                        caption: "Tested Zinc",
                        dataType: "number",
                        alignment: "center",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                    },
                    {
                        dataField: "Weight",
                        caption: "Mass",
                        dataType: "number",
                        alignment: "center",
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        },
                    },
                    {
                        dataField: "Reference",
                        caption: "Ref.",
                        allowEditing: false,
                    },
                    {
                        dataField: "strStatus",
                        caption: "Status",
                        allowEditing: false,
                    },
                    {
                        dataField: "strTable",
                        caption: "Table",
                        allowEditing: false,
                    },
                ],
                onRowDblClick: function(e) {
                    window.open('{!! url('/printGalvLabel') !!}/' + e.data.TicketNo, "_blank",
                        "location=1, status=1, scrollbars=1, width=1200, height=850");
                },
                onRowUpdated: function(e) {
                    $.ajax({
                        url: '{!! url('/galvReprintEdit') !!}',
                        type: "POST",
                        data: {
                            TicketNo: e.data.TicketNo,
                            ActualWireSize: e.data.ActualWireSize,
                            TreatedMPA: e.data.TreatedMPA,
                            TestedZinc: e.data.TestedZinc,
                            Weight: e.data.Weight,
                            Table: e.data.strTable,
                        },
                        success: function(data) {
                            alert(data[0].Result);
                            getReprints();
                        }
                    });
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('Reprint');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxTextBox",
                        options: {
                            placeholder: 'Ticket No.',
                            showSelectionControls: true,
                            width: '100%',
                            onInitialized: function(e) {
                                TicketNo = e.component;
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxDateRangeBox",
                        options: {
                            displayFormat: 'yyyy-MM-dd',
                            showClearButton: true,
                            width: '100%',
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
                            text: "GET REPRINTS",
                            onClick: function(args) {
                                getReprints();
                            },
                        },
                    });
                },
            }).dxDataGrid('instance');

            function getReprints() {
                $.ajax({
                    url: '{!! url('/getGalvReprints') !!}',
                    type: "GET",
                    data:{
                        ticketNo: TicketNo.option('value'),
                        dateFrom: formatDate(DateRange.option('value')[0]),
                        dateTo: formatDate(DateRange.option('value')[1]),
                    },
                    success: function(data) {
                        gridReprint.option('dataSource', data);
                        gridReprint.refresh();

                        gridData = gridReprint.option("dataSource");
                    },

                });
            };

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
