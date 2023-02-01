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

        .btn {
            margin-bottom: 20px !important;
        }
    </style>


</head>

{{-- <div class="col-lg-12"  style="background: rgb(141, 141, 141);">

    <div style="padding-bottom: 20px; width: 100%;text-align:center; position:relative; margin: auto;">
        <span style="font-size: 65px; font-weight:700;">DEPARTMENT</span>
        
        <a class="btn btn-dark" href= '{!!url("/printpalletsselectdept")!!}' style=" font-size: 41px; position:absolute; left:10px; right: 0px;
        top: 15px;" ><i class="bi bi-arrow-return-left"></i></a>

    </div>

    @foreach($departments as $val)
    <h3>SELECTED DEPARTMENT: {{$val->strDeptName}}</h3>

        <?php
            $intId = $val->intAutoID;
        ?>
    @endforeach

    <h1>CHOOSE MACHINE</h1>

    @foreach($machines as $val)
    <button class="btn btn-dark" onclick="location.href='{!!url("/printpalletchoosproducttomake")!!}/{{$intId}}/{{$val->intMachineID}}'" type="button" style="width: 100% !important;font-size: 40px;">
        {{$val->strMachineName}}</button><br><br>
    @endforeach


</div> --}}

<div class="col-lg-12"  style="padding:20px; height:100vh;">
    <div style="padding-bottom: 20px; width: 100%;text-align:center; position:relative; margin: auto;">
        @foreach($departments as $val)
        {{-- <h3>SELECTED DEPARTMENT: {{$val->strDeptName}}</h3> --}}

        <?php
            $intId = $val->intAutoID;
        ?>
    @endforeach
        <span style="font-size: 50px; font-weight:700; text-transform:uppercase;">{{$val->strDeptName}} MACHINES</span>

        <a class="btn btn-dark" href= '{!!url("/printpalletsselectdept")!!}' style=" font-size: 30px; position:absolute; left: 0px; top: 15px;" >
        <i class="bi bi-arrow-return-left"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    </div>

    
    
    @foreach($machines as $val)
    @if ($val->intDeptID == $deparment)
        <button class="btn btn-danger" onclick="location.href='{!!url("/printpalletchoosproducttomake")!!}/{{$intId}}/{{$val->intMachineID}}'" type="button" style="width: 100% !important;font-size: 40px;">{{$val->strMachineName}}
        </button>
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

    $(document).ready(function() {


        $('#savemachine').click(function(){

            window.location.replace('{!!url("/choosproducttomake")!!}/' +$('#deptid').val()+"/"+$('#machines').val());

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
