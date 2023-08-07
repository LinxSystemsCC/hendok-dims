<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

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

        #gridContainer {
            height: calc(100vh - 63px);
            max-height: calc(100vh - 63px);
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
            <h3 style="flex-grow: 1; padding-left: 15px;">ISSUE STOCK</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newStockModal">
                New Stock Issue
            </button>
        </div>
        
        <div id="gridContainer"></div>
        
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
                    <input type="text" class="form-control input-sm col-xs-1" id="reference" disabled>

                    <label class="control-label" for="issuedto">Issued to</label>

                    <select class="form-select mx-2" type="text" id='issuedto'>
                        <option value="None" selected disabled></option>
                        @foreach ($users as $user)
                            <option value="{{ $user->EmployeeCode }}">{{ $user->FirstName }} {{ $user->LastName }}</option>
                        @endforeach
                    </select>
                </div>    

                <br>

                <button type="button" class="btn btn-success" data-bs-target="#newItemModal" data-bs-toggle="modal" id="addNewItem">ADD</button> 

                <br><br>

                <div class="form-group">
                    <div id="itemsGrid"></div>
                </div>
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeCreateNewStockIssue">Close</button>
                <button type="button" id="savestockissue" class="btn btn-success" >Save</button>
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
                        <div class="col-md-12 mb-3">
                            <label for="newType" class="col-form-label">Stock Issue Type</label>
                            <select class="form-select mx-2" type="text" id='newType'>
                                <option value="None"></option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->intAutoID }}">{{ $type->strIssueType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="isUpkeepJob" class="col-md-12 mb-3">
                            <label for="upkeep" class="col-form-label">Is this an Upkeep Job?</label>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="yesUpkeep">
                                        <label class="form-check-label" for="yesUpkeep">
                                        Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="noUpkeep" checked>
                                        <label class="form-check-label" for="noUpkeep">
                                        No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newItemGroup" class="col-form-label">Item Group</label>
                            <select class="form-select mx-2" type="text" id='newItemGroup'>
                                <option></option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->strStockGroup }}">{{ $group->strStockGroupDesc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newItem" class="col-form-label">Item Code</label>
                            <select class="form-select mx-2" type="text" id='newItem'>
                                <option></option>
                                {{-- @foreach ($stockItems as $stock)
                                    <option value="{{ $stock->strPastelCode }}">{{ $stock->strPastelDescription }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newQtyOnHand" class="col-form-label">Qty On Hand</label>
                            <input type="text" class="form-control" id="newQtyOnHand" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newQtyRequired" class="col-form-label">Qty Required</label>
                            <input type="text" class="form-control" id="newQtyRequired">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newUpkeepJob" class="col-form-label">Upkeep Job</label>
                            <select class="form-select mx-2" type="text" id='newUpkeepJob'>
                                <option></option>
                                @foreach ($upkeepjobs as $job)
                                    <option value="{{ $job['workOrderNo'] }}">{{ $job['workOrderNo'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newPastelProject" class="col-form-label">Pastel Project</label>
                            <select class="form-select mx-2" type="text" id='newPastelProject'>
                                <option></option>
                                @foreach ($pastelProjects as $project)
                                    <option value="{{ $project->ProjectCode }}">{{ $project->ProjectCode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id='area' class="col-md-6 mb-3">
                            <label for="newArea" class="col-form-label">Area</label>
                            <select class="form-select mx-2" type="text" id='newArea'>
                                <option></option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->intAutoID }}">{{ $area->strAreaName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id='department' class="col-md-6 mb-3">
                            <label for="newDepartment" class="col-form-label">Department</label>
                            <select class="form-select mx-2" type="text" id='newDepartment'>
                                {{-- @foreach ($departments as $dept)
                                    <option value="{{ $dept->intAutoID }}">{{ $dept->strDeptName }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div id='subdepartment' class="col-md-6 mb-3">
                            <label for="newSubDepartment" class="col-form-label">Sub Department</label>
                            <select class="form-select mx-2" type="text" id='newSubDepartment'>
                                {{-- @foreach ($subdepartments as $subdept)
                                    <option value="{{ $subdept->intAutoID }}">{{ $subdept->strSubDeptName }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div id='machine' class="col-md-6 mb-3">
                            <label for="newMachine" class="col-form-label">Machine</label>
                            <select class="form-select mx-2" type="text" id='newMachine'>
                                {{-- @foreach ($machines as $machine)
                                    <option value="{{ $machine->intAutoMachineID }}">{{ $machine->strMachineName }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        {{-- This is for upkeep jobs --}}

                        <div id='upkeeparea' class="col-md-6 mb-3">
                            <label for="upkeepNewArea" class="col-form-label">Area</label>
                            <input type="text" class="form-control" id="upkeepNewArea" disabled>
                        </div>
                        <div id='upkeepdepartment' class="col-md-6 mb-3">
                            <label for="upkeepNewDepartment" class="col-form-label">Department</label>
                            <input type="text" class="form-control" id="upkeepNewDepartment" disabled>
                        </div>
                        <div id='upkeepsubdepartment' class="col-md-6 mb-3">
                            <label for="upkeepNewSubDepartment" class="col-form-label">Sub Department</label>
                            <input type="text" class="form-control" id="upkeepNewSubDepartment" disabled>
                        </div>
                        <div id='upkeepmachine' class="col-md-6 mb-3">
                            <label for="upkeepNewMachine" class="col-form-label">Machine</label>
                            <input type="text" class="form-control" id="upkeepNewMachine" disabled>
                        </div>

                    </div>
                </form>           
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-target="#newStockModal" data-bs-toggle="modal" id="cancelNewStockItem">Cancel</button>
                <button type="button" id="insertNewLine" class="btn btn-success" data-bs-target="#newStockModal" data-bs-toggle="modal">Insert</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
        var ref ={{ $intAutoId }};
        var ref = ref+1;

        var types = ({!! json_encode($types) !!});
        var groups = ({!! json_encode($groups) !!});
        var stockItems = ({!! json_encode($stockItems) !!});
        var upkeepjobs = ({!! json_encode($upkeepjobs) !!});
        var areas = ({!! json_encode($areas) !!});
        var departments = ({!! json_encode($departments) !!});
        var subdepartments = ({!! json_encode($subdepartments) !!});
        var machines = ({!! json_encode($machines) !!});
        var pastelProjects = ({!! json_encode($pastelProjects) !!});

        $('#reference').val('STK-'+ref);

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

        $('#newType').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newItemGroup').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newItem').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newUpkeepJob').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newPastelProject').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newArea').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newDepartment').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newSubDepartment').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $('#newMachine').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newItemModal'),
        });

        $("#newItem").change(function(){
            var strPastelCode = $('#newItem').val();

            var result = $.grep(stockItems, function(e) {
                return e.strPastelCode == strPastelCode;
            });

            if (result.length > 0) {
                var mnyQtyOnHand = result[0].mnyQtyOnHand;
                $("#newQtyOnHand").val(mnyQtyOnHand);
            } else {
                $("#newQtyOnHand").val("");
            }
        });

        $('#addNewItem').prop('disabled', true);
        $('#savestockissue').prop('disabled', true);
        $('#isUpkeepJob').prop('hidden', true);
        $('#upkeeparea').prop('hidden', true);
        $('#upkeepdepartment').prop('hidden', true);
        $('#upkeepsubdepartment').prop('hidden', true);
        $('#upkeepmachine').prop('hidden', true);
        $('#newUpkeepJob').prop('disabled', true);

        $("#issuedto").change(function(){
            $('#addNewItem').prop('disabled', false);
        });

        $.ajax({
            url: '{!!url("/getIssueStock")!!}',
            type: "GET",
            data: {

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
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'StockIssues.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "strPastelCode",
                            caption: "Item Code",
                        },{
                            dataField: "strPastelDescription",
                            caption: "Item Description",
                        },{
                            dataField: "strStockGroup",
                            caption: "Item Group",
                        },{
                            dataField: "strStockGroupDesc",
                            caption: "Item Group Description",
                        },{
                            dataField: "mnyQtyOnHand",
                            caption: "Qty on Hand",
                        },{
                            dataField: "intMinLevel",
                            caption: "Min Level",
                        },{
                            dataField: "intMaxLevel",
                            caption: "Max Level",
                        },
                    ],
                    onRowUpdating: function(e){

                    },
                    onRowRemoving: function(e) {

                    }
                });
            }
        });

        $('#savestockissue').click(function(){
            $('#savestockissue').prop('disabled', true);
            var allGridItems =  $("#itemsGrid").dxDataGrid("getDataSource").items();
            var newLines = new Array();

            allGridItems.forEach((element, index, value) => {
                newLines.push({
                    'intType': element['intType'],
                    'strStockGroup': element['strStockGroup'],
                    'strPastelCode': element['strPastelCode'],
                    'mnyQty': element['mnyQty'],
                    'strUpkeep': element['strUpkeep'],
                    'strPastelProjectJob': element['strPastelProjectJob'],
                    'intArea': element['intArea'],
                    'intDept': element['intDept'],
                    'intSubDept': element['intSubDept'],
                    'intMachine': element['intMachine']
                });
            });

            $.ajax({

                url: '{!!url("/savestockissue")!!}',
                type: "POST",
                data: {
                    reference: $("#reference").val(),
                    assignedTo: $("#issuedto").val(),
                    lines: newLines
                },
                success: function (data) {
                    location.reload();
                }

            });

        });

        var itemsGrid = $("#itemsGrid").dxDataGrid({
            dataSource: [],
            hoverStateEnabled: true,
            showBorders: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            noDataText: "Please Add Lines",
            editing: {
                allowDeleting: true,
            },
            columns: [
                {
                    dataField: "intType",
                    caption: "Type",
                    lookup: {
                        dataSource: types,
                        valueExpr: "intAutoID",
                        displayExpr: "strIssueType",
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
                },
                {
                    dataField: "mnyQty",
                    caption: "Qty Required",
                },
                {
                    dataField: "strUpkeep",
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
                    $('#savestockissue').prop('disabled', true);
                }
            },       
        }).dxDataGrid("instance");

        $('#insertNewLine').click(function(){
            $('#savestockissue').prop('disabled', false);
            // Get the values from the input fields
            var intType = $("#newType").val();
            var strStockGroup = $("#newItemGroup").val();
            var strPastelCode = $("#newItem").val();
            var mnyQty = $("#newQtyRequired").val();
            var strUpkeep = $("#newUpkeepJob").val();
            var strPastelProjectJob = $("#newPastelProject").val();
            var intArea = $("#newArea").val();
            var intDept = $("#newDepartment").val();
            var intSubDept = $("#newSubDepartment").val();
            var intMachine = $("#newMachine").val();

            // Create an object that represents the new row
            var newRow = {
                intType: intType,
                strStockGroup: strStockGroup,
                strPastelCode: strPastelCode,
                mnyQty: mnyQty,
                strUpkeep: strUpkeep,
                strPastelProjectJob: strPastelProjectJob,
                intArea: intArea,
                intDept: intDept,
                intSubDept: intSubDept,
                intMachine: intMachine
            };

            var dataSource = itemsGrid.getDataSource();
            dataSource.store().insert(newRow).then(function() {
                dataSource.reload();
            })

            $("#newType").val("").trigger("change");
            $("#newItemGroup").val("").trigger("change");
            $("#newItem").val("").trigger("change");
            $("#newQtyOnHand").val("").trigger("change");
            $("#newQtyRequired").val("").trigger("change");
            $("#newUpkeepJob").val("").trigger("change");
            $("#newPastelProject").val("").trigger("change");
            $("#newArea").val("").trigger("change");
            $("#newDepartment").val("").trigger("change");
            $("#newSubDepartment").val("").trigger("change");
            $("#newMachine").val("").trigger("change");

            $("#upkeepNewArea").val("").trigger("change");
            $("#upkeepNewMachine").val("").trigger("change");
            $("#upkeepNewDepartment").val("").trigger("change");
            $("#upkeepNewSubDepartment").val("").trigger("change");
        });

        // Item Restrictions

        $('#newType').change(function(){
            var Type = $('#newType :selected').text();
            // console.log(Type);
            if (Type === 'Parts'){
                $('#isUpkeepJob').prop('hidden', false);
                $("#noUpkeep").prop('checked', true);
                $("#yesUpkeep").prop('checked', false);
                
            }else{
                $('#isUpkeepJob').prop('hidden', true);
                $('#upkeeparea').prop('hidden', true);
                $('#upkeepdepartment').prop('hidden', true);
                $('#upkeepsubdepartment').prop('hidden', true);
                $('#upkeepmachine').prop('hidden', true);

                $('#area').prop('hidden', false);
                $('#department').prop('hidden', false);
                $('#subdepartment').prop('hidden', false);
                $('#machine').prop('hidden', false);
            }

            $('#newUpkeepJob').prop('disabled', true);
            $('#newUpkeepJob').val("").trigger("change");
            $('#upkeepNewArea').val("").trigger("change");
            $('#upkeepNewMachine').val("").trigger("change");
            $('#upkeepNewDepartment').val("").trigger("change");
            $('#upkeepNewSubDepartment').val("").trigger("change");
        });

        $("#yesUpkeep").change(function() {
            $('#area').prop('hidden', true);
            $('#department').prop('hidden', true);
            $('#subdepartment').prop('hidden', true);
            $('#machine').prop('hidden', true);

            $('#upkeeparea').prop('hidden', false);
            $('#upkeepdepartment').prop('hidden', false);
            $('#upkeepsubdepartment').prop('hidden', false);
            $('#upkeepmachine').prop('hidden', false);

            $('#newUpkeepJob').prop('disabled', false);
            
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

            $('#newUpkeepJob').prop('disabled', true);
            $("#newUpkeepJob").val("").trigger("change");

            $('#upkeepNewArea').val("").trigger("change");
            $('#upkeepNewMachine').val("").trigger("change");
            $('#upkeepNewDepartment').val("").trigger("change");
            $('#upkeepNewSubDepartment').val("").trigger("change");
        });

        $('#newItemGroup').change(function(){
            $.ajax({
                url: '{!!url("/getStockItemsByGroup")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#newItemGroup option:selected').val(),
                },
                success: function (data) {
                    var toAppend = '';
                    $("#newItem").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.strPastelCode+'">'+o.strPastelDescription+'</option>';
                    });
                    $("#newItem").append(toAppend);
                    $('#newItem').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#newItemModal'),
                    });
                }
            });
        });

        $('#newArea').change(function(){
            $.ajax({
                url: '{!!url("/getBulkMappingAreaDeptSubDeptMachines")!!}',
                type: "GET",
                data: {
                    ID: $('#newArea').val(),
                    prompt: 'Departments'
                },
                success: function (data) {
                    console.log(data);
                    var toAppend = '';
                    $("#newDepartment").empty();
                    $("#newSubDepartment").empty();
                    $("#newMachine").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.intDeptID+'">'+o.strDeptName+'</option>';
                    });
                    $("#newDepartment").append(toAppend);
                    $('#newDepartment').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#newItemModal'),
                    });
                }
            });
        });

        $('#newDepartment').change(function(){
            $.ajax({
                url: '{!!url("/getBulkMappingAreaDeptSubDeptMachines")!!}',
                type: "GET",
                data: {
                    ID: $('#newDepartment').val(),
                    prompt: 'SubDepartments'
                },
                success: function (data) {
                    console.log(data);
                    var toAppend = '';
                    $("#newSubDepartment").empty();
                    $("#newMachine").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.intSubDeptID+'">'+o.strSubDeptName+'</option>';
                    });
                    $("#newSubDepartment").append(toAppend);
                    $('#newSubDepartment').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#newItemModal'),
                    });
                }
            });
        });

        $('#newSubDepartment').change(function(){
            $.ajax({
                url: '{!!url("/getBulkMappingAreaDeptSubDeptMachines")!!}',
                type: "GET",
                data: {
                    ID: $('#newSubDepartment').val(),
                    prompt: 'Machines'
                },
                success: function (data) {
                    console.log(data);
                    var toAppend = '';
                    $("#newMachine").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.intMachineID+'">'+o.strMachineName+'</option>';
                    });
                    $("#newMachine").append(toAppend);
                    $('#newMachine').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#newItemModal'),
                    });
                }
            });
        });

        $('#newUpkeepJob').change(function(){
            
                var JobsList = {!! json_encode($upkeepjobs) !!};
                var upkeepID = $('#newUpkeepJob').val();
                var strPastelCode = $('#newItem').val();

                if (upkeepID !== ''){
                    var result = $.grep(JobsList, function(e) {
                        return e.workOrderNo == upkeepID;
                    });

                    // console.log("-------------------------------------------- Job Info --------------------------------------------");
                    // console.log(result);

                    var AssetID = result[0].asset;
                    var LocationID = result[0].location;

                    $.ajax({
                        url: '{!!url("/getUpkeepJobAsset/")!!}'+'/'+AssetID,
                        type: "GET",
                        data: {
                        },
                        success: function (data) {
                            // console.log("-------------------------------------------- Asset Info --------------------------------------------");
                            // console.log(data);
                            if (data.success === true){
                                var MachineName = data.result.name;
                            }else{
                                alert(data.message);
                            }

                            $('#upkeepNewMachine').val(MachineName);

                            $.ajax({
                                url: '{!!url("/GetAreaDeptSubDeptByMachine")!!}',
                                type: "GET",
                                data: {
                                    MachineName: MachineName,
                                },
                                success: function (data) {
                                    // alert(data.length);
                                    if (data.length !== 0){
                                        $('#upkeepNewArea').val(data[0]['strAreaName']);
                                        $('#upkeepNewDepartment').val(data[0]['strDeptName']);
                                        $('#upkeepNewSubDepartment').val(data[0]['strSubDeptName']);
                                    }
                                    else{
                                        alert("The Machine needs to be mapped! Please contact IT.")
                                    }
                                }
                            });
                        }
                    });

                }
        });

        $('#closeCreateNewStockIssue').click(function(){
            $("#issuedto").val("None").trigger("change");
            $('#addNewItem').prop('disabled', true);
            var dataSource = itemsGrid.getDataSource();

            dataSource.store().clear();
            dataSource.reload();
        });

        $('#cancelNewStockItem').click(function(){
            $("#newType").val("").trigger("change");
            $("#newItemGroup").val("").trigger("change");
            $("#newItem").val("").trigger("change");
            $("#newQtyOnHand").val("").trigger("change");
            $("#newQtyRequired").val("").trigger("change");
            $("#newUpkeepJob").val("").trigger("change");
            $("#newPastelProject").val("").trigger("change");
            $("#newArea").val("").trigger("change");
            $("#newDepartment").val("").trigger("change");
            $("#newSubDepartment").val("").trigger("change");
            $("#newMachine").val("").trigger("change");

            $("#upkeepNewArea").val("").trigger("change");
            $("#upkeepNewMachine").val("").trigger("change");
            $("#upkeepNewDepartment").val("").trigger("change");
            $("#upkeepNewSubDepartment").val("").trigger("change");

        });

        $('.sidebar ul li a').on(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
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