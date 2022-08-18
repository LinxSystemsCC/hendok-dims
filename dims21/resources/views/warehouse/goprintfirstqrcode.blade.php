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
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">


    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
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
            <a href='{!!url("/mapmachinestodept")!!}' >Map Machines To Dept</a>
            <a href='{!!url("/mapitemsmachinesdept")!!}'>Map Machines,Dept & Prod</a>
            <a href='{!!url("/createjobs")!!}'  class="active">Create Jobs</a>
            <a href='{!!url("/printpalletsselectdept")!!}'>Print Pallet Label</a>
            <a href="#">In Progress Jobs</a>
            <a href="#">Jobs Data</a>
        </div>
    </div>
    <div class="col-lg-10" >
        @foreach($departments as $val)
            <h3>SELECTED DEPARTMENT: {{$val->strDeptName}}</h3>
            <input type="hidden" id="deptid" value="{{$val->intAutoID}}">
        @endforeach
        <br><br>
        @foreach($machines as $val)
            <h3>SELECTED MACHINE: {{$val->strMachineName}}</h3>
            <input type="hidden" id="machineid" value="{{$val->intAutoMachineID }}">
        @endforeach
        <br><br>
        @foreach($pallets as $val)
            <h3>PALLET TYPE: {{$val->strPalletTypeDescription}}</h3>
            <input type="hidden" id="pallettypeid" value="{{$val->intPalletId}}">
            <input type="hidden" id="estimatedpallets" value="{{$val->intPalletConf}}">
                <h4>Estimated Number Of Pallets : {{ floatval($qty)/$val->intPalletConf}} </h4>
        @endforeach
            <br><br>
        <h1>PRODUCT</h1>
        <fieldset class="well">
            <form>

                <div class="form-group">
                    @foreach($products as $val)
                        <input  type="text" class="form-control input-sm col-xs-1" id="productcode" style="height:40px;font-size: 20px;font-family: sans-serif;font-weight: 900;" value="{{$val->PastelCode}}"><br>
                        <input  type="text" class="form-control input-sm col-xs-1" id="producdescription" style="height:40px;font-size: 15px;font-family: sans-serif;font-weight: 900;" value="{{$val->PastelDescription}}"><br>
                    @endforeach
                    <br>

                </div>
                <div class="form-group">

                    <label class="control-label" for="qtyrequired"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Quantity Required</label>
                    <br>
                    <input type="number" class="form-control input-sm col-md-2-1" id="qtyrequired" value="{{$qty}}" ><br>


                </div>
                <div class="form-group">

                    <label class="control-label" for="operatorcode"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Operator</label>
                    <br>
                    <input type="number" class="form-control input-sm col-md-2-1" id="operatorcode"   ><br>


                </div>
            </form>
        </fieldset>
        <br><br><br>
        <button class="btn-primary btn-lg" id="goprintnow">GENERATE QR-CODE</button>

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

        $('#goprintnow').click(function(){


            window.location.replace('{!!url("/startprintingjob")!!}/' +$('#deptid').val()+"/"+$('#machineid').val()+"/"+$('#productcode').val()+"/"+$('#pallettypeid').val()+"/"+$('#qtyrequired').val()+"/"+$('#estimatedpallets').val()+"/"+$('#operatorcode').val());
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
