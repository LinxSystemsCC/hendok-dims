@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Stands')

@php
    $includeMenu = true;
@endphp

@section('page')

    <div class="row">
        <div class="col-lg-12 d-inline-flex">
            <h3 style="flex-grow: 1; padding-left: 15px;">Stands</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newstands">
                New Stands
            </button>
        </div>
        <div id="gridContainer" style="min-width: 100%;"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newstands" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newuserLabel">Create New Stands</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- General error message will be displayed here if needed -->
                    <div id="general-error"></div>

                    <div class="form-group mt-2 " id="strStandNameDiv">
                        <label class="control-label" for="strStandName"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Stand Name</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="strStandName" name="strStandName">
                        <!-- Error message will be appended here -->
                    </div>
                    <div class="form-group mt-2" id="fltStandMassDiv">
                        <label class="control-label" for="fltStandMass"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Stand Mass</label>
                        <input type="text" class="form-control input-sm col-xs-1" id="fltStandMass" name="fltStandMass">
                        <!-- Error message will be appended here -->
                    </div>
                    <div class="form-group mt-2">
                        <label class="control-label" for="Department ID"
                            style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Department</label>
                        <select class="form-select" type="text" id='intDepartmentId'>
                            <option value="" selected>Select Department</option>
                            @foreach ($dept as $val)
                                <option value="{{ $val-> dptID}}"> {{ $val->dptName }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" id="close">Close</button>
                    <button type="button" id="savestands" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });

        $('#intDepartmentId').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#newstands'),
        });

        $(document).ready(function() {
            $('#savestands').click(function() {
                $.ajax({
                    url: '{{ route('wire-draw.stands.store') }}',
                    type: "POST",
                    data: {
                        strStandName: $('#strStandName').val(),
                        fltStandMass: $('#fltStandMass').val(),
                        intDepartmentId: $('#intDepartmentId').val()
                    },
                    success: function(data) {
                        if (data.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#newstands"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });
            });

            $('.close').click(function() {
                $('#newstands').find('.errorClass').hide()
                $('#general-error').hide()
            });
            
            var dept = {!! json_encode($dept) !!};
            $.ajax({
                url: '{{ route('wire-draw.stands.get-stands') }}',
                type: "GET",

                success: function(data) {
                    $("#gridContainer").dxDataGrid({

                        dataSource: data, //as json
                        showBorders: true,
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
                        scrolling: {
                            rowRenderingMode: 'infinite',
                        },
                        paging: {
                            pageSize: 10,
                        },
                        pager: {
                            visible: true,
                            allowedPageSizes: [5, 10, 20, 50, 'all'],
                            showPageSizeSelector: true,
                            showInfo: true,
                            showNavigationButtons: true,
                        },
                        editing: {
                            mode: 'popup',
                            allowUpdating: true,
                            // allowAdding: true,
                            allowDeleting: true,
                            useIcons: true,
                        },
                        export: {
                            enabled: true,
                        },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('Wiredraw Stands');

                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], {
                                        type: 'application/octet-stream'
                                    }), 'Wiredraw Stands.xlsx');
                                });
                            });
                            e.cancel = true;
                        },

                        columns: [
                            {
                                dataField: "intStandId",
                                caption: "ID",
                                allowEditing: false,
                            },
                            {
                                dataField: "strStandName",
                                caption: "Stand Name",

                            },
                            {
                                dataField: "fltStandMass",
                                caption: "Stand Mass",
                            },
                            {
                                dataField: "intDepartmentId",
                                caption: "Department Name",
                                lookup: {
                                    dataSource: dept,
                                    displayExpr: 'dptName',
                                    valueExpr: 'dptID',
                                },
                            },
                        ],
                        onRowClick: function(e) {},
                        onRowRemoved(e) {

                        },
                        onRowRemoved(e) {
                            var intStandId = e.data.intStandId;
                            $.ajax({

                                url: '{!! url('wire-draw/stands') !!}' + '/' + intStandId,
                                type: "DELETE",
                                data: {
                                    intStandId: intStandId
                                },
                                success: function(data) {
                                    location.reload();
                                },

                            });
                        },
                        onRowUpdated(e) {
                            //var intStandId = e.data.intStandId;
                            console.log(e.data);
                            //var strStandName = ;

                            $.ajax({
                                url: '{!! url('wire-draw/stands') !!}' + '/' + e.data.intStandId,
                                type: "PUT",
                                data: {
                                    intStandId: e.data.intStandId,
                                    strStandName: e.data.strStandName,
                                    fltStandMass: e.data.fltStandMass,
                                    intDepartmentId: e.data.intDepartmentId
                                },
                                success: function(data) {
                                    location.reload();
                                },
                            });
                        },
                    });
                }
            });
        });

        function showDialog(tag, width, height) {
            $(tag).dialog({
                height: height,
                modal: false,
                width: width,
                containment: false
            }).dialogExtend({
                "closable": true, // enable/disable close button
                "maximizable": false, // enable/disable maximize button
                "minimizable": true, // enable/disable minimize button
                "collapsable": true, // enable/disable collapse button
                "dblclick": "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
                "titlebar": false, // false, 'none', 'transparent'
                "minimizeLocation": "right", // sets alignment of minimized dialogues
                "icons": { // jQuery UI icon class

                    "maximize": "ui-icon-circle-plus",
                    "minimize": "ui-icon-circle-minus",
                    "collapse": "ui-icon-triangle-1-s",
                    "restore": "ui-icon-bullet"
                },
                "load": function(evt, dlg) {}, // event
                "beforeCollapse": function(evt, dlg) {}, // event
                "beforeMaximize": function(evt, dlg) {}, // event
                "beforeMinimize": function(evt, dlg) {}, // event
                "beforeRestore": function(evt, dlg) {}, // event
                "collapse": function(evt, dlg) {}, // event
                "maximize": function(evt, dlg) {}, // event
                "minimize": function(evt, dlg) {}, // event
                "restore": function(evt, dlg) {} // event
            });
        }
    </script>

@endsection
