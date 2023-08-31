<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('resources\css\jobmodulestyle.css') }}">
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <title>Warehouse Printing</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

</head>

<body>
<div class="col-12 d-flex px-0 vh-100"  style="background: white;">
    <div class="col-custom-2" style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>

    <div class="col p-3 overflow-auto"  style="max-width:100% !important; height:100vh !important;">
        <ul class="nav nav-tabs">
            <li class="nav-item">
            <a class="nav-link active" onclick="openPage('barcodepage', this,'barcodetab')"id="barcodetab">Barcode</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" onclick="openPage('barcodelesspage', this, 'defaultOpen')"id="defaultOpen">Barcodeless</a>
            </li>
        </ul>

        {{-- Barcode --}}
        <div class="tab-content">
            <div class="tabcontent tab-pane" id="barcodepage" role="tabpanel">
                {{-- Barcode Scan Page --}}
                <div class="col-lg-4 col-sm-12 p-2 bd-highlight">

                    {{--Input of Job ID--}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="jobid">Job ID </label>
                        <input  class="form-control input-sm col-xs-1" id="jobid" >
                    </div>

                    {{-- Department --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="department">Department </label>
                        <input  class="form-control input-sm col-xs-1" id="department" readonly>
                    </div>

                    {{-- Department HIDDEN FOR PURPOSES OF VALUE! --}}
                    <div class="form-group mb-2">
                        <input  class="form-control input-sm col-xs-1" id="departmentId" readonly hidden>
                    </div>

                    {{-- Product Category --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="category">Product Category </label>
                        <input  class="form-control input-sm col-xs-1" id="category" readonly>
                    </div>

                    {{-- Category HIDDEN FOR PURPOSES OF VALUE! --}}
                    <div class="form-group mb-2">
                        <input  class="form-control input-sm col-xs-1" id="categoryID" readonly hidden>
                    </div>

                    {{-- Product HIDDEN FOR PURPOSES OF VALUE! --}}
                    <div class="form-group mb-2">
                        <input  class="form-control input-sm col-xs-1" id="productCode" readonly hidden>
                    </div>

                    {{-- Product --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="product">Product Name </label>
                        <input class="form-control input-sm col-xs-1" id="product" readonly>
                    </div>
                    
                    {{-- Label Type --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="labelType">Label Type</label>
                        <select  class="form-select input-sm w-100" id="labelType" required>
                            <option></option>
                            <option value="Pallet">Pallet</option>
                            <option value="Bundle">Bundle</option>
                        </select>
                    </div>

                    {{-- Pallets --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="configuration">Pallet / Bundle Configuration</label>
                        <select  class="form-control input-sm col-xs-1 " id="configuration" >
                            <option></option>
                            
                            
                        </select> 
                    </div>

                    {{-- Quantity --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="qty">Quantity to Print </label>
                        <input  class="form-control input-sm col-xs-1" id="qty"type="number">
                    </div>

                    {{-- Weight --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="weight">Weight to Print </label>
                        <div class="col-12 d-inline-flex">
                            <div class="col-8">
                                <select  class="form-select input-sm w-100" id="scaleID">
                                    <option></option>
                                    @foreach($scales as $scale)
                                        <option value="{{$scale->intAutoId}}">{{$scale->strName}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-4">
                                <input  class="form-control input-sm w-100" id="weight" type="number" disabled>
                            </div>
                        </div>
                    </div>

                    {{-- Barcode --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="barcode">Barcode</label>
                        <input class="form-control input-sm col-xs-1" id="barcode"type="number">
                    </div>

                    {{-- Driver Name --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="driver">Driver Name</label>
                        <input  class="form-control input-sm col-xs-1" id="driver" >
                    </div>

                    {{-- Driver Number --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="forklift">Forklift Number </label>
                        <select  class="form-select input-sm w-100" id="forklift" readonly>
                            <option></option>
                            @foreach($forklifts as $forklift)
                                <option value="{{$forklift->intLocationNameId}}">{{$forklift->strLocationName}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Area --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="area">Area</label>
                        <select class="form-select input-sm w-100" id="area" readonly>
                            <option></option>
                            @foreach($areas as $area)
                                <option value="{{$area->intAutoID}}">{{$area->strAreaName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="printer">Printer</label>
                        <select  class="form-select w-100" id="printer"  required>
                            <option></option>
                            @foreach($printers as $printer)
                                <option value="{{$printer->intPrinterId}}">{{$printer->strPrinter}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success w-100" id="print" >PRINT</button>
                </div>
            </div>
        </div>

        {{-- Barcodeless --}}
        <div class="tab-content">
            <div class="tabcontent tab-pane" id="barcodelesspage" role="tabpanel">
                {{-- Barcode Scan Page --}}
                <div class="col-lg-4 col-sm-12 p-2 bd-highlight">
                    {{-- Department --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="departmentBarcodeless">Department</label>
                        <select  class="form-select input-sm w-100 " id="departmentBarcodeless" >
                            <option></option>
                            @foreach($dept as $val)
                                <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    {{-- Product Category --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="categoryBarcodeless">Product Category </label>
                        <select  class="form-select input-sm w-100" id="categoryBarcodeless" required>
                            <option></option>
                        </select>
                    </div>

                    {{-- Product --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="productBarcodeless">Product Name </label>
                        <select  class="form-select input-sm w-100" id="productBarcodeless" required>
                            <option></option>
                        </select>
                    </div>

                    {{-- Label Type --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="labelTypeBarcodeless">Label Type</label>
                        <select  class="form-select input-sm w-100" id="labelTypeBarcodeless" required>
                            <option></option>
                            <option value="Single">Single</option>
                            <option value="Pallet">Pallet</option>
                            <option value="Bundle">Bundle</option>
                        </select>
                    </div>

                    {{-- Pallets --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="configurationBarcodeless">Pallet / Bundle Configuration</label>
                        <select  class="form-select input-sm w-100 "id="configurationBarcodeless">

                        </select> 
                    </div>

                    {{-- Quantity --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="quantityBarcodeless">Quantity to Print </label>
                        <input  class="form-control input-sm col-xs-1" id="quantityBarcodeless">
                    </div>

                    {{-- Weight --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="weightBarcodeless">Weight to Print </label>
                        <div class="col-12 d-inline-flex">
                            <div class="col-8">
                                <select  class="form-select input-sm w-100" id="scaleIDBarcodeless">
                                    <option></option>
                                    @foreach($scales as $scale)
                                        <option value="{{$scale->intAutoId}}">{{$scale->strName}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-4">
                                <input  class="form-control input-sm w-100" id="weightBarcodeless" type="number" disabled>
                            </div>
                        </div>
                    </div>

                    {{-- Barcode --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="barcodeBarcodeless">Barcode</label>
                        <input class="form-control input-sm col-xs-1" id="barcodeBarcodeless">
                    </div>

                    {{-- Driver Name --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="driverBarcodeless">Driver Name</label>
                        <input  class="form-control input-sm col-xs-1" id="driverBarcodeless" >
                    </div>

                    {{-- Driver Number --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="forkliftBarcodeless">Forklift Number </label>
                        <select  class="form-select input-sm w-100" id="forkliftBarcodeless" readonly>
                            <option></option>
                            @foreach($forklifts as $forklift)
                                <option value="{{$forklift->intLocationNameId}}">{{$forklift->strLocationName}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Area --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="areaBarcodeless">Area</label>
                        <select class="form-select input-sm w-100" id="areaBarcodeless" readonly>
                            <option></option>
                            @foreach($areas as $area)
                                <option value="{{$area->intAutoID}}">{{$area->strAreaName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="printerbarcodeless">Printer</label>
                        <select  class="form-select w-100" id="printerbarcodeless"  required>
                            <option></option>
                            @foreach($printers as $printer)
                                <option value="{{$printer->strPrinter}}">{{$printer->strPrinter}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success w-100" id="printBarcodeless">PRINT</button>
                </div> 
            </div>
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
        document.getElementById("defaultOpen").click();

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");

        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

        $('#jobid').change(function(){
            $.ajax({

                url: '{!!url("/getproductbyjobid")!!}',
                type: "GET",
                data: {
                    jobid: $('#jobid').val()
                },
                success: function (data) {
                    $('#department').val(data[0]['DepartmentName']);
                    $('#departmentId').val(data[0]['DeptID']);
                    $('#category').val(data[0]['strItemGroup']);
                    $('#categoryID').val(data[0]['intCategoryId']);
                    $('#product').val(data[0]['ProductDescription']);
                    $('#productCode').val(data[0]['ItemCode']);
                    $('#barcode').val(data[0]['Barcode']);
                    $.ajax({

                        url: '{!!url("/getProductInfoAppend")!!}',
                        type: "GET",
                        data: {
                            productCode: $('#productCode').val(),
                        },
                        success: function (dataappend) {
                            var toAppend = '';
                            $("#configuration").empty();
                            toAppend += '<option></option>';
                            $.each(dataappend,function(i,o){

                                toAppend += '<option value="'+o.pack+'">'+o.packdesc+'</option>';
                            });
                            $("#configuration").append(toAppend);

                            $.ajax({

                                url: '{!!url("/getProductInfo")!!}',
                                type: "GET",
                                data: {
                                    productCode: $('#productCode').val(),
                                },
                                success:function(data){

                                        $('#configuration').val(data[0]['intPackSize']);
                                        
                                }});
                                
                            }

                    });
                }

            });
        });

        $('#print').click(function(){
            $.ajax({

                url: '{!!url("/printgenericpalletlabel")!!}',
                type: "POST",
                data: {
                    department: $('#departmentId').val(),
                    category: $('#categoryID').val(),
                    product: $('#productCode').val(),
                    labelType: $('#labelType').val(),
                    configuration: $('#configuration').val(),
                    qty: $('#qty').val(),
                    weight: $('#weight').val(),
                    barcode: $('#barcode').val(),
                    driver: $('#driver').val(),
                    forklift: $('#forklift').val(),
                    area: $('#area').val(),
                    printer: $('#printer').val()
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

        $('#printBarcodeless').click(function(){
            $.ajax({

                url: '{!!url("/printgenericpalletlabel")!!}',
                type: "POST",
                data: {
                    department: $('#departmentBarcodeless').val(),
                    category: $('#categoryBarcodeless').val(),
                    product: $('#productBarcodeless').val(),
                    labelType: $('#labelTypeBarcodeless').val(),
                    configuration: $('#configurationBarcodeless').val(),
                    quantity: $('#quantityBarcodeless').val(),
                    weight: $('#weightBarcodeless').val(),
                    barcode: $('#barcodeBarcodeless').val(),
                    driver: $('#driverBarcodeless').val(),
                    forklift: $('#forkliftBarcodeless').val(), 
                    area: $('#areaBarcodeless').val(),
                    printer: $('#printerbarcodeless').val()
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

        $('#departmentBarcodeless').change(function(){
            $.ajax({

                url: '{!!url("/getDepListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#departmentBarcodeless option:selected').text(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#categoryBarcodeless").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.intAutoGroupCategoryId+'">'+o.strProductCategory+'</option>';
                    });
                    $("#categoryBarcodeless").append(toAppend);

                }

            });
        });

        $('#categoryBarcodeless').change(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#categoryBarcodeless option:selected').val(),
                },
                success: function (data) {
                    var toAppend = '';
                    $("#productBarcodeless").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                    });
                    $("#productBarcodeless").append(toAppend);

                }

            });
        });

        // $('#productBarcodeless').change(function(){
        //     $.ajax({

        //         url: '{!!url("/getProductInfoAppend")!!}',
        //         type: "GET",
        //         data: {
        //             productCode: $('#productBarcodeless option:selected').val(),
        //         },
        //         success: function (dataappend) {
        //             var toAppend = '';
        //             $("#configurationBarcodeless").empty();
        //             toAppend += '<option></option>';
        //             $.each(dataappend,function(i,o){
        //                 toAppend += '<option value="'+o.pack+'">'+o.packdesc+'</option>';
        //             });
        //             $("#configurationBarcodeless").append(toAppend);

        //             $.ajax({
        //                 url: '{!!url("/getProductInfo")!!}',
        //                 type: "GET",
        //                 data: {
        //                     productCode: $('#productBarcodeless option:selected').val(),
        //                 },
        //                 success:function(data){
        //                     $('#configurationBarcodeless').val(data[0]['intPackSize']);
        //                     $('#barcodeBarcodeless').val(data[0]['Barcode']);
        //                 }
        //             });
        //         }
        //     });
        // });

        $('#productBarcodeless').change(function(){
            $.ajax({
                url: '{!!url("/getProductInfo")!!}',
                type: "GET",
                data: {
                    productCode: $('#productBarcodeless option:selected').val(),
                },
                success:function(data){
                    $('#barcodeBarcodeless').val(data[0]['Barcode']);
                    var toAppend = '';
                    $("#configurationBarcodeless").empty();

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
                    $("#configurationBarcodeless").append(toAppend);
                }
            });
        });

        $('#labelTypeBarcodeless').change(function(){
            var type = $('#labelTypeBarcodeless').val();

            if (type == 'Pallet'){
                $("#configurationBarcodeless optgroup[label='Pallet']").prop('hidden', false);
                $("#configurationBarcodeless optgroup[label='Bundle']").prop('hidden', true);
                $("#configurationBarcodeless optgroup[label='Single']").prop('hidden', true);
                $("#configurationBarcodeless").val("");
                $("#configurationBarcodeless").prop('disabled', false);
            }else if (type == 'Bundle'){
                $("#configurationBarcodeless optgroup[label='Pallet']").prop('hidden', true);
                $("#configurationBarcodeless optgroup[label='Bundle']").prop('hidden', false);
                $("#configurationBarcodeless optgroup[label='Single']").prop('hidden', true);
                $("#configurationBarcodeless").val("");
                $("#configurationBarcodeless").prop('disabled', false);
            }else{
                $("#configurationBarcodeless optgroup[label='Pallet']").prop('hidden', true);
                $("#configurationBarcodeless optgroup[label='Bundle']").prop('hidden', true);
                $("#configurationBarcodeless optgroup[label='Single']").prop('hidden', false);
                $("#configurationBarcodeless").val("1");
                $("#configurationBarcodeless").prop('disabled', true);

            }
        });

        $('#scaleIDBarcodeless').change(function(){
            fetchWeight();
            fetchweightBarcodeless();
            
            toggleWeigh();
            toggleWeighBarcodeless();
        });

        $('#scaleID').change(function(){
            fetchWeight();
            fetchweightBarcodeless();
            
            toggleWeigh();
            toggleWeighBarcodeless();
        });

        // setInterval(fetchWeight,1000);

    });

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function openPage(pageName, elmnt, elementid) {
    // Hide all elements with class="tabcontent" by default */
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remove the background color of all tablinks/buttons
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }

    // Remove the upper tabs class active
    var uppertabs = document.getElementsByClassName("nav-link active");
    $('#'+uppertabs[0].id).removeClass("active");
    $('#'+elementid).addClass("active");
    // Show the specific tab content
    document.getElementById(pageName).style.display = "block";
    $('#weight').val('');
    $('#weightBarcodeless').val('');

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

function toggleWeigh(){
    setInterval(fetchWeight,2000);
};

function toggleWeighBarcodeless(){
    setInterval(fetchweightBarcodeless,2000);
};

function fetchWeight(){
    
    // console.debug("weigh");
    $.ajax({
        url: '{!!url("/listenToScale")!!}',
        type: "GET",
        data: {
            scaleID: $('#scaleID option:selected').val(),
        },
        success: function (data) {
            $('#weight').val(data);
        }
    });
};

function fetchweightBarcodeless(){
    // console.debug("weigh Barcodeless");
    $.ajax({
        url: '{!!url("/listenToScale")!!}',
        type: "GET",
        data: {
            scaleID: $('#scaleIDBarcodeless option:selected').val(),
        },
        success: function (data) {
            $('#weightBarcodeless').val(data);
        }
    });
};

</script>
</body>
