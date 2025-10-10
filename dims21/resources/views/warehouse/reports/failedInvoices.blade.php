@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Failed Invoices')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

<div id="gridFailedInvoices"></div>

@endsection

@section('scripts')

    <style>
        #gridFailedInvoices{
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <script>
        $(document).ready(function() {

            var failures = [];

            const gridFailedInvoices = $("#gridFailedInvoices").dxDataGrid({
                dataSource: failures,
                showBorders: true,
                showRowLines: true,
                showColumnLines: true,
                rowAlternationEnabled: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                paging: {
                    enabled: false
                },
                selection: {
                    mode: "single",
                },
                columnFixing: {
                    enabled: true,
                },
                columnAutoWidth:true,
                allowColumnResizing: true,
                columnResizingMode: "nextColumn",
                columns: [
                    {
                        dataField: "intXmlOrder",
                        caption: "XML Order",
                    },
                    {
                        dataField: "strUniqueID",
                        caption: "Unique ID",
                    },
                    {
                        dataField: "OrderNo",
                        caption: "Order No",
                    },
                    {
                        dataField: "intFlag",
                        caption: "Flag",
                    },
                    {
                        dataField: "strErrorMessage",
                        caption: "Error",
                    },
                    {
                        dataField: "dteCreated",
                        caption: "Date Created",
                    },
                    {
                        type: "buttons",
                        buttons: [
                            {
                                hint: "Delete",
                                icon: "trash",
                                visible: function (e) {
                                    return e.row.data.intFlag == 2;
                                },
                                onClick: function (e) {
                                    if (confirm("Are you sure you want to delete this failed Invoice?")) {
                                        // Delete the row programmatically
                                        gridInstance.deleteRow(e.row.rowIndex);
                                    }
                                }
                            }
                        ]
                    }
                ],
                onToolbarPreparing: function (e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('Failed Invoices');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxDateRangeBox",
                            options: {
                                width: 300,
                                class: "myDateRangeBox",
                                displayFormat: 'yyyy-MM-dd',
                                elementAttr: {
                                    id: "dateRange"
                                },
                            }
                        }
                    );
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa-solid fa-search",
                            text: "SEARCH",
                            onClick: function (args) {
                                getFailedInvoices();
                            },
                        },
                    });
                },
                
                onRowRemoved: function (e) {
                $.ajax({
                    url: '{!! url('deleteFailedInvoice') !!}', 
                    type: 'POST',
                    data: {
                        invoice: e.data.intXmlOrder
                    },
                    success: function (data) {
                    },
                    error: function () {
                        alert("Error deleting record.");
                    }
                });
            },
            }).dxDataGrid('instance');

            function getFailedInvoices(){
                // Get the dxDateRangeBox widget instance using the CSS class
                var dateRangeBox = $("#dateRange").dxDateRangeBox("instance");
                var selectedValues = dateRangeBox.option("value");

                var dateFrom = selectedValues[0].toLocaleDateString("en-ZA", { year: 'numeric', month: '2-digit', day: '2-digit' });
                var dateTo = selectedValues[1].toLocaleDateString("en-ZA", { year: 'numeric', month: '2-digit', day: '2-digit' });

                dateFrom = dateFrom.replace(/\//g, '-');
                dateTo = dateTo.replace(/\//g, '-');

                $.ajax({
                    url: '{!!url("/getFailedInvoices")!!}',
                    type: "GET",
                    data: {
                        dateFrom: dateFrom,
                        dateTo: dateTo
                    },
                    success: function (data) {
                        gridFailedInvoices.option('dataSource', data);
                        gridFailedInvoices.refresh();

                        gridData = gridFailedInvoices.option("dataSource");
                    }
                });
            }
        });
    </script>

@endsection