<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/20.1.7/css/dx.common.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    

    <!-- Select2 JS -->

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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet">
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

</head>

<body>
    <div class="col-lg-12 bd-highlight"  style="background: white;">
        <div class="col-lg-12 py-2 d-inline-flex">
            {{-- <button type="button" id="printlabels" class="btn btn-secondary mx-1" data-toggle="modal" data-target="#prinlabels">Print Labels</button> --}}

            <button type="button" id="updateSeq" class="btn btn-success mx-1" data-toggle="modal" data-target="#sequencedialog">Update Sequence</button>
            
            <button type="button" id="statuschange" class="btn btn-primary mx-1" data-toggle="modal" data-target="#jobchanges">Change Job Status</button>

            <button type="button" id="printjobcard" class="btn btn-danger mx-1" data-toggle="modal" data-target="#printjobcard">Print Job Card</button>
        </div>
            
        
        <div id="jobgrid" style="width: 100% !important; height:50%; padding-bottom: 10px;">
        </div>

        <div id="exportButton">
        </div>

        <div title="Statuses" id="jobchanges" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="jobchangesTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jobchangesTitle">Change Status</h5>
    
    
                    </div>
                    <div class="modal-body">
    
                        <select class="form-control" id="setstatus">
                            <option></option>
                            <option value="start">Start</option>
                            <option value="hold">Hold</option>
                            <option value="end">End</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn-danger btn-lg" id="savestatus" style="width: 100%;">SAVE</button>
                    </div>
                </div>
            </div>
        </div>

        <div title="Labels" id="additionallabels" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="jobchangesTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jobchangesTitle">Print Additional Labels</h5>
                    </div>
                    <div class="modal-body">
                        <h6 id="JobId">Job ID: </h6>
                        <input id="JobIdVal" value="" hidden>
                        <h6 id="SONum">SO Number: </h6>
                        <input type="number" class="form-control" id="qtytoprint" value="2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn-danger btn-lg" id="printadditional" style="width: 100%;">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>

