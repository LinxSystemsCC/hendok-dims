<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
    <title>Re-Print</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

</head>

<body>
<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2" style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>


    <div class="col p-3" >
        <div class="col-lg-10" id="tabs">
            {{-- @if($nwo !="0")
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createjob" style="margin-right:10px;">New Work Order</button>
            @endif --}}

            {{-- @if($nwo !="0")
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#finalisejob" style="margin-right:10px;" id="completejob" disabled>Complete Job</button>
            @endif --}}

            {{-- @if($qc1 !="0")
            <button type="button" id="qcphase1" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">QC Phase 1 </button>
            @endif --}}

            {{-- @if($qc2 !="0")
            <button type="button" id="qcphase2" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">QC Phase 2</button>
            @endif --}}

            {{-- @if($weight !="0")
            <button type="button" id="weigh" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Weigh</button>
            @endif --}}
            
            {{-- @if($print !="0")
            <button type="button" id="print" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Re-Print</button>
            @endif --}}

            {{-- <button type="button" id="scrapweigh" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Scrap Weighing</button> --}}

            {{-- @if($regrade !="0")
            <button type="button" id="regrade" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Regrade</button>
            @endif --}}

            {{-- @if($sc !="0")
            <button type="button" id="stockchange" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Stock Change</button>
            @endif --}}

            {{-- @if($retest !="0")
            <button type="button" id="retest" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Re-Test</button>
            @endif --}}
            <h3 style="flex-grow: 1;">Re-Print</h3>

        </div>

        <div id="gridContainer" style="width: 100% !important;">
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

    .dx-checkbox-checked .dx-checkbox-icon {
        background-color: #df2413 !important;
    }

    .dx-checkbox-indeterminate .dx-checkbox-icon {
        background-color: #fff;
        border: 2px solid rgba(0,0,0,.54);
    }

    .dx-selection {
        background-color: #df2413; /* Specify the desired background color */
        font-weight: 700;
        /* Additional styles */
    }


    .dx-datagrid {
        height: calc(100vh - 78px);
        max-height: calc(100vh - 78px);
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
        var jobs = ({!! json_encode($jobs) !!});

        $("#gridContainer").dxDataGrid({
            dataSource:jobs, //as json
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
                pageSize: 20,
            },
            pager: {
                visible: true,
                allowedPageSizes: [5, 10, 20, 50, 'all'],
                showPageSizeSelector: true,
                showInfo: true,
                showNavigationButtons: true,
            },
            selection: {
                mode: "single",
                rowCssClass: 'custom-selected-row'
            },
            columns: [
                {
                    dataField: "intJobId",
                    caption: "Id",
                },{
                    dataField: "strRef",
                    caption: "SO Number",
                }, {
                    dataField: "strCustomerName",
                    caption: "Customer Name",
                }, 
                {
                    dataField: "strItemCode",
                    caption: "Product Code",
                },
                {
                    dataField: "Description_1",
                    caption: "Product Description",
                },
                {
                    dataField: "intPackSize",
                    caption: "Pack Size",
                },
                {
                    dataField: "dteJobCreated",
                    caption: "Date",
                },
            ],

            onRowDblClick:function(e){
                var intJobId = e.data.intJobId;
                window.open('{!!url("/printRoofingLabel")!!}/'+intJobId,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");
            },
            onRowClick:function(e){

            },
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
</body>
