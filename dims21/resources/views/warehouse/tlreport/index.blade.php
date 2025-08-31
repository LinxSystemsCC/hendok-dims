
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

        <div class="grid" id="gridTLs"></div>

</div>



@endsection

@section('scripts')
    <!-- Flexdatalist -->
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script> 
    <script>
        
		let gridTLs;
        $(document).ready(function () {

        let dateFrom = '{{ $dateFrom }}';
        let dateTo = '{{ $dateTo }}';
        let selectDate='';
            gridTLs = $("#gridTLs").dxDataGrid({
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
                        var worksheet = workbook.addWorksheet('tls');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet: worksheet,
                            autoFilterEnabled: true
                        }).then(function() {
                            // https://github.com/exceljs/exceljs#writing-xlsx
                            workbook.xlsx.writeBuffer().then(function(buffer) {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'tls.xlsx');
                            });
                        });
                        e.cancel = true;
            },
                paging: {
                    pageSize: 20,
                },
                columns: [{
                        dataField: "strTLNumber",
                        caption: "TL Number",
                    allowEditing: false,
                    width: 80,
                    cellTemplate: function(container, options) {
                        $("<div>")
                            .addClass("dx-link")
                            .text(options.value)
                            .on("click", function() {
                                fetchTLItemsPerIBT(options.data.strTLNumber)
                                    .then(data => {
                                        let popupContainer = $("<div>").appendTo("body");
                                        let grid;

                                        popupContainer.dxPopup({
                                            title:options.data.strTLNumber,
                                            width: 700,
                                            height: 500,
                                            visible: true,
                                            showCloseButton: true,
                                            contentTemplate: function(popupContent) {
                                                $("<div>").appendTo(popupContent).dxDataGrid({
                                                dataSource: data,
                                                showBorders: true,
                                                columnAutoWidth: true,
                                                paging: { pageSize: 50 },
                                            });

                                            $("<hr>").appendTo(popupContent);
                                                grid = $("<div>").appendTo(popupContent).dxDataGrid({
                                                    dataSource: [],
                                                    showBorders: true,
                                                    columnAutoWidth: true,
                                                    paging: { pageSize: 50 },
                                                    columns: [
                                                        {
                                                            dataField: "strIBTNumber",
                                                            caption: "IBT Number",
                                                        },
                                                        { 
                                                            dataField: "strItemCode",
                                                            caption: "Item Code",
                                                        },
                                                        { 
                                                            dataField: "strItemDescription",
                                                            caption: "Item Description",
                                                        },
                                                        { 
                                                            dataField: "decQtyRequired",
                                                            caption: "Qty Req.",
                                                        },
                                                        { 
                                                            dataField: "decQtyIssued",
                                                            caption: "Qty Iss.",
                                                        },
                                                        { 
                                                            dataField: "decQtyReceived",
                                                            caption: "Qty Rec.",
                                                        },
                                                        { 
                                                            dataField: "decQtyToReceive",
                                                            caption: "Qty to Rec.",
                                                        },
                                                    ]
                                                }).dxDataGrid("instance");

                                            }
                                        });
                                    });
                            })
                            .appendTo(container);
                    }
                },{
                    dataField: "strIBTNumbers",
                    caption: "IBT Numbers",
                    allowEditing: false
                },{
                    dataField: "dtmDatePrinted",
                    caption: "Date Printed",
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
                            getTLsDateRange(selectDate.option('value')[0],selectDate.option('value')[1]);
                        },
                        elementAttr: {
                            class: "menu-button"
                        },
                    },
                });
            }
            }).dxDataGrid("instance");
        });
        
        function fetchTLItemsPerIBT(strTLNumber) {
            return $.ajax({
                url: '{!! url("/getTLItemsPerIBT") !!}',
                method: 'POST',
                data: {
                    strTLNumber: strTLNumber,
                },
                xhrFields: {
                    withCredentials: true
                }
            });
        }

        function getTLsDateRange(dateFromParam, dateToParam) {
            
            // Ajax call for Get IBT Records
            $.ajax({
                url: '{!! url('/getTLsDateRange') !!}',
                type: "GET",
                data: {
                    dateFrom:dateFromParam,
                    dateTo: dateToParam,
                },
                success: function (data) {
                    gridTLs.option('dataSource', data);
                    gridTLs.refresh();
                }
            });
        }

    </script>
@endsection