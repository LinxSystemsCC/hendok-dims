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

<style>
    .tablearea{
        /*height: 70vh;*/
    }
    .testarea{
        display: inline-flex;
        width: 100%;
        /*height: 30vh;*/
    }
    form{
        padding: 10px;
    }
    .formcontent{
        display: flex;
        flex-wrap: wrap;
        width: 300px;
    }

    .formcontent label{
        /*width: 250px;
        white-space: nowrap;*/
        flex-basis: 50%;
        
    }

    .formcontent input{
        flex-basis: 50%;
    }

    .formcontent select{
        flex-basis: 50%;
    }

    #left{
        float:left; 
        width:25%;
    }

    #middle{
        float:left; 
        width:50%;
    }

    #right{
        float:right;
        width:25%;
    }

</style>

<div class="col-lg-12 d-inline bd-highlight"  style="background: white; height:100vh; padding: 10px !important;">
    <div>
        <div class="tablearea" >
            <h3 style="flex-grow: 1;">QC Phase 1</h3>
            <div id="gridContainer" style="max-width: 100% !important;">
            </div>
        </div>

        <fieldset class="well" style="position: absolute; bottom: 0; width:99%">
            <div class="testarea">
                <form id="left">
                    <div class="form-group">
                        <div class="formcontent">
                            <label class="control-label" for="zinc" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Zinc
                            </label>

                            <input  type="text" class="form-control input-sm col-xs-1" id="zinc" style="height:22px;font-size: 10px;font-family: sans-serif;">

                        </div>

                        <br>

                        <div class="formcontent">
                            <label class="control-label" for="zinc" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                MPA
                            </label>

                            <input  type="text" class="form-control input-sm col-xs-1" id="MPA" style="height:22px;font-size: 10px;font-family: sans-serif;">

                        </div>

                        <br>

                        <div class="formcontent">
                            <label class="control-label" for="zinc"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Cast No
                            </label>

                            <input  type="text" class="form-control input-sm col-xs-1" id="CastNo" style="height:22px;font-size: 10px;font-family: sans-serif;">
                        </div>

                    </div>

                    <br>

                    <button type="button" id="passtest" class="btn btn-success" >Pass</button>
                    <button type="button" id="failtest" class="btn btn-danger" >Fail</button>
                </form>

                <form id="middle">
                    <div class="form-group">
                        <div class="formcontent">
                            <label class="control-label" for="wiresize" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Actual Wire Size
                            </label>

                            <input  type="text" class="form-control input-sm col-xs-1" id="wiresize" style="height:22px;font-size: 10px;font-family: sans-serif;">
                        </div>

                        <br>

                        <div class="formcontent">
                            <label class="control-label" for="test" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Test No
                            </label>
                            
                            <input  type="text" class="form-control input-sm col-xs-1" id="test" style="height:22px;font-size: 10px;font-family: sans-serif;">
                        </div>

                        <br>

                        <div class="formcontent">
                            <label class="control-label" for="comment" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Comment
                            </label>
                            
                            <select  type="text" class="form-select input-sm" id="comment" style="height:22px;font-size: 10px;font-family: sans-serif;">
                            </select>

                        </div>

                    </div>

                    <br>

                    
                </form>

                <form id="right">
                    <div class="form-group">
                        <div class="formcontent">
                            <label class="control-label" for="initmass" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Initial Mass
                            </label>

                            <input  type="text" class="form-control input-sm col-xs-1" id="initmass" style="height:22px;font-size: 10px;font-family: sans-serif;">

                        </div>

                        <br>

                        <div class="formcontent">
                            <label class="control-label" for="stripmass" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Strip Mass
                            </label>

                            <input  type="text" class="form-control input-sm col-xs-1" id="stripmass" style="height:22px;font-size: 10px;font-family: sans-serif;">

                        </div>

                        <br>

                        <div class="formcontent">
                            <label class="control-label" for="stripsize"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">
                                Strip Size
                            </label>

                            <input  type="text" class="form-control input-sm col-xs-1" id="stripsize" style="height:22px;font-size: 10px;font-family: sans-serif;">
                        </div>

                    </div>

                    <br>

                    <button type="button" id="passtest" class="btn btn-primary" >Refresh</button>
                    <button type="button" id="failtest" class="btn btn-primary" >Calculate Zinc</button>
                </form>
            </div>
        </fieldset>
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

        $.ajax({

            url: '{!!url("/getqc1")!!}',
            type: "GET",
            data: {
        
            },
            success: function (data) {

                $("#gridContainer").dxDataGrid({

                    dataSource:data, //as json

                    showBorders: true,
                    filterRow: { visible: true },
                    allowColumnResizing: true,
                    paging:{
                        pageSize: 15,
                    },
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('qc1');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'qc1.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "JobNo",
                            caption: "Job No",
                            width:100,
                        },{
                            dataField: "Reference",
                            caption: "Reference",
                            width:150,
                        },{
                            dataField: "ProductName",
                            caption: "Product",
                            width:150,
                        },{
                            dataField: "DepartmentName",
                            caption: "Department",
                            width: 450,
                        },{
                            dataField: "MachineName",
                            caption: "Machine",
                            width: 350,
                        },{
                            dataField: "WireSize",
                            caption: "Wire Size",
                            width:200,
                        },{
                            dataField: "MaxTDT",
                            caption: "Date",
                            width:250,
                        },{
                            dataField: "Completed",
                            caption: "Complete",
                            width:50,
                        },{
                            dataField: "MassRequired",
                            caption: "Required",
                            width:100,
                        },
                    ],
                    /*onRowDblClick:function(e){

                        // console.debug(e.row,cells[e.columnIndex]);
                        console.log(e.data.intAutoID);
                        var palletid =  e.data.intAutoID;
                        var strPalletTypeDescription =  e.data.strAreaName;

                                //data[0].sendto
                                var dialog = $('<p><label>Area Name</label><br><input id="theAreaname" value="'+strPalletTypeDescription+'"><br></p>').dialog({
                                    height: 300, width: 700,modal: true,containment: false,
                                    buttons: {
                                        "Update": function () {

                                            $.ajax({

                                                url: '{!!url("/updateAreaName")!!}',
                                                type: "POST",
                                                data: {
                                                    theAreaname: $('#theAreaname').val(),
                                                    palletid:palletid
                                                },
                                                success: function (data) {
                                                    location.reload();
                                                },

                                            });

                                        }
                                    }
                                });



                    },*/

                    onRowClick:function(e){

                    },
                });

            }

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
