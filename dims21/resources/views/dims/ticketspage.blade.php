@extends('layouts.app')

@section('content')
    <head>
        <style>
            h2{color:red;}
            h3 {color:blue;}
            h4 {color:orange;}
            td{color:orange;}
            tbody{background-color:black;}


            input[type=text], select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 2px;
                box-sizing: border-box;
                cursor: text;
            }

            div.scrollable
            {
                width:100%;
                height: 100%;
                margin: 0;
                padding: 0;
                overflow-y: scroll
            }



        </style>
    </head>


    <div class="container" style="width: 100%;">
        <div class="form-group row add">
            <div class="col-lg-12" >
                <h3>Assign Tickets</h3>
                @foreach($awaitingtobeassgined as $val)
                    <a href='{!!url("/weightticketslist")!!}/{{$val->strUnickReference}}'  style="background: red;padding:10px;color: black;font-weight: 900" >{{$val->strPickingNickname}}</a><br><br>
                @endforeach
            </div>
            <hr style="border: 2px solid black">
            <div class="col-lg-12" >
                <h3>Already Assigned</h3>
                @foreach($assigned as $val)
                    <a href='{!!url("/startassigningtickets")!!}/{{$val->strUnickReference}}'  style="background: green;padding:10px;color: black;font-weight: 900" >{{$val->strPickingNickname}}</a><br><br>
                @endforeach
            </div>

        </div>

    </div>



@endsection
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $('#QuoteDetails').hide();
        $('#extraInfo').hide();
        $('#salesQEmail').hide();
        $('#orderListing').hide();
        $('#pricing').hide();
        $('#callList').hide();
        $('#copyOrdersBtn').hide();
        $('#tabletLoadingApp').hide();
        $('#pricingOnCustomer').hide();
        $('#salesOnOrder').hide();
        $('#posCashUp').hide();
        $('#dropdown').hide();
        $('#editTrucks').hide();
        $('#salesInvoiced').hide();
        $('#returns').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    });
    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }


</script>
