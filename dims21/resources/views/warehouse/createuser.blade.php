@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Create Users')


@php
    $includeMenu = true;
@endphp

@section('page')

    <style>
        .customPadding {
            padding: 3px !important;
        }

        #gridUsers {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    
    <div id="gridUsers"></div>

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
                        <label class="control-label fw-bold" for="username">User Name </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="username">
                    </div>

                    <div class="form-group">
                        <label class="control-label fw-bold" for="email">Email </label>
                        <input type="text" class="form-control input-sm col-xs-1" id="email">
                    </div>

                    <div class="form-group">
                        <label class="control-label fw-bold" for="password">Password </label>
                        <input type="password" class="form-control input-sm col-xs-1" id="password">
                    </div>

                    <div class="form-group">
                        <label class="control-label fw-bold" for="groupID">Group </label>
                        <select class="form-select input-sm col-xs-1" id="groupID" required>
                            <option></option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->GroupId }}">{{ $group->GroupName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label fw-bold" for="groupType">Group Type</label>
                        <select class="form-select input-sm col-xs-1" id="groupType" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label fw-bold" for="issuedto">Employee Sage Code</label>
                        <select class="form-select mx-2" type="text" id='sageCode'>
                            <option value="None" selected disabled></option>
                            @foreach ($users as $user)
                                <option value="{{ $user->EmployeeCode }}">{{ $user->FirstName }} {{ $user->LastName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label fw-bold" for="pincode">Pincode </label>
                        <input type="number" class="form-control input-sm col-xs-1" id="pincode">
                    </div>

                    <div class="form-group">
                        <label class="control-label fw-bold" for="tabletuser">Tablet User </label>
                        <div class="d-inline-flex w-100">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="tabletuseryes"
                                    checked value="1">
                                <label class="form-check-label" for="tabletuseryes">
                                    Yes
                                </label>
                            </div>

                            <div class="form-check" style="padding-left: 50px;">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="tabletuserno"
                                    value="0">
                                <label class="form-check-label" for="tabletuserno">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="savesusername" class="btn btn-success">Save</button>
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
                    <button type="button" id="updatePrinters" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#savesusername').click(function() {
                $.ajax({
                    url: '{!! url('/createuser') !!}',
                    type: "POST",
                    data: {
                        username: $('#username').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        groupID: $('#groupID').val(),
                        groupType: $('#groupType').val(),
                        sageCode: $('#sageCode').val(),
                        pincode: $('#pincode').val(),
                        tabletuser: $("input[type='radio'][name='flexRadioDefault']:checked").val()
                    },
                    success: function(data) {
                        location.reload();
                    }

                });
            });

            var groups = {!! json_encode($groups) !!};
            var groupTypes = {!! json_encode($groupTypes) !!};
            var users = {!! json_encode($users) !!};
            var printers = {!! json_encode($printers) !!};

            users.forEach(function(user) {
                user.sageUserName = user.FirstName + " " + user.LastName;
            });

            const gridUsers = $("#gridUsers").dxDataGrid({
                dataSource: getUsers(), //as json
                hoverStateEnabled: true,
                showBorders: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                allowColumnResizing: true,
                columnResizingMode: "widget",
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging: {
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
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'Users.xlsx');
                        });
                    });
                    e.cancel = true;
                },

                columns: [{
                        dataField: "UserID",
                        caption: "ID",
                        allowEditing: false,
                    },
                    {
                        dataField: "UserName",
                        caption: "Username",
                    },
                    {
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
                    }, {
                        dataField: "PrinterPathInvoice",
                        caption: "Invoice Printer",
                        lookup: {
                            dataSource: printers,
                            valueExpr: "strPrinter",
                            displayExpr: "strPrinter",
                        },
                    },{
                        dataField: "PrinterPathTruckControl",
                        caption: "Truck Control Sheet Printer",
                        lookup: {
                            dataSource: printers,
                            valueExpr: "strPrinter",
                            displayExpr: "strPrinter",
                        },
                    },{
                        dataField: "PrinterPathDeliveryNote",
                        caption: "Delivery Note Printer",
                        lookup: {
                            dataSource: printers,
                            valueExpr: "strPrinter",
                            displayExpr: "strPrinter",
                        },
                    },{
                        dataField: "PrinterPathUpliftment",
                        caption: "Upliftment Printer",
                        lookup: {
                            dataSource: printers,
                            valueExpr: "strPrinter",
                            displayExpr: "strPrinter",
                        },
                    },{
                        dataField: "PrinterPathTestCert",
                        caption: "Test Cert Printer",
                        lookup: {
                            dataSource: printers,
                            valueExpr: "strPrinter",
                            displayExpr: "strPrinter",
                        },
                    },{
                        dataField: "PrinterPathIBT",
                        caption: "IBT Printer",
                        lookup: {
                            dataSource: printers,
                            valueExpr: "strPrinter",
                            displayExpr: "strPrinter",
                        },
                    },
                    {
                        dataField: "intGroupType",
                        caption: "Group Type",
                        lookup: {
                            dataSource: groupTypes,
                            valueExpr: "intAutoId",
                            displayExpr: "strGroupType",
                            calculateFilterExpression: function(data) {
                                // Check if 'data' is defined and contains 'GroupId'
                                if (data && data.GroupId !== undefined) {
                                    return ["intGroupId", "=", data.GroupId];
                                }
                                // Return a default filter expression when 'data' is undefined or lacks 'GroupId'
                                return null; // Or any other default filter expression as needed
                            },
                        },
                    },
                    {
                        dataField: "strSageCode",
                        caption: "Sage Name",
                        lookup: {
                            dataSource: users,
                            valueExpr: "EmployeeCode",
                            displayExpr: "sageUserName",
                            searchExpr: ["EmployeeCode", "FirstName", "LastName"],
                        },
                    },
                    {
                        dataField: "TabletUser",
                        caption: "Tablet User",
                        lookup: {
                            dataSource: [{
                                    Id: "0",
                                    Prompt: 'No',
                                },
                                {
                                    Id: "1",
                                    Prompt: 'Yes',
                                }
                            ],
                            valueExpr: "Id",
                            displayExpr: "Prompt",
                        },
                    },
                    {
                        dataField: "printerAssign",
                        caption: "Printers",
                        cellTemplate: function(container, options) {
                            container.addClass("customPadding");
                            const button = $("<button class='btn btn-secondary btn-sm w-100'>")
                                .text("View").on("click", function() {
                                    // console.log(options.data);
                                    $("#userId").val(options.data.UserID);
                                    getUserPrinters(options.data.UserID);
                                });
                            container.append(button);
                        },
                        width: 100,
                        allowEditing: false,
                        fixed: true,
                        fixedPosition: "right",
                    },{
                        type: "buttons",
                        fixed: true,
                        fixedPosition: "right",
                    },
                ],
                onRowDblClick: function(e) {
                    // var intUserID = e.data.UserID;

                    // window.open('{!! url('/userpermissions') !!}/' + intUserID, "User" + intUserID);
                    var intUserID = e.data.UserID;
                    var url = '{{ route('newuserpermissions.index', ['userid' => '__USER_ID__']) }}'.replace('__USER_ID__', intUserID);
                    window.open(url, "User" + intUserID);
                },
                onRowRemoving: function(e) {
                    var UserID = e.data.UserID;
                    $.ajax({
                        url: '{!! url('/deleteUser') !!}',
                        type: "GET",
                        data: {
                            ID: UserID,
                        },
                        success: function(data) {
                            location.reload();
                        }
                    });
                },
                onRowUpdating: function(e) {
                    var ID = e.oldData.UserID;
                    var userName = e.newData.UserName || e.oldData.UserName;
                    var email = e.newData.Email || e.oldData.Email;
                    var groupId = e.newData.GroupId || e.oldData.GroupId;
                    var groupType = e.newData.intGroupType || e.oldData.intGroupType;
                    var sageCode = e.newData.strSageCode || e.oldData.strSageCode;
                    var tablet = e.newData.TabletUser || e.oldData.TabletUser;
                    var PrinterPathInvoice = e.newData.PrinterPathInvoice || e.oldData.PrinterPathInvoice;
                    var PrinterPathTruckControl = e.newData.PrinterPathTruckControl || e.oldData.PrinterPathTruckControl;
                    var PrinterPathDeliveryNote = e.newData.PrinterPathDeliveryNote || e.oldData.PrinterPathDeliveryNote;
                    var PrinterPathUpliftment = e.newData.PrinterPathUpliftment || e.oldData.PrinterPathUpliftment;
                    var PrinterPathTestCert = e.newData.PrinterPathTestCert || e.oldData.PrinterPathTestCert;
                    var PrinterPathIBT = e.newData.PrinterPathIBT || e.oldData.PrinterPathIBT;

                    $.ajax({
                        url: '{!! url('/updateUser') !!}',
                        type: "GET",
                        data: {
                            ID: ID,
                            userName: userName,
                            email: email,
                            groupId: groupId,
                            groupType: groupType,
                            sageCode: sageCode,
                            tablet: tablet,
                            PrinterPathInvoice: PrinterPathInvoice,
                            PrinterPathTruckControl: PrinterPathTruckControl,
                            PrinterPathDeliveryNote: PrinterPathDeliveryNote,
                            PrinterPathUpliftment: PrinterPathUpliftment,
                            PrinterPathTestCert: PrinterPathTestCert,
                            PrinterPathIBT: PrinterPathIBT,
                        },
                        success: function(data) {
                            getUsers();
                        }
                    });
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('Users');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-user",
                            text: "NEW USER",
                            onClick: function(args) {
                                $("#newuser").modal("toggle");
                            },
                        },
                    });
                },
            }).dxDataGrid('instance');

            function getUsers() {
                $.ajax({
                    url: '{!! url('/getusers') !!}',
                    type: "GET",
                    data: {},
                    success: function(data) {
                        // console.log(data);
                        gridUsers.option('dataSource', data);
                        gridUsers.refresh();
                    }
                });
            };

            $('#updatePrinters').click(function() {
                var userId = $("#userId").val();
                var checkedIds = [];
                $("#checkboxContainer input[type='checkbox']:checked").each(function() {
                    checkedIds.push($(this).val());
                });

                var printers = checkedIds.join(",");
                updateUserPrinters(userId, printers);
            });

            $('#sageCode').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newuser'),
                matcher: function(params, data) {
                    // If there's no search term, return all options
                    if ($.trim(params.term) === '') {
                        return data;
                    }
                    // Check if search term matches option value
                    if (data.id.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                        return data;
                    }
                    // Check if search term matches option display text
                    if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                        return data;
                    }
                    // Return null if there's no match
                    return null;
                }
            });

            $('#groupID').change(function() {
                var groupId = $('#groupID').val();
                getGroupTypesByGroupId(groupId);
            });

            function getGroupTypesByGroupId(groupId) {
                $.ajax({
                    url: '{!! url('/getGroupTypesByGroupId') !!}',
                    type: "GET",
                    data: {
                        groupId: groupId,
                    },
                    success: function(data) {
                        var toAppend = '';
                        $("#groupType").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + o.intAutoId + '">' + o
                                .strGroupType +
                                '</option>';
                        });
                        $("#groupType").append(toAppend);
                    }
                });
            };

            function getUserPrinters(ID) {
                $.ajax({
                    url: '{!! url('/getUserPrinters') !!}',
                    type: "GET",
                    data: {
                        ID: ID,
                    },
                    success: function(data) {
                        // console.log(data);
                        printers = data;
                        var checkboxContainer = $("#checkboxContainer");

                        // Loop through your data and append the HTML structure for each line
                        checkboxContainer.empty();

                        data.forEach(function(item) {
                            var checkboxDiv = $('<div class="form-check">');
                            var checkboxInput = $(
                                '<input class="form-check-input" type="checkbox" value="' +
                                item
                                .intPrinterId + '" id="' + item.intPrinterId + '">');
                            var checkboxLabel = $(
                                    '<label class="form-check-label" for="flexCheckDefault">')
                                .text(item.strPrinter);

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

            function updateUserPrinters(ID, printers) {
                $.ajax({
                    url: '{!! url('/updateUserPrinters') !!}',
                    type: "GET",
                    data: {
                        ID: ID,
                        printers: printers,
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            };
        });
    </script>

@endsection
