<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <style>
        .vertical-menu {
            width: 200px;
        }

        .vertical-menu a {
            background-color: #eee;
            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .vertical-menu a:hover {
            background-color: #ccc;
        }

        .vertical-menu a.active {
            background-color: #04AA6D;
            color: white;
        }
    </style>


</head>
<div class="col-lg-12"  style="background: white;">
    <div class="col-lg-2"  style="background: white;border-right: 2px solid black;">

        <div class="vertical-menu">
            <a href='{!!url("/createPalletConfig")!!}'>Pallets Configurations</a>
            <a href='{!!url("/mapitemstopallet")!!}' >Map Pallet To Items</a>
            <a href='{!!url("/departmentpage")!!}'>Departments</a>
            <a href='{!!url("/machines")!!}'>Machines</a>
            <a href='{!!url("/mapmachinestodept")!!}' class="active">Map Machines To Dept</a>
            <a href='{!!url("/mapitemsmachinesdept")!!}'>Map Machines,Dept & Prod</a>
            <a href='{!!url("/createjobs")!!}'  class="active">Create Jobs</a>
            <a href="#">In Progress Jobs</a>
            <a href="#">Jobs Data</a>
        </div>
    </div>
    <div class="col-lg-10" >
        @foreach($machines as $val)
      <h3>PRODUCT: {{$machines[0]->strItemName}}</h3>
        <input type="hidden" id="itemCode" value="{{$machines[0]->strItemCode}}">
        @endforeach
    <br><br>
        <h1>CHOOSE MACHINE</h1>
        <fieldset class="well">
            <form>

                <div class="form-group">
                    <label class="control-label" for="machines"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Machine </label>
                    <select  class="form-control input-sm col-xs-1" id="machines" required>
                        <option></option>
                        @foreach($machines as $val)
                            <option value="{{$val->intMachineID}}">{{$val->strMachineName}}</option>
                        @endforeach

                    </select>
                    <br><br><br>
                </div>

                <div class="form-group">
                    <label class="control-label" for="intPalletId"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Pallet Configuration </label>
                    <select  class="form-control input-sm col-xs-1" id="intPalletId" required>
                        <option></option>
                        @foreach($pallets as $val)
                            <option value="{{$val->intPalletId}}"><table><tr><td style="background: green">{{$val->strPalletTypeDescription}} </td><td>| /PALLET {{$val->intPalletConf}} </td></tr></table></option>
                        @endforeach

                    </select>               <br><br><br>
                </div>

                <div class="form-group">
                    <label class="control-label" for="qtyproduce"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Quantity To Produce</label>
                    <input type="number" class="form-control input-sm col-lg-2" id="qtyproduce" required />


                </div>

                <h5 id="warningplanner" style="color: red;font-weight: bolder"></h5><br>

            </form>
        </fieldset>
            <br><br><br>
            <button class="btn-danger btn-lg" id="savemachine" style="width: 100%">NEXT</button>

    </div>
    <div title="PLANNING WARNING" class="form-group" id="youwantplan">
        <p>YOUR PLAN DOES NOT CONTAIN FULL PALLETS</p>

        <br>
        <button class="btn-danger btn-lg" id="sureaboutplan">I AM 100% SURE</button>
    </div>
</div>


<style>

    .dx-datagrid-table{
        font-size:15px;
    }
</style>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {
        $('#youwantplan').hide();


        $('#savemachine').click(function(){

            $('#warningplanner').empty();

            $.ajax({

                url: '{!!url("/validatepalletsplan")!!}',
                type: "POST",
                data: {
                    qtyproduce: $('#qtyproduce').val(),
                    intPalletId: $("#intPalletId").val()

                },
                success: function (data) {

                    console.debug("_________________________"+data[0].intPalletConf);
                    console.debug("PLAN_________________________"+ parseInt($('#qtyproduce').val())/data[0].intPalletConf);
                    $('#warningplanner').empty();

                    if($('#qtyproduce').val() % data[0].intPalletConf >0){
                        $('#youwantplan').show();
                        showDialog('#youwantplan','45%',400);
                        $('#warningplanner').append("ARE YOU SURE ABOUT THE QUANTITY YOU WANT TO PLAN? YOUR PLAN IS EQUAL TO "+ parseInt($('#qtyproduce').val())/data[0].intPalletConf)
                        $('#sureaboutplan').click(function(){
                            //
                            window.location.replace('{!!url("/choosproducttomake")!!}/' +$('#qtyproduce').val()+"/"+$('#itemCode').val()+"/"+$('#intPalletId').val()+"/"+$('#machines').val());
                        });

                    }else{
                        window.location.replace('{!!url("/choosproducttomake")!!}/' +$('#qtyproduce').val()+"/"+$('#itemCode').val()+"/"+$('#intPalletId').val()+"/"+$('#machines').val());

                    }

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
