<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
    <title>Create Users</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Multiselect --> 
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet"  type='text/css'>

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.compact.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

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
            height: calc(100vh - 75px);
            max-height: calc(100vh - 75px);
        }

        .customPadding {
            padding: 3px !important;
        }
    </style>

</head>

<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >
        <div class="col-lg-12 d-inline-flex" >
            <h3 style="flex-grow: 1; padding-left: 15px;">USERS</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newuser">
                New User 
            </button>
        </div>

        <div id="gridContainer" style=""></div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newuser" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">Create New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="username"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">User Name </label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="username">
                </div>

                <div class="form-group">
                    <label class="control-label" for="email"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Email </label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="email">
                </div>

                <div class="form-group">
                    <label class="control-label" for="password"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Password </label>
                    <input  type="password" class="form-control input-sm col-xs-1" id="password">
                </div>

                <div class="form-group">
                    <label class="control-label" for="groupID"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Group </label>
                    <select  class="form-select input-sm col-xs-1" id="groupID" required>
                        <option></option>
                        @foreach($groups as $group)
                            <option value="{{$group->GroupId}}">{{$group->GroupName}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label" for="pincode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Pincode </label>
                    <input  type="number" class="form-control input-sm col-xs-1" id="pincode">
                </div>

                <div class="form-group">
                    <label class="control-label" for="tabletuser"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Tablet User </label>
                    <div class="d-inline-flex w-100">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="tabletuseryes" checked value="1">
                            <label class="form-check-label" for="tabletuseryes">
                                Yes
                            </label>
                        </div>

                        <div class="form-check" style="padding-left: 50px;">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="tabletuserno" value="0">
                            <label class="form-check-label" for="tabletuserno"> 
                            No
                            </label>
                        </div>
                    </div>
                </div>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="savesusername" class="btn btn-success" >Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="assignPrinter" tabindex="-1" aria-labelledby="assignPrinterLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="assignPrinterLabel">Assigned Printers</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div id="checkboxContainer">

                    </div>
                    <input id='userId' hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="updatePrinters" class="btn btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>

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
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    $(document).ready(function() {
        
        $('#savesusername').click(function(){

            $.ajax({

                url: '{!!url("/createuser")!!}',
                type: "POST",
                data: {
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    groupID: $('#groupID option:selected').val(),
                    pincode: $('#pincode').val(),
                    tabletuser: $("input[type='radio'][name='flexRadioDefault']:checked").val()
                },
                success: function (data) {
                    location.reload();
                }

            });

        });

        var groups = {!! json_encode($groups) !!};

        $.ajax({

            url: '{!!url("/getusers")!!}',
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
                    paging:{
                        pageSize: 10,
                    },
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
                        mode: 'popup',
                        allowUpdating: true,
                        allowDeleting: true,
                    },
                    selection: {
                        mode: 'single',
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Users');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Users.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "UserID",
                            caption: "ID",
                            allowEditing: false,
                        },{
                            dataField: "UserName",
                            caption: "Username",
                        },{
                            dataField: "Email",
                            caption: "Email",
                        },
                        {
                            dataField: "GroupId",
                            caption: "Group ID",
                            lookup: {
                                dataSource: groups,
                                valueExpr: "GroupId",
                                displayExpr: "GroupName",
                            },
                        },
                        {
                            dataField: "TabletUser",
                            caption: "Tablet User",
                            lookup: {
                                dataSource: [
                                    {Id:"0", Prompt:'No',},
                                    {Id:"1", Prompt:'Yes',}
                                ],
                                valueExpr: "Id",
                                displayExpr: "Prompt",
                            },
                        },
                        {
                            dataField: "printerAssign",
                            caption: "Printers",
                            cellTemplate: function (container, options) {
                                container.addClass("customPadding");
                                const button = $("<button class='btn btn-secondary btn-sm w-100'>").text("View").on("click", function() {
                                    // console.log(options.data);
                                    $("#userId").val(options.data.UserID);
                                    getUserPrinters(options.data.UserID);
                                });
                                container.append(button);
                            },
                            width: 100,
                        },
                    ],
                    onRowDblClick:function(e){ 
                        var intUserID =  e.data.UserID;

                        window.open('{!!url("/userpermissions")!!}/' +intUserID, "User" +intUserID);
                    },
                    onRowRemoving: function(e) {

                        var UserID = e.data.UserID;
                        $.ajax({
                            url: '{!!url("/deleteUser")!!}',
                            type: "GET",
                            data: {
                                ID : UserID,
                            },
                            success: function (data) {
                                location.reload();
                            }
                        });
                    },
                    onRowUpdating: function(e) {
                        var ID = e.oldData.UserID;
                        var userName = e.newData.UserName || e.oldData.UserName;
                        var email = e.newData.Email || e.oldData.Email;
                        var groupId = e.newData.GroupId || e.oldData.GroupId;
                        var tablet = e.newData.TabletUser || e.oldData.TabletUser;

                        $.ajax({
                            url: '{!!url("/updateUser")!!}',
                            type: "GET",
                            data: {
                                ID : ID,
                                userName : userName,
                                email : email,
                                groupId : groupId,
                                tablet : tablet,
                            },
                            success: function (data) {
                                location.reload();
                            }
                        });
                    }
                });

            }

        });

        $('#updatePrinters').click(function(){  
            var userId = $("#userId").val();
            var checkedIds = [];
            $("#checkboxContainer input[type='checkbox']:checked").each(function() {
                checkedIds.push($(this).val());
            });
            
            var printers = checkedIds.join(",");
            updateUserPrinters(userId, printers);
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

    function showDialog(tag,width,height){
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
    };

    function getUserPrinters(ID){
        $.ajax({
            url: '{!!url("/getUserPrinters")!!}',
            type: "GET",
            data: {
                ID : ID,
            },
            success: function (data) {
                // console.log(data);
                var checkboxContainer = $("#checkboxContainer");

                // Loop through your data and append the HTML structure for each line
                checkboxContainer.empty(); 
                
                data.forEach(function(item) {
                    var checkboxDiv = $('<div class="form-check">');
                    var checkboxInput = $('<input class="form-check-input" type="checkbox" value="'+item.intPrinterId+'" id="'+item.intPrinterId+'">');
                    var checkboxLabel = $('<label class="form-check-label" for="flexCheckDefault">').text(item.strPrinter);

                    if (item.intAssigned === '1') {
                        checkboxInput.prop("checked", true);
                    } else {
                        checkboxInput.prop("checked", false);
                    }

                    checkboxDiv.append(checkboxInput);
                    checkboxDiv.append(checkboxLabel);

                    checkboxContainer.append(checkboxDiv);
                });
                
                $("#assignPrinter").modal("toggle");
            }
        });
    };

    function updateUserPrinters(ID, printers){
        $.ajax({
            url: '{!!url("/updateUserPrinters")!!}',
            type: "GET",
            data: {
                ID : ID,
                printers : printers,
            },
            success: function (data) {
                location.reload();
            }
        });
    };



</script>