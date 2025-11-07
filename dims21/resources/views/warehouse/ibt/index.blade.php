@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'IBT')

{{-- Set to show navbar --}}
@php
    $includeMenu = true;
@endphp

@section('page')
    <!-- Flexdatalist -->
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet" type='text/css'>

    <style>
        .grid {
            height: 100%;
            max-height: 100%;
        }
    </style>

    <div class="col-md-12 h-100">

        <div class="grid" id="gridIBT"></div>

        <!-- IBT Modal -->
        <div class="modal fade modal-xl extra-large" id="IBTModal" tabindex="-1" aria-labelledby="newuserLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newuserLabel">Create IBT</h1>
                        <h3 class="modal-title fs-5 txtIBTNumber" id="txtIBTNumber"></h3>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputDate">Date</label>
                                    <div id="inputDate"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="strReference">Reference</label>
                                    <input class="form-control w-100 strReference" id="strReference" required>
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="intVariance">Variance</label>
                                    <select class="form-select select2 intVariance" type="text" id='intVariance'>
                                        <option value="" selected>Select Variance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 tlnumber_container">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="strTlNumber">TL Number</label>
                                    <input class="form-control w-100 strTlNumber" id="strTlNumber" required>
                                </div>
                            </div>
                            <div class="col-6 receiving_bin_container">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="intReceivingBin">Receiving Bin</label>
                                    <select class="form-select select2 intReceivingBin" type="text" id='intReceivingBin'>
                                        <option value="" selected>Select Receiving Bin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-inline-flex border bg-light mt-3 mb-3 mx-1 modal-lg add_product_section">
                            <label class="control-label fw-bold">By Products</label>
                            <div class="col-2 pe-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductCode">Code</label>
                                    <input type="text" class="form-control rounded-0 rounded-start" id="inputProductCode">
                                </div>
                            </div>
                            <div class="col-3 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductDescription">Description</label>
                                    <input type="text" class="form-control rounded-0" id="inputProductDescription">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductQtyAvl" id="int-qty">Qty Avl</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductQtyAvl">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductQty" id="int-qty">Qty</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductQty">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductWeight">Weight</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductWeight" readonly>
                                </div>
                            </div>
                            <div class="col-3 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductComment">Comment</label>
                                    <input type="text" class="form-control rounded-0" id="inputProductComment">
                                </div>
                            </div>
                            <div class="col-1 ps-0">
                                <div class="form-group mb-2">
                                    <label class="control-label">&nbsp;</label>
                                    <button class="btn btn-success rounded-0 rounded-end w-100"
                                        id="btnAddProduct">ADD</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="gridProducts"></div>
                        </div>
                    </div>
                    <input type="text" id="intStatus" hidden>

                    <div class="modal-footer">
                        <button type="button" id="btnCancelIBT" class="btn btn-warning">Cancel</button>
                        <button type="button" class="btn btn-secondary closeIBTModal" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="btnUpdateIBT" class="btn btn-success" hidden>Update</button>
                        <button type="button" id="btnSaveIBT" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- For Recieveing Popo --}}
<div id="popupReceive">

    <!-- Truck Load (filtered by DC) -->
    <div class="dx-field">
        <div class="dx-field-label">Truck Load</div>
        <div class="dx-field-value">
            <div id="selectReceivingTruckLoads"></div>
        </div>
    </div>


    <!-- DC -->
    <div class="dx-field">
        <div class="dx-field-label">DC</div>
        <div class="dx-field-value">
            <div id="selectReceivingDC"></div>
        </div>
    </div>


    <!-- Warehouse (filtered by DC) -->
    <div class="dx-field">
        <div class="dx-field-label">Warehouse</div>
        <div class="dx-field-value">
            <div id="selectReceivingWarehouse"></div>
        </div>
    </div>

    <!-- Receiving Bin (filtered by Warehouse) -->
    <div class="dx-field">
        <div class="dx-field-label">Receiving Bin</div>
        <div class="dx-field-value">
            <div id="selectReceivingBin"></div>
        </div>
    </div>

    <!-- Grid for quantities -->
    <div id="gridReceiveQtys"></div>
</div>



@endsection

