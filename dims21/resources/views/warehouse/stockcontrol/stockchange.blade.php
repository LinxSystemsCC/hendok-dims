<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('resources\css\jobmodulestyle.css') }}">
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <title>Stock Change</title>

    <!-- CSS only -->
        <link href="{{ asset(path: 'bootstrap/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous">


            <link href="{{ asset(path: 'bootstrap/select2.min.css') }}" rel="stylesheet" crossorigin="anonymous">

                        <link href="{{ asset(path: 'bootstrap/select2.min.css') }}" rel="stylesheet" crossorigin="anonymous">


    <!-- Select2 CSS --> 
    <link rel="stylesheet" href="{{ asset(path: 'bootstrap/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" crossorigin="anonymous"/>


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
                        <select class="form-select" id="category" required>
                            <option></option>
                        </select>
                    </div>


                    {{-- Product --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="product">Product Group </label>
                        <select class="form-select" id="productgrouop" required>
                            <option></option>
                        </select>
                    </div>


                    {{-- Product --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="product">Product </label>
                        <select class="form-select" id="product" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label">Select DC </label>
                        <select name="from_dc" class="form-select" id="from_dc">
                            <option value=""></option>
                            @foreach ($dcData as $val)
                            <option value="{{ $val->intAutoId }}">{{ $val->strDCName }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group mb-2">
                        <label class="control-label">Select Warehouse </label>

                        <select name="from_warehouse" class="form-select" id="from_warehouse">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label>Select Zone</label>
                        <select name="from_zone" class="form-select"></select>
                    </div>

                    {{-- Label Type --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="labelType">Label Type</label>
                        <select class="form-select input-sm w-100" id="labelType" required>
                            <option></option>
                        </select>
                    </div>


                    {{-- Quantity --}}
                    <div class="form-group mb-2">
                        <label class="control-label" for="quantity">Quantity </label>
                        <input class="form-control" id="quantity" required>
                    </div>

                </div>

                <!-- Change Product To -->
                <div class="col-md-6">
                    <strong class="mb-3 d-block">Change Product to:</strong>

                    <div class="form-group">
                        <label for="to_department">Department</label>
                        <select class="form-select select2" id="to_department">
                            <option></option>
                            @foreach($dept as $val)
                                <option value="{{ $val->intAutoID }}">{{ $val->strDeptName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="to_category">Product Category</label>
                        <select class="form-select" id="to_category"></select>
                    </div>

                    <div class="form-group">
                        <label for="to_product_group">Product Group</label>
                        <select class="form-select" id="to_product_group"></select>
                    </div>

                    <div class="form-group">
                        <label for="to_product">Product</label>
                        <select class="form-select" id="to_product"></select>
                    </div>

                    <div class="form-group">
                        <label for="to_dc">Select DC</label>
                        <select name="to_dc" class="form-select" id="to_dc">
                            <option></option>
                            @foreach ($dcData as $val)
                                <option value="{{ $val->intAutoId }}">{{ $val->strDCName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="to_warehouse">Select Warehouse</label>
                        <select name="to_warehouse" class="form-select" id="to_warehouse">
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="to_zone">Select Zone</label>
                        <select name="to_zone" class="form-select" id="to_zone"></select>
                    </div>

             
                    <div class="form-group">
                        <label for="to_quantity">Type Weight</label>
                        <input class="form-control" id="TypeWeight">
                    </div>
                </div>
            </div>
                                                <button class="btn btn-success"  style="width: 50%; margin-right: 10px;">Change Product</button>

        </div>
    </div>

    <!-- Scripts go here -->



    <!-- jQuery -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

<script src="{{ asset('bootstrap/jquery.min.js') }}"></script>

<script src="{{ asset('bootstrap/select2.min.js') }}"></script>


{{-- 
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}

    <!-- Bootstrap -->
<script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }}"></script>


    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}

    <!-- DevExtreme library -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script> --}}

    <script src="{{ asset('bootstrap/dx.all.js') }}"></script>


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

            const allBins = @json($bins);

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

            $('#configuration').change(function() {
                var config = $('#configuration').val();
                $('#inputConfiguration').val(config);
            });

            $('.sidebar ul li a').on(function() {
                var id = $(this).attr('id');
                $('nav ul li ul.item-show-' + id).toggleClass("show");
                $('nav ul li #' + id + ' span').toggleClass("rotate");

            });

            $('.sidebar ul li a').click(function() {
                var id = $(this).attr('id');
                $('nav ul li ul.item-show-' + id).toggleClass("show");
                $('nav ul li #' + id + ' span').toggleClass("rotate");

            });

            $('nav ul li').click(function() {
                $(this).addClass("active").siblings().removeClass("active");
            });

        });

    </script>
</body>
</html>
