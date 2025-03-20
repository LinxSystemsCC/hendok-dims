<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="{{ url('images/dimslogo.png') }}">
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <title>DIMS Dashboard</title>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 90vh;
            margin: 0;
        }

            /* Ensure the select dropdown matches input height */
            .select2-container .select2-selection--single {
        height: 45px !important; /* Match input height */
        padding: 6px 12px !important;
        font-size: 1rem;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }

    .select2-container .select2-selection__rendered {
        line-height: 32px !important;
    }

    .select2-container .select2-selection__arrow {
        height: 100% !important;
    }

    </style>

</head>

<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="text-center mb-0">SCAN INTO STOCK 

                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="scanForm">
                            @csrf
                    
                            <!-- Validation Message -->
                            <div id="qr_error" class="alert alert-danger d-none">
                                QR Code must contain only numbers, include a single pipe `|`, and have numbers after the pipe without spaces.
                            </div>
                    
                            <div class="mb-3">
                                <label for="qr_code" class="form-label fw-bold">QR CODE</label>
                                <input type="text" id="qr_code" name="qr_code" class="form-control" placeholder="Enter or Scan QR Code" required>
                            </div>
                    
                            <div class="mb-3">
                                <label for="bin_select" class="form-label fw-bold">SELECT BIN</label>
                                <select id="bin_select" name="bin" class="form-control custom-select" required>
                                    <option value="">Select Bin</option>
                                    @foreach($StockData as $bin)
                                        <option value="{{ $bin->intBinId }}">{{ $bin->strBin }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <input type="hidden" id="dtmItemScanned" name="dtmItemScanned">
                    
                            <div class="d-grid">
                                <button type="submit" id="submit_btn" class="btn btn-danger btn-lg" disabled>PUSH INTO STOCK</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


</div>

    <!-- jQuery Validation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize select2 for better dropdown
            $('#bin_select').select2({
                placeholder: "Select a Bin",
                allowClear: true, // Allows clearing the selection
                width: '100%' // Makes sure it uses full width
            });
    
            $("#qr_code").on("input", function() {
                let qrValue = $(this).val();
                let qrPattern = /^\d+\|\d+$/; // Any number of digits before and after "|"
    
                if (qrPattern.test(qrValue) && !qrValue.includes(" ")) { // Ensure no spaces
                    $("#qr_error").addClass("d-none");  // Hide error
                    $("#submit_btn").prop("disabled", false); // Enable button
                    $("#dtmItemScanned").val(new Date().toISOString().slice(0, 19).replace("T", " ")); // Set dtmItemScanned
                } else {
                    $("#qr_error").removeClass("d-none");  // Show error
                    $("#submit_btn").prop("disabled", true); // Disable button
                }
            });
    
            $("#scanForm").on("submit", function(e) {
                e.preventDefault();
    
                let formData = {
                    qr_code: $("#qr_code").val(),
                    bin_id: $("#bin_select").val(),
                    dtmItemScanned: $("#dtmItemScanned").val(),
                    _token: "{{ csrf_token() }}"
                };
    
                $.ajax({
                    url: "{{ route('store.scan') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        alert("Scan successfully stored!");
                        $("#scanForm")[0].reset();
                        $("#bin_select").val("").trigger('change'); // Reset dropdown with Select2
                        $("#submit_btn").prop("disabled", true);
                    },
                    error: function(xhr) {
                        console.log("Error Response:", xhr.responseText);
                        alert("Something went wrong. Error: " + xhr.responseText); // Display full error
                    }
                });
            });
        });
    </script>


<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Excel Saver -->
<script src="{{ asset('js/exceljs.min.js') }}"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="{{ asset('js/dx.all.js') }}"></script>

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
</script>
