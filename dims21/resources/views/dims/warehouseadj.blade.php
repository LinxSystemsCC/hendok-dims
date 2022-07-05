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
        <link rel="stylesheet" href="{{ asset('css/ag_css.css') }}">
        <link rel="stylesheet" href="{{ asset('css/ag_cc_theme.css') }}">
    </head>


    <div class="container" style="width: 100%;">
        <div class="form-group row add">
            <div class="col-lg-12" >

                <form>
                    <fieldset class="well">
                        <legend class="well-legend">Adjustments Screen</legend>
                        <div class="form-group col-md-12">
                            <label class="control-label" for="itemCode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Item Code</label>
                            <input id="itemCode" class="form-control input-sm col-xs-1" >

                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label" for="warehousecode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Warehouse Code</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="warehousecode" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label" for="adjmentType"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Adjustment Type</label>
                            <select class="form-control input-sm col-xs-1" id="adjmentType">
                                <option value="">Choose</option>
                                <option value="0">Out</option>
                                <option value="1">IN</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label" for="companyname"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Ref One(Company)</label>
                            <select id="companyname">
                                <option value=""></option>
                                <option value="Hendok">Hendok</option>
                                <option value="Henroof">Henroof</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label" for="invnumber"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Ref Two(Inv Number)</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="invnumber" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label" for="Qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Quantity</label>
                            <input type="number" class="form-control input-sm col-xs-1" id="Qty" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>


                        <div class="form-group col-md-12">
                            <label class="control-label" for="trandate"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Trans Date</label>
                            <input type="date" class="form-control input-sm col-xs-1" id="trandate" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;">
                        </div>
                        <div class="form-group col-md-12">
                            <button class="btn-large btn-success" id="adjust">Adjust</button>
                        </div>

                    </fieldset>

                </form>
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

        $('#adjust').click(function(){
            $.ajax({
                url: '{!!url("/dimsmanualadjustment")!!}',
                type: "POST",
                data: {

                    itemCode: $('#itemCode').val(),
                    warehousecode: $('#warehousecode').val(),
                    adjmentType: $('#adjmentType').val(),
                    companyname: $('#companyname').val(),
                    invnumber: $('#invnumber').val(),
                    Qty: $('#Qty').val(),
                    trandate: $('#trandate').val()

                },
                success: function (data) {


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
