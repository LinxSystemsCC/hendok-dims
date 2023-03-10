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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

    <style>
        .header{
            position:sticky;
            top: 0 ;
        }
    </style>

</head>
<div class="col-lg-12" style="background: white;">
    <input type="hidden" id= "userID" value="{{ $id }}">
    <h3 style="flex-grow: 1; border-bottom: 1px solid black; padding-left: 15px;">User {{ $id }} Permissions</h3>
        <div id= "usergrid" class="col-lg-12" style="height: 80vh; overflow: overlay;" >
          
    </div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createjob" style="margin-left:15px; margin-top:10px;" id="saveUserPermissions">Save</button>
   
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

        var jArray = JSON.stringify({!! json_encode($permissions) !!});
    var finalUserGrid = $.map(JSON.parse(jArray), function (item) {
        var booleanfromitem = (item.Selected ==1);
        
        return {
            Type: item.Type,
            UserID: item.UserID,
            num1: item.num1,
            num2: item.num2,
            num3: item.num3,
            num4: item.num4,
            Selected: booleanfromitem
        }

    });
        $("#usergrid").dxDataGrid({
                    dataSource:finalUserGrid,
                    showBorders: true,
                    keyExpr:'Type',
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    hoverStateEnabled: true,
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    editing: {
                        mode: 'batch',
                        allowUpdating: true,
                        // allowAdding: true,
                        // allowDeleting: true,
                        useIcons: true,
                    },
                    paging:{
                        pageSize: 10,
                    }, 
                    columns: [
                        
                    {
                            dataField: "Type",
                            caption: "ID",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            dataField: "num1",
                            caption: "Section 1 Detail",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },{
                            dataField: "num2",
                            caption: "Section 2 Detail",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },{
                            dataField: "num3",
                            caption: "Section 3 Detail",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },{
                            dataField: "num4",
                            caption: "Section 4 Detail",
                            headerFilter: {
                                allowSearch: true,
                            }

                        },
                        {
                            dataField: "Selected",
                            caption: "Yes/No",
                            dataType: "boolean",
                            headerFilter: {
                                allowSearch: true,
                            }   
                        },
                        


                    ]
                });
        
        $('#saveUserPermissions').click(function(){
            
            var checkedLines = Array();
            var selectedRowsData =  $("#usergrid").dxDataGrid("getDataSource").store().load().done(function (data) {
                checkedLines= data;
                });
                var gridResults ="<xml>";
        
         

                    $.each(checkedLines ,function(key,value) {
                    gridResults= gridResults + "<result>";
                    gridResults= gridResults + "<Type>"+value.Type+"</Type>";
                    if(value.Selected ==true){
                    gridResults= gridResults + "<Selected>1</Selected>";
                    }else 
                    {
                    gridResults= gridResults + "<Selected>0</Selected>";
                    }
                    gridResults= gridResults+ "</result>";

                });
                    gridResults= gridResults+"</xml>";
            console.log(gridResults);
            $.ajax({
                    url: '{!!url("/xmlUserGridPermsPost")!!}',
                    type: "POST",
                    data: {
                        UserID:$('#userID').val(),
                        gridResult: gridResults
                    },
                    success: function (data) {
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
