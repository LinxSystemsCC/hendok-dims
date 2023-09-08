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
            <h3 style="flex-grow: 1; padding-left: 15px;">NAILS INNER</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newNail">
                New Nail Type
            </button>
        </div>
        
        <div id="gridContainer" style=""></div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newNail" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">Create New Nail Type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="code"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Code</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="code">
                </div>    
                <div class="form-group">
                    <label class="control-label" for="description"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Description</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="description">
                </div> 
                <div class="form-group">
                    <label class="control-label" for="group"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Group</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="group">
                </div> 
                <div class="form-group">
                    <label class="control-label" for="labelDescription"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Label Description</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="labelDescription">
                </div> 
                <div class="form-group">
                    <label class="control-label" for="size"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Size</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="size">
                </div> 
                <div class="form-group">
                    <label class="control-label" for="packsize"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Pack Size Outer</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="packsize">
                </div> 
                <div class="form-group">
                    <label class="control-label" for="label"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Label</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="label">
                </div> 
                <div class="form-group">
                    <label class="control-label" for="coating"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Coating</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="coating">
                </div> 
                <div class="form-group">
                    <label class="control-label" for="barcode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Barcode</label>
                    <input  type="text" class="form-control input-sm col-xs-1" id="barcode">
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveNail" class="btn btn-success" >Save</button>
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
        var nails = ({!! json_encode($nails) !!});

        $('#saveNail').click(function(){

            $.ajax({
                url: '{!!url("/nailsInnerCrud")!!}',
                type: "POST",
                data: {
                    code: $('#code').val(),
                    description: $('#description').val(),
                    group: $('#group').val(),
                    labelDescription: $('#labelDescription').val(),
                    size: $('#size').val(),
                    packsize: $('#packsize').val(),
                    label: $('#label').val(),
                    coating: $('#coating').val(),
                    barcode: $('#barcode').val(),
                    prompt: 'Insert',
                    ID: 0,
                },
                success: function (data) {
                    alert(data[0]['Result']);
                    location.reload();
                }
            });
        });

        $("#gridContainer").dxDataGrid({
            dataSource: nails, //as json
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
                allowUpdating: true,
                allowDeleting: true,
            },
            selection: {
                mode: 'single',
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Areas');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Areas.xlsx');
                    });
                });
                e.cancel = true;
            },

            columns: [
                {
                    dataField: "intAutoID",
                    caption: "ID",
                    allowEditing: false,
                }, {
                    dataField: "Code",
                    caption: "Code",
                }, {
                    dataField: "Description_1",
                    caption: "Description",
                },{
                    dataField: "ItemGroup",
                    caption: "Group",
                },{
                    dataField: "ucIILabelHeader",
                    caption: "Label Description",
                },{
                    dataField: "ucIILabelDescription",
                    caption: "Size",
                },{
                    dataField: "ucIILabelDescription2",
                    caption: "Pack Size Outer",
                },{
                    dataField: "ulIISingleLabel",
                    caption: "Lable",
                },{
                    dataField: "ucIIZincCoating",
                    caption: "Coating",
                },{
                    dataField: "Barcode",
                    caption: "Barcode",
                },{
                    dataField: "dtmCreated",
                    caption: "Date Time",
                    allowEditing: false,
                },
            ],
            onRowUpdating: function(e){
                var ID = e.oldData.intAutoID;
                var code = e.newData.Code || e.oldData.Code;
                var description = e.newData.Description_1 || e.oldData.Description_1;
                var group = e.newData.ItemGroup || e.oldData.ItemGroup;
                var labelDescription = e.newData.ucIILabelHeader || e.oldData.ucIILabelHeader;
                var size = e.newData.ucIILabelDescription || e.oldData.ucIILabelDescription;
                var packsize = e.newData.ucIILabelDescription2 || e.oldData.ucIILabelDescription2;
                var label = e.newData.ulIISingleLabel || e.oldData.ulIISingleLabel;
                var coating = e.newData.ucIIZincCoating || e.oldData.ucIIZincCoating;
                var barcode = e.newData.Barcode || e.oldData.Barcode;
                
                $.ajax({
                    url: '{!!url("/nailsInnerCrud")!!}',
                    type: "POST",
                    data: {
                        code: code,  
                        description: description,  
                        group: group,  
                        labelDescription: labelDescription,  
                        size: size,  
                        packsize: packsize,  
                        label: label,  
                        coating: coating,  
                        barcode: barcode,  
                        prompt: 'Update',
                        ID: ID,
                    },
                    success: function (data) {
                        alert(data[0]['Result']);
                        location.reload();
                    }
                });
            },
            onRowRemoving: function(e) {
                var ID = e.data.intAutoID;
                var code = e.data.strPastelCode;

                $.ajax({
                    url: '{!!url("/nailsInnerCrud")!!}',
                    type: "POST",
                    data: {
                        code: code,
                        description: 'NA',
                        group: 'NA',
                        labelDescription: 'NA',
                        size: 'NA',
                        packsize: 'NA',
                        label: 'NA',
                        coating: 'NA',
                        barcode: 'NA',
                        prompt: 'Delete',
                        ID: ID,
                    },
                    success: function (data) {
                        alert(data[0]['Result']);
                        location.reload();
                    }
                });
            }
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
