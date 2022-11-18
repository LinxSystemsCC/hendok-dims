<?php
if ((Auth::guest()))
{

}else{
    $v  =  new \App\Http\Controllers\SalesForm();
}
?>
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
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>
    <!-- DevExtreme library -->
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<div class="col-lg-12" style="background: white; height: 100vh;">
    <input type="hidden" id= "userID" value="{{ $id }}">
    <h3 style="flex-grow: 1;">User {{ $id }} Permissions</h3>
    <div class="col-lg-4" style="height: 80vh; overflow: overlay;" >
        <table class="table" id="userPermissionsTable">
            <tbody>
                <?php $count=1;?>
                @foreach ($permissions as $permission)
                <?php $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
                $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);?>
                <tr>
                    @foreach (explode('-', $permission->FullDesc) as $desc)
                        <td class="row{{ $randomString }}_{{ $count }}">
                            @if ($v->getThingsUserPermissions( $id , $desc) != "1")
                                <input id="row{{ $randomString }}_{{ $count }}" type="checkbox" value="{{$desc}}">{{ $desc }}

                            @else
                                <input id="row{{ $randomString }}_{{ $count }}" type="checkbox" value="{{$desc}}" checked>{{ $desc }}

                            @endif         
                            
                            
                        </td>
                            
                        <?php $count++;?> 
                    @endforeach
                </tr><?php $count=1;?>
                @endforeach
            </tbody>
        </table>
        
    </div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createjob" style="margin-right:10px;" id="saveUserPermissions">Save</button>
   
</div>



<style>

    
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
        $('#userPermissionsTable').on('click', 'tr td', function () {
            //console.log($(this).attr("class"));
            //console.log($(this).text());

            var rowClass = ($(this).attr("class"));
            var rowNum = rowClass.split("_").pop();
            var rowName = rowClass.substring(0, rowClass.indexOf('_'));
            var checked = true; 

            if ($('#'+rowName+"_"+rowNum).prop('checked')){
                checked = true;
            }else{
                $('#'+rowName+"_"+rowNum).prop('checked', false);
                checked = false;
            }
            //console.debug(checked);

            if (checked == true){
                for (let index = 1; index <= rowNum; index++) {
                    $('#'+rowName+"_"+index).prop('checked', true);
                }
            }

            
            

            

            //console.debug(rowNum);
            //console.debug(rowName);
        });

        $('#saveUserPermissions').click(function(){
            
            var checkedBoxes = [];
            /*$("input:checkbox[type=checkbox]:checked").each(function(){
                checkedBoxes.push($(this).val());
            });*/

            $.each($("input[type=checkbox]:checked"), function(){
                checkedBoxes.push($(this).val());
            });
            
            console.debug(checkedBoxes);

            $.ajax({

                url: '{!!url("/savepermissions")!!}',
                type: "POST",
                data: {
                    'UserID':$('#userID').val(),
                    'CheckBoxes':checkedBoxes
                },
                success: function (data) {
                    location.reload();
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
