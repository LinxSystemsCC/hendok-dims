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
            <h3>Galv Products</h3>
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
        console.log(data);

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
                mode: 'popup',
                allowUpdating: true,
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
                const worksheet = workbook.addWorksheet('Galv Products');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Galv Products - '+currentDate+'.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [
                { 
                    type: "buttons" 
                },
                {
                    dataField: 'ProductID',
                    caption: 'ID',
                    allowEditing: false,
                    dataType: 'number'
                },
                {
                    dataField: 'ProductName',
                    caption: 'Name',
                    dataType: 'string'
                },
                {
                    dataField: 'WireSize',
                    caption: 'Wire Size',
                    dataType: 'number',
                    format: {type: "fixedPoint", precision: 2}
                },
                {
                    dataField: 'SizeTolerance',
                    caption: 'Size Tolerance',
                    dataType: 'string'
                },
                {
                    dataField: 'Type',
                    caption: 'Type',
                    dataType: 'string'
                },
                {
                    dataField: 'MPATolerance',
                    caption: 'MPA Tolerance',
                    dataType: 'string'
                },
                {
                    dataField: 'ZincSpec',
                    caption: 'Zinc spec',
                    dataType: 'string'
                },
                {
                    dataField: 'Gas',
                    caption: 'Gas',
                    dataType: 'string'
                },
                {
                    dataField: 'LedDip',
                    caption: 'Led Dip',
                    dataType: 'string'
                },
                {
                    dataField: 'DV',
                    caption: 'DV',
                    dataType: 'string'
                },
                {
                    dataField: 'RodSize',
                    caption: 'Rod Size',
                    dataType: 'string'
                },
                {
                    dataField: 'RodType',
                    caption: 'Rod Type',
                    dataType: 'string'
                },
                {
                    dataField: 'SECode',
                    caption: 'SE Code',
                    dataType: 'string'
                },
                {
                    dataField: 'CustomerName',
                    caption: 'Customer',
                    dataType: 'string'
                },
                {
                    dataField: 'WDBlackTol',
                    caption: 'WD Black Tolerance',
                    dataType: 'string'
                },
                {
                    dataField: 'GalvRPM',
                    caption: 'Galv RPM',
                    dataType: 'string'
                },
                {
                    dataField: 'QCStrict',
                    caption: 'QC Strict',
                    dataType: 'boolean',
                },
                {
                    dataField: 'strProductApplication',
                    caption: 'Product Application',
                    dataType: 'string'
                },
                {
                    dataField: 'strRodTreatment',
                    caption: 'Rod Treatment',
                    dataType: 'string'
                },
                {
                    dataField: 'intStressTest',
                    caption: 'Stress Test Spec',
                    dataType: 'number'
                },
                {
                    dataField: 'intElongation',
                    caption: 'Elongation Spec',
                    dataType: 'number'
                },
                {
                    dataField: 'strLeadBathDip',
                    caption: 'Lead Bath Dip',
                    dataType: 'string'
                },
                {
                    dataField: 'strZincCoatingMinMax',
                    caption: 'Zinc Coating Tolerance',
                    dataType: 'string'
                },
                {
                    dataField: 'strCoatingUniformity',
                    caption: 'Coating Uniformity',
                    dataType: 'string'
                },
                {
                    dataField: 'strCoatingAdhesion',
                    caption: 'Coating Adhesion',
                    dataType: 'string'
                },
                {
                    dataField: 'strLabelling',
                    caption: 'Labelling',
                    dataType: 'string'
                },
                {
                    dataField: 'intMaxWelds',
                    caption: 'Max Welds',
                    dataType: 'number'
                },
                {
                    dataField: 'strPackagingRequirements',
                    caption: 'Packaging Requirements',
                    dataType: 'string'
                },
                {
                    dataField: 'strSpecialInstructions',
                    caption: 'Special Instructions',
                    dataType: 'string'
                },
                {
                    dataField: 'boolStrictDiameterTolerance',
                    caption: 'Strict Diameter Tolerance',
                    dataType: 'boolean'
                },
                {
                    dataField: 'boolStrictTensileStrength',
                    caption: 'Strict Tensile Strength',
                    dataType: 'boolean'
                },
                {
                    dataField: 'boolStrictStressTest',
                    caption: 'Strict Stress Test',
                    dataType: 'boolean'
                },
                {
                    dataField: 'boolStrictElongation',
                    caption: 'Strict Elongation Test',
                    dataType: 'boolean'
                },
                {
                    dataField: 'boolStrictZincCoatingMinMax',
                    caption: 'Strict Zinc Coating',
                    dataType: 'boolean'
                },
                {
                    dataField: 'intNitroDieSize',
                    caption: 'Strict Nitro Die Size',
                    dataType: 'number'
                },
                {
                    dataField: 'boolStrictMaxWelds',
                    caption: 'Strict Max Welds',
                    dataType: 'boolean'
                },
            ],

            onRowClick:function(e){

            },
            onRowRemoved(e){

            },
            onRowUpdated(e){
                // console.log(e);
                var ProductID = e.data.ProductID
                var ProductName = e.data.ProductName
                var WireSize = e.data.WireSize
                var SizeTolerance = e.data.SizeTolerance
                var Type = e.data.Type
                var MPATolerance = e.data.MPATolerance
                var ZincSpec = e.data.ZincSpec
                var Gas = e.data.Gas
                var LedDip = e.data.LedDip
                var DV = e.data.DV
                var RodSize = e.data.RodSize
                var RodType = e.data.RodType
                var SECode = e.data.SECode
                var CustomerName = e.data.CustomerName
                var WDBlackTol = e.data.WDBlackTol
                var GalvRPM = e.data.GalvRPM
                var QCStrict = e.data.QCStrict
                var strProductApplication = e.data.strProductApplication
                var strRodTreatment = e.data.strRodTreatment
                var intStressTest = e.data.intStressTest
                var intElongation = e.data.intElongation
                var strLeadBathDip = e.data.strLeadBathDip
                var strZincCoatingMinMax = e.data.strZincCoatingMinMax
                var strCoatingUniformity = e.data.strCoatingUniformity
                var strCoatingAdhesion = e.data.strCoatingAdhesion
                var strLabelling = e.data.strLabelling
                var intMaxWelds = e.data.intMaxWelds
                var strPackagingRequirements = e.data.strPackagingRequirements
                var strSpecialInstructions = e.data.strSpecialInstructions
                var boolStrictDiameterTolerance = e.data.boolStrictDiameterTolerance
                var boolStrictTensileStrength = e.data.boolStrictTensileStrength
                var boolStrictStressTest = e.data.boolStrictStressTest
                var boolStrictElongation = e.data.boolStrictElongation
                var boolStrictZincCoatingMinMax = e.data.boolStrictZincCoatingMinMax
                var intNitroDieSize = e.data.intNitroDieSize
                var boolStrictMaxWelds = e.data.boolStrictMaxWelds

                $.ajax({
                    url: '{!!url("/updateGalvProduct")!!}',
                    type: "POST",
                    data: {
                        ProductID : ProductID,
                        ProductName : ProductName,
                        WireSize : WireSize,
                        SizeTolerance : SizeTolerance,
                        Type : Type,
                        MPATolerance : MPATolerance,
                        ZincSpec : ZincSpec,
                        Gas : Gas,
                        LedDip : LedDip,
                        DV : DV,
                        RodSize : RodSize,
                        RodType : RodType,
                        SECode : SECode,
                        CustomerName : CustomerName,
                        WDBlackTol : WDBlackTol,
                        GalvRPM : GalvRPM,
                        QCStrict : QCStrict,
                        strProductApplication : strProductApplication,
                        strRodTreatment : strRodTreatment,
                        intStressTest : intStressTest,
                        intElongation : intElongation,
                        strLeadBathDip : strLeadBathDip,
                        strZincCoatingMinMax : strZincCoatingMinMax,
                        strCoatingUniformity : strCoatingUniformity,
                        strCoatingAdhesion : strCoatingAdhesion,
                        strLabelling : strLabelling,
                        intMaxWelds : intMaxWelds,
                        strPackagingRequirements : strPackagingRequirements,
                        strSpecialInstructions : strSpecialInstructions,
                        boolStrictDiameterTolerance : boolStrictDiameterTolerance,
                        boolStrictTensileStrength : boolStrictTensileStrength,
                        boolStrictStressTest : boolStrictStressTest,
                        boolStrictElongation : boolStrictElongation,
                        boolStrictZincCoatingMinMax : boolStrictZincCoatingMinMax,
                        intNitroDieSize : intNitroDieSize,
                        boolStrictMaxWelds : boolStrictMaxWelds,
                    },
                    success: function (data) {
                        location.reload();
                    }

                    });
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
