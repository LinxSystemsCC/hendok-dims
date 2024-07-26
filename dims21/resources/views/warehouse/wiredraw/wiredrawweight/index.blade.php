@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'WireDraw Machines')

@php
    $includeMenu = true;
@endphp

@section('page')

    <!-- Modal -->
    <div class="modal fade" id="Weigh" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="general-error"></div>

                    <div class="form-group">
                        <label class="control-label" for="intjobNumber">Machines</label>
                        <input type="text" class="form-control" id="strMachines" name="strMachines" disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="intjobNumber">Job No</label>
                        <input type="text" class="form-control" id="intjobNumber" name="intjobNumber" disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="intproductId">Product Name</label>
                        <input type="text" class="form-control" id="intproductId" name="intproductId" disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="intstand">Stand No</label>
                        <input type="text" class="form-control" id="intstand" name="intstand" disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="intStandId">Tare Weight</label>
                        <select class="form-select" id="intStandId">
                            <option value="" selected>Select Tare Weight</option>
                            @foreach ($standGuop as $standId => $standCollection)
                                @foreach ($standCollection as $stand)
                                    <option value="{{ $stand->intStandId }}" data-stand-mass="{{ $stand->fltStandMass }}">
                                        {{ $stand->strStandName }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="fltweight">Weight</label>
                        <input type="text" class="form-control" id="fltweight" name="fltweight">
                    </div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="ftlfinalweight">Final Tare Weight</label>
                        <input type="text" class="form-control" id="ftlfinalweight" name="ftlfinalweight" disabled>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">Close</button>
                    <button type="button" id="save" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion" id="accordionFlush">
        <h2>WireDraw Machines</h2>
        @foreach ($machines as $machineId => $machineName)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $machineId }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $machineId }}" aria-expanded="false"
                        aria-controls="collapse{{ $machineId }}">
                        {{ $machineName }}
                    </button>
                </h2>
                <div id="collapse{{ $machineId }}" class="accordion-collapse collapse"
                    aria-labelledby="heading{{ $machineId }}" data-bs-parent="#accordionFlush">
                    <div class="accordion-body tbl  p-3">
                        <table class="table table-bordered mb-0 tblwiredrawmachines">
                            <tbody>
                                @foreach ($machineWiseJobs[$machineId] as $job)
                                    <tr class="trofwiredrawmachines">
                                        <td scope="row" data-job-id="{{ $job->intHeaderId }}" class="tdofwiredrawmachines">JobNo:
                                            {{ $job->intHeaderIdcustom }}</td>
                                        <td scope="row" class="tdofwiredrawmachines">Stand: {{ $job->intNoOfStand + 1 }} </td>
                                        <td scope="row" data-product-id="{{ $job->intProductId }}" class="tdofwiredrawmachines">Product:
                                            {{ $job->strProductName }} </td>
                                    <tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

@section('scripts')
    <script>
        $('#intStandId').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#Weigh'),
        });

        $(document).ready(function() {

            var currentSelectedIntproductId = 0;
            var currentSelectedIntjobNo = 0;
            var machineName = "Ishan";
            
            // Add click event listener to all <tr> elements inside tables
            $('#accordionFlush').on('click', 'tr', function() {

                machineName = $(this).parents('.accordion-item:first').find('.accordion-header').text().trim();
                var jobNo = $(this).find('td:eq(0)').text().trim().split(': ')[1]; // Extract JobNo value
                var standNo = $(this).find('td:eq(1)').text().trim().split(': ')[1]; // Extract Stand value
                var productName = $(this).find('td:eq(2)').text().trim().split(': ')[1]; // Extract product value
                console.log(jobNo);
                console.log(productName);

                currentSelectedIntproductId = $(this).find('td:eq(2)').attr('data-product-id')
                currentSelectedIntjobNo = $(this).find('td:eq(0)').attr('data-job-id')
                $('#intjobNumber').val(jobNo);
                $('#intstand').val(standNo);
                $('#intproductId').val(productName);
                $('#strMachines').val(machineName);

                $('#fltweight').keyup(function() {
                    var tareWeight = $('#intStandId option:selected').data('stand-mass');
                    var fltweightValue = parseFloat($('#fltweight').val());
                    $('#ftlfinalweight').val(fltweightValue - tareWeight);
                });

                // Open the modal
                $('#Weigh').modal('show');
            });
            $('#save').click(function() {
                $.ajax({
                    url: '{{ route('wire-draw.weight.store') }}',
                    type: "POST",
                    data: {
                        intjobNumber: currentSelectedIntjobNo,
                        intproductId: currentSelectedIntproductId,
                        intstand: $('#intstand').val(),
                        intStandId: $('#intStandId').val(),
                        fltweight: $('#ftlfinalweight').val()
                    },
                    success: function(data) {
                        location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#Weigh"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });
            });
        });
    </script>

@endsection
