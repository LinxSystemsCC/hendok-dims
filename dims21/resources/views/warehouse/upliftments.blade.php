<?php
if (Auth::guest()) {
} else {
    $v = new \App\Http\Controllers\SalesForm();
    $make = $v->getThingsUserPermissions(Auth::user()->UserID, 'Make Voucher');
    $view = $v->getThingsUserPermissions(Auth::user()->UserID, 'View Upliftment Voucher');
    $update = $v->getThingsUserPermissions(Auth::user()->UserID, 'Update Upliftment Voucher');
    $enquiry = $v->getThingsUserPermissions(Auth::user()->UserID, 'Enquire Upliftment Voucher');
    $backlog = $v->getThingsUserPermissions(Auth::user()->UserID, 'View Backlogs Upliftment Voucher');
    $approve = $v->getThingsUserPermissions(Auth::user()->UserID, 'Approve Uplifment Voucher');
    $print = $v->getThingsUserPermissions(Auth::user()->UserID, 'Print Upliftment Voucher');
    $complete = $v->getThingsUserPermissions(Auth::user()->UserID, 'Complete Upliftment Voucher');
    $viewimage = $v->getThingsUserPermissions(Auth::user()->UserID, 'View Image Upliftment Voucher');
}
?>

@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Upliftments')


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

        <div class="grid" id="gridUpliftment"></div>
        <div id="upliftmentLoader"></div>

        <!-- Upliftment Modal -->
        <div class="modal fade modal-xl" id="upliftmentModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newuserLabel">Create/Edit Upliftment</h1>
                        <h3 class="modal-title fs-5" id="txtUpliftNumber"></h3>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputDate">Date</label>
                                    <input type="date" class="form-control w-100" id="inputDate">


                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="selectType">Collection Type</label>
                                    <select class="form-select w-100" id="selectType">
                                        <option value=""></option>
                                        <option value="Hendok Fleet">Hendok Fleet</option>
                                        <option value="Rep Collection">Rep Collection</option>
                                        <option value="Customer Return">Customer Return</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="selectCompany">Company</label>
                                    <select class="form-select w-100" id="selectCompany" style="width: 60%">
                                        <option></option>
                                        @foreach ($companies as $val)
                                            <option value="{{ $val->companyname }}">{{ $val->companyname }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputArea">Selected Area</label>
                                    <input readonly class="form-control w-100" id="inputArea" required>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputAddress">Address Name</label>
                                    <input class="form-control w-100" id="inputAddress" required disabled>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputCustomer">Customer Name</label>
                                    <input class="form-control w-100" id="inputCustomer" required>
                                </div>


                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="selectAltArea">Alternative Area
                                        Selection</label>
                                    <select class="form-select" id="selectAltArea" required>
                                        <option></option>
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputAltAddress">Alternative Address
                                        Name</label>
                                    <input type="text" class="form-control w-100" id="inputAltAddress" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="selectInvoice">Invoices</label>
                                    <select class="form-select" id="selectInvoice">
                                        <option value=""></option>
                                    </select>
                                    <div id="invoiceError" class="invalid-feedback d-none">
                                        *Invoice is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputAltInvoice">Alternative Invoice</label>
                                    <input class="form-control w-100" id="inputAltInvoice" required>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="invoiceDate">Delivery Date</label>
                                <input type="text" class="form-control" id="invoiceDate" name="invoiceDate" readonly>
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="inputPickupReason">Reason for Pickup</label><br>
                            <small id="RequireReason" style="color: red; display: none;">*Reason for Pickup must be at
                                least
                                10 characters.</small>
                            <textarea class="form-control w-100" id="inputPickupReason"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-2">

                                    <label class="control-label fw-bold" for="inputPhoto3">Upload
                                        documents</label><br><small id="RequireVal"
                                        style="color: red; display: none;">*File required to be upload</small>
                                    <input type="file" name="uploaded[]" class="form-control w-100" id="uploads"
                                        multiple accept="image/jpeg,image/gif,image/png,application/pdf">
                                </div>
                            </div>

                        </div>


                        <div class="row d-inline-flex border bg-light">
                            <label class="control-label fw-bold">By Products</label>
                            <div class="col-2 pe-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductCode">Code</label>
                                    <input type="text" class="form-control rounded-0 rounded-start"
                                        id="inputProductCode">
                                </div>
                            </div>
                            <div class="col-4 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductDescription">Description</label>
                                    <input type="text" class="form-control rounded-0" id="inputProductDescription">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductQty">Qty</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductQty">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductWeight">Weight</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductWeight"
                                        readonly>
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

                            <label class="control-label fw-bold">By Invoice Number</label>
                            <div class="col-2 pe-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="selectSOInvoice">Invoice Number</label>
                                    <select type="text" class="form-select rounded-0 rounded-start"
                                        id="selectSOInvoice">

                                    </select>
                                </div>
                            </div>
                            <div class="col-4 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="selectSOProductCode">Product</label>
                                    <select type="text" class="form-select rounded-0" id="selectSOProductCode">

                                    </select>
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputSOProductQty">Qty</label>
                                    <input type="number" class="form-control rounded-0" id="inputSOProductQty">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputSOProductQtyOrdered">Qty Ord</label>
                                    <input type="number" class="form-control rounded-0" id="inputSOProductQtyOrdered">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputSOProductWeight">Weight</label>
                                    <input type="number" class="form-control rounded-0" id="inputSOProductWeight"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-3 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputSOProductComment">Comment</label>
                                    <input type="text" class="form-control rounded-0" id="inputSOProductComment">
                                </div>
                            </div>
                            <div class="col-1 ps-0">
                                <div class="form-group mb-2">
                                    <label class="control-label">&nbsp;</label>
                                    <button class="btn btn-success rounded-0 rounded-end w-100"
                                        id="btnAddSOProduct">ADD</button>
                                </div>
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <div id="gridProducts"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        @if ($complete != '0')
                            <button type="button" id="btnCompleteUpliftment" class="btn btn-success"
                                hidden>Complete</button>
                        @else
                            <button type="button" id="btnCompleteUpliftment" class="btn btn-success" hidden
                                disabled>Complete</button>
                        @endif

                        @if ($print != '0')
                            <button type="button" id="btnPrintUpliftment" class="btn btn-success" hidden>Print</button>
                        @else
                            <button type="button" id="btnPrintUpliftment" class="btn btn-success" hidden
                                disabled>Print</button>
                        @endif

                        @if ($approve != '0')
                            <button type="button" id="btnApproveUpliftment" class="btn btn-success"
                                hidden>Approve</button>
                        @else
                            <button type="button" id="btnApproveUpliftment" class="btn btn-success" hidden
                                disabled>Approve</button>
                        @endif

                        @if ($approve != '0')
                            <button type="button" id="btnDenyUpliftment" class="btn btn-success" hidden>Deny</button>
                        @else
                            <button type="button" id="btnDenyUpliftment" class="btn btn-success" hidden
                                disabled>Deny</button>
                        @endif

                        @if ($update != '0')
                            <button type="button" id="btnUpdateUpliftment" class="btn btn-success"
                                hidden>Update</button>
                        @else
                            <button type="button" id="btnUpdateUpliftment" class="btn btn-success" hidden
                                disabled>Update</button>
                        @endif

                        @if ($viewimage != '0')
                            <button type="button" id="btnUpliftmentImages" class="btn btn-success" hidden>Images &
                                Docs</button>
                        @else
                            <button type="button" id="btnUpliftmentImages" class="btn btn-success" hidden
                                disabled>Images & Docs</button>
                        @endif

                        @if ($enquiry != '0')
                            <button type="button" id="btnEnquireUpliftment" class="btn btn-success"
                                hidden>Enquiry</button>
                        @else
                            <button type="button" id="btnEnquireUpliftment" class="btn btn-success" hidden
                                disabled>Enquiry</button>
                        @endif

                        <button type="button" class="btn btn-secondary closeUpliftmentModal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" id="btnSaveUpliftment" class="btn btn-success">Save</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Approve Confirmation Modal -->
        <div class="modal fade" id="approveConfirmationModal" tabindex="-1" aria-labelledby="approveConfirmationLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="approveConfirmationLabel">Approve Upliftment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="approveComment" class="form-label">Comment</label><br>
                            <small id="RequireApproveComment" style="color: red; display: none;">*Comment must be at least
                                10 characters.</small>

                            <textarea class="form-control" id="approveComment" name="strComment" rows="3" placeholder="Enter comment..."></textarea>
                        </div>

                        <label class="fw-bold">Handling Fee - Yes / No</label><br>

                        <small id="RequireHandingFee" style="color: red; display: none;">*Please select either "Yes" or
                            "No" for Handling Fee.</small><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="handlingFee" id="handlingFeeYes"
                                value="1" required>
                            <label class="form-check-label" for="handlingFeeYes">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="handlingFee" id="handlingFeeNo"
                                value="0" required>
                            <label class="form-check-label" for="handlingFeeNo">No</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" id="btnConfirmApprove">Confirm Approval</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deny Confirmation Modal -->
        <div class="modal fade" id="denyConfirmationModal" tabindex="-1" aria-labelledby="denyConfirmationLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="denyConfirmationLabel">Deny Upliftment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="denyComment" class="form-label">Comment</label><br>
                            <small id="RequireDenyComment" style="color: red; display: none;">*Comment Required</small>

                            <textarea class="form-control" id="denyComment" name="strCommentD" rows="3"
                                placeholder="Enter reason for denial..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="btnConfirmDeny">Confirm Denial</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('scripts')

    <!-- Flexdatalist -->
    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>

    <script>
        // Parse the JSON string into a JavaScript object
        var products = JSON.parse(JSON.stringify({!! json_encode($products) !!}));

        // Map the products array to a new array with selected properties
        var productsList = $.map(products, function(item) {
            return {
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                Weight: item.Weight
            };
        });

        $(document).ready(function() {
            let selectedCustomer = '';
            let selectedInvoice = '';
            let selectedAltAddress = '';
            let selectedId = '';

            let SelectedHandingFee = '';

            const gridUpliftment = $("#gridUpliftment").dxDataGrid({
                dataSource: [], //as json
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
                export: {
                    enabled: true
                },
                onExporting(e) {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('Upliftments');

                    DevExpress.excelExporter.exportDataGrid({
                        component: e.component,
                        worksheet,
                        autoFilterEnabled: true,
                    }).then(() => {
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            saveAs(new Blob([buffer], {
                                type: 'application/octet-stream'
                            }), 'Upliftments.xlsx');
                        });
                    });
                    e.cancel = true;
                },

                columns: [{
                        dataField: "intUpliftmentNumber",
                        caption: "Uplift ID",
                        sortOrder: "asc", // or "desc" if you want newest first
                        calculateDisplayValue: function(rowData) {
                            return "UPL#" + (1000000 + rowData.intUpliftmentNumber).toString()
                                .slice(-6);
                        }

                    },
                    {
                        dataField: "dteUpliftDate",
                        caption: "Uplift Date",
                    },
                    {
                        dataField: "strReasonPickup",
                        caption: "Upliftment Description",
                        visible: false,
                    },
                    {
                        dataField: "strCompany",
                        caption: "Company",
                    },
                    {
                        dataField: "strCustomer",
                        caption: "Customer",
                    },
                    {
                        dataField: "strArea",
                        caption: "Area",
                    },
                    {
                        dataField: "strInvoice",
                        caption: "Invoice Number",
                    },
                    {
                        dataField: "strUpliftmentStatus",
                        caption: "Upliftment Status",
                    },
                    {
                        dataField: "Username",
                        caption: "User",
                    },

                    {
                        dataField: "strFirstApproval",
                        caption: "First Approval",
                    },
                    {
                        dataField: "strSecondApproval",
                        caption: "Second Approval",
                    },
                    {
                        dataField: "strCollectionType",
                        caption: "Collection Type",
                    },

                    {
                        dataField: "bitHandingFee",
                        caption: "Handing Fee",
                        visible: false
                    }
                ],
                onRowRemoving: function(e) {

                },
                onRowDblClick: function(e) {
                    if (viewPermission) {
                        var upliftmentNumber = e.data.intUpliftmentNumber;
                        var statusupliftment = e.data.strUpliftmentStatus;
                        SelectedUpliftmentNumber = e.data.intUpliftmentNumber;
                        selectedInvoice = e.data.strInvoice; // ✅ use the global one
                        var BitHandingFee = e.data.bitHandingFee;
                        SelectedHandingFee = e.data.bitHandingFee;

                        // if BitHandingFee == '' set the radio button to no check


                        // if BitHandingFee == '0' set the radio button No

                        // if BitHandingFee == '1' set the radio button Yes

                        const fee = parseInt(BitHandingFee);

                        if (fee === 1) {
                            $('#handlingFeeYes').prop('checked', true);
                            console.log("Checked: YES");
                        } else if (fee === 0) {
                            $('#handlingFeeNo').prop('checked', true);
                            console.log("Checked: NO");
                        } else {
                            $('input[name="handlingFee"]').prop('checked', false);
                            console.log("Unchecked (NULL or invalid value)");
                        }


                        console.log("Handlingfee: " + BitHandingFee);
                        // ✅ Store invoice number globally
                        selectedInvoice = e.data.strInvoice;
                        console.log("Clicked invoice number: " + selectedInvoice);



                        // Reset radio buttons first
                        // $('input[name="handlingFee"]').prop('checked', false);
                        // // 🆕 Fetch bitHandlingFee from backend using invoice
                        //  // 🆕 Fetch bitHandlingFee from backend using invoice
                        // if (selectedInvoice && selectedInvoice.trim() !== '') {
                        //     $.ajax({
                        //         url: '{{ url('/getHandlingFeeByInvoice') }}',
                        //         type: 'GET',
                        //         data: {
                        //             invoice: selectedInvoice
                        //         },
                        //         success: function(data) {
                        //             console.log("Handling Fee from DB: " + data);
                        //             const fee = parseInt(data);

                        //             if (fee === 1) {
                        //                 $('#handlingFeeYes').prop('checked', true);
                        //                 console.log("Checked: YES");
                        //             } else if (fee === 0) {
                        //                 $('#handlingFeeNo').prop('checked', true);
                        //                 console.log("Checked: NO");
                        //             } else {
                        //                 $('input[name="handlingFee"]').prop('checked', false);
                        //                 console.log("Unchecked (NULL or invalid value)");
                        //             }
                        //         }
                        //     });
                        // }


                        $('#upliftmentModal').modal('toggle');

                        var numericPart = (1000000 + SelectedUpliftmentNumber).toString().slice(-6);
                        $('#txtUpliftNumber').text('UPL#' + numericPart);

                        if (statusupliftment != "Denied" && statusupliftment != "Enquired" &&
                            statusupliftment != "Pending") {
                            $('#printupliftment').prop('hidden', false); //can only appear from approved
                        }

                        if (statusupliftment == "Printed" || statusupliftment == "Completed" ||
                            statusupliftment == "Approved") {
                            $('#completeupliftment').prop('hidden',
                                false); // can only appear from printed
                        }

                        if (statusupliftment == "Printed" || statusupliftment == "Completed" ||
                            statusupliftment == "Approved") {
                            $('#btnPrintUpliftment').prop('disabled', false);
                        } else {
                            $('#btnPrintUpliftment').prop('disabled', true);
                        }

                        $('#btnUpdateUpliftment').prop('hidden', false);
                        $('#btnApproveUpliftment').prop('hidden', false);
                        $('#btnPrintUpliftment').prop('hidden', false);
                        $('#btnDenyUpliftment').prop('hidden', false);
                        $('#btnUpliftmentImages').prop('hidden', false);
                        $('#btnEnquireUpliftment').prop('hidden', false);
                        $('#btnSaveUpliftment').prop('hidden', true);

                        $('#inputDate').val(e.data.dteUpliftDate);
                        selectedCustomer = e.data.strCustomer;
                        selectedInvoice = e.data.strInvoice;
                        selectedId = e.data.intUpliftmentNumber;

                        $('#selectCompany').val(e.data.strCompany).trigger('change');

                        // $('#inputAltAddress').val(e.data.strAddress);
                        selectedAltAddress = e.data.strAddress;

                        $('#inputArea').val(e.data.strArea);
                        // $('#inputAltInvoice').val(e.data.strInvoice).trigger('change');

                        $('#inputPickupReason').val(e.data.strReasonPickup);
                        $('#selectType').val(e.data.strCollectionType);

                        getGridProducts(upliftmentNumber);
                    }
                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h3>').text('UPLIFTMENTS');
                        }
                    });
                    if (makeUpliftment != 0) {
                        e.toolbarOptions.items.push({
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa fa-plus",
                                text: "ADD",
                                onClick: function(args) {
                                    $('#upliftmentModal').modal('show');
                                },
                            },
                        });
                    }
                }
            }).dxDataGrid('instance');

            const upliftmentLoadPanel = $('#upliftmentLoader').dxLoadPanel({
                message: 'Processing...',
                shadingColor: 'rgba(0,0,0,0.4)',
                position: {
                    of: 'body'
                },
                visible: false,
                showIndicator: true,
                showPane: true
            }).dxLoadPanel('instance');

            const gridProducts = $("#gridProducts").dxDataGrid({
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
                    mode: "row",
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
                    },

                    {
                        dataField: "QtyOrd",
                        caption: "Qty Ord",
                        dataType: "number",
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
                    },


                ],
                onRowRemoving: function(e) {

                },
                onRowDblClick: function(e) {

                },
                onToolbarPreparing: function(e) {
                    e.toolbarOptions.items.unshift({
                        location: 'before',
                        template: function() {
                            return $('<h5>').text('PRODUCTS');
                        }
                    });
                }
            }).dxDataGrid('instance');

            $('#inputCustomer').flexdatalist({
                minLength: 1,
                valueProperty: 'CustomerCode',
                textProperty: 'StoreName',
                selectionRequired: true,
                focusFirstResult: true,
                searchContain: true,
                visibleProperties: ["CustomerCode", "StoreName"],
                searchIn: ["CustomerCode", "StoreName"],
            });

            var SelectedUpliftmentNumber = 0;

            setProductsDataList(productsList);

            $("#selectCompany").change(function() {
                $('#overlay').prop('hidden', false);
                $.ajax({
                    url: '{!! url('/getCustomerForSelectedCompany') !!}',
                    type: "POST",
                    data: {
                        company: $("#selectCompany").val()
                    },
                    success: function(data) {
                        setCustomersDataList(data);
                        $('#overlay').prop('hidden', true);
                    }
                });
            });

            $('#inputCustomer').on('change:flexdatalist', function(event, strInvoice) {

                var customerDetails = $('#inputCustomer').flexdatalist('value');
                var selectedCustomer = customerDetails;

                if (customerDetails != '') {
                    $.ajax({
                        url: '{!! url('/getAreaAddressInvoiceInfoParam') !!}',
                        type: "POST",
                        data: {
                            customer: customerDetails,
                            company: $("#selectCompany").val()
                        },
                        success: function(data) {

                            $.each(data.areas, function(i, o) {
                                $("#inputArea").val(o.Route);
                            });

                            setAlternativeAreaList(data.routes);
                            setCustomerAddressList(data.addresses)
                            setInvoiceDataList(data.invoices);

                            if (strInvoice) {
                                $('#selectInvoice').val(strInvoice).trigger('change');
                            }
                        }
                    });
                }
            });

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
                inputProductCode.on('select:flexdatalist', function(event, data) {
                    //fill in inputs of code desc weight, empty qty empty comment..
                    $('#inputProductCode').flexdatalist('value', data.PastelCode);
                    $('#inputProductDescription').flexdatalist('value', data.PastelDescription);
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
                inputProductDescription.on('select:flexdatalist', function(event, data) {
                    //fill in inputs of code desc weight, empty qty empty comment..
                    $('#inputProductCode').flexdatalist('value', data.PastelCode);
                    $('#inputProductDescription').flexdatalist('value', data.PastelDescription);
                    $('#inputProductQty').val(1);
                    $('#inputProductWeight').val(parseFloat(data.Weight).toFixed(3));
                });
            }

            function setCustomersDataList(customers) {
                var customerList = $.map(JSON.parse(JSON.stringify(customers)), function(item) {
                    return {
                        CustomerCode: item.CustomerPastelCode,
                        StoreName: item.StoreName,
                    }
                });

                $('#inputCustomer').flexdatalist('data', customerList);
                $('#inputCustomer').flexdatalist('value', selectedCustomer).trigger('change:flexdatalist');
            };

            function setCustomerAddressList(addresses) {
                // $('#inputAddress').empty();
                // var toAppend='';
                // $.each(addresses,function(i,o){
                //     toAppend += '<option value="'+o.strAddress+'">'+o.strAddress+'</option>';
                // });
                // $("#inputAddress").append(toAppend);

                if (selectedAltAddress != '') {
                    $("#inputAddress").val(selectedAltAddress);
                } else {
                    $("#inputAddress").val(addresses[0]["strAddress"]);
                }

            };

            function setAlternativeAreaList(areas) {
                var alternativeAreasList = $.map(JSON.parse(JSON.stringify(areas)), function(item) {
                    return {
                        // routeID: item.routeID,
                        // Route: item.Route,
                        id: item.Route,
                        text: item.Route
                    }
                });

                alternativeAreasList.unshift({
                    id: '',
                    text: ''
                });

                $('#selectAltArea').empty().select2({
                    data: alternativeAreasList,
                    theme: 'bootstrap-5',
                    dropdownParent: $('#upliftmentModal'),
                });

            };

            function setInvoiceDataList(invoices) {


                var invoiceList = $.map(JSON.parse(JSON.stringify(invoices)), function(item) {
                    return {
                        value: item.InvNumber,
                        id: item.InvNumber,
                        text: item.InvNumber,
                        delivery: item.DeliveryDate // include it in the option

                    };
                });

                invoiceList.unshift({
                    value: '',
                    id: '',
                    text: ''
                });

                $('#selectInvoice').empty().select2({
                    data: invoiceList,
                    theme: 'bootstrap-5',
                    dropdownParent: $('#upliftmentModal'),
                    templateResult: function(data) {
                        if (!data.id) return data.text;
                        return $('<span>').text(data.text).attr('data-delivery', data.delivery);
                    }
                });

                $('#selectSOInvoice').empty().select2({
                    data: invoiceList,
                    theme: 'bootstrap-5',
                    dropdownParent: $('#upliftmentModal'),
                });

                if (!invoiceList.some(item => item.value === selectedInvoice)) {
                    $('#inputAltInvoice').val(selectedInvoice);
                } else {
                    $('#selectInvoice').val(selectedInvoice).trigger('change');
                    // Force trigger the select2:select event so deliveryDate shows
                    $('#selectInvoice').trigger({
                        type: 'select2:select',
                        params: {
                            data: $('#selectInvoice').select2('data')[0]
                        }
                    });
                }

            };

            function setSalesOrderProductDataList(soProducts) {
                // Map the soProducts array to match select2 expected format
                // console.log(soProducts);
                var soProductList = $.map(JSON.parse(JSON.stringify(soProducts)), function(item) {
                    return {
                        value: item.Code,
                        id: item.Code,
                        text: item.PDesc
                    };
                });

                // Add an empty option at the beginning
                soProductList.unshift({
                    id: '',
                    text: ''
                });

                // Initialize select2 with the data
                $('#selectSOProductCode').empty().select2({
                    data: soProductList,
                    theme: 'bootstrap-5',
                    dropdownParent: $('#upliftmentModal'),
                });
            };

            $('#inputProductQty').on('change', function() {
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

            $('#selectInvoice').on('change', function() {

                $('#selectSOInvoice').val($(this).val()).trigger('change');
                const selectedOption = $(this).find(':selected');

            });

            $('#selectInvoice').on('select2:select', function(e) {
                const data = e.params.data;
                const deliveryDate = data.delivery;
                $('#invoiceDate').val(deliveryDate || '');
            });

            $('#selectSOInvoice').on('select2:select', function(e) {
                const data = e.params.data;
                const deliveryDate = data.delivery;
                $('#invoiceDate').val(deliveryDate || '');
            });

            $('#selectSOInvoice').on('change', function() {
                var InvNum = $(this).val(); // value from selectSOInvoice
                var strCompany = $('#selectCompany').val();

                // ✅ Sync to #selectInvoice and trigger full select2 event
                $('#selectInvoice').val(InvNum).trigger({
                    type: 'select2:select',
                    params: {
                        data: {
                            id: InvNum,
                            text: InvNum
                        }
                    }
                });

                // ✅ Proceed to fetch product lines for selected invoice
                if (InvNum !== "") {
                    $.ajax({
                        url: '{!! url('/getUpliftmentSalesOrderLines') !!}',
                        type: "GET",
                        data: {
                            InvNum: InvNum,
                            strCompany: strCompany,
                        },
                        success: function(data) {
                            setSalesOrderProductDataList(data);
                        }
                    });
                }
            });

            $('#selectSOProductCode').on('change', function() {
                var selectedProductCode = $('#selectSOProductCode').val();
                if (selectedProductCode != '') {
                    var selectedProduct = products.find(item => item.PastelCode === selectedProductCode);
                    $('#inputSOProductQty').val(1);
                    $('#inputSOProductWeight').val(parseFloat(selectedProduct.Weight).toFixed(3));

                    // 🆕 Find the item from the last invoice products and set Qty Ordered
                    var selectedInvoice = $('#selectSOInvoice').val();
                    $.ajax({
                        url: '{!! url('/getUpliftmentSalesOrderLines') !!}',
                        type: 'GET',
                        data: {
                            InvNum: selectedInvoice,
                            strCompany: $('#selectCompany').val(),
                        },
                        success: function(data) {
                            const matched = data.find(x => x.Code === selectedProductCode);
                            if (matched) {
                                $('#inputSOProductQtyOrdered').val(matched.decQtyProcessed);
                            } else {
                                $('#inputSOProductQtyOrdered').val('');
                            }
                        }
                    });
                }
            });

            $('#inputSOProductQty').on('change', function() {
                var qty = parseFloat($('#inputSOProductQty').val()) || 0; // Ensure qty is a valid number
                var selectedProductCode = $('#selectSOProductCode').val();

                // Find the corresponding product based on the selected PastelCode
                var selectedProduct = products.find(item => item.PastelCode === selectedProductCode);

                if (selectedProduct) {
                    // Calculate the new weight based on the quantity
                    var calculatedWeight = qty * selectedProduct.Weight;

                    // Set the calculated weight in the input field
                    $('#inputSOProductWeight').val(calculatedWeight.toFixed(3));
                }
            });

            $('#btnAddProduct').click(function() {
                // retrieve the input values
                var PastelCode = $('#inputProductCode').val().trim();
                var PastelDescription = $('#inputProductDescription').val().trim();
                var Weight = $('#inputProductWeight').val();
                var Qty = $('#inputProductQty').val();
                var Comment = $('#inputProductComment').val().trim();

                // validate required fields
                if (PastelCode === '') {
                    alert('Product code is required.');
                    return;
                }

                if (Qty === '' || isNaN(Qty) || parseFloat(Qty) <= 0) {
                    alert('Quantity must be a number greater than 0.');
                    return;
                }

                // clear the inputs
                $('#inputProductCode').val('');
                $('#inputProductDescription').val('');
                $('#inputProductWeight').val(0);
                $('#inputProductQty').val(0);
                $('#inputProductComment').val('');

                // create new row
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
            });

            $('#btnAddSOProduct').click(function() {
                // retrieve the input values
                var PastelCode = $('#selectSOProductCode').val();
                var PastelDescription = $('#selectSOProductCode option:selected').text();
                var Weight = $('#inputSOProductWeight').val();
                var Qty = $('#inputSOProductQty').val();
                var QtyOrd = $('#inputSOProductQtyOrdered').val();
                var Comment = $('#inputSOProductComment').val().trim();

                // validate required fields
                if (!PastelCode) {
                    alert('Please select a product.');
                    return;
                }

                if (Qty === '' || isNaN(Qty) || parseFloat(Qty) <= 0) {
                    alert('Quantity must be a number greater than 0.');
                    return;
                }

                // create new row
                var newRow = {
                    PastelCode: PastelCode,
                    PastelDescription: PastelDescription,
                    Qty: Qty,
                    QtyOrd: QtyOrd,
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

                // clear inputs
                $('#selectSOProductCode').val('').trigger('change');
                $('#inputSOProductWeight').val(0);
                $('#inputSOProductQty').val(0);
                $('#inputSOProductQtyOrdered').val(0);
                $('#inputSOProductComment').val('');
            });

            $('#btnSaveUpliftment').click(function() {
                var $btn = $(this);

                // Prevent double-clicking
                if ($btn.prop('disabled')) return;

                // Disable the button and show loading
                $btn.prop('disabled', true);
                upliftmentLoadPanel.show();

                var files = $('#uploads')[0].files;
                var reason = $('#inputPickupReason').val().trim();

                // File validation
                if (files.length === 0) {
                    $("#RequireVal").show();
                    $('#uploads').focus();
                    $btn.prop('disabled', false);
                    upliftmentLoadPanel.hide();
                    return;
                } else {
                    $("#RequireVal").hide();
                }

                // Reason validation
                if (reason.length < 10) {
                    $("#RequireReason").show();
                    $('#inputPickupReason').addClass('is-invalid').focus();
                    $btn.prop('disabled', false);
                    upliftmentLoadPanel.hide();
                    return;
                } else {
                    $("#RequireReason").hide();
                    $('#inputPickupReason').removeClass('is-invalid');
                }

                // Invoice validation: at least one must be filled
                var invoiceSelect = $('#selectInvoice').val().trim();
                var invoiceAlt = $('#inputAltInvoice').val().trim();

                if (invoiceSelect === '' && invoiceAlt === '') {
                    $('#invoiceError').removeClass('d-none');
                    $('#selectInvoice').addClass('is-invalid');
                    $('#inputAltInvoice').addClass('is-invalid').focus();
                    $btn.prop('disabled', false);
                    upliftmentLoadPanel.hide();
                    return;
                } else {
                    $('#invoiceError').addClass('d-none');
                    $('#selectInvoice').removeClass('is-invalid');
                    $('#inputAltInvoice').removeClass('is-invalid');
                }

                // Build XML data
                var checkedLines = gridProducts.option('dataSource');
                var gridResults = '<xml>';
                var hasLines = false; // track if there's at least one valid line

                $.each(checkedLines, function(key, value) {
                    if (value.Qty != undefined && value.Qty != null && value.Qty !== '') {
                        hasLines = true;
                        gridResults += "<result>";
                        gridResults += "<PastelCode>" + escapeHtml(value.PastelCode) +
                            "</PastelCode>";
                        gridResults += "<PastelDescription>" + escapeHtml(value.PastelDescription) +
                            "</PastelDescription>";
                        gridResults += "<Qty>" + value.Qty + "</Qty>";
                        gridResults += "<QtyOrd>" + (value.QtyOrd || '') + "</QtyOrd>";
                        gridResults += "<Weight>" + value.Weight + "</Weight>";
                        gridResults += "<Comment>" + escapeHtml(value.Comment) + "</Comment>";
                        gridResults += "</result>";
                    }
                });
                gridResults += "</xml>";

                // 🚫 No lines? Show error and exit
                if (!hasLines) {
                    DevExpress.ui.notify("Please add at least one product before saving the upliftment.",
                        "error", 3000);
                    $('#btnSaveUpliftment, #btnUpdateUpliftment').prop('disabled', false);
                    upliftmentLoadPanel.hide();
                    return;
                }

                // Form data
                var formData = new FormData();
                for (var i = 0; i < files.length; i++) {
                    formData.append('uploaded[]', files[i]);
                }

                formData.append('dataxml', gridResults);
                formData.append('reasonpickup', $('#inputPickupReason').val());

                formData.append('area', $('#selectAltArea').val().length > 0 ? $('#selectAltArea').val() :
                    $('#inputArea').val());
                formData.append('address', $('#inputAltAddress').val().length > 0 ? $('#inputAltAddress')
                    .val() : $('#inputAddress').val());
                formData.append('invoice', $('#inputAltInvoice').val().length > 0 ? $('#inputAltInvoice')
                    .val() : $('#selectInvoice').val());
                formData.append('customers', $('#inputCustomer').flexdatalist('value'));
                formData.append('company', $('#selectCompany').val());
                formData.append('date', $('#inputDate').val());
                formData.append('collectionType', $('#selectType').val());

                // Ajax call
                $.ajax({
                    url: '{!! url('/insertUpliftmentAll') !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        location.reload(); // or show a success message first
                    },
                    error: function() {
                        alert('An error occurred while saving.');
                        $btn.prop('disabled', false);
                        upliftmentLoadPanel.hide();
                    }
                });
            });

            $('#btnUpdateUpliftment').click(function() {
                var $btn = $(this);

                // Prevent double-submission
                if ($btn.prop('disabled')) return;

                $btn.prop('disabled', true);
                upliftmentLoadPanel.show();

                var checkedLines = gridProducts.option('dataSource');

                var gridResults = '<xml>';
                $.each(checkedLines, function(key, value) {
                    if (value.Qty != undefined || value.Qty != null) {
                        gridResults += "<result>";
                        gridResults += "<PastelCode>" + escapeHtml(value.PastelCode) +
                            "</PastelCode>";
                        gridResults += "<PastelDescription>" + escapeHtml(value.PastelDescription) +
                            "</PastelDescription>";
                        gridResults += "<Qty>" + value.Qty + "</Qty>";
                        gridResults += "<Weight>" + value.Weight + "</Weight>";
                        gridResults += "<Comment>" + escapeHtml(value.Comment) + "</Comment>";
                        gridResults += "</result>";
                    }
                });
                gridResults += "</xml>";

                var formData = new FormData();
                formData.append('SelectedUpliftmentNumber', SelectedUpliftmentNumber);

                var files = $('#uploads')[0].files;
                for (var i = 0; i < files.length; i++) {
                    formData.append('uploaded[]', files[i]);
                }

                formData.append('dataxml', gridResults);
                formData.append('reasonpickup', $('#inputPickupReason').val());

                formData.append('area', $('#selectAltArea').val().length > 0 ? $('#selectAltArea').val() :
                    $('#inputArea').val());
                formData.append('address', $('#inputAltAddress').val().length > 0 ? $('#inputAltAddress')
                    .val() : $('#inputAddress').val());

                var invoice = $('#inputAltInvoice').val().length > 0 ? $('#inputAltInvoice').val() : $(
                    '#selectInvoice').val();
                formData.append('invoice', invoice);

                var customer = $('#inputCustomer').flexdatalist('value');
                formData.append('customers', customer);
                formData.append('company', $('#selectCompany').val());
                formData.append('date', $('#inputDate').val());
                formData.append('collectionType', $('#selectType').val());

                $.ajax({
                    url: '{!! url('/updateUpliftmentPost') !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        location.reload();
                    },
                    error: function() {
                        alert('Update failed. Please try again.');
                        $btn.prop('disabled', false);
                        upliftmentLoadPanel.hide();
                    }
                });
            });

            $('#btnApproveUpliftment').click(function() {
                $('#approveComment').val('');
                $('input[name="handlingFee"]').prop('checked', false);
                $('#upliftmentModal').modal('hide');
                $('#approveConfirmationModal').modal('show');

                const fee = parseInt(SelectedHandingFee);
                if (fee === 1) {
                    $('#handlingFeeYes').prop('checked', true);
                } else if (fee === 0) {
                    $('#handlingFeeNo').prop('checked', true);
                }
            });

            $('#btnConfirmApprove').click(function() {
                const comment = $('#approveComment').val().trim();
                const handlingFee = $('input[name="handlingFee"]:checked').val(); // ✅ get selected value

                if (comment.length < 10) {
                    $('#RequireApproveComment').show();
                    $('#approveComment').addClass('is-invalid').focus();
                    return;
                } else {
                    $('#RequireApproveComment').hide();
                    $('#approveComment').removeClass('is-invalid');
                }

                // ✅ Check if a radio option is selected
                if (typeof handlingFee === 'undefined') {
                    $('#RequireHandingFee').show();
                    return;
                } else {
                    $('#RequireHandingFee').hide();

                }

                var formData = new FormData();
                formData.append('SelectedUpliftmentNumber', SelectedUpliftmentNumber);
                formData.append('comment', comment);
                formData.append('handlingFee', handlingFee);

                $.ajax({
                    url: '{!! url('/approveUpliftmentPost') !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('#approveConfirmationModal').modal('hide');
                        DevExpress.ui.notify(data.Message, data.Status === "1" ? "success" :
                            "error", 5000);
                        if (data.Status === "1") location.reload();
                    }
                });
            });

            $('#btnPrintUpliftment').click(function() {

                var formData = new FormData();

                formData.append('SelectedUpliftmentNumber', SelectedUpliftmentNumber);
                $.ajax({

                    url: '{!! url('/printUpliftmentPost') !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        window.open('{!! url('/retrieveUpliftmentPrint') !!}/' + SelectedUpliftmentNumber,
                            'width=800,height=600,resizable=yes,scrollbars=yes,status=yes');
                    }
                });
            });

            $('#btnCompleteUpliftment').click(function() {

                var formData = new FormData();

                formData.append('SelectedUpliftmentNumber', SelectedUpliftmentNumber);
                $.ajax({
                    url: '{!! url('/completeUpliftmentPost') !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        location.reload();
                    }
                });
            });

            $('#btnDenyUpliftment').click(function() {
                $('#denyComment').val('');
                $('#denyConfirmationModal').modal('show');
            });

            $('#btnConfirmDeny').click(function() {
                const comment = $('#denyComment').val().trim();
                console.log("Decline Comment here: " + comment)

                if (comment.length < 3) {
                    // alert("Comment is required to deny.");
                    $("#RequireDenyComment").show();
                    return;
                } else {
                    $("#RequireDenyComment").hide();

                }

                var formData = new FormData();
                formData.append('SelectedUpliftmentNumber', SelectedUpliftmentNumber);
                formData.append('comment', comment);

                $.ajax({
                    url: '{!! url('/denyUpliftmentPost') !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log("Denial saved!");
                        $('#denyConfirmationModal').modal('hide');
                        location.reload();
                    },
                    error: function(err) {
                        console.error("Error submitting denial", err);
                        alert("Something went wrong while denying.");
                    }
                });
            });

            $('#btnUpliftmentImages').click(function() {
                window.open('{!! url('/upliftmentUploads') !!}/' + SelectedUpliftmentNumber, 'upliftmentUploads',
                    "location=1,status=1,scrollbars=1, width=1200,height=850");
            });

            $('#btnEnquireUpliftment').click(function() {
                window.open('{!! url('/upliftEnquiry') !!}/' + SelectedUpliftmentNumber, 'upliftenquirygetter',
                    "location=1,status=1,scrollbars=1, width=1200,height=850");
            });

            var viewPermission = '{{ $view }}';
            var makeUpliftment = '{{ $make }}';

            $.ajax({
                url: '{!! url('/getUpliftmentRecords') !!}',
                type: "GET",
                success: function(data) {
                    gridUpliftment.option('dataSource', data);
                    gridUpliftment.refresh();
                }
            });

            function getGridProducts(upliftmentNumber) {
                $.ajax({
                    url: '{!! url('/getUpliftmentDetails') !!}',
                    type: 'GET',
                    data: {
                        upliftmentNumber: upliftmentNumber
                    },
                    success: function(data) {
                        gridProducts.option('dataSource', data);
                        gridProducts.refresh();
                    }
                });
            }

            // To clear and close the upliftment modal
            var upliftmentModal = $('#upliftmentModal');
            $('.closeUpliftmentModal', upliftmentModal).on('click', function() {
                upliftmentModal.hide();

                $('#txtUpliftNumber').text('');

                $('#btnUpdateUpliftment').prop('hidden', true);
                $('#btnApproveUpliftment').prop('hidden', true);
                $('#btnPrintUpliftment').prop('hidden', true);
                $('#btnDenyUpliftment').prop('hidden', true);
                $('#btnUpliftmentImages').prop('hidden', true);
                $('#btnEnquireUpliftment').prop('hidden', true);
                $('#btnSaveUpliftment').prop('hidden', false);

                $('.form-control', upliftmentModal).val('');
                $('.form-select', upliftmentModal).val('default');
                $('.form-select', upliftmentModal).trigger('change.select2');
                $('.form-select:not(#selectCompany,#selectType)', upliftmentModal).empty();
                selectedCustomer = '';
                $('#inputCustomer').flexdatalist('value', selectedCustomer).trigger('change:flexdatalist');

                selectedInvoice = '';
                selectedAltAddress = '';
                selectedId = '';

                gridProducts.option('dataSource', []);
                gridProducts.refresh();
            });

            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            };

        });
    </script>
@endsection
