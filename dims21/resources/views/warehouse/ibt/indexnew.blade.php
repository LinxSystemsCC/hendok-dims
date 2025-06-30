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

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Email Report Recipients</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
        </div>
        <div id="gridContainer"></div>
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
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="intUserId" class="form-label">Username</label>
                        <select id="intUserId" name="intUserId" class="form-select select2-user" style="width: 100%"
                            required>
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->UserID }}" data-email="{{ $user->Email }}">
                                    {{ $user->UserName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="strEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="strEmail" name="strEmail" required>
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
            const grid = $('#gridContainer').dxDataGrid({
                dataSource: @json($data),
                keyExpr: 'intAutoId',
                showBorders: true,
                paging: {
                    pageSize: 5  // 👈 change to 10 or whatever you prefer
                },

                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [5, 10, 20],
                    showInfo: true,
                    showNavigationButtons: true
                },
                searchPanel: { visible: true, width: 240, placeholder: "Search..." },
                filterRow: { visible: true },
                columns: [
                    { dataField: 'strType', caption: 'Type' },
                    { dataField: 'strEmail', caption: 'Email' },
                    { dataField: 'intUserId', caption: 'User ID' },
                    { dataField: 'dtmCreated', caption: 'Created At' },
                    {
                        caption: 'Actions',
                        cellTemplate: function (container, options) {
                            const id = options.data.intAutoId;
                            const row = options.data;
                            $('<button class="btn btn-sm btn-primary me-2">Edit</button>')
                                .on('click', function () {
                                    $('#recipientId').val(row.intAutoId);
                                    $('#strType').val(row.strType).trigger('change');
                                    $('#intUserId').val(row.intUserId).trigger('change');
                                    $('#strEmail').val(row.strEmail);
                                    $('#addModal').modal('show');
                                }).appendTo(container);

                            $('<button class="btn btn-sm btn-danger">Delete</button>')
                                .on('click', function () {
                                    if (confirm("Are you sure you want to delete this recipient?")) {
                                        const deleteUrl = "{{ url('/email-recipients/delete') }}/" + id;

                                        $.ajax({
                                            url: deleteUrl,
                                            type: 'POST',
                                            data: {
                                                _token: $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function () {
                                                refreshGrid();
                                            },
                                            error: function (xhr) {
                                                console.error(xhr.responseText);
                                                alert("Error deleting record.");
                                            }
                                        });
                                    }
                                }).appendTo(container);


                        }
                    }
                ]
            }).dxDataGrid('instance');

            // Initialize Select2 dropdowns
            $('.select2').select2({ dropdownParent: $('#addModal') });
            $('.select2-user').select2({ dropdownParent: $('#addModal'), placeholder: "Select user", allowClear: true });

            // Auto-fill email when user changes
            $('#intUserId').on('change', function () {
                const email = $(this).find(':selected').data('email');
                $('#strEmail').val(email || '');
            });

            // Form Submit for Create/Update
            $('#addRecipientForm').on('submit', function (e) {
                e.preventDefault();

                const id = $('#recipientId').val();
                let url = '';

                if (id) {
                    url = `{{ url('/email-recipients/update') }}/${id}`;
                } else {
                    url = "{{ url('/email-recipients/store') }}";
                }

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

            // Fetch and refresh grid
            function refreshGrid() {
                $.get("{{ url('/email-recipients/fetch') }}", function (data) {
                    grid.option('dataSource', data);
                });
            }
        });
    </script>
@endsection