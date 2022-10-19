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



    <!-- Select2 JS -->


    <!-- DevExtreme library -->

    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>


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
    </style>


</head>
<body>


<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2"  style="background: white;border-right: 2px solid black;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col-lg-10" >
        <button type="button" class="btn-lg btn btn-primary pull-right" data-toggle="modal" data-target="#createjob">Create New Job</button><br>
        <div id="gridContainer" style="width: 100% !important;">
        </div>

    </div>
    <div title="JOB" id="viewjob" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="viewjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewjobTitle">Job Data</h5>
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
                    <h5 class="modal-title" id="createjobTitle">Create A Job</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label class="control-label" for="departmentheader"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Department</label>
                        <select  class="form-control input-sm col-xs-1 " id="departmentheader" style="width: 100%" required>
                            <option></option>
                            @foreach($dept as $val)
                                <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                            @endforeach

                        </select>


                    </div>
                <div class="input-group mb-3">
                    <label class="control-label" for="department"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Group </label>
                    <select  class="form-control input-sm col-xs-1 " id="department" style="width: 100%" required>
                        <option></option>
                        @foreach($prodGroups as $val)
                            <option value="{{$val->ItemGroup}}">{{$val->ItemGroupDescription}}</option>
                        @endforeach
                    </select>

                    <input type='button' value='Confirm Prod Group' class="btn btn-secondary btn-sm" id='but_read'>

                </div>
                <div class="form-group">
                    <label class="control-label" for="productcategory"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Category </label>
                    <select  class="form-control input-sm col-xs-1" id="productcategory" required>
                        <option></option>
                    </select>
                    <input type='button' class="btn btn-secondary btn-sm" value='Confirm Prod Cat' id='getproduct' style="margin-top: 22px;">
                </div>
                <div class="form-group">
                    <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                    <select  class="form-control input-sm col-xs-1" id="prodname" required>
                        <option></option>
                    </select>

                </div>

                    <div class="form-group">
                        <label class="control-label" for="machinename"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Machine </label>
                        <select  class="form-control input-sm col-xs-1" id="machinename" required>
                            <option></option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="qty"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Qty </label>
                        <input type="number"  class="form-control input-sm col-xs-1" id="qty" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="palletconfig"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Pallet Conf </label>
                        <select  class="form-control input-sm col-xs-1" id="palletconfig" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="startdate"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Start Date </label>
                        <input type="date" class="form-control input-sm col-xs-1" id="startdate">
                    </div>

                </div>
        <br><br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn-danger btn-lg" id="savedepartment" style="width: 100%;">SAVE</button>
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

$("#machinename").change(function () {

    $.ajax({

        url: '{!!url("/getPalletForSelectedItem")!!}',
        type: "GET",
        data: {
            itemCode: $("#prodname").val(),
            intMachine: $("#machinename").val()
        },
        success: function (data) {
            var toAppend = '';
            $("#palletconfig").empty();
            toAppend += '<option></option>';
            $.each(data,function(i,o){

                toAppend += '<option value="'+o.intPalletId+'">'+o.strPalletTypeDescription+'</option>';
            });
            $("#palletconfig").append(toAppend);
            $("#palletconfig").select2();
        }
    });

});

$('#prodname').change(function () {



    $.ajax({

        url: '{!!url("/getMachinesforselecteddept")!!}',
        type: "GET",
        data: {
            deptId: $("#departmentheader").val(),
            prodname: $("#prodname").val()
        },
        success: function (data) {
            var toAppend = '';
            $("#machinename").empty();
            $.each(data,function(i,o){

                toAppend += '<option value="'+o.intMachineID+'">'+o.strMachineName+'</option>';
            });
            $("#machinename").append(toAppend);
            $("#machinename").select2();
        }
    });
});


        $("#department").select2();

        $('#but_read').click(function(){
            var ItemGroupDescription = $('#department option:selected').text();
            var ItemGroup = $('#department').val();
            $.ajax({

                url: '{!!url("/getProdCategory")!!}',
                type: "GET",
                data: {
                    ItemGroup: ItemGroup
                },
                success: function (data) {
                    var toAppend = '';
                    $("#productcategory").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){
                        toAppend += '<option value="'+o.strProductCategory+'">'+o.strProductCategory+'</option>';
                    });
                    $("#productcategory").append(toAppend);
                    $("#productcategory").select2();
                    $("#productcategory").change(function () {
                        $("#prodname").empty();



                    });



                }

            });

           // $('#result').html("id : " + userid + ", name : " + username);

        });

        $('#getproduct').click(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#department').val(),
                    strProductCategory: $("#productcategory").val()

                },
                success: function (data) {
                    var toAppend = '';
                    $("#prodname").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.strItemCode+'">'+o.strItemName+'</option>';
                    });
                    $("#prodname").append(toAppend);
                    $("#prodname").select2();

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

            $.ajax({

                url: '{!!url("/insertIntoJobTable")!!}',
                type: "POST",
                data: {
                    deptId: $('#departmentheader').val(),
                    prodgroup: $('#department').val(),
                    productcategory: $('#productcategory').val(),
                    prodname: $('#prodname').val(),
                    machinename: $('#machinename').val(),
                    qty: $('#qty').val(),
                    startdate: $('#startdate').val(),
                    palletconfig: $('#palletconfig').val()
                },
                success: function (data) {
                    if(data[0].result == "Success"){

                        location.reload();
                    }else{
                        alert(""+data[0].result);
                    }

                }
            });
        });

        $.ajax({
            url: '{!!url("/getWIP")!!}',
            type: "GET",
            data: {
                machineId: $('#machineid').val()
            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    paging:{
                        pageSize: 20,
                    },
                    export: {
                        enabled: true
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
                            dataField: "intJobId",
                            caption: "JobNo",
                            width: 60,

                        }, {
                            dataField: "intJobSequence",
                            caption: "Job Sequence",
                            width: 60,

                        }, {
                            dataField: "strDeptName",
                            caption: "Department",
                            width: 150,

                        },
                        {
                            dataField: "strMachineName",
                            caption: "Machine",
                            width: 150,

                        },
                        {
                            dataField: "PastelDescription",
                            caption: "Product",
                            width: 400,

                        },
                        {
                            dataField: "mnyQtyRequired",
                            caption: "Qty",
                            width: 90,dataType:"number"

                        },
                        {
                            dataField: "palletQty",
                            caption: "Pallet Qty",
                            width: 90,dataType:"number"

                        }
                        ,
                        {
                            dataField: "dteStartDate",
                            caption: "Start Date",
                            width: 100,dataType:"date"

                        },
                        {
                            dataField: "jobStatus",
                            caption: "Job Status",
                            width: 60,

                        },
                    ],
                    onRowDblClick:function(e){
                        console.log(e.data.intJobId);
                        var intJobId =  e.data.intJobId;

                        window.open('{!!url("/jobupdateprint")!!}/' +intJobId, "Job" +intJobId, "location=1,status=1,scrollbars=1, width=1200,height=850");

                    }

                });

            }

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
