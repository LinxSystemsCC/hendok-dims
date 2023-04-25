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
            z-index: 1051; /* or any higher value */
        }

        .select2-container--default .select2-dropdown--above {
            z-index: 1051; /* or any higher value */
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

<div class="col-lg-12"  style="background: white;">
    <div class="col-lg-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col-lg-10" >
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group w-50">
                    <label class="control-label" for="reference">Reference</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="reference" disabled>

                    <label class="control-label" for="issuedto">Issued to</label>

                    <select class="form-select mx-2" type="text" id='issuedto'>
                        <option></option>
                        @foreach ($users as $user)
                            <option value="{{ $user->EmployeeCode }}">{{ $user->FirstName }} {{ $user->LastName }}</option>
                        @endforeach
                    </select>
                </div>    

                {{-- <br>

                <button type="button" class="btn btn-success" data-bs-target="#newItemModal" data-bs-toggle="modal">ADD</button> 
                --}}
                <div class="form-group">
                    <div id="itemsGrid"></div>
                </div>
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <div class="col-md-6 mb-3">
                            <label for="newType" class="col-form-label">Stock Issue Type</label>
                            <select class="form-select mx-2" type="text" id='newType'>
                                <option></option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->intAutoID }}">{{ $type->strIssueType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newItemGroup" class="col-form-label">Item Group</label>
                            <select class="form-select mx-2" type="text" id='newType'>
                                <option></option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->strStockGroup }}">{{ $group->strStockGroupDesc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type3" class="col-form-label">Stock Issue Type 3</label>
                            <input type="text" class="form-control" id="type3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type4" class="col-form-label">Stock Issue Type 4</label>
                            <input type="text" class="form-control" id="type4">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type5" class="col-form-label">Stock Issue Type 5</label>
                            <input type="text" class="form-control" id="type5">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type6" class="col-form-label">Stock Issue Type 6</label>
                            <input type="text" class="form-control" id="type6">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type7" class="col-form-label">Stock Issue Type 7</label>
                            <input type="text" class="form-control" id="type7">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type8" class="col-form-label">Stock Issue Type 8</label>
                            <input type="text" class="form-control" id="type8">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type9" class="col-form-label">Stock Issue Type 9</label>
                            <input type="text" class="form-control" id="type9">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type10" class="col-form-label">Stock Issue Type 10</label>
                            <input type="text" class="form-control" id="type10">
                        </div>
                    </div>
                </form>           
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-target="#newStockModal" data-bs-toggle="modal">Cancel</button>
                <button type="button" id="savestockissue" class="btn btn-success" data-bs-target="#newStockModal" data-bs-toggle="modal">Insert</button>
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
        
        $('#savestockissue').click(function(){
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

        var types = ({!! json_encode($types) !!});
        var groups = ({!! json_encode($groups) !!});
        var stock = ({!! json_encode($stock) !!});
        var upkeepjobs = ({!! json_encode($upkeepjobs) !!});
        var areas = ({!! json_encode($areas) !!});
        var departments = ({!! json_encode($departments) !!});
        var subdepartments = ({!! json_encode($subdepartments) !!});
        var machines = ({!! json_encode($machines) !!});
        var pastelProjects = ({!! json_encode($pastelProjects) !!});

        // console.log(stock);
        var data = [];

        $("#itemsGrid").dxDataGrid({
            dataSource: data,
            hoverStateEnabled: true,
            showBorders: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            editing: {
                mode: "cell",
                allowAdding: true,
                allowUpdating: true,
                allowDeleting: true,
                popup: {
                    container: "#newStockModal",
                }
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
                        dataSource: stock,
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
        }).dxDataGrid("instance");

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

        // Adding New Lines!
        
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