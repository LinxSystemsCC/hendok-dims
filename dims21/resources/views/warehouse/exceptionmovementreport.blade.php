<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />



    <!-- Select2 JS -->


    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

    <style>
        .vertical-menu {
            width: 200px;
        }

        .vertical-menu a {
            background-color: #eee;
            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .vertical-menu a:hover {
            background-color: #ccc;
        }

        .vertical-menu a.active {
            background-color: #04AA6D;
            color: white;
        }

        .report {
            background-color: #ccc !important;
        }
    </style>


</head>
<body>


<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2"  style="background: white;border-right: 2px solid black;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>

    <div class="col-lg-10" >
        <div class="contentWrapper">
            <h3>Exception Movement Report</h3>

            <div>
                <h5>Pallet Movement Report</h5>
                Date From <input type="date" id="datefrom"> - Date To <input type="date" id="dateto"><button id="getmovementdata">GET</button> 
                <div id="gridPallets" style="width: 100% !important;"></div>
            </div>
            <!--hr>
            <div>
                <h5>Item Movement Report</h5> 
                <div id="gridItems" style="width: 100% !important;"></div>
            <div-->
            <hr>
            <div>
                <h5>Pallet Revesal Report</h5>
                Date From <input type="date" id="datefrom"> - Date To <input type="date" id="dateto"><button id="getreversaldata">GET</button> 
                <div id="gridReversal" style="width: 100% !important;"></div>
            <div>

        </div>
    </div>
</div>


<style>

    .dx-datagrid-table{
        font-size:15px;
    }
    .wrapper {

        margin: auto;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, .1);
    }

    .buttonWrapper {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
    }

    button {
        letter-spacing: 3px;
        border: none;
        padding: 10px;
        background-color: #bccbe9;
        color: #232c3d;
        font-size: 18px;
        cursor: pointer;
        transition: 0.5s;
    }

    button:hover {
        background-color: #d5e3ff;
    }

    button.active {
        background-color: white;
    }

    .active {
        background-color: white;
    }



    .content {
        display: none;
        padding: 10px 20px;
    }

    .content.active {
        display: block;
    }
</style>

<script>

    const tabs = document.querySelector(".wrapper");
    const tabButton = document.querySelectorAll(".tab-button");
    const contents = document.querySelectorAll(".content");

    /* tabs.onclick = e => {
        const id = e.target.dataset.id;
        if (id) {
            tabButton.forEach(btn => {
                btn.classList.remove("active");
            });
            e.target.classList.add("active");

            contents.forEach(content => {
                content.classList.remove("active");
            });
            const element = document.getElementById(id);
            element.classList.add("active");
        }
    }*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });


    $(document).ready(function() {
        $("#palletmovementreport").select2();

        $("#getmovementdata").click(function(){
            $.ajax({
                url: '{!!url("/getpalletmovementreport")!!}',
                type: "GET",
                data: {

                },
                success: function (data) {
                    $("#gridPallets").dxDataGrid({
                        dataSource:data, //as json
                        showBorders: true,
                        filterRow: { visible: true },
                        filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        allowColumnResizing: true,
                        paging:{
                            pageSize: 20,
                        },
                        export: {
                            enabled: true
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('palletmovementreport');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'palletmovementreport.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [
                            {
                                dataField: "moveOut",
                                caption: "Move Out",
                                width: 100,
                            },
                            {
                                dataField: "strLocation",
                                caption: "Location",
                                width: 150,
                            },
                            {
                                dataField: "UserName",
                                caption: "User Name",
                                width: 200,
                            },
                            {
                                dataField: "intJobIdOut",
                                caption: "Job Id Out",
                                width: 50,
                            },
                            {
                                dataField: "tokenOut",
                                caption: "Token Out",
                                width: 250,
                            },
                            {
                                dataField: "palletOut",
                                caption: "Pallet Out",
                                width: 150,
                            },
                            {
                                dataField: "itemCodeOut",
                                caption: "Item Code",
                                width: 150,
                            },

                            {
                                dataField: "ItemName",
                                caption: "Item Name",
                                width: 350,
                            },

                            {
                                dataField: "moveIn",
                                caption: "Move In",
                                width: 150,
                            },
                            {
                                dataField: "intJobIdIn",
                                caption: "Job ID In",
                                width: 150,
                            },
                            {
                                dataField: "tokenIn",
                                caption: "Token In",
                                width: 150,
                            },
                            {
                                dataField: "palletIn",
                                caption: "Pallet In",
                                width: 150,
                            },
                            {
                                dataField: "itemCodeIn",
                                caption: "Item Code In",
                                width: 150,
                            }
                        ],
                        onRowDblClick:function(e){
                            
                        }

                    });

                    //Location Typs

                }

            });
        });

        $("#itemmovementreport").select2();

        $.ajax({
            url: '{!!url("/getitemmovementreport")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                $("#gridItems").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    paging:{
                        pageSize: 20,
                    },
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('itemmovementreport');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'itemmovementreport.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [

                    ],
                    onRowDblClick:function(e){
                        
                    }

                });

                //Location Typs

            }

        });

        $("#palletreversalreport").select2();

        $("#getreversaldata").click(function(){
            $.ajax({
                url: '{!!url("/getpalletreversalreport")!!}',
                type: "GET",
                data: {
                    datefrom: $('#datefrom').val(),
                    dateto: $('#dateto').val()
                },
                success: function (data) {
                    $("#gridReversal").dxDataGrid({
                        dataSource:data, //as json
                        showBorders: true,
                        filterRow: { visible: true },
                        filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        allowColumnResizing: true,
                        paging:{
                            pageSize: 20,
                        },
                        export: {
                            enabled: true
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('palletreversalreport');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'palletreversalreport.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [
                            {
                                dataField: "moveOut",
                                caption: "Transaction Type",
                                width: 100,
                            },
                            {
                                dataField: "strLocation",
                                caption: "Location",
                                width: 150,
                            },
                            {
                                dataField: "UserName",
                                caption: "User Name",
                                width: 200,
                            },
                            {
                                dataField: "intJobIdOut",
                                caption: "Job Id",
                                width: 50,
                            },
                            {
                                dataField: "tokenOut",
                                caption: "Token Out",
                                width: 250,
                            },
                            {
                                dataField: "palletOut",
                                caption: "Pallet Out",
                                width: 150,
                            },
                            {
                                dataField: "itemCodeOut",
                                caption: "Item Code",
                                width: 150,
                            },
                            {
                                dataField: "ItemName",
                                caption: "Item Name",
                                width: 350,
                            },
                            {
                                dataField: "dteTimeCreate",
                                caption: "Date",
                                width: 200,
                            }

                        ],
                        onRowDblClick:function(e){
                            
                        }

                    });

                    //Location Typs

                }

            });
        });
    });


    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }

</script>
</body>
