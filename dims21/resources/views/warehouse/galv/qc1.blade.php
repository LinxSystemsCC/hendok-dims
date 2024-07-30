@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'QC Phase1')



{{-- Set to show navbar --}}
@php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        // $permission = $v->getThingsUserPermissions(Auth::user()->UserID,'Permission');
    }

    $includeMenu = true;
    
@endphp

@section('page')

<style>
    #gridQcPhase1{
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="CloseModal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="initmass">Initial Mass</label>
                        <div class="row w-100">
                            <div class="col-7 pe-0">
                                <select class="form-select rounded-0 rounded-start" id="selectInitMassScale">
                                    <option></option>
                                    @foreach($scales as $scale)
                                        <option value="{{$scale->intAutoId}}">{{$scale->strName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 px-0">
                                <input type="number"  class="form-control rounded-0" id="initmass" required disabled>
                            </div>
                            <div class="col-1 ps-0">
                                <button class="btn btn-secondary rounded-0 rounded-end" id="btnEditInitMass" ><i class="fa fa-edit p-0"></i></button>
                                <button class="btn btn-success rounded-0 rounded-end" id="btnToggleMeasureInitMass" hidden><i class="fa fa-play p-0"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="stripmass">Strip Mass</label>
                        <div class="row w-100">
                            <div class="col-7 pe-0">
                                <select class="form-select rounded-0 rounded-start" id="selectStripMassScale">
                                    <option></option>
                                    @foreach($scales as $scale)
                                        <option value="{{$scale->intAutoId}}">{{$scale->strName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 px-0">
                                <input type="number"  class="form-control rounded-0" id="stripmass" required disabled>
                            </div>
                            <div class="col-1 ps-0">
                                <button class="btn btn-secondary rounded-0 rounded-end" id="btnEditStripMass"><i class="fa fa-edit p-0"></i></button>
                                <button class="btn btn-success rounded-0 rounded-end" id="btnToggleMeasureStripMass" hidden><i class="fa fa-play p-0"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="stripsize">Strip Size</label>
                        <input type="number"  class="form-control" id="stripsize" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="zinc">Zinc</label>
                        <div class="row">
                            <div class="col-md-4">
                                <button class="btn btn-primary px-4" id="calczinc">
                                    Calculate
                                </button>
                            </div>
                            <div class="col-md-8">
                                <input type="number"  class="form-control" id="zinc" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="mpa">MPA Tested</label>
                        <input type="number"  class="form-control" id="mpa" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="wiresize">Wire Size</label>
                        <input type="number"  class="form-control" id="wiresize" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="stresstest">1 % Stress Test</label>
                        <input type="number"  class="form-control" id="stresstest" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="elongation">Elongation at Break %</label>
                        <input type="number"  class="form-control" id="elongation" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="torsion">Torsion Test</label>
                        <input type="number"  class="form-control" id="torsion" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="wraptest">1 Diameter Wrap Test</label>
                        <input type="number"  class="form-control" id="wraptest" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="coating">Coating Uniformity</label>

                        <select  class="form-control" id="coating" required>
                            <option>
                                PASS
                            </option>

                            <option>
                                FAIL
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="CastNo">Cast Number</label>
                        <input type="text"  class="form-control" id="CastNo" required>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="test">Test Number</label>
                        <input type="number"  class="form-control" id="test" required disabled>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label class="form-label" for="comment1">Comment</label>
                        <select  class="form-control" id="comment1" required>
                            <option>
                            </option>
                        </select>
                        <br>
                        <select  class="form-control" id="comment2" required>
                            <option>
                            </option>
                        </select>
                        <br>
                        <select  class="form-control" id="comment3" required>
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

        $('#zinc').prop( "disabled", true );

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
        $("#modalPassOrFail").on("hidden.bs.modal", function () {
            $("#modalPassOrFail input, #modalPassOrFail select").val("");
            $('#btnEditInitMass').prop('hidden', false);
            $('#btnToggleMeasureInitMass').prop('hidden', true);
            $('#btnEditStripMass').prop('hidden', false);
            $('#btnToggleMeasureStripMass').prop('hidden', true);
        });

        const gridQcPhase1 = $("#gridQcPhase1").dxDataGrid({
            dataSource:[], //as json
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
                        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'qc1.xlsx');
                    });
                });
                e.cancel = true;
            },
            columns: [
                {
                    dataField: "JobNo",
                    caption: "Job No",
                    //width:100,
                },{
                    dataField: "TestNo",
                    caption: "Test No",
                    //width:100,
                },{
                    dataField: "Reference",
                    caption: "Reference",
                    //width:150,
                },{
                    dataField: "CustomerName",
                    caption: "Customer Name",
                    //width:150,
                },{
                    dataField: "ProductName",
                    caption: "Product",
                    //width:150,
                },{
                    dataField: "DepartmentName",
                    caption: "Department",
                    //width: 450,
                },{
                    dataField: "MachineName",
                    caption: "Machine",
                    //width: 350,
                },{
                    dataField: "MPATolerance",
                    caption: "MPA Tolerance",
                    //width:250,
                },{
                    dataField: "ZincSpec",
                    caption: "Zinc Spec",
                    //width:250,
                },{
                    dataField: "WireSize",
                    caption: "Wire Size",
                    dataType: "number", 
                    alignment: "left",
                    type:"fixedPoint",  
                    precision:2,
                    //width:200,
                },{
                    dataField: "SizeTolerance",
                    caption: "Wire Tolerance",
                },{
                    dataField: "MaxTDT",
                    caption: "Date",
                    //width:250,
                },
                {
                    dataField: "MassRequired",
                    caption: "Required",
                    //width:100,
                },{
                    dataField: "count",
                    caption: "Count",
                    visible: false,
                    //width:100,
                },
            ],
            onRowDblClick:function(e){
                $('#modalPassOrFail').modal('toggle');
                var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
                var selectedRowsData = dataGrid.getSelectedRowsData();
                var dept = selectedRowsData[0].DepartmentName;
                var mach = selectedRowsData[0].MachineName;
                var title = dept + ", " + mach;
                var testNo = selectedRowsData[0].TestNo;

                $('#qc1TestTitle').text(title);
                $('#test').val(testNo);
            },
            onToolbarPreparing: function (e) {
                // Create a custom header on the left side
                e.toolbarOptions.items.unshift(
                    {
                        location: 'before',
                        template: function () {
                            return $('<h3>').text('QC PHASE 1');
                        }
                    }
                );
            },

        }).dxDataGrid('instance');

        getQc1Data();

        // Update Comments Lists
        $.ajax({

            url: '{!!url("/getqc1comments")!!}',
            type: "GET",
            data: {
    

            },
            success: function (data) {
                var toAppend = '';
                $("#comment1").empty();
                $("#comment2").empty();
                $("#comment3").empty();
                toAppend += '<option></option>';
                $.each(data,function(i,o){

                    toAppend += '<option value="'+o.RemarkID+'">'+o.Remark+'</option>';
                });
                $("#comment1").append(toAppend);
                $("#comment2").append(toAppend);
                $("#comment3").append(toAppend);

            },
        });

        $('#testpass').click(function(){
            $(this).prop("disabled", true);
            var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            $.ajax({
                
                url: '{!!url("/qc1pf")!!}',
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
                success: function (data) {
                    if (data[0].Result != "Success"){
                        alert(data[0].Result);
                    }
                    else{
                        if (data[0].Warnings != "Warning:"){
                            alert(data[0].Warnings);
                            $('#modalPassOrFail').modal('hide');
                            getQc1Data();
                        }
                        else{
                            $('#modalPassOrFail').modal('hide');
                            getQc1Data();
                        }
                    }
                }
            });
            
                
        });

        $('#testfail').click(function(){
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
                    
                    url: '{!!url("/qc1pf")!!}',
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
                    success: function (data) {
                        if (data[0].Result != "Success"){
                            alert(data[0].Result);
                            getQc1Data();
                        }
                        else{
                            if (data[0].Warnings != "Warning:"){
                                alert(data[0].Warnings);
                                $('#modalPassOrFail').modal('hide');
                                getQc1Data();
                            }
                            else{
                                $('#modalPassOrFail').modal('hide');
                                getQc1Data();
                            }
                        }
                    }

                });
            }
        });

        $('#calczinc').click(function(){
            var dataGrid = $("#gridQcPhase1").dxDataGrid("instance");
            var selectedRowsData = dataGrid.getSelectedRowsData();

            var zincInitialMass = $("#initmass").val();
            var zincStripMass = $("#stripmass").val();
            var zincStripSize = $("#stripsize").val();

            var formula = ((zincInitialMass-zincStripMass)/zincStripMass)*(1960*zincStripSize);
            formula = parseFloat(formula).toFixed(4);
            
            $('#zinc').val(formula);

        });

        function getQc1Data(){
            $('#testpass').prop("disabled", false);
            $('#testfail').prop("disabled", false);
            $.ajax({
                url: '{!!url("/getqc1")!!}',
                type: "GET",
                data: {

                },
                success: function (data) {
                    gridQcPhase1.option('dataSource', data);
                    gridQcPhase1.refresh();

                    gridData = gridQcPhase1.option("dataSource");
                }
            });
        }

        doacheck();

        function doacheck(){
            setInterval(checkforchanges,10000);
        };

        function checkforchanges(){
            $.ajax({
                url: '{!!url("/checkForGalvUpdates")!!}',
                type: "GET",
                data: {
                    checker: "QC1",
                },
                success: function (data) {
                    // console.log(data[0].Result);
                    if (data[0].Result == "Reload"){
                        $.ajax({
                            url: '{!!url("/deleteGalvChecker")!!}',
                            type: "GET",
                            data: {
                                checker: "QC1",
                            },
                            success: function (data) {
                                getQc1Data();
                            }
                        });
                    }
                }
            });
        };

        function fetchWeight(scale, inputId) {
            $.ajax({
                url: '{!!url("/listenToScale")!!}',
                type: "GET",
                data: {
                    scaleID: scale,
                },
                success: function (data) {
                    if (data) {
                        $(inputId).val(data);
                    } else {
                        $(inputId).val(0);
                    }
                }
            });
        }

        $("#selectInitMassScale").change(function () {
            const scaleValue = $("#selectInitMassScale").val();

            if (scaleValue === '') {
                $('#btnEditInitMass').prop('hidden', false);
                $('#btnToggleMeasureInitMass').prop('hidden', true);
            } else {
                $('#btnEditInitMass').prop('hidden', true);
                $('#btnToggleMeasureInitMass').prop('hidden', false);
            }
        });

        $("#selectStripMassScale").change(function () {
            const scaleValue = $("#selectStripMassScale").val();

            if (scaleValue === '') {
                $('#btnEditStripMass').prop('hidden', false);
                $('#btnToggleMeasureStripMass').prop('hidden', true);
            } else {
                $('#btnEditStripMass').prop('hidden', true);
                $('#btnToggleMeasureStripMass').prop('hidden', false);
            }
        });

        let isRunningInit = false;
        let isRunningStrip = false;
        let initInterval = null;
        let stripInterval = null;

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

        $('#btnToggleMeasureInitMass').click(function () {
            initInterval = toggleFetchWeight('#btnToggleMeasureInitMass', '#selectInitMassScale', isRunningInit, initInterval, '#initmass');
            isRunningInit = !isRunningInit;
        });

        $('#btnToggleMeasureStripMass').click(function () {
            var initMass = $("#initmass").val();
            if (initMass == ''){
                alert("Please Measeure the initial mass first.");
                return;
            }
            
            stripInterval = toggleFetchWeight('#btnToggleMeasureStripMass', '#selectStripMassScale', isRunningStrip, stripInterval, '#stripmass');
            isRunningStrip = !isRunningStrip;
        });

        $('#btnEditInitMass').click(function () {
            $('#initmass').prop("disabled", function(_, value) {
                return !value;
            });
            $('#selectInitMassScale').prop("disabled", function(_, value) {
                return !value;
            });
            $('#initmass').val("");
            $('#selectInitMassScale').val("");
        });

        $('#btnEditStripMass').click(function () {
            $('#stripmass').prop("disabled", function(_, value) {
                return !value;
            });
            $('#selectStripMassScale').prop("disabled", function(_, value) {
                return !value;
            });
            $('#stripmass').val("");
            $('#selectStripMassScale').val("");
        });
    });

</script>

@endsection