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
            <div id="ticketSuggestions" class="list-group position-absolute w-100"
                style="z-index: 1000; max-height: 300px; overflow-y: auto;"></div>
        </div>

        <div class="mb-3">
            <label for="truck" class="form-label">Current Truck</label>
            <input type="text" id="truck" name="truck" class="form-control" placeholder="truck reg" readonly>
        </div>

        <div class="mb-3">
            <label for="trailer1" class="form-label">Trailer 1</label>
            <input type="text" id="trailer1" name="trailer1" class="form-control" placeholder="trailer 1" readonly>
        </div>

        <div class="mb-3">
            <label for="trailer2" class="form-label">Trailer 2</label>
            <input type="text" id="trailer2" name="trailer2" class="form-control" placeholder="trailer 2" readonly>
        </div>

        <div class="mb-3">
            <label for="first_weight" class="form-label">First Weight</label>
            <input type="number" id="first_weight" name="first_weight" class="form-control" placeholder="First Weight" readonly>
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
                    success: function(tickets) {
                        const $list = $('#ticketSuggestions').empty();

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
                                        url: '{!! url('/getProWeighTicketDetails') !!}/' + encodeURIComponent(selectedTicket),
                                        method: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                            $('#truck').val(data.REG_NUMBER).data('tare-weight', parseFloat(data.TRUCK_TARE_WEIGHT || 0));
                                            $('#trailer1').val(data.TRAILER1_REG_NUMBER);
                                            $('#trailer2').val(data.TRAILER2_REG_NUMBER);
                                            $('#first_weight').val(data.FIRST_WEIGHT);
                                        },
                                        error: function(xhr, status,
                                            error) {
                                            if (status !== 'abort') {
                                                console.error('Error fetching ticket details:', status, error);
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
                    fetchTicketDetails(ticket);
                }
            });

            // Focus out triggers fetch
            $('#ticket_number').on('blur', function() {
                const ticket = $(this).val().trim();

                // Abort any previous search request
                if (searchRequest !== null) {
                    searchRequest.abort();
                }

                // Give a slight delay to allow click events on suggestions
                setTimeout(() => {
                    if (!$('#ticketSuggestions').is(':hover')) {
                        $('#ticketSuggestions').empty();
                        fetchTicketDetails(ticket);
                    }
                }, 200);
            });

            function fetchTicketDetails(ticketNumber) {
                if (!ticketNumber) return;

                // Abort any previous detail fetch
                if (detailRequest !== null) {
                    detailRequest.abort();
                }

                detailRequest = $.ajax({
                    url: '{!! url('/getProWeighTicketDetails') !!}/' + encodeURIComponent(ticketNumber),
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#truck').val(data.REG_NUMBER).data('tare-weight', parseFloat(data.TRUCK_TARE_WEIGHT || 0));
                        $('#trailer1').val(data.TRAILER1_REG_NUMBER);
                        $('#trailer2').val(data.TRAILER2_REG_NUMBER);
                        $('#first_weight').val(data.FIRST_WEIGHT);
                    },
                    error: function(xhr, status, error) {
                        if (status !== 'abort') {
                            console.error('Error fetching ticket details:', status, error);
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

                    // console.log('oldTare: '+ oldTare)
                    // console.log('newTare: '+ newTare)
                    // console.log('firstWeight: '+ firstWeight)
                    // console.log('newfirstWeight: '+ adjustedWeight)
                } else {
                    console.warn('Missing or invalid weights');
                    $('#new_first_weight').val('');
                }

            });

            $('#btnSubmit').on('click', function(){
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
                        decNewTruckTareWeight: parseFloat($('#new_truck').find(':selected').data('tare-weight')),
                    },
                    success: function(data) {
                        DevExpress.ui.notify(data.Message, data.Status === "1" ? "success" : "error", 5000);
                        if (data.Status === "1") location.reload();
                    }
                });
            });

        });
    </script>
@endsection
