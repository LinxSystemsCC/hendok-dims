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
$(document).ready(function () {
    function getUserIdFromPath() {
        const parts = window.location.pathname.split('/');
        return parts[parts.length - 1];
    }

    const userId = getUserIdFromPath();
    if (!userId) {
        console.error('❌ No user ID found in URL');
        return;
    }

    // ---- Initialize Tree ----
    const $tree = $('#kt_docs_jstree_ajax').jstree({
        core: {
            check_callback: true,
            themes: { responsive: false },
            data: function (node, cb) {
                // Root or children load
                const url = (node.id === '#')
                    ? '{{ route("getPermissionsList", ["userid" => "__USER_ID__"]) }}'.replace('__USER_ID__', userId)
                    : '{{ route("getPermissionsList", ["userid" => "__USER_ID__"]) }}'.replace('__USER_ID__', userId) + '?parent=' + node.id;

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        // Ensure proper state mapping
                        const data = response.map(item => ({
                            id: item.id,
                            text: item.text,
                            children: item.children,
                            icon: item.icon || "ki-outline ki-abstract-13",
                            state: {
                                opened: false,
                                selected: item.state && item.state.selected === true
                            }
                        }));
                        cb(data);
                    },
                    error: function (xhr) {
                        console.error('Tree load failed:', xhr);
                        cb([]);
                    }
                });
            }
        },
        plugins: ['checkbox', 'types', 'wholerow'],
        types: {
            default: { icon: "ki-solid ki-folder text-warning" },
            file: { icon: "ki-solid ki-file text-warning" }
        },
        checkbox: {
            three_state: false,
            cascade: '',
            keep_selected_style: false
        }
    });

    // ---- Prevent jsTree auto-select bug ----
    $tree.on('after_open.jstree', function (e, data) {
        const instance = data.instance;
        data.node.children.forEach(childId => {
            const node = instance.get_node(childId);
            const isSelected = node.original && node.original.state && node.original.state.selected;
            if (!isSelected) {
                instance.uncheck_node(node);
            }
        });
    });

    // ✅ ---- Parent → Children Select Cascade ----
    $tree.on('select_node.jstree', function (e, data) {
        const tree = $tree.jstree(true);
        const node = data.node;
        if (node.children && node.children.length > 0) {
            node.children.forEach(childId => {
                tree.select_node(childId);
            });
        }
    });

    // ✅ ---- Parent → Children Deselect Cascade ----
    $tree.on('deselect_node.jstree', function (e, data) {
        const tree = $tree.jstree(true);
        const node = data.node;
        if (node.children && node.children.length > 0) {
            node.children.forEach(childId => {
                tree.deselect_node(childId);
            });
        }
    });

    // ---- Save Permissions ----
    $('#savescustomername').on('click', function (e) {
        e.preventDefault();

        const tree = $tree.jstree(true);
        const selectedNodes = tree.get_selected(true);

        const childIds = selectedNodes
            .map(n => n.id)
            .filter(id => !isNaN(id) && id !== '#');

        const parentIds = selectedNodes
            .map(n => n.parent)
            .filter(id => !isNaN(id) && id !== '#');

        $.ajax({
            url: '{{ route("saveUserPermissions", ["userid" => "__USER_ID__"]) }}'.replace('__USER_ID__', userId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                childIds: childIds,
                parentIds: parentIds
            },
            success: function (res) {
                if (res.success) {
                    $tree.jstree(true).refresh();
                }
            },
            error: function (xhr) {
                console.error('Save error:', xhr);
            }
        });
    });
});
</script>

@endsection


