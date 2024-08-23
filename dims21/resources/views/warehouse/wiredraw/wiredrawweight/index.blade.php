@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'WireDraw Machines')

@php
    $includeMenu = false;
@endphp

@section('page')

    <!-- Modal -->
    <div class="modal modal-lg fade" id="Weigh" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel"></h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <input type="number" class="form-control" id="fltweight" name="fltweight">
                    </div>

                    <div class="form-group mt-2">
                        <label class="control-label" for="ftlfinalweight">Final Tare Weight</label>
                        <input type="text" class="form-control" id="ftlfinalweight" name="ftlfinalweight" disabled>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal"
                        id="close">Close</button>
                    <button type="button" id="save" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

    @include('warehouse.wiredraw.addrod')

    <div class="logoutbtn" style="display: flex; margin-bottom: 1pc;">
        <button class="btn btn-dark d-flex justify-content-center align-items-center" style="width:75px; margin-right: 1pc;"
            onclick="document.getElementById('logout-form').submit()">
            <i class="bi bi-door-open h4"></i>
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <h2>WireDraw Machines</h2>
    </div>
    <div class="accordion" id="accordionFlush">
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
                                    <tr
                                        data-machinename="{{ $machineName }}"
                                        data-jobnocustom="{{ $job->intHeaderIdcustom }}"
                                        data-jobno="{{ $job->intHeaderId }}"
                                        data-standno="{{ $job->intNoOfStand + 1 }}"
                                        data-productname="{{ $job->strProductName }}"
                                        data-product-id="{{ $job->intProductId }}"
                                        data-job-id="{{ $job->intHeaderId }}"
                                    >
                                        <td>
                                            JobNo: {{ $job->intHeaderIdcustom }}
                                        </td>
                                        <td>
                                            Stand: {{ $job->intNoOfStand + 1 }}
                                        </td>
                                        <td>
                                            Product Name: {{ $job->strProductName }}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm mb-1 add_weight">Add Weight</button>
                                            <button class="btn btn-secondary btn-sm mb-1 open_rod_modal is_from_weight">Add Rod</button>
                                        </td>
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
            var finalweight = 0;
            var standMass = @json($standMass);

            $('#intStandId').change(function() {
                var intStandIdValue = $('#intStandId').val();
                if (standMass.hasOwnProperty(intStandIdValue)) {
                    finalweight = -standMass[intStandIdValue];
                    $('#ftlfinalweight').val(finalweight);
                }
                if ($('#intStandId').val() == '') {
                    $('#ftlfinalweight').val('');
                }
                if ($('#fltweight').val() != '') {
                    calculateFinalWeight(
                        $('#intStandId option:selected').data('stand-mass'),
                        parseFloat($('#fltweight').val())
                    );
                }
            });

            $('#fltweight').keyup(function() {
                calculateFinalWeight(
                    $('#intStandId option:selected').data('stand-mass'),
                    parseFloat($('#fltweight').val())
                );
            });

            $('.add_weight').click(function() {
                let curTR = $(this).parents('tr:first');
                currentSelectedIntproductId = curTR.attr('data-product-id');
                currentSelectedIntjobNo = curTR.attr('data-job-id');
                $('#strMachines').val(curTR.attr('data-machinename'));
                $('#intjobNumber').val(curTR.attr('data-jobnocustom'));
                $('#intstand').val(curTR.attr('data-standno'));
                $('#intproductId').val(curTR.attr('data-productname'));
                $('#Weigh').modal('show');
            });


            $('#Weigh').on('hidden.bs.modal', function() {
                $(this).find('.errorClass').hide();
                $('#general-error').hide();
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
        //This function is used for calculate final tare weight
        function calculateFinalWeight(tareWeight, fltweightValue) {
            var newFinalWeight = fltweightValue - tareWeight
            if (isNaN(newFinalWeight)) {
                newFinalWeight = finalweight
            }
            if ($('#intStandId').val() != '') {
                $('#ftlfinalweight').val(newFinalWeight);
            }
        }
    </script>

    @yield('rod_scripts')
@endsection
