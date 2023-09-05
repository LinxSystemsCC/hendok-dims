<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('resources\css\jobmodulestyle.css') }}">
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <title>Generic Printing</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.compact.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-x0Jk5I2tJp2F5vzZ2jw5CzOaSj4Ck5l5eT5f5eI5V5Y3r5u5F5V5I5y5S5G5H5N5N5H5d5L5T5s5N5P5C5E5r5e5x5D5I5O5=" crossorigin="anonymous">

    <style>
        .red-message{
            color: red;
            border-color: red;
        }
    </style>
</head>

<body>
<div class="col-12 d-flex px-0 vh-100"  style="background: white;">
    <div class="col-custom-2" style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>

    <div class="col overflow-auto d-flex">
        <div class="col-lg-4 col-sm-12 p-3">

            <h3>PRODUCT LABEL PRINTING</h3>

            {{-- Department --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="department">Department</label>
                <select  class="form-select" id="department"required>
                    <option></option>
                    @foreach($dept as $val)
                        <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                    @endforeach
                </select>
            </div>

            {{-- Product Category --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="category">Product Category </label>
                <select  class="form-select" id="category"  required>
                    <option></option>
                </select>
            </div>

            {{-- Product --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="product">Product Name </label>
                <select  class="form-select" id="product" required>
                    <option></option>
                </select>
            </div>

            {{-- Label Type --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="labelType">Label Type</label>
                <select  class="form-select input-sm w-100" id="labelType" required>
                    <option></option>
                </select>
            </div>

            {{-- Pallets --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="configuration">Pallet / Bundle Quantity</label>
                <div class="col-12 d-inline-flex">
                    <div class="col-11">
                        <select  class="form-select input-sm w-100 rounded-0 rounded-start" id="configuration">

                        </select> 
                        <input class="form-control input-sm w-100 rounded-0" id="inputConfiguration" type="number" hidden>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-secondary rounded-0 rounded-end" id="btnEditConfiguration" disabled><i class="fa fa-edit p-0"></i></button>
                    </div>
                </div>
            </div>

            {{-- Quantity --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="quantity">Quantity to Print </label>
                <input  class="form-control" id="quantity" required>
            </div>

            {{-- Barcode --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="barcode">Barcode</label>
                <input class="form-control" id="barcode" aria-describedby="barcodeHelp" required disabled>
                <div id="barcodeHelp" class="form-text" hidden>Please Contact your manager to rectify missing barcode</div>
            </div>

            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="printer">Printer</label>
                <select  class="form-select w-100" id="printer"  required>
                    <option></option>
                    @foreach($printers as $printer)
                        <option value="{{$printer->strPrinter}}">{{$printer->strPrinter}}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success" id="print" style="width: 100%; margin-right: 10px;">PRINT</button>
            
            <br><br>

            <h3>LABEL PRINTING REPORT</h3>
            {{-- Date from --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="datefrom">Date From </label>
                <input type="date" class="form-control" id="datefrom" required>
            </div>

            {{-- Date To --}}
            <div class="form-group mb-2">
                <label class="control-label fw-bold" for="dateto">Date To</label>
                <input type="date" class="form-control" id="dateto" required>
            </div>
            
            <button class="btn btn-primary w-100" id="report" >REPORT</button>
        </div>

        <div class="col-lg-8 col-sm-12 p-3">
            <h3 id="gridHeading"></h3>
            <div id="gridContainer">
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

        $('#print').click(function(){

            $.ajax({

                url: '{!!url("/printgenericlabel")!!}',
                type: "POST",
                data: {
                    department: $('#department').val(),
                    category: $('#category').val(),
                    product: $('#product').val(),
                    labelType: $('#labelType').val(),
                    configuration: $('#inputConfiguration').val(),
                    quantity: $('#quantity').val(),
                    barcode: $('#barcode').val(),
                    printer: $('#printer').val(),
                },
                success: function (data) {
                    if(data[0].Result =="SUCCESS")
                    {
                        alert('Succesful Printout.');
                        location.reload();
                    }else{
                        alert(data[0].Result);
                    }
                }

            });

        });

        $('#report').click(function(){
            var datefrom =  $('#datefrom').val();
            var dateto = $('#dateto').val();
            $('#gridHeading').text("PRINTING REPORT FROM: "+datefrom + " TO: "+dateto);
            $.ajax({
                url: '{!!url("/getgenericlabelprintscreen")!!}',
                type: "GET",
                data: {
                    datefrom: $('#datefrom').val(),
                    dateto: $('#dateto').val()
                },
                success: function (data) {
                    $("#gridContainer").dxDataGrid({
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
                        export: {
                            enabled: true
                        },
                        selection: {
                            mode: 'single',
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('printReport');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'printReport.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [
                            {
                                dataField: "intJobId",
                                caption: "JobNo",
                                //width: 80,

                            }, {
                                dataField: "Code",
                                caption: "Code",
                                //width: 100,

                            }, {
                                dataField: "Description_1",
                                caption: "Description",
                                //width: 200,

                            },
                            {
                                dataField: "mnyQtyRequired",
                                caption: "Qty Required",
                                //width: 250,

                            },
                            {
                                dataField: "dteStartDate",
                                caption: "Date",
                                //width: 500,

                            },
                            

                        ],
                        onRowDblClick:function(e){
                            // console.log(e.data.intJobId);
                            // var intJobId =  e.data.intJobId;

                            // window.open('{!!url("/jobupdateprint")!!}/' +intJobId, "Job" +intJobId, "location=1,status=1,scrollbars=1, width=1200,height=850");

                        }

                    });

                }

            });
        });

        $('#department').change(function(){
            $.ajax({

                url: '{!!url("/getDepListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#department option:selected').text(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#category").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.intAutoGroupCategoryId+'">'+o.strProductCategory+'</option>';
                    });
                    $("#category").append(toAppend);

                }

            });
        });

        $('#category').change(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#category option:selected').val(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#product").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                    });
                    $("#product").append(toAppend);

                }

            });
        });

        $('#product').change(function(){
            // $.ajax({

            //     url: '{!!url("/getProductBarcode")!!}',
            //     type: "GET",
            //     data: {
            //         productCode: $('#product option:selected').val(),

            //     },
            //     success: function (data) {
            //         var barcode = data[0]["BarCode"];
            //         console.debug(barcode);

            //         if (barcode == null){
            //             $('#barcode').val("0000000000000");
            //         }else{
            //             $('#barcode').val(barcode);
            //         }
                    

            //     }

            // });
            $.ajax({
                url: '{!!url("/getProductInfo")!!}',
                type: "GET",
                data: {
                    productCode: $('#product option:selected').val(),
                },
                success:function(data){
                    
                    var toAppend = '';
                    $("#configuration").empty();

                    toAppend += '<optgroup label="Single" hidden>';
                    toAppend += '<option></option>';
                    toAppend += '<option value = "1">1</option>';
                    toAppend += '</optgroup>';
                    
                    $.each(data,function(i,o){
                        if (o.strBundleSize !== null) {
                            var bundleSize = o.strBundleSize.split(';');

                            toAppend += '<optgroup label="Bundle" hidden>';
                            toAppend += '<option></option>';
                            $.each(bundleSize, function(index,value){
                                toAppend += '<option value="'+value+'">'+value+' / bundle</option>';
                            })
                            toAppend += '</optgroup>';
                        }

                        if (o.strPackSize !== null) {
                            var packSizes = o.strPackSize.split(';');

                            toAppend += '<optgroup label="Pallet" hidden>';
                            toAppend += '<option></option>';
                            $.each(packSizes, function(index,value){
                                toAppend += '<option value="'+value+'">'+value+' / pallet</option>';
                            })
                            toAppend += '</optgroup>';
                        }
                        
                    });

                    $("#configuration").append(toAppend);

                    var addType = '';
                    $("#labelType").empty();
                    addType += '<option></option>';

                    if (data[0]['intHasSingleLable'] == "1"){
                        addType += '<option value = "Single">Single</option>';
                    }
                    if (data[0]['intHasBundleLable'] == "1"){
                        addType += '<option value = "Bundle">Bundle</option>';
                    }
                    if (data[0]['intHasPalletLable'] == "1"){
                        addType += '<option value = "Pallet">Pallet</option>';
                    }

                    $("#labelType").append(addType);

                    $('#barcode').val(data[0]['Barcode']);

                    if (data[0]["Barcode"] == '0000000000000'){
                        $('#barcode').addClass('red-message');
                        $('#barcodeHelp').addClass('red-message');
                        $('#barcodeHelp').prop('hidden', false);
                        
                    }else{
                        $('#barcode').removeClass('red-message');
                        $('#barcodeHelp').removeClass('red-message');
                        $('#barcodeHelp').prop('hidden', true);
                    }
                    
                }
            });
        });

        $('#labelType').change(function(){
            var type = $('#labelType').val();

            if (type == 'Pallet'){
                $("#configuration optgroup[label='Pallet']").prop('hidden', false);
                $("#configuration optgroup[label='Bundle']").prop('hidden', true);
                $("#configuration optgroup[label='Single']").prop('hidden', true);
                $("#configuration").val("");
                $("#configuration").prop('disabled', false);
            }else if (type == 'Bundle'){
                $("#configuration optgroup[label='Pallet']").prop('hidden', true);
                $("#configuration optgroup[label='Bundle']").prop('hidden', false);
                $("#configuration optgroup[label='Single']").prop('hidden', true);
                $("#configuration").val("");
                $("#configuration").prop('disabled', false);
            }else{
                $("#configuration optgroup[label='Pallet']").prop('hidden', true);
                $("#configuration optgroup[label='Bundle']").prop('hidden', true);
                $("#configuration optgroup[label='Single']").prop('hidden', false);
                $("#configuration").val("1");
                $("#configuration").prop('disabled', true);

            }
        });

        $('#btnEditConfiguration').click(function() {
            $('#configuration').prop("hidden", function(_, value) {
                return !value;
            });
            $('#inputConfiguration').prop("hidden", function(_, value) {
                return !value;
            });

            $('#configuration').val("");
            $('#inputConfiguration').val("");
        });

        $('#configuration').change(function(){
            var config = $('#configuration').val();
            $('#inputConfiguration').val(config);
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
