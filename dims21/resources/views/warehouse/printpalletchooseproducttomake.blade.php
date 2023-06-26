<?php

    $v  =  new \App\Http\Controllers\SalesForm();
    if (Auth::guest()){
        $button ="0";
        return redirect('home');
    }else{
        $GroupId= Auth::user()->GroupId;
        $button = "1";

        if($v->getThings($GroupId,'Has Auto Redirect')){
            $button = "0";
        }
    }

?>
<!DOCTYPE html>
<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
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
<div class="col-lg-12"  style="padding:20px; min-height: 100vh; min-width: 100%;">
    
    <div style="display: flex;">
        @if($button !="0")
        <a class="btn btn-dark" href='{!!url("/printpalletchoosemachine")!!}/{{$departmentselected}}' style=" font-size: 30px; left: 0px; top: 15px; height:auto;" >
            <i class="bi bi-arrow-return-left"></i>
        </a>
        @endif
        
        <div style="padding-left: 20px;">
            @foreach($departments as $val)
                <h3>SELECTED DEPARTMENT: {{$val->strDeptName}}</h3>
                <input type="hidden" id="deptid" value="{{$val->intAutoID}}">
            @endforeach

            @foreach($machines as $val)
                <h3>SELECTED MACHINE: {{$val->strMachineName}}</h3>
                <input type="hidden" id="machineid" value="{{$val->intMachineID}}">
            @endforeach
        </div>
    </div>
    <br>

    <h2 id='batchRef'>REFERENCE: NONE</h2>
    @foreach($products as $val)
        @if($val->intJobId == 0)
            @if ($loop->first) 
                <div class="d-inline-flex w-100">
                    <button class="btn btn-danger" type="button" style="width:10% !important;font-size: 20px; margin-right:10px;">
                        {{$val->intSequence}}
                    </button>
                    
                    <button class="btn btn-danger" type="button" style="width:89% !important;font-size: 20px;" onclick="location.href='{!!url("/startgenratingqrcodeforpallet")!!}/{{$val->intRoofSOID}}/Roofing'">
                        {{$val->PastelDescription}} {{$val->packToCut}} | {{$val->productionstat}}
                    </button>
                </div>
            @else
                <div class="d-inline-flex w-100">
                    <button class="btn btn-danger" type="button" style="width:10% !important;font-size: 20px; margin-right:10px;" disabled>
                        {{$val->intSequence}}
                    </button>
                    
                    <button class="btn btn-danger" type="button" style="width:89% !important;font-size: 20px;" onclick="location.href='{!!url("/startgenratingqrcodeforpallet")!!}/{{$val->intRoofSOID}}/Roofing'" disabled>
                        {{$val->PastelDescription}} {{$val->packToCut}} | {{$val->productionstat}}
                    </button>
                </div>
            @endif
            <br>
            <br>
        @else
            @if($val->strJobStatus !="NOT STARTED")
                <button class="btn btn-danger" type="button" style="width:100% !important;font-size: 20px;" onclick="location.href='{!!url("/startgenratingqrcodeforpallet")!!}/{{$val->intJobId}}/None'" >
                    {{$val->PastelDescription}} {{$val->productionstat}} [ {{$val->strPalletTypeDescription}} ]</button>
                <br>
                <br>
            @endif
        @endif
    @endforeach

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

    var jArray = JSON.stringify({!! json_encode($products) !!});
    var Reference = {!! json_encode($products) !!};
    
    $(document).ready(function() {
        
        console.debug(Reference);
        if (Reference.length != 0){
            var BatchRef = Reference[0]['strReference'];
            $('#batchRef').text('BATCH REFERENCE: '+BatchRef);
        }
        
        var finalData =$.map(JSON.parse(jArray), function(item) {

            return {
                strItemCode:item.strItemCode,
                PastelDescription:item.PastelDescription

            }

        });
        var inputProductcode = $('#productcode').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,
            visibleProperties: ["strItemCode","PastelDescription"],
            searchIn: 'PastelDescription',
            data: finalData
        });
        inputProductcode.on('select:flexdatalist', function (event, data) {

            $('#productcode').val(data.strItemCode);
            $('#productdesc').val(data.PastelDescription);
            //

            $.ajax({

                url: '{!!url("/getpalletconfforitems")!!}',
                type: "POST",
                data: {
                    productcode: $('#productcode').val()

                },
                success: function (data) {
                    var toAppend = '';
                    $("#pallettype").empty();
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.intPalletId+'"><table><tr><td style="background: green">'+o.strPalletTypeDescription+' </td><td>| /PALLET '+o.intPalletConf+'</td></tr></table></option>';
                    });
                    $("#pallettype").append(toAppend);

                }

            });
        });

        $('#savemachine').click(function(){

            window.location.replace('{!!url("/goprintfirstqrcode")!!}/' +$('#deptid').val()+"/"+$('#machineid').val()+"/"+$('#productcode').val()+"/"+$('#pallettype').val()+"/"+$('#qtyrequired').val());

        });

        setTimeout(function(){
            window.location.reload(1);
        }, 15000);

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