@section('scripts')
    <!-- Flexdatalist -->
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script> 
    <script>
        var products = JSON.parse(JSON.stringify({!! json_encode($products) !!}));
        var allBins = @json($bins);
        let dcList = {!! json_encode($dcData) !!};
        


        const selectReceivingDC = $("#selectReceivingDC").dxSelectBox({
            dataSource: [...new Map(allBins.map(bin => [bin.intDcId, bin])).values()],
            valueExpr: 'intDcId',
            displayExpr: 'strDCName',
            placeholder: 'Select DC',
            onValueChanged(e) {
                const dcId = e.value;

                const warehouses = [...new Map(allBins
                    .filter(x => x.intDcId === dcId)
                    .map(x => [x.intLocationId, x])
                ).values()];

                selectReceivingWarehouse.option('items', warehouses);
                selectReceivingWarehouse.option('value', null);
                selectReceivingBin.option('items', []);
                selectReceivingBin.option('value', null);

                
                    // 👇 Trigger the warehouse dropdown's onValueChanged manually
                    selectReceivingWarehouse._options.onValueChanged({ value: warehouses[0]?.intLocationId || null });
            }
        }).dxSelectBox("instance");

        const selectReceivingWarehouse = $("#selectReceivingWarehouse").dxSelectBox({
            valueExpr: 'intLocationId',
            displayExpr: 'strLocationName',
            placeholder: 'Select Warehouse',
            onValueChanged(e) {
                const selectedDC = selectReceivingDC.option('value');
                const selectedWarehouse = e.value;

                const bins = allBins.filter(
                    x => x.intDcId === selectedDC && x.intLocationId === selectedWarehouse
                );

                selectReceivingBin.option('items', bins);
                selectReceivingBin.option('value', null);
            }
        }).dxSelectBox("instance");

        const selectReceivingBin = $("#selectReceivingBin").dxSelectBox({
            valueExpr: 'intBinId',
            displayExpr: 'strBin',
            placeholder: 'Select Bin',
        }).dxSelectBox("instance");


        var productsList = $.map(products, function (item) {
            return {
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                Weight: item.Weight,
                qtyavl: item.qtyavl
            };
        });
        var gridProducts;
        var selectedStatus = "";
        var SelectedIbtHeaderId = null;
        var selectedIBTRowDetails = null;
        var inputDateElement = null;

        $(document).ready(function () {
            inputDateElement = $("#inputDate").dxDateBox({
                type: "datetime", // This will allow selecting both date and time
                displayFormat: "dd-MM-yyyy HH:mm:ss", // Customize the display format
                value: new Date(), // Optional: Set initial value to current date and time
                // Define the onValueChanged event
                onValueChanged: function (e) {
                    var newValue = e.value;
                }
            }).dxDateBox("instance");
            $('#IBTModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#IBTModal'),
                });
            });
            //This is use for disply the IBT list
            let showReceivedButton = true;
            const gridIBT = $("#gridIBT").dxDataGrid({
                dataSource: [],
                hoverStateEnabled: true,
                showBorders: true,
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
                selection: {
                    mode: "single",
                    rowCssClass: 'custom-selected-row'
                },
                export: {
                    enabled: true
                },
                onExporting(e) {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('IBT');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet,
                        autoFilterEnabled: true,
                    }).then(() => {
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'IBT.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columns: [{
                    dataField: "intAutoId",
                    caption: "IBT ID",
                    customizeText: function (cellInfo) {
                        var IbtHeaderId = cellInfo.value;
                        var numericPart = (100000 + IbtHeaderId).toString().slice(-6);
                        return 'IBT' + numericPart;
                    },
                },
                {
                    dataField: "strReference",
                    caption: "Reference",
                },
                {
                    dataField: "strDCName",
                    caption: "From DC",
                },
                {
                    dataField: "toDCName",
                    caption: "To DC",
                },
                {
                    dataField: "gitBinName",
                    caption: "GIT",
                },
                {
                    dataField: "varianceBinName",
                    caption: "Variance",
                    visible: false,
                },
                {
                    dataField: "intStatus",
                    caption: "Status Id",
                    visible: false,
                },
                {
                    dataField: "strStatus",
                    caption: "Status",
                },
                {
                    dataField: "IssuedBy",
                    caption: "Requested By",
                },
                {
                    dataField: "dtmCreated",
                    caption: "Requested Date",
                    customizeText: function (cellInfo) {
                        const date = new Date(cellInfo.value);
                        if (!isNaN(date)) {
                            return formatDateDDMMYYY(date);
                        }
                        return cellInfo.value;
                    }
                },
                {
                    dataField: "intAutoRecieveId",
                    caption: "Receiving ID",
                    customizeText: function (cellInfo) {
                        if (cellInfo.value != null) {
                            var numericPart = (100000 + parseInt(cellInfo.value, 10)).toString()
                                .slice(-6);
                            return 'IBTRC' + numericPart;
                        }
                        return '-';
                    },
                },
                {
                    dataField: "ReceivedBy",
                    caption: "Received By",
                    customizeText: function (cellInfo) {
                        if (cellInfo.value != null) {
                            return cellInfo.value;
                        }
                        return '-';
                    }
                },
                {
                    dataField: "dtmReceived",
                    caption: "Received Date",
                    customizeText: function (cellInfo) {
                        if (cellInfo.value != null) {
                            const date = new Date(cellInfo.value);
                            if (!isNaN(date)) {
                                return formatDateDDMMYYY(date);
                            }
                        }
                        return '-';
                    }
                },
                {
                    dataField: "strTlNumber",
                    caption: "TL Number",
                    visible: false,
                },
                {
                    dataField: "intReceivingBin",
                    caption: "Receiving Bin",
                    visible: false,
                },
                ],
                onRowRemoving: function (e) { },
                // onToolbarPreparing should manage toolbar items based on the flag
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function () {
                            return $('<h3>').text('IBT');
                        }
                    });
                    e.toolbarOptions.items.push({
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            icon: "fa fa-plus",
                            text: "ADD",
                            onClick: function () {
                                modalPopupShow('add');
                            },
                        },
                    });
                    let receivedButton = {
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            text: "Receive",
                            onClick: function () {
                                    // console.log("🔍 Selected IBT Details:", selectedIBTRowDetails);

                                // modalPopupShow('received', selectedIBTRowDetails);
                                loadingPanel.option('visible', true);
                                $.ajax({
                                    url: '{{ url('ibt/get-bins') }}',
                                    type: "GET",
                                    data: {
                                        is_to_dc: true,
                                        dc_id: selectedIBTRowDetails.data.intToDC,
                                    },
                                    success: function (data) {
                                        if (data.receivingBins) {
                                            selectReceivingBin.option('dataSource', data.receivingBins)
                                        }
                                    },
                                    complete: function () {
                                        loadingPanel.option('visible', false);
                                    }
                                });
                                $.ajax({
                                    url: '{!! url('/getIssuedIBTTruckLoads') !!}',
                                    type: 'GET',
                                    data: {
                                        IbtHeaderId: selectedIBTRowDetails.data.intAutoId
                                    },
                                    success: function (data) {
                                        if (data) {
                                            selectReceivingTruckLoads.option('dataSource', data)
                                        }
                                    },
                                    complete: function () {
                                        // Hide the loading panel
                                        loadingPanel.option('visible', false);
                                        popupReceive.show();
                                    }
                                });


                            },
                        }
                    };
                    if (showReceivedButton) {
                        e.toolbarOptions.items.push(receivedButton);
                    }
                },
                onRowDblClick: function (e) {
					//console.debug(e.data);
                    if (e.data.intStatus == "0") {
                        modalPopupShow('update', e);
                    } else if (e.data.intStatus == "3") {

                        modalPopupShow('received', e);
                    } else {
                        modalPopupShow('show', e);
                    }
                },
                onRowClick: function (e) {
					  
                    showReceivedButton = true;
                    selectedStatus = e.data.strStatus;
                    SelectedIbtHeaderId = e.data.intAutoId;
                    selectedIBTRowDetails = e;
                },
            }).dxDataGrid('instance');

            //This is use for display the Products list
            gridProducts = $(".gridProducts").dxDataGrid({
                dataSource: [], //as json
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
                editing: {
                    mode: "cell",
                    allowUpdating: true,
                    allowDeleting: true,
                },
                columns: [{
                    dataField: "PastelCode",
                    caption: "Item Code",
                    allowEditing: false,
                },
                {
                    dataField: "PastelDescription",
                    caption: "Item Description",
                    allowEditing: false,
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing: false,
                },
                {
                    dataField: "Weight",
                    caption: "Weight",
                    allowEditing: false,
                    dataType: 'number',
                },
                {
                    dataField: "Comment",
                    caption: "Comment",
                    allowEditing: false,
                },
                {
                    dataField: "bitIsPriority",
                    caption: "Priority",
                    allowEditing: true,
                    dataType: 'boolean',
                        calculateCellValue: function(rowData) {
                        return rowData.bitIsPriority == 1; 
                    }
                },
                {
                    dataField: "mnyQtyReceived",
                    caption: "Qty Received",
                    allowEditing: false,
                },
                {
                    dataField: "mnyQtyVariance",
                    caption: "Qty Variance",
                    allowEditing: false,
                },
                {
                    type: "buttons",
                    buttons: [
                        {
                            hint: "Delete",
                            icon: "trash",
                            visible: function (e) {
                                return !e.row.data.strHasBeenModified  || e.row.data.strHasBeenModified.length < 2;
                            },
                            onClick: function (e) {
                                    gridProducts.deleteRow(e.row.rowIndex);
                            }
                        }
                    ]
                }
                ],
                summary: {
                    totalItems: [{
                        column: 'Weight',
                        summaryType: 'sum',
                        valueFormat: 'number',
                        customizeText: function (itemInfo) {
                            let value = itemInfo.value.toFixed(3);
                            return `Total Weight: ${value}`;
                        }
                    }]
                },
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function () {
                            return $('<h5>').text('PRODUCTS');
                        }
                    });
                },
                onRowUpdating: function (e) {
                    console.log(e)
                    // Check if the updated field is 'mnyQtyReceived'
                    var updatedField = e.newData
                        .mnyQtyReceived; // Get the new value of 'mnyQtyReceived'
                    var oldQtyReceived = e.oldData
                        .mnyQtyReceived; // Get the old value of 'mnyQtyReceived'

                    // If 'mnyQtyReceived' was updated, calculate 'mnyQtyVariance'
                    if (updatedField !== oldQtyReceived) {
                        var qty = e.oldData.Qty || 0; // Assuming 'Qty' is the base quantity
                        var mnyQtyReceived = e.newData.mnyQtyReceived || 0;

                        // Calculate the variance
                        var mnyQtyVariance = qty - mnyQtyReceived;

                        // Update the 'mnyQtyVariance' value
                        e.newData.mnyQtyVariance = mnyQtyVariance;
                    }
                },
                onRowRemoved: function (e) {
                $.ajax({
                    url: '{!! url('ibt/delete-ibt-line') !!}', 
                    type: 'POST',
                    data: {
                        intAutoId: e.data.intAutoId
                    },
                    success: function (data) {
                    },
                    error: function () {
                        alert("Error deleting record.");
                    }
                });
            },


                onRowUpdated: function (e) {
                    return $.ajax({
                        url: '{!! url('ibt/update-ibt-lines') !!}',
                        type: 'POST',
                        data: {
                            intAutoId: e.data.intAutoId,
                            mnyQtyReceived: e.data.mnyQtyReceived,
                            mnyQtyVariance: e.data.mnyQtyVariance,
                        },
                        success: function (data) {
                            // console.log("Update success:", data);
                            return data;
                        },
                        error: function () {
                            alert("Error updating record.");
                        }
                    });
                },
                onContentReady: function (e) {
                    setTimeout(function () {
                        focusOnFirstBlankCell(e);
                    }, 500);
                },
            }).dxDataGrid('instance');

            setProductsDataList(productsList);

            //change qty Weight wiil change with use of this function
            $('#inputProductQty').on('change', function () {
                var qty = parseFloat($('#inputProductQty').val()) || 0; // Ensure qty is a valid number
                var selectedProductCode = $('#inputProductCode').flexdatalist('value');

                // Find the corresponding product based on the selected PastelCode
                var selectedProduct = products.find(item => item.PastelCode === selectedProductCode);

                if (selectedProduct) {
                    // Calculate the new weight based on the quantity
                    var calculatedWeight = qty * selectedProduct.Weight;

                    // Set the calculated weight in the input field
                    $('#inputProductWeight').val(calculatedWeight.toFixed(3));
                }
            });

            //This function is use for Save IBT product
            $('#btnAddProduct').click(function () {
                if (!isValidationOccurOnAddProduct()) {
                    var PastelCode = $('#inputProductCode').val();
                    var PastelDescription = $('#inputProductDescription').val();
                    var Weight = $('#inputProductWeight').val();
                    var Qty = $('#inputProductQty').val();
                    var Comment = $('#inputProductComment').val();
                    // if (parseFloat(Qty) > parseFloat($('#inputProductQtyAvl').val())) {
                    //     alert("We're sorry, but the quantity you've requested exceeds our current stock, so we can't process request!");
                    // } else {
                    // }
                    $('#inputProductCode').val('');
                    $('#inputProductDescription').val('');
                    $('#inputProductWeight').val(0);
                    $('#inputProductQty').val(0);
                    $('#inputProductComment').val('');
                    $('#inputProductQtyAvl').val(0);
                    var newRow = {
                        PastelCode: PastelCode,
                        PastelDescription: PastelDescription,
                        Qty: Qty,
                        Weight: Weight,
                        Comment: Comment
                    };

                    if (gridProducts) {
                        var dataSource = gridProducts.getDataSource();
                        dataSource.store().insert(newRow);
                        dataSource.reload();
                    } else {
                        console.log('Datagrid not found.');
                    }
                }
            });

            //This function is use for Save IBT data with product and convet product to xml and append into formData
            $('#btnSaveIBT').click(function () {
                if (!isValidationOccurOnCreate()) {
                    loadingPanel.option('visible', true);
                    var checkedLines = Array();
                    checkedLines = gridProducts.option('dataSource');
                    var gridResults = '<xml>';
                    $.each(checkedLines, function (key, value) {
                        if (value.Qty != undefined || value.Qty != null) {
                            gridResults = gridResults + "<result>";
                            gridResults = gridResults + "<PastelCode>" + escapeHtml(value
                                .PastelCode) + "</PastelCode>";
                            gridResults = gridResults + "<Qty>" + value.Qty + "</Qty>";
                            gridResults = gridResults + "<Weight>" + value.Weight + "</Weight>";
                            gridResults = gridResults + "<Comment>" + escapeHtml(value.Comment) +
                                "</Comment>";
                            gridResults = gridResults + "<bitIsPriority>" + escapeHtml(value.bitIsPriority) +
                                "</bitIsPriority>";
                            gridResults = gridResults + "</result>";
                        }
                    });
                    gridResults = gridResults + "</xml>";

                    var formData = new FormData();
                    // Append the other form data to the FormData object
                    formData.append('dataxml', gridResults);
                    formData.append('dtmCreated', formatDateYYYYMMDD(inputDateElement.option("value")));
                    formData.append('strReference', $('#strReference').val());
                    formData.append('intFromDC', $('#intFromDC').val());
                    formData.append('intToDC', $('#intToDC').val());
                    formData.append('intGIT', $('#intGIT').val());
                    formData.append('intVariance', $('#intVariance').val());
                    formData.append('intStatus', $('#intStatus').val());

                    $.ajax({
                        url: '{!! url('/ibt') !!}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            loadingPanel.option('visible', true);
                            location.reload();
                        },
                        complete: function () {
                            // Hide the loading panel
                            loadingPanel.option('visible', false);
                        }
                    });
                }
            });
            $('#btnCancelIBT').click(function () {
            // Show confirmation dialog
            var confirmed = confirm("Are you sure you want to cancel this IBT?");

            if (!confirmed) {
                return; // Exit the function if user selects "No"
            }

            loadingPanel.option('visible', true);

            var formData = new FormData();
            formData.append('SelectedIbtHeaderId', SelectedIbtHeaderId);
            formData.append('intStatus', 4);

            $.ajax({
                url: '{!! url('ibt/cancel-ibt') !!}',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    loadingPanel.option('visible', true);
                    location.reload();
                },
                complete: function () {
                    // Hide the loading panel
                    loadingPanel.option('visible', false);
                }
            });
        });


            //This function is use for Update IBT Data with product
            $('#btnUpdateIBT').click(function () {
                if (!isValidationOccurOnCreate()) {
                    loadingPanel.option('visible', true);
                    var checkedLines = Array();
                    checkedLines = gridProducts.option('dataSource');
                    var gridResults = '<xml>';
                    $.each(checkedLines, function (key, value) {
                        if (value.Qty != undefined || value.Qty != null) {
                            gridResults = gridResults + "<result>";
                            gridResults = gridResults + "<PastelCode>" + escapeHtml(value
                                .PastelCode) + "</PastelCode>";
                            gridResults = gridResults + "<Qty>" + value.Qty + "</Qty>";
                            gridResults = gridResults + "<Weight>" + value.Weight + "</Weight>";
                            gridResults = gridResults + "<Comment>" + escapeHtml(value.Comment) +
                                "</Comment>";
                            gridResults = gridResults + "<bitIsPriority>" + escapeHtml(value.bitIsPriority) +
                                "</bitIsPriority>";
                            gridResults = gridResults + "</result>";
                        }
                    });
                    gridResults = gridResults + "</xml>";

                    var formData = new FormData();
                    formData.append('SelectedIbtHeaderId', SelectedIbtHeaderId);
                    formData.append('dataxml', gridResults);
                    formData.append('dtmCreated', formatDateYYYYMMDD(new Date(inputDateElement.option(
                        "value"))));
                    formData.append('strReference', $('.strReference').val());
                    formData.append('intFromDC', $('.intFromDC').val());
                    formData.append('intToDC', $('.intToDC').val());
                    formData.append('intGIT', $('.intGIT').val());
                    formData.append('intVariance', $('.intVariance').val());
                    if ($('#intStatus').val() != '') {
                        formData.append('intStatus', $('#intStatus').val());
                    }
                    if ($('.strTlNumber') != '') {
                        formData.append('strTlNumber', $('.strTlNumber').val());
                    }


                    $.ajax({
                        url: '{!! url('ibt/update-ibt') !!}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            loadingPanel.option('visible', true);
                            location.reload();
                        },
                        complete: function () {
                            // Hide the loading panel
                            loadingPanel.option('visible', false);
                        }
                    });
                }
            });

            getIbtRecords(gridIBT);

            // To clear and close the IBT modal
            $('#IBTModal').on('hidden.bs.modal', function () {
                $('.txtIBTNumber').text('');
                $('#btnUpdateIBT').prop('hidden', true);
                $('.form-control', IBTModal).val('');
                $('.intFromDC').val('');
                $('.intToDC').val('');
                $('.intGIT').val('');
                $('.intVariance').val('');
                gridProducts.option('dataSource', []);
                gridProducts.refresh();
            });

            $('#intFromDC').change(function () {
                if (checkSameDcOrNot($(this))) {
                    getGITBins();
                }
            });

            $('#intToDC').change(function () {
                if (checkSameDcOrNot($(this))) {
                    getVarianceAndReceivingBins();
                }
            });

            const selectReceivingTruckLoads = $("#selectReceivingTruckLoads").dxSelectBox({
                dataSource: [],
                valueExpr: 'intTLNumber',
                displayExpr: 'intTLNumber',
                placeholder: 'Truck Load',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
                onValueChanged: function (e) {
                    loadingPanel.option('visible', true);
                    $.ajax({
                        url: '{!! url('/getIssuedIBTDetails') !!}',
                        type: 'GET',
                        data: {
                            intTLNumber: e.value,
                            intIBTHeaderId: selectedIBTRowDetails.data.intAutoId,
                        },
                        success: function (data) {
                            const updatedData = data.map(row => ({
                                ...row,
                                mnyQtyToReceive: row.mnyQtyToReceive || ''
                            }));

                            gridReceiveQtys.option('dataSource', updatedData);
                            gridReceiveQtys.refresh();
                        },
                        complete: function () {
                            // Hide the loading panel
                            loadingPanel.option('visible', false);
                        }
                    });
                }
            }).dxValidator({
                validationGroup: "recieve",
                validationRules: [{
                    type: 'required',
                    message: 'You need to select a truck Load',
                }],
            }).dxSelectBox("instance");

            const selectReceivingBin = $("#selectReceivingBin").dxSelectBox({
                dataSource: [],
                valueExpr: 'intBinId',
                displayExpr: 'strBin',
                placeholder: 'Bin',
                showSelectionControls: true,
                showClearButton: true,
                width: '100%',
                searchEnabled: true,
            }).dxValidator({
                validationGroup: "recieve",
                validationRules: [{
                    type: 'required',
                    message: 'Bin is required',
                }],
            }).dxSelectBox("instance");

            const gridReceiveQtys = $("#gridReceiveQtys").dxDataGrid({
                dataSource: [], // as JSON
                hoverStateEnabled: true,
                showBorders: true,
                allowColumnResizing: true,
                columnAutoWidth: true,
                keyExpr: "PastelCode",
                wordWrapEnabled: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging: {
                    pageSize: 10,
                },
                editing: {
                    mode: "batch",
                    allowUpdating: true,
                    texts: {
                        save: "", // Hide default save button in the grid
                    },
                },
                columns: [{
                    dataField: "PastelCode",
                    caption: "Item Code",
                    allowEditing: false
                },
                {
                    dataField: "PastelDescription",
                    caption: "Item Description",
                    allowEditing: false
                },
                {
                    dataField: "Qty",
                    caption: "Qty Req.",
                    allowEditing: false
                },
                {
                    dataField: "mnyQtyIssued",
                    caption: "Qty Iss.",
                    allowEditing: false
                },
                {
                    dataField: "mnyQtyReceived",
                    caption: "Qty Rec.",
                    allowEditing: false
                },
                {
                    dataField: "mnyQtyToReceive",
                    caption: "Qty To Rec.",
                    allowEditing: true,
                }
                ],
                onSaving: function (e) {
                    let isValid = true;

                    let rows = e.component.getVisibleRows();
                    rows.forEach(row => {
                        let qtyToReceive = row.data.mnyQtyToReceive;

                        if (qtyToReceive === null || qtyToReceive === undefined ||
                            qtyToReceive === "") {
                            isValid = false;
                            DevExpress.ui.notify(
                                `Invalid quantity to receive for item ${row.data.PastelCode}`,
                                "error", 3000);
                        }
                    });

                    if (!isValid) {
                        e.cancel = true; // Prevent saving if invalid
                        return;
                    }

                    let binValidation = $("#selectReceivingBin").dxValidator("instance").validate();
                    if (!binValidation.isValid) {
                        e.cancel = true;
                        DevExpress.ui.notify("Please select a receiving bin.", "error", 3000);
                        return;
                    }
                },
                onSaved: function (e) {
                    submitReceive(
                        selectedIBTRowDetails.data.intAutoId,
                        gridReceiveQtys.option('dataSource'),
                        selectReceivingBin.option('value'),
                        selectReceivingTruckLoads.option('value')
                    );

                    popupReceive.hide();
                },
                toolbar: {
                    items: [{
                        widget: 'dxButton',
                        toolbar: 'bottom',
                        location: 'after',
                        options: {
                            icon: "save", // You can use "edit", "save", or your own custom icon
                            text: "RECEIVE",
                            onClick: function () {
                                // Manually trigger saving (this will call the onSaving method)
                                gridReceiveQtys.saveEditData(); // Trigger save for batch edit
                            },
                        },
                    }]
                }
            }).dxDataGrid("instance");

            const popupReceive = $('#popupReceive').dxPopup({
                showTitle: true,
                title: 'Receive',
                hideOnOutsideClick: true,
                showCloseButton: true,
                width: 900,
                height: 'auto',
                onHidden: function (e) {
                    gridReceiveQtys.option('dataSource', []);
                    selectReceivingBin.option('dataSource', []);
                },
            }).dxPopup("instance");

        });

        //This function is use for get ibt records
        function getIbtRecords(gridIBT) {
            
            // Ajax call for Get IBT Records
            $.ajax({
                url: '{!! url('/getIBTRecords') !!}',
                type: "GET",
                success: function (data) {
                    gridIBT.option('dataSource', data);
                    gridIBT.refresh();
                }
            });
        }

        //This function is use for set Products list
        function setProductsDataList(products) {
            var inputProductCode = $('#inputProductCode').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                focusFirstResult: true,
                searchContain: true,
                visibleProperties: ["PastelCode", "PastelDescription"],
                searchIn: ["PastelCode", "PastelDescription"],
                data: products
            });
            inputProductCode.on('select:flexdatalist', function (event, data) {
                //fill in inputs of code desc weight, empty qty empty comment..
                $('#inputProductCode').flexdatalist('value', data.PastelCode);
                $('#inputProductDescription').flexdatalist('value', data.PastelDescription);
                if (data.qtyavl != undefined) {
                    $('#inputProductQtyAvl').val(parseFloat(data.qtyavl));
                } else {
                    $('#inputProductQtyAvl').val(0);
                }
                $('#inputProductQty').val(1);
                $('#inputProductWeight').val(parseFloat(data.Weight).toFixed(3));
            });

            var inputProductDescription = $('#inputProductDescription').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                focusFirstResult: true,
                searchContain: true,
                visibleProperties: ["PastelCode", "PastelDescription"],
                searchIn: ["PastelCode", "PastelDescription"],
                data: products
            });
            inputProductDescription.on('select:flexdatalist', function (event, data) {
                //fill in inputs of code desc weight, empty qty empty comment..
                $('#inputProductCode').flexdatalist('value', data.PastelCode);
                $('#inputProductDescription').flexdatalist('value', data.PastelDescription);
                $('#inputProductQty').val(1);
                $('#inputProductWeight').val(parseFloat(data.Weight).toFixed(3));
            });
        }

        //Get IBT Details on time of upadte IBT
        function getGridProducts(IbtHeaderId) {

            loadingPanel.option('visible', true);
            $.ajax({
                url: '{!! url('/getIBTDetails') !!}',
                type: 'GET',
                data: {
                    IbtHeaderId: IbtHeaderId
                },
                success: function (data) {
                    gridProducts.option('dataSource', data);
                    gridProducts.refresh();
                },
                complete: function () {
                    // Hide the loading panel
                    loadingPanel.option('visible', false);
                }
            });
        }

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        };

        function modalPopupShow(action, e) {
            let intGIT = 0;
            let intVariance = 0;
            let intReceivingBin = 0;
            if (e != undefined) {
                selectedStatus = e.data.strStatus;
                SelectedIbtHeaderId = e.data.intAutoId;
            }
            $('#IBTModal').modal('show');
            gridProducts.option("editing.allowDeleting", true);
            if (action != 'add') {
                if (SelectedIbtHeaderId) {
                    var numericPart = (1000000 + SelectedIbtHeaderId).toString().slice(-6);
                    $('.txtIBTNumber').text('IBT' + numericPart);
                }
                inputDateElement.option("value", e.data.dtmCreated);
                $('#strReference').val(e.data.strReference);
                $('#intFromDC').val(e.data.intFromDC);
                $('#intToDC').val(e.data.intToDC);
                $('#intGIT').val(e.data.intGIT);
                $('#intVariance').val(e.data.intVariance);
                $('#strTlNumber').val(e.data.strTlNumber);
                $('#intReceivingBin').val(e.data.intReceivingBin);
                intGIT = e.data.intGIT;
                intVariance = e.data.intVariance;
                intReceivingBin = e.data.intReceivingBin;
                getGridProducts(e.data.intAutoId);
            }
            $('#strTlNumber').attr('disabled', true);
            $(".tlnumber_container").hide();
            $(".receiving_bin_container").hide();
            if (action != 'show') {
                inputDateElement.option("disabled", false);
                $('#strReference').removeAttr('disabled');
                $('#intFromDC').removeAttr('disabled');
                $('#intToDC').removeAttr('disabled');
                $('#intGIT').removeAttr('disabled');
                $('#intVariance').removeAttr('disabled');
                $('#intReceivingBin').removeAttr('disabled');
            }
            if (action == 'add') {
                $('#IBTModal .modal-header .modal-title#newuserLabel').text('Create IBT');
                $('#btnSaveIBT').prop('hidden', false);
                $('#btnUpdateIBT').prop('hidden', true);
                $('.txtIBTNumber').text('');
                $('.form-control', IBTModal).val('');
                $('.intFromDC').val('');
                $('.intToDC').val('');
                $('.intGIT').val('');
                $('.intVariance').val('');
                $(".add_product_section").removeClass('d-none');
                inputDateElement.option("value", new Date());
                gridProducts.option('dataSource', []);
                gridProducts.refresh();
            } else if (action == 'update') {
                $('#newuserLabel').text('Update IBT');
                $('#btnSaveIBT').prop('hidden', true);
                $('#btnUpdateIBT').prop('hidden', false);
                $(".add_product_section").removeClass('d-none');
            } else if (action == 'received') {
                $('#newuserLabel').text('Received IBT');
                $('#btnSaveIBT').prop('hidden', true);
                $('#btnUpdateIBT').prop('hidden', true);
            } else if (action == 'show') {
                $('#newuserLabel').text('IBT Details');
                $('#btnSaveIBT').prop('hidden', true);
                $('#btnUpdateIBT').prop('hidden', true);
                $('#intReceivingBin').attr('disabled', true);
            }
            if (action == 'received' || action == 'show') {
                $(".add_product_section").addClass('d-none');
                gridProducts.option("editing.allowDeleting", false);
                inputDateElement.option("disabled", true);
                $('#strReference').attr('disabled', true);
                $('#intFromDC').attr('disabled', true);
                $('#intToDC').attr('disabled', true);
                $('#intGIT').attr('disabled', true);
                $('#intVariance').attr('disabled', true);
                $(".tlnumber_container").show();
                $(".receiving_bin_container").show();
            }
            gridProducts.columnOption("Qty", "caption", "Qty");
            gridProducts.columnOption("mnyQtyReceived", "visible", false);
            gridProducts.columnOption("mnyQtyVariance", "visible", false);
            if ((e != undefined && e.data.intStatus === "2") || action == 'received') {
                gridProducts.columnOption("Qty", "caption", "Qty Issued");
                gridProducts.columnOption("mnyQtyReceived", "visible", true);
                gridProducts.columnOption("mnyQtyVariance", "visible", true);
            }
            gridProducts.columnOption("mnyQtyReceived", "allowEditing", false);
            if (action == 'received') {
                gridProducts.columnOption("mnyQtyReceived", "allowEditing", false);
            }
            getGITBins(intGIT);
            getVarianceAndReceivingBins(intVariance, intReceivingBin);
        }

        function focusOnFirstBlankCell(e) {
            // console.log(e);
            // console.log("-------------------------------------------------------------------");

            var columnIndex = e.component.columnOption('mnyQtyReceived').index; // Column index for 'mnyQtyReceived'
            var firstBlankCellFound = false;

            // Iterate over all visible rows and check for the first blank cell in the specified column
            e.component.getVisibleRows().forEach(function (row) {
                if (gridProducts.columnOption("mnyQtyReceived", "visible") && !firstBlankCellFound && !row.data
                    .mnyQtyReceived) {
                    firstBlankCellFound = true;
                    var rowIndex = row.rowIndex;
                    var rowElement = e.component.getRowElement(rowIndex);
                    var cellElement = $(rowElement).find('td').eq(columnIndex); // Find the cell in the column
                    $(cellElement).click(); // Simulate a click on the blank cell to focus it
                }
            });
        }

        function getGITBins(intGIT) {
            $('#intGIT').children().not('option:first').remove();

            if ($('#intFromDC').val() != '') {
                let fromDC = $('#intFromDC').val();
                loadingPanel.option('visible', true);


                $.ajax({
                    url: '{{ url('ibt/get-bins') }}',
                    type: "GET",
                    data: {
                        is_from_dc: true,
                        dc_id: fromDC
                    },
                    success: function (data) {
                        console.log("📦 All Bins Received from API:", data);


                        for (let index = 0; index < data.length; index++) {
                            let bin = data[index];

                            let isDisabled = (parseInt(bin.bitActive) === 0 && bin.intBinId != intGIT);

                            console.log(
                                `➡️ Bin: ${bin.strBin}, bitActive: ${bin.bitActive}, intBinId: ${bin.intBinId}, Current intGIT: ${intGIT}, Disabled: ${isDisabled}`
                            );

                            $('#intGIT').append($('<option>', {
                                value: bin.intBinId,
                                text: isDisabled ? `${bin.strBin} (In Use)` : bin.strBin,
                                disabled: isDisabled,
                                style: isDisabled ? 'color: gray;' : ''
                            }));
                        }

                        if (intGIT !== undefined && intGIT !== null) {
                            $('#intGIT').val(intGIT);
                        }
                    },
                    complete: function () {
                        loadingPanel.option('visible', false);
                    }
                });
            }
        }

        function getVarianceAndReceivingBins(intVariance, intReceivingBin) {
            $('#intVariance').children().not('option:first').remove();
            $('#intReceivingBin').children().not('option:first').remove();
            if ($('#intToDC').val() != '') {
                loadingPanel.option('visible', true);
                $.ajax({
                    url: '{{ url('ibt/get-bins') }}',
                    type: "GET",
                    data: {
                        is_to_dc: true,
                        dc_id: $('#intToDC').val()
                    },
                    success: function (data) {
                        if (data.varianceBins) {
                            for (let index = 0; index < data.varianceBins.length; index++) {
                                $('#intVariance').append($('<option>', {
                                    value: data.varianceBins[index].intBinId,
                                    text: data.varianceBins[index].strBin
                                }));
                            }
                        }
                        if (data.receivingBins) {
                            for (let index = 0; index < data.receivingBins.length; index++) {
                                $('#intReceivingBin').append($('<option>', {
                                    value: data.receivingBins[index].intBinId,
                                    text: data.receivingBins[index].strBin
                                }));
                            }
                        }
                        if (intVariance != undefined) {
                            $('#intVariance').val(intVariance);
                        }
                        if (intReceivingBin != undefined) {
                            $('#intReceivingBin').val(intReceivingBin);
                        }
                    },
                    complete: function () {
                        // Hide the loading panel
                        loadingPanel.option('visible', false);
                    }
                });
            }
        }

        function checkSameDcOrNot(curDc) {
            if ($('#intFromDC').val() != '' && $('#intToDC').val() != '' &&
                $('#intFromDC').val() == $('#intToDC').val()
            ) {
                generalAlertPopup('Alert Popup', "You cannot select the same DC for both 'From DC' and 'To DC'.")
                curDc.val('');

                return false;
            }

            return true;
        }

        function isValidationOccurOnCreate() {
            var errors = [];
            if (inputDateElement.option("value") == '') {
                errors.push({
                    message: "Date field is required!"
                });
            }
            if ($("#intFromDC").val() == '') {
                errors.push({
                    message: "From DC field is required!"
                });
            }
            if ($("#intToDC").val() == '') {
                errors.push({
                    message: "To DC field is required!"
                });
            }
            if ($("#intGIT").val() == '') {
                errors.push({
                    message: "GIT field is required!"
                });
            }
            if ($("#intVariance").val() == '') {
                errors.push({
                    message: "Variance field is required!"
                });
            }
            let lines = gridProducts.option("dataSource");
            if (lines.length <= 0) {
                errors.push({
                    message: "Please select at least one product to proceed with the ibt."
                });
            }
            if (errors.length > 0) {
                generalErrorList.option("dataSource", errors);
                generalValidationPopup.show();
                return true;
            }

            return false;
        }

        function isValidationOccurOnAddProduct() {
            var errors = [];
            if ($("#inputProductCode").val() == '') {
                errors.push({
                    message: "Product Code field is required!"
                });
            }
            if ($("#inputProductDescription").val() == '') {
                errors.push({
                    message: "Product Description field is required!"
                });
            }
            if ($("#inputProductQty").val() == '') {
                errors.push({
                    message: "Qty field is required!"
                });
            }
            if (errors.length > 0) {
                generalErrorList.option("dataSource", errors);
                generalValidationPopup.show();
                return true;
            }

            return false;
        }

        function isValidationOccurOnReceive() {
            var errors = [];
            if ($("#intReceivingBin").val() == '') {
                errors.push({
                    message: "Receiving Bin field is required!"
                });
            }
            let lines = gridProducts.option("dataSource");
            if (lines.length > 0) {
                let isLineValidationOccur = false;
                lines.forEach(function (item, index) {
                    if (item) {
                        if (item.mnyQtyReceived == '' || item.mnyQtyReceived == null) {
                            if (!isLineValidationOccur) {
                                errors.push({
                                    message: "Please ensure that the quantity received for all products is filled."
                                });
                                isLineValidationOccur = true;
                            }
                        }
                    }
                });
            }
            if (errors.length > 0) {
                generalErrorList.option("dataSource", errors);
                generalValidationPopup.show();
                return true;
            }

            return false;
        }

        function submitReceive(ibtHeader, lines, bin, intTLNumber) {
            loadingPanel.option('visible', true);
            $.ajax({
                url: '{!! url('/ibt/receive') !!}',
                type: "POST",
                data: {
                    ibtHeader: ibtHeader,
                    lines: lines,
                    bin: bin,
                    intTLNumber: intTLNumber,
                },
                success: function (data) {
                    DevExpress.ui.notify(data.Message, data.Status === "1" ? "success" : "error", 5000);
                    if (data.Status === "1") location.reload();
                },
                complete: function () {
                    // Hide the loading panel
                    loadingPanel.option('visible', false);
                }
            });
        }
    </script>
@endsection