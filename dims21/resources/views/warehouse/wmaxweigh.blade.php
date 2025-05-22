@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Galv Weigh')



{{-- Set to show navbar --}}
@php
    if (Auth::guest()) {
    } else {
        $v = new \App\Http\Controllers\SalesForm();
        // $permission = $v->getThingsUserPermissions(Auth::user()->UserID,'Permission');
    }

    $includeMenu = true;

@endphp

@section('page')

    <style>
        #gridWeigh {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <div id="gridWeigh"></div>

    <div class="modal modal-lg fade" id="modalAcceptHold" aria-labelledby="modalAcceptHold" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weighTestTitle">Set Weight</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="CloseModal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="jobnum"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Job
                                No</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="jobnum"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="seqnum"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">
                                Seq No
                            </label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="seqnum"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="custnum"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Customer
                                No</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="custnum"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="dept"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Department</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="dept"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="ref"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Reference</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="ref"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="machine"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Machine</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="machine"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="prod"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Product</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="prod"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="zinc"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Zinc</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="zinc"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="tensile"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Tensile
                                Ticket</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="tensile"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="mpa"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">MPA</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="mpa"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="wire"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Actual
                                Wire Size</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="wire"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="control-label" for="cast"
                                style="margin-bottom: 0px;font-weight: 400;font-size: 15px; white-space: nowrap;">Cast
                                No</label>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="control-label" id="cast"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px; white-space: nowrap;"></label>
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="control-label" for="tare"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Tare Mass</label>
                        </div>
                        <div class="col-md-9 mb-1">
                            <select class="form-select" id="tare" required>
                                <option>
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="control-label" for="mass"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Mass</label>
                        </div>
                        <div class="d-inline-flex col-md-9 mb-1">
                            <div class="col-7 pe-0">
                                <select class="form-select rounded-0 rounded-start" id="scales">
                                    <option></option>
                                    @foreach ($scales as $scales)
                                        <option value="{{ $scales->intAutoId }}">{{ $scales->strName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 px-0">
                                <input type="number" class="form-control rounded-0" id="mass" required disabled>
                            </div>
                            <div class="col-1 ps-0">
                                <button class="btn btn-secondary rounded-0 rounded-end w-100" id="btnEditMass"><i
                                        class="fa fa-edit p-0"></i></button>
                                <button class="btn btn-success rounded-0 rounded-end w-100" id="btnToggleMeasureMass"
                                    hidden><i class="fa fa-play p-0"></i></button>
                            </div>
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="control-label" for="final"
                                style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Final Mass</label>
                        </div>
                        <div class="col-md-9 mb-1">
                            <input type="number" class="form-control input-sm col-xs-1" id="final" required
                                disabled>
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

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $("#mass").on("change", function() {
                const tare = parseFloat($('#tare').val()) || 0;
                const mass = parseFloat($("#mass").val()) || 0;
                const finalweight = mass - tare;

                $('#final').val(finalweight);
            });

            $("#scales").change(function() {
                // console.log($("#scales").val() );
                if ($("#scales").val() == '') {
                    $('#update').prop('disabled', false);
                } else {
                    $('#update').prop('disabled', true);
                    $('#mass').prop('disabled', true);
                }
                fetchWeight();
            });

            $("#update").click(function() {
                $('#mass').prop('disabled', function(_, disabled) {
                    return !disabled;
                });
                $('#scales').prop('disabled', function(_, disabled) {
                    return !disabled;
                });
            });

            let btnUndo;
            let currentSelectedRow = [];

            let isRunning = false;
            let Interval = null;

            const gridWeigh = $("#gridWeigh").dxDataGrid({
                dataSource: [], // as json
                hoverStateEnabled: true,
                showBorders: true,
                key: "JobNo",
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
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging: {
                    enabled: false
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
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'weigh.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columns: [{
                        dataField: "DateTime",
                        caption: "Date"
                    },
                    {
                        dataField: "DepartmentName",
                        caption: "Department"
                    },
                    {
                        dataField: "MachineName",
                        caption: "Machine"
                    },
                    {
                        dataField: "CustomerName",
                        caption: "Customer"
                    },
                    {
                        dataField: "ProductName",
                        caption: "Product"
                    },
                    {
                        dataField: "Reference",
                        caption: "Reference"
                    },
                    {
                        dataField: "JobNo",
                        caption: "Job Number"
                    },
                    {
                        dataField: "SeqNo",
                        caption: "Seq No"
                    },
                    {
                        dataField: "TensileTicket",
                        caption: "Tensile Ticket"
                    },
                    {
                        dataField: "Zinc",
                        caption: "Zinc"
                    },
                    {
                        dataField: "WireSize",
                        caption: "Wire Size"
                    },
                    {
                        dataField: "MPA",
                        caption: "MPA"
                    },
                ],
                onRowDblClick: function(e) {
                    $('#modalAcceptHold').modal('toggle');
                    var dataGrid = $("#gridWeigh").dxDataGrid("instance");
                    var selectedRowsData = dataGrid.getSelectedRowsData();

                    $("#accept").prop('disabled', true);
                    $("#hold").prop('disabled', true);

                    var passfailed = selectedRowsData[0].PassedFailed;

                    if (passfailed == 'P') {
                        $("#accept").prop('disabled', false);
                        $("#hold").prop('disabled', true);
                    }
                    if (passfailed == 'F') {
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
                    $('#zinc').text(zinc);
                    $('#tensile').text(tensile);
                    $('#mpa').text(mpa);
                    $('#wire').text(wire);
                    $('#cast').text(castno);
                },
                onToolbarPreparing: function(e) {
                    // Create a custom header on the left side
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('WEIGH');
                        }
                    });

                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "undo",
                            text: "Undo",
                            onInitialized: function(e) {
                                btnUndo = e.component;
                            },
                            onClick: function(args) {
                                undoLastGalvWeigh();
                            },
                        },
                    });
                },
            }).dxDataGrid('instance');

            getWeighData();

            $.ajax({
                url: '{!! url('/getTare') !!}',
                type: "GET",
                data: {

                },
                success: function(data) {
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

            $('#accept').click(function() {
                $(this).prop("disabled", true);
                var dataGrid = $("#gridWeigh").dxDataGrid("instance");
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

                    url: '{!! url('/acceptholdweigh') !!}',
                    type: "POST",
                    data: {
                        ref: ref,
                        custnum: custnum,
                        prod: prod,
                        dept: dept,
                        machine: machine,
                        jobnum: jobnum,
                        zinc: zinc,
                        mpa: mpa,
                        castno: castno,
                        wire: wire,
                        sequm: sequm,
                        tensile: tensile,
                        netmass: $('#final').val(),
                        GrossMass: $("#mass").val(),
                        taremass: $('#tare option:selected').val(),
                        buttonMethod: 'ACCEPT',
                    },
                    success: function(data) {
                        if (data[0].Result = "Success") {
                            var customer = data[0].CustomerName;
                            var product = data[0].ProductName;
                            var ticket = data[0].TicketNo;

                            // window.open('{!! url('/getgalvlabel') !!}/' +customer+'/'+product+'/'+ticket +'/Accept', "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");
                            window.open('{!! url('/printGalvLabel') !!}/' + ticket, "_blank",
                                "location=1,status=1,scrollbars=1, width=1200,height=850");

                            $('#modalAcceptHold').modal('hide');
                            getWeighData();

                        }

                    }

                });


            });

            $('#hold').click(function() {
                $(this).prop("disabled", true);
                var dataGrid = $("#gridWeigh").dxDataGrid("instance");
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

                    url: '{!! url('/acceptholdweigh') !!}',
                    type: "POST",
                    data: {
                        ref: ref,
                        custnum: custnum,
                        prod: prod,
                        dept: dept,
                        machine: machine,
                        jobnum: jobnum,
                        zinc: zinc,
                        mpa: mpa,
                        castno: castno,
                        wire: wire,
                        sequm: sequm,
                        tensile: tensile,
                        netmass: $('#final').val(),
                        GrossMass: $("#mass").val(),
                        taremass: $('#tare option:selected').val(),
                        buttonMethod: 'HOLD',
                    },
                    success: function(data) {
                        if (data[0].Result = "Success") {
                            var customer = data[0].CustomerName;
                            var product = data[0].ProductName;
                            var ticket = data[0].TicketNo;

                            // window.open('{!! url('/getgalvlabel') !!}/' +customer+'/'+product+'/'+ticket +'/Hold', "GalvLabel" +customer, "location=1,status=1,scrollbars=1, width=1200,height=850");
                            window.open('{!! url('/printGalvLabel') !!}/' + ticket, "_blank",
                                "location=1,status=1,scrollbars=1, width=1200,height=850");

                            $('#modalAcceptHold').modal('hide');
                            getWeighData();

                        }
                    }
                });
            });

            $("#scales").change(function() {
                const scaleValue = $("#scales").val();

                if (scaleValue === '') {
                    $('#btnEditMass').prop('hidden', false);
                    $('#btnToggleMeasureMass').prop('hidden', true);
                } else {
                    $('#btnEditMass').prop('hidden', true);
                    $('#btnToggleMeasureMass').prop('hidden', false);
                }
            });

            $('#btnToggleMeasureMass').click(function() {
                Interval = toggleFetchWeight('#btnToggleMeasureMass', '#scales', isRunning, Interval,'#mass');
                isRunning = !isRunning;
            });



            $('#btnEditMass').click(function() {
                $('#mass').prop("disabled", function(_, value) {
                    return !value;
                });
                $('#scales').prop("disabled", function(_, value) {
                    return !value;
                });
                $('#mass').val("");
                $('#scales').val("");
            });

            function getWeighData() {
                gridWeigh.beginCustomLoading();
                $.ajax({
                    url: '{!! url('/getweigh') !!}',
                    type: "GET",
                    data: {},
                    success: function(data) {
                        gridWeigh.option('dataSource', data);
                        gridWeigh.refresh();

                        gridData = gridWeigh.option("dataSource");
                        gridWeigh.endCustomLoading();
                    }
                });
            };

            doacheck();

            function doacheck() {
                setInterval(checkforchanges, 10000);
            };

            function checkforchanges() {
                $.ajax({
                    url: '{!! url('/checkForGalvUpdates') !!}',
                    type: "GET",
                    data: {
                        checker: "WEIGH",
                    },
                    success: function(data) {
                        // console.log(data[0].Result);
                        if (data[0].Result == "Reload") {
                            console.log("deleting record and reloading");
                            //runs store procedure to delete the record
                            $.ajax({
                                url: '{!! url('/deleteGalvChecker') !!}',
                                type: "GET",
                                data: {
                                    checker: "WEIGH",
                                },
                                success: function(data) {
                                    getWeighData();
                                }
                            });
                        }
                    }
                });
            };

            function toggleFetchWeight(button, scaleSelect, isRunning, intervalRef, inputId) {
                const scaleValue = $(scaleSelect).val();

                if (isRunning) {
                    $(button + ' i').removeClass('fa-stop').addClass('fa-play');
                    $(button).removeClass('btn-danger').addClass('btn-success');
                    clearInterval(intervalRef);
                    return null;
                } else {
                    $(button + ' i').removeClass('fa-play').addClass('fa-stop');
                    $(button).removeClass('btn-success').addClass('btn-danger');
                    fetchWeight(scaleValue, inputId);
                    return setInterval(() => fetchWeight(scaleValue, inputId), 2500);
                }
            }

            function fetchWeight(scales, inputId) {
                $.ajax({
                    url: '{!! url('/listenToScale') !!}',
                    type: "GET",
                    data: {
                        scaleID: scales,
                    },
                    success: function(data) {
                        if (data) {
                            $(inputId).val(data);
                        } else {
                            $(inputId).val(0);
                        }
                    }
                });
            }

            function undoLastGalvWeigh() {
                gridWeigh.beginCustomLoading();
                $.ajax({
                    url: '{!! url('/undoLastGalvWeigh') !!}',
                    type: "POST",
                    data: {
                    },
                    success: function(data) {
                        gridWeigh.endCustomLoading();
                        getWeighData();
                    }
                });
            }
        });
    </script>

@endsection
