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
    
        .select2-container{
            z-index: 5000;
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
        <div class="col-lg-12 d-inline-flex">
            <h3>Galv Report</h3>
        </div>
        
        <div id="gridContainer" style=""></div>
        
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Excel Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

<!-- File Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>

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
        var data = {!! json_encode($data) !!};

        $("#gridContainer").dxDataGrid({
            dataSource:data, //as json
            showBorders: true,
            hoverStateEnabled: true,
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
            editing:{
                mode: 'form',
                // allowUpdating: true,
                // allowAdding: true,
                // allowDeleting: true,
                useIcons: true,
            },
            export: {
                enabled: true,
            },
            onExporting(e) {
                var currentDate = new Date();
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Galv Report');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Galv Report - '+currentDate+'.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [
                {
                    dataField : 'dtmSaved',
                    caption : 'Time',
                },
                {
                    dataField : 'strShift',
                    caption : 'Shift',
                },
                {
                    dataField : 'strDepartment',
                    caption : 'Department',
                },
                {
                    dataField : 'strMachine',
                    caption : 'Machine',
                },
                {
                    dataField : 'intJobNo',
                    caption : 'Job No.',
                },
                {
                    dataField : 'intSeqNo',
                    caption : 'Seq No.',
                },
                {
                    dataField : 'intTestNo',
                    caption : 'Test No.',
                },
                {
                    dataField : 'strCustomer',
                    caption : 'Customer',
                },
                {
                    dataField : 'strProductName',
                    caption : 'Product',
                },
                {
                    dataField : 'strQCPhase',
                    caption : 'Phase',
                },
                {
                    dataField : 'strWireTol',
                    caption : 'Wire Tol',
                },
                {
                    dataField : 'intWireTest',
                    caption : 'Wire Tested',
                    dataType: 'number',
                    format: {type: "fixedPoint", precision: 2}
                },
                {
                    dataField : 'strZincSpec',
                    caption : 'Zinc Spec',
                },
                {
                    dataField : 'intZincTest',
                    caption : 'Zinc Tested',
                },
                {
                    dataField : 'strMPASpec',
                    caption : 'MPA Spec',
                },
                {
                    dataField : 'intMPATest',
                    caption : 'MPA Tested',
                },
                {
                    dataField : 'intElongTest',
                    caption : 'Elongation Tested',
                },
                {
                    dataField : 'intTorsionTest',
                    caption : 'Torsion Tested',
                },
                {
                    dataField : 'intStressTest',
                    caption : 'Stress Tested',
                },
                {
                    dataField : 'intWrapTest',
                    caption : 'Dia Wrap Tested',
                },
                {
                    dataField : 'intWeight',
                    caption : 'Weight',
                },
                {
                    dataField : 'strCastNo',
                    caption : 'CasNo',
                },
                {
                    dataField : 'strTicket',
                    caption : 'Ticket',
                },
                {
                    dataField : 'strOldTicket',
                    caption : 'Old Ticket',
                },
                {
                    dataField : 'strPassFail',
                    caption : 'Status',
                },
                {
                    dataField : 'strComment1',
                    caption : 'Comment 1',
                },
                {
                    dataField : 'strComment2',
                    caption : 'Comment 2',
                },
                {
                    dataField : 'strComment3',
                    caption : 'Comment 3',
                },
                {
                    dataField : 'strRegrade',
                    caption : 'Regraded',
                },
                {
                    dataField : 'strStockChange',
                    caption : 'Stock Changed',
                },
                {
                    dataField : 'strOperator',
                    caption : 'Operator',
                },
            ],

            onRowClick:function(e){

            },
            onRowRemoved(e){

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
