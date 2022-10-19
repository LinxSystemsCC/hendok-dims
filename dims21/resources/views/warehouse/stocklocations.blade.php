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
            <div class="wrapper">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="tab-button btn-lg btn   active "  data-id="home">Stock Summary</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="tab-button btn-lg btn " data-id="profile">Stock Detail</button>
                </li>

            </ul>
                <div class="contentWrapper">
                <div   class="content  active" id="home"  aria-labelledby="home-tab">
                    <h5>Summary</h5>
                        <div id="gridContainer" style="width: 100% !important;"></div>
                </div>
                <div class="content" id="profile"  aria-labelledby="profile-tab">
                    <h5>Details</h5>

                        <label class="control-label" for="productcode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Item</label>
                        <select  class="form-control input-sm col-xs-1 " id="productcode" style="width: 100%" required>
                            <option></option>
                            @foreach($products as $val)
                                <option value="{{$val->PastelCode}}">{{$val->PastelCode}}-{{$val->PastelDescription}}</option>
                            @endforeach

                        </select>

                    <br>
                        <button class="btn btn-success" id="searchitem">Search</button>

                        <div id="gridContainetypes" style="width: 100% !important;">
                        </div>
                </div>


                </div>
        </div>


    </div>
    <div title="JOB" id="viewjob" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="viewjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewjobTitle">Job Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>


    <div title="Location Type" id="createlocationtype" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="createlocationtypeTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createlocationtypeTitle">Create A Location Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="control-label" for="strLocationType"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Description</label>
                        <input  class="form-control input-sm col-xs-1 " id="strLocationType" style="width: 100%" required>
                    </div>
                </div>
                <br><br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn-danger btn-lg" id="savelocationtype" style="width: 100%;">SAVE</button>
                </div>
            </div>
        </div>

    </div>

    <div title="Location Name" id="createlocationname" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="createlocationname" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createlocationnameTitle">Create A Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="control-label" for="strLocationName"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Location Name</label>
                        <input  class="form-control input-sm col-xs-1 " id="strLocationName" style="width: 100%" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label" for="locationtype"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Location Type</label>

                    </div>
                </div>
                <br><br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn-danger btn-lg" id="savelocationame" style="width: 100%;">SAVE</button>
                </div>
            </div>
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

    tabs.onclick = e => {
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
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });



    $(document).ready(function() {





        $.ajax({
            url: '{!!url("/getviewGridStockSummary")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
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
                        const worksheet = workbook.addWorksheet('getviewGridStockSummary');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'getviewGridStockSummary.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "strErpItemCode",
                            caption: "Item Code",
                            width: 150,

                        }, {
                            dataField: "Description_1",
                            caption: "Item Name",
                            width: 460,

                        }, {
                            dataField: "ItemGroupDescription",
                            caption: "Item Group",
                            width: 180,

                        }, {
                            dataField: "mnyPalletQty",
                            caption: "Qty",dataType:"number",format: "#0",
                            width: 80,

                        }, {
                            dataField: "MinLevel",
                            caption: "Min Level",
                            width: 80,

                        }
                     , {
                            dataField: "MaxLevel",
                            caption: "Max Level",
                            width: 80,

                        }, {
                            dataField: "QtyInStock",
                            caption: "Stock On Hand",
                            width: 80,

                        }
                    ],
                    onRowDblClick:function(e){


                    }

                });

                //Location Typs

            }

        });

        $('#searchitem').click(function(){

            $.ajax({
                url: '{!!url("/getviewGridStockDetails")!!}',
                type: "GET",
                data: {
                    ItemCode:$('#productcode').val()
                },
                success: function (data) {
                    $("#gridContainetypes").dxDataGrid({
                        dataSource: data, //as json
                        showBorders: true,
                        filterRow: {visible: true},
                        filterPanel: {visible: true},
                        headerFilter: {visible: true},
                        allowColumnResizing: true,
                        paging: {
                            pageSize: 20,
                        },
                        export: {
                            enabled: true
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('getviewGridStockDetails');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], {type: 'application/octet-stream'}), 'getLocationNamesAndTypes.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [

                            {
                                dataField: "strErpItemCode",
                                caption: "Item Code",
                                width: 150,

                            }, {
                                dataField: "Description_1",
                                caption: "Item Name",
                                width: 460,

                            }, {
                                dataField: "ItemGroupDescription",
                                caption: "Item Group",
                                width: 180,

                            }, {
                                dataField: "Username",
                                caption: "User Name",
                                width: 140,

                            }
                            , {
                                dataField: "mnyPalletQty",
                                caption: "Qty", dataType: "number", format: "#0",
                                width: 80,

                            }, {
                                dataField: "MinLevel",
                                caption: "Min Level",
                                width: 80,

                            }
                            , {
                                dataField: "MaxLevel",
                                caption: "Max Level",
                                width: 80,

                            }, {
                                dataField: "QtyInStock",
                                caption: "Stock On Hand",
                                width: 80,

                            }
                            , {
                                dataField: "strLocation",
                                caption: "Location",
                                width: 180,

                            },
                            {
                                dataField: "intJobId",
                                caption: "Job Id",
                                width: 80,

                            },
                            {
                                dataField: "strMoveType",
                                caption: "Mov Type",
                                width: 80,

                            },
                            {
                                dataField: "strItem",
                                caption: "strItem",
                                width: 80,

                            }
                        ],
                        onRowDblClick: function (e) {


                        }

                    });
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
