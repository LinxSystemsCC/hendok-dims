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
<div style="display: flex; justify-content: space-around; background-color: black;">
    <img  src="{{url('/images/HendokLogoBlack.jpg')}}" style="height: 70px; border: solid 3px black; margin:auto; padding-left: 20px;">
    <h3 style="flex-grow: 1;">Map Machine To Area</h3>
    <!--img  src="{{url('/images/logo-02.png')}}" style="height: 70px; border: solid 3px black;"-->
</div>
<div class="col-lg-12"  style="background: white;">
    <div class="col-lg-2"  style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col-lg-10" >
        <div class="col-lg-12" >
            
            <div class="col-lg-4"  style="background: white;">
                <h4>Set-Up</h4>
                <fieldset class="well">
                    <form>
                        Map Machine To Area
                        <div class="form-group">
                            <label class="control-label" for="area"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Area </label>
                            <select  class="form-control input-sm col-xs-1" id="area" required>
                                <option></option>
                                @foreach($area as $val)
                                    <option value="{{$val->intAutoID}}">{{$val->strAreaName}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="machine"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Machine </label>
                            <select  class="form-control input-sm col-xs-1" id="machine" required>
                                <option></option>
                                @foreach($machine as $val)
                                    <option value="{{$val->intAutoMachineID}}">{{$val->strMachineName}}</option>
                                @endforeach

                            </select>
                        </div>
                        <br>
                        <button type="button" id="savemachine" class="btn-lg btn-success" >Save</button>
                        <br>


                    </form>
                </fieldset>
                <hr>


            </div>
            <div class="col-lg-8"  style="background: white;">
                <h4>Data Grid</h4>
                <div class="col-lg-12" id="afterFilter">
                    <div id="gridContainer">
                    </div>


                </div>
            </div>
        </div>
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


        $('#savemachine').click(function(){

            $.ajax({

                url: '{!!url("/savesMachinetoarea")!!}',
                type: "POST",
                data: {
                    machineid: $('#machine').val(),
                    areaid: $('#area').val()

                },
                success: function (data) {
                    location.reload();
                }

            });

        });


        $.ajax({

            url: '{!!url("/getMachinemappedtoarea")!!}',
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
                        pageSize: 50,
                    },
                    export: {
                        enabled: true
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Machines');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Machines.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "intAutoMappedMachineArea",
                            caption: "ID",
                            width: 50,

                        }, {
                            dataField: "strMachineName",
                            caption: "Machine",
                            width: 250,

                        }, {
                            dataField: "strAreaName",
                            caption: "Area",
                            width: 250,

                        }
                        , {
                            dataField: "dteCreate",
                            caption: "Date Time",
                            width: 125,

                        },
                    ],
                    onRowDblClick:function(e){

                        // console.debug(e.row,cells[e.columnIndex]);
                        console.log(e.data.intAutoMappedMachineDept);
                        var palletid =  e.data.intAutoMappedMachineDept;
                        var dialog = $('<p>Un Mapped</p>').dialog({
                            height: 300, width: 700,modal: true,containment: false,
                            buttons: {
                                "Update": function () {

                                    // console.log($('#statusselect').val());
                                    $.ajax({

                                        url: '{!!url("/unmapmachinefromdept")!!}',
                                        type: "POST",
                                        data: {
                                            mappingId:palletid
                                        },
                                        success: function (data) {
                                            location.reload();
                                        },

                                    });

                                }
                            }
                        });



                    },
                    onRowClick:function(e){

                    },
                });

            }

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
