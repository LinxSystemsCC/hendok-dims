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
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="PPSOTab" aria-current="page">Pre Plan SO's</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="BSOPTab">Batch SO Processing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="BSTab" >Batch Progression</a>
            </li>
        </ul>
        
        <div class="tab-content p-3">
            {{-- Pre Planned Sales Orders Page --}}
            <div class="tab-pane fade show active" id="PPSOPage" role="tabpanel">

                <div class="modal-header">
                    <h5 class="modal-title" id="preplanningsoTitle">Pre Planning SO</h5>
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

                    <button class="btn-danger btn-lg" id="savePPSO" style="width: 100%;">SAVE</button>

                </div>

                
            </div>

            {{--  Batch Sales Order Processing Page --}}
            <div class="tab-pane fade" id="BSOPPage" role="tabpanel">
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

                <div id="linesgrid" class="py-3" style="width: 100% !important; height:50%;">
                    
                </div>

                <button type="button" class="btn btn-success" id="saveBSOP" aria-label="Save">Save</button>

            </div>

            {{--  Batch Sequencing Page --}}
            <div class="tab-pane fade" id="BSPage" role="tabpanel">
                
                {{-- <div class="form-group">
                    <label class="control-label" for="machine"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Machine</label>
                    <select  class="form-control input-sm col-xs-1" id="machine" required>
                        <option></option>
                        @foreach($machines as $val)
                            <option value="{{$val->intAutoMachineID}}">{{$val->strMachineName}}</option>
                        @endforeach

                    </select>
                </div> --}}

                <div id="sequencegrid" style="width: 50% !important; height:50%; padding-bottom: 10px;">
                </div>

                {{-- <button type="button" class="btn btn-success" id="updateBS" aria-label="Save">Update Sequence</button> --}}
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
        var date = (new Date()).toISOString().slice(0, 10);
		$('#datefrom').val(date);
		$('#dateto').val(date);
        $('#datefromheader').val(date);
		$('#datetoheader').val(date);

        if (localStorage.getItem("PPSO") == 'active') {
            localStorage.setItem('PPSO', 'done');
            $('#PPSOPage').addClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').addClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').removeClass("active");
        }

        if (localStorage.getItem("BSOP") == 'active') {
            localStorage.setItem('BSOP', 'done');
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').addClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').addClass("active");
            $('#BSTab').removeClass("active");
        }

        if (localStorage.getItem("BS") == 'active') {
            localStorage.setItem('BS', 'done');
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').addClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').addClass("active");
        }
        
        // localStorage.setItem('PPSO', '');
        // localStorage.setItem('PPSO', '');
        // localStorage.setItem('PPSO', '');
        
        $.ajax({
            url: '{!!url("/getRoofWIP")!!}',
            type: "GET",
            data: {
            },
            success: function (data) {

                $("#sequencegrid").dxDataGrid({
                    dataSource:data, //as json
                    showBorders: true,
                    hoverStateEnabled: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    // rowDragging: {
                    //     allowReordering: true,
                    //     showDragIcons: false,
                    //     onReorder(e) {
                    //         const visibleRows = e.component.getVisibleRows();
                    //         const toIndex = data.findIndex((item) => item.UniqueId === visibleRows[e.toIndex].data.UniqueId);
                    //         const fromIndex = data.findIndex((item) => item.UniqueId === e.itemData.UniqueId);

                    //         data.splice(fromIndex, 1);
                    //         data.splice(toIndex, 0, e.itemData);

                    //         e.component.refresh();
                    //     },
                    // },
                    paging:{
                        pageSize: 20,
                    },
                    selection: {
                        mode: 'single',
                    },

                    columns: [
                        {
                            dataField: "UniqueId",
                            caption: 'ID', 
                            visible: false,
                        },
                        {
                            dataField: "strReference",
                            caption: "Reference",
                            //width: 80,
                        },
                        {
                            dataField: "strMachineName",
                            caption: "Machine",
                            //width: 300,

                        }
                    ],

                    
                    onRowDblClick:function(e){
                        //console.log(e.data.intJobId);
                        var strReference =  e.data.strReference;
                        var strMachineName = e.data.strMachineName;

                        window.open('{!!url("/roofingSOUpdate")!!}/'+strReference+'/'+strMachineName,"_blank", "location=1,status=1,scrollbars=1, width=1200,height=850");

                    }

                }).dxDataGrid('instance');
            }

        });

        headersFunction();
        
        $('#getheaders').click(function(){
            headersFunction();
        });

        $('#PPSOTab').click(function(){
            $('#PPSOPage').addClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').addClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').removeClass("active");
        });

        $('#BSOPTab').click(function(){
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').addClass("show active");
            $('#BSPage').removeClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').addClass("active");
            $('#BSTab').removeClass("active");
        });

        $('#BSTab').click(function(){
            $('#PPSOPage').removeClass("show active");
            $('#BSOPPage').removeClass("show active");
            $('#BSPage').addClass("show active");

            $('#PPSOTab').removeClass("active");
            $('#BSOPTab').removeClass("active");
            $('#BSTab').addClass("active");
        });


        $('#savePPSO').click(function(){
            if (($("#reference").val()).length < 1)
                alert("The Reference needs to be inserted");
            else{
                const salorders = $("#salesorders").val();
                const invorders = $("#invoiceorders").val();
                const comp = $("#company").val();

                var salesorders = salorders.split("\n");
                var invoiceorders = invorders.split("\n");
                var company = comp.split("\n");
                
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
                            localStorage.setItem('PPSO', 'active');
                        }else{
                            alert(""+data[0].Result);
                        }
                    }
                });
            }
                
        });

        $('#saveBSOP').click(function(){
            var allGridItems =  $("#linesgrid").dxDataGrid("getDataSource").items();
            var checkedLines = new Array();

            allGridItems.forEach((element, index, value) => {
                checkedLines.push({
                    'UniqueID': element["UniqueID"],
                    'strSONum': element["strSONum"],
                    'intAutoMachineID':element["intMachineId"],
                    'ProdName': escapeHtml(element["Code"]),
                    'intQty':element["intQty"],
                    'Dept': 'Roofing',
                    'strReference': element["strReference"],
                    'intOrderLineID': element["intOrderLineID"],
                });
            });

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
                        location.reload();
                        localStorage.setItem('BSOP', 'active');
                    }else{
                        alert(""+data[0].Result);
                    }
                }
            });

        });

        $('#updateBS').click(function(){
            var allGridItems =  $("#sequencegrid").dxDataGrid("getDataSource").items();
            var checkedLines = new Array();

            var seq = 0;

            allGridItems.forEach((element, index, value) => {
                seq += 1;
                checkedLines.push({
                    'strReference':element["strReference"],
                    'strMachineName':element["strMachineName"],
                    'jobSeq' : seq,
                });
            });

            // console.debug(checkedLines);

            $.ajax({
                url: '{!!url("/updateRoofLinesSequence")!!}',
                type: "POST",
                data: {
                    workOrders: checkedLines,
                },
                success: function (data) {
                    if(data[0].Result == "Success"){
                        location.reload();
                        localStorage.setItem('BS', 'active');
                    }else{
                        alert(""+data[0].Result);
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

                    onRowClick:function(e){
                        $('#linesgrid').show();
                        var headerID = e.data.intRoofingHeader;
                        batchID = headerID;
                        batchReference = e.data.strReference;
                        var machineslist = ({!! json_encode($machines) !!});

                        //console.debug(machineslist);

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
                                    editing: {
                                        mode: 'batch',
                                        allowUpdating: true,
                                        // allowAdding: true,
                                        // allowDeleting: true,
                                        useIcons: true,
                                    },
                                    selection: {
                                        mode: 'single',
                                    },
                                    paging: {
                                        enabled: false
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
                                    },
                                    
                                });
                            }
                        });
                    },
                });
            }
        });
    };

    //TODO remove ended sales orders from the Batch Processing List

    function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function showDialog(tag,width,height){
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
