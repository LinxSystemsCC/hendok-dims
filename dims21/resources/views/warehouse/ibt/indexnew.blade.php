@extends('layouts.base')

@section('title', 'Email Report Recipients')
@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@php $includeMenu = true; @endphp

@section('page')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div id="gridContainer"></div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addRecipientForm" class="modal-content">
                @csrf
                <input type="hidden" id="recipientId" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Recipient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="strType" class="form-label">Type</label>
                        <select id="strType" name="strType" class="form-select select2" style="width: 100%" required>
                            <option value="">Select Type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->strEmailType }}">{{ $type->strEmailType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="intUserId" class="form-label">Username</label>
                        <select id="intUserId" name="intUserId" class="form-select select2-user" style="width: 100%" required>
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->UserID }}" data-email="{{ $user->Email }}">{{ $user->UserName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="strEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="strEmail" name="strEmail" required readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            const userMap = @json(collect($users)->mapWithKeys(function($u) { return [$u->UserID => $u->Email]; }));

            const grid = $('#gridContainer').dxDataGrid({
                dataSource: @json($data),
                keyExpr: 'intAutoId',
                showBorders: true,
                paging: { pageSize: 10 },
                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [10, 20],
                    showInfo: true,
                    showNavigationButtons: true
                },
                searchPanel: { visible: true, width: 240, placeholder: "Search..." },
                filterRow: { visible: true },
                editing: {
                    mode: 'popup',
                    allowUpdating: true,
                    allowDeleting: true,
                    useIcons: true,
                    popup: {
                        showTitle: true,
                        title: 'Edit Recipient',
                        width: 600,
                        height: 400
                    },
                    form: {
                        items: [
                            {
                                dataField: 'strType',
                                editorType: 'dxSelectBox',
                                editorOptions: {
                                    dataSource: @json($types),
                                    displayExpr: 'strEmailType',
                                    valueExpr: 'strEmailType',
                                    searchEnabled: true
                                }
                            },
                            {
                                dataField: 'intUserId',
                                editorType: 'dxSelectBox',
                                editorOptions: {
                                    dataSource: @json($users),
                                    displayExpr: 'UserName',
                                    valueExpr: 'UserID',
                                    searchEnabled: true,
                                    onValueChanged: function(e) {
                                        const selectedUser = userMap[e.value];
                                        const rowIndex = grid.getRowIndexByKey(grid.option("editing.editRowKey"));
                                        grid.cellValue(rowIndex, "strEmail", selectedUser || '');
                                    }
                                }
                            },
                            'strEmail'
                        ]
                    }
                },
                onRowUpdating: function(e) {
                    const id = e.oldData.intAutoId;
                    $.post(`{{ url('/email-recipients/update') }}/${id}`, {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        strType: e.newData.strType || e.oldData.strType,
                        intUserId: e.newData.intUserId || e.oldData.intUserId,
                        strEmail: e.newData.strEmail || e.oldData.strEmail,
                    }, function () {
                        alert("Updated successfully");
                    });
                },
                onRowRemoving: function(e) {
                    const id = e.data.intAutoId;
                    $.post(`{{ url('/email-recipients/delete') }}/${id}`, {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }, function () {
                        alert("Deleted successfully");
                    });
                },
                toolbar: {
                    items: [
                        {
                            location: 'before',
                            template: () => $('<h4 class="m-0">Email Report Recipients</h4>')
                        },
                        {
                            location: 'after',
                            widget: 'dxButton',
                            options: {
                                icon: 'plus',
                                text: 'Add Email',
                                type: 'default',
                                onClick: function () {
                                    $('#addRecipientForm')[0].reset();
                                    $('#recipientId').val('');
                                    $('.select2').val('').trigger('change');
                                    $('.select2-user').val('').trigger('change');
                                    $('#strEmail').val('');
                                    $('#addModal').modal('show');
                                }
                            }
                        }
                    ]
                },
                columns: [
                    { dataField: 'strType', caption: 'Type' },
                    {
                        dataField: 'intUserId',
                        caption: 'User ID',
                        lookup: {
                            dataSource: @json($users),
                            valueExpr: 'UserID',
                            displayExpr: 'UserName'
                        }
                    },
                    { dataField: 'strEmail', caption: 'Email' }
                ]
            }).dxDataGrid('instance');

            $('.select2').select2({ dropdownParent: $('#addModal') });
            $('.select2-user').select2({
                dropdownParent: $('#addModal'),
                placeholder: "Select user",
                allowClear: true
            });

            $('#intUserId').on('change', function () {
                const email = $(this).find(':selected').data('email');
                $('#strEmail').val(email || '');
            });

            $('#addRecipientForm').on('submit', function (e) {
                e.preventDefault();

                const id = $('#recipientId').val();
                const url = id ? `{{ url('/email-recipients/update') }}/${id}` : `{{ url('/email-recipients/store') }}`;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function () {
                        $('#addModal').modal('hide');
                        $('#addRecipientForm')[0].reset();
                        $('.select2').val(null).trigger('change');
                        $('.select2-user').val(null).trigger('change');
                        refreshGrid();
                    },
                    error: function () {
                        alert("Error saving data.");
                    }
                });
            });

            function refreshGrid() {
                $.get("{{ url('/email-recipients/fetch') }}", function (data) {
                    grid.option('dataSource', data);
                });
            }
        });
    </script>
@endsection
