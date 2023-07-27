<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

</head>

<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >
        <div class="col-lg-12 d-inline-flex" >
            <h3 style="flex-grow: 1; padding-left: 15px;">TRUCKS</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newTruck">
                New Truck
            </button>

        </div>
        
        <div id="gridContainer"></div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newTruck" tabindex="-1" aria-labelledby="newTruck" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">Create New Truck</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="TruckName" class="col-form-label">Fleet No</label>
                        <input type="text" class="form-control" id="TruckName">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="TruckReg" class="col-form-label">Truck Reg No.</label>
                        <input type="text" class="form-control" id="TruckReg">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="TruckCapacity" class="col-form-label">Truck Capacity</label>
                        <input type="number" class="form-control" id="TruckCapacity">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="TruckType" class="col-form-label">Truck Type</label>
                        <select class="form-select mx-2" type="text" id='TruckType'>
                            <option value="1">Articulated Horse</option>
                            <option value="2">Rigid</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="TruckModel" class="col-form-label">Truck Model</label>
                        <input type="text" class="form-control" id="TruckModel">
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveTruck" class="btn btn-success" >Save</button>
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
        var trucks = ({!! json_encode($readTrucksItems) !!});

        $('#saveTruck').click(function(){
            $.ajax({
                url: '{!!url("/addTrucksItem")!!}',
                type: "POST",
                data: {
                    TruckName: $('#TruckName').val(),
                    RegNo: $('#TruckReg').val(),
                    Capacity: $('#TruckCapacity').val(),
                    transportmodeid: $('#TruckType').val(),
                    model: $('#TruckModel').val(),
                    statement: 'Insert'
                },
                success: function (data)
                {
                    location.reload(true);
                }
            });
        });

        var transportType = [
            {
                'intType':1,
                'strType':'Articulated Horse'
            },{
                'intType':2,
                'strType':'Ridgid'
            }
        ]

        $("#gridContainer").dxDataGrid({
            dataSource:trucks, //as json
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
                const worksheet = workbook.addWorksheet('Trucks');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Trucks.xlsx');
                    });
                });
                e.cancel = true;
            },

            columns: [
                {
                    dataField: "TruckId",
                    caption: "ID",
                    allowEditing: false,
                },{
                    dataField: "TruckName",
                    caption: "Fleet No.",
                },{
                    dataField: "RegNo",
                    caption: "Truck Reg No.",
                },{
                    dataField: "Capacity",
                    caption: "Truck Capacity",
                },{
                    dataField: "intType",
                    caption: "Type ID",
                    lookup: {
                        dataSource: transportType,
                        valueExpr: "intType",
                        displayExpr: "strType",
                    },
                },{
                    dataField: "Model",
                    caption: "Model",
                }
            ],
            onRowUpdating: function(e){
                var TruckId = e.oldData.TruckId;
                var TruckName = e.newdata.TruckName || e.oldData.TruckName;
                var RegNo = e.newdata.RegNo || e.oldData.RegNo;
                var Capacity = e.newdata.Capacity || e.oldData.Capacity;
                var intType = e.newdata.intType || e.oldData.intType;
                var Model = e.newdata.Model || e.oldData.Model;
                
                $.ajax({
                    url: '{!!url("/editTrucksItem")!!}',
                    type: "POST",
                    data: {
                        TruckId: TruckId,
                        TruckName: TruckName,
						RegNo: RegNo,
						Capacity: Capacity,
                        transportmodeid: intType,
                        model: Model,
                        statement: 'Update'
                    },
                    success: function (data)
					{
						location.reload(true);
                    }
                });
            },
            onRowRemoving: function(e) {
                // var ID = e.data.DriverId;
                // var DriverName = e.data.DriverName;

                // $.ajax({
                //     url: '{!!url("/deleteItem")!!}',
                //     type: "POST",
                //     data: {
                //         DriverId: ID,
                //         statement: 'Delete'
                //     },
                //     success: function (data)
                //     {
                //         location.reload(true);
                //     }
                // });
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
