@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Production Capture')


@php
    if ((Auth::guest()))
    {

    }else{
        $v  =  new \App\Http\Controllers\SalesForm();
        $Delete = $v->getThingsUserPermissions(Auth::user()->UserID,'Production Capture Delete');

        $canDelete = ($Delete == 1) ? true : false;
    }

    $includeMenu = true;
    
@endphp


@section('page')

<div id="gridProductionCapture"></div>

<!-- Upliftment Modal -->
<div class="modal fade modal-lg" id="captureModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">CAPTURE PRODUCTION</h1>
                <button type="button" class="btn-close closeCaptureModal" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="inputDate">Date</label>
                            <input type="date" class="form-control w-100" id="inputDate" required>
                        </div>

                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="selectShift">Shift</label>
                            <select class="form-select w-100" id="selectShift" required>
                                <option></option>
                                @foreach($shifts as $shift)
                                    <option value="{{ $shift->intAutoId }}">{{ $shift->strShiftName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="selectDepartment">Department</label>
                            <select class="form-select w-100" id="selectDepartment" required>
                                <option></option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->intAutoID }}">{{ $department->strDeptName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="selectMachine">Machine</label>
                            <select class="form-select w-100" id="selectMachine" required>
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group mb-2 col-8 pe-0">
                            <label class="control-label fw-bold" for="selectProduct">Product Description</label>
                            <select class="form-select w-100 rounded-0 rounded-start" id="selectProduct" required>
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group mb-2 col-4 ps-0">
                            <label class="control-label fw-bold" for="inputProductCode">Product Code</label>
                            <input type="text" class="form-control w-100 rounded-0 rounded-end" id="inputProductCode"
                                disabled>
                        </div>

                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="inputSageWeight">Product Weight</label>
                            <input type="number" class="form-control w-100" id="inputSageWeight" disabled>
                        </div>

                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="inputActualWeight">Actual Weight</label>
                            <input type="number" class="form-control w-100" id="inputActualWeight" required>
                        </div>

                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="inputQty">Quantity</label>
                            <input type="number" class="form-control w-100" id="inputQty" required>
                        </div>

                        <div class="form-group mb-2 col-6">
                            <label class="control-label fw-bold" for="inputScrap">Scrap</label>
                            <input type="number" class="form-control w-100" id="inputScrap" required>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="selectOperator1">Operator 1</label>
                            <select class="form-select w-100" id="selectOperator1" required>
                                <option></option>
                                @foreach($operators as $operator)
                                    <option value="{{ $operator->EmployeeCode }}">{{ $operator->FirstName }}
                                        {{ $operator->LastName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="selectOperator2">Operator 2</label>
                            <select class="form-select w-100" id="selectOperator2" required>
                                <option></option>
                                @foreach($operators as $operator)
                                    <option value="{{ $operator->EmployeeCode }}">{{ $operator->FirstName }}
                                        {{ $operator->LastName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="selectOperator3">Operator 3</label>
                            <select class="form-select w-100" id="selectOperator3" required>
                                <option></option>
                                @foreach($operators as $operator)
                                    <option value="{{ $operator->EmployeeCode }}">{{ $operator->FirstName }}
                                        {{ $operator->LastName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="selectOperator4">Operator 4</label>
                            <select class="form-select w-100" id="selectOperator4" required>
                                <option></option>
                                @foreach($operators as $operator)
                                    <option value="{{ $operator->EmployeeCode }}">{{ $operator->FirstName }}
                                        {{ $operator->LastName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="inputDowntime1">Downtime 1</label>
                            <div id="inputDowntime1" class="d-inline-flex w-100">
                                <input type="number" min="0" step="1" class="form-control me-2 hours" />
                                <h3>:</h3>
                                <input type="number" min="0" max="59" step="1" class="form-control ms-2 minutes" />
                            </div>
                            {{-- <input type="time" class="form-control w-100" id="inputDowntime1" required hidden> --}}
                        </div>

                        <div class="form-group mb-2 col-5">
                            <label class="control-label fw-bold" for="selectReason1">Reason 1</label>
                            <select class="form-select w-100" id="selectReason1" required>
                                <option></option>
                                @foreach($reasons as $reason)
                                    <option value="{{ $reason->intAutoId }}">{{ $reason->strReason }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-4">
                            <label class="control-label fw-bold" for="inputComment1">Comment 1</label>
                            <input type="text" class="form-control w-100" id="inputComment1" required>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="inputDowntime2">Downtime 2</label>
                            <div id="inputDowntime2" class="d-inline-flex w-100">
                                <input type="number" min="0" step="1" class="form-control me-2 hours" />
                                <h3>:</h3>
                                <input type="number" min="0" max="59" step="1" class="form-control ms-2 minutes" />
                            </div>
                            {{-- <input type="time" class="form-control w-100" id="inputDowntime2" required> --}}
                        </div>

                        <div class="form-group mb-2 col-5">
                            <label class="control-label fw-bold" for="selectReason2">Reason 2</label>
                            <select class="form-select w-100" id="selectReason2" required>
                                <option></option>
                                @foreach($reasons as $reason)
                                    <option value="{{ $reason->intAutoId }}">{{ $reason->strReason }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-4">
                            <label class="control-label fw-bold" for="inputComment2">Comment 2</label>
                            <input type="text" class="form-control w-100" id="inputComment2" required>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="inputDowntime3">Downtime 3</label>
                            <div id="inputDowntime3" class="d-inline-flex w-100">
                                <input type="number" min="0" step="1" class="form-control me-2 hours" />
                                <h3>:</h3>
                                <input type="number" min="0" max="59" step="1" class="form-control ms-2 minutes" />
                            </div>
                            {{-- <input type="time" class="form-control w-100" id="inputDowntime3" required> --}}
                        </div>

                        <div class="form-group mb-2 col-5">
                            <label class="control-label fw-bold" for="selectReason3">Reason 3</label>
                            <select class="form-select w-100" id="selectReason3" required>
                                <option></option>
                                @foreach($reasons as $reason)
                                    <option value="{{ $reason->intAutoId }}">{{ $reason->strReason }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-4">
                            <label class="control-label fw-bold" for="inputComment3">Comment 3</label>
                            <input type="text" class="form-control w-100" id="inputComment3" required>
                        </div>

                        <div class="form-group mb-2 col-3">
                            <label class="control-label fw-bold" for="inputDowntime4">Downtime 4</label>
                            <div id="inputDowntime4" class="d-inline-flex w-100">
                                <input type="number" min="0" step="1" class="form-control me-2 hours" />
                                <h3>:</h3>
                                <input type="number" min="0" max="59" step="1" class="form-control ms-2 minutes" />
                            </div>
                            {{-- <input type="time" class="form-control w-100" id="inputDowntime4" required> --}}
                        </div>

                        <div class="form-group mb-2 col-5">
                            <label class="control-label fw-bold" for="selectReason4">Reason 4</label>
                            <select class="form-select w-100" id="selectReason4" required>
                                <option></option>
                                @foreach($reasons as $reason)
                                    <option value="{{ $reason->intAutoId }}">{{ $reason->strReason }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2 col-4">
                            <label class="control-label fw-bold" for="inputComment4">Comment 4</label>
                            <input type="text" class="form-control w-100" id="inputComment4" required>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100" id="btnCapture">CAPTURE</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<style>
    #gridProductionCapture {
        height: calc(100vh - 2rem);
        max-height: calc(100vh - 2rem);
    }

</style>

<script>
    $(document).ready(function () {
        let products;
        let productionCapture = [];

        const gridProductionCapture = $("#gridProductionCapture").dxDataGrid({
            dataSource: productionCapture,
            showBorders: true,
            showRowLines: true,
            showColumnLines: true,
            rowAlternationEnabled: true,
            filterRow: {
                visible: true
            },
            filterPanel: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
            paging: {
                enabled: false
            },
            selection: {
                mode: "single",
            },
            columnFixing: {
                enabled: true,
            },
            editing: {
                mode: 'row',
                // allowUpdating: true,
                allowDeleting: '{{ $canDelete }}',
            },
            columnAutoWidth: true,
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                    dataField: "intAutoId",
                    caption: "intAutoId",
                    visible: false,
                },
                {
                    dataField: "dteOccured",
                    caption: "Date",
                },
                {
                    dataField: "strShiftName",
                    caption: "Shift",
                },
                {
                    dataField: "strDeptName",
                    caption: "Department",
                },
                {
                    dataField: "strMachineName",
                    caption: "Machine",
                },
                {
                    dataField: "ProductCode",
                    caption: "Product Code",
                },
                {
                    dataField: "ProductDescription",
                    caption: "Product Description",
                },
                {
                    dataField: "fltSageWeight",
                    caption: "Product Weight",
                    dataType: "number",
                    type: "fixedPoint",
                    precision: 2,
                },
                {
                    dataField: "fltWeight",
                    caption: "Actual Weight",
                    dataType: "number",
                    type: "fixedPoint",
                    precision: 2,
                },
                {
                    dataField: "fltQty",
                    caption: "Qty",
                    dataType: "number",
                    type: "fixedPoint",
                    precision: 2,
                },
                {
                    dataField: "strOperator1",
                    caption: "Operator 1",
                },
                {
                    dataField: "strOperator2",
                    caption: "Operator 2",
                },
                {
                    dataField: "strOperator3",
                    caption: "Operator 3",
                },
                {
                    dataField: "strOperator4",
                    caption: "Operator 4",
                },
                {
                    dataField: "fltScrap",
                    caption: "Scrap",
                    dataType: "number",
                    type: "fixedPoint",
                    precision: 2,
                },
                {
                    dataField: "strDowntime1",
                    caption: "Downtime 1",
                },
                {
                    dataField: "strReason1",
                    caption: "Reason 1",
                },
                {
                    dataField: "strComment1",
                    caption: "Comment 1",
                },
                {
                    dataField: "strDowntime2",
                    caption: "Downtime 2",
                },
                {
                    dataField: "strReason2",
                    caption: "Reason 2",
                },
                {
                    dataField: "strComment2",
                    caption: "Comment 2",
                },
                {
                    dataField: "strDowntime3",
                    caption: "Downtime 3",
                },
                {
                    dataField: "strReason3",
                    caption: "Reason 3",
                },
                {
                    dataField: "strComment3",
                    caption: "Comment 3",
                },
                {
                    dataField: "strDowntime4",
                    caption: "Downtime 4",
                },
                {
                    dataField: "strReason4",
                    caption: "Reason 4",
                },
                {
                    dataField: "strComment4",
                    caption: "Comment 4",
                },
            ],
            onRowRemoved: function (e) {
                $.ajax({
                    url: '{!!url("/postProductionCaptureCRUD")!!}',
                    type: "POST",
                    data: {
                        intAutoId: e.data.intAutoId,
                        command: "DELETE"
                    },
                    success: function (data) {
                        getProductionCapture();
                    }
                });
            },
            onToolbarPreparing: function (e) {
                // Create a custom header on the left side
                e.toolbarOptions.items.unshift({
                    location: 'before',
                    template: function () {
                        return $('<h3>').text('Production Capture');
                    }
                });
                e.toolbarOptions.items.push({
                    location: 'after',
                    widget: "dxButton",
                    options: {
                        icon: "fa fa-clipboard",
                        text: "CAPTURE",
                        onClick: function (args) {
                            $('#captureModal').modal('show');
                        },
                    },
                });
            }
        }).dxDataGrid('instance');

        $('#selectOperator1').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
            matcher: function (params, data) {
                // If there's no search term, return all options
                if ($.trim(params.term) === '') {
                    return data;
                }
                // Check if search term matches option value
                if (data.id.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Check if search term matches option display text
                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Return null if there's no match
                return null;
            }
        });

        $('#selectOperator2').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
            matcher: function (params, data) {
                // If there's no search term, return all options
                if ($.trim(params.term) === '') {
                    return data;
                }
                // Check if search term matches option value
                if (data.id.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Check if search term matches option display text
                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Return null if there's no match
                return null;
            }
        });

        $('#selectOperator3').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
            matcher: function (params, data) {
                // If there's no search term, return all options
                if ($.trim(params.term) === '') {
                    return data;
                }
                // Check if search term matches option value
                if (data.id.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Check if search term matches option display text
                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Return null if there's no match
                return null;
            }
        });

        $('#selectOperator4').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
            matcher: function (params, data) {
                // If there's no search term, return all options
                if ($.trim(params.term) === '') {
                    return data;
                }
                // Check if search term matches option value
                if (data.id.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Check if search term matches option display text
                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) >= 0) {
                    return data;
                }
                // Return null if there's no match
                return null;
            }
        });

        $('#selectReason1').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
        });

        $('#selectReason2').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
        });

        $('#selectReason3').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
        });

        $('#selectReason4').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#captureModal'),
        });

        function clearInputsAndSelect() {
            $('.form-control').val('');
            $('.form-select').val('').trigger('change');
            $('#inputSageWeight').val('');
        }

        // Event listener for modal dismiss
        $('#captureModal').on('hidden.bs.modal', function (e) {
            clearInputsAndSelect();
        });

        $("#btnCapture").click(function () {
            var dteOccured = $("#inputDate").val();
            var intShiftId = $("#selectShift").val();
            var intDepartmentId = $("#selectDepartment").val();
            var intMachineId = $("#selectMachine").val();
            var strProductCode = $("#selectProduct").val();
            var fltWeight = $("#inputActualWeight").val();
            var fltQty = $("#inputQty").val();
            var strOperator1 = $("#selectOperator1").val();
            var strOperator2 = $("#selectOperator2").val();
            var strOperator3 = $("#selectOperator3").val();
            var strOperator4 = $("#selectOperator4").val();
            var fltScrap = $("#inputScrap").val();

            var hours1 = $('#inputDowntime1 .hours').val();
            var minutes1 = $('#inputDowntime1 .minutes').val();
            if (hours1 == '') {
                hours1 = '0';
            }
            if (minutes1 == '') {
                minutes1 = '0';
            }
            var strDowntime1 = hours1 + ':' + minutes1

            var intReason1 = $("#selectReason1").val();
            var strComment1 = $("#inputComment1").val();

            var hours2 = $('#inputDowntime2 .hours').val();
            var minutes2 = $('#inputDowntime2 .minutes').val();
            if (hours2 == '') {
                hours2 = '0';
            }
            if (minutes2 == '') {
                minutes2 = '0';
            }
            var strDowntime2 = hours2 + ':' + minutes2

            var intReason2 = $("#selectReason2").val();
            var strComment2 = $("#inputComment2").val();

            var hours3 = $('#inputDowntime3 .hours').val();
            var minutes3 = $('#inputDowntime3 .minutes').val();
            if (hours3 == '') {
                hours3 = '0';
            }
            if (minutes3 == '') {
                minutes3 = '0';
            }
            var strDowntime3 = hours3 + ':' + minutes3

            var intReason3 = $("#selectReason3").val();
            var strComment3 = $("#inputComment3").val();

            var hours4 = $('#inputDowntime4 .hours').val();
            var minutes4 = $('#inputDowntime4 .minutes').val();
            if (hours4 == '') {
                hours4 = '0';
            }
            if (minutes4 == '') {
                minutes4 = '0';
            }
            var strDowntime4 = hours4 + ':' + minutes4

            var intReason4 = $("#selectReason4").val();
            var strComment4 = $("#inputComment4").val();

            insertProductCapture(dteOccured, intShiftId, intDepartmentId, intMachineId, strProductCode,
                fltWeight, fltQty, strOperator1, strOperator2, strOperator3, strOperator4, fltScrap,
                strDowntime1, intReason1, strComment1, strDowntime2, intReason2, strComment2,
                strDowntime3, intReason3, strComment3, strDowntime4, intReason4, strComment4);
        });

        $('#selectDepartment').change(function () {
            if ($('#selectDepartment').val() != '') {
                $('#overlay').prop('hidden', false);
                $.ajax({

                    url: '{!!url("/getBulkMappingAreaDeptSubDeptMachines")!!}',
                    type: "GET",
                    data: {
                        ID: $('#selectDepartment').val(),
                        prompt: 'DepartmentMachines',
                    },
                    success: function (data) {
                        var machines = $.map(JSON.parse(JSON.stringify(data)), function (
                            item) {
                            return {
                                id: item.intMachineID,
                                text: item.strMachineName
                            }
                        });

                        machines.unshift({
                            id: '',
                            text: ''
                        });

                        $('#selectMachine').empty().select2({
                            data: machines,
                            theme: 'bootstrap-5',
                            dropdownParent: $('#captureModal'),
                        });

                        $('#overlay').prop('hidden', true);
                    }
                });

                $('#overlay').prop('hidden', false);
                $.ajax({
                    url: '{!!url("/getProductsMappedToDepartment")!!}',
                    type: "GET",
                    data: {
                        ID: $('#selectDepartment').val(),
                    },
                    success: function (data) {
                        products = $.map(JSON.parse(JSON.stringify(data)), function (item) {
                            return {
                                id: item.ProductCode,
                                text: item.ProductDescription,
                                ProductCode: item.ProductCode,
                                ProductDescription: item.ProductDescription,
                                ProductWeight: item.ProductWeight,
                            }
                        });

                        products.unshift({
                            id: '',
                            text: ''
                        });

                        $('#selectProduct').empty().select2({
                            data: products,
                            theme: 'bootstrap-5',
                            dropdownParent: $('#captureModal'),
                            matcher: function (params, data) {
                                // If there's no search term, return all options
                                if ($.trim(params.term) === '') {
                                    return data;
                                }
                                // Check if search term matches option value
                                if (data.id.toLowerCase().indexOf(params.term
                                        .toLowerCase()) >= 0) {
                                    return data;
                                }
                                // Check if search term matches option display text
                                if (data.text.toLowerCase().indexOf(params.term
                                        .toLowerCase()) >= 0) {
                                    return data;
                                }
                                // Return null if there's no match
                                return null;
                            }
                        });

                        $('#overlay').prop('hidden', true);
                    }
                });
            }

        });

        $('#selectProduct').change(function () {
            var selectedProductCode = $('#selectProduct').val();
            // console.log(products);
            $.each(products, function (index, product) {
                if (product.ProductCode == selectedProductCode) {
                    // Once the matching product is found, retrieve its 'ProductWeight' property
                    selectedProductWeight = product.ProductWeight;
                    return false; // Exit the loop once the matching product is found
                }
            });

            $('#inputSageWeight').val(parseFloat(selectedProductWeight).toFixed(3));
            $('#inputProductCode').val(selectedProductCode);
        });

        getProductionCapture()

        function getProductionCapture() {
            $.ajax({
                url: '{!!url("/postProductionCaptureCRUD")!!}',
                type: "POST",
                data: {
                    command: "READ"
                },
                success: function (data) {
                    gridProductionCapture.option('dataSource', data);
                    gridProductionCapture.refresh();

                    gridData = gridProductionCapture.option("dataSource");
                }
            });
        }

        function insertProductCapture(dteOccured, intShiftId, intDepartmentId, intMachineId, strProductCode,
            fltWeight, fltQty, strOperator1, strOperator2, strOperator3, strOperator4, fltScrap, strDowntime1,
            intReason1, strComment1, strDowntime2, intReason2, strComment2, strDowntime3, intReason3,
            strComment3, strDowntime4, intReason4, strComment4) {
            $.ajax({
                url: '{!!url("/postProductionCaptureCRUD")!!}',
                type: "POST",
                data: {
                    dteOccured: dteOccured,
                    intShiftId: intShiftId,
                    intDepartmentId: intDepartmentId,
                    intMachineId: intMachineId,
                    strProductCode: strProductCode,
                    fltWeight: fltWeight,
                    fltQty: fltQty,
                    strOperator1: strOperator1,
                    strOperator2: strOperator2,
                    strOperator3: strOperator3,
                    strOperator4: strOperator4,
                    fltScrap: fltScrap,
                    strDowntime1: strDowntime1,
                    intReason1: intReason1,
                    strComment1: strComment1,
                    strDowntime2: strDowntime2,
                    intReason2: intReason2,
                    strComment2: strComment2,
                    strDowntime3: strDowntime3,
                    intReason3: intReason3,
                    strComment3: strComment3,
                    strDowntime4: strDowntime4,
                    intReason4: intReason4,
                    strComment4: strComment4,
                    command: "CREATE"
                },
                success: function (data) {
                    if (data[0]['RESULT'] != 'SUCCESS') {
                        alert(data[0]['RESULT']);
                    } else {
                        getProductionCapture();
                        $('#captureModal').modal('hide');
                    }


                }
            });
        }
    });

</script>

@endsection
