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
            <h3 style="flex-grow: 1;">Regrade</h3>
            <div class="tablearea" >
            <div id="gridContainer" style="max-width: 100% !important; height: 100%;">
            </div>
        </div>
    </div>

    

    <div title="Job Creation" id="createjob" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weighTestTitle">Regrade Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="customer"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Customer</label>
                        <select  class="form-control input-sm col-xs-1" id="customer" required>
                            <option></option>
                            @foreach($customers as $val)
                                <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="product"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Regrade to Product</label>
                        <select  class="form-control input-sm col-xs-1" id="product" required>
                            <option></option>
                        </select>
                    </div>


                </div>
                
                <br>
                <div class="modal-footer">
                    <button class="btn btn-success" id="regrade">REGRADE</button>
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
        
        $("#customer").change(function () {
            $.ajax({

                url: '{!!url("/wmaxgetcustomerproduct")!!}',
                type: "GET",
                data: {
                    customers: $("#customer").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#product").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.ProductID+'">'+o.ProductName+'</option>';
                    });
                    $("#product").append(toAppend);
                    $("#product").select2();
                }
            });
        });

        //GetWeigh
        $.ajax({

            url: '{!!url("/getregrade")!!}',
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
                        const worksheet = workbook.addWorksheet('regrade');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'regrade.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "Reference",
                            caption: "Reference",
                            //width:100,
                        },{
                            dataField: "TicketNo",
                            caption: "TicketNo",
                            //width:100,
                        },{
                            dataField: "Customer",
                            caption: "Customer",
                            //width:100,
                        },
                        {
                            dataField: "Department",
                            caption: "Deaprtment",
                            //width:100,
                        },
                        {
                            dataField: "Machine",
                            caption: "Machine",
                            //width:100,
                        },
                        {
                            dataField: "JobNo",
                            caption: "Job No",
                            //width:100,
                        },
                        {
                            dataField: "SequenceNo",
                            caption: "Seq No",
                            //width:100,
                        },
                        {
                            dataField: "WireTol",
                            caption: "Wire Spec",
                            //width:100,
                        },
                        {
                            dataField: "ActualWireSize",
                            caption: "Wire Test", 
                            dataType: "number",  
                            alignment: "left",
                            type:"fixedPoint",  
                            precision:2,
                            //width:100,
                        },
                        {
                            dataField: "MPASpec",
                            caption: "Mpa Spec",
                            //width:100,
                        },
                        {
                            dataField: "TreatedMPA",
                            caption: "MPa Test",
                            //width:100,
                        },
                        {
                            dataField: "ZincSpec",
                            caption: "Zinc Spec",
                            //width:100,
                        },
                        {
                            dataField: "TestedZinc",
                            caption: "Zinc Test",
                            //width:100,
                        },
                        {
                            dataField: "Type",
                            caption: "Zinc Coating",
                            //width:100,
                        },
                        {
                            dataField: "Weight",
                            caption: "Weight",
                            //width:100,
                        },
                    ],


                    onRowDblClick:function(e){
                        $('#createjob').modal('toggle');
                        var dataGrid = $("#gridContainer").dxDataGrid("instance");
                        var selectedRowsData = dataGrid.getSelectedRowsData();
                        
                        //var jobnum = selectedRowsData[0].JobNo;

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

        $('#regrade').click(function(){
            var dataGrid = $("#gridContainer").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            var ref = selectedRowsData[0].Reference;
            var custnum = selectedRowsData[0].Customer;
            var prod = selectedRowsData[0].ProductName;
            var dept = selectedRowsData[0].Department;
            var machine = selectedRowsData[0].Machine;
            var jobnum = selectedRowsData[0].JobNo;
            var zinc = selectedRowsData[0].TestedZinc;
            var mpa = selectedRowsData[0].TreatedMPA;
            var wire = selectedRowsData[0].WireSize;
            var sequm = selectedRowsData[0].SequenceNo;
            var tensile = selectedRowsData[0].TicketNo;

            $.ajax({
                
                url: '{!!url("/regradeproduct")!!}',
                type: "POST",
                data: {
                    jobnum:jobnum,
                    sequm:sequm,
                    custnum:custnum,
                    custnumfrom:$('#customer option:selected').val(),
                    dept:dept,
                    ref:ref,
                    machine:machine,
                    prod:prod,
                    prodfrom:$('#product option:selected').val(),
                    zinc:zinc,
                    tensile:tensile,
                    mpa:mpa,
                    wire:wire,
                },
                success: function (data) {
                    
                    if (data[0].Result = "Success"){
                        var customer =  data[0].CustomerName;
                        var product =  data[0].ProductName;
                        var ticket =  data[0].TicketNo;

                        window.open('{!!url("/getgalvlabel")!!}/' +customer+'/'+product+'/'+ticket, "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");
                    }
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
