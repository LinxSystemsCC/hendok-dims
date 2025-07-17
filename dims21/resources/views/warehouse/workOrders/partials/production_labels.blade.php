@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Print Products')

@php
    $includeMenu = false;

    $userDepartment = Auth::user()->strPickingTeams;

    if (Auth::guest()) {
        $backButton = '0';
        $logoutButton = '0';
        return redirect('home');
    } else {
        $backButton = '1';
        $logoutButton = '1';

        if ($hasRedirect) {
            if (strpos($userDepartment, '|') !== false) {
                $backButton = '0';
                $logoutButton = '1';
            } else {
                $backButton = '1';
                $logoutButton = '0';
            }
        } else {
            $backButton = '1';
            $logoutButton = '0';
        }
    }
@endphp

@section('page')

    <div class="col-lg-12">
        <div class="d-flex">
            @if ($backButton != '0')
                <button class="btn btn-dark d-flex justify-content-center align-items-center p-3"
                    onclick="location.href='{!! url('/production_machines') !!}/{{ $department }}'">
                    <i class="bi bi-arrow-return-left text-center h4 pt-2"></i>
                </button>
            @endif

            @if ($logoutButton != '0')
                <button class="btn btn-dark d-flex justify-content-center align-items-center p-3" onclick="document.getElementById('logout-form').submit()">
                    <i class="bi bi-door-open h4 m-0"></i>
                </button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            @endif

            <div class="ps-3">
                @foreach ($departments as $val)
                    <h3 class="mb-1">Department: {{ $val->strDeptName }}</h3>
                    <input type="hidden" id="deptid" value="{{ $val->intAutoID }}">
                @endforeach

                @foreach ($machines as $val)
                    <h3 class="mb-1">Machine: {{ $val->strMachineName }}</h3>
                    <input type="hidden" id="machineid" value="{{ $val->intMachineID }}">
                @endforeach
            </div>
        </div>
        <br>

        <h2 id='batchRef'>Reference: NONE</h2>
        @foreach ($products as $val)
            @if ($loop->first)
                <div class="d-flex w-100 mb-2">
                    <button class="btn btn-danger rounded-0 rounded-start p-3 fs-6">
                        {{ $val->intSequence }}
                    </button>

                    <button class="btn btn-danger rounded-0 rounded-end text-start p-3 w-100 fs-6" id="btnPrintModal"
                        data-id="{{ $val->intAutoJobId }}" data-bs-toggle="modal" data-bs-target="#modalPrint">
                        {{ $val->strProductDescription }} | {{ $val->strPackToCut }} | {{ $val->strProductStats }}
                    </button>
                </div>
            @else
                <div class="d-flex w-100 mb-2">
                    <button class="btn btn-danger rounded-0 rounded-start p-3 fs-6" disabled>
                        {{ $val->intSequence }}
                    </button>

                    <button class="btn btn-danger rounded-0 rounded-end text-start p-3 w-100 fs-6" disabled>
                        {{ $val->strProductDescription }} | {{ $val->strPackToCut }} | {{ $val->strProductStats }}
                    </button>
                </div>
            @endif
        @endforeach

    </div>

    {{-- Add a new bootstrap modal --}}
    <!-- Modal -->
    <div class="modal fade" id="modalPrint" tabindex="-1" aria-labelledby="modalPrintLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title fs-3" id="modalPrintLabel">PRINT JOB</h5>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">

                    <!-- Quantity Input -->
                    <div class="mb-4">
                        <input type="number" id="quantityInput" class="form-control form-control-lg text-center fw-bold"
                            style="font-size: 3rem;" value="0" min="0" readonly>
                    </div>

                    <!-- Control Buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-danger btn-lg px-5 py-3 fw-bold w-100" id="btnDecrease"
                            style="font-size: 2rem;">−</button>
                        <button class="btn btn-success btn-lg px-5 py-3 fw-bold w-100" id="btnIncrease"
                            style="font-size: 2rem;">＋</button>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-lg px-4" data-bs-dismiss="modal">CLOSE</button>
                    <button type="button" class="btn btn-primary btn-lg px-4" id="btnPrint">PRINT</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        var Jobs = {!! json_encode($products) !!};
        let currentJob = null;
        let reloadTimeout = null;

        $(document).ready(function() {
            // Initially show the first job's reference
            if (Jobs.length !== 0) {
                var BatchRef = Jobs[0]['strReference'];
                $('#batchRef').text('Reference: ' + BatchRef);
            }

            // Handle "Print" modal open and set the current job
            $("#btnPrintModal").click(function() {
                let intAutoJobId = $(this).data('id');
                currentJob = Jobs.find(job => job.intAutoJobId == intAutoJobId);

                $('#quantityInput').val(currentJob.intDefaultToPrint);

                // Show the modal (if you're triggering it manually)
                $('#modalPrint').modal('show');
            });

            // Handle quantity increase
            $('#btnIncrease').on('click', function() {
                let qty = parseInt($('#quantityInput').val()) || 0;
                $('#quantityInput').val(qty + 1);
            });

            // Handle quantity decrease
            $('#btnDecrease').on('click', function() {
                let qty = parseInt($('#quantityInput').val()) || 0;
                if (qty > 0) {
                    $('#quantityInput').val(qty - 1);
                }
            });

            // Handle Print button
            $('#btnPrint').on('click', function() {
                let decQtyToPrint = $('#quantityInput').val();

                $('#btnPrint').prop('disabled', true);

                $.ajax({
                    url: '{!! url('/printWorkOrderLabel') !!}',
                    type: 'POST',
                    data: {
                        intAutoJobId: currentJob.intAutoJobId,
                        decQtyToPrint: decQtyToPrint,
                        strDepartment: currentJob.strDepartment,
                    },
                    success: function(data) {
                        DevExpress.ui.notify({
                            message: data.Message,
                            type: data.Status == '1' ? 'success': 'error',
                            displayTime: 5000,
                        });

                        $('#modalPrint').modal('hide');
                    },
                });
            });

            // Pause auto-reload when modal is shown
            $('#modalPrint').on('show.bs.modal', function() {
                if (reloadTimeout) {
                    clearTimeout(reloadTimeout);
                    reloadTimeout = null;
                }
                $('#btnPrint').prop('disabled', false);
            });

            // Reload immediately when modal is closed
            $('#modalPrint').on('hidden.bs.modal', function() {
                window.location.reload();
            });

            // Start 15s auto-reload timeout
            reloadTimeout = setTimeout(function() {
                window.location.reload();
            }, 15000);

        });
    </script>

@endsection
