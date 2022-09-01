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
    <div class="col-lg-7">
    <input type="hidden" id="jobid" value="{{$id}}">
    <hr>
    <button type="button" id="statuschange" class="btn btn-primary" data-toggle="modal" data-target="#jobchanges">Change Job Status</button>
    <button type="button" id="printlabels" class="btn btn-secondary" data-toggle="modal" data-target="#prinlabels">Print Additional Labels</button>
    <button type="button" id="sequence" class="btn btn-success" data-toggle="modal" data-target="#sequencedialog">Change Sequence</button>

    <div title="Statuses" id="jobchanges" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="jobchangesTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobchangesTitle">Change Status</h5>


                </div>
                <div class="modal-body">

                    <select class="form-control" id="finalisestatus">
                        <option></option>
                        <option value="start">Start</option>
                        <option value="hold">Hold</option>
                        <option value="end">End</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn-danger btn-lg" id="savechanges" style="width: 100%;">SAVE</button>
                </div>
            </div>
        </div>
    </div>

    <div title="Print Labels" id="prinlabels" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="prinlabelsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobchangesTitle"> Print Labels</h5><br>


                </div>
                <div class="modal-body">
                    <label>Product Label</label><br>
                    <input type="number" id="productlabelqtytoprint" class="form-control"><br>
                    <button class="btn btn-secondary"  id="finaliselabelprint" >Print Product Label</button>
                    <h4 id="errorprint"></h4>
                    <hr>
                    <label style="color: red">Pallet Label</label><br>
                    <input type="number" id="palletlabelqty" class="form-control"><br>
                    <button class="btn btn-danger"  id="finalisepalletprint" >Print Pallet Label</button>
                    <h4 id="errorprint"></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalclear">Close</button>

                </div>
            </div>
        </div>
    </div>
    <hr>
    <table class="table table-bordered">
@foreach($jobdata as $val)
        <tbody>
        <tr>

            <td>Current Job Status </td>
            <td>{{$val->jobStatus}}</td>
        </tr>
        <tr>
            <td>Job Number</td>
            <td>HK- {{$val->intJobId}} </td>

        </tr>
        <tr>
            <td>Job Sequence</td>
            <td>{{$val->intJobSequence}}</td>

        </tr>
        <tr>
            <td>Department</td>
            <td> {{$val->strDeptName}} </td>

        </tr>

        <tr>
            <td>Product Group</td>
            <td> {{$val->strProductGroup}} </td>

        </tr>
        <tr>
            <td>Product Category</td>
            <td> {{$val->strProductCat}} </td>

        </tr>
        <tr>
            <td>Product</td>
            <td> {{$val->PastelDescription}} </td>

        </tr>
        <tr>
            <td>Machine</td>
            <td> {{$val->strMachineName}}<input type="hidden" id="machineid" value="{{$val->intAutoMachineID}}"> </td>

        </tr>
        <tr>
            <td>Qty</td>
            <td> <input type="number"  class="form-control" id="qty" value="{{$val->mnyQtyRequired}}">  </td>

        </tr>
        <tr>
            <td>Current Pallet Qty</td>
            <td>  {{$val->palletQty}} </td>

        </tr>
        <tr>
            <td>Start Date</td>
            <td>  <input type="date" class="form-control" id="startdate"    value="{{$val->dteStartDate}}"> </td>

        </tr>
        <tr>
            <td>Estimated Duration</td>
            <td> - </td>

        </tr>
        <tr>
            <td>Estimated End Date</td>
            <td> - </td>

        </tr>
        </tbody>
    @endforeach
    </table>
        <hr>
        <h5>Items On The Machine</h5>
        <div id="gridContainer" style="width: 100% !important;">
        </div>
    </div>
    <div class="col-lg-5">
        <hr>
        <table class="table table-dark">

                <tbody>
                <tr>

                    <td>Job Start </td>
                    <td><input type="date" class="form-control" id="updatestartdate"> </td>
                    <td><button id="btnupdatestartdate" class="btn btn-primary" >Update Start Date</button> </td>
                </tr>
                <tr>
                    <td>Job End</td>
                    <td><input type="date" class="form-control" id="updateenddate"> </td>
                    <td><button id="btnupdateenddate" class="btn btn-primary" >Update End Date</button> </td>

                </tr>

                </tbody>
        </table>

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
        $('#modalclear').click(function(){
            $('#palletlabelqty').val("");
            $('#productlabelqtytoprint').val("");
        });

        $('#finalisepalletprint').click(function(){
            $.ajax({
                url: '{!!url("/sendLabelToThePrinter")!!}',
                type: "GET",
                data: {
                    qty: $('#palletlabelqty').val(),
                    type:2,
                    jobid:$('#jobid').val()
                },
                success: function (data) {
                    $('#palletlabelqty').val('');

                }

            });
        });

        $('#finaliselabelprint').click(function(){
            $.ajax({
                url: '{!!url("/sendLabelToThePrinter")!!}',
                type: "GET",
                data: {
                    qty: $('#productlabelqtytoprint').val(),
                    type:1,
                    jobid:$('#jobid').val()
                },
                success: function (data) {
                    $('#productlabelqtytoprint').val('');
                }

            });
        });

        $('#btnupdatestartdate').click(function(){
            $.ajax({
                url: '{!!url("/updatestartdate")!!}',
                type: "GET",
                data: {
                    startdate: $('#updatestartdate').val(),
                    jobid:$('#jobid').val()
                },
                success: function (data) {
                  alert("Done");

                }

            });
        });
        $('#btnupdateenddate').click(function(){
            $.ajax({
                url: '{!!url("/endjob")!!}',
                type: "GET",
                data: {
                    endjob: $('#updateenddate').val(),
                    jobid:$('#jobid').val()
                },
                success: function (data) {
                    alert("Done");

                }

            });
        });

        $.ajax({
            url: '{!!url("/getProductPlannedOnThatMachine")!!}',
            type: "GET",
            data: {
                machineId: $('#machineid').val()
            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    filterRow: { visible: true },
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

                        },
                        {
                            dataField: "strMachineName",
                            caption: "Machine",
                            width: 90,

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

                        }
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





</script>
</body>
