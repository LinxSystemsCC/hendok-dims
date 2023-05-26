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
    {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet">
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
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

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
            max-width: calc(100vw - 270px) !important;
        }
    
        #headergrid{
            max-height: calc(54vh - 155px);
            min-height: calc(54vh - 155px);
            max-width: calc(100vw - 270px) !important;
        }
    
        #linesgrid{
            max-height: calc(54vh - 155px);
            min-height: calc(54vh - 155px);
            max-width: calc(100vw - 270px) !important;
        }
    
    </style>

</head>

<body>
    <div class="col-lg-12 d-flex bd-highlight w-100"  style="background: white;">
        <div class="col-lg-2" style="background: white;">

            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>

        <div class="col-lg-10">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="PPSOTab" aria-current="page">Pre Plan SO's</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="BSOPTab">Batch SO Processing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="BSTab" >Batch Progression</a>
                </li>
            </ul>
            
            <div class="tab-content p-3 w-100">
                {{-- Pre Planned Sales Orders Page --}}
                <div class="tab-pane fade show active" id="PPSOPage" role="tabpanel">

                    {{-- -------------------------------------- Old Design -------------------------------------- --}}

                    {{-- <div class="modal-header">
                        <h5 class="modal-title" id="preplanningsoTitle">Pre Planning SO</h5>
                    </div>
                    <div class="modal-body">
                        <form id="upload-form" class="w-100">
                            <input type="file" id="excel-file" class="px-3" name="excel-file" accept=".xlsx">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                        <div class="d-inline-flex w-100">
                            <div class="form-group col-4">
                                <label class="control-label" for="salesorders"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Sales Orders</label>
                                <textarea  type="text" rows="15" class="form-control input-sm col-xs-1" id="salesorders" required></textarea>
                            </div>
                            
                            <div class="form-group col-4">
                                <label class="control-label" for="invoiceorders"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Invoice Orders</label>
                                <textarea  type="text" rows="15" class="form-control input-sm col-xs-1" id="invoiceorders" required></textarea>
                            </div>

                            <div class="form-group col-4">
                                <label class="control-label" for="company"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Company</label>
                                <textarea  type="text" rows="15" class="form-control input-sm col-xs-1" id="company" required></textarea>
                            </div>
                        </div>
                            
        
                        <div class="form-group">
                            <label class="control-label" for="reference"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Reference </label>
                            <input type="text"  class="form-control input-sm col-xs-1" id="reference" required>
                        </div>

                        <button class="btn-danger btn-lg" id="savePPSO" style="width: 100%;">SAVE</button>

                    </div> --}}
                    <h3>Pre Plan Sales Orders</h3>

                    {{-- <button class="btn btn-primary" id="syncNewOrders" style="width: 100%;">SYNC NEW ORDERS</button> --}}
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mulkMapModal">Bulk Selection</button>

                    <div id="ppsoGrid" class="py-2"></div>

                    <div class="form-group">
                        <label class="control-label" for="reference"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Reference </label>
                        <input type="text"  class="form-control input-sm col-xs-1" id="reference" required>
                    </div>

                    <button class="btn btn-success" id="savePPSO" style="width: 100%;">SAVE</button>


                </div>

                {{--  Batch Sales Order Processing Page --}}
                <div class="tab-pane fade" id="BSOPPage" role="tabpanel">
                    {{-- Date from --}}
                    <label class="control-label" for="datefromheader"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date From </label>
                    <input type="date" id="datefromheader">

                    {{-- Date To --}}
                    <label class="control-label" for="datetoheader"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date To </label>
                    <input type="date" id="datetoheader">
                    <button class="btn btn-info" id="getheaders">GET</button>

                    <br><br>
                    
                    <div id="headergrid">
                    </div>

                    <div id="linesgrid" class="my-3">
                        
                    </div>

                    <button type="button" class="btn btn-success" id="saveBSOP" aria-label="Save">Save</button>

                </div>

                {{--  Batch Sequencing Page --}}
                <div class="tab-pane fade" id="BSPage" role="tabpanel">
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

        if (localStorage.getItem("PPSO") == 'active') {
            localStorage.setItem('PPSO', 'done');
            $('#PPSOPage').addClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').addClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').removeClass("active");
        }

        if (localStorage.getItem("BSOP") == 'active') {
            localStorage.setItem('BSOP', 'done');
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').addClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').addClass("active");
            $('#BSTab').removeClass("active");
        }

        if (localStorage.getItem("BS") == 'active') {
            localStorage.setItem('BS', 'done');
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').addClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').addClass("active");
        }

        ppsoGrid();
        headersFunction();
        getRoofWIP();
        setInterval(getRoofWIP, 60000);
        
        $('#getheaders').click(function(){
            headersFunction();
        });

        $('#PPSOTab').click(function(){
            $('#PPSOPage').addClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').addClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').removeClass("active");
        });

        $('#BSOPTab').click(function(){
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').addClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').addClass("active");
            $('#BSTab').removeClass("active");
        });

        $('#BSTab').click(function(){
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').addClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').addClass("active");
        });

        // Old Design -------------------------------------------------------------------------------------------------------------------
        // $('#savePPSO').click(function(){
        //     if (($("#reference").val()).length < 1)
        //         alert("The Reference needs to be inserted");
        //     else{
        //         const salorders = $("#salesorders").val();
        //         const invorders = $("#invoiceorders").val();
        //         const comp = $("#company").val();

        //         var salesorders = salorders.split("\n");
        //         var invoiceorders = invorders.split("\n");
        //         var company = comp.split("\n");
                
        //         var SOnumbers = new Array();
        //         var IOnumbers = new Array();
        //         var CompName = new Array();
                

        //         linesignored = 0;

        //         for (let i = 0; i < salesorders.length; i++)
        //             if (salesorders[i] == ''){
        //                 salesorders+= 1;
        //             }else{
        //                 SOnumbers.push(escapeHtml(salesorders[i]));
        //             }
                
        //         var linesignored = 0;

        //         for (let i = 0; i < invoiceorders.length; i++)
        //             if (invoiceorders[i] == ''){
        //                 linesignored+= 1;
        //             }else{
        //                 IOnumbers.push(escapeHtml(invoiceorders[i]));
        //             }


        //         linesignored = 0;

        //         for (let i = 0; i < company.length; i++)
        //             if (company[i] == ''){
        //                 company+= 1;
        //             }else{
        //                 CompName.push(escapeHtml(company[i]));
        //             }

        //         var orderlines = new Array();
                
        //         for (let i = 0; i < salesorders.length; i++)
        //             orderlines.push({'SOnumbers': SOnumbers[i],'IOnumbers': IOnumbers[i],'CompanyName': CompName[i]});

        //         // console.log(orderlines);
        //         // console.log(IOnumbers);

        //         $.ajax({
        //             url: '{!!url("/insertPrePlannedSO")!!}',
        //             type: "POST",
        //             data: {
        //                 orderlines: orderlines,
        //                 reference: $("#reference").val()
        //             },
        //             success: function (data) {
        //                 if(data[0].Result == "Success"){
        //                     location.reload();
        //                     localStorage.setItem('PPSO', 'active');
        //                 }else{
        //                     alert(""+data[0].Result);
        //                 }
        //             }
        //         });
        //     }
                
        // });

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
                        getLin
                        // location.reload();
                        // localStorage.setItem('BSOP', 'active');
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

            var dataGrid = $("#ppsoGrid").dxDataGrid("instance");
            var dataSource = dataGrid.getDataSource().items();
            // console.log(dataSource);

            var selectedRowKeys = [];
            dataSource.forEach(function(item) {
                for (var i = 0; i < salesorders.length; i++) {
                    if (salesorders[i] === item.OrderNumber) {
                        var key = dataGrid.getKeyByRowIndex(dataGrid.getRowIndexByKey(item));
                        selectedRowKeys.push(key);
                        console.log(key);
                    }
                }
                for (var i = 0; i < invoiceorders.length; i++) {
                    if (invoiceorders[i] === item.idInvoiceLines) {
                        var key = dataGrid.getKeyByRowIndex(dataGrid.getRowIndexByKey(item));
                        selectedRowKeys.push(key);
                        console.log(key);
                    }
                }
                for (var i = 0; i < company.length; i++) {
                    if (company[i] === item.Company) {
                        var key = dataGrid.getKeyByRowIndex(dataGrid.getRowIndexByKey(item));
                        selectedRowKeys.push(key);
                        console.log(key);
                    }
                }
            });
            dataGrid.selectRows(selectedRowKeys);
        });
        
        // Clear inputs and selects within the modal
        $("#mulkMapModal").on("hidden.bs.modal", function () {
            $("#mulkMapModal textarea").val("");
        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

        // Function to read excel
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

    });
    
    function ppsoGrid(){
        $.ajax({
            url: '{!!url("/getRoofingSalesOrders")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                //console.debug(data);
                
                const ppsoGrid = $("#ppsoGrid").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    noDataText: 'Please Sync for new Sales Orders',
                    scrolling: {
                        rowRenderingMode: 'infinite',
                    },
                    paging:{
                        pageSize: 2000,
                    },
                    
                    editing:{
                        mode: 'form',
                        // allowUpdating: true,
                        // allowAdding: true,
                        // allowDeleting: true,
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
                });

                ppsoGrid.dxDataGrid("instance").on("customizeSummaryValue", function(e) {
                    if (e.summaryProcess === "finalize" && e.summaryName.startsWith("Total")) {
                        e.totalValue = ppsoGrid.dxDataGrid("instance").getDataSource().totalSummary(e.summaryName);
                    }
                });
            }
        });
    };

    function headersFunction(){
        $.ajax({
            url: '{!!url("/getroofingheaders")!!}',
            type: "GET",
            data: {
                datefrom: $('#datefromheader').val(),
                dateto: $('#datetoheader').val()
            },
            success: function (data) {
                //console.debug(data);
                
                const headergrid = $("#headergrid").dxDataGrid({
                    dataSource:data, //as json
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
                        var machineslist = ({!! json_encode($machines) !!});
                        machineslist.unshift({ intAutoMachineID: 0, strMachineName: "Unassigned" });

                        // console.debug(machineslist);

                        $.ajax({
                            url: '{!!url("/getroofinglines")!!}',
                            type: "GET",
                            data: {
                                ID : headerID,
                            },
                            success: function (data) {
                                // console.debug(data);
                                
                                const linesgrid =  $("#linesgrid").dxDataGrid({
                                    dataSource:data, //as json
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
                            }
                        });
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
                });
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

                $("#sequencegrid").dxDataGrid({
                    dataSource:data, //as json
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
            }

        });
    }

    function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

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
