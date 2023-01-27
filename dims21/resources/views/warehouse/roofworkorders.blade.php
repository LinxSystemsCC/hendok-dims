<?php
if ((Auth::guest()))
{
}else{
    $v  =  new \App\Http\Controllers\SalesForm();
}
$nwor = $v->getThingsUserPermissions(Auth::user()->UserID,'New Work Order Roof');
$ppso = $v->getThingsUserPermissions(Auth::user()->UserID,'Pre Planning SO');
$print = $v->getThingsUserPermissions(Auth::user()->UserID,'Roof Print');
?>

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
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

</head>

<body>
<div class="col-lg-12 d-flex bd-highlight"  style="background: white;">
    <div class="col-lg-2" style="background: white;">

        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    
    <div class="col-lg-10"  style="width:100%; max-width:100% !important">
        <h3 style="flex-grow: 1;">Work Orders</h3>
        
        <div>
            @if($nwor !="0")
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createjob" style="margin-right:10px;">Update Work Order</button>
            @endif
            
            @if($ppso !="0")
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#preplanningso" style="margin-right:10px;">Pre Planning SO</button>
            @endif
            
            @if($print !="0")
            <button type="button" id="printjobcard" class="btn btn-primary" data-toggle="modal" data-target="#sequencedialog">Print All Active Jobs</button>
            @endif

            @if($ppso !="0")
            <div style="float:right;">
                {{-- Date from --}}
                <label class="control-label" for="datefrom"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date From </label>
                <input type="date" id="datefrom">

                {{-- Date To --}}
                <label class="control-label" for="dateto"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date To </label>
                <input type="date" id="dateto">
                <button class="btn btn-info" id="get">GET</button>
            </div>
            @endif

        </div>
        
        <div id="gridContainerWO" style="width: 100% !important;">
        </div>

        <br>
        <br>

        @if($ppso !="0")
        <h3 id="PPSO" style="flex-grow: 1;">Pre Planned Sales Orders</h3>
        <div id="gridContainerPPSO" style="width: 100% !important;">
        </div>
        @endif


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

    <div title="Pre Planning SO" id="preplanningso" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="preplanningso" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="preplanningsoTitle">Pre Planning SO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-inline-flex w-100">
                        <div class="form-group col-4">
                            <label class="control-label" for="salesorders"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Sales Orders</label>
                            <textarea  type="text" rows="20" class="form-control input-sm col-xs-1" id="salesorders" required></textarea>
                        </div>
                        
                        <div class="form-group col-4">
                            <label class="control-label" for="invoiceorders"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Invoice Orders</label>
                            <textarea  type="text" rows="20" class="form-control input-sm col-xs-1" id="invoiceorders" required></textarea>
                        </div>

                        <div class="form-group col-4">
                            <label class="control-label" for="company"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Company</label>
                            <textarea  type="text" rows="20" class="form-control input-sm col-xs-1" id="company" required></textarea>
                        </div>
                    </div>
                        
    
                    <div class="form-group">
                        <label class="control-label" for="reference"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Reference </label>
                        <input type="text"  class="form-control input-sm col-xs-1" id="reference" required>
                    </div>

                </div>

                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button class="btn-danger btn-lg" id="save" style="width: 100%;">SAVE</button>
                </div>
            </div>
        </div>

    </div>

    <div title="Job Creation" id="createjob" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="createjobTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="min-width: 90% !important; max-width: 90% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createjobTitle">Update Roofing Work Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Date from --}}
                    <label class="control-label" for="datefromheader"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date From </label>
                    <input type="date" id="datefromheader">

                    {{-- Date To --}}
                    <label class="control-label" for="datetoheader"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date To </label>
                    <input type="date" id="datetoheader">
                    <button class="btn btn-info" id="getheaders">GET</button>

                    <br><br>
                    
                    <div id="headergrid" style="width: 100% !important; height:50%;">
                    </div>

                    <div id="linesgrid" style="width: 100% !important; height:50%;">
                    </div>

                    {{-- <div class="input-group mb-3">
                        <label class="control-label" for="productcategory"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Department</label>
                        <select  class="form-control input-sm col-xs-1 " id="department" style="width: 100%" required>
                            <option></option>
                            @foreach($dept as $val)
                                <option value="{{$val->intAutoID}}">{{$val->strDeptName}}</option>
                            @endforeach

                        </select>


                    </div>

                    <div class="input-group mb-3">
                        <label class="control-label" for="productcategory" onselect="but_read" style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Category </label>
                        <select  class="form-control input-sm col-xs-1 " id="productcategory" style="width: 100%" required>
                            <option></option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="prodname"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Product Name </label>
                        <select  class="form-control input-sm col-xs-1" id="prodname" required>
                            <option></option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label class="control-label" id="SOLabel" for="salesorders"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Sales Orders </label><br>
                        <div id="SOList">
                            
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="machinename"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Machine </label>
                        <select  class="form-control input-sm col-xs-1" id="machinename" required>
                            <option></option>
                        </select>
                    </div> --}}

                    <div id="gridContainerWO" class="w-100"></div>
                        
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="saveWorkOrder" aria-label="Save">Save</button>
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

    var batchID = 0;
    var batchReference = 0;

    $(document).ready(function() {
        $('#PPSO').hide();
        $('#SOLabel').hide();
        var date = (new Date()).toISOString().slice(0, 10);
		$('#datefrom').val(date);
		$('#dateto').val(date);
        $('#datefromheader').val(date);
		$('#datetoheader').val(date);
        

        $.ajax({
            url: '{!!url("/getRoofWIP")!!}',
            type: "GET",
            data: {
                machineId: $('#machineid').val()
            },
            success: function (data) {
                $("#gridContainerWO").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    paging:{
                        pageSize: 20,
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
                            dataField: "intJobId",
                            caption: "JobNo",
                            //width: 80,

                        }, {
                            dataField: "intJobSequence",
                            caption: "Job Seq",
                            //width: 100,

                        },
                        {
                            dataField: "strMachineName",
                            caption: "Machine",
                            //width: 300,

                        },
                        {
                            dataField: "PastelDescription",
                            caption: "Product",
                            //width: 600,

                        },
                        {
                            dataField: "mnyQtyRequired",
                            caption: "Qty",
                            //width: 60,dataType:"number"

                        },
                        {
                            dataField: "dteStartDate",
                            caption: "Start Date",
                            //width: 100,dataType:"date"

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

        headersFunction();
        
        $('#getheaders').click(function(){
            headersFunction();
        });

        $('#save').click(function(){
            if (($("#reference").val()).length < 1)
                alert("The Reference needs to be inserted");
            else{
                const salorders = $("#salesorders").val();
                const invorders = $("#invoiceorders").val();
                const comp = $("#company").val();

                var salesorders = salorders.split("\n");
                var invoiceorders = invorders.split("\n");
                const company = comp.split("\n");
                
                var SOnumbers = new Array();
                var IOnumbers = new Array();
                var CompName = new Array();
                

                linesignored = 0;

                for (let i = 0; i < salesorders.length; i++)
                    if (salesorders[i] == ''){
                        salesorders+= 1;
                    }else{
                        SOnumbers.push(escapeHtml(salesorders[i]));
                    }
                
                var linesignored = 0;

                for (let i = 0; i < invoiceorders.length; i++)
                    if (invoiceorders[i] == ''){
                        linesignored+= 1;
                    }else{
                        IOnumbers.push(escapeHtml(invoiceorders[i]));
                    }


                linesignored = 0;

                for (let i = 0; i < company.length; i++)
                    if (company[i] == ''){
                        company+= 1;
                    }else{
                        CompName.push(escapeHtml(company[i]));
                    }

                var orderlines = new Array();
                
                for (let i = 0; i < salesorders.length; i++)
                    orderlines.push({'SOnumbers': SOnumbers[i],'IOnumbers': IOnumbers[i],'CompanyName': CompName[i]});

                // console.log(orderlines);
                // console.log(IOnumbers);

                $.ajax({
                    url: '{!!url("/insertPrePlannedSO")!!}',
                    type: "POST",
                    data: {
                        orderlines: orderlines,
                        reference: $("#reference").val()
                    },
                    success: function (data) {
                        if(data[0].Result == "Success"){
                            location.reload();
                        }else{
                            alert(""+data[0].Result);
                        }
                    }
                });
            }
                
        });

        $('#saveWorkOrder').click(function(){
            var linesgrid = $("#linesgrid").dxDataGrid("instance");
            var allGridItems =  $("#linesgrid").dxDataGrid("getDataSource").items();
            var checkedLines = new Array();
            var dataSource = linesgrid.getDataSource();

            // console.debug(allGridItems);
            var seq = 0;

            allGridItems.forEach((element, index, value) => {
                // console.debug(element);
                seq += 1;
                checkedLines.push({
                    'UniqueID': element["UniqueID"],
                    'strSONum': element["strSONum"],
                    'intAutoMachineID':element["intMachineId"],
                    'ProdName': escapeHtml(element["Code"]),
                    'intQty':element["intQty"],
                    'Dept': 'Roofing',
                    'strReference': element["strReference"],
                    'intOrderLineID': element["intOrderLineID"],
                    'jobSeq' : seq,
                });
            });

            console.debug(checkedLines);
            $.ajax({
                url: '{!!url("/updateRoofLines")!!}',
                type: "POST",
                data: {
                    workOrders: checkedLines,
                    batchID: batchID,
                    batchReference: batchReference,
                },
                success: function (data) {
                    if(data[0].Result == "Success"){
                        //location.reload();
                    }else{
                        alert(""+data[0].Result);
                    }
                }
            });

        });

        $('#department').change(function(){
            $.ajax({

                url: '{!!url("/getDepListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#department option:selected').text(),
                    strProductCategory: $("#productcategory").val()

                },
                success: function (data) {
                    var toAppend = '';
                    $("#productcategory").empty();
                    toAppend += '<option></option>';
                    $.each(data,function(i,o){

                        toAppend += '<option value="'+o.intAutoGroupCategoryId+'">'+o.strProductCategory+'</option>';
                    });
                    $("#productcategory").append(toAppend);
                    $("#productcategory").select2();

                }

            });
        });

        $('#productcategory').change(function(){
            $.ajax({

                url: '{!!url("/getProdListToPlan")!!}',
                type: "GET",
                data: {
                    ItemGroup: $('#productcategory option:selected').text(),
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

        $('#get').click(function(){
            $('#PPSO').show();
            
            $.ajax({
                url: '{!!url("/getroofingWIP")!!}',
                type: "GET",
                data: {
                    datefrom: $('#datefrom').val(),
                    dateto: $('#dateto').val()
                },
                success: function (data) {
                    
                    $("#gridContainerPPSO").dxDataGrid({
                        dataSource:data, //as json
                        showBorders: true,
                        hoverStateEnabled: true,
                        filterRow: { visible: true },
                        filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        allowColumnResizing: true,
                        columnAutoWidth: true,
                        paging:{
                            pageSize: 20,
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
                                dataField: "strReference",
                                caption: "Reference",
                                //width: 80,
                            }, {
                                dataField: "UserName",
                                caption: "User",
                                //width: 100,
                            }, {
                                dataField: "dtmCreated",
                                caption: "Date",
                                //width: 200,
                            },
                        ],

                        onRowDblClick:function(e){
                        //console.log(e.data.strReference);
                        var reference =  e.data.strReference;
                        var ref = '<p><label>Reference</label><br><input id="theReference" value="'+reference+'" disabled><br></p>';
                        var table = '';
                        $.ajax({

                            url: '{!!url("/getsalesorders")!!}',
                            type: "GET",
                            data: {
                                reference: reference,
                            },
                            success: function (data) {
                                //location.reload();
                                console.debug(data[0]);
                                table += '<table class="table table-responsive table-hover table-bordered" id="list_table_json">';
                                table += '<thead>';
                                table += '<tr>';
                                table += '<th id="header">Reference: '+reference+'</th>';           
                                table += '</tr>';
                                table += '</thead>';
                                table += '<tbody>';
                                $.each(data, function(index, value){
                                    table += '<tr>';
                                    table += '<td>'+value.strSONum+'</td>';
                                    table += '<tr>';
                                });
                                table += '</tbody>';
                                table += '</table>';

                                var dialog = $(table).dialog({
                                    height: 700, width: 700,modal: true,containment: false,
                                    buttons: {
                                        "Delete": function () {

                                            $.ajax({

                                                url: '{!!url("/deletesalesorders")!!}',
                                                type: "POST",
                                                data: {
                                                    reference: reference,
                                                },
                                                success: function (data) {
                                                    location.reload();
                                                },

                                            });

                                        }
                                    }
                                });
                            },
                        });

                        }

                });

                }

            });//Update this to get roofing work orders!  

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

    function headersFunction(){
        $.ajax({
            url: '{!!url("/getroofingheaders")!!}',
            type: "GET",
            data: {
                datefrom: $('#datefromheader').val(),
                dateto: $('#datetoheader').val()
            },
            success: function (data) {
                //console.debug(data);
                
                const headergrid = $("#headergrid").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    noDataText: 'No Sales Orders between the date range specified',
                    scrolling: {
                        mode: 'infinite',
                    },
                    paging:{
                        pageSize: 20,
                    },
                    editing:{
                        mode: 'form',
                        // allowUpdating: true,
                        // allowAdding: true,
                        // allowDeleting: true,
                        useIcons: true,
                    },
                    selection: {
                        mode: 'single',
                    },

                    columns: [
                        {
                            dataField: "intRoofingHeader",
                            caption: "ID",
                        }, {
                            dataField: "strReference",
                            caption: "Reference",
                        }, 
                        {
                            dataField: "UserName",
                            caption: "User Name",
                        }, 
                        {
                            dataField: "dateTimeCreated",
                            caption: "Time Created",
                        }, 
                    ],
                    // onSaved(data){
                    //     data = data.changes[0]["key"];
                    //     console.debug(data)
                    //     $.ajax({
                    //         url: '{!!url("/deleteOrder")!!}',
                    //         type: "POST",
                    //         data: {
                    //             ID: data["ID"],
                    //         },
                    //         success: function (data) {
                                
                    //         }
                    //     });
                    // }, //TODO fix this update method

                    onRowClick:function(e){
                        $('#linesgrid').show();
                        var headerID = e.data.intRoofingHeader;
                        batchID = headerID;
                        batchReference = e.data.strReference;
                        var machineslist = ({!! json_encode($machines) !!});

                        console.debug(machineslist);

                        $.ajax({
                            url: '{!!url("/getroofinglines")!!}',
                            type: "GET",
                            data: {
                                ID : headerID,
                            },
                            success: function (data) {
                                // console.debug(data);
                                
                                const linesgrid =  $("#linesgrid").dxDataGrid({
                                    dataSource:data, //as json
                                    showBorders: true,
                                    hoverStateEnabled: true,
                                    filterRow: { visible: true },
                                    filterPanel: { visible: true },
                                    headerFilter: { visible: true },
                                    allowColumnResizing: true,
                                    columnAutoWidth: true,
                                    keyExpr: 'UniqueID',
                                    scrolling: {
                                        mode: 'infinite',
                                    },
                                    rowDragging: {
                                        allowReordering: true,
                                        onReorder(e) {
                                            const visibleRows = e.component.getVisibleRows();
                                            const toIndex = data.findIndex((item) => item.UniqueID === visibleRows[e.toIndex].data.UniqueID);
                                            const fromIndex = data.findIndex((item) => item.UniqueID === e.itemData.UniqueID);

                                            data.splice(fromIndex, 1);
                                            data.splice(toIndex, 0, e.itemData);

                                            e.component.refresh();
                                        },
                                    },
                                    paging:{
                                        pageSize: 20,
                                    },editing: {
                                        mode: 'row',
                                        allowUpdating: true,
                                        // allowAdding: true,
                                        // allowDeleting: true,
                                        useIcons: true,
                                    },
                                    selection: {
                                        mode: 'single',
                                    },

                                    columns: [
                                        
                                        {
                                            dataField: "strReference",
                                            caption: "Reference",
                                            visible: false,
                                            allowEditing : false,
                                        },{
                                            dataField: "UniqueID",
                                            caption: "Unique ID",
                                            allowEditing : false,
                                        },{
                                            dataField: "intRoofingHeader",
                                            caption: "ID",
                                            visible: false,
                                            allowEditing : false,
                                        }, {
                                            dataField: "strSONum",
                                            caption: "SO Number",
                                            allowEditing : false,
                                        },{
                                            dataField: "intOrderLineID",
                                            caption: "Order Line ID",
                                            allowEditing : false,
                                        }, {
                                            dataField: "StoreName",
                                            caption: "Store Name",
                                            allowEditing : false,
                                        }, {
                                            dataField: "Code",
                                            caption: "Code",
                                            visble: false,
                                            allowEditing : false,
                                        }, {
                                            dataField: "ItemName",
                                            caption: "Item Name",
                                            allowEditing : false,
                                        },{
                                            dataField: "intSequence",
                                            caption: "Seq",
                                            // visible: false,
                                            // allowEditing : false,
                                        },
                                        {
                                            dataField: "intMachineId",
                                            caption: "Machine Name",
                                            lookup: {
                                                dataSource: machineslist,
                                                valueExpr: "intAutoMachineID",
                                                displayExpr: "strMachineName",
                                            }
                                        },
                                        {
                                            dataField: "intQty",
                                            caption: "Qty",
                                        },
                                        
                                    ],
                                    onSaved(data){
                                        var orderheader = $("#orderheader").dxDataGrid("instance");
                                        var row = orderheader.getSelectedRowKeys();
                                        //console.debug(data);
                                        var type = data.changes[0]["type"];
                                        data = data.changes[0]["key"];
                                        // console.debug(type);
                                        // console.debug(data);
                                        // $.ajax({
                                        //     url: '{!!url("/updateDeleteOrderLines")!!}',
                                        //     type: "POST",
                                        //     data: {
                                        //         ID: headerID,
                                        //         intDetailId: data["intDetailId"],
                                        //         Price: data["Price"],
                                        //         Quantity: data["Quantity"],
                                        //         comment: data["strComment"],
                                        //         statement: type,
                                        //     },
                                        //     success: function (data) {
                                        //         //location.reload();
                                        //         orderheader.selectRows(row);
                                        //     }
                                        // });
                                    },
                                    
                                });
                            }
                        });
                    },
                });
            }
        });
    };

    function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

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
