@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'QC Phase')



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
        #gridQcPhase1 {
            height: calc(100vh - 2rem);
            max-height: calc(100vh - 2rem);
        }
    </style>

    <div id="gridQcPhase1"></div>

    <!-- Modal New Item -->
    <div class="modal modal-lg fade" id="modalPassOrFail" aria-labelledby="modalPassOrFail" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="qc1TestTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="CloseModal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="initmass">Initial Mass</label>
                            <input type="number" class="form-control" id="initmass" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="stripmass">Strip Mass</label>
                            <input type="number" class="form-control" id="stripmass" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="stripsize">Strip Size</label>
                            <input type="number" class="form-control" id="stripsize" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="zinc">Zinc</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-primary px-4" id="calczinc">
                                        Calculate
                                    </button>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" id="zinc" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="mpa">MPA Tested</label>
                            <input type="number" class="form-control" id="mpa" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="wiresize">Wire Size</label>
                            <input type="number" class="form-control" id="wiresize" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="stresstest">1 % Stress Test</label>
                            <input type="number" class="form-control" id="stresstest" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="elongation">Elongation at Break %</label>
                            <input type="number" class="form-control" id="elongation" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="torsion">Torsion Test</label>
                            <input type="number" class="form-control" id="torsion" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="wraptest">1 Diameter Wrap Test</label>
                            <input type="number" class="form-control" id="wraptest" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="coating">Coating Uniformity</label>

                            <select class="form-control" id="coating" required>
                                <option>
                                    PASS
                                </option>

                                <option>
                                    FAIL
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="CastNo">Cast Number</label>
                            <input type="text" class="form-control" id="CastNo" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="test">Test Number</label>
                            <input type="number" class="form-control" id="test" required disabled>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="col-form-label" for="comment1">Comment</label>
                            <select class="form-control" id="comment1" required>
                                <option>
                                </option>
                            </select>
                            <br>
                            <select class="form-control" id="comment2" required>
                                <option>
                                </option>
                            </select>
                            <br>
                            <select class="form-control" id="comment3" required>
                                <option>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="d-inline-flex gap-2">
                        <button class="btn btn-success" id="testpass">PASS</button>
                        <button class="btn btn-danger" id="testfail">FAIL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {

            $('#zinc').prop("disabled", true);

            $("#wiresize").change(function() {
                $(this).val(parseFloat($(this).val()).toFixed(2));
            });

            $('#wiresize').on('input', function() {
                // console.log($('#wiresize').val());
                var inputValue = $(this).val();

                if (inputValue.length > 4) {
                    $(this).val(inputValue.slice(0, 4)); // Truncate the input to four characters
                }
            });

            $('#mpa').on('input', function() {
                var inputValue = $(this).val();

                if (inputValue.length > 4) {
                    $(this).val(inputValue.slice(0, 4)); // Truncate the input to four characters
                }
            });

            // Clear inputs and selects within the modal
            $("#modalPassOrFail").on("hidden.bs.modal", function() {
                $("#modalPassOrFail input, #modalPassOrFail select").val("");
            });

            $.ajax({
                url: '{{ route('wire-draw.qcscreen.get-qcscreen') }}',
                type: "GET",
                success: function(data) {
                    console.log("Data received:", data);

                    const gridData = data.headers.map(header => ({
                        ...header,
                        strCustomerName: data.customerName[0].strCustomerName,
                        strProductName: data.productName[0].strProductName,
                        strMachineName: data.machine[0].strMachineName
                    }));

                    console.log("Mapped Data for Grid:", gridData);

                    const gridWorkInProgress = $("#gridQcPhase1").dxDataGrid({
                        dataSource: gridData,
                        hoverStateEnabled: true,
                        showBorders: true,
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
                            const worksheet = workbook.addWorksheet('qc1');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], {
                                        type: 'application/octet-stream'
                                    }), 'qc1.xlsx');
                                });
                            });
                            e.cancel = true;
                        },
                        columns: [{
                                dataField: "intHeaderId",
                                caption: "Job No"
                            },
                            {
                                dataField: "strReference",
                                caption: "Reference"
                            },
                            {
                                dataField: "strCustomerName",
                                caption: "Customer Name"
                            },
                            {
                                dataField: "strProductName",
                                caption: "Product"
                            },
                            {
                                dataField: "dtDateStart",
                                caption: "Date Start"
                            },
                            {
                                dataField: "dtDateEnd",
                                caption: "Date End"
                            },
                            {
                                dataField: "strMachineName",
                                caption: "Machine"
                            },
                            {
                                dataField: "stand",
                                caption: "Stand #"
                            }
                        ],
                        onRowDblClick: function(e) {
                            $('#modalPassOrFail').modal('toggle');
                            var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
                            var selectedRowsData = dataGrid.getSelectedRowsData();
                            if (selectedRowsData.length > 0) {
                                var dept = selectedRowsData[0].DepartmentName;
                                var mach = selectedRowsData[0].MachineName;
                                var title = dept + ", " + mach;
                                var testNo = selectedRowsData[0].TestNo;

                                $('#qc1TestTitle').text(title);
                                $('#test').val(testNo);
                            }
                        },
                        onToolbarPreparing: function(e) {
                            e.toolbarOptions.items.unshift({
                                location: 'before',
                                template: function() {
                                    return $('<h3>').text('QC PHASE 1');
                                }
                            });
                        },

                    }).dxDataGrid('instance');
                }
            });

            // Update Comments Lists
            $.ajax({

                url: '{!! url('/getqc1comments') !!}',
                type: "GET",
                data: {


                },
                success: function(data) {
                    var toAppend = '';
                    $("#comment1").empty();
                    $("#comment2").empty();
                    $("#comment3").empty();
                    toAppend += '<option></option>';
                    $.each(data, function(i, o) {

                        toAppend += '<option value="' + o.RemarkID + '">' + o.Remark +
                            '</option>';
                    });
                    $("#comment1").append(toAppend);
                    $("#comment2").append(toAppend);
                    $("#comment3").append(toAppend);

                },
            });

            $('#testpass').click(function() {
                $(this).prop("disabled", true);
                var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
                var selectedRowsData = dataGrid.getSelectedRowsData();

                $.ajax({

                    url: '{!! url('/qc1pf') !!}',
                    type: "POST",
                    data: {
                        Reference: selectedRowsData[0].Reference,
                        CustomerName: selectedRowsData[0].CustomerName,
                        ProductName: selectedRowsData[0].ProductName,
                        DepartmentName: selectedRowsData[0].DepartmentName,
                        MachineName: selectedRowsData[0].MachineName,
                        JobNo: selectedRowsData[0].JobNo,
                        WireSize: selectedRowsData[0].WireSize,
                        MassRequired: selectedRowsData[0].MassRequired,
                        testNo: $("#test").val(),
                        zincTested: $("#zinc").val(),
                        mpaTested: $("#mpa").val(),
                        castNo: $("#CastNo").val(),
                        wireSizeTested: $("#wiresize").val(),
                        stressTest: $("#stresstest").val(),
                        elongBreakTest: $("#elongation").val(),
                        torsionTest: $("#torsion").val(),
                        wrapTest: $("#wraptest").val(),
                        coating: $("#coating option:selected").text(),
                        comment1: $("#comment1 option:selected").text(),
                        massProduced: selectedRowsData[0].MassProduced,
                        zincInitialMass: $("#initmass").val(),
                        zincStripMass: $("#stripmass").val(),
                        zincStripSize: $("#stripsize").val(),
                        comment2: $("#comment2 option:selected").text(),
                        comment3: $("#comment3 option:selected").text(),
                        testpf: "P",

                    },
                    success: function(data) {
                        if (data[0].Result != "Success") {
                            alert(data[0].Result);
                        } else {
                            if (data[0].Warnings != "Warning:") {
                                alert(data[0].Warnings);
                                $('#modalPassOrFail').modal('hide');
                                getQc1Data();
                            } else {
                                $('#modalPassOrFail').modal('hide');
                                getQc1Data();
                            }
                        }
                    }
                });
            });

            $('#testfail').click(function() {
                var comment1 = $("#comment1 option:selected").text();
                var comment2 = $("#comment2 option:selected").text();
                var comment3 = $("#comment3 option:selected").text();

                if (comment1.trim() == "" && comment2.trim() == "" && comment3.trim() == "") {
                    alert("You need to select at least one comment.");
                } else {
                    $(this).prop("disabled", true);
                    var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
                    var selectedRowsData = dataGrid.getSelectedRowsData();

                    $.ajax({

                        url: '{!! url('/qc1pf') !!}',
                        type: "POST",
                        data: {
                            Reference: selectedRowsData[0].Reference,
                            CustomerName: selectedRowsData[0].CustomerName,
                            ProductName: selectedRowsData[0].ProductName,
                            DepartmentName: selectedRowsData[0].DepartmentName,
                            MachineName: selectedRowsData[0].MachineName,
                            JobNo: selectedRowsData[0].JobNo,
                            WireSize: selectedRowsData[0].WireSize,
                            MassRequired: selectedRowsData[0].MassRequired,
                            testNo: $("#test").val(),
                            zincTested: $("#zinc").val(),
                            mpaTested: $("#mpa").val(),
                            castNo: $("#CastNo").val(),
                            wireSizeTested: $("#wiresize").val(),
                            stressTest: $("#stresstest").val(),
                            elongBreakTest: $("#elongation").val(),
                            torsionTest: $("#torsion").val(),
                            wrapTest: $("#wraptest").val(),
                            coating: $("#coating option:selected").text(),
                            comment1: $("#comment1 option:selected").text(),
                            massProduced: selectedRowsData[0].MassProduced,
                            zincInitialMass: $("#initmass").val(),
                            zincStripMass: $("#stripmass").val(),
                            zincStripSize: $("#stripsize").val(),
                            comment2: $("#comment2 option:selected").text(),
                            comment3: $("#comment3 option:selected").text(),
                            testpf: "F",


                        },
                        success: function(data) {
                            if (data[0].Result != "Success") {
                                alert(data[0].Result);
                                getQc1Data();
                            } else {
                                if (data[0].Warnings != "Warning:") {
                                    alert(data[0].Warnings);
                                    $('#modalPassOrFail').modal('hide');
                                    getQc1Data();
                                } else {
                                    $('#modalPassOrFail').modal('hide');
                                    getQc1Data();
                                }
                            }
                        }

                    });
                }
            });

            $('#calczinc').click(function() {
                var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
                var selectedRowsData = dataGrid.getSelectedRowsData();

                var zincInitialMass = $("#initmass").val();
                var zincStripMass = $("#stripmass").val();
                var zincStripSize = $("#stripsize").val();

                var formula = ((zincInitialMass - zincStripMass) / zincStripMass) * (1960 * zincStripSize);
                formula = parseFloat(formula).toFixed(4);

                $('#zinc').val(formula);

            });

            function getQc1Data() {
                $('#testpass').prop("disabled", false);
                $('#testfail').prop("disabled", false);
                $.ajax({
                    url: '{!! url('/getqc1') !!}',
                    type: "GET",
                    data: {

                    },
                    success: function(data) {
                        gridQcPhase1.option('dataSource', data);
                        gridQcPhase1.refresh();

                        gridData = gridQcPhase1.option("dataSource");
                    }
                });
            }

            doacheck();

            function doacheck() {
                setInterval(checkforchanges, 10000);
            };

            function checkforchanges() {
                $.ajax({
                    url: '{!! url('/checkForGalvUpdates') !!}',
                    type: "GET",
                    data: {
                        checker: "QC1",
                    },
                    success: function(data) {
                        // console.log(data[0].Result);
                        if (data[0].Result == "Reload") {
                            $.ajax({
                                url: '{!! url('/deleteGalvChecker') !!}',
                                type: "GET",
                                data: {
                                    checker: "QC1",
                                },
                                success: function(data) {
                                    getQc1Data();
                                }
                            });
                        }
                    }
                });
            };
        });
    </script>

@endsection
