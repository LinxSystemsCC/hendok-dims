<!-- Add Rods Modal -->
<div id="addrod" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-labelledby="addrodLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="h5addrod">Add Wire Draw ROD</h5>
                <button type="button" class="btn-close rodsclose" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label" for="supplier" style="font-weight: 700;font-size: 15px;">Rod Supplier</label>
                        <select class="form-select dims-select3" type="text" id="intRodSupplier">
                            <option value="" selected>Select Rod Supplier</option>
                            @foreach ($suppliers as $val)
                                <option value="{{ $val->intRodSupplierId }}">{{ $val->strRodSupplierName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="rodcode" style="font-weight: 700;font-size: 15px;">Rod Code</label>
                        <select class="form-select dims-select3" type="text" id='strRodCode'>
                            <option value="" selected>Select Rod Code</option>
                            @foreach ($rodcodes as $val)
                                <option value="{{ $val->strPartNumber }}">{{ $val->strPartDescription }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="strCastNumber" class="col-form-label" style="font-weight: 700;font-size: 15px;">Cast Number</label>
                        <input type="text" class="form-control" id="strCastNumber" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="wiresize" style="font-weight: 700;font-size: 15px;">Serial Number</label>
                        <input type="text" class="form-control" id="strSerialNumber" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Batch Number</label>
                        <input type="text" class="form-control" id="strBatchNumber" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Rod Elongation</label>
                        <input type="number" class="form-control" id="fltRodElongation" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Rod MPa</label>
                        <input type="number" class="form-control" id="fltRodMpa" required>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="qty" style="font-weight: 700;font-size: 15px;">Rod Weigh</label>
                        <input type="number" class="form-control" id="fltRodWeigh" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rodsclose" data-bs-target="#addrod"
                    data-bs-toggle="modal" id="canceladdrod">Close</button>
                <button type="button" id="addrodsave" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="toastContainer"></div>
@section('rod_scripts')
    <script>
        $(document).ready(function() {
            var selectedJobId = 0;
            $('.dims-select3').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#addrod'),
            });
            $('.open_rod_modal').click(function() {
                if ($(this).hasClass('is_from_weight')) {
                    let curTR = $(this).parents('tr:first');
                    selectedJobId = curTR.attr('data-jobno');
                } else {
                    selectedJobId = getJobId();
                }
                $('#addrod').modal('show');
            });
            $('#addrod').on('hidden.bs.modal', function() {
                $(this).find('.errorClass').hide();
                $(this).find('#general-error').hide();
                $('#addrod').find('input').val('');
                $('#intRodSupplier').val('').trigger('change');
                $('#strRodCode').val('').trigger('change');
            });
            $('#addrodsave').click(function() {
                $.ajax({
                    url: '{!! url('wire-draw/headers/add-rod') !!}',
                    type: "POST",
                    data: {
                        intJobNumber: parseInt(selectedJobId),
                        intRodSupplier: $('#intRodSupplier').val(),
                        strRodCode: $('#strRodCode').val(),
                        strCastNumber: $('#strCastNumber').val(),
                        strSerialNumber: $('#strSerialNumber').val(),
                        strBatchNumber: $('#strBatchNumber').val(),
                        fltRodElongation: $('#fltRodElongation').val(),
                        fltRodMpa: $('#fltRodMpa').val(),
                        fltRodWeigh: $('#fltRodWeigh').val()
                    },
                    success: function(data) {
                        $("#addrod").modal("hide");
                        $("#toastContainer").dxToast({
                            message: "Data saved successfully!",
                            type: "success",
                            width: 230,
                            height: 50,
                            position: {
                                my: 'top right',
                                at: 'top right',
                            },
                            visible: true
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#addrod"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });
            });
        });
    </script>
@endsection
