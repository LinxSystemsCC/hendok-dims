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
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newstock">
                New Stock Issue
            </button>
        </div>
        
        <div id="gridContainer"></div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal modal-xl fade" id="newstock" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">Create New Stock Issue</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group w-50">
                    <label class="control-label" for="reference">Reference</label>
                    <input type="text" class="form-control input-sm col-xs-1" id="reference" disabled>

                    <label class="control-label" for="issuedto">Issued to</label>
                    <select type="text" class="form-select input-sm col-xs-1" id="issuedto">
                        <option></option>
                    </select>
                </div>      
                <div class="form-group">
                    <div id="itemsGrid"></div>
                </div>
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="savesareaname" class="btn btn-success" >Save</button>
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

    #gridContainer {
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

        $('#saveStockIssue').click(function(){

            $.ajax({

                url: '{!!url("/savestockissue")!!}',
                type: "POST",
                data: {

                },
                success: function (data) {
                    location.reload();
                }

            });

        });

        var data = [];
        var categories = [
            {
                "name":"icecream",
                "id":1,
            },
            {
            "name": "Aurora",
            "id": 51
            },
            {
            "name": "Maximilian",
            "id": 52
            },
            {
            "name": "Niamh",
            "id": 53
            },
            {
            "name": "Orson",
            "id": 54
            },
            {
            "name": "Eliana",
            "id": 55
            },
            {
            "name": "Elio",
            "id": 56
            },
            {
            "name": "Aaliyah",
            "id": 57
            },
            {
            "name": "Zayn",
            "id": 58
            },
            {
            "name": "Maddison",
            "id": 59
            },
            {
            "name": "Khalil",
            "id": 60
            },
            {
            "name": "Tia",
            "id": 61
            },
            {
            "name": "Carmela",
            "id": 66
            },
            {
            "name": "Kaidence",
            "id": 67
            },
            {
            "name": "Emmet",
            "id": 68
            },
            {
            "name": "Malcolm",
            "id": 69
            },
            {
            "name": "Gloria",
            "id": 70
            },
            {
            "name": "Nathanael",
            "id": 71
            },
            {
            "name": "Lilith",
            "id": 72
            },
            {
            "name": "Jovani",
            "id": 73
            },
            {
            "name": "Karlie",
            "id": 74
            },
            {
            "name": "Truman",
            "id": 75
            },
            {
            "name": "Astrid",
            "id": 76
            },
            {
            "name": "Rome",
            "id": 77
            },
            {
            "name": "Naya",
            "id": 78
            },
            {
            "name": "Marlon",
            "id": 79
            },
            {
            "name": "Scarlette",
            "id": 80
            },
            {
            "name": "Kye",
            "id": 81
            },
            {
            "name": "Kensington",
            "id": 82
            },
            {
            "name": "Alaya",
            "id": 83
            },
            {
            "name": "Harper",
            "id": 84
            },
            {
            "name": "Brock",
            "id": 85
            },
            {
            "name": "Rubi",
            "id": 86
            },
            {
            "name": "Colson",
            "id": 87
            },
            {
            "name": "Averi",
            "id": 88
            },
            {
            "name": "Darian",
            "id": 89
            },
            {
            "name": "Lennon",
            "id": 90
            },
            {
            "name": "Jaida",
            "id": 91
            },
            {
            "name": "Maison",
            "id": 92
            },
            {
            "name": "Charleigh",
            "id": 93
            },
            {
            "name": "Aurora",
            "id": 51
            },
            {
            "name": "Maximilian",
            "id": 52
            },
            {
            "name": "Niamh",
            "id": 53
            },
            {
            "name": "Orson",
            "id": 54
            },
            {
            "name": "Eliana",
            "id": 55
            },
            {
            "name": "Elio",
            "id": 56
            },
            {
            "name": "Aaliyah",
            "id": 57
            },
            {
            "name": "Zayn",
            "id": 58
            },
            {
            "name": "Maddison",
            "id": 59
            },
            {
            "name": "Khalil",
            "id": 60
            },
            {
            "name": "Tia",
            "id": 61
            },
            {
            "name": "Preston",
            "id": 62
            },
            {
            "name": "Kashton",
            "id": 63
            },
            {
            "name": "Anabelle",
            "id": 64
            },
            {
            "name": "Deacon",
            "id": 65
            },
            {
            "name": "Carmela",
            "id": 66
            },
            {
            "name": "Kaidence",
            "id": 67
            },
            {
            "name": "Emmet",
            "id": 68
            },
            {
            "name": "Malcolm",
            "id": 69
            },
            {
            "name": "Gloria",
            "id": 70
            },
            {
            "name": "Nathanael",
            "id": 71
            },
            {
            "name": "Lilith",
            "id": 72
            },
            {
            "name": "Jovani",
            "id": 73
            },
            {
            "name": "Karlie",
            "id": 74
            },
            {
            "name": "Truman",
            "id": 75
            },
            {
            "name": "Astrid",
            "id": 76
            },
            {
            "name": "Rome",
            "id": 77
            },
            {
            "name": "Naya",
            "id": 78
            },
            {
            "name": "Marlon",
            "id": 79
            },
            {
            "name": "Scarlette",
            "id": 80
            },
            {
            "name": "Kye",
            "id": 81
            },
            {
            "name": "Kensington",
            "id": 82
            },
            {
            "name": "Alaya",
            "id": 83
            },
            {
            "name": "Harper",
            "id": 84
            },
            {
            "name": "Brock",
            "id": 85
            },
            {
            "name": "Rubi",
            "id": 86
            },
            {
            "name": "Colson",
            "id": 87
            },
            {
            "name": "Averi",
            "id": 88
            },
            {
            "name": "Darian",
            "id": 89
            },
            {
            "name": "Lennon",
            "id": 90
            },
            {
            "name": "Jaida",
            "id": 91
            },
            {
            "name": "Maison",
            "id": 92
            },
            {
            "name": "Charleigh",
            "id": 93
            },
        ];

        var categoriesStore = new DevExpress.data.ArrayStore({
            key: "id",
            data: categories
        });

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
        mode: "popup",
        allowAdding: true,
        allowUpdating: true,
        allowDeleting: true,
        popup: {
            //... other popup options ...
            container: "#newstock" // Set container to the ID of the Bootstrap modal's element
        }
    },

    columns: [
        {
            dataField: "strIssueType",
            caption: "Type",
            lookup: {
                dataSource: categoriesStore,
                valueExpr: "id",
                displayExpr: "name",
                allowClearing: true,
                searchEnabled: true,
                searchExpr: "name",
            },
        },
        {
            dataField: "strGroup",
            caption: "Item Group",
        },
        {
            dataField: "strPastelCode",
            caption: "Item Code",
        },
        {
            dataField: "strPastelDescription",
            caption: "Item Desc",
        },
        {
            dataField: "intInStockQty",
            caption: "In Stock",
        },
        {
            dataField: "intQtyRequired",
            caption: "Required",
            allowEditing: true,
        },
        {
            dataField: "strUpkeepId",
            caption: "Upkeep Job",
        },
        {
            dataField: "intArea",
            caption: "Area",
        },
        {
            dataField: "intDept",
            caption: "Dept",
        },
        {
            dataField: "intSubDept",
            caption: "Sub Dept",
        },
        {
            dataField: "intMachine",
            caption: "Machine",
        },
        {
            dataField: "strPastelProject",
            caption: "Pastel Project",
        },
    ],

    onRowUpdating: function(e){

    },

    onRowRemoving: function(e) {

    },
    
    onCellPrepared: function(e) {
        if (e.rowType === 'data' && e.column.dataField === 'strIssueType' && e.cellElement) {
            $(e.cellElement).dxLookup({
                searchValue: e.text,
                searchOperation: 'contains',
            });
        }
    },
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
                        allowUpdating: true,
                        allowDeleting: true,
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
                            dataField: "intAutoID",
                            caption: "ID",
                        },{
                            dataField: "strPastelCode",
                            caption: "Item Code",
                        },{
                            dataField: "strPastelDesc",
                            caption: "Item Description",
                        },{
                            dataField: "mnyQty",
                            caption: "Qty on Hand",
                        },{
                            dataField: "MinLevel",
                            caption: "Min Level",
                        },{
                            dataField: "MaxLevel",
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
