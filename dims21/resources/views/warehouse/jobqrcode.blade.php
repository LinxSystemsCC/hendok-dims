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
                        <legend class="well-legend">Product Produced</legend>
                        <div class="form-group col-md-12">
                            <label class="control-label" for="machine"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Machine</label>
                            <input id="machine" class="form-control input-sm col-xs-1" >

                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label" for="itemCode"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Item Code</label>
                            <select class="form-control input-sm col-xs-1" id="itemCode">
                                <option value="Item 1">Item 1</option>
                                <option value="Item 2">Item 2</option>
                                <option value="Item 3">Item 3</option>
                                <option value="Item 4">Item 4</option>
                                <option value="Item 5">Item 5</option>
                                <option value="Item 6">Item 6</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label" for="Qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 11px;">Qty</label>
                            <input type="text" class="form-control input-sm col-xs-1" id="Qty" style="height:22px;font-size: 10px;font-family: sans-serif;font-weight: 900;" >
                        </div>
                        <br>
                        <div class="form-group col-md-12">
                            <button type="button" id="qrcodeid" class="btn-xs btn-info">Submit</button>
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

        $('#qrcodeid').click(function(){
            window.open('{!!url("/qrcodeimage")!!}/' + $('#machine').val()+'/'+ $('#itemCode').val()+'/'+ $('#Qty').val(), "qrcodeimage" + $('#itemCode').val(), "location=1,status=1,scrollbars=1, width=1200,height=850");

        });
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
