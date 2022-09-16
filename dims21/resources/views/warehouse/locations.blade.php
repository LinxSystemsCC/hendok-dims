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
            <a href='{!!url("/createPalletConfig")!!}'>Pallets Configurations</a>
            <a href='{!!url("/mapitemstopallet")!!}' >Map Pallet To Items</a>
            <a href='{!!url("/departmentpage")!!}'>Departments</a>
            <a href='{!!url("/machines")!!}'>Machines</a>
            <a href='{!!url("/mapmachinestodept")!!}' >Map Machines To Dept</a>
            <a href='{!!url("/mapitemsmachinesdept")!!}'>Map Machines,Dept & Prod</a>
            <a href='{!!url("/createjobs")!!}'   >Create Jobs</a>
            <a href='{!!url("/printpalletsselectdept")!!}' >Print Pallet Labels</a>
            <a href='{!!url("/location")!!}'  class="active">Locations</a>
            <a href='{!!url("/stocklocation")!!}' >Stock</a>
            <a href="#">In Progress Jobs</a>
            <a href="#">Jobs Data</a>
        </div>
    </div>
    <div class="col-lg-10" >
        <button type="button" class="btn-lg btn btn-primary pull-right" data-toggle="modal" data-target="#createlocationtype">New Location Type</button>
        <button type="button" class="btn-lg btn btn-primary pull-right" data-toggle="modal" data-target="#createlocationname">New Location</button>
        <div id="gridContainer" style="width: 100% !important;">

        </div>  <hr>
        <h5>Location Types</h5> <div id="gridContainetypes" style="width: 100% !important;">
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
                        <select  class="form-control input-sm col-xs-1 " id="locationtype" style="width: 100%" required>
                            <option></option>
                            @foreach($locationtypes as $val)
                                <option value="{{$val->intLocationTypeId}}">{{$val->strLocationType}}</option>
                            @endforeach

                        </select>
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
</style>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {

        $("#savelocationtype").click(function () {

            $.ajax({

                url: '{!!url("/saveLocationType")!!}',
                type: "POST",
                data: {
                    locationtype: $("#strLocationType").val()
                },
                success: function (data) {
                    location.reload();
                }
            });

        });

        $("#savelocationame").click(function () {

            $.ajax({

                url: '{!!url("/saveLocationName")!!}',
                type: "POST",
                data: {
                    locationtypeid: $("#locationtype").val(),
                    strLocationName: $("#strLocationName").val()
                },
                success: function (data) {
                    location.reload();
                }
            });

        });




        $.ajax({
            url: '{!!url("/getLocationNamesAndTypes")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
                    dataSource:data.locationname, //as json
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
                        const worksheet = workbook.addWorksheet('getLocationNamesAndTypes');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'getLocationNamesAndTypes.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "intLocationNameId",
                            caption: "Location ID",
                            width: 60,

                        }, {
                            dataField: "strLocationName",
                            caption: "Location Name",
                            width: 260,

                        }, {
                            dataField: "strLocationType",
                            caption: "Location Type",
                            width: 200,

                        }
                    ],
                    onRowDblClick:function(e){
                        var strLocationName =  e.data.strLocationName;
                        window.open('{!!url("/printlocationqrcodes")!!}/' +strLocationName, "Location" +strLocationName, "location=1,status=1,scrollbars=1, width=1200,height=850");

                    }

                });

                //Location Typs
                $("#gridContainetypes").dxDataGrid({
                    dataSource:data.locationtypes, //as json
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
                        const worksheet = workbook.addWorksheet('getLocationNamesAndTypes');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'getLocationNamesAndTypes.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "intLocationTypeId",
                            caption: "Location Type ID",
                            width: 60,

                        }, {
                            dataField: "strLocationType",
                            caption: "Location Type",
                            width: 200,

                        }
                    ],
                    onRowDblClick:function(e){


                    }

                });
            }

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
