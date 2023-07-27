<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
        <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
        <title>Weigh</title>
    
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        
        <!-- DevExtreme theme -->
        {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    </head>

    <div class="col-12 d-flex px-0"  style="background: white;">
        <div class="col-custom-2" style="background: white;">
    
            <div class="vertical-menu">
                @include('warehouse.menu')
            </div>
        </div>

        <div class="col p-3">
            <h3 style="flex-grow: 1;">Weigh</h3>
            <div class="tablearea" >
            <div id="gridContainer" style="max-width: 100% !important; height: 100%;">
            </div>
        </div>
    </div>

    <div class="modal modal-lg fade" id="createjob" aria-labelledby="createjob" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weighTestTitle">Set Weight</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModal"></button>
                </div>
    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="jobnum"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Job No</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="jobnum"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="seqnum"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                Seq No
                            </label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="seqnum"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="custnum"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Customer No</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="custnum"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="dept"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Department</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="dept"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="ref"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Reference</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="ref"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="machine"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Machine</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="machine"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="prod"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Product</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="prod"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="zinc"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Zinc</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="zinc" style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="tensile"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Tensile Ticket</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="tensile"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="mpa"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">MPA</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="mpa"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="wire"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Actual Wire Size</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="wire"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="cast"  style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Cast No</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="cast"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="control-label" for="tare"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Tare Mass</label>
                        </div>
                        <div class="col-md-9 mb-1">
                            <select  class="form-select" id="tare" required>
                                <option>
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="control-label" for="mass"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Mass</label>
                        </div>
                        <div class="d-inline-flex col-md-9 mb-1">
                            <div class="col-md-8 mb-1">
                                <select  class="form-select" id="scales" required>
                                    <option></option>
                                    @foreach ($scales as $scale)
                                        <option value="{{ $scale->intAutoId }}">{{ $scale->strName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-2 mb-1">
                                <button class="btn btn-primary mx-1" id="update">UPDATE</button>
                            </div> --}}
                            <div class="col-md-4 mb-1">
                                <input type="number" class="form-control input-sm col-xs-1" id="mass" required disabled>
                            </div>
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="control-label" for="final"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Final Mass</label>
                        </div>  
                        <div class="col-md-9 mb-1">
                            <input type="number" class="form-control input-sm col-xs-1" id="final" required disabled>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="d-inline-flex gap-2">
                        <button class="btn btn-success" id="accept" style="width:50%">ACCEPT</button>
                        <button class="btn btn-danger" id="hold" style="width:50%">HOLD</button>
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

<!-- Excel Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

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
        
        // $("#mass").change(function() {
        //     finalweight = ($("#mass").val()-$('#tare').val());
        //     $('#final').val(finalweight);
        // });

        $("#scales").change(function() {
            // console.log($("#scales").val() );
            if ($("#scales").val() == ''){
                $('#update').prop('disabled', false);
            }else{
                $('#update').prop('disabled', true);
                $('#mass').prop('disabled', true);
            }
            fetchWeight();
        });

        $("#update").click(function(){
            $('#mass').prop('disabled', function(_, disabled) {
                return !disabled;
            });
            $('#scales').prop('disabled', function(_, disabled) {
                return !disabled;
            });
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
                    hoverStateEnabled: true,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    scrolling: {
                        rowRenderingMode: 'infinite',
                    },
                    paging:{
                        pageSize: 10,
                    },
                    pager: {
                        visible: true,
                        allowedPageSizes: [5, 10, 20, 50, 'all'],
                        showPageSizeSelector: true,
                        showInfo: true,
                        showNavigationButtons: true,
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

                        $('#jobnum').text(jobnum);
                        $('#seqnum').text(sequm);
                        $('#custnum').text(custnum);
                        $('#dept').text(dept);
                        $('#ref').text(ref);
                        $('#machine').text(machine);
                        $('#prod').text(prod);
                        //$('#SEno').text(SEno);
                        $('#zinc').text(zinc);
                        $('#tensile').text(tensile);
                        $('#mpa').text(mpa);
                        $('#wire').text(wire);
                        $('#cast').text(castno);
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
                    if (data[0].Result = "Success"){
                        var customer =  data[0].CustomerName;
                        var product =  data[0].ProductName;
                        var ticket =  data[0].TicketNo;

                        // window.open('{!!url("/getgalvlabel")!!}/' +customer+'/'+product+'/'+ticket +'/Accept', "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");
                        window.open('{!!url("/printGalvLabel")!!}/'+ticket,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");

                        location.reload();
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
                        
                        window.open('{!!url("/getgalvlabel")!!}/' +customer+'/'+product+'/'+ticket +'/Hold', "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");

                        location.reload();
                    }
                }

            });

            
            
                
        });
        
        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");

        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

        doacheck();
        fetchWeight();
        toggleWeigh();


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

    function doacheck(){
        setInterval(checkforchanges,10000);
    };

    function checkforchanges(){
        $.ajax({
            url: '{!!url("/checkForGalvUpdates")!!}',
            type: "GET",
            data: {
                checker: "WEIGH",
            },
            success: function (data) {
                // console.log(data[0].Result);
                if (data[0].Result == "Reload"){
                    console.log("deleting record and reloading");
                    //runs store procedure to delete the record
                    $.ajax({
                        url: '{!!url("/deleteGalvChecker")!!}',
                        type: "GET",
                        data: {
                            checker: "WEIGH",
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
                else{
                    // console.log("as you where young lad");
                }
            }
        });
    };

    function toggleWeigh(){
        setInterval(fetchWeight,10000);
    };

    function fetchWeight(){
    
    // console.debug("weigh");
    $.ajax({
        url: '{!!url("/listenToScale")!!}',
        type: "GET",
        data: {
            scaleID: $('#scales option:selected').val(),
        },
        success: function (data) {
            if (data){
                $('#mass').val(data);
                finalweight = ($("#mass").val()-$('#tare').val());
                $('#final').val(finalweight);
            }else{
                $('#mass').val(0);
            }
            
        }
    });
};
</script>
