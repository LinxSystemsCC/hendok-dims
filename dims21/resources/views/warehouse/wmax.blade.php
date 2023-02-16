<?php
if ((Auth::guest()))
{

}else{
    $v  =  new \App\Http\Controllers\SalesForm();
}
$nwo = $v->getThingsUserPermissions(Auth::user()->UserID,'New Work Order');
$qc1 = $v->getThingsUserPermissions(Auth::user()->UserID,'QC Phase 1');
$qc2 = $v->getThingsUserPermissions(Auth::user()->UserID,'QC Phase 2');
$weight = $v->getThingsUserPermissions(Auth::user()->UserID,'Weight');
$print = $v->getThingsUserPermissions(Auth::user()->UserID,'Print');
$regrade = $v->getThingsUserPermissions(Auth::user()->UserID,'Regrade');
$sc = $v->getThingsUserPermissions(Auth::user()->UserID,'Stock Change');
$retest = $v->getThingsUserPermissions(Auth::user()->UserID,'Retest');

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.light.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">

    <!-- Select2 JS -->

    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>

</head>

<body>
<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2" style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>


    <div class="col-lg-10" >
        <div class="col-lg-10">
            @if($nwo !="0")
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createjob" style="margin-right:10px;">New Work Order</button>
            @endif

            @if($qc1 !="0")
            <button type="button" id="qcphase1" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">QC Phase 1 </button>
            @endif

            @if($qc2 !="0")
            <button type="button" id="qcphase2" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">QC Phase 2</button>
            @endif

            @if($weight !="0")
            <button type="button" id="weigh" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Weigh</button>
            @endif
            
            @if($print !="0")
            <button type="button" id="print" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Print</button>
            @endif

            {{-- <button type="button" id="scrapweigh" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Scrap Weighing</button> --}}

            @if($regrade !="0")
            <button type="button" id="regrade" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Regrade</button>
            @endif

            @if($sc !="0")
            <button type="button" id="stockchange" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Stock Change</button>
            @endif

            @if($retest !="0")
            <button type="button" id="retest" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Re-Test</button>
            @endif

        </div>
        <div id="gridContainer" style="width: 100% !important;">
        </div>

    </div>

    <div title="JOB" id="viewjob" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="viewjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewjobTitle">Work Order Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div title="Job Creation" id="createjob" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="createjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createjobTitle">Create A Work Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="control-label" for="customers"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Customer</label>
                        <select  class="form-control input-sm col-xs-1 " id="customers" style="width: 100%" required>
                            <option></option>
                            @foreach($customers as $val)
                                <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                            @endforeach

                        </select>


                    </div>

                    <div class="form-group">
                        <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                        <select  class="form-control input-sm col-xs-1" id="prodname" required>
                            <option></option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="wiresize"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Wire Size </label>
                        <select  class="form-control input-sm col-xs-1" id="wiresize" required>
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="department"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Department </label>
                        <select  class="form-control input-sm col-xs-1" id="department" required>
                            <option></option>
                            @foreach($dept as $val)
                                <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                                @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="machinename"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Machine </label>
                        <select  class="form-control input-sm col-xs-1" id="machinename" required>
                            <option></option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Mass Required </label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="qty" required>
                    </div>


                    <div class="form-group">
                        <label class="control-label" for="startdate"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">References </label>
                        <input type="reference" maxlength="15" class="form-control input-sm col-xs-1" id="reference">
                    </div>

                </div>
                <br><br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" id="savedepartment" style="width: 100%;">SAVE</button>
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
        
        var max_length = 15;
        $('#reference').keyup(function () {
            var len = max_length - $(this).val().length;
        });

        $("#customers").select2();

        $("#customers").change(function () {

            $.ajax({

                url: '{!!url("/wmaxgetcustomerproduct")!!}',
                type: "GET",
                data: {
                    customers: $("#customers").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.ProductID+'">'+o.ProductName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();
                }
            });

        });

        $('#prodname').change(function () {

            $.ajax({

                url: '{!!url("/wmaxgetproductwiresize")!!}',
                type: "GET",
                data: {
                    productId: $("#prodname").val()
                },
                success: function (data) {
                    var toAppend = '';
                    $("#wiresize").empty();
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+ parseFloat(o.WireSize).toFixed(2)+'">'+parseFloat(o.WireSize).toFixed(2)+'</option>';
                    });
                    
                    $("#wiresize").append(toAppend);
                    $("#wiresize").select2();
                    

                }
            });
        });

        $('#department').change(function(){
            $.ajax({

                url: '{!!url("/wmaxdepartmentmachinesgalv")!!}',
                type: "GET",
                data: {
                    deptId: $('#department').val(),


                },
                success: function (data) {
                    var toAppend = '';
                    $("#machinename").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.intAutoMachineID+'">'+o.strMachineName+'</option>';
                    });
                    $("#machinename").append(toAppend);
                    $("#machinename").select2();

                }

            });
        });

        $('#but_deptheader').click(function(){
            $.ajax({

                url: '{!!url("/getProductGroupMappedToDept")!!}',
                type: "GET",
                data: {
                    deptId: $('#departmentheader').val()
                },
                success: function (data) {
                    /* var toAppend = '';
                     $("#machinename").empty();
                     $.each(data,function(i,o){

                         toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                     });
                     $("#machinename").append(toAppend);
                     $("#machinename").select2();*/

                }

            });
        });

        $('#savedepartment').click(function(){
            var textbox = $('#reference').val();
            length = textbox.length;
            //console.debug(length)
            if (length <2) {
                alert("The entered input should be 2 or more than 2 characters");
                return false;
            } else{
                $.ajax({

                url: '{!!url("/insertIntoJobTableGalv")!!}',
                type: "POST",
                data: {
                    prodname: $('#prodname').val(),
                    wiresize: $('#wiresize').val(),
                    department: $('#department').val(),
                    machinename: $('#machinename').val(),
                    qty: $('#qty').val(),
                    customers: $('#customers').val(),
                    reference: $('#reference').val()
                },

                success: function (data) {
                    if(data[0].result == "Success"){

                        location.reload();
                    }else{
                        alert(""+data[0].result);
                    }

                }
            });
            }
            
            

        });

        $.ajax({
            url: '{!!url("/getGalvWIP")!!}',
            type: "GET",
            data: {
                machineId: $('#machineid').val()
            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    paging:{
                        pageSize: 14,
                    },
                    export: {
                        enabled: true
                    },
                    selection: {
                        mode: 'single',
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('machineplan');

                        DevExpress.excelExporter.exportDataGrid({
                            component: e.component,
                            worksheet,
                            autoFilterEnabled: true,
                        }).then(() => {
                            workbook.xlsx.writeBuffer().then((buffer) => {
                                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'machineplan.xlsx');
                            });
                        });
                        e.cancel = true;
                    },

                    columns: [
                        {
                            dataField: "JobNo",
                            caption: "Job No.",
                            //width: 80,

                        }, {
                            dataField: "CustomerName",
                            caption: "Customer Name",
                            //width: 100,

                        }, 
                        {
                            dataField: "DepartmentName",
                            caption: "Department",
                            //width: 250,

                        },
                        {
                            dataField: "MachineName",
                            caption: "Machine",
                            //width: 300,

                        },
                        {
                            dataField: "ProductName",
                            caption: "Product",
                            //width: 600,

                        },
                        {
                            dataField: "MassRequired",
                            caption: "Mass Required",
                            //width: 60,dataType:"number"

                        },
                        {
                            dataField: "MassProduced",
                            caption: "Mass Produced",
                            //width: 60,dataType:"number"

                        },
                        {
                            dataField: "TestDateTime",
                            caption: "Test Date",
                            //width: 100,dataType:"date"

                        },
                        {
                            dataField: "Reference",
                            caption: "Reference",
                            //width: 150,

                        },
                    ],

                    onRowDblClick:function(e){
                        console.log(e.data.intJobId);
                        var intJobId =  e.data.intJobId;

                        window.open('{!!url("/jobupdateprint")!!}/' +intJobId, "Job" +intJobId, "location=1,status=1,scrollbars=1, width=1200,height=850");

                    }

                });
            },

        });

        $('#qcphase1').click(function(){
            window.open('{!!url("/qc1")!!}',"_blank","location=1,status=1,scrollbars=1, width=1200,height=850");
        });

        $('#qcphase2').click(function(){
            window.open('{!!url("/qc2")!!}',"_blank","location=1,status=1,scrollbars=1, width=1200,height=850");
        });

        $('#weigh').click(function(){
            window.open('{!!url("/wmaxweigh")!!}',"_blank","location=1,status=1,scrollbars=1, width=1200,height=850");
        });

        $('#scrap').click(function(){
            window.open('{!!url("/wmaxscrap")!!}',"_blank","location=1,status=1,scrollbars=1, width=850,height=850");
        });

        $('#regrade').click(function(){
            window.open('{!!url("/wmaxregrade")!!}',"_blank","location=1,status=1,scrollbars=1, width=1200,height=850");
        });

        $('#stockchange').click(function(){
            window.open('{!!url("/wmaxstockchange")!!}',"_blank","location=1,status=1,scrollbars=1, width=400,height=700");
        });

        $('#retest').click(function(){
            window.open('{!!url("/wmaxretest")!!}',"_blank","location=1,status=1,scrollbars=1, width=650,height=1000");
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
</body>
