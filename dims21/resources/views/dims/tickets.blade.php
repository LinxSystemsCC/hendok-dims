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
                <div class="col-lg-4">

                    <form style="color: black;font-weight: 900">
                        <fieldset class="well">
                            <legend class="well-legend">Transport And Drivers</legend>
                            <input type="hidden" id="ref" value="{{$ref}}">
                            <div class="form-group ">
                                <label class="control-label" for=  "TruckName" style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Trailor/truck Reg</h4></label>
                                <select id="TruckName" class="form-control input-sm col-s-2" required>
                                    @foreach($truckstodrive as $val)
                                        <option value="{{$val->TruckId}}">{{$val->RegNo}}</option>
                                    @endforeach
                                    @foreach($trucks as $val)
                                        <option value="{{$val->TruckId}}">{{$val->RegNo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="DriverOne"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Driver One</h4></label>
                                <select id="DriverOne" class="form-control input-sm col-s-2" required>
                                    @foreach($driverone as $val)
                                        <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
                                    @endforeach
                                    @foreach($drivers as $val)
                                        <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="DriverTwo"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Driver Two</h4></label>
                                <select id="DriverTwo" class="form-control input-sm col-s-2" required>
                                    @foreach($drivertwo as $val)
                                        <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
                                    @endforeach
                                @foreach($drivers as $val)
                                        <option value="{{$val->DriverId}}">{{$val->DriverName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label class="control-label" for="Ticket"  style="margin-bottom: 2px;font-weight: 700;font-size: 11px;"><h4>Ticket</h4></label>
                                <select id="Ticket" class="form-control input-sm col-s-2" required>
                                    @foreach($ticketselected as $val)
                                        <option value="{{$val->strTicket}}">{{$val->strTicket}}</option>
                                    @endforeach
                                    @foreach($tickets as $val)
                                        <option value="{{$val->TICKET_NUMBER}}">{{$val->TICKET_NUMBER}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class=" btn btn-success fa fa-plus-circle" type="submit" id="add" >ADD</button>

                        </fieldset>
                    </form>

                </div>

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

        $("#add").click(function()
        {
            $.ajax({
                url: '{!!url("/addtransport")!!}',
                type: "POST",
                data: {
                    TruckName: $('#TruckName').val(),
                    DriverOne: $('#DriverOne').val(),
                    DriverTwo: $('#DriverTwo').val(),
                    Ticket: $('#Ticket').val(),
                    ref: $('#ref').val()
                },
                success: function (data)
                {
                    location.reload(true);
                }
            });


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
