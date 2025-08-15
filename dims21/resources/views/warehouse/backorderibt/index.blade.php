
@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'IBT')

{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')
    <!-- Flexdatalist -->
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet" type='text/css'>

    <style>
        .grid {
            height: 100%;
            max-height: 100%;
        }
    </style>

    <div class="col-md-12 h-100">

        <div class="grid" id="gridIBT"></div>

</div>



@endsection

@section('scripts')
    <!-- Flexdatalist -->
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script> 
    <script>
        
		let gridIBT;
        $(document).ready(function () {

        let dateFrom = '{{ $dateFrom }}';
        let dateTo = '{{ $dateTo }}';
        let selectDate='';
            gridIBT = $("#gridIBT").dxDataGrid({
                dataSource: [], // as JSON
                hoverStateEnabled: true,
                showBorders: true,
                allowColumnResizing: true,
                columnAutoWidth: true,
                wordWrapEnabled: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
            filterRow: {
                visible: true
            },
            filterPanel: {
                visible: true
            },  
            export: {
                        enabled: true,
                        allowExportSelectedData: true
                    },
                    onExporting: function(e) {
                        var workbook = new ExcelJS.Workbook();
                        var worksheet = workbook.addWorksheet('outstanding');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet: worksheet,
                            autoFilterEnabled: true
                        }).then(function() {
                            // https://github.com/exceljs/exceljs#writing-xlsx
                            workbook.xlsx.writeBuffer().then(function(buffer) {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'outstanding.xlsx');
                            });
                        });
                        e.cancel = true;
            },
                paging: {
                    pageSize: 20,
                },
                columns: [{
                    dataField: "DateCreated",
                    caption: "Date Created",
                    allowEditing: false
                },{
                    dataField: "ibtheader",
                    caption: "IBT Number",
                    allowEditing: false
                },{
                    dataField: "strReference",
                    caption: "Reference",
                    allowEditing: false
                },{
                    dataField: "ItemCode",
                    caption: "Item Code",
                    allowEditing: false
                },{
                    dataField: "ItemName",
                    caption: "Item Name",
                    allowEditing: false
                },{
                    dataField: "mnyQty",
                    caption: "Requested Quantity",
                    allowEditing: false
                },{
                    dataField: "outstanding",
                    caption: "Outstanding Quantity",
                    allowEditing: false
                }
                ],
                onToolbarPreparing: function(e) {
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxDateRangeBox",
                    options: {
                        width: 250,
                        id: "dateRange",
                        displayFormat: 'yyyy-MM-dd',
                        showClearButton: true,
                        value: [dateFrom, dateTo],
                        onInitialized: function(e) {
                            selectDate = e.component;
                        },
                        onValueChanged: function(e) {

                        }
                    }
                });
                
                e.toolbarOptions.items.push({
                    location: 'before',
                    widget: "dxButton",
                    options: {
                        icon: "find",
                        text: "GET DATA",
                        type: 'default',
                        stylingMode: 'contained',
                        onClick: function(args) {
                            getBackorderIBTRecords(selectDate.option('value')[0],selectDate.option('value')[1]);
                        },
                        elementAttr: {
                            class: "menu-button"
                        },
                    },
                });
            }
            }).dxDataGrid("instance");
        });
        function getBackorderIBTRecords(dateFromParam, dateToParam) {
            
            // Ajax call for Get IBT Records
            $.ajax({
                url: '{!! url('/getBackOrderIBT') !!}',
                type: "GET",
                data: {
                    dateFrom:dateFromParam,
                    dateTo: dateToParam,
                },
                success: function (data) {
                    gridIBT.option('dataSource', data);
                    gridIBT.refresh();
                }
            });
        }

    </script>
@endsection