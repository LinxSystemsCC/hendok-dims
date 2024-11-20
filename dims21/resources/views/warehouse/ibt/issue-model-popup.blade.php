<!-- IBT Issue Modal -->
<div class="modal fade modal-xl" id="IBTIssueModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">Upadet IBT</h1>
                <h3 class="modal-title fs-5" id="txtIBTNumber"></h3>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="inputDate">Date</label>
                            <input type="date" class="form-control w-100 inputDate" id="inputDate">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="strReference">Reference</label>
                            <input  class="form-control w-100 strReference" id="strReference" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="intFromDC">From DC</label>
                            <select class="form-select select2 intFromDC" type="text" id='intFromDC'>
                                <option value="" selected>Select From DC</option>
                                @foreach ($dcData as $val)
                                    <option value="{{ $val->intAutoId }}">{{ $val->strDCName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="intToDC">To DC</label>
                            <select class="form-select select2 intToDC" type="text" id='intToDC'>
                                <option value="" selected>Select To DC</option>
                                @foreach ($dcData as $val)
                                    <option value="{{ $val->intAutoId }}">{{ $val->strDCName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="intGIT">GIT</label>
                            <select class="form-select select2 intGIT" type="text" id='intGIT'>
                                <option value="" selected>Select GIT</option>
                                @foreach ($gitData as $val)
                                    <option value="{{ $val->intLocationNameId }}">{{ $val->strLocationName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="intVariance">Variance</label>
                            <select class="form-select select2 intVariance" type="text" id='intVariance'>
                                <option value="" selected>Select Variance</option>
                                @foreach ($varianceData as $val)
                                    <option value="{{ $val->intLocationNameId }}">{{ $val->strLocationName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row tlNumber">
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="strTlNumber">TL Number</label>
                            <input  class="form-control w-100 strTlNumber" id="strTlNumber" required>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <div class="gridIssueProducts"></div>
                </div>
            </div>
            <input type="text" id="intStatus" hidden>

            <div class="modal-footer">
                <button type="button" id="btnUpdateIBT" class="btn btn-success btnUpdateIBT">Update</button>
                <button type="button" class="btn btn-secondary closeIBTModal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function getIssueModalProducts(currentSlectedID) {
        $('#IBTIssueModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#IBTIssueModal'),
            });
        });
        var gridIssueProducts;
        $('#IBTIssueModal').on('shown.bs.modal', function () {
            if (!gridIssueProducts) {
                gridIssueProducts = $(".gridIssueProducts").dxDataGrid({
                    dataSource: new DevExpress.data.CustomStore({
                        key: "intAutoId",

                        load: function (loadOptions) {
                            var IbtHeaderId = currentSlectedID;

                            // Make AJAX call to get the data
                            return $.ajax({
                                url: '{!! url("/getIBTDetails") !!}',
                                type: 'GET',
                                data: {
                                    IbtHeaderId: IbtHeaderId,
                                    skip: loadOptions.skip,
                                    take: loadOptions.take,
                                    sort: loadOptions.sort,
                                    filter: loadOptions.filter
                                },
                                success: function (data) {
                                    return {
                                        data: data,
                                        totalCount: data.length
                                    };
                                },
                                error: function () {
                                    alert("Error loading data.");
                                }
                            });
                        },
                    }),

                    hoverStateEnabled: true,
                    showBorders: true,
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    scrolling: {
                        rowRenderingMode: 'infinite',
                    },
                    paging: {
                        pageSize: 10,
                    },
                    columns: [
                        {
                            dataField: "PastelCode", 
                            caption: "Item Code",
                            allowEditing: false,
                        },
                        {
                            dataField: "PastelDescription",
                            caption: "Pastel Description",
                            allowEditing: false,
                        },
                        {
                            dataField: "Qty",
                            caption: "QtyIssue",
                        },
                        {
                            dataField: "Weight",
                            caption: "Weight",
                            dataType: 'number',
                        },
                        {
                            dataField: "Comment",
                            caption: "Comment",
                        }
                    ],
                    onToolbarPreparing: function (e) {
                        e.toolbarOptions.items.unshift(
                            {
                                location: 'before',
                                template: function () {
                                    return $('<h5>').text('PRODUCTS');
                                }
                            }
                        );
                    }
                }).dxDataGrid('instance');
            } else {
                gridIssueProducts.refresh();
            }
        });
    }
</script>