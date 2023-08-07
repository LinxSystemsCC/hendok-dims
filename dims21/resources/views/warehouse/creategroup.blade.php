<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.nset/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
</head>

<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >
        <div class="col-lg-12 d-inline-flex" >
            <h3 style="flex-grow: 1; padding-left: 15px;">GROUPS</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newGroup">
                New Group
            </button>
        </div>

        <div id="gridContainer" style=""></div>

        {{-- <div id="gridContainer1" style=""></div> --}}
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newGroup" tabindex="-1" aria-labelledby="newGroupLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newGroupLabel">Create New Group</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="groupname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Group Name </label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="groupname">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="savesgroupname" class="btn btn-success" >Save</button>
            </div>
        </div>
    </div>
</div>

<style>
    .dx-datagrid-table{
        font-size:15px;
    }

    .dx-datagrid .dx-link {
        color: #df2413;
    }

    .dx-pager .dx-page-sizes .dx-selection, .dx-pager .dx-pages .dx-selection {
        font-weight: 500;
        background-color: #df2413;
        color: #fff;
    }

    .dx-datagrid-filter-panel .dx-datagrid-filter-panel-text {
        color: #df2413;
        font-size: 14px;
        line-height: 18px;
    }

    .dx-datagrid {
        height: calc(100vh - 83px);
        max-height: calc(100vh - 83px);
    }
</style>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Multiselect -->
<script src="{{ asset('js/jquery.multiselect.js') }}"></script>

<!-- Excel Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( document ).on( 'focus', ':input', function()-{
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {


        $('#savesgroupname').click(function(){

            $.ajax({

                url: '{!!url("/savesgroupname")!!}',
                type: "POST",
                data: {
                    groupname: $('#groupname').val()

                },
                success: function (data) {
                    location.reload();
                }

            });

        });

        $.ajax({

            url: '{!!url("/getgroupsetting")!!}',
            type: "GET",
            data: {
                datefrom: $('#datefrom').val(),
                dateto: $('#dateto').val()
            },
            success: function (data) {

                $("#gridContainer1").dxDataGrid({

                    dataSource:data, //as json

                    showBorders: true,
                    filterRow: { visible: true },
                    allowColumnResizing: true,
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Settings');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Settings.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "GroupID",
                            caption: "ID",
                        },  
                        {
                            dataField: "GroupName",
                            caption: "Group Name",
                        },
                        {
                            dataField: "OptionDesc",
                            caption: "Description",
                        }
                        
                    ],
                    onRowDblClick:function(e){

                        // console.debug(e.row,cells[e.columnIndex]);
                        console.log(e.data.GroupID);
                        var GroupID =  e.data.GroupID;
                        var strPalletTypeDescription =  e.data.strgroupName;

                                //data[0].sendto
                                var dialog = $('<p><label>Group Name</label><br><input id="thegroupname" value="'+GroupName+'"><br></p>').dialog({
                                    height: 300, width: 700,modal: true,containment: false,
                                    buttons: {
                                        "Update": function () {

                                            $.ajax({

                                                url: '{!!url("/updategroupName")!!}',
                                                type: "POST",
                                                data: {
                                                    thegroupname: $('#thegroupname').val(),
                                                    GroupID:GroupID
                                                },
                                                success: function (data) {
                                                    location.reload();
                                                },

                                            });

                                        }
                                    }
                                });



                    },
                    onRowClick:function(e){

                    },
                });

            }

        });

        $('#savessettingname').click(function(){

            $.ajax({

                url: '{!!url("/savessettingname")!!}',
                type: "POST",
                data: {
                    groupID: $('#group option:selected').val(),
                    settingname: $('#settingname option:selected').text()

                },
                success: function (data) {
                    location.reload();
                }

            });

        });

        $.ajax({
            url: '{!!url("/getgroupname")!!}',
            type: "GET",
            data: {
                datefrom: $('#datefrom').val(),
                dateto: $('#dateto').val()
            },
            success: function (data) {

                $("#gridContainer").dxDataGrid({

                    dataSource:data, //as json
                    hoverStateEnabled: true,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    scrolling: {
                        rowRenderingMode: 'infinite',
                    },
                    // paging:{
                    //     pageSize: 10,
                    // },
                    pager: {
                        visible: true,
                        allowedPageSizes: [5, 10, 20, 50, 'all'],
                        showPageSizeSelector: true,
                        showInfo: true,
                        showNavigationButtons: true,
                    },
                    export: {
                        enabled: true
                    },
                    editing: {
                        mode: 'batch',
                        allowUpdating: true,
                        allowDeleting: true,
                    },
                    selection: {
                        mode: 'single',
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Groups');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Groups.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "GroupId",
                            caption: "ID",
                            width: 50,

                        }, {
                            dataField: "GroupName",
                            caption: "Group Name",
                            width: 300,

                        }
                        ,/*{
                            dataField: "dteCreated",
                            caption: "Date Time",
                            width: 200,

                        },*/
                    ],
                    onRowDblClick:function(e){

                        // console.debug(e.row,cells[e.columnIndex]);
                        console.log(e.data.GroupID);
                        var GroupID =  e.data.GroupID;
                        var strPalletTypeDescription =  e.data.strgroupName;

                                //data[0].sendto
                                var dialog = $('<p><label>Group Name</label><br><input id="thegroupname" value="'+GroupName+'"><br></p>').dialog({
                                    height: 300, width: 700,modal: true,containment: false,
                                    buttons: {
                                        "Update": function () {

                                            $.ajax({

                                                url: '{!!url("/updategroupName")!!}',
                                                type: "POST",
                                                data: {
                                                    thegroupname: $('#thegroupname').val(),
                                                    GroupID:GroupID
                                                },
                                                success: function (data) {
                                                    location.reload();
                                                },

                                            });

                                        }
                                    }
                                });



                    },
                    onRowClick:function(e){

                    },
                });

            }

        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });
        
        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
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
