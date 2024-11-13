@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'User Permissions')

@php
    $includeMenu = true;
@endphp

@section('page')

<div class="row">
    <div id="message-container" class="col-lg-12" style="display: none;"></div>
    <div class="col-lg-12 d-inline-flex">
        <h3 style="flex-grow: 1; padding-left: 15px;">User Permissions</h3>
    </div>
    <div id="gridContainer" style="min-width: 100%;"></div>
</div>

<div>
    <div id="kt_docs_jstree_ajax" class="mt-3">
    </div>
    <div class="mt-3">
        <button type="button" id="savescustomername" class="btn btn-success">Save User Permissions</button>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            function getUserIdFromPath() {
                const pathSegments = window.location.pathname.split('/');
                const userId = pathSegments[pathSegments.length - 1];
                return userId;
            }
            var userId = getUserIdFromPath();
            if (!userId) {
                console.error("User ID is not available in the URL!");
                return;
            }

            $("#kt_docs_jstree_ajax").jstree({
                "core": {
                    "themes": {
                        "responsive": false
                    },
                    "check_callback": true,
                    'data': {
                        'url': function (node) {
                            return '{{ route('getPermissionsList', ['userid' => '__USER_ID__']) }}'.replace('__USER_ID__', userId);
                        },
                        'data': function (node) {
                            return {
                                'parent': node.id // Send the parent ID to the backend
                            };
                        }
                    }
                },
                "types": {
                    "default": {
                        "icon": "ki-solid ki-folder text-warning"
                    },
                    "file": {
                        "icon": "ki-solid ki-file text-warning"
                    }
                },
                "plugins": ["wholerow", "checkbox", "types"]
            });

            $(document).on('click', '#savescustomername', function(event) {
                event.preventDefault();

                var selectedElms = $('#kt_docs_jstree_ajax').jstree("get_selected", true);

                var childIds = selectedElms.map(function(elm) {
                    if (!isNaN(elm.id) && elm.id !== "#") {
                        return elm.id;
                    }
                }).filter(function(elm) { return elm !== undefined });

                var parentIds = selectedElms.map(function(elm) {
                    if (!isNaN(elm.parent) && elm.parent !== "#") {
                        return elm.parent; 
                    }
                }).filter(function(elm) { return elm !== undefined });

                $.ajax({
                    url: '{{ route('saveUserPermissions', ['userid' => '__USER_ID__']) }}'.replace('__USER_ID__', userId),
                    type: "POST",
                    data: {
                        childIds: childIds,
                        parentIds: parentIds
                    },
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
