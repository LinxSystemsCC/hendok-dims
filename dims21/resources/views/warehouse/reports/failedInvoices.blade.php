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

            var failures = {!! json_encode($failures) !!};

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
                        dataField: "intXMLOrder",
                        caption: "XML Order",
                    },
                    {
                        dataField: "strUniqueID",
                        caption: "Unique ID",
                    },
                    {
                        dataField: "intFlag",
                        caption: "Flag",
                    },
                    {
                        dataField: "intOrderID",
                        caption: "Order Id",
                    },
                    {
                        dataField: "dteCreated",
                        caption: "Date Created",
                    },
                    {
                        dataField: "SoNumber",
                        caption: "SO Number",
                    },
                    {
                        dataField: "Compnay",
                        caption: "Company",
                    },
                ],
                onRowPrepared(e) {
                    //console.debug("RowPrepared");
                },
                onRowClick: function (e) {
                    //console.debug("RowClick");
                },
                onSelectionChanged: function(e) {
                    //console.debug("SelectionChanged");
                },
                onRowDblClick: function (e) {
                    //console.debug("RowDblClick");
                },
                onInitNewRow: function(e) {
                    //console.debug("InitNewRow");
                },
                onRowInserting: function(e) {
                    //console.debug("RowInserting");
                }, 
                onRowInserted: function(e) {
                    //console.debug("RowInserted");
                },
                onRowUpdating: function(e) {
                    //console.debug("RowUpdating");
                },
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
                }
            }).dxDataGrid('instance');
        });
    </script>

@endsection