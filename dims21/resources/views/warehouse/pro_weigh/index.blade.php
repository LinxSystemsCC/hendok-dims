@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Pro Weigh')


@php
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
        $includeMenu = true;
    }
@endphp


@section('page')

    <div class="container my-4">
        <h3>Pro-weigh adjustment module</h3>
        <div class="mb-3">
            <label for="ticket_number" class="form-label">Ticket Number</label>
            <input type="text" id="ticket_number" name="ticket_number" class="form-control" autocomplete="off"
                placeholder="Search ticket number...">
            <div id="ticketSuggestions" class="list-group w-100"
                style="z-index: 1000; max-height: 300px; overflow-y: auto;"></div>
        </div>

        <div class="mb-3">
            <label for="truck" class="form-label">Current Truck</label>
            <div class="input-group">
                <input type="text" id="truck" name="truck" class="form-control" placeholder="truck reg" readonly>
                <span class="input-group-text d-none" id="truckLoader">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="trailer1" class="form-label">Trailer 1</label>
            <div class="input-group">
                <input type="text" id="trailer1" name="trailer1" class="form-control" placeholder="trailer 1" readonly>
                <span class="input-group-text d-none" id="trailer1Loader">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="trailer2" class="form-label">Trailer 2</label>
            <div class="input-group">
                <input type="text" id="trailer2" name="trailer2" class="form-control" placeholder="trailer 2" readonly>
                <span class="input-group-text d-none" id="trailer2Loader">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="first_weight" class="form-label">First Weight</label>
            <div class="input-group">
                <input id="first_weight" name="first_weight" class="form-control" placeholder="First Weight" readonly>
                <span class="input-group-text d-none" id="firstWeightLoader">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="new_truck" class="form-label">New Truck</label>
            <select id="new_truck" name="new_truck" class="form-select">
                <option selected disabled>Choose new truck...</option>
                @foreach ($horses as $horse)
                    <option value="{{ $horse->TruckId }}" data-tare-weight="{{ $horse->TareWeight }}">
                        {{ $horse->TruckId }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="new_first_weight" class="form-label">New First Weight</label>
            <input type="number" id="new_first_weight" name="new_first_weight" class="form-control"
                placeholder="New First Weight">
        </div>

        <button id="btnSubmit" class="btn btn-primary">Submit</button>

    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var horses = ({!! json_encode($horses) !!});

            let searchRequest = null;
            let detailRequest = null;

            $('#ticket_number').on('input', function() {
                let query = $.trim($(this).val());

                if (query.length < 2) {
                    $('#ticketSuggestions').empty();
                    return;
                }

                // Abort any previous search request
                if (searchRequest !== null) {
                    searchRequest.abort();
                }

                searchRequest = $.ajax({
                    url: '{!! url('/searchTicket') !!}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        const $list = $('#ticketSuggestions').empty();

                        // Add spinner as a list item
                        $list.append(`
                            <div class="list-group-item list-group-item-action" id="loadingSpinner">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Searching...
                            </div>
                        `);
                    },
                    success: function(tickets) {
                        const $list = $('#ticketSuggestions').empty(); // Clear spinner

                        if (tickets.length === 0) {
                            $list.append(
                                '<div class="list-group-item text-muted">No results found</div>'
                            );
                            return;
                        }

                        $.each(tickets, function(index, ticket) {
                            $('<a>', {
                                    href: '#',
                                    text: ticket.TICKET_NUMBER,
                                    class: 'list-group-item list-group-item-action'
                                })
                                .on('click', function(e) {
                                    e.preventDefault();

                                    const selectedTicket = ticket.TICKET_NUMBER;
                                    $('#ticket_number').val(selectedTicket);
                                    $list.empty();

                                    // Abort any previous detail fetch
                                    if (detailRequest !== null) {
                                        detailRequest.abort();
                                    }

                                    detailRequest = $.ajax({
                                        url: '{!! url('/getProWeighTicketDetails') !!}/' +
                                            encodeURIComponent(
                                                selectedTicket),
                                        method: 'GET',
                                        dataType: 'json',
                                        beforeSend: function() {
                                            // Optional: show loading in details section
                                            $('#truck').val(
                                                'Loading...');
                                        },
                                        success: function(data) {
                                        console.debug(data);
                                        console.debug(data.REG_NUMBER);
                                            $('#truck').val(data
                                                .REG_NUMBER).data(
                                                'tare-weight',
                                                parseFloat(data
                                                    .TRUCK_TARE_WEIGHT ||
                                                    0));
                                            $('#trailer1').val(data
                                                .TRAILER1_REG_NUMBER
                                            );
                                            $('#trailer2').val(data
                                                .TRAILER2_REG_NUMBER
                                            );
                                            $('#first_weight').val(data
                                                .FIRST_WEIGHT);
                                        },
                                        error: function(xhr, status,
                                            error) {
                                            if (status !== 'abort') {
                                                console.error(
                                                    'Error fetching ticket details:',
                                                    status, error);
                                            }
                                        }
                                    });
                                })
                                .appendTo($list);
                        });
                    },
                    error: function(xhr, status, error) {
                        if (status !== 'abort') {
                            console.error('Error fetching tickets:', status, error);
                        }
                    }
                });
            });

            // Enter key triggers fetch
            $('#ticket_number').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    // Abort any previous search request
                    if (searchRequest !== null) {
                        searchRequest.abort();
                    }

                    e.preventDefault();
                    const ticket = $(this).val().trim();
                    $('#ticketSuggestions').empty();
                    console.log('enter fetch for:', ticket);
                    fetchTicketDetails(ticket);
                }
            });

            // Focus out triggers fetch
            $('#ticket_number').on('blur', function() {
                // Abort any previous search request
                if (searchRequest !== null) {
                    searchRequest.abort();
                }

                // Delay to allow click on suggestion
                setTimeout(() => {
                    if (!$('#ticketSuggestions').is(':hover')) {
                        $('#ticketSuggestions').empty();

                        // Get the CURRENT value from input
                        const currentTicket = $('#ticket_number').val().trim();
                        if (currentTicket) {
                            console.log('blur fetch for:', currentTicket);
                            fetchTicketDetails(currentTicket);
                        }
                    }
                }, 200);
            });

            function fetchTicketDetails(ticketNumber) {
                if (!ticketNumber) return;

                if (detailRequest !== null) {
                    detailRequest.abort();
                }

                detailRequest = $.ajax({
                    url: '{!! url('/getProWeighTicketDetails') !!}/' + encodeURIComponent(ticketNumber),
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        // Show all spinners
                        $('#truckLoader, #trailer1Loader, #trailer2Loader, #firstWeightLoader')
                            .removeClass('d-none');

                        // Clear previous values
                        $('#truck, #trailer1, #trailer2, #first_weight').val('');
                    },
                    success: function(data) {
                        // Hide all spinners
                        $('#truckLoader, #trailer1Loader, #trailer2Loader, #firstWeightLoader')
                            .addClass('d-none');

                        // Populate values
                        $('#truck').val(data.REG_NUMBER).data('tare-weight', parseFloat(data
                            .TRUCK_TARE_WEIGHT || 0));
                        $('#trailer1').val(data.TRAILER1_REG_NUMBER);
                        $('#trailer2').val(data.TRAILER2_REG_NUMBER);
                        $('#first_weight').val(data.FIRST_WEIGHT);
                    },
                    error: function(xhr, status, error) {
                        if (status !== 'abort') {
                            console.error('Error fetching ticket details:', status, error);
                            // Hide spinners and show error text
                            $('#truckLoader, #trailer1Loader, #trailer2Loader, #firstWeightLoader')
                                .addClass('d-none');
                        }
                    }
                });
            }

            $('#new_truck').on('change', function() {
                const newTare = parseFloat($(this).find(':selected').data('tare-weight'));
                const oldTare = parseFloat($('#truck').data('tare-weight'));
                const firstWeight = parseFloat($('#first_weight').val());

                if (!isNaN(newTare) && !isNaN(oldTare) && !isNaN(firstWeight)) {
                    const adjustedWeight = firstWeight - oldTare + newTare;
                    $('#new_first_weight').val(adjustedWeight.toFixed(2));
                } else {
                    console.warn('Missing or invalid weights');
                    $('#new_first_weight').val('');
                }

            });

            $('#btnSubmit').on('click', function() {
                // console.log($('#ticket_number').val());
                // console.log($('#truck').val());
                // console.log(parseFloat($('#first_weight').val()));
                // console.log(parseFloat($('#truck').data('tare-weight')));
                // console.log($('#new_truck').val());
                // console.log(parseFloat($('#new_first_weight').val()));
                // console.log(parseFloat($('#new_truck').data('tare-weight')));

                $.ajax({
                    url: '{!! url('/updateProWeighData') !!}',
                    type: "POST",
                    data: {
                        strTicket: $('#ticket_number').val(),
                        strOldRegNumber: $('#truck').val(),
                        decOldFirstWeigh: parseFloat($('#first_weight').val()),
                        decOldTruckTareWeight: parseFloat($('#truck').data('tare-weight')),
                        strNewRegNumber: $('#new_truck').val(),
                        decNewFirstWeigh: parseFloat($('#new_first_weight').val()),
                        decNewTruckTareWeight: parseFloat($('#new_truck').find(':selected').data(
                            'tare-weight')),
                    },
                    success: function(data) {
                        DevExpress.ui.notify(data.Message, data.Status === "1" ? "success" :
                            "error", 5000);
                        if (data.Status === "1") location.reload();
                    }
                });
            });

        });
    </script>
@endsection
