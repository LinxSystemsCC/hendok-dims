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
    
    <link rel="stylesheet" href="{{ asset('resources/css/jobmodulestyle.css')}}">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

        <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

    
</head>

<div class="col-12 d-flex px-0"  style="background: white;">
    <div class="col-custom-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col p-3" >
        <div class="col-lg-12 d-inline-flex" >
            <input type="hidden" id= "userID" value="{{ $id }}">
            
            @foreach($username as $user)
            <h3 class="text-uppercase" style="flex-grow: 1; padding-left: 15px;">{{ $user->UserName }}'s PERMISSIONS</h3>
            @endforeach
        </div>
        <input id="toggleall" type="checkbox" value="Toggle All" style="margin-left: 20px;"> <label for="toggleall">Toggle All</label>
        <div class="col-lg-12" style="height: 80vh; overflow: overlay;" >
            
            <table class="table table-borderless table-hover" id="userPermissionsTable" style="background-color: rgb(216, 216, 216);">
                <thead class="thead-dark">
                    <th class="header" scope="col">Main Tree</th>
                    <th class="header" scope="col">First Branch</th>
                    <th class="header" scope="col">Second Branch</th>
                    <th class="header" scope="col">Page Components</th>
                </thead>
                <tbody>
                    <?php $count=1;?>
                    @foreach ($permissions as $permission)
                    <?php $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
                    $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);?>
                    <tr>
                        @foreach (explode('-', $permission->FullDesc) as $desc)
                            <td class="row{{ $randomString }}_{{ $count }}">
                                @if ($v->getThingsUserPermissions( $id , $desc) != "1")
                                    <input id="row{{ $randomString }}_{{ $count }}" type="checkbox" value="{{$desc}}">
                                    <label for ="row{{ $randomString }}_{{ $count }}">
                                        {{ $desc }}
                                    </label>
                                @else
                                    <input id="row{{ $randomString }}_{{ $count }}" type="checkbox" value="{{$desc}}" checked>
                                    <label for ="row{{ $randomString }}_{{ $count }}">
                                        {{ $desc }}
                                    </label>
                                @endif         
                            </td>
                                
                            <?php $count++;?> 
                        @endforeach
                    </tr><?php $count=1;?>
                    @endforeach
                </tbody>
            </table>
        
    </div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createjob" style="margin-left:15px; margin-top:10px;" id="saveUserPermissions">Save</button>
</div>


<style>
    .dx-datagrid-table{
        font-size:15px;
    }

    .dx-datagrid .dx-link {
        color: #df2413;
    }

    .dx-pager .dx-page-sizes .dx-selection, .dx-pager .dx-pages .dx-selection {
        font-weight: 500;
        background-color: #df2413;
        color: #fff;
    }

    .dx-datagrid-filter-panel .dx-datagrid-filter-panel-text {
        color: #df2413;
        font-size: 14px;
        line-height: 18px;
    }

    .dx-datagrid {
        height: calc(100vh - 63px);
        max-height: calc(100vh - 63px);
    }
</style>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

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

        $("#toggleall").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
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

            if (checked == true){
                for (let index = 1; index <= rowNum.lenght; index++) {
                    $('#'+rowName+"_"+index).prop('checked', true);
                }
            }
        });

        $('#saveUserPermissions').click(function(){
                        
            var checkedBoxes = [];

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


        $('.sidebar ul li a').on(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });
        
        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
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
