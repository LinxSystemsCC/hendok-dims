@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stock Issue')

{{-- Set to show navbar --}}
@php
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
        // $permission = $v->getThingsUserPermissions(Auth::user()->UserID,'Permission');
    }

    $includeMenu = true;

@endphp

@section('page')

    <style>
        .select2-container--default .select2-dropdown--below {
            z-index: 1051;
        }

        .select2-container--default .select2-dropdown--above {
            z-index: 1051;
        }

        .modal-xl {
            --bs-modal-width: 90%;
        }

        #gridAvailableStock,
        #gridIssuedStock {
            height: calc(100vh - 113px);
            max-height: calc(100vh - 113px);
        }
    </style>

    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1" role="tab"
                aria-controls="content1" aria-selected="true">Issue Stock</a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2" role="tab" aria-controls="content2"
                aria-selected="true">Issued Stock</a>
        </li>
    </ul>

    <div class="tab-content h-auto py-3" id="tabs">
        <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1"
            style="height: calc(100vh - 110px); overflow-y: auto;">
            <div id="gridAvailableStock"></div>
        </div>

        <div class="tab-pane fade show" id="content2" role="tabpanel" aria-labelledby="tab2"
            style="height: calc(100vh - 110px); overflow-y: auto;">
            <div id="gridIssuedStock"></div>
        </div>
    </div>

    <!-- Modal New Stock -->
    <div class="modal modal-xl fade" id="newStockModal" aria-labelledby="newStockModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newStockModal">Create New Stock Issue</h1>
                </div>

                <div class="modal-body">
                    <div class="form-group w-50">
                        <label class="control-label" for="reference">Reference</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="reference" readonly>

                        <label class="control-label" for="issuedto">Issued to</label>

                        <select class="form-select mx-2" type="text" id='issuedto'>
                            <option value="None" selected readonly></option>
                            @foreach ($users as $user)
                                <option value="{{ $user->EmployeeCode }}">{{ $user->FirstName }} {{ $user->LastName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <br>

                    <button type="button" class="btn btn-success" data-bs-target="#newItemModal" data-bs-toggle="modal"
                        id="addNewItem">ADD</button>

                    <br><br>

                    <div class="form-group">
                        <div id="itemsGrid"></div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeCreateNewStockIssue">Close</button>
                    <button type="button" id="saveStockIssue" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal New Item -->
    <div class="modal modal-lg fade" id="newItemModal" aria-labelledby="newItemModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newItemModal">Insert New Stock Item</h1>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="selectType" class="col-form-label">Stock Issue Type</label>
                                <select class="form-select mx-2" type="text" id='selectType'>
                                    <option value="None"></option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->intAutoID }}">{{ $type->strIssueType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="selectReqType" class="col-form-label">Request Type</label>
                                <select class="form-select mx-2" type="text" id='selectReqType'>
                                    <option value="None"></option>
                                    @foreach ($requestTypes as $type)
                                        <option value="{{ $type->intAutoId }}">{{ $type->strType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="isUpkeepJob" class="col-md-12">
                                <label for="upkeep" class="col-form-label">Is this an Upkeep Job?</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="yesUpkeep">
                                            <label class="form-check-label" for="yesUpkeep">
                                                Yes
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="noUpkeep" checked>
                                            <label class="form-check-label" for="noUpkeep">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="selectItemGroup" class="col-form-label">Item Group</label>
                                <select class="form-select mx-2" type="text" id='selectItemGroup'>
                                    <option></option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->strStockGroup }}">{{ $group->strStockGroupDesc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="selectItem" class="col-form-label">Item Code</label>
                                <select class="form-select mx-2" type="text" id='selectItem'>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputQtyOnHand" class="col-form-label">Qty On Hand</label>
                                <input type="number" class="form-control" id="inputQtyOnHand" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inputQtyIssued" class="col-form-label">Qty Issued</label>
                                <input type="number" class="form-control" id="inputQtyIssued">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inputOldQtyReturned" class="col-form-label">Qty Returned</label>
                                <input type="number" class="form-control" id="inputOldQtyReturned" value=0>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="selectReason" class="col-form-label">Reason</label>
                                <select class="form-select mx-2" type="text" id='selectReason'>
                                    <option></option>
                                    @foreach ($reasons as $reason)
                                        <option value="{{ $reason->intAutoId }}">{{ $reason->strReason }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="selectUpkeepJob" class="col-form-label">Upkeep Job</label>
                                <select class="form-select mx-2" type="text" id='selectUpkeepJob'>
                                    <option></option>
                                    @foreach ($upkeepjobs as $job)
                                        <option value="{{ $job['workOrderNo'] }}">{{ $job['workOrderNo'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="selectPastelProject" class="col-form-label">Pastel Project</label>
                                <select class="form-select mx-2" type="text" id='selectPastelProject'>
                                    <option></option>
                                    @foreach ($pastelProjects as $project)
                                        <option value="{{ $project->ProjectCode }}">{{ $project->ProjectCode }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id='area' class="col-md-6 mb-3">
                                <label for="selectArea" class="col-form-label">Area</label>
                                <select class="form-select mx-2" type="text" id='selectArea'>
                                    <option></option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->intAutoID }}">{{ $area->strAreaName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id='department' class="col-md-6 mb-3">
                                <label for="selectDepartment" class="col-form-label">Department</label>
                                <select class="form-select mx-2" type="text" id='selectDepartment'>
                                </select>
                            </div>

                            <div id='subdepartment' class="col-md-6 mb-3">
                                <label for="selectSubDepartment" class="col-form-label">Sub Department</label>
                                <select class="form-select mx-2" type="text" id='selectSubDepartment'>
                                </select>
                            </div>

                            <div id='machine' class="col-md-6 mb-3">
                                <label for="selectNewMachine" class="col-form-label">Machine</label>
                                <select class="form-select mx-2" type="text" id='selectNewMachine'>
                                </select>
                            </div>

                            {{-- This is for upkeep jobs --}}

                            <div id='upkeeparea' class="col-md-6 mb-3">
                                <label for="selectAreaUpkeep" class="col-form-label">Area</label>
                                <select class="form-select mx-2" type="text" id='selectAreaUpkeep' disabled>
                                    <option></option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->intAutoID }}">{{ $area->strAreaName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id='upkeepdepartment' class="col-md-6 mb-3">
                                <label for="selectDepartmentUpkeep" class="col-form-label">Department</label>
                                <select class="form-select mx-2" type="text" id='selectDepartmentUpkeep' disabled>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->intAutoID }}">{{ $dept->strDeptName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id='upkeepsubdepartment' class="col-md-6 mb-3">
                                <label for="selectSubDepartmentUpkeep" class="col-form-label">Sub Department</label>
                                <select class="form-select mx-2" type="text" id='selectSubDepartmentUpkeep' disabled>
                                    @foreach ($subdepartments as $subdept)
                                        <option value="{{ $subdept->intAutoID }}">{{ $subdept->strSubDeptName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id='upkeepmachine' class="col-md-6 mb-3">
                                <label for="selectMachineUpkeep" class="col-form-label">Machine</label>
                                <select class="form-select mx-2" type="text" id='selectMachineUpkeep' disabled>
                                    @foreach ($machines as $machine)
                                        <option value="{{ $machine->intAutoMachineID }}">{{ $machine->strMachineName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-target="#newStockModal"
                        data-bs-toggle="modal" id="cancelNewStockItem">
                        Cancel
                    </button>

                    <button type="button" id="insertNewLine" class="btn btn-success" data-bs-target="#newStockModal"
                        data-bs-toggle="modal">
                        Insert
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Modal-->
    <div class="modal modal-lg fade" id="returnModal" aria-labelledby="returnModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="returnModal">Return Stock Items</h1>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="row">
                            <input type="text" id="inputHeaderId" hidden>
                            <input type="text" id="inputLineId" hidden>

                            <div class="col-md-6 mb-3">
                                <label for="inputItemCode" class="col-form-label">Item Code</label>
                                <input type="text" class="form-control input-sm col-xs-1" id="inputItemCode" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inputQtyIssuedOnReturn" class="col-form-label">Qty Issued</label>
                                <input type="number" class="form-control" id="inputQtyIssuedOnReturn" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inputOldQtyReturnedOnReturn" class="col-form-label">Old Qty Returned</label>
                                <input type="number" class="form-control" id="inputOldQtyReturnedOnReturn">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inputNewQtyReturnedOnReturn" class="col-form-label">New Qty Returned</label>
                                <input type="number" class="form-control" id="inputNewQtyReturnedOnReturn">
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-target="#returnModal"
                        data-bs-toggle="modal" id="cancelReturnModal">
                        Cancel
                    </button>

                    <button type="button" id="returnItems" class="btn btn-success" data-bs-target="#returnModal"
                        data-bs-toggle="modal">
                        Return
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            var ref = {{ $intAutoId }};
            var ref = ref + 1;

            var types = ({!! json_encode($types) !!});
            var requestTypes = ({!! json_encode($requestTypes) !!});
            var groups = ({!! json_encode($groups) !!});
            var stockItems = ({!! json_encode($stockItems) !!});
            var upkeepjobs = ({!! json_encode($upkeepjobs) !!});
            var areas = ({!! json_encode($areas) !!});
            var departments = ({!! json_encode($departments) !!});
            var subdepartments = ({!! json_encode($subdepartments) !!});
            var machines = ({!! json_encode($machines) !!});
            var pastelProjects = ({!! json_encode($pastelProjects) !!});
            var reasons = ({!! json_encode($reasons) !!});
            var users = ({!! json_encode($users) !!});

            let matchedUser;

            $('#reference').val('STK-' + ref);

            $('#issuedto').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newStockModal'),
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

            $('#selectType').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectReqType').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectItemGroup').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectItem').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectUpkeepJob').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectPastelProject').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectArea').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectDepartment').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectSubDepartment').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectNewMachine').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $('#selectReason').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#newItemModal'),
            });

            $("#selectItem").change(function() {
                var strPastelCode = $('#selectItem').val();

                var result = $.grep(stockItems, function(e) {
                    return e.strPastelCode == strPastelCode;
                });

                if (result.length > 0) {
                    var decQtyOnHand = result[0].decQtyOnHand;
                    $("#inputQtyOnHand").val(decQtyOnHand);
                } else {
                    $("#inputQtyOnHand").val("");
                }
            });

            $('#addNewItem').prop('disabled', true);
            $('#saveStockIssue').prop('disabled', true);
            $('#isUpkeepJob').prop('hidden', true);
            $('#upkeeparea').prop('hidden', true);
            $('#upkeepdepartment').prop('hidden', true);
            $('#upkeepsubdepartment').prop('hidden', true);
            $('#upkeepmachine').prop('hidden', true);
            $('#selectUpkeepJob').prop('disabled', true);

            $("#issuedto").change(function() {
                $('#addNewItem').prop('disabled', false);
            });

            const gridAvailableStock = $("#gridAvailableStock").dxDataGrid({
                dataSource: [], //as json
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
                    mode: 'batch',
                    // allowUpdating: true,
                    // allowDeleting: true,
                    useIcons: true,
                },
                selection: {
                    mode: 'single',
                },
                onExporting(e) {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('StockIssues');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet,
                        autoFilterEnabled: true,
                    }).then(() => {
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'StockIssues.xlsx');
                        });
                    });
                    e.cancel = true;
                },

                columns: [{
                    dataField: "strPastelCode",
                    caption: "Item Code",
                }, {
                    dataField: "strPastelDescription",
                    caption: "Item Description",
                }, {
                    dataField: "fltAvgCost",
                    caption: "Average Cost",
                    dataType: "number",
                    alignment: "center",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                }, {
                    dataField: "strStockGroup",
                    caption: "Item Group",
                }, {
                    dataField: "strStockGroupDesc",
                    caption: "Item Group Description",
                }, {
                    dataField: "decQtyOnHand",
                    caption: "Qty on Hand",
                }, {
                    dataField: "intMinLevel",
                    caption: "Min Level",
                }, {
                    dataField: "intMaxLevel",
                    caption: "Max Level",
                }, ],
                onRowUpdating: function(e) {

                },
                onRowRemoving: function(e) {

                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('ISSUE STOCK');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-plus",
                            text: "NEW STOCK ISSUE",
                            onClick: function(args) {
                                $("#issuedto").prop('disabled', false);
                                $('#newStockModal').modal('show');
                            },
                        },
                    });
                },
            }).dxDataGrid('instance');

            const gridIssuedStock = $("#gridIssuedStock").dxDataGrid({
                dataSource: [], //as json
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
                editing: {
                    mode: 'batch',
                    // allowUpdating: true,
                    // allowDeleting: true,
                    useIcons: true,
                },
                selection: {
                    mode: 'single',
                },
                columns: [{
                    dataField: "dteCreated",
                    caption: "Date",
                }, {
                    dataField: "strReference",
                    caption: "Reference",
                }, {
                    dataField: "strIssueType",
                    caption: "Issue Type",
                }, {
                    dataField: "strIssuedTo",
                    caption: "Issued To",
                }, {
                    dataField: "strUpkeepJob",
                    caption: "Upkeep ID",
                }, {
                    dataField: "strPastelCode",
                    caption: "Item Code",
                }, {
                    dataField: "strPastelDescription",
                    caption: "Item Description",
                }, {
                    dataField: "fltTotalAvgCost",
                    caption: "Total Avg Cost",
                    dataType: "number",
                    alignment: "center",
                    format: {
                        type: "fixedPoint",
                        precision: 2
                    },
                }, {
                    dataField: "strStockGroup",
                    caption: "Item Group",
                }, {
                    dataField: "strAreaName",
                    caption: "strAreaName",
                }, {
                    dataField: "strDeptName",
                    caption: "strDeptName",
                }, {
                    dataField: "strSubDeptName",
                    caption: "strSubDeptName",
                }, {
                    dataField: "strMachineName",
                    caption: "strMachineName",
                }, ],
                onRowDblClick: function(e) {
                    var data = gridIssuedStock.option("dataSource");

                    var issuedStock = data.filter(function(item) {
                        return item.strReference === e.data.strReference;
                    });

                    itemsGrid.option('dataSource', issuedStock);
                    itemsGrid.refresh();

                    $('#reference').val(e.data.strReference);
                    $("#issuedto").prop('disabled', true);
                    $("#issuedto").val(e.data.strIssuedTo).trigger("change");
                    $('#addNewItem').prop('disabled', true);

                    $('#newStockModal').modal('show');
                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('ISSUED STOCK');
                        }
                    });
                },
            }).dxDataGrid('instance');

            getAvailableStock();
            getIssuedStock();

            function getAvailableStock() {
                $.ajax({
                    url: '{!! url('/getIssueStock') !!}',
                    type: "GET",
                    data: {},
                    success: function(data) {
                        gridAvailableStock.option('dataSource', data);
                        gridAvailableStock.refresh();
                    }
                });
            }

            function getIssuedStock() {
                $.ajax({
                    url: '{!! url('/getIssuedStock') !!}',
                    type: "GET",
                    data: {},
                    success: function(data) {
                        gridIssuedStock.option('dataSource', data);
                        gridIssuedStock.refresh();
                    }
                });
            }

            $('#saveStockIssue').click(function() {
                $('#saveStockIssue').prop('disabled', true);

                var allGridItems = $("#itemsGrid").dxDataGrid("getDataSource").items();
                var newLines = new Array();

                allGridItems.forEach((element, index, value) => {
                    newLines.push({
                        'intType': element['intType'],
                        'intReqType': element['intReqType'],
                        'strStockGroup': element['strStockGroup'],
                        'strPastelCode': element['strPastelCode'],
                        'decIssuedQty': element['decIssuedQty'],
                        'decReturnedOld': element['decReturnedOld'],
                        'decReturnedNew': element['decReturnedNew'],
                        'intReason': element['intReason'],
                        'strUpkeep': element['strUpkeepJob'],
                        'strPastelProjectJob': element['strPastelProjectJob'],
                        'intArea': element['intArea'],
                        'intDept': element['intDept'],
                        'intSubDept': element['intSubDept'],
                        'intMachine': element['intMachine']
                    });
                });

                $.ajax({
                    url: '{!! url('/saveStockIssue') !!}',
                    type: "POST",
                    data: {
                        reference: $("#reference").val(),
                        assignedTo: $("#issuedto").val(),
                        lines: newLines
                    },
                    success: function(data) {
                        location.reload();
                    }

                });

            });

            $('#returnItems').click(function() {
                $.ajax({
                    url: '{!! url('/issueStockRecieve') !!}',
                    type: "POST",
                    data: {
                        intHeaderId: $('#inputHeaderId').val(),
                        intLineId: $('#inputLineId').val(),
                        oldQtyReturned: $('#inputOldQtyReturnedOnReturn').val(),
                        newQtyReturned: $('#inputNewQtyReturnedOnReturn').val(),
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            });

            var itemsGrid = $("#itemsGrid").dxDataGrid({
                dataSource: [],
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
                editing: {
                    allowDeleting: true,
                },
                columns: [{
                        dataField: "intHeaderId",
                        caption: "HeaderId",
                    }, {
                        dataField: "intLineId",
                        caption: "LineId",
                    }, {
                        dataField: "intType",
                        caption: "Type",
                        lookup: {
                            dataSource: types,
                            valueExpr: "intAutoID",
                            displayExpr: "strIssueType",
                        },
                    }, {
                        dataField: "intReqType",
                        caption: "Req. Type",
                        lookup: {
                            dataSource: requestTypes,
                            valueExpr: "intAutoId",
                            displayExpr: "strType",
                        },
                    },
                    {
                        dataField: "strStockGroup",
                        caption: "Item Group",
                        lookup: {
                            dataSource: groups,
                            valueExpr: "strStockGroup",
                            displayExpr: "strStockGroupDesc",
                        },
                    },
                    {
                        dataField: "strPastelCode",
                        caption: "Item",
                        lookup: {
                            dataSource: stockItems,
                            valueExpr: "strPastelCode",
                            displayExpr: "strPastelDescription",
                        }
                    }, ,
                    {
                        dataField: "intReason",
                        caption: "Reason",
                        lookup: {
                            dataSource: reasons,
                            valueExpr: "intAutoId",
                            displayExpr: "strReason",
                        }
                    },
                    {
                        dataField: "decIssuedQty",
                        caption: "Qty Issued",
                    },
                    {
                        dataField: "decReturnedOld",
                        caption: "Qty Returned Old",
                    },
                    {
                        dataField: "decReturnedNew",
                        caption: "Qty Returned New",
                    },
                    {
                        dataField: "strUpkeepJob",
                        caption: "Upkeep Job",
                        lookup: {
                            dataSource: upkeepjobs,
                            valueExpr: "workOrderNo",
                            displayExpr: "workOrderNo",
                        },
                    },
                    {
                        dataField: "strPastelProjectJob",
                        caption: "Pastel Project",
                        lookup: {
                            dataSource: pastelProjects,
                            valueExpr: "ProjectCode",
                            displayExpr: "ProjectCode",
                        },
                    },
                    {
                        dataField: "intArea",
                        caption: "Area",
                        lookup: {
                            dataSource: areas,
                            valueExpr: "intAutoID",
                            displayExpr: "strAreaName",
                        },

                    },
                    {
                        dataField: "intDept",
                        caption: "Dept",
                        lookup: {
                            dataSource: departments,
                            valueExpr: "intAutoID",
                            displayExpr: "strDeptName",
                        },
                    },
                    {
                        dataField: "intSubDept",
                        caption: "Sub Dept",
                        lookup: {
                            dataSource: subdepartments,
                            valueExpr: "intAutoID",
                            displayExpr: "strSubDeptName",
                        },
                    },
                    {
                        dataField: "intMachine",
                        caption: "Machine",
                        lookup: {
                            dataSource: machines,
                            valueExpr: "intAutoMachineID",
                            displayExpr: "strMachineName",
                        },
                    },
                ],
                onRowRemoved: function(e) {
                    var dataSource = itemsGrid.getDataSource();
                    if (dataSource.items().length === 0) {
                        $('#saveStockIssue').prop('disabled', true);
                    }
                },
                onRowDblClick: function(e) {
                    $('.modal').modal('hide');

                    let headerId = e.data.intHeaderId;
                    let lineId = e.data.intLineId;
                    var ItemCode = e.data.strPastelCode;
                    var qtyIssued = e.data.decIssuedQty;

                    $("#inputHeaderId").val(headerId);
                    $("#inputLineId").val(lineId);
                    $("#inputItemCode").val(ItemCode);
                    $("#inputQtyIssuedOnReturn").val(qtyIssued);

                    $('#returnModal').modal('show');
                }
            }).dxDataGrid("instance");

            $('#insertNewLine').click(function() {
                $('#saveStockIssue').prop('disabled', false);
                // Get the values from the input fields
                var intType = $("#selectType").val();
                var intReqType = $("#selectReqType").val();
                var strStockGroup = $("#selectItemGroup").val();
                var strPastelCode = $("#selectItem").val();

                var decIssuedQty = $("#inputQtyIssued").val();

                var decReturnedOld = $("#inputOldQtyReturned").val();
                var decReturnedNew = 0;

                var strUpkeep = $("#selectUpkeepJob").val();
                var strPastelProjectJob = $("#selectPastelProject").val();
                var intReason = $("#selectReason").val();

                if ($("#yesUpkeep").prop("checked")) {
                    var intArea = $("#selectAreaUpkeep").val();
                    var intDept = $("#selectDepartmentUpkeep").val();
                    var intSubDept = $("#selectSubDepartmentUpkeep").val();
                    var intMachine = $("#selectMachineUpkeep").val();
                } else {
                    var intArea = $("#selectArea").val();
                    var intDept = $("#selectDepartment").val();
                    var intSubDept = $("#selectSubDepartment").val();
                    var intMachine = $("#selectNewMachine").val();
                }

                // Create an object that represents the new row
                var newRow = {
                    intType: intType,
                    intReqType: intReqType,
                    strStockGroup: strStockGroup,
                    strPastelCode: strPastelCode,
                    decIssuedQty: decIssuedQty,
                    decReturnedOld: decReturnedOld,
                    decReturnedNew: decReturnedNew,
                    strUpkeepJob: strUpkeep,
                    strPastelProjectJob: strPastelProjectJob,
                    intArea: intArea,
                    intDept: intDept,
                    intSubDept: intSubDept,
                    intMachine: intMachine,
                    intReason: intReason
                };

                var dataSource = itemsGrid.getDataSource();
                dataSource.store().insert(newRow).then(function() {
                    dataSource.reload();
                })

                $("#selectType").val("").trigger("change");
                $("#selectReqType").val("").trigger("change");
                $("#selectItemGroup").val("").trigger("change");
                $("#selectItem").val("").trigger("change");
                $("#inputQtyOnHand").val("").trigger("change");
                $("#inputQtyIssued").val("").trigger("change");
                $("#selectUpkeepJob").val("").trigger("change");
                $("#selectPastelProject").val("").trigger("change");
                $("#selectArea").val("").trigger("change");
                $("#selectDepartment").val("").trigger("change");
                $("#selectSubDepartment").val("").trigger("change");
                $("#selectNewMachine").val("").trigger("change");

                $("#selectAreaUpkeep").val("").trigger("change");
                $("#selectMachineUpkeep").val("").trigger("change");
                $("#selectDepartmentUpkeep").val("").trigger("change");
                $("#selectSubDepartmentUpkeep").val("").trigger("change");

                $("#inputOldQtyReturned").val(0).trigger("change");

                $("#selectReason").val("").trigger("change");
            });

            // Item Restrictions
            $('#selectType').change(function() {
                var Type = $('#selectType :selected').text();
                if (Type === 'Parts') {
                    $('#isUpkeepJob').prop('hidden', false);
                    $("#noUpkeep").prop('checked', true);
                    $("#yesUpkeep").prop('checked', false);

                    $('#selectArea').prop('disabled', false);
                    $('#selectDepartment').prop('disabled', false);
                    $('#selectSubDepartment').prop('disabled', false);
                    $('#selectNewMachine').prop('disabled', false);
                } else if (Type === 'PPE') {
                    $('#isUpkeepJob').prop('hidden', true);

                    $('#upkeeparea').prop('hidden', true);
                    $('#upkeepdepartment').prop('hidden', true);
                    $('#upkeepsubdepartment').prop('hidden', true);
                    $('#upkeepmachine').prop('hidden', true);

                    $('#area').prop('hidden', false);
                    $('#department').prop('hidden', false);
                    $('#subdepartment').prop('hidden', false);
                    $('#machine').prop('hidden', false);

                    $('#selectArea').prop('disabled', true);
                    $('#selectDepartment').prop('disabled', true);
                    $('#selectSubDepartment').prop('disabled', true);
                    $('#selectNewMachine').prop('disabled', true);

                    $('#selectArea').prop('disabled', true);
                    $('#selectDepartment').prop('disabled', true);
                    $('#selectSubDepartment').prop('disabled', true);
                    $('#selectNewMachine').prop('disabled', true);

                    const selectedCode = $('#issuedto').val();
                    matchedUser = users.find(user => user.EmployeeCode === selectedCode);

                    if (matchedUser) {
                        setSelect2ByText('#selectArea', matchedUser.Area);
                    } else {
                        $('#selectArea').val('');
                        $('#selectDepartment').val('');
                        $('#selectSubDepartment').val('');
                        $('#selectNewMachine').val('');
                    }

                } else {
                    $('#isUpkeepJob').prop('hidden', true);
                    $('#upkeeparea').prop('hidden', true);
                    $('#upkeepdepartment').prop('hidden', true);
                    $('#upkeepsubdepartment').prop('hidden', true);
                    $('#upkeepmachine').prop('hidden', true);

                    $('#area').prop('hidden', false);
                    $('#department').prop('hidden', false);
                    $('#subdepartment').prop('hidden', false);
                    $('#machine').prop('hidden', false);

                    $('#selectArea').prop('disabled', false);
                    $('#selectDepartment').prop('disabled', false);
                    $('#selectSubDepartment').prop('disabled', false);
                    $('#selectNewMachine').prop('disabled', false);
                }

                $('#selectUpkeepJob').prop('disabled', true);
                $('#selectUpkeepJob').val("").trigger("change");
                $('#selectAreaUpkeep').val("").trigger("change");
                $('#selectMachineUpkeep').val("").trigger("change");
                $('#selectDepartmentUpkeep').val("").trigger("change");
                $('#selectSubDepartmentUpkeep').val("").trigger("change");
            });

            function setSelect2ByText(selectId, matchText) {
                let $select = $(selectId);
                let matchingOption = $select.find('option').filter(function() {
                    return $(this).text().trim() === matchText.trim();
                });

                if (matchingOption.length) {
                    $select.find('option').prop('selected', false); // optional: deselect others
                    matchingOption.prop('selected', true);
                    $select.trigger('change');
                }
            }

            $("#yesUpkeep").change(function() {
                $('#area').prop('hidden', true);
                $('#department').prop('hidden', true);
                $('#subdepartment').prop('hidden', true);
                $('#machine').prop('hidden', true);

                $('#upkeeparea').prop('hidden', false);
                $('#upkeepdepartment').prop('hidden', false);
                $('#upkeepsubdepartment').prop('hidden', false);
                $('#upkeepmachine').prop('hidden', false);

                $('#selectUpkeepJob').prop('disabled', false);

            });

            $("#noUpkeep").change(function() {
                $('#area').prop('hidden', false);
                $('#department').prop('hidden', false);
                $('#subdepartment').prop('hidden', false);
                $('#machine').prop('hidden', false);

                $('#upkeeparea').prop('hidden', true);
                $('#upkeepdepartment').prop('hidden', true);
                $('#upkeepsubdepartment').prop('hidden', true);
                $('#upkeepmachine').prop('hidden', true);

                $('#selectUpkeepJob').prop('disabled', true);
                $("#selectUpkeepJob").val("").trigger("change");

                $('#selectAreaUpkeep').val("").trigger("change");
                $('#selectMachineUpkeep').val("").trigger("change");
                $('#selectDepartmentUpkeep').val("").trigger("change");
                $('#selectSubDepartmentUpkeep').val("").trigger("change");
            });

            $('#selectItemGroup').change(function() {
                var selectedValue = $('#selectItemGroup option:selected').val();

                // Check if the value is empty
                if (!selectedValue) {
                    return; // Exit the function if the value is empty
                }

                $.ajax({
                    url: '{!! url('/getStockItemsByGroup') !!}',
                    type: "GET",
                    data: {
                        ItemGroup: selectedValue,
                    },
                    success: function(data) {
                        var toAppend = '';
                        $("#selectItem").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {
                            toAppend += '<option value="' + o.strPastelCode + '">' + o
                                .strPastelDescription + '</option>';
                        });
                        $("#selectItem").append(toAppend);
                        $('#selectItem').select2({
                            theme: 'bootstrap-5',
                            dropdownParent: $('#newItemModal'),
                        });
                    }
                });
            });

            $('#selectArea').change(function() {
                var selectedValue = $('#selectArea').val();

                // Check if the value is empty
                if (!selectedValue) {
                    return; // Exit the function if the value is empty
                }

                $.ajax({
                    url: '{!! url('/getBulkMappingAreaDeptSubDeptMachines') !!}',
                    type: "GET",
                    data: {
                        ID: selectedValue,
                        prompt: 'Departments'
                    },
                    success: function(data) {
                        var toAppend = '';

                        $("#selectDepartment").empty();
                        $("#selectSubDepartment").empty();
                        $("#selectNewMachine").empty();

                        toAppend += '<option></option>';

                        $.each(data, function(i, o) {
                            toAppend += '<option value="' + o.intDeptID + '">' + o
                                .strDeptName + '</option>';
                        });

                        $("#selectDepartment").append(toAppend);

                        $('#selectDepartment').select2({
                            theme: 'bootstrap-5',
                            dropdownParent: $('#newItemModal'),
                        });
                        if (matchedUser && matchedUser.Department) {
                            setSelect2ByText('#selectDepartment', matchedUser.Department);
                        }
                    }
                });
            });

            $('#selectDepartment').change(function() {
                var selectedValue = $('#selectDepartment').val();

                // Check if the value is empty
                if (!selectedValue) {
                    return; // Exit the function if the value is empty
                }

                $.ajax({
                    url: '{!! url('/getBulkMappingAreaDeptSubDeptMachines') !!}',
                    type: "GET",
                    data: {
                        ID: selectedValue,
                        prompt: 'SubDepartments'
                    },
                    success: function(data) {
                        var toAppend = '';
                        $("#selectSubDepartment").empty();
                        $("#selectNewMachine").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {
                            toAppend += '<option value="' + o.intSubDeptID + '">' + o
                                .strSubDeptName + '</option>';
                        });
                        $("#selectSubDepartment").append(toAppend);
                        $('#selectSubDepartment').select2({
                            theme: 'bootstrap-5',
                            dropdownParent: $('#newItemModal'),
                        });
                        if (matchedUser && matchedUser.SubDepartment) {
                            setSelect2ByText('#selectSubDepartment', matchedUser.SubDepartment);
                        }
                    }
                });
            });

            $('#selectSubDepartment').change(function() {
                var selectedValue = $('#selectSubDepartment').val();

                // Check if the value is empty
                if (!selectedValue) {
                    return; // Exit the function if the value is empty
                }

                $.ajax({
                    url: '{!! url('/getBulkMappingAreaDeptSubDeptMachines') !!}',
                    type: "GET",
                    data: {
                        ID: selectedValue,
                        prompt: 'Machines'
                    },
                    success: function(data) {
                        var toAppend = '';
                        $("#selectNewMachine").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {
                            toAppend += '<option value="' + o.intMachineID + '">' + o
                                .strMachineName + '</option>';
                        });
                        $("#selectNewMachine").append(toAppend);
                        $('#selectNewMachine').select2({
                            theme: 'bootstrap-5',
                            dropdownParent: $('#newItemModal'),
                        });
                        
                        if (matchedUser && matchedUser.Machine) {
                            setSelect2ByText('#selectNewMachine', matchedUser.Machine);
                        }
                    }
                });
            });

            $('#selectUpkeepJob').change(function() {

                var JobsList = {!! json_encode($upkeepjobs) !!};
                var upkeepID = $('#selectUpkeepJob').val();
                var strPastelCode = $('#selectItem').val();

                if (upkeepID !== '') {
                    var result = $.grep(JobsList, function(e) {
                        return e.workOrderNo == upkeepID;
                    });

                    var AssetID = result[0].asset;
                    var LocationID = result[0].location;

                    $.ajax({
                        url: '{!! url('/getUpkeepJobAsset/') !!}' + '/' + AssetID,
                        type: "GET",
                        data: {},
                        success: function(data) {
                            if (data.success === true) {
                                var MachineName = data.result.name;
                            } else {
                                DevExpress.ui.dialog.alert(
                                    data.message,
                                    "Alert"
                                );
                            }

                            // $('#selectMachineUpkeep').val(MachineName);
                            var selectBox = $('#selectMachineUpkeep');

                            selectBox.val(selectBox.find('option').filter(function() {
                                return $(this).text() === MachineName;
                            }).val()).change();

                            $.ajax({
                                url: '{!! url('/GetAreaDeptSubDeptByMachine') !!}',
                                type: "GET",
                                data: {
                                    MachineName: MachineName,
                                },
                                success: function(data) {
                                    if (data.length !== 0) {
                                        $('#selectAreaUpkeep').val(data[0][
                                            'intAreaID'
                                        ]);
                                        $('#selectDepartmentUpkeep').val(data[0][
                                            'intDeptID'
                                        ]);
                                        $('#selectSubDepartmentUpkeep').val(data[0][
                                            'intSubDeptID'
                                        ]);
                                    } else {
                                        DevExpress.ui.dialog.alert(
                                            "The Machine needs to be mapped! Please contact IT.",
                                            "Alert"
                                        );
                                    }
                                }
                            });
                        }
                    });

                }
            });

            $('#closeCreateNewStockIssue').click(function() {
                $('#reference').val('STK-' + ref);
                $("#issuedto").prop('readonly', false);

                $("#issuedto").val("None").trigger("change");
                $('#addNewItem').prop('disabled', true);
                var dataSource = itemsGrid.getDataSource();

                dataSource.store().clear();
                dataSource.reload();
            });

            $('#cancelNewStockItem').click(function() {
                $("#selectType").val("").trigger("change");
                $("#selectItemGroup").val("").trigger("change");
                $("#selectItem").val("").trigger("change");
                $("#inputQtyOnHand").val("").trigger("change");
                $("#inputQtyIssued").val("").trigger("change");
                $("#inputOld").val("").trigger("change");
                $("#selectUpkeepJob").val("").trigger("change");
                $("#selectPastelProject").val("").trigger("change");
                $("#selectArea").val("").trigger("change");
                $("#selectDepartment").val("").trigger("change");
                $("#selectSubDepartment").val("").trigger("change");
                $("#selectNewMachine").val("").trigger("change");

                $("#selectAreaUpkeep").val("").trigger("change");
                $("#selectMachineUpkeep").val("").trigger("change");
                $("#selectDepartmentUpkeep").val("").trigger("change");
                $("#selectSubDepartmentUpkeep").val("").trigger("change");

                $("#inputOldQtyReturned").val(0).trigger("change");

                $("#selectReason").val("").trigger("change");
            });

            $('#cancelReturnModal').on('click', function() {
                $('#returnModal').modal('hide');

                // Open the new modal
                $('#newStockModal').modal('show');
            });
        });
    </script>

@endsection
