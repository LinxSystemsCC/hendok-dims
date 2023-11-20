@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Upliftment Enquiry')

{{-- Set to show navbar --}}
@php
    $includeMenu = false;
@endphp

@section('page')

<div class="col-12">
    <div class="row mb-2">
        <div class="form-group col-md-6">
            <label class="control-label" for="fromuser">From</label>
            <input class="form-control" id="fromuser" value="{{Auth::user()->UserName}}" required readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="control-label" for="fromemail">From Email</label>
            <input class="form-control" id="fromemail" value="{{Auth::user()->Email}}" required readonly>
        </div>
    </div>

    <div class="row mb-2">
        <div class="form-group col-md-6">
            <label class="control-label" for="touser">To</label>
            @foreach($headerdetails as $val)
            <input class="form-control" id="touser" value="{{$val->Username}}" required readonly>
            @endforeach
        </div>

        <div class="form-group col-md-6">
            <label class="control-label" for="toemail">To Email</label>
            @foreach($headerdetails as $val)
            <input class="form-control" id="toemail" value="{{$val->Email}}" required readonly>
            <input class="form-control" id="upliftmentnumber" value="{{$val->UpliftmentNumber}}" required readonly hidden>
            @endforeach
        </div>
    </div>

    <div class="row mb-2">
        <div class="form-group col-md-12">
            <label class="control-label" for="message">Message</label>
            <textarea class="form-control mb-2" id="message" required></textarea>
            <button type="button" id="messageupliftment" class="btn btn-success w-100">Send Message</button>
        </div>
    </div>

    <div id="gridHistory" style="min-height: 100%;"></div>
</div>

@endsection

@section('scripts')

<script>
    var jArray = JSON.stringify({!! json_encode($upliftmakerdata) !!});
    var finalDataMessages = $.map(JSON.parse(jArray), function (item) {
        return {
            dteTimestamp: item.dteTimestamp,
            strMessage: item.strMessage,
            Username: item.Username,
        }
    });

    $(document).ready(function() {
        $('#messageupliftment').click(function(){
            $.ajax({
                url: '{!!url("/upliftmentMessagePost")!!}',
                type: 'POST',
                data: {
                    upliftmentNumber: $('#upliftmentnumber').val(),
                    upliftmentMessage:$('#message').val()
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
    
        $("#gridHistory").dxDataGrid({
            dataSource:finalDataMessages, //as json
            hoverStateEnabled: true,
            showBorders: true,
            filterRow: { visible: true },
            filterPanel: { visible: true },
            headerFilter: { visible: true },
            allowColumnResizing: true,
            columnAutoWidth: true,
            scrolling: {
                rowRenderingMode: 'infinite',
            },
            paging:{
                pageSize: 10,
            },
            pager: {
                visible: true,
                allowedPageSizes: [5, 10, 20, 50, 'all'],
                showPageSizeSelector: true,
                showInfo: true,
                showNavigationButtons: true,
            },
            columns: [
                {
                    dataField: "dteTimestamp",
                    caption: "Timestamp",
                },{
                    dataField: "strMessage",
                    caption: "Message",
                },{
                    dataField: "Username",
                    caption: "Username",
                },
            ],
            onToolbarPreparing: function (e) {
                e.toolbarOptions.items.unshift(
                    {
                        location: 'before',
                        template: function () {
                            return $('<h3>').text('Enquiry History');
                        }
                    }
                );
            }
        });
    });

</script>

@endsection