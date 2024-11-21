<div class="modal fade modal-xl" id="IBTPlannedModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">IBT Details</h1>
                <h3 class="modal-title fs-5 txtIBTNumber"></h3>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="inputDate">Date</label>
                            <input type="date" class="form-control w-100 inputDate" id="inputDate" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="strReference">Reference</label>
                            <input  class="form-control w-100 strReference" id="strReference" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="intFromDC">From DC</label>
                            <select class="form-select select2 intFromDC" type="text" id='intFromDC' disabled>
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
                            <select class="form-select select2 intToDC" type="text" id='intToDC' disabled>
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
                            <select class="form-select select2 intGIT" type="text" id='intGIT' disabled>
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
                            <select class="form-select select2 intVariance" type="text" id='intVariance' disabled>
                                <option value="" selected>Select Variance</option>
                                @foreach ($varianceData as $val)
                                    <option value="{{ $val->intLocationNameId }}">{{ $val->strLocationName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <div class="gridIssueProducts"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeIBTModal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function getPlannedModalProducts(currentSlectedID, date, reference, fromDc, toDc, git, variance) {
        $('#IBTPlannedModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#IBTPlannedModal'),
            });
        });
        var gridIssueProducts;
        $('.inputDate').val(date);
        $('.strReference').val(reference);
        $('.intFromDC').val(fromDc);
        $('.intToDC').val(toDc);
        $('.intGIT').val(git);
        $('.intVariance').val(variance);
        $('#IBTPlannedModal').on('shown.bs.modal', function () {
            $('.txtIBTNumber').text('IBT' + (1000000 + currentSlectedID).toString().slice(-6));
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