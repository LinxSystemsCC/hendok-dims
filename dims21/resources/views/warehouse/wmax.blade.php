<?php
if ((Auth::guest()))
{

}else{
    $v  =  new \App\Http\Controllers\SalesForm();
}
$nwo = $v->getThingsUserPermissions(Auth::user()->UserID,'New Work Order');
// $qc1 = $v->getThingsUserPermissions(Auth::user()->UserID,'QC Phase 1');
// $qc2 = $v->getThingsUserPermissions(Auth::user()->UserID,'QC Phase 2');
// $weight = $v->getThingsUserPermissions(Auth::user()->UserID,'Weight');
// $print = $v->getThingsUserPermissions(Auth::user()->UserID,'Print');
// $regrade = $v->getThingsUserPermissions(Auth::user()->UserID,'Regrade');
// $sc = $v->getThingsUserPermissions(Auth::user()->UserID,'Stock Change');
// $retest = $v->getThingsUserPermissions(Auth::user()->UserID,'Retest');

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
    <title>Galv Module</title>

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

<body>
<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2" style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>


    <div class="col-lg-10" >
        <div class="col-lg-10" id="tabs">
            @if($nwo !="0")
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createjob">
                Create Job
            </button>
            @endif

            @if($nwo !="0")
            <button type="button" id="completejob" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#finalisejob" disabled>
                Complete Job
            </button>
            @endif

            {{-- @if($qc1 !="0")
            <button type="button" id="qcphase1" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">QC Phase 1 </button>
            @endif --}}

            {{-- @if($qc2 !="0")
            <button type="button" id="qcphase2" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">QC Phase 2</button>
            @endif --}}

            {{-- @if($weight !="0")
            <button type="button" id="weigh" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Weigh</button>
            @endif --}}
            
            {{-- @if($print !="0")
            <button type="button" id="print" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Print</button>
            @endif --}}

            {{-- <button type="button" id="scrapweigh" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Scrap Weighing</button> --}}

            {{-- @if($regrade !="0")
            <button type="button" id="regrade" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Regrade</button>
            @endif --}}

            {{-- @if($sc !="0")
            <button type="button" id="stockchange" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Stock Change</button>
            @endif --}}

            {{-- @if($retest !="0")
            <button type="button" id="retest" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Re-Test</button>
            @endif --}}

        </div>
        <div id="gridsummedup" style="width: 100% !important;">
        </div>
        <div id="gridContainer" style="width: 100% !important;">
        </div>

    </div>

    <!-- Finalise Job Modal -->
    <div class="modal fade" id="finalisejob" aria-labelledby="finalisejob" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finalisejob">Complete Job</h5>
                </div>
                <div class="modal-body">
                    <h6 id="JobEndTextMessage">ARE YOU SURE YOU WANT TO COMPLETE THIS JOB?</h6>
                </div>
                <div class="modal-footer d-inline">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeFinaliseJob">CLOSE</button>
                    <button class="btn btn-danger" id="completesave">COMPLETE</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div title="JOB" id="finalisejob" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="finalisejob" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finalisejob">Complete Job</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 id="JobEndTextMessage">ARE YOU SURE YOU WANT TO COMPLETE THIS JOB?</h6>
                </div>
                <div class="modal-footer d-inline">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: 47%;">Close</button>
                    <button class="btn btn-danger" id="completesave" style="width: 47%;">COMPLETE</button>
                </div>
            </div>
        </div>
    </div> --}}

    <div title="Job Creation" id="createjob" class="modal modal-xl fade"   tabindex="-1" role="dialog" aria-labelledby="createjob" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createjob">Create A Work Order</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="customers" class="col-form-label">Customer</label>
                            <select class="form-select" type="text" id='customers'>
                                <option value="None"></option>
                                @foreach($customers as $val)
                                <option value="{{$val->CustomerName}}">{{$val->CustomerName}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="prodname">Product Name </label>
                            <select class="form-select" id="prodname" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="wiresize">Wire Size</label>
                            <select class="form-select" id="wiresize" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="department">Department</label>
                            <select class="form-select" id="department" required>
                                <option></option>
                                @foreach($dept as $val)
                                    <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="machinename">Machine</label>
                            <select class="form-select" id="machinename" required>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="qty">Quantity Required</label>
                            <input type="number" class="form-control" id="qty" required>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label" for="reference">References</label>
                            <input type="text" maxlength="15" class="form-control" id="reference" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" id="saveGalvJob" style="width: 100%;">SAVE</button> --}}

                    <button type="button" class="btn btn-secondary" data-bs-target="#createjob" data-bs-toggle="modal" id="cancelCreateJob">CANCEL</button>
                    <button type="button" id="saveGalvJob" class="btn btn-success" data-bs-target="#createjob" data-bs-toggle="modal">SAVE</button>
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

    .dx-checkbox-checked .dx-checkbox-icon {
        background-color: #df2413 !important;
    }

    .dx-checkbox-indeterminate .dx-checkbox-icon {
        background-color: #fff;
        border: 2px solid rgba(0,0,0,.54);
    }

    .dx-selection {
        background-color: #df2413; /* Specify the desired background color */
        font-weight: 700;
        /* Additional styles */
    }


    /* .dx-datagrid {
        height: calc(50vh - 40px);
        max-height: calc(50vh - 40px);
    } */
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
        
        var max_length = 15;
        $('#reference').keyup(function () {
            var len = max_length - $(this).val().length;
        });

        $('#customers').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#createjob'),
        });

        $('#department').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#createjob'),
        });

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
                    $("#prodname").select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#createjob'),
                    });
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
                    $("#wiresize").select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#createjob'),
                    });
                    

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

                        toAppend += '<option value="'+o.intMachineID+'">'+o.strMachineName+'</option>';
                    });
                    $("#machinename").append(toAppend);
                    $("#machinename").select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#createjob'),
                    });

                }

            });
        });

        $('#completesave').click(function(){
            var selectedItem = $("#gridContainer").dxDataGrid("instance").getSelectedRowsData()[0];
            var JobId = selectedItem.JobNo;
            // console.log(JobId);
            $.ajax({

                url: '{!!url("/changeGalvJobStatus")!!}',
                type: "GET",
                data: {
                    JobId: JobId,
                },
                success: function (data) {
                    alert("Job Completed!");
                    location.reload();
                }
            });
        });

        $('#saveGalvJob').click(function(){
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

        var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization

        $.ajax({
            url: '{!!url("/getGalvWIP")!!}',
            type: "GET",
            data: {
                machineId: $('#machineid').val()
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
                        pageSize: 20,
                    },
                    pager: {
                        visible: true,
                        allowedPageSizes: [5, 10, 20, 50, 'all'],
                        showPageSizeSelector: true,
                        showInfo: true,
                        showNavigationButtons: true,
                    },
                    selection: {
                        mode: "single",
                        rowCssClass: 'custom-selected-row'
                        // showCheckBoxesMode: "onClick"
                    },
                    columns: [
                        // {
                        //     caption: "Complete",
                        //     type: 'selection',
                        //     allowSelectAll: false,
                        //     selectAllMode: 'page',
                        // }, 
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
                        }
                    ],

                    onRowDblClick:function(e){

                    },
                    onRowClick:function(e){
                        var currentID = currentSelectedRow[0];
                        var clickedID = e.data.JobNo;

                        if (clickedID === currentID){
                            currentSelectedRow = [];
                            e.component.clearSelection();
                            $("#completejob").prop("disabled", true);
                        }else{
                            currentSelectedRow = [];
                            currentSelectedRow.push(clickedID);

                            $("#JobEndTextMessage").css("white-space", "pre-wrap");
                            $("#JobEndTextMessage").text("ARE YOU SURE YOU WANT TO COMPLETE JOB: "+clickedID+"? \nTHE JOB WILL NO LONGER BE ACCESSABLE ANYMORE");
                            $("#completejob").prop("disabled", false);
                        }

                    },
                });

                var gridElement = $("#gridContainer");
                gridElement.css("height", "74%");
            },

        });

        $.ajax({
            url: '{!!url("/getGalvWIPConsolidated")!!}',
            type: "GET",
            success: function (data) {
                $("#gridsummedup").dxDataGrid({
                    dataSource:data, //as json
                    hoverStateEnabled: true,
                    showBorders: true,
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    scrolling: {
                        rowRenderingMode: 'infinite',
                    },
                    selection: {
                        mode: 'single',
                    },

                    columns: [
                        {
                            dataField: "MachineName",
                            caption: "Machine Group",
                            //width: 80,

                        }, {
                            dataField: "DayWeight",
                            caption: "Day Shift Weights",
                            //width: 100,

                        }, 
                        {
                            dataField: "NightWeight",
                            caption: "Night Shift Weights",
                            //width: 250,

                        },
                        {
                            dataField: "DayCount",
                            caption: "Day Shift Holds",
                            //width: 300,

                        },
                        {
                            dataField: "NightCount",
                            caption: "Night Shift Holds",
                            //width: 600,

                        },
                    ]

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

        doacheck();
        
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
                checker: "NEWJOB",
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
                            checker: "NEWJOB",
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

</script>
</body>
