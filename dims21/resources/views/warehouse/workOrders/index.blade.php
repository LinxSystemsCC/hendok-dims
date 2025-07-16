@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Work Orders')

{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')

    <div id="gridJobs"></div>

    @include('warehouse.workOrders.partials.modalJobCard')

    <div class="modal fade" id="modalCreateJob" tabindex="-1" aria-labelledby="modalCreateJobTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateJobTitle">Create A Work Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="selectDepartment">Department</label>
                        <select class="form-select w-100 select2" id="selectDepartment" required>
                            <option></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->intAutoID }}">{{ $department->strDeptName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="selectCategory">Product Category </label>
                        <select class="form-select w-100 select2" id="selectCategory" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="selectProduct">Product Name </label>
                        <select class="form-select w-100 select2" id="selectProduct" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="selectMachine">Machine </label>
                        <select class="form-select w-100 select2" id="selectMachine" required>
                            <option></option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="decQty">Qty </label>
                        <input type="number" class="form-control w-100" id="decQty" required>
                    </div>

                    {{-- Label Type --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="labelType">Label Type</label>
                        <select class="form-select w-100" id="labelType" required>
                            <option></option>
                        </select>
                    </div>

                    {{-- Pallets --}}
                    <div class="form-group mb-2">
                        <label class="control-label fw-bold" for="configuration">Pallet / Bundle Quantity</label>
                        <div class="col-12 d-inline-flex">
                            <div class="col-11">
                                <select class="form-select w-100 rounded-0 rounded-start" id="configuration">

                                </select>
                                <input class="form-control w-100 rounded-0" id="inputConfiguration" type="number"
                                    hidden>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-secondary rounded-0 rounded-end" id="btnEditConfiguration"><i
                                        class="fa fa-edit p-0"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label class="control-label" for="dteStart">Start Date </label>
                        <input type="date" class="form-control col-xs-1" id="dteStart">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" id="btnSaveJob">SAVE</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#modalCreateJob').on('shown.bs.modal', function() {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#modalCreateJob'),
                });
            });

            var statuses = {!! json_encode($statuses) !!};
            let currentMachineId, currentJobId;
            let machineJobsData = [];

            const gridJobs = $("#gridJobs").dxDataGrid({
                dataSource: [], //as json
                showBorders: true,
                hoverStateEnabled: true,
                height: '100%',
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
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'machineplan.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columns: [
                    {
                        dataField: "intAutoId",
                        caption: "ID",
                        dataType: "number",
                    }, {
                        dataField: "intSequence",
                        caption: "Seq.",
                        dataType: "number",
                    }, {
                        dataField: "intDepartmentId",
                        caption: "Department ID",
                        visible: false,
                    }, {
                        dataField: "strDepartmentName",
                        caption: "Department",
                    }, {
                        dataField: "intMachineId",
                        caption: "Machine ID",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strMachineName",
                        caption: "Machine",
                    },
                    {
                        dataField: "strProductCode",
                        caption: "Product Code",
                    },
                    {
                        dataField: "strProductDescription",
                        caption: "Product Desc.",
                    },
                    {
                        dataField: "decQtyRequired",
                        dataType: "number",
                        caption: "Qty Req.",
                    },
                    {
                        dataField: "decQtyProduced",
                        dataType: "number",
                        caption: "Qty Prod.",
                    },
                    {
                        dataField: "decQtyConfiguration",
                        dataType: "number",
                        caption: "Config Qty",
                    },
                    {
                        dataField: "strConfigurationType",
                        caption: "Config Type",
                    },
                    {
                        dataField: "dtePropStart",
                        caption: "Prop. Start Date",
                    },
                    {
                        dataField: "intStatusId",
                        caption: "Job Status",
                        lookup: {
                            dataSource: statuses,
                            displayExpr: 'strStatus',
                            valueExpr: 'intStatusId',
                        },
                    },
                    // ------------------------------
                    {
                        dataField: "intCreatedBy",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strCreatedBy",
                        visible: false,
                    },
                    {
                        dataField: "dtmCreated",
                        visible: false,
                    },
                    {
                        dataField: "intStartedBy",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strStartedBy",
                        visible: false,
                    },
                    {
                        dataField: "dtmStarted",
                        visible: false,
                    },
                    {
                        dataField: "intEndedBy",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strEndedBy",
                        visible: false,
                    },
                    {
                        dataField: "dtmEnded",
                        visible: false,
                    },
                ],
                onRowDblClick: function(e) {
                    currentJobId = e.data.intAutoId;     
                    currentJobId = e.data.intAutoId;
                    $('#selectStatus').val(e.data.intStatusId);
                    $('#inputPropStart').val(e.data.dtePropStart);
                    $('#inputStart').val(e.data.dtmStarted);
                    $('#inputEnd').val(e.data.dtmEnded);
                    $('#inputSequence').val(e.data.intSequence);
                    $('#inputDepartment').val(e.data.strDepartmentName);
                    $('#inputProductCode').val(e.data.strProductCode);
                    $('#inputProductDescription').val(e.data.strProductDescription);
                    $('#inputMachine').val(e.data.strMachineName);
                    $('#inputQty').val(e.data.decQtyRequired);
                    $('#inputConfigurationType').val(e.data.strConfigurationType);
                    $('#inputConfigurationQty').val(e.data.decQtyConfiguration);

                    $('#modalJobCard').modal('show');

                    getMachineJobs(e.data.intMachineId)
                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('WORK ORDERS');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "add",
                            text: "CREATE WORK ORDER",
                            onClick: function() {
                                $('#modalCreateJob').modal('show');
                            },
                        },
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "print",
                            text: "PRINT ALL ACTIVE JOBS",
                            onClick: function() {
                                $('#modalViewJobCard').modal('show');
                            },
                        },
                    });
                },
            }).dxDataGrid("instance");

            const gridMachineJobs = $("#gridMachineJobs").dxDataGrid({
                dataSource: machineJobsData,
                showBorders: true,
                hoverStateEnabled: true,
                height: '100%',
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
                export: {
                    enabled: true
                },
                selection: {
                    mode: 'single',
                },
                rowDragging: {
                    allowReordering: true,
                    showDragIcons: false,
                    onReorder(e) {
                        const fromIndex = e.fromIndex;
                        const toIndex = e.toIndex;

                        const movedItem = machineJobsData.splice(fromIndex, 1)[0];
                        machineJobsData.splice(toIndex, 0, movedItem);

                        // Optional: reassign sequence
                        machineJobsData.forEach((item, idx) => item.intSequence = idx + 1);

                        // Rebind to reflect order
                        e.component.option("dataSource", [...machineJobsData]);
                    },
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
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'machineplan.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columns: [
                    {
                        dataField: "intAutoId",
                        caption: "ID",
                        dataType: "number",
                    }, {
                        dataField: "intSequence",
                        caption: "Seq.",
                        dataType: "number",
                    }, {
                        dataField: "intDepartmentId",
                        caption: "Department ID",
                        visible: false,
                    }, {
                        dataField: "strDepartmentName",
                        caption: "Department",
                    }, {
                        dataField: "intMachineId",
                        caption: "Machine ID",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strMachineName",
                        caption: "Machine",
                    },
                    {
                        dataField: "strProductCode",
                        caption: "Product Code",
                    },
                    {
                        dataField: "strProductDescription",
                        caption: "Product Desc.",
                    },
                    {
                        dataField: "decQtyRequired",
                        dataType: "number",
                        caption: "Qty Req.",
                    },
                    {
                        dataField: "decQtyProduced",
                        dataType: "number",
                        caption: "Qty Prod.",
                    },
                    {
                        dataField: "decQtyConfiguration",
                        dataType: "number",
                        caption: "Config Qty",
                    },
                    {
                        dataField: "strConfigurationType",
                        caption: "Config Type",
                    },
                    {
                        dataField: "dtePropStart",
                        caption: "Prop. Start Date",
                    },
                    {
                        dataField: "intStatusId",
                        caption: "Job Status",
                        lookup: {
                            dataSource: statuses,
                            displayExpr: 'strStatus',
                            valueExpr: 'intStatusId',
                        },
                    },
                    // ------------------------------
                    {
                        dataField: "intCreatedBy",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strCreatedBy",
                        visible: false,
                    },
                    {
                        dataField: "dtmCreated",
                        visible: false,
                    },
                    {
                        dataField: "intStartedBy",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strStartedBy",
                        visible: false,
                    },
                    {
                        dataField: "dtmStarted",
                        visible: false,
                    },
                    {
                        dataField: "intEndedBy",
                        dataType: "number",
                        visible: false,
                    },
                    {
                        dataField: "strEndedBy",
                        visible: false,
                    },
                    {
                        dataField: "dtmEnded",
                        visible: false,
                    },
                ],
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('JOBS ON MACHINE');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "SEQUENCE",
                            text: "SEQUENCE",
                            onClick: function() {
                                updateJobSequence();
                            },
                        },
                    });
                },
            }).dxDataGrid("instance");

            const ajaxRequests = {
                department: null,
                departmentMachine: null,
                subdepartment: null,
                category: null,
                product: null,
                machine: null,
            };

            $('#selectDepartment').change(function() {
                if (ajaxRequests.department) ajaxRequests.department.abort();

                ajaxRequests.department = $.ajax({
                    url: '{!! url('/getDepListToPlan') !!}',
                    type: 'GET',
                    data: {
                        ItemGroup: $('#selectDepartment option:selected').text(),
                    },
                    success: function(data) {
                        let toAppend = '<option></option>';
                        $('#selectCategory').empty();
                        $.each(data, function(i, o) {
                            toAppend +=
                                `<option value="${o.intAutoGroupCategoryId}">${o.strProductCategory}</option>`;
                        });
                        $('#selectCategory').append(toAppend);
                    },
                    complete: function() {
                        ajaxRequests.department = null;
                    }
                });

                if (ajaxRequests.departmentMachine) ajaxRequests.departmentMachine.abort();

                ajaxRequests.departmentMachine = $.ajax({
                    url: '{!! url('/getBulkMappingAreaDeptSubDeptMachines') !!}',
                    type: "GET",
                    data: {
                        ID: $('#selectDepartment').val(),
                        prompt: 'DepartmentMachines'
                    },
                    success: function(data) {
                        let toAppend = '<option></option>';
                        $('#selectMachine').empty();
                        $.each(data, function(i, o) {
                            toAppend +=
                                `<option value="${o.intMachineID}">${o.strMachineName}</option>`;
                        });
                        $('#selectMachine').append(toAppend);
                    },
                    complete: function() {
                        ajaxRequests.departmentMachine = null;
                    }
                });
            });

            $('#selectCategory').change(function() {
                if (ajaxRequests.category) ajaxRequests.category.abort();

                ajaxRequests.category = $.ajax({
                    url: '{!! url('/getProdListToPlan') !!}',
                    type: 'GET',
                    data: {
                        ItemGroup: $('#selectCategory').val(),
                    },
                    success: function(data) {
                        let toAppend = '<option></option>';
                        $('#selectProduct').empty();
                        $.each(data, function(i, o) {
                            toAppend +=
                                `<option value="${o.strItemCode}">${o.strItemName}</option>`;
                        });
                        $('#selectProduct').append(toAppend);
                    },
                    complete: function() {
                        ajaxRequests.category = null;
                    }
                });
            });

            $('#selectProduct').change(function() {
                if (ajaxRequests.product) ajaxRequests.product.abort();

                ajaxRequests.product = $.ajax({
                    url: '{!! url('/getMachinesforselecteddept') !!}',
                    type: 'GET',
                    data: {
                        deptId: $('#selectDepartment').val(),
                        prodname: '1'
                    },
                    success: function(data) {
                        let toAppend = '<option></option>';
                        $('#selectMachine').empty();
                        $.each(data, function(i, o) {
                            toAppend +=
                                `<option value="${o.intMachineID}">${o.strMachineName}</option>`;
                        });
                        $('#selectMachine').append(toAppend);
                    },
                    complete: function() {
                        ajaxRequests.product = null;
                    }
                });
            });

            $('#selectMachine').change(function() {
                if (ajaxRequests.machine) ajaxRequests.machine.abort();

                ajaxRequests.machine = $.ajax({
                    url: '{!! url('/getProductInfo') !!}',
                    type: "GET",
                    data: {
                        productCode: $('#selectProduct').val(),
                    },
                    success: function(data) {
                        $('#barcode').val(data[0]['Barcode']);
                        var toAppend = '';
                        $("#configuration").empty();

                        toAppend += '<optgroup label="Single" hidden>';
                        toAppend += '<option></option>';
                        toAppend += '<option value = "1">1</option>';
                        toAppend += '</optgroup>';

                        $.each(data, function(i, o) {
                            if (o.strBundleSize !== null) {
                                var bundleSize = o.strBundleSize
                                    .split(';');

                                toAppend +=
                                    '<optgroup label="Bundle" hidden>';
                                toAppend += '<option></option>';
                                $.each(bundleSize, function(index,
                                    value) {
                                    toAppend +=
                                        '<option value="' +
                                        value + '">' +
                                        value +
                                        ' / bundle</option>';
                                })
                                toAppend += '</optgroup>';
                            }

                            if (o.strPackSize !== null) {
                                var packSizes = o.strPackSize.split(
                                    ';');

                                toAppend +=
                                    '<optgroup label="Pallet" hidden>';
                                toAppend += '<option></option>';
                                $.each(packSizes, function(index,
                                    value) {
                                    toAppend +=
                                        '<option value="' +
                                        value + '">' +
                                        value +
                                        ' / pallet</option>';
                                })
                                toAppend += '</optgroup>';
                            }
                        });
                        $("#configuration").append(toAppend);

                        var addType = '';
                        $("#labelType").empty();
                        addType += '<option></option>';

                        if (data[0]['intHasSingleLable'] == "1") {
                            addType +=
                                '<option value = "Single">Single</option>';
                        }
                        if (data[0]['intHasBundleLable'] == "1") {
                            addType +=
                                '<option value = "Bundle">Bundle</option>';
                        }
                        if (data[0]['intHasPalletLable'] == "1") {
                            addType +=
                                '<option value = "Pallet">Pallet</option>';
                        }

                        $("#labelType").append(addType);
                    }
                });
            });

            $('#labelType').change(function() {
                var type = $('#labelType').val();

                if (type == 'Pallet') {
                    $("#configuration optgroup[label='Pallet']").prop('hidden', false);
                    $("#configuration optgroup[label='Bundle']").prop('hidden', true);
                    $("#configuration optgroup[label='Single']").prop('hidden', true);
                    $("#configuration").val("");
                    $("#configuration").prop('disabled', false);
                } else if (type == 'Bundle') {
                    $("#configuration optgroup[label='Pallet']").prop('hidden', true);
                    $("#configuration optgroup[label='Bundle']").prop('hidden', false);
                    $("#configuration optgroup[label='Single']").prop('hidden', true);
                    $("#configuration").val("");
                    $("#configuration").prop('disabled', false);
                } else {
                    $("#configuration optgroup[label='Pallet']").prop('hidden', true);
                    $("#configuration optgroup[label='Bundle']").prop('hidden', true);
                    $("#configuration optgroup[label='Single']").prop('hidden', false);
                    $("#configuration").val("1");
                    $("#configuration").prop('disabled', true);
                    var config = $('#configuration').val();
                    $('#inputConfiguration').val(config);
                }
            });

            $('#configuration').change(function() {
                var config = $('#configuration').val();
                $('#inputConfiguration').val(config);
            });

            $('#btnSaveJob').click(function() {
                $.ajax({
                    url: '{!! url('/createNewJob') !!}',
                    type: "POST",
                    data: {
                        intDepartmentId: $('#selectDepartment').val(),
                        intMachineId: $('#selectMachine').val(),
                        strProductCode: $('#selectProduct').val(),
                        decQtyRequired: $('#decQty').val(),
                        decQtyConfiguration: $('#inputConfiguration').val(),
                        strConfigurationType: $('#labelType').val(),
                        dtePropStart: $('#dteStart').val(),
                    },
                    success: function(data) {
                        DevExpress.ui.notify({
                            message: data.Message,
                            type: data.Status == '1' ? 'success': 'error', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });

                        if (data.Status == '1') {
                            location.reload();
                        }
                    }
                });
            });

            $('#btnEditConfiguration').click(function() {
                $('#configuration').prop("hidden", function(_, value) {
                    return !value;
                });
                $('#inputConfiguration').prop("hidden", function(_, value) {
                    return !value;
                });

                $('#configuration').val("");
                $('#inputConfiguration').val("");
            });

            $('#btnPrintJobCard').click(function() {
                window.open('{!! url('/getallactivejobs') !!}', "_blank",
                    "location=1,status=1,scrollbars=1, width=1200,height=850");
            });

            $('#selectStatus').change(function() {
                var intJobId = currentJobId;
                var intStatusId = $('#selectStatus').val();

                $.ajax({
                    url: '{!! url('/updateWorkOrderStatus') !!}',
                    type: "POST",
                    data: {
                        intJobId: intJobId,
                        intStatusId: intStatusId,
                    },
                    success: function(data) {
                        // console.log(data);
                        DevExpress.ui.notify({
                            message: data.Message,
                            type: data.Status == '1' ? 'success': 'error', // 'info', 'success', 'warning'
                            displayTime: 3500,
                        });
                        
                        if (intStatusId == 1){
                            $("#inputStart").val(data.dtmStarted);
                        }else if(intStatusId == 2){
                            $("#inputEnd").val(data.dtmEnded);
                        }

                        getActiveJobs();
                        getMachineJobs(currentMachineId);
                    }
                });
            });

            let originalQty = null;

            $('#btnEditQty').click(function () {
                originalQty = $('#inputQty').val();
                $('#inputQty').prop('disabled', false).focus();
                $('#btnEditQty').attr('hidden', true);
                $('#btnSaveQty').removeAttr('hidden');
            });

            $('#btnSaveQty').click(function () {
                const newQty = $('#inputQty').val();

                $('#inputQty').prop('disabled', true);
                $('#btnSaveQty').attr('hidden', true);
                $('#btnEditQty').removeAttr('hidden');

                if (newQty === originalQty) {
                    // No change, do nothing
                    DevExpress.ui.notify({
                        message: 'No changes detected.',
                        type: 'info',
                        displayTime: 2500,
                    });
                    return;
                }

                const intJobId = currentJobId;

                $.ajax({
                    url: '{!!url("/updateJobQtyRequired")!!}',
                    type: "POST",
                    data: {
                        intJobId: intJobId,
                        decQtyRequired: newQty
                    },
                    success: function (data) {
                        DevExpress.ui.notify({
                            message: data.Message,
                            type: data.Status == '1' ? 'success' : 'error',
                            displayTime: 3500,
                        });
                        
                        getActiveJobs();
                        getMachineJobs(currentMachineId);
                    }
                });
            });

            getActiveJobs();

            function getActiveJobs() {
                $.ajax({
                    url: '{!! url('/getActiveJobs') !!}',
                    type: "GET",
                    data: {
                        machineId: $('#machineid').val()
                    },
                    success: function(data) {
                        // console.log(data);
                        gridJobs.option("dataSource", data);
                        gridJobs.refresh();
                    }
                });
            };

            function getMachineJobs(intMachineId) {
                $.ajax({
                    url: '{!!url("/getMachineJobs")!!}',
                    type: "GET",
                    data: {
                        intMachineId: intMachineId
                    },
                    success: function(data) {
                        machineJobsData = data;
                        gridMachineJobs.option("dataSource", data);
                        gridMachineJobs.refresh();
                    }
                });
            }

            function updateJobSequence(){
                var jobData = gridMachineJobs.option("dataSource");

                var sequenceData = [];

                $.each(jobData, function(index, job) {
                    sequenceData.push({
                        intAutoId: job.intAutoId,
                        intSequence: job.intSequence
                    });
                });
                
                $.ajax({
                    url: '{!!url("/updateJobSequence")!!}',
                    type: "POST",
                    data: {
                        sequenceData: sequenceData
                    },
                    success: function(data) {
                        DevExpress.ui.notify({
                            message: data.Message,
                            type: data.Status == '1' ? 'success' : 'error',
                            displayTime: 3500,
                        });
                        
                        console.log(currentMachineId);
                        
                        getActiveJobs();
                        getMachineJobs(currentMachineId);
                    }
                });
            }
        });
    </script>

@endsection
