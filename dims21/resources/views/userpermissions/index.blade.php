@extends('layouts.base')

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
</div>

<div>
    <div id="kt_docs_jstree_ajax" class="mt-3"></div>
    <div class="mt-3">
        <button type="button" id="savePermissionsBtn" class="btn btn-success">Save User Permissions</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    const userId = "{{ $userid }}";
    const treeData = {!! $treeData !!};

    // ---- Initialize jsTree (no AJAX) ----
    const $tree = $('#kt_docs_jstree_ajax').jstree({
        core: {
            check_callback: true,
            themes: { responsive: false },
            data: treeData
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

    // ✅ Parent → Child cascade
    $tree.on('select_node.jstree', function (e, data) {
        const tree = $tree.jstree(true);
        const node = data.node;
        if (node.children && node.children.length > 0) {
            node.children.forEach(childId => tree.select_node(childId));
        }
    });

    // ✅ Deselect cascade
    $tree.on('deselect_node.jstree', function (e, data) {
        const tree = $tree.jstree(true);
        const node = data.node;
        if (node.children && node.children.length > 0) {
            node.children.forEach(childId => tree.deselect_node(childId));
        }
    });

    // ✅ Collapse all by default after tree ready
    $tree.on('ready.jstree', function () {
        $(this).jstree('close_all');
    });

    // ✅ Save Permissions
    $('#savePermissionsBtn').on('click', function (e) {
        e.preventDefault();
        const selectedIds = $tree.jstree('get_selected', true).map(node => node.id);

        $.ajax({
            url: '{{ route("saveUserPermissions", ["userid" => "__USER_ID__"]) }}'.replace('__USER_ID__', userId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                permissionIds: selectedIds
            },
            success: function (res) {
                if (res.success) {
                    alert('Permissions saved successfully');
                }
            }
        });
    });
});
</script>
@endsection
