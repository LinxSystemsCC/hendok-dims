<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('resources\css\jobmodulestyle.css') }}">
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <title>{{ $department }} Label</title>

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
    <div class="col-6 p-3">
        <h3>Print {{ $department }} Lables</h3>
        {{-- Product Category --}}
        <div class="form-group">
            <label class="control-label" for="category"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Category </label>
            <select  class="form-control input-sm col-xs-1" id="category" style="width: 100%" required>
                <option></option>
            </select>
        </div>

        {{-- Product --}}
        <div class="form-group">
            <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
            <select  class="form-control input-sm col-xs-1" id="prodname" style="width: 100%" required>
                <option></option>
            </select>
        </div>

        {{-- Barcode --}}
        <div class="form-group">
            <label class="control-label" for="barcode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Barcode</label>
            <input class="form-control input-sm col-xs-1" id="barcode" style="width: 100%" required>
        </div>

        {{-- Quantity --}}
        <div class="form-group">
            <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Quantity</label>
            <input class="form-control input-sm col-xs-1" id="qty" style="width: 100%" required>
        </div>

        {{-- Product --}}
        <div class="form-group">
            <label class="control-label" for="printer"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Printer</label>
            <select  class="form-control input-sm col-xs-1" id="printer" style="width: 100%" required>
                <option></option>
                @foreach ($printers as $printer)
                    <option value="{{ $printer->intPrinterID }}">{{ $printer->strPrinterName }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary my-2 w-100" id="print">PRINT</button>
    </div>
    {{-- <div class="col-4 p-3">
        <iframe src="" width="100%" height="40%"></iframe>
    </div> --}}
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
        $('#category').select2({
            theme: 'bootstrap-5',
            // dropdownParent: $('#tbc'),
        });
        $('#prodname').select2({
            theme: 'bootstrap-5',
            // dropdownParent: $('#tbc'),
        });
        $('#printer').select2({
            theme: 'bootstrap-5',
            // dropdownParent: $('#tbc'),
        });

        $.ajax({

            url: '{!!url("/getDepListToPlan")!!}',
            type: "GET",
            data: {
                ItemGroup: '{{ $department }}',

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

        $('#category').change(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#category option:selected').val(),

                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                    });
                    $("#prodname").append(toAppend);

                }

            });
        });

        $('#prodname').change(function(){
            $.ajax({

                url: '{!!url("/getProductBarcode")!!}',
                type: "GET",
                data: {
                    productCode: $('#prodname option:selected').val(),

                },
                success: function (data) {
                    var barcode = data[0]["BarCode"];
                    console.debug(barcode);

                    if (barcode == null){
                        $('#barcode').val("0000000000000");
                    }else{
                        $('#barcode').val(barcode);
                    }
                    

                }

            });
        });

        $('#print').click(function(){
            $.ajax({
                url: '{!!url("/printLabelByDepartment")!!}',
                type: "POST",
                data: {
                    department: '{{ $department }}',
                    category: $('#category option:selected').text(),
                    product: $('#prodname option:selected').val(),
                    qty: $('#qty').val(),
                    barcode: $('#barcode').val()
                },
                success: function (data) {
                    if(data[0].Result =="SUCCESS")
                    {
                        
                    }else{
                        alert(data[0].Result);
                    }
                }
            });
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