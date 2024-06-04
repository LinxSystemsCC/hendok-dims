@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Diamond Mesh Work Orders')

@php
    $includeMenu = false;
@endphp

@section('page')
    <div class="col-lg-12 bd-highlight" style="background: white;">
        <div class="col-lg-12 py-2 d-inline-flex">
            <button type="button" id="updateSeq" class="btn btn-success mx-1">Update Sequence</button>

            <button type="button" id="statuschange" class="btn btn-primary mx-1" data-bs-toggle="modal"
                data-bs-target="#jobchanges">Change Job Status</button>

            <button type="button" id="printjobcard" class="btn btn-danger mx-1">Print Job Card</button>
        </div>

        <div id="gridJobs" style="width: 100% !important; height:50%; padding-bottom: 10px;">
        </div>

        <div title="Statuses" id="jobchanges" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="jobchangesTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jobchangesTitle">Change Status</h5>


                    </div>
                    <div class="modal-body">

                        <select class="form-select" id="setstatus">
                            <option></option>
                            <option value="start">Start</option>
                            <option value="hold">Hold</option>
                            <option value="end">End</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-danger" id="savestatus">SAVE</button>
                    </div>
                </div>
            </div>
        </div>

        <div title="Labels" id="additionallabels" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="jobchangesTitle" aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary" style="width:48%;"
                            data-dismiss="modal">Close</button>
                        <button class="btn btn-danger" style="width:48%;" id="printadditional">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        var salesorder = '';
        var invoiceorder = '';

        $(document).ready(function() {

            var reference = '{!! $reference !!}';
            var machine = '{!! $machine !!}';

            $('#updateSeq').click(function() {
                var allGridItems = $("#gridJobs").dxDataGrid("getDataSource").items();
                var checkedLines = new Array();

                var seq = 0;

                allGridItems.forEach((element, index, value) => {
                    seq += 1;
                    checkedLines.push({
                        'intDiamondMeshSOID': element["intDiamondMeshSOID"],
                        'jobSeq': seq,
                    });
                });

                // console.debug(checkedLines);

                $.ajax({
                    url: '{!! url('/updateDiamondMeshLinesSequence') !!}',
                    type: "POST",
                    data: {
                        workOrders: checkedLines,
                    },
                    success: function(data) {
                        if (data[0].Result == "Success") {
                            location.reload();
                        } else {
                            alert("" + data[0].Result);
                        }
                    }
                });

            });

            $('#printadditional').click(function() {
                $.ajax({
                    url: '{!! url('/printAdditionalDiamondMeshLabels') !!}',
                    type: "GET",
                    data: {
                        JobId: $('#JobIdVal').val(),
                        qty: $('#qtytoprint').val(),
                    },
                    success: function(data) {
                        if (data[0].Result == "SUCCESS") {
                            location.reload();
                        } else {
                            alert(data[0].Result);
                            location.reload();
                        }
                    }
                });
            });

            $('#printjobcard').click(function() {
                const datagrid = $('#gridJobs').dxDataGrid('instance');

                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Areas');

                DevExpress.excelExporter.exportDataGrid({
                    component: datagrid,
                    worksheet,
                    autoFilterEnabled: true,
                }).then(() => {
                    workbook.xlsx.writeBuffer().then((buffer) => {
                        saveAs(new Blob([buffer], {
                            type: 'application/octet-stream'
                        }), '' + reference + '.xlsx');
                    });
                });
            });

            let gridData = [];

            const gridJobs = $("#gridJobs").dxDataGrid({
                dataSource: gridData,
                showBorders: true,
                keyExpr: 'intSequence',
                hoverStateEnabled: true,
                filterRow: {
                    visible: true
                },
                filterPanel: {
                    visible: true
                },
                headerFilter: {
                    visible: true
                },
                allowColumnResizing: true,
                columnAutoWidth: true,
                paging: {
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
                        const toIndex = gridData.findIndex((item) => item.intSequence === visibleRows[e.toIndex].data.intSequence);
                        const fromIndex = gridData.findIndex((item) => item.intSequence === e.itemData.intSequence);

                        gridData.splice(fromIndex, 1);
                        gridData.splice(toIndex, 0, e.itemData);

                        // Update sequence numbers
                        gridData.forEach((item, index) => {
                            if (index !== 0 && index !== gridData.length - 1) {
                                item.sequence = index;
                            }
                        });

                        e.component.refresh();
                    },
                },
                columns: [{
                        dataField: "strJobStatus",
                        caption: "Status",
                        //width: 600,
                    }, {
                        dataField: "productionstat",
                        caption: "Completed",
                        //width: 600,
                    },
                    {
                        dataField: "intDiamondMeshSOID",
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
                    }, {
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
                    }, {
                        dataField: "strRawMaterial",
                        caption: "Raw Material",
                        //width: 600,
                    },
                    {
                        dataField: "strProductCode",
                        caption: "Product Code",
                        //width: 600,
                    }, {
                        dataField: "strDescription",
                        caption: "Product Description",
                        //width: 600,
                    }, {
                        dataField: "intQty",
                        caption: "Qty Planned",
                        dataType: 'number',
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    }, {
                        dataField: "fltWeight",
                        caption: "Weight Planned",
                        dataType: 'number',
                        format: {
                            type: "fixedPoint",
                            precision: 2
                        }
                    }, {
                        dataField: "dtmCreated",
                        caption: "Created",
                        //width: 600,
                    }, , {
                        dataField: "dtmJobStarted",
                        caption: "Start Date",
                        //width: 600,
                    }, , {
                        dataField: "dtmJobEnded",
                        caption: "End Date",
                        //width: 600,
                    }
                ],

                onRowDblClick: function(e) {
                    salesorder = e.data.strSONum;
                    invoiceorder = e.data.intOrderLineId;
                    ID = e.data.intDiamondMeshSOID;

                    $('#JobId').text('Job ID: ' + ID);
                    $('#JobIdVal').val(ID);
                    $('#SONum').text('SO Number: ' + salesorder);
                    $('#additionallabels').modal('toggle');

                }

            }).dxDataGrid("instance");

            $.ajax({
                url: '{!! url('/getDiamondMeshLinesByReference') !!}',
                type: "GET",
                data: {
                    reference: reference,
                    machine: machine
                },
                success: function(data) {
                    // console.log(data);
                    gridJobs.option('dataSource', data);
                    gridJobs.refresh();

                    gridData = gridJobs.option("dataSource");
                }
            });

            $('#savestatus').click(function() {
                var lines = ''; // Initialize lines variable
                var selectedRows = gridJobs.getSelectedRowsData();
                var rowsToProcess = selectedRows;

                if (selectedRows.length == 0) {
                    // If no rows are selected, get all rows from the datasource
                    rowsToProcess = gridJobs.getDataSource().items();
                }

                if (rowsToProcess.length > 0) {
                    rowsToProcess.forEach(function(row) {
                        var strSONum = row.strSONum;
                        var intOrderLineId = row.intOrderLineId;
                        // console.log("SO Number: " + strSONum + ", Order Line ID: " + intOrderLineId);
                        $.ajax({
                            url: '{!! url('/changeDiamondMeshJobStatus') !!}',
                            type: "GET",
                            data: {
                                reference: '{!! $reference !!}',
                                machine: '{!! $machine !!}',
                                SONumber: strSONum,
                                InvNumber: intOrderLineId,
                                status: $('#setstatus').val(),
                            },
                            success: function(data) {
                                location.reload();
                            },
                        });
                    });
                }

            });

        });
    </script>

@endsection
