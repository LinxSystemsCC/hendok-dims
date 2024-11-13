@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'System Modules Listing')

@php
    $includeMenu = true;
@endphp

@section('page')

    <div class="row">
        <div class="col-lg-12 d-inline-flex">
            <h3 style="flex-grow: 1; padding-left: 15px;">System Modules Listing</h3>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#system-module" id="add-system-module">
                Add System Module
            </button>
        </div>
        <div id="gridContainer" style="min-width: 100%;"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="system-module" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content getModelPopup">
                
            </div>
        </div>
    </div>

    <!-- This Modal is use for Delete Confirmation -->
    <div id="confirmDeletePopup"></div>

@endsection

@section('scripts')

    <script>
        $(document).on('focus', ':input', function() {
            $(this).attr('autocomplete', 'off');
        });

        $(document).ready(function() {
            $('#system-module').on('hidden.bs.modal', function() {
                $(this).find('.errorClass').hide();
                $('#general-error').hide();
            });

            $(document).on('click', '#save-system-module', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('system-modules.store') }}',
                    type: "POST",
                    data: $('form.save-system-module').serialize(),
                    success: function(data) {
                        if (data.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#system-module"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });
            });

            $(document).on('click', '#update-system-module', function(event) {
                event.preventDefault();
                var actionUrl = $('.update-system-module-form').attr('action');
                $.ajax({
                    url: actionUrl,
                    type: "PUT",
                    data: $('form.update-system-module-form').serialize(),
                    success: function(data) {
                        if (data.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            modalSetValidation($("#system-module"), xhr);
                        } else {
                            console.error('An unexpected error occurred:', xhr);
                        }
                    }
                });
            });

            $(document).on('click', '#add-system-module', function(event) {
                $.ajax({
                    url: '{{ route('system-modules.create') }}',
                    type: "GET",
                    data:{},
                    success: function(data) {
                        console.log(data);
                        $('.getModelPopup').html(data);
                        $('.dims-select2').select2({
                            theme: 'bootstrap-5',
                            dropdownParent: $('#system-module'),
                        });
                    }
                });
            });

            $.ajax({
                url: '{{ route('system-modules.get-system-modules') }}',
                type: "GET",
                success: function(data) {
                    console.log(data);
                    $("#gridContainer").dxDataGrid({
                        dataSource: data, // as json
                        showBorders: true,
                        hoverStateEnabled: true,
                        filterRow: { visible: true },
                        filterPanel: { visible: true },
                        headerFilter: { visible: true },
                        allowColumnResizing: true,
                        columnAutoWidth: true,
                        scrolling: { rowRenderingMode: 'infinite' },
                        paging: { pageSize: 10 },
                        pager: {
                            visible: true,
                            allowedPageSizes: [5, 10, 20, 50, 'all'],
                            showPageSizeSelector: true,
                            showInfo: true,
                            showNavigationButtons: true,
                        },
                        export: { enabled: true },
                        onExporting(e) {
                            const workbook = new ExcelJS.Workbook();
                            const worksheet = workbook.addWorksheet('System Modules');
                            DevExpress.excelExporter.exportDataGrid({
                                component: e.component,
                                worksheet,
                                autoFilterEnabled: true,
                            }).then(() => {
                                workbook.xlsx.writeBuffer().then((buffer) => {
                                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'System Modules.xlsx');
                                });
                            });
                            e.cancel = true;
                        },
                        columns: [
                            { 
                                dataField: "intAutoId", 
                                caption: "ID",
                                allowEditing: false, 
                                alignment: "left", 
                                width: '10%' 
                            },
                            {
                                dataField: "strName", 
                                caption: "Name", 
                                alignment: "left" 
                            },
                            {
                                dataField: "strSlug", 
                                caption: "Slug Name", 
                                alignment: "left" 
                            },
                            { 
                                dataField: "ParentIdName", 
                                caption: "Parents Name", 
                                alignment: "left" 
                            },
                            {
                                cellTemplate: function(container, options) {
                                    const buttonWrapper = $('<div>')
                                        .css({
                                            'display': 'flex',
                                            'justify-content': 'flex-end',
                                            'gap': '5px'
                                        })
                                        .appendTo(container);

                                    // Edit button
                                    $('<i>')
                                        .addClass('dx-icon-edit')
                                        .css({ 'cursor': 'pointer', 'color': '#e63f2d' })
                                        .on('click', function() {
                                            let intAutoId = options.data.intAutoId;
                                            openDeletePopup(intAutoId);
                                        })
                                        .appendTo(buttonWrapper);

                                    // Delete button
                                    $('<i>')
                                        .addClass('dx-icon-trash')
                                        .css({ 'cursor': 'pointer', 'color': '#e63f2d' })
                                        .on('click', function() {
                                            let intAutoId = options.data.intAutoId;
                                            $("#confirmDeletePopup").data("intAutoId", intAutoId).dxPopup("show");
                                        })
                                        .appendTo(buttonWrapper);
                                }
                            },
                        ],
                        onRowUpdated(e) {
                            console.log(e);
                        },
                        onRowDblClick: function(e) {},
                        onRowClick: function(e) {},
                    });
                }
            });

            // Initialize the confirmation popup
            $("#confirmDeletePopup").dxPopup({
                width: 350,
                height: 'auto',
                visible: false,
                dragEnabled: false,
                closeOnOutsideClick: true,
                showTitle: false, // Add this line to remove the header
                contentTemplate: function() {
                    return $("<div>")
                        .addClass("dx-dialog-message")
                        .text("Are you sure you want to delete this record?");
                },
                toolbarItems: [{
                    widget: "dxButton",
                    toolbar: "bottom",
                    location: "after",
                    options: {
                        text: "YES",
                        type: "danger",
                        onClick: function() {
                            let intAutoId = $("#confirmDeletePopup").data("intAutoId");
                            $.ajax({
                                url: '{{ route('system-modules.destroy', ':id') }}'.replace(':id', intAutoId),
                                type: "DELETE",
                                data: { intAutoId: intAutoId },
                                success: function(data) {
                                    if (data.success) {
                                        location.reload();
                                    } else {
                                        alert('Error deleting the record.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("Error deleting data:", status, error);
                                }
                            });
                            $("#confirmDeletePopup").dxPopup("hide");
                        }
                    }
                }, 
                {
                    widget: "dxButton",
                    toolbar: "bottom",
                    location: "after",
                    options: {
                        text: "NO",
                        onClick: function() {
                            $("#confirmDeletePopup").dxPopup("hide");
                        }
                    }
                }]
            });
        });

        function openDeletePopup(intAutoId) {
            $.ajax({
                url: '{{ route('system-modules.edit', ':intAutoId') }}'.replace(':intAutoId', intAutoId),
                type: "GET",
                success: function(data) {
                    $('.getModelPopup').html(data); // Populate the modal body
                    $('#system-module').modal('show'); // Show the modal

                    // Initialize any select2 elements if necessary
                    $('.dims-select2').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#system-module'),
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", status, error);
                }
            });
        }


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
