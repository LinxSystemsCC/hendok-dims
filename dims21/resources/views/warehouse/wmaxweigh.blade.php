<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    

    <!-- Select2 JS -->

    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

</head>

<style>
    .tablearea{
        display: block;
    }
    .formcontent{
        display: flex;
        flex-wrap: wrap;
        max-width: 300px;
        padding-bottom: 10px;
        
    }

    .formcontent label{
        /*width: 250px;
        white-space: nowrap;*/
        flex-basis: 50%;
        padding-left: 10px;
    }

    .formcontent input{
        flex-basis: 50%;
    }

    .formcontent select{
        flex-basis: 50%;
        border-color: #ccc;
    }

    .form-group{
        margin-bottom: 0px !important;
    }
    .well{
        width: fit-content;
    }

</style>
    <div class="col-lg-12 bd-highlight"  style="background: white; height:100vh; padding: 10px !important;">
        <div class="col-lg-10">
            <h3 style="flex-grow: 1;">Weigh</h3>
            <div class="tablearea" >
            <div id="gridContainer" style="max-width: 100% !important; height: 100%;">
            </div>
        </div>
    </div>

    

    <div title="Job Creation" id="createjob" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weighTestTitle">Set Weight</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    
                    {{-- Row 1 --}}
                    <div class="d-flex">
                        <div class="form-group" style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="jobnum"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Job No
                                </label>
                                <label class="control-label" id="jobnum"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                     
                                </label>
                            </div>
                        </div>
                
                        <div class="form-group"  style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="seqnum"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Seq No
                                </label>
                                <label class="control-label" id="seqnum"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                            </div>
                        </div>
                    </div>
                        
                    {{-- Row 2 --}}
                    <div class="d-flex">
                        <div class="form-group" style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="custnum"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Customer No
                                </label>
                                <label class="control-label" id="custnum"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                     
                                </label>
                            </div>
                        </div>
                
                        <div class="form-group"  style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="dept"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Department
                                </label>
                                <label class="control-label" id="dept"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3 --}}
                    <div class="d-flex">
                        <div class="form-group" style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="ref"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Reference
                                </label>
                                <label class="control-label" id="ref"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                     
                                </label>
                            </div>
                        </div>
                
                        <div class="form-group"  style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="machine"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Machine
                                </label>
                                <label class="control-label" id="machine"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Row 4 --}}
                    <div class="d-flex">
                        <div class="form-group" style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="prod"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Product
                                </label>
                                <label class="control-label" id="prod"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                     
                                </label>
                            </div>
                        </div>
                
                        {{-- <div class="form-group"  style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="SEno"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    SE No
                                </label>
                                <label class="control-label" id="SEno"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                            </div>
                        </div> --}}
                    </div>

                    {{-- Row 5 --}}
                    <div class="d-flex">
                        <div class="form-group" style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="zinc"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Zinc
                                </label>
                                <label class="control-label" id="zinc"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                     
                                </label>
                            </div>
                        </div>
                
                        <div class="form-group"  style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="tensile"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Tensile Ticket
                                </label>
                                <label class="control-label" id="tensile"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Row 6 --}}
                    <div class="d-flex">
                        <div class="form-group" style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="mpa"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    MPA
                                </label>
                                <label class="control-label" id="mpa"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                     
                                </label>
                            </div>
                        </div>
                
                        <div class="form-group"  style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="wire"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Actual Wire Size
                                </label>
                                <label class="control-label" id="wire"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Row 7 --}}
                    <div class="d-flex">
                        <div class="form-group" style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="cast"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    Cast No
                                </label>
                                <label class="control-label" id="cast"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                     
                                </label>
                            </div>
                        </div>
                
                        <div class="form-group"  style="width: 50%;">
                            <div class="d-flex" style="padding: 10px;">
                                <label class="control-label" for="blank"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                                <label class="control-label" id="blank"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;">
                                    
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="tare"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Tare Mass</label>
                        <select  class="form-control input-sm col-xs-1" id="tare" required>
                            <option>
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="mass"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Mass</label>
                        <input type="number" class="form-control input-sm col-xs-1" id="mass" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="final"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Final Mass</label>
                        <input type="number" class="form-control input-sm col-xs-1" id="final" required disabled>
                    </div>

                </div>
                
                <br>
                <div class="modal-footer">
                    <button class="btn btn-success" id="accept" style="width:50%">ACCEPT</button>
                    <button class="btn btn-danger" id="hold" style="width:50%">HOLD</button>
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

        $("#tare").change(function() {
            //console.debug($('#tare').val());
            finalweight = ($("#mass").val()-$('#tare').val());
            $('#final').val(finalweight);
        });
        
        $("#mass").change(function() {
            finalweight = ($("#mass").val()-$('#tare').val());
            $('#final').val(finalweight);
        });

        //GetWeigh
        $.ajax({

            url: '{!!url("/getweigh")!!}',
            type: "GET",
            data: {
        
            },
            success: function (data) {

                $("#gridContainer").dxDataGrid({

                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    paging:{
                        pageSize: 15,
                    },
                    export: {
                        enabled: true
                    },
                    selection: {
                        mode: 'single',
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('weigh');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'weigh.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "DepartmentName",
                            caption: "Department",
                            //width:100,
                        },{
                            dataField: "MachineName",
                            caption: "Machine",
                            //width:150,
                        },{
                            dataField: "CustomerName",
                            caption: "Customer",
                            //width:150,
                        },{
                            dataField: "ProductName",
                            caption: "Product",
                            //width: 450,
                        },{
                            dataField: "Reference",
                            caption: "Reference",
                            //width: 350,
                        },{
                            dataField: "JobNo",
                            caption: "Job Number",
                            //width:200,
                        },{
                            dataField: "SeqNo",
                            caption: "Seq No",
                            //width:250,
                        },{
                            dataField: "TensileTicket",
                            caption: "Tensile Ticket",
                            //width:50,
                        },{
                            dataField: "Zinc",
                            caption: "Zinc",
                            //width:100,
                        },{
                            dataField: "WireSize",
                            caption: "Wire Size",
                            //width:100,
                        },{
                            dataField: "MPA",
                            caption: "MPA",
                            //width:100,
                        },
                    ],


                    onRowDblClick:function(e){
                        $('#createjob').modal('toggle');
                        var dataGrid = $("#gridContainer").dxDataGrid("instance");
                        var selectedRowsData = dataGrid.getSelectedRowsData();

                        $("#accept").prop('disabled', true);
                        $("#hold").prop('disabled', true);

                        var passfailed = selectedRowsData[0].PassedFailed;
                        //console.debug(passfailed);
                        
                        
                        if (passfailed == 'P'){
                            $("#accept").prop('disabled', false);
                            $("#hold").prop('disabled', true);
                        }
                        if (passfailed == 'F'){
                            $("#hold").prop('disabled', false);
                            $("#accept").prop('disabled', true);
                        }


                        var jobnum = selectedRowsData[0].JobNo;
                        var sequm = selectedRowsData[0].SeqNo;
                        var custnum = selectedRowsData[0].CustomerName;
                        var dept = selectedRowsData[0].DepartmentName;
                        var ref = selectedRowsData[0].Reference;
                        var machine = selectedRowsData[0].MachineName;
                        var prod = selectedRowsData[0].ProductName;
                        var zinc = selectedRowsData[0].Zinc;
                        var tensile = selectedRowsData[0].TensileTicket;
                        var mpa = selectedRowsData[0].MPA;
                        var wire = selectedRowsData[0].WireSize;
                        var castno = selectedRowsData[0].CastNo;

                        $('#jobnum').text(": "+ jobnum);
                        $('#seqnum').text(": "+ sequm);
                        $('#custnum').text(": "+ custnum);
                        $('#dept').text(": "+ dept);
                        $('#ref').text(": "+ ref);
                        $('#machine').text(": "+ machine);
                        $('#prod').text(": "+ prod);
                        //$('#SEno').text(": "+ SEno);
                        $('#zinc').text(": "+ zinc);
                        $('#tensile').text(": "+ tensile);
                        $('#mpa').text(": "+ mpa);
                        $('#wire').text(": "+ wire);
                        $('#cast').text(": "+ castno);
                    },

                    onRowClick:function(e){

                    },
                });

            }

        }); 

        //Get Scales
        $.ajax({

            url: '{!!url("/getTare")!!}',
            type: "GET",
            data: {

            },
            success: function (data) {
                // $("#tare").select2({ data:result });
                // console.log(data.length);
                // console.log(data);

                for (let i = 0; i < data.length; i++) {
                    // console.log(data[i].StandName);
                    name = data[i].StandName;
                    mass = data[i].StandMass;

                    $('#tare').append(`<option value="${mass}">${name}</option>`);
                }


            }
        });

        $('#accept').click(function(){
            var dataGrid = $("#gridContainer").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();
                        
            var jobnum = selectedRowsData[0].JobNo;
            var sequm = selectedRowsData[0].SeqNo;
            var custnum = selectedRowsData[0].CustomerName;
            var dept = selectedRowsData[0].DepartmentName;
            var ref = selectedRowsData[0].Reference;
            var machine = selectedRowsData[0].MachineName;
            var prod = selectedRowsData[0].ProductName;
            //var SEno = "TBC"//selectedRowsData[0].JobNo;//change
            var zinc = selectedRowsData[0].Zinc;
            var tensile = selectedRowsData[0].TensileTicket;
            var mpa = selectedRowsData[0].MPA;
            var wire = selectedRowsData[0].WireSize;
            var castno = selectedRowsData[0].CastNo;

            $.ajax({
                
                url: '{!!url("/acceptholdweigh")!!}',
                type: "POST",
                data: {
                    ref:ref,
                    custnum:custnum,
                    prod:prod,
                    dept:dept,
                    machine:machine,
                    jobnum:jobnum,
                    zinc:zinc,
                    mpa:mpa,
                    castno:castno,
                    wire:wire,
                    sequm:sequm,
                    tensile:tensile,
                    netmass: $('#final').val(),
                    GrossMass: $("#mass").val(),
                    taremass: $('#tare option:selected').val(),
                    buttonMethod: 'ACCEPT',
                },
                success: function (data) {
                    //location.reload();
                    
                    if (data[0].Result = "Success"){
                        var customer =  data[0].CustomerName;
                        var product =  data[0].ProductName;
                        var ticket =  data[0].TicketNo;

                        window.open('{!!url("/getgalvlabel")!!}/' +customer+'/'+product+'/'+ticket, "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");
                    }
                    
                }

            });
            
                
        });

        $('#hold').click(function(){
            var dataGrid = $("#gridContainer").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            var jobnum = selectedRowsData[0].JobNo;
            var sequm = selectedRowsData[0].SeqNo;
            var custnum = selectedRowsData[0].CustomerName;
            var dept = selectedRowsData[0].DepartmentName;
            var ref = selectedRowsData[0].Reference;
            var machine = selectedRowsData[0].MachineName;
            var prod = selectedRowsData[0].ProductName;
            //var SEno = "TBC"//selectedRowsData[0].JobNo;//change
            var zinc = selectedRowsData[0].Zinc;
            var tensile = selectedRowsData[0].TensileTicket;
            var mpa = selectedRowsData[0].MPA;
            var wire = selectedRowsData[0].WireSize;
            var castno = selectedRowsData[0].CastNo;

            $.ajax({
                
                url: '{!!url("/acceptholdweigh")!!}',
                type: "POST",
                data: {
                    ref:ref,
                    custnum:custnum,
                    prod:prod,
                    dept:dept,
                    machine:machine,
                    jobnum:jobnum,
                    zinc:zinc,
                    mpa:mpa,
                    castno:castno,
                    wire:wire,
                    sequm:sequm,
                    tensile:tensile,
                    netmass: $('#final').val(),
                    GrossMass: $("#mass").val(),
                    taremass: $('#tare option:selected').val(),
                    buttonMethod: 'HOLD',
                },
                success: function (data) {
                    if (data[0].Result = "Success"){
                        var customer =  data[0].CustomerName;
                        var product =  data[0].ProductName;
                        var ticket =  data[0].TicketNo;
                        
                        window.open('{!!url("/getgalvlabel")!!}/' +customer+'/'+product+'/'+ticket, "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");
                    }
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
