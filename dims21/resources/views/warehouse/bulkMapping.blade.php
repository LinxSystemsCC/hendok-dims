<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

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

    <style>
		.col-lg-2, .col-lg-10 {
			min-height: 100vh;
		}

        .col-lg-10{
            max-width: 100% !important;
        }

        h3{
            padding-left: 0px !important;
        }
	</style>
</head>
<body>
    <div class="container-fluid">
		<div class="row">
			<div class="col-lg-2">
                <div class="vertical-menu">
                    @include('warehouse.menu')
                </div>
			</div>
            <div class="col-lg-10" >
                <div class="col-lg-12 d-inline-flex" >
                    <h3 style="flex-grow: 1; padding-left: 15px;">BULK MAPPING</h3>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newMapping">
                        New Mapping
                    </button>
                </div>
                
                <div id="bulkMappingGrid"></div>
                
            </div>
		</div>
	</div>
</body>

<!-- Modal New Mapping -->
<div class="modal fade" id="newMapping" aria-labelledby="newMapping" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newMapping">New Mapping</h1>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="area" class="col-form-label">Area</label>
                            <select class="form-select" type="text" id='area'>
                                <option value="NULL">None</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->intAutoID }}">{{ $area->strAreaName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="department" class="col-form-label">Department</label>
                            <select class="form-select" type="text" id='department'>
                                <option value="NULL">None</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->intAutoID }}">{{ $department->strDeptName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="subdepartment" class="col-form-label">Sub Department</label>
                            <select class="form-select" type="text" id='subdepartment'>
                                <option value="NULL">None</option>
                                @foreach ($subdepartments as $subdepartment)
                                    <option value="{{ $subdepartment->intAutoID }}">{{ $subdepartment->strSubDeptName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="machine" class="col-form-label">Machines</label>
                            <select class="form-select" type="text" id='machine'>
                                <option value="NULL">None</option>
                                @foreach ($machines as $machine)
                                    <option value="{{ $machine->intAutoMachineID }}">{{ $machine->strMachineName }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveMapping" class="btn btn-success" >Save</button>
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
        height: calc(100vh - 63px);
        max-height: calc(100vh - 63px);
    }
</style>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

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
        var mappings = ({!! json_encode($mappings) !!});

        $('#area').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newMapping'),
        });

        $('#department').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newMapping'),
        });

        $('#subdepartment').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newMapping'),
        });

        $('#machine').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newMapping'),
        });

        $("#department").change(function(){
            var ID = $("#department").val();
            var prompt = 'department';
            $.ajax({
                url: '{!!url("/checkBulkMapping")!!}',
                type: "GET",
                data: {
                    ID: ID,
                    prompt: prompt,
                },
                success: function (data) {
                    console.log(data);
                    if (data[0]['intAreaID'] === null){
                        alert("This Department is being mapped for the first time.");
                    }else{
                        $('#area').val(data[0]['intAreaID']).trigger("change");
                    }
                }
            });
        });

        $("#subdepartment").change(function(){
            var ID = $("#subdepartment").val();
            var prompt = 'subdepartment';
            $.ajax({
                url: '{!!url("/checkBulkMapping")!!}',
                type: "GET",
                data: {
                    ID: ID,
                    prompt: prompt,
                },
                success: function (data) {
                    console.log(data);
                    if (data[0]['intAreaID'] === null){
                        alert("This Sub Department is being mapped for the first time.");
                    }else{
                        $('#area').val(data[0]['intAreaID']).trigger("change");
                        $('#department').val(data[0]['intDeptID']).trigger("change");
                    }
                }
            });
        });

        // $("#machine").change(function(){
        //     var ID = $("#machine").val();
        //     var prompt = 'machine';
        //     $.ajax({
        //         url: '{!!url("/checkBulkMapping")!!}',
        //         type: "GET",
        //         data: {
        //             ID: ID,
        //             prompt: prompt,
        //         },
        //         success: function (data) {
        //             alert(data);
        //         }
        //     });
        // });

        $('#saveMapping').click(function(){
            // alert("Saving mappings has not been set up yet!")
            $.ajax({
                url: '{!!url("/bulkMappingCRUD")!!}',
                type: "POST",
                data: {
                    area: $('#area').val(),
                    department: $('#department').val(),
                    subdepartment: $('#subdepartment').val(),
                    machine: $('#machine').val(),
                    ID: 0,
                    prompt: 'insert',
                },
                success: function (data) {
                    if (data[0]['Result'] === 'Success'){
                        location.reload();
                    }else{
                        alert(data[0]['Result']);
                    }
                }
            });
        });

        $("#bulkMappingGrid").dxDataGrid({
            dataSource:mappings, //as json
            hoverStateEnabled: true,
            showBorders: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            scrolling: {
                rowRenderingMode: 'infinite',
            },
            paging:{
                pageSize: 50,
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
                allowDeleting: true,
            },
            selection: {
                mode: 'single',
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('BulkMapping');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'BulkMapping.xlsx');
                    });
                });
                e.cancel = true;
            },

            columns: [
                {
                    dataField: "strAreaName",
                    caption: "Area",
                    // groupIndex: 0,
                }, 
                {
                    dataField: "strDeptName",
                    caption: "Department",
                    // groupIndex: 1,
                },
                {
                    dataField: "strSubDeptName",
                    caption: "Sub Department",
                    // groupIndex: 2,
                },
                {
                    dataField: "strMachineName",
                    caption: "Machine",
                }
            ],
            onRowUpdating: function(e){
                alert("Updating Has Not been implemented Yet!")
            },
            onRowRemoving: function(e) {
                alert("Removing Has Not been implemented Yet!")
            },
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
    }
</script>
