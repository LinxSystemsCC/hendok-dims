@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Jumbo Coils')


{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

<h3>Galv Juimbo Coil Reprint Page</h3>
    {{-- Department --}}
    <div class="form-group mb-2">
        <label class="control-label fw-bold" for="ticket">Existing Ticket</label>
        <select  class="form-select" id="ticket" required>
            <option></option>
            {{-- @foreach($tickets as $ticket)
                <option value="{{$ticket->TicketNo}}">{{$ticket->TicketNo}}</option>
            @endforeach --}}
        </select>
    </div>

    {{-- Quantity --}}
    <div class="form-group mb-2">
        <label class="control-label fw-bold" for="quantity">Quantity to Print</label>
        <input  class="form-control" id="quantity" required>
    </div>

    {{-- Printer --}}
    <div class="form-group mb-2">
        <label class="control-label fw-bold" for="printer">Printer</label>
        <select  class="form-select w-100" id="printer"  required>
            <option></option>
            @foreach($printers as $printer)
                <option value="{{$printer->strPrinter}}">{{$printer->strPrinter}}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success" id="btnPrintJumboCoil" style="width: 100%; margin-right: 10px;">PRINT</button>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('#ticket').select2({
            theme: 'bootstrap-5',
            ajax: {
                url: '{!! url("/getWmaxTickets") !!}',
                type: "GET",
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term, // User's search query
                    };
                },
                processResults: function(data) {
                    // Format the data into the expected format with 'id' and 'text' properties.
                    const formattedData = data.map(ticket => ({
                        id: ticket.TicketNo,
                        text: ticket.TicketNo,
                    }));

                    return {
                        results: formattedData,
                    };
                },
            },
            minimumInputLength: 1, // Minimum characters to trigger a search
        });

        $('#btnPrintJumboCoil').click(function(){
            $.ajax({
                url: '{!!url("/galvPrintJumboCoil")!!}',
                type: "GET",
                data: {
                    ticket: $('#ticket').val(),
                    quantity: $('#quantity').val(),
                    printer: $('#printer').val()
                },
                success: function (data) {
                    if(data[0].Result =="SUCCESS")
                    {
                        alert('Succesful Printout.');
                        location.reload();
                    }else{
                        alert(data[0].Result);
                    }
                    
                },
                error: function (error) {
                    console.error("Error loading data: ", error);
                }
            });
        });
    });
</script>


@endsection