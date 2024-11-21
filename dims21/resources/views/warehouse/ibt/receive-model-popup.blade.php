<!-- IBT Receive Modal -->
<div class="modal fade modal-xl" id="IBTReceiveModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
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
                <div class="row tlNumber" hidden>
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="strTlNumber">TL Number</label>
                            <input  class="form-control w-100 strTlNumber" id="strTlNumber" required>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <div class="gridReceiveProducts"></div>
                </div>
            </div>
            <input type="text" id="intStatus" hidden>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeIBTModal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function ReceivedModalProducts(currentSlectedID, date, reference, fromDc, toDc, git, variance) {
        $('#IBTReceiveModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#IBTReceiveModal'),
            });
        });
        let gridIssueProducts;
        $('.inputDate').val(date);
        $('.strReference').val(reference);
        $('.intFromDC').val(fromDc);
        $('.intToDC').val(toDc);
        $('.intGIT').val(git);
        $('.intVariance').val(variance);
        $('#IBTReceiveModal').on('shown.bs.modal', function () {
            $('.txtIBTNumber').text('IBT' + (1000000 + currentSlectedID).toString().slice(-6));   
            if (!gridIssueProducts) {
                gridIssueProducts = $(".gridReceiveProducts").dxDataGrid({
                    dataSource: new DevExpress.data.CustomStore({
                        key: "intAutoId",
                        load: function (loadOptions) {
                            var IbtHeaderId = currentSlectedID;
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
                                    // Check and populate data if needed
                                    return { data: data, totalCount: data.length };
                                },
                                error: function () {
                                    alert("Error loading data.");
                                }
                            });
                        },
                        update: function (key, values) {
                            var rowData = gridIssueProducts.getDataSource().items().find(item => item.intAutoId === key);
                            if (rowData) {
                                var qty = rowData.Qty; 
                                var qtyReceived = values.intQtyReceived;

                                if (qtyReceived < 0 || isNaN(qtyReceived)) {
                                    DevExpress.ui.notify("Qty Received cannot be less than 0", "error", 3000);
                                    return;
                                }

                                if (qty !== undefined && qtyReceived !== undefined) {
                                    var qtyVariance = qty - qtyReceived;
                                    values.QtyVariance = qtyVariance;
                                    var rowIndex = gridIssueProducts.getDataSource().items().findIndex(item => item.intAutoId === key);
                                    if (rowIndex !== -1) {
                                        gridIssueProducts.cellValue(rowIndex, "QtyVariance", qtyVariance);
                                    }
                                } else {
                                    console.error("Qty or QtyReceived is undefined for row with key:", key);
                                }
                            } else {
                                console.error("Row data not found for key:", key);
                            }
                            return $.ajax({
                                url: '{!! url("update-ibt-lines") !!}',
                                type: 'POST',
                                data: {
                                    key: key,
                                    values: values
                                },
                                success: function (data) {
                                    console.log("Update success:", data);
                                    return data;
                                },
                                error: function () {
                                    alert("Error updating record.");
                                }
                            });
                        },
                        remove: function (key) {
                            return $.ajax({
                                url: '{!! url("delete-ibt") !!}',
                                type: 'DELETE',
                                data: { id: key },
                                success: function () {
                                    return key;
                                },
                                error: function () {
                                    alert("Error deleting record.");
                                }
                            });
                        }
                    }),
                    hoverStateEnabled: true,
                    showBorders: true,
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    editing: {
                        mode: "cell",
                        allowUpdating: true, 
                        allowAdding: false,
                        allowDeleting: false 
                    },
                    paging: {
                        pageSize: 10
                    },
                    columns: [
                        { dataField: "PastelCode", caption: "Item Code", allowEditing: false },
                        { dataField: "PastelDescription", caption: "Pastel Description", allowEditing: false },
                        { dataField: "Qty", caption: "Qty Issue", allowEditing: false },
                        { dataField: "Weight", caption: "Weight", dataType: 'number', allowEditing: false },
                        { dataField: "Comment", caption: "Comment", allowEditing: false },
                        { dataField: "intQtyReceived", caption: "Qty Received" },
                        { dataField: "intQtyVariance", caption: "Qty Variance", allowEditing: false }
                    ]
                }).dxDataGrid('instance');
            } else {
                gridIssueProducts.refresh();
            }
        });
    }

</script>
