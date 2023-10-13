<?php
if ((Auth::guest()))
{
}else{
    $v  =  new \App\Http\Controllers\SalesForm();
}
$nwor = $v->getThingsUserPermissions(Auth::user()->UserID,'New Work Order Roof');
$ppso = $v->getThingsUserPermissions(Auth::user()->UserID,'Pre Planning SO');
$print = $v->getThingsUserPermissions(Auth::user()->UserID,'Roof Print');
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.compact.css" rel="stylesheet">


    <style>
        .dx-datagrid{
            max-width: 100% !important;
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
    
        #ppsoGrid{
            height: calc(100vh - 265px);
        }
    
        #headergrid{
            max-height: 500px;
            min-height: 500px;
        }
    
        #linesgrid{
            max-height: 500px;
            min-height: 500px;
        }
    
    </style>

</head>

<body>
    <div class="col-12 d-flex px-0 vh-100"  style="background: white;">
        <div class="col-custom-2 h-100" style="background: white;">

            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>

        <div class="col-custom-10 p-2 mh-100 overflow-auto">
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1" role="tab" aria-controls="content1" aria-selected="true">Pre Plan SO's</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2" role="tab" aria-controls="content2" aria-selected="true">Batch SO Processing</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3" role="tab" aria-controls="content3" aria-selected="true" >Batch Progression</a>
                </li>
            </ul>
            
            <div class="tab-content p-2 w-100" id="tabs">
                {{-- Pre Planned Sales Orders Page --}}
                <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1">

                    <h3>Pre Plan Sales Orders</h3>

                    <button class="btn btn-primary" id="refresh">REFRESH</button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mulkMapModal">BULK SELECTION</button>

                    <div id="ppsoGrid" class="py-2"></div>

                    <div class="form-group">
                        <label class="control-label" for="reference"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Reference </label>
                        <input type="text"  class="form-control input-sm col-xs-1" id="reference" required>
                    </div>

                    <button class="btn btn-success" id="savePPSO" style="width: 100%;">SAVE</button>


                </div>

                {{--  Batch Sales Order Processing Page --}}
                <div class="tab-pane fade" id="content2" role="tabpanel" aria-labelledby="tab2">
                    <div class="d-inline-flex mb-2">
                        {{-- Date from --}}
                        <label class="d-flex align-items-center px-2 text-nowrap" for="datefromheader">Date From </label>
                        <input type="date" id="datefromheader" class="form-control">

                        {{-- Date To --}}
                        <label class="d-flex align-items-center px-2 text-nowrap ms-2" for="datetoheader">Date To </label>
                        <input type="date" id="datetoheader" class="form-control">
                        <button class="btn btn-primary ms-2" id="getheaders">SEARCH</button>
                    </div>
                    
                    <div id="headergrid"></div>
                    <div id="linesgrid" class="my-3"></div>

                    <button type="button" class="btn btn-success" id="saveBSOP" aria-label="Save">Save</button>

                </div>

                {{--  Batch Sequencing Page --}}
                <div class="tab-pane fade" id="content3" role="tabpanel" aria-labelledby="tab3">
                    <div id="sequencegrid" style="width: 50% !important; height:50%; padding-bottom: 10px;">
                    </div>
                </div>


            </div>
            
        </div>

        <!-- Modal New Stock -->
        <div class="modal modal-xl fade" id="mulkMapModal" aria-labelledby="mulkMapModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="mulkMapModal">Bulk Select Roofing Jobs</h1>
                    </div>

                    <div class="modal-body">
                        <div class="d-inline-flex w-100">
                            <div class="form-group col-4">
                                <label class="control-label" for="salesorders"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Sales Orders</label>
                                <textarea  type="text" rows="15" class="form-control input-sm col-xs-1" id="salesorders" required></textarea>
                            </div>
                            
                            <div class="form-group col-4 px-3">
                                <label class="control-label" for="invoiceorders"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Invoice Orders</label>
                                <textarea  type="text" rows="15" class="form-control input-sm col-xs-1" id="invoiceorders" required></textarea>
                            </div>

                            <div class="form-group col-4">
                                <label class="control-label" for="company"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Company</label>
                                <textarea  type="text" rows="15" class="form-control input-sm col-xs-1" id="company" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeBulkSelectModal">Close</button>
                        <button type="button" id="bulkSelect" data-bs-dismiss="modal" class="btn btn-success" >Select</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Dev Extreme -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

    <!-- Excel Saver -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

    <!-- File Saver -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    var batchID = 0;
    var batchReference = 0;

    $(document).ready(function() {
        var date = (new Date()).toISOString().slice(0, 10);
		$('#datefrom').val(date);
		$('#dateto').val(date);
        $('#datefromheader').val(date);
		$('#datetoheader').val(date);

        const machineslist = ({!! json_encode($machines) !!});
        machineslist.unshift({ intAutoMachineID: 0, strMachineName: "Unassigned" });

        const ppsoGrid = $("#ppsoGrid").dxDataGrid({
            dataSource:[], //as json
            showBorders: true,
            hoverStateEnabled: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            noDataText: 'Data Loading...',
            scrolling: {
                rowRenderingMode: 'infinite',
            },
            paging:{
                pageSize: 2000,
            },
            
            editing:{
                mode: 'form',
                useIcons: true,
            },
            selection: {
                mode: 'multiple',
            },
            export: {
                enabled: true,
            },
            onExporting(e) {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('RoofPlanning');

                DevExpress.excelExporter.exportDataGrid({
                    component: e.component,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'RoofPlanning.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [
                {
                    dataField: "intRowKey",
                    caption: "Key",
                    visible: false,
                },{
                    dataField: "RoofingCat",
                    caption: "Category",
                }, {
                    dataField: "RMCode",
                    caption: "Raw Material Code",
                    visible: false,
                }, {
                    dataField: "RMProduct",
                    caption: "Raw Material Description",
                }, {
                    dataField: "RMStockOnHand",
                    caption: "Stock On Hand",
                }, {
                    dataField: "ProductCode",
                    caption: "Product Code",
                    visible: false,
                }, {
                    dataField: "Product",
                    caption: "Product Description",
                }, {
                    dataField: "UnitWeight",
                    caption: "Unit Weight",
                    visible: false,
                }, {
                    dataField: "AccountNumber",
                    caption: "Account Number",
                }, {
                    dataField: "CustomerName",
                    caption: "Customer Name",
                }, {
                    dataField: "RepName",
                    caption: "Rep Name",
                }, {
                    dataField: "CustomerStatus",
                    caption: "Customer Status",
                }, {
                    dataField: "OrderNumber",
                    caption: "Order Number",
                }, {
                    dataField: "idInvoiceLines",
                    caption: "Invoice Number",
                }, {
                    dataField: "Company",
                    caption: "Company",
                }, {
                    dataField: "OrderDate",
                    caption: "Order Date",
                }, {
                    dataField: "DueDate",
                    caption: "Due Date",
                }, {
                    dataField: "QtyOrdered",
                    caption: "Qty Ordered",
                }, {
                    dataField: "QtyOutstanding",
                    caption: "Qty Outstanding",
                }, {
                    dataField: "TonsOutstanding",
                    caption: "Tons Outstanding",
                }, {
                    dataField: "PricePerTon",
                    caption: "Price Per Ton",
                    visible: false,
                }, {
                    dataField: "Area",
                    caption: "Area",
                }, {
                    dataField: "DeliveryInstructions",
                    caption: "Delivery Instructions",
                }, {
                    dataField: "OrderComplete",
                    caption: "Order Complete",
                    visible: false,
                }, {
                    dataField: "DateCompleted",
                    caption: "Date Completed",
                    visible: false,
                }, {
                    dataField: "NumberOfItemsCut",
                    caption: "Number Of Items Cut",
                    visible: false,
                }, {
                    dataField: "PartialCut",
                    caption: "Partial Cut",
                    visible: false,
                },

            ],
            summary: {
                totalItems: [{
                    column: "QtyOutstanding",
                    summaryType: 'sum',
                    valueFormat: { type: 'fixedPoint', precision: 2 },
                    displayFormat: '{0}',
                }, {
                    column: "TonsOutstanding",
                    summaryType: 'sum',
                    valueFormat: { type: 'fixedPoint', precision: 2 },
                    displayFormat: '{0}',
                }]
            },

            onRowClick:function(e){

            },
            onRowRemoved(e){

            },
        }).dxDataGrid('instance');

        const headergrid = $("#headergrid").dxDataGrid({
            dataSource:[], //as json
            showBorders: true,
            hoverStateEnabled: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            noDataText: 'No Sales Orders between the date range specified',
            scrolling: {
                mode: 'infinite',
            },
            paging:{
                pageSize: 10,
            },
            pager: {
                visible: true,
                allowedPageSizes: [5, 10, 20, 50],
                showPageSizeSelector: true,
                showInfo: true,
                showNavigationButtons: true,
            },
            editing:{
                mode: 'form',
                // allowUpdating: true,
                // allowAdding: true,
                allowDeleting: true,
                useIcons: true,
            },
            selection: {
                mode: 'single',
            },

            columns: [
                {
                    dataField: "intRoofingHeader",
                    caption: "ID",
                }, {
                    dataField: "strReference",
                    caption: "Reference",
                }, 
                {
                    dataField: "UserName",
                    caption: "User Name",
                }, 
                {
                    dataField: "dateTimeCreated",
                    caption: "Time Created",
                }, 
            ],

            onRowClick:function(e){
                $('#linesgrid').show();
                var headerID = e.data.intRoofingHeader;
                batchID = headerID;
                batchReference = e.data.strReference;

                getLines(headerID);
            },
            onRowRemoved(e){
                var HeaderID = e.data.intRoofingHeader

                $.ajax({
                    url: '{!!url("/deleteRoofingBatch")!!}',
                    type: "POST",
                    data: {
                        ID: HeaderID,
                    },
                    success: function (data) {
                        alert("Reference Deleted");
                    }
                });
            },
        }).dxDataGrid('instance');

        const linesgrid =  $("#linesgrid").dxDataGrid({
            dataSource:[], //as json
            showBorders: true,
            hoverStateEnabled: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            keyExpr: 'UniqueID',
            editing: {
                mode: 'cell',
                allowUpdating: true,
                saveButton: true, // enable Save Changes button
                // allowAdding: true,
                allowDeleting: true,
                useIcons: true,
            },
            selection: {
                mode: 'single',
            },
            paging:{
                pageSize: 10,
            },                    
            pager: {
                visible: true,
                allowedPageSizes: [5, 10, 20, 50],
                showPageSizeSelector: true,
                showInfo: true,
                showNavigationButtons: true,
            },

            columns: [
                
                {
                    dataField: "strReference",
                    caption: "Reference",
                    visible: false,
                    allowEditing : false,
                },{
                    dataField: "UniqueID",
                    caption: "Unique ID",
                    allowEditing : false,
                },{
                    dataField: "intRoofingHeader",
                    caption: "ID",
                    visible: false,
                    allowEditing : false,
                }, {
                    dataField: "strSONum",
                    caption: "SO Number",
                    allowEditing : false,
                },{
                    dataField: "intOrderLineID",
                    caption: "Order Line ID",
                    allowEditing : false,
                }, {
                    dataField: "StoreName",
                    caption: "Store Name",
                    allowEditing : false,
                    width: 300,
                }, {
                    dataField: "Code",
                    caption: "Code",
                    visible: false,
                    allowEditing : false,
                }, {
                    dataField: "ItemName",
                    caption: "Item Name",
                    allowEditing : false,
                },
                {
                    dataField: "intMachineId",
                    caption: "Machine Name",
                    lookup: {
                        dataSource: machineslist,
                        valueExpr: "intAutoMachineID",
                        displayExpr: "strMachineName",
                    },
                    cellTemplate: function(container, options) {
                        if (options.value === 0) {
                            container.text("Unassigned");
                        } else {
                            container.text(options.displayValue);
                        }
                    }
                },
                {
                    dataField: "intQty",
                    caption: "Qty",
                },
                
            ],
            onRowRemoved(e){
                var UniqueID = e.data.UniqueID

                $.ajax({
                    url: '{!!url("/deleteRoofingSO")!!}',
                    type: "POST",
                    data: {
                        ID: UniqueID,
                    },
                    success: function (data) {
                        alert("Order Deleted");
                    }
                });
            },
            
        }).dxDataGrid("instance");

        const sequencegrid = $("#sequencegrid").dxDataGrid({
            dataSource:[], //as json
            showBorders: true,
            hoverStateEnabled: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,

            paging:{
                pageSize: 20,
            },
            selection: {
                mode: 'single',
            },

            columns: [
                {
                    dataField: "UniqueId",
                    caption: 'ID', 
                    visible: false,
                },
                {
                    dataField: "strReference",
                    caption: "Reference",
                },
                {
                    dataField: "strMachineName",
                    caption: "Machine",
                },
                {
                    dataField: "strStatus",
                    caption: "Status",
                }
            ],

            
            onRowDblClick:function(e){
                //console.log(e.data.intJobId);
                var strReference =  e.data.strReference;
                var strMachineName = e.data.strMachineName;

                window.open('{!!url("/roofingSOUpdate")!!}/'+strReference+'/'+strMachineName,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");

            }

        }).dxDataGrid('instance');

        if (localStorage.getItem("PPSO") == 'active') {
            localStorage.setItem('PPSO', 'done');
            $('#content1').addClass("show active");
            $('#content2').removeClass("show active");
            $('#content3').removeClass("show active");

            $('#tab1').addClass("active");
            $('#tab2').removeClass("active");
            $('#tab3').removeClass("active");
        }

        if (localStorage.getItem("BSOP") == 'active') {
            localStorage.setItem('BSOP', 'done');
            $('#content1').removeClass("show active");
            $('#content2').addClass("show active");
            $('#content3').removeClass("show active");

            $('#tab1').removeClass("active");
            $('#tab2').addClass("active");
            $('#tab3').removeClass("active");
        }

        if (localStorage.getItem("BS") == 'active') {
            localStorage.setItem('BS', 'done');
            $('#content1').removeClass("show active");
            $('#content2').removeClass("show active");
            $('#content3').addClass("show active");

            $('#tab1').removeClass("active");
            $('#tab2').removeClass("active");
            $('#tab3').addClass("active");
        }

        getPPSO();
        getHeaders();
        getRoofWIP();
        setInterval(getRoofWIP, 60000);
        
        $('#getheaders').click(function(){
            getHeaders();
        });

        $('#refresh').click(function(){
            getPPSO();
        });

        $('#savePPSO').click(function(){
            if (($("#reference").val()).length < 1)
                alert("The Reference needs to be inserted");
            else{
                var toPlan =  $("#ppsoGrid").dxDataGrid("getSelectedRowKeys");
                var orderlines = new Array();

                for (var i = 0; i < toPlan.length; i++) {
                    var rowKey = toPlan[i];
                    orderlines.push({'SOnumbers': toPlan[i]['OrderNumber'],'IOnumbers': toPlan[i]['idInvoiceLines'],'CompanyName': toPlan[i]['Company']});
                }

                $.ajax({
                    url: '{!!url("/insertPrePlannedSO")!!}',
                    type: "POST",
                    data: {
                        orderlines: orderlines,
                        reference: $("#reference").val()
                    },
                    success: function (data) {
                        if(data[0].Result == "Success"){
                            location.reload();
                            localStorage.setItem('PPSO', 'active');
                        }else{
                            alert(""+data[0].Result);
                        }
                    }
                });
            }
        });

        $('#saveBSOP').click(function(){
            // alert('Clicked MF!');
            var allGridItems =  $("#linesgrid").dxDataGrid("getDataSource").items();
            var checkedLines = new Array();

            allGridItems.forEach((element, index, value) => {
                checkedLines.push({
                    'UniqueID': element["UniqueID"],
                    'strSONum': element["strSONum"],
                    'intAutoMachineID':element["intMachineId"],
                    'ProdName': escapeHtml(element["Code"]),
                    'intQty':element["intQty"],
                    'Dept': 'Roofing',
                    'strReference': element["strReference"],
                    'intOrderLineID': element["intOrderLineID"],
                });
            });

            $.ajax({
                url: '{!!url("/updateRoofLines")!!}',
                type: "POST",
                data: {
                    workOrders: checkedLines,
                    batchID: batchID,
                    batchReference: batchReference,
                },
                success: function (data) {
                    if(data[0].Result == "Success"){
                        
                        location.reload();
                        localStorage.setItem('BSOP', 'active');
                    }else{
                        alert(""+data[0].Result);
                    }
                }
            });

        });

        $('#updateBS').click(function(){
            var allGridItems =  $("#sequencegrid").dxDataGrid("getDataSource").items();
            var checkedLines = new Array();

            var seq = 0;

            allGridItems.forEach((element, index, value) => {
                seq += 1;
                checkedLines.push({
                    'strReference':element["strReference"],
                    'strMachineName':element["strMachineName"],
                    'jobSeq' : seq,
                });
            });

            // console.debug(checkedLines);

            $.ajax({
                url: '{!!url("/updateRoofLinesSequence")!!}',
                type: "POST",
                data: {
                    workOrders: checkedLines,
                },
                success: function (data) {
                    if(data[0].Result == "Success"){
                        location.reload();
                        localStorage.setItem('BS', 'active');
                    }else{
                        alert(""+data[0].Result);
                    }
                }
            });

        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });

        $('#bulkSelect').click(function(){
            const salorders = $("#salesorders").val();
            const invorders = $("#invoiceorders").val();
            const comp = $("#company").val();

            var salesorders = salorders.split("\n");
            var invoiceorders = invorders.split("\n");
            var company = comp.split("\n");

            var dataSource = ppsoGrid.getDataSource().items();
            // console.log(dataSource);

            var selectedRowKeys = [];
            dataSource.forEach(function(item) {
                for (var i = 0; i < salesorders.length; i++) {
                    if (salesorders[i] === item.OrderNumber && invoiceorders[i] === item.idInvoiceLines && company[i] === item.Company) {
                        var key = ppsoGrid.getKeyByRowIndex(ppsoGrid.getRowIndexByKey(item));
                        selectedRowKeys.push(key);
                    }
                }
            });
            ppsoGrid.selectRows(selectedRowKeys);
        });

        $("#mulkMapModal").on("hidden.bs.modal", function () {
            $("#mulkMapModal textarea").val("");
        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

        $("#upload-form").submit(function(event) {
            event.preventDefault();

            // Get the file data
            var file = $("#excel-file")[0].files[0];
            var reader = new FileReader();
            var SalesOrderList = new Array();
            var InvoiceOrderList = new Array();
            var CompanyList = new Array();

            reader.onload = function(event) {
                var data = event.target.result;

                // Use a library like SheetJS to parse the Excel data
                var workbook = XLSX.read(data, {type: 'binary'});
                var sheet = workbook.Sheets[workbook.SheetNames[0]];

                // Convert the sheet data to an array
                var arrayData = XLSX.utils.sheet_to_json(sheet, { header: 1});

                arrayData.shift();

                // console.log(arrayData);

                // Use the array data as needed
                arrayData.forEach((element, index, value) => {
                    SalesOrderList.push(element[4]);
                    $('#salesorders').val(SalesOrderList.join('\n'));
                    InvoiceOrderList.push(element[5]);
                    $('#invoiceorders').val(InvoiceOrderList.join('\n'));
                    CompanyList.push(element[6]);
                    $('#company').val(CompanyList.join('\n'));
                });
            };

            // console.log(file);
            // console.log(InvoiceOrderList);
            // console.log(CompanyList);
            var ref = file["name"];
            ref = ref.replace(".xlsx", "");
            $('#reference').val(ref);

            reader.readAsBinaryString(file);
        });

        function getPPSO(){
            $.ajax({
                url: '{!!url("/getRoofingSalesOrders")!!}',
                type: "GET",
                data: {

                },
                success: function (data) {
                    // console.debug(data);

                    ppsoGrid.option('dataSource', data);
                    ppsoGrid.refresh();

                    ppsoGrid.on("customizeSummaryValue", function(e) {
                        if (e.summaryProcess === "finalize" && e.summaryName.startsWith("Total")) {
                            e.totalValue = ppsoGrid.getDataSource().totalSummary(e.summaryName);
                        }
                    });
                }
            });
        };

        function getHeaders(){
            $.ajax({
                url: '{!!url("/getroofingheaders")!!}',
                type: "GET",
                data: {
                    datefrom: $('#datefromheader').val(),
                    dateto: $('#datetoheader').val()
                },
                success: function (data) {
                    //console.debug(data);

                    headergrid.option('dataSource', data);
                    headergrid.refresh();
                    
                }
            });
        };

        function getLines(headerID){
            $.ajax({
                url: '{!!url("/getroofinglines")!!}',
                type: "GET",
                data: {
                    ID : headerID,
                },
                success: function (data) {
                    linesgrid.option('dataSource', data);
                    linesgrid.refresh();
                    
                }
            });
        };

        function getRoofWIP() {
            $.ajax({
                url: '{!!url("/getRoofWIP")!!}',
                type: "GET",
                data: {
                },
                success: function (data) {
                    sequencegrid.option('dataSource', data);
                    sequencegrid.refresh();
                }

            });
        };


    });



    function escapeHtml(unsafe) {
        return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    };

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
</body>