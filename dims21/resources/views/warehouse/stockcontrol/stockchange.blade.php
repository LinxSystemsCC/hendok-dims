<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('resources\css\jobmodulestyle.css') }}">
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <title>Stock Change</title>

 
  <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.compact.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>


    <!-- Select2 CSS -->


    <style>
        .red-message {
            color: red;
            border-color: red;
        }

    </style>
</head>

<body>
    <div class="d-flex vh-100" style="background: white;">
        <!-- Sidebar -->
        <div class="col-custom-2" style="background: white;">
            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>

        <!-- Main Content -->
        <div class="col overflow-auto p-4">
            <h4 class="text-center fw-bold mb-4">Stock Change to B-Grade</h4>

            <div class="row">
                <!-- Change Product From -->
                <div class="col-md-6">
                    <strong class="mb-3 d-block">Change Product from:</strong>
                    {{-- Department --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="department">Department</label>
                        <small class="text-danger" id="error_from_dep" style="display: none">This field is required</small>

                        <select class="form-select select2" id="department" required>
                            <option></option>
                            @foreach($dept as $val)
                            <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Product Category --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="category">Product Category </label>
                        <small class="text-danger" id="error_from_cat" style="display: none">This field is required</small>

                        <select class="form-select" id="category" required>
                            <option></option>
                        </select>
                    </div>


                    {{-- Product --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="product">Product </label>
                        <small class="text-danger" id="error_from_product" style="display: none">This field is required</small>
                        <select class="form-select" id="product" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label">Select DC </label>
                        <select name="from_dc" class="form-select" id="from_dc">
                            <small class="text-danger" id="error_from_dc" style="display: none">This field is required</small>

                            <option value=""></option>
                            @foreach ($dcData as $val)
                            <option value="{{ $val->intAutoId }}">{{ $val->strDCName }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group mb-2">
                        <label class="control-label">Select Warehouse </label>
                        <small class="text-danger" id="error_from_wh" style="display: none">This field is required</small>
                        <select name="from_warehouse" class="form-select" id="from_warehouse">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label>Select Zone</label>
                        <small class="text-danger" id="error_from_zone" style="display: none">This field is required</small>
                        <select name="from_zone" id="from_zone" class="form-select"></select>
                    </div>

                    {{-- Label Type --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="labelType">Label Type</label>
                        <small class="text-danger" id="error_label_type" style="display: none">This field is required</small>
                        <select class="form-select input-sm w-100" id="labelType" required>
                            <option></option>
                        </select>
                    </div>


                    {{-- Quantity --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="quantity">Quantity </label>
                        <small class="text-danger" id="error_quantity" style="display: none">This field is requireds</small>
                        <input type="number" class="form-control" id="quantity" required>
                    </div>

                </div>

                <!-- Change Product To -->
                <div class="col-md-6">
                    <strong class="mb-3 d-block">Change Product to:</strong>
                    <div class="form-group">
                        <label for="stock_type">Stock Change Type</label>
                        <small class="text-danger" id="error_stock_type" style="display: none">This field is required</small>
                        <select class="form-select" id="stock_type">
                            <option value=""></option>
                            <option value="Normal Stock">Normal Stock</option>
                            <option value="B-Grade">B-Grade</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="to_department">Department</label>
                        <small class="text-danger" id="error_to_department" style="display: none">This field is required</small>
                        <select class="form-select select2" id="to_department">
                            <option></option>
                            @foreach($dept as $val)
                            <option value="{{ $val->intAutoID }}">{{ $val->strDeptName }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="to_category">Product Category</label>
                        <small class="text-danger" id="error_to_category" style="display: none">This field is required</small>
                        <select class="form-select" id="to_category"></select>
                    </div>


                    <div class="form-group">
                        <label for="to_product">Product</label>
                        <small class="text-danger" id="error_to_product" style="display: none">This field is required</small>
                        <select class="form-select" id="to_product"></select>
                    </div>

                    <div class="form-group">
                        <label for="to_dc">Select DC</label>
                        <small class="text-danger" id="error_to_dc" style="display: none">This field is required</small>
                        <select name="to_dc" class="form-select" id="to_dc">
                            <option></option>
                            @foreach ($dcData as $val)
                            <option value="{{ $val->intAutoId }}">{{ $val->strDCName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="to_warehouse">Select Warehouse</label>
                        <small class="text-danger" id="error_to_wh" style="display: none">This field is required</small>
                        <select name="to_warehouse" class="form-select" id="to_warehouse">
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="to_zone">Select Zone</label>
                        <small class="text-danger" id="error_to_zone" style="display: none">This field is required</small>
                        <select name="to_zone" class="form-select" id="to_zone"></select>
                    </div>


                    <div class="form-group" id="hideWeight" style="display: none;">
                        <label for="TypeWeight">Type Weight</label>
                        <small class="text-danger" id="error_weight" style="display: none">This field is required</small>
                        <input type="number" class="form-control" id="TypeWeight">
                    </div>
                </div>
            </div>
            <button class="btn btn-success" id="btnChangeProduct" style="width: 50%; margin-right: 10px;">Change Product</button>

        </div>
    </div>

    <!-- Scripts go here -->



    <!-- jQuery -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

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
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });
        $(document).ready(function() {


            $('.form-select').select2({
                theme: 'bootstrap-5'
                , placeholder: "Select an option"
                , allowClear: true
            });


            // Handle dropdown change to show/hide the TypeWeight field
            $('#stock_type').on('change', function() {
                const stockType = $(this).val();

                if (stockType === 'B-Grade') {
                    $('#hideWeight').show();



                } else {
                    $('#hideWeight').hide();
                    $('#error_weight').hide(); // Hide the error if not B-Grade
                    $('#TypeWeight').val(''); // Clear value if not needed
                }
            });



            const allBins = @json($bins);


            //From Dropdwon
            $('#department').change(function() {
                $.ajax({

                    url: '{!!url("/getDepListToPlan")!!}'
                    , type: "GET"
                    , data: {
                        ItemGroup: $('#department option:selected').text(),

                    }
                    , success: function(data) {
                        var toAppend = '';
                        $("#category").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + o.intAutoGroupCategoryId + '">' + o.strProductCategory + '</option>';
                        });
                        $("#category").append(toAppend);

                    }

                });
            });

            $('#from_dc').change(function() {
                const selectedDcId = $(this).val();

                const filteredWarehouses = [...new Map(
                    allBins
                    .filter(bin => bin.intDcId == selectedDcId)
                    .map(bin => [bin.intLocationId, bin])
                ).values()];

                let warehouseOptions = '<option value="">Select Warehouse</option>';
                filteredWarehouses.forEach(wh => {
                    warehouseOptions += `<option value="${wh.intLocationId}">${wh.strLocationName}</option>`;
                });

                $('#from_warehouse').html(warehouseOptions);
                $('select[name="from_zone"]').html('<option value="">Select Zone</option>');
            });

            $('#from_warehouse').change(function() {
                const selectedDcId = $('#from_dc').val();
                const selectedLocationId = $(this).val();

                const filteredZones = allBins.filter(
                    bin => bin.intDcId == selectedDcId && bin.intLocationId == selectedLocationId
                );

                let zoneOptions = '<option value="">Select Zone</option>';
                filteredZones.forEach(zone => {
                    zoneOptions += `<option value="${zone.intBinId}">${zone.strBin}</option>`;
                });

                $('select[name="from_zone"]').html(zoneOptions);
            });

            $('#category').change(function() {
                $.ajax({

                    url: '{!!url("/getProdListToPlan")!!}'
                    , type: "GET"
                    , data: {
                        ItemGroup: $('#category option:selected').val(),

                    }
                    , success: function(data) {
                        var toAppend = '';
                        $("#product").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + o.strItemCode + '">' + o.strItemName + '</option>';
                        });
                        $("#product").append(toAppend);

                    }

                });
            });

            $('#product').change(function() {

                $.ajax({
                    url: '{!!url("/getProductInfo")!!}'
                    , type: "GET"
                    , data: {
                        productCode: $('#product option:selected').val()
                    , }
                    , success: function(data) {

                        var toAppend = '';
                        $("#configuration").empty();

                        toAppend += '<optgroup label="Single" hidden>';
                        toAppend += '<option></option>';
                        toAppend += '<option value = "1">1</option>';
                        toAppend += '</optgroup>';

                        $.each(data, function(i, o) {
                            if (o.strBundleSize !== null) {
                                var bundleSize = o.strBundleSize.split(';');

                                toAppend += '<optgroup label="Bundle" hidden>';
                                toAppend += '<option></option>';
                                $.each(bundleSize, function(index, value) {
                                    toAppend += '<option value="' + value + '">' + value + ' / bundle</option>';
                                })
                                toAppend += '</optgroup>';
                            }

                            if (o.strPackSize !== null) {
                                var packSizes = o.strPackSize.split(';');

                                toAppend += '<optgroup label="Pallet" hidden>';
                                toAppend += '<option></option>';
                                $.each(packSizes, function(index, value) {
                                    toAppend += '<option value="' + value + '">' + value + ' / pallet</option>';
                                })
                                toAppend += '</optgroup>';
                            }

                        });

                        $("#configuration").append(toAppend);

                        var addType = '';
                        $("#labelType").empty();
                        addType += '<option></option>';

                        if (data[0]['intHasSingleLable'] == "1") {
                            addType += '<option value = "Single">Single</option>';
                        }
                        if (data[0]['intHasBundleLable'] == "1") {
                            addType += '<option value = "Bundle">Bundle</option>';
                        }
                        if (data[0]['intHasPalletLable'] == "1") {
                            addType += '<option value = "Pallet">Pallet</option>';
                        }

                        $("#labelType").append(addType);

                        $('#barcode').val(data[0]['Barcode']);

                        if (data[0]["Barcode"] == '0000000000000') {
                            $('#barcode').addClass('red-message');
                            $('#barcodeHelp').addClass('red-message');
                            $('#barcodeHelp').prop('hidden', false);

                        } else {
                            $('#barcode').removeClass('red-message');
                            $('#barcodeHelp').removeClass('red-message');
                            $('#barcodeHelp').prop('hidden', true);
                        }

                    }
                });
            });

            $('#labelType').change(function() {
                var type = $('#labelType').val();

                if (type == 'Pallet') {
                    $("#configuration optgroup[label='Pallet']").prop('hidden', false);
                    $("#configuration optgroup[label='Bundle']").prop('hidden', true);
                    $("#configuration optgroup[label='Single']").prop('hidden', true);
                    $("#configuration").val("");
                    $("#configuration").prop('disabled', false);
                } else if (type == 'Bundle') {
                    $("#configuration optgroup[label='Pallet']").prop('hidden', true);
                    $("#configuration optgroup[label='Bundle']").prop('hidden', false);
                    $("#configuration optgroup[label='Single']").prop('hidden', true);
                    $("#configuration").val("");
                    $("#configuration").prop('disabled', false);
                } else {
                    $("#configuration optgroup[label='Pallet']").prop('hidden', true);
                    $("#configuration optgroup[label='Bundle']").prop('hidden', true);
                    $("#configuration optgroup[label='Single']").prop('hidden', false);
                    $("#configuration").val("1");
                    $("#configuration").prop('disabled', true);
                    var config = $('#configuration').val();
                    $('#inputConfiguration').val(config);

                }
            });



            //To Dropdown
            $('#to_department').change(function() {
                $.ajax({

                    url: '{!!url("/getDepListToPlan")!!}'
                    , type: "GET"
                    , data: {
                        ItemGroup: $('#to_department option:selected').text(),

                    }
                    , success: function(data) {
                        var toAppend = '';
                        $("#to_category").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + o.intAutoGroupCategoryId + '">' + o.strProductCategory + '</option>';
                        });
                        $("#to_category").append(toAppend);

                    }

                });
            });

            //TO DC
            $('#to_dc').change(function() {
                const selectedDcId = $(this).val();

                const filteredWarehouses = [...new Map(
                    allBins
                    .filter(bin => bin.intDcId == selectedDcId)
                    .map(bin => [bin.intLocationId, bin])
                ).values()];

                let warehouseOptions = '<option value="">Select Warehouse</option>';
                filteredWarehouses.forEach(wh => {
                    warehouseOptions += `<option value="${wh.intLocationId}">${wh.strLocationName}</option>`;
                });

                $('#to_warehouse').html(warehouseOptions);
                $('select[name="to_zone"]').html('<option value="">Select Zone</option>');
            });

            //TO Warehouse 
            $('#to_warehouse').change(function() {
                const selectedDcId = $('#to_dc').val();
                const selectedLocationId = $(this).val();

                const filteredZones = allBins.filter(
                    bin => bin.intDcId == selectedDcId && bin.intLocationId == selectedLocationId
                );

                let zoneOptions = '<option value="">Select Zone</option>';
                filteredZones.forEach(zone => {
                    zoneOptions += `<option value="${zone.intBinId}">${zone.strBin}</option>`;
                });

                $('select[name="to_zone"]').html(zoneOptions);
            });

            //To Category
            $('#to_category').change(function() {
                $.ajax({

                    url: '{!!url("/getProdListToPlan")!!}'
                    , type: "GET"
                    , data: {
                        ItemGroup: $('#category option:selected').val(),

                    }
                    , success: function(data) {
                        var toAppend = '';
                        $("#to_product").empty();
                        toAppend += '<option></option>';
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + o.strItemCode + '">' + o.strItemName + '</option>';
                        });
                        $("#to_product").append(toAppend);

                    }

                });
            });


            $('#to_product').change(function() {

                $.ajax({
                    url: '{!!url("/getProductInfo")!!}'
                    , type: "GET"
                    , data: {
                        productCode: $('#product option:selected').val()
                    , }
                    , success: function(data) {

                        var toAppend = '';
                        $("#configuration").empty();

                        toAppend += '<optgroup label="Single" hidden>';
                        toAppend += '<option></option>';
                        toAppend += '<option value = "1">1</option>';
                        toAppend += '</optgroup>';

                        $.each(data, function(i, o) {
                            if (o.strBundleSize !== null) {
                                var bundleSize = o.strBundleSize.split(';');

                                toAppend += '<optgroup label="Bundle" hidden>';
                                toAppend += '<option></option>';
                                $.each(bundleSize, function(index, value) {
                                    toAppend += '<option value="' + value + '">' + value + ' / bundle</option>';
                                })
                                toAppend += '</optgroup>';
                            }

                            if (o.strPackSize !== null) {
                                var packSizes = o.strPackSize.split(';');

                                toAppend += '<optgroup label="Pallet" hidden>';
                                toAppend += '<option></option>';
                                $.each(packSizes, function(index, value) {
                                    toAppend += '<option value="' + value + '">' + value + ' / pallet</option>';
                                })
                                toAppend += '</optgroup>';
                            }

                        });

                        $("#configuration").append(toAppend);

                        var addType = '';
                        $("#labelType").empty();
                        addType += '<option></option>';

                        if (data[0]['intHasSingleLable'] == "1") {
                            addType += '<option value = "Single">Single</option>';
                        }
                        if (data[0]['intHasBundleLable'] == "1") {
                            addType += '<option value = "Bundle">Bundle</option>';
                        }
                        if (data[0]['intHasPalletLable'] == "1") {
                            addType += '<option value = "Pallet">Pallet</option>';
                        }

                        $("#labelType").append(addType);

                        $('#barcode').val(data[0]['Barcode']);

                        if (data[0]["Barcode"] == '0000000000000') {
                            $('#barcode').addClass('red-message');
                            $('#barcodeHelp').addClass('red-message');
                            $('#barcodeHelp').prop('hidden', false);

                        } else {
                            $('#barcode').removeClass('red-message');
                            $('#barcodeHelp').removeClass('red-message');
                            $('#barcodeHelp').prop('hidden', true);
                        }

                    }
                });
            });

            $('#btnChangeProduct').click(function() {
                let isValid = true;

                if ($('#department').val() === '') {
                    $("#error_from_dep").show();
                    isValid = false;
                } else {
                    $("#error_from_dep").hide();
                }

                if ($('#category').val() === '') {
                    $("#error_from_cat").show();
                    isValid = false;
                } else {
                    $("#error_from_cat").hide();
                }

                if ($('#product').val() === '') {
                    $("#error_from_product").show();
                    isValid = false;
                } else {
                    $("#error_from_product").hide();
                }

                if ($('#from_dc').val() === '') {
                    $("#error_from_dc").show();
                    isValid = false;
                } else {
                    $("#error_from_dc").hide();
                }

                if ($('#from_warehouse').val() === '') {
                    $("#error_from_wh").show();
                    isValid = false;
                } else {
                    $("#error_from_wh").hide();
                }

                if ($('#from_zone').val() === '') {
                    $("#error_from_zone").show();
                    isValid = false;
                } else {
                    $("#error_from_zone").hide();
                }

                if ($('#labelType').val() === '') {
                    $("#error_label_type").show();
                    isValid = false;
                } else {
                    $("#error_label_type").hide();
                }

                if ($('#quantity').val() === '') {
                    $("#error_quantity").show();
                    isValid = false;
                } else {
                    $("#error_quantity").hide();
                }


                if ($('#to_dc').val() === '') {
                    $("#error_to_dc").show();
                    isValid = false;
                } else {
                    $("#error_to_dc").hide();
                }

                if ($('#to_warehouse').val() === '') {
                    $("#error_to_wh").show();
                    isValid = false;
                } else {
                    $("#error_to_wh").hide();
                }

                if ($('#to_zone').val() === '') {
                    $("#error_to_zone").show();
                    isValid = false;
                } else {
                    $("#error_to_zone").hide();
                }

                if ($('#to_product').val() === '') {
                    $("#error_to_product").show();
                    isValid = false;
                } else {
                    $("#error_to_product").hide();
                }


                if ($('#to_category').val() === '') {
                    $("#error_to_category").show();
                    isValid = false;
                } else {
                    $("#error_to_category").hide();
                }

                if ($('#to_department').val() === '') {
                    $("#error_to_department").show();
                    isValid = false;
                } else {
                    $("#error_to_department").hide();
                }




                //For Stock Type 
                const stockType = $('#stock_type').val();
                const typeWeight = $('#TypeWeight').val();

                // Validate stock_type
                if (stockType === '') {
                    $('#error_stock_type').show();
                    isValid = false;
                } else {
                    $('#error_stock_type').hide();
                }

                // Validate TypeWeight only if B-Grade is selected
                if (stockType === 'B-Grade') {
                    if (typeWeight === '') {
                        $('#error_weight').show();
                        isValid = false;
                    } else {
                        $('#error_weight').hide();
                    }
                }



                if (!isValid) return;

                // Proceed with AJAX
                const payload = {
                    department: $('#department').val()
                    , category: $('#category').val()
                    , product: $('#product').val()
                    , from_dc: $('#from_dc').val()
                    , from_warehouse: $('#from_warehouse').val()
                    , from_zone: $('#from_zone').val()
                    , label_type: $('#labelType').val()
                    , quantity: $('#quantity').val(), // ✅ Add comma here
                    to_department: $('#to_department').val()
                    , to_category: $('#to_category').val()
                    , to_dc: $('#to_dc').val()
                    , to_warehouse: $('#to_warehouse').val()
                    , to_zone: $('#to_zone').val()
                    , to_product: $('#to_product').val()
                    , type_weight: $('#TypeWeight').val()
                    , stockType: $('#stock_type').val(),

                };

           
                $.ajax({
                    url: "{{ route('change.stock') }}"
                    , method: "POST"
                    , data: payload
                    , success: function(response) {
                        alert("Success: " + response.message);
                    }
                    , error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Something went wrong");
                    }
                });
            });



        });

    </script>
</body>
</html>