<style>
    .dx-datagrid-table{
        font-size:15px;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.0/polyfill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.0.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/20.1.7/js/dx.all.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    var salesorder = '';
    var invoiceorder = '';

    $(document).ready(function() {
        $('#savestatus').click(function(){
            $.ajax({
                url: '{!!url("/changeRoofingSOStatus")!!}',
                type: "GET",
                data: {
                    reference: '{!! $reference !!}',
                    machine: '{!! $machine !!}',
                    status:$('#setstatus').val(),
                },
                success: function (data) {
                    if(data[0].Result =="SUCCESS"){
                        location.reload();
                    }else{
                        alert(data[0].Result);
                        location.reload();
                    }
                }
            });
        });

        $('#updateSeq').click(function(){
            var allGridItems =  $("#jobgrid").dxDataGrid("getDataSource").items();
            var checkedLines = new Array();

            var seq = 0;

            allGridItems.forEach((element, index, value) => {
                seq += 1;
                checkedLines.push({
                    'intRoofSOID':element["intRoofSOID"],
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
                    }else{
                        alert(""+data[0].Result);
                    }
                }
            });

        });

        $('#printjobcard').click(function(){
            //TODO Got to new roofing jobcard for reference and machine (See 'savestatus' above for reference and machine!)
        });

        $('#printadditional').click(function(){
            $.ajax({
                url: '{!!url("/printAdditionalRoofingLabels")!!}',
                type: "GET",
                data: {
                    JobId: $('#JobIdVal').val(),
                    qty: $('#qtytoprint').val(),
                },
                success: function (data) {
                    if(data[0].Result =="SUCCESS"){
                        location.reload();
                    }else{
                        alert(data[0].Result);
                        location.reload();
                    }
                }
            });
        });

        var reference = '{!! $reference !!}';
        var machine = '{!! $machine !!}';

        $.ajax({
            url: '{!!url("/getRoofingSOtoUpdate")!!}',
            type: "GET",
            data: {
                reference: reference,
                machine: machine
            },
            success: function (data) {
                //console.debug(data);

                $("#jobgrid").dxDataGrid({
                    dataSource: data, //as json
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
                    selection: {
                        mode: 'multiple',
                    },
                    rowDragging: {
                        allowReordering: true,
                        showDragIcons: false,
                        onReorder(e) {
                            const visibleRows = e.component.getVisibleRows();
                            const toIndex = data.findIndex((item) => item.intRoofSOID === visibleRows[e.toIndex].data.intRoofSOID);
                            const fromIndex = data.findIndex((item) => item.intRoofSOID === e.itemData.intRoofSOID);

                            data.splice(fromIndex, 1);
                            data.splice(toIndex, 0, e.itemData);

                            e.component.refresh();
                        },
                    },
                    
                    export: {
                        formats: ['xlsx', 'pdf', 'csv'],
                        enabled: true,
                        allowExportSelectedData: true,
                    },
                    onExporting(e) {
                        const workbook = new ExcelJS.Workbook();
                        const worksheet = workbook.addWorksheet('Employees');

                        if (e.format === 'xlsx') {
                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                                selectedRowsOnly: false
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], {
                                        type: 'application/octet-stream'
                                    }), 'Employees.xlsx');
                                });
                            });
                            e.cancel = true;
                        }

                        if (e.format === 'pdf') {
                            window.jsPDF = window.jspdf.jsPDF;

                            const doc = new jsPDF();
                            DevExpress.pdfExporter.exportDataGrid({
                                jsPDFDocument: doc,
                                component: e.component,

                            }).then(() => {
                                doc.save('Companies.pdf');
                            });
                        }

                        if (e.format === 'csv') {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('Employees');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet: worksheet
                            }).then(function() {
                                // https://github.com/exceljs/exceljs#writing-csv
                                // https://github.com/exceljs/exceljs#reading-csv
                                workbook.csv.writeBuffer().then(function(buffer) {
                                    saveAs(new Blob([buffer], {
                                        type: "application/octet-stream"
                                    }), "Employees.csv");
                                });
                            });
                        }
                    },

                    columns: [
                        {
                            dataField: "intRoofSOID",
                            caption: 'ID', 
                            // visible: false,
                        },
                        {
                            dataField: "intOrderLineId",
                            caption: 'Order Line ID', 
                            visible: false,
                        },
                        {
                            dataField: "strSONum",
                            caption: 'SO Number', 
                            // visible: false,
                        },{
                            dataField: "intSequence",
                            caption: 'Seq', 
                            // visible: false,
                        },
                        {
                            dataField: "strCustomerCode",
                            caption: "Customer Code",
                            //width: 300,
                        },
                        {
                            dataField: "strCustomerName",
                            caption: "Customer",
                            //width: 80,
                        },{
                            dataField: "strRawMaterial",
                            caption: "Raw Material",
                            //width: 600,
                        },
                        {
                            dataField: "strProductCode",
                            caption: "Product Code",
                            //width: 600,
                        },{
                            dataField: "strDescription",
                            caption: "Product Description",
                            //width: 600,
                        },{
                            dataField: "intQty",
                            caption: "Qty Planned",
                            //width: 600,
                        },{
                            dataField: "dtmCreated",
                            caption: "Created",
                            //width: 600,
                        },
                        ,{
                            dataField: "dtmJobStarted",
                            caption: "Start Date",
                            //width: 600,
                        },
                        ,{
                            dataField: "dtmJobEnded",
                            caption: "End Date",
                            //width: 600,
                        },{
                            dataField: "strJobStatus",
                            caption: "Status",
                            //width: 600,
                        },
                    ],

                    onRowDblClick:function(e){
                        salesorder = e.data.strSONum;
                        invoiceorder = e.data.intOrderLineId;
                        ID = e.data.intRoofSOID;

                        $('#JobId').text('Job ID: '+ID);
                        $('#JobIdVal').val(ID);
                        $('#SONum').text('SO Number: '+salesorder);
                        $('#additionallabels').modal('toggle');
                        
                    }

                }).dxDataGrid('instance');
            }
        });

    

    });

    $(function(){
        $('#exportButton').dxButton({
            onClick: function() {
                const doc = new jsPDF();
                DevExpress.pdfExporter.exportDataGrid({
                    jsPDFDocument: doc,
                    component: dataGrid
                }).then(function() {
                    doc.save('Customers.pdf');
                });
            }
        });
        const dataGrid = $('#jobgrid').dxDataGrid('instance');
    });

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