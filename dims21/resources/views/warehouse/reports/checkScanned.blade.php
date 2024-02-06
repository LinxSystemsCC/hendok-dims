@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Check Scanned Lines')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

<div id="gridCheckScanned"></div>

@endsection

@section('scripts')

    <style>
        #gridCheckScanned{
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <script>
        $(document).ready(function() {

            var failures = [];

            const gridCheckScanned = $("#gridCheckScanned").dxDataGrid({
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
                        dataField: "Company",
                        caption: "Company",
                        groupIndex: 1
                    },
                    {
                        dataField: "Code",
                        caption: "Item Code",
                    },
                    {
                        dataField: "Description_1",
                        caption: "Item Description",
                    },
                    {
                        dataField: "PickedTime",
                        caption: "Picked Time",
                    },
                    {
                        dataField: "strAppName",
                        caption: "App",
                    },
                    {
                        dataField: "Loader",
                        caption: "Loader",
                    },
                    {
                        dataField: "Picker",
                        caption: "Picker",
                    },
                    {
                        dataField: "OrderNum",
                        caption: "Order No.",
                    },
                    {
                        dataField: "InvNumber",
                        caption: "Invoice No.",
                    },
                ],
                onToolbarPreparing: function (e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('Check Scanned');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxTextBox",
                            options: {
                                placeholder: 'Enter TL number',
                                width: 300,
                                elementAttr: {
                                    id: "txtTruckload"
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
                                getCheckScanned();
                            },
                        },
                    });
                }
            }).dxDataGrid('instance');

            function getCheckScanned(){
                var txtTruckload = $("#txtTruckload").dxTextBox("instance");
                var tlno = txtTruckload.option("value");
                $.ajax({
                    url: '{!!url("/getCheckScanned")!!}',
                    type: "GET",
                    data: {
                        tlno: tlno,
                    },
                    success: function (data) {
                        gridCheckScanned.option('dataSource', data);
                        gridCheckScanned.refresh();

                        gridData = gridCheckScanned.option("dataSource");
                    }
                });
            }
        });
    </script>

@endsection