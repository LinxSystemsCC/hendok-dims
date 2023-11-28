
<?php
if ((Auth::guest()))
{

}else{
    $v  =  new \App\Http\Controllers\SalesForm();
    $make = $v->getThingsUserPermissions(Auth::user()->UserID,'Make Voucher');
    $view = $v->getThingsUserPermissions(Auth::user()->UserID,'View Upliftment Voucher');
    $update = $v->getThingsUserPermissions(Auth::user()->UserID,'Update Upliftment Voucher');
    $enquiry = $v->getThingsUserPermissions(Auth::user()->UserID,'Enquire Upliftment Voucher');
    $backlog = $v->getThingsUserPermissions(Auth::user()->UserID,'View Backlogs Upliftment Voucher');
    $approve = $v->getThingsUserPermissions(Auth::user()->UserID,'Approve Uplifment Voucher');
    $print = $v->getThingsUserPermissions(Auth::user()->UserID,'Print Upliftment Voucher');
    $complete = $v->getThingsUserPermissions(Auth::user()->UserID,'Complete Upliftment Voucher');
    $viewimage = $v->getThingsUserPermissions(Auth::user()->UserID,'View Image Upliftment Voucher');
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
    <link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>  

    <style>
        .grid{
            height: 100%;
            max-height: 100%;
        }
    </style>

    <div class="col-md-12 h-100">
        <div class="grid" id="gridUpliftment"></div>

        <!-- Upliftment Modal -->
        <div class="modal fade modal-xl" id="upliftmentModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newuserLabel">Create/Edit Upliftment</h1>
                        <button type="button" class="btn-close closeUpliftmentModal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputDate">Date</label>
                                    <input type="date" class="form-control w-100" id="inputDate">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="selectCompany">Company</label>
                                    <select  class="form-select w-100" id="selectCompany" style="width: 60%" >
                                        <option></option>
                                        @foreach($companies as $val)
                                        <option value="{{$val->companyname}}">{{$val->companyname}}</option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputArea">Selected Area</label>
                                    <input readonly  class="form-control w-100" id="inputArea" required>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="selectAddress">Address Name</label>
                                    <select  class="form-select" id="selectAddress" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputCustomer">Customer Name</label>
                                    <input  class="form-control w-100" id="inputCustomer" required>
                                </div>
                                

                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="selectAltArea">Alternative Area Selection</label>
                                    {{-- <input  class="form-control w-100" id="selectAltArea" required> --}}
                                    <select  class="form-select" id="selectAltArea" required>
                                        <option></option>
                                    </select>
                                </div>
        
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputAltAddress">Alternative Address Name</label>
                                    <input type="text" class="form-control w-100" id="inputAltAddress" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputInvoice">Invoice</label>
                                    <input  class="form-control w-100" id="inputInvoice" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputAltInvoice">Alternative Invoice</label>
                                    <input  class="form-control w-100" id="inputAltInvoice" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="control-label fw-bold" for="inputPickupReason">Reason for Pickup</label>
                            <textarea class="form-control w-100" id="inputPickupReason"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputPhoto1">Upload a First Photo</label>
                                    <input type="file" name="photo" class="form-control w-100" id="inputPhoto1">
                                </div>
                            </div>
                            <div class="col-4 px-0">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputPhoto2">Upload a Second Photo</label>
                                    <input type="file" name="photo" class="form-control w-100" id="inputPhoto2">
                                </div>
                            </div>  
                            <div class="col-4">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="inputPhoto3">Upload a Third Photo</label>
                                    <input type="file" name="photo" class="form-control w-100" id="inputPhoto3">
                                </div>
                            </div>
                        </div>

                        
                        <div class="row d-inline-flex border bg-light">
                            <label class="control-label fw-bold">By Products</label>
                            <div class="col-2 pe-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductCode">Code</label>
                                    <input type="text" class="form-control rounded-0 rounded-start" id="inputProductCode">
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
                                    <button class="btn btn-success rounded-0 rounded-end w-100" id="btnAddProduct">ADD</button>
                                </div>
                            </div>

                            <label class="control-label fw-bold">By Invoice Number</label>
                            <div class="col-2 pe-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="selectSONumber">Invoice Number</label>
                                    <select type="text" class="form-select rounded-0 rounded-start" id="selectSONumber">

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
                                    <label class="control-label" for="inputSOProductWeight">Weight</label>
                                    <input type="number" class="form-control rounded-0" id="inputSOProductWeight" readonly>
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
                                    <button class="btn btn-success rounded-0 rounded-end w-100" id="btnAddSOProduct">ADD</button>
                                </div>
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <div id="gridProducts"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        @if($complete !="0")
                            <button type="button" id="btnCompleteUpliftment" class="btn btn-success" hidden>Complete</button>
                        @else
                            <button type="button" id="btnCompleteUpliftment" class="btn btn-success" hidden disabled>Complete</button>
                        @endif

                        @if($print !="0")
                            <button type="button" id="btnPrintUpliftment" class="btn btn-success" hidden>Print</button>
                        @else
                            <button type="button" id="btnPrintUpliftment" class="btn btn-success" hidden disabled>Print</button>
                        @endif

                        @if($approve !="0")
                            <button type="button" id="btnApproveUpliftment" class="btn btn-success" hidden>Approve</button>
                        @else
                            <button type="button" id="btnApproveUpliftment" class="btn btn-success" hidden disabled>Approve</button>
                        @endif

                        @if($approve !="0")
                            <button type="button" id="btnDenyUpliftment" class="btn btn-success" hidden>Deny</button>
                        @else
                            <button type="button" id="btnDenyUpliftment" class="btn btn-success" hidden disabled>Deny</button>
                        @endif
                        
                        @if($update !="0")
                            <button type="button" id="btnUpdateUpliftment" class="btn btn-success" hidden>Update</button>
                        @else
                            <button type="button" id="btnUpdateUpliftment" class="btn btn-success" hidden disabled>Update</button>
                        @endif
                        
                        @if($viewimage !="0")
                            <button type="button" id="btnUpliftmentImages" class="btn btn-success" hidden>Images</button>
                        @else
                            <button type="button" id="btnUpliftmentImages" class="btn btn-success" hidden disabled>Images</button>
                        @endif
                        
                        @if($enquiry !="0")
                            <button type="button" id="btnEnquireUpliftment" class="btn btn-success" hidden>Enquiry</button>
                        @else
                            <button type="button" id="btnEnquireUpliftment" class="btn btn-success" hidden disabled>Enquiry</button>
                        @endif

                        <button type="button" class="btn btn-secondary closeUpliftmentModal" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="btnSaveUpliftment" class="btn btn-success" >Save</button>

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
        var productsList = $.map(products, function (item) {
            return {
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                Weight: item.Weight
            };
        });

        $(document).ready(function() {

            const gridUpliftment = $("#gridUpliftment").dxDataGrid({
                dataSource:[], //as json
                hoverStateEnabled: true,
                showBorders: true,
                filterRow: { visible: true },
                filterPanel: { visible: true },
                headerFilter: { visible: true },
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging:{
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
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Upliftments.xlsx');
                        });
                    });
                    e.cancel = true;
                },

                columns: [
                    {
                        dataField: "intUpliftmentNumber",
                        caption: "Uplift ID",
                    }, 
                    {
                        dataField: "dteUpliftDate",
                        caption: "Uplift Date",
                    }, 
                    {
                        dataField: "strReasonPickup",
                        caption: "Upliftment Description",
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
                ],
                onRowRemoving: function(e) {

                },
                onRowDblClick: function(e) {
                    if (viewPermission) {
                        var upliftmentNumber = e.data.intUpliftmentNumber;
                        var statusupliftment = e.data.strUpliftmentStatus;
                        SelectedUpliftmentNumber = e.data.intUpliftmentNumber;
                        $('#upliftmentModal').modal('toggle');

                        if(statusupliftment !="Denied" && statusupliftment !="Enquired" &&statusupliftment !="Pending")
                        {
                            $('#printupliftment').prop('hidden',false); //can only appear from approved
                        }
                        
                        if(statusupliftment =="Printed" || statusupliftment =="Completed"|| statusupliftment =="Approved")
                        {
                            $('#completeupliftment').prop('hidden',false); // can only appear from printed
                        }

                        $('#btnUpdateUpliftment').prop('hidden',false);
                        $('#btnApproveUpliftment').prop('hidden',false);
                        $('#btnDenyUpliftment').prop('hidden',false);
                        $('#btnUpliftmentImages').prop('hidden',false);
                        $('#btnEnquireUpliftment').prop('hidden',false);
                        $('#btnSaveUpliftment').prop('hidden',true);
                        
                        $('#inputDate').val(e.data.dteUpliftDate);
                        $('#selectCompany').val(e.data.strCompany).trigger('change');
                        $('#inputCustomer').val(e.data.strCustomer);
                        $('#inputAltAddress').val(e.data.strAddress);

                        $('#inputArea').val(e.data.strArea);
                        $('#inputAltInvoice').val(e.data.strInvoice).trigger('change');
                        $('#inputPickupReason').val(e.data.strReasonPickup);
                        
                        getGridProducts(upliftmentNumber);
                    }
                },
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('UPLIFTMENTS');
                            }
                        }
                    );
                    if (makeUpliftment != 0){
                        e.toolbarOptions.items.push(
                            {
                                location: 'after',
                                widget: "dxButton",
                                options: {
                                    icon: "fa fa-plus",
                                    text: "ADD",
                                    onClick: function (args) {
                                        $('#upliftmentModal').modal('show');
                                    },
                                },
                            }
                        );
                    }
                }
            }).dxDataGrid('instance');

            const gridProducts = $("#gridProducts").dxDataGrid({
                dataSource:[], //as json
                hoverStateEnabled: true,
                showBorders: true,
                allowColumnResizing: true,
                columnAutoWidth: true,
                scrolling: {
                    rowRenderingMode: 'infinite',
                },
                paging:{
                    pageSize: 10,
                },
                editing: {
                    mode: "row",
                    allowDeleting: true,
                },
                columns: [
                    {
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

            var SelectedUpliftmentNumber = 0;

            setProductsDataList(productsList);

            $("#selectCompany").change(function () {
                $('#overlay').prop('hidden', false);
                $.ajax({
                    url: '{!!url("/getCustomerForSelectedCompany")!!}',
                    type: "POST",
                    data: {
                        company: $("#selectCompany").val()
                    },
                    success: function (data) {
                        setCustomersDataList(data);
                        $('#overlay').prop('hidden', true);
                    }
                });
            });

            $('#inputCustomer').on('change:flexdatalist', function(event, set, options) {
                var customerDetails = $('#inputCustomer').flexdatalist('value');
                $.ajax({
                    url: '{!!url("/getAreaAddressInvoiceInfoParam")!!}',
                    type: "POST",
                    data: {
                        customer: customerDetails.CustomerCode,
                        company: $("#selectCompany").val()
                    },
                    success: function (data) {

                        $.each(data.areas,function(i,o){
                            $("#inputArea").val(o.Route);
                        });

                        setAlternativeAreaList(data.routes);
                        setCustomerAddressList(data.addresses)
                        setInvoiceDataList(data.invoices);
                        setSalesOrderDataList(data.salesorders);
                    }
                });
            });

            function setProductsDataList(products){
                var inputProductCode = $('#inputProductCode').flexdatalist({
                    minLength: 1,
                    valueProperty: '*',
                    selectionRequired: true,
                    focusFirstResult: true,
                    searchContain:true,
                    visibleProperties: ["PastelCode","PastelDescription"],
                    searchIn: ["PastelCode","PastelDescription"],
                    data: products
                });
                inputProductCode.on('select:flexdatalist', function (event, data) {
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
                    searchContain:true,
                    visibleProperties: ["PastelCode","PastelDescription"],
                    searchIn: ["PastelCode","PastelDescription"],
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

            function setCustomersDataList(customers){
                var customerList = $.map(JSON.parse(JSON.stringify(customers)), function (item) {
                    return {
                        CustomerCode: item.CustomerPastelCode,
                        StoreName: item.StoreName,
                    }
                });

                $('#inputCustomer').flexdatalist({
                    minLength: 1,
                    valueProperty: '*',
                    selectionRequired: true,
                    focusFirstResult: true,
                    searchContain:true,
                    visibleProperties: ["CustomerCode","StoreName"],
                    searchIn: ["CustomerCode","StoreName"],
                    data: customerList
                });
            };

            function setCustomerAddressList(addresses){
                $('#selectAddress').empty();
                var toAppend='';
                $.each(addresses,function(i,o){
                    toAppend += '<option value="'+o.strAddress+'">'+o.strAddress+'</option>';
                });
                $("#selectAddress").append(toAppend);
            };

            function setAlternativeAreaList(areas){
                var alternativeAreasList = $.map(JSON.parse(JSON.stringify(areas)), function (item) {
                    return {
                        // routeID: item.routeID,
                        // Route: item.Route,
                        id: item.Route,
                        text: item.Route
                    }
                });

                alternativeAreasList.unshift({ id: '', text: '' });

                $('#selectAltArea').empty().select2({
                    data: alternativeAreasList,
                    theme: 'bootstrap-5',
                    dropdownParent: $('#upliftmentModal'),
                });

                // $('#selectAltArea').flexdatalist({
                //     minLength: 1,
                //     valueProperty: '*',
                //     selectionRequired: true,
                //     focusFirstResult: true,
                //     searchContain:true,
                //     visibleProperties: ["routeID","Route"],
                //     searchIn: ["routeID","Route"],
                //     data: alternativeAreasList
                // });
            };

            function setInvoiceDataList(invoices){
                var invoiceList = $.map(JSON.parse(JSON.stringify(invoices)), function (item) {
                    return {
                        InvNumber: item.InvNumber
                    }
                });

                $('#inputInvoice').flexdatalist({
                    minLength: 1,
                    valueProperty: '*',
                    selectionRequired: true,
                    focusFirstResult: true,
                    searchContain:true,
                    visibleProperties: ["InvNumber"],
                    searchIn: ["InvNumber"],
                    data: invoiceList
                });
            };

            function setSalesOrderDataList(salesorders){
                var soList = $.map(JSON.parse(JSON.stringify(salesorders)), function (item) {
                    return {
                        value: item.OrderNum,
                        id: item.OrderNum,
                        text: item.InvNumber
                    };
                });

                soList.unshift({ value: '', id: '', text: '' });

                $('#selectSONumber').empty().select2({
                    data: soList,
                    theme: 'bootstrap-5',
                    dropdownParent: $('#upliftmentModal'),
                });
            };

            function setSalesOrderProductDataList(soProducts){
                var soProductList = $.map(JSON.parse(JSON.stringify(soProducts)), function (item) {
                    return {
                        id: item.Code,
                        text: item.Description_1
                    };
                });

                soProductList.unshift({ value: '', id: '', text: '' });

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

            $('#selectSONumber').on('change', function() {
                var SalesOrder = $('#selectSONumber').val();
                $.ajax({
                    url: '{!!url("/getUpliftmentSalesOrderLines")!!}',
                    type: "GET",
                    data: {
                        SalesOrder: SalesOrder,
                    },
                    success: function (data) {
                        // console.log(data)

                        setSalesOrderProductDataList(data);
                    }
                });
            });

            $('#selectSOProductCode').on('change', function() {
                var selectedProductCode = $('#selectSOProductCode').val();
                var selectedProduct = products.find(item => item.PastelCode === selectedProductCode);
                $('#inputSOProductQty').val(1);
                $('#inputSOProductWeight').val(parseFloat(selectedProduct.Weight).toFixed(3));
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

            $('#btnAddProduct').click(function(){
                // retrieve the input values and create a new row object
                var PastelCode = $('#inputProductCode').val();
                $('#inputProductCode').val('');
                var PastelDescription = $('#inputProductDescription').val();
                $('#inputProductDescription').val('');
                var Weight = $('#inputProductWeight').val();
                $('#inputProductWeight').val(0);
                var Qty = $('#inputProductQty').val();
                $('#inputProductQty').val(0);
                var Comment = $('#inputProductComment').val();
                $('#inputProductComment').val('');

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

            $('#btnAddSOProduct').click(function(){
                // retrieve the input values and create a new row object
                var PastelCode = $('#selectSOProductCode').val("");
                var PastelDescription = $('#selectSOProductCode option:selected').text("");
                $('#selectSOProductCode').val('');
                
                var Weight = $('#inputSOProductWeight').val();
                $('#inputSOProductWeight').val(0);
                var Qty = $('#inputSOProductQty').val();
                $('#inputSOProductQty').val(0);
                var Comment = $('#inputSOProductComment').val();
                $('#inputSOProductComment').val('');

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

            $('#btnSaveUpliftment').click(function(){
                var checkedLines = Array();
                checkedLines = gridProducts.option('dataSource');

                var gridResults = '<xml>';
                $.each(checkedLines ,function(key,value) {
                    if (value.Qty !=undefined || value.Qty !=null){
                        gridResults= gridResults + "<result>";
                        gridResults= gridResults + "<PastelCode>"+value.PastelCode+"</PastelCode>";
                        gridResults= gridResults + "<PastelDescription>"+value.PastelDescription+"</PastelDescription>";
                        gridResults= gridResults + "<Qty>"+value.Qty+"</Qty>";
                        gridResults= gridResults + "<Weight>"+value.Weight+"</Weight>";
                        gridResults= gridResults + "<Comment>"+value.Comment+"</Comment>";
                        gridResults= gridResults+ "</result>";
                    }
                });
                gridResults= gridResults+"</xml>";

                var formData = new FormData();

                // Append the file to the FormData object
                formData.append('file1', $('#inputPhoto1')[0].files[0]);
                formData.append('file2', $('#inputPhoto2')[0].files[0]);
                formData.append('file3', $('#inputPhoto3')[0].files[0]);

                // Append the other form data to the FormData object
                formData.append('dataxml', gridResults);
                formData.append('reasonpickup', $('#inputPickupReason').val());
                if ($('#selectAltArea').val().length > 0){
                    formData.append('area', $('#selectAltArea').val());
                }
                else{
                    formData.append('area', $('#inputArea').val());
                }
                
                if ($('#inputAltAddress').val().length > 0){
                    formData.append('address', $('#inputAltAddress').val());
                }
                else{
                    formData.append('address', $('#selectAddress').val());
                }
                if ($('#inputAltInvoice').val().length > 0){
                    formData.append('invoice', $('#inputAltInvoice').val());
                }
                else{
                    var invoice = $('#inputInvoice').flexdatalist('value');
                    formData.append('invoice', invoice.InvNumber);
                }
                
                var customer = $('#inputCustomer').flexdatalist('value');

                formData.append('customers', customer.CustomerCode);
                formData.append('company', $('#selectCompany').val());
                formData.append('date', $('#inputDate').val());

                $.ajax({
                    url: '{!!url("/insertUpliftmentAll")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            $('#btnUpdateUpliftment').click(function(){
                var checkedLines = Array();
                checkedLines = gridProducts.option('dataSource');

                console.log(checkedLines);

                var gridResults = '<xml>';
                $.each(checkedLines ,function(key,value) {
                    if (value.Qty !=undefined || value.Qty !=null){
                        gridResults= gridResults + "<result>";
                        gridResults= gridResults + "<PastelCode>"+value.PastelCode+"</PastelCode>";
                        gridResults= gridResults + "<PastelDescription>"+value.PastelDescription+"</PastelDescription>";
                        gridResults= gridResults + "<Qty>"+value.Qty+"</Qty>";
                        gridResults= gridResults + "<Weight>"+value.Weight+"</Weight>";
                        gridResults= gridResults + "<Comment>"+value.Comment+"</Comment>";
                        gridResults= gridResults+ "</result>";
                    }
                });
                gridResults= gridResults+"</xml>";

                var formData = new FormData();

                // Append the file to the FormData object
                formData.append('file1', $('#inputPhoto1')[0].files[0]);
                formData.append('file2', $('#inputPhoto2')[0].files[0]);
                formData.append('file3', $('#inputPhoto3')[0].files[0]);

                // Append the other form data to the FormData object
                formData.append('dataxml', gridResults);
                formData.append('reasonpickup', $('#inputPickupReason').val());
                if ($('#selectAltArea').val().length > 0){
                    formData.append('area', $('#selectAltArea').val());
                }
                else{
                    formData.append('area', $('#inputArea').val());
                }
                
                if ($('#inputAltAddress').val().length > 0){
                    formData.append('address', $('#inputAltAddress').val());
                }
                else{
                    formData.append('address', $('#selectAddress').val());
                }
                if ($('#inputAltInvoice').val().length > 0){
                    formData.append('invoice', $('#inputAltInvoice').val());
                }
                else{
                    var invoice = $('#inputInvoice').flexdatalist('value');
                    formData.append('invoice', invoice.InvNumber);
                }
                
                var customer = $('#inputCustomer').flexdatalist('value');

                formData.append('customers', customer.CustomerCode);
                formData.append('company', $('#selectCompany').val());
                formData.append('date', $('#inputDate').val());

                $.ajax({
                    url: '{!!url("/updateUpliftmentPost")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            $('#btnApproveUpliftment').click(function(){
                var formData = new FormData();
                formData.append('SelectedUpliftmentNumber',SelectedUpliftmentNumber);

                $.ajax({
                    url: '{!!url("/approveUpliftmentPost")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        location.reload();
                    }
                });
            });
            
            $('#btnPrintUpliftment').click(function(){

                var formData = new FormData();

                formData.append('SelectedUpliftmentNumber',SelectedUpliftmentNumber);
                $.ajax({

                    url: '{!!url("/printUpliftmentPost")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        window.open('{!!url("/retrieveUpliftmentPrint")!!}/'+SelectedUpliftmentNumber, 'width=800,height=600,resizable=yes,scrollbars=yes,status=yes');
                    }
                });
            });
            
            $('#btnCompleteUpliftment').click(function(){

                var formData = new FormData();

                formData.append('SelectedUpliftmentNumber',SelectedUpliftmentNumber);
                $.ajax({
                    url: '{!!url("/completeUpliftmentPost")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            $('#btnDenyUpliftment').click(function(){

                var formData = new FormData();

                formData.append('SelectedUpliftmentNumber',SelectedUpliftmentNumber);
                $.ajax({

                    url: '{!!url("/denyUpliftmentPost")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        location.reload();

                    }
                });
            });

            $('#btnUpliftmentImages').click(function(){
                window.open('{!!url("/upliftImageGetter")!!}/'+SelectedUpliftmentNumber, 'upliftimagegetter', "location=1,status=1,scrollbars=1, width=1200,height=850");
            });

            $('#btnEnquireUpliftment').click(function(){
                window.open('{!!url("/upliftEnquiry")!!}/'+SelectedUpliftmentNumber, 'upliftenquirygetter', "location=1,status=1,scrollbars=1, width=1200,height=850");
            });

            var viewPermission = '{{ $view }}';
            var makeUpliftment = '{{ $make }}';

            $.ajax({
                url: '{!!url("/getUpliftmentRecords")!!}',
                type: "GET",
                success: function (data) {
                    gridUpliftment.option('dataSource', data);
                    gridUpliftment.refresh();
                }
            });

            function getGridProducts(upliftmentNumber){
                $.ajax({
                    url: '{!!url("/getUpliftmentDetails")!!}',
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
            $('.closeUpliftmentModal', upliftmentModal).on('click', function () {
                upliftmentModal.hide();
                
                $('.form-control', upliftmentModal).val('');
                $('.form-select', upliftmentModal).val('default');
                $('.form-select', upliftmentModal).trigger('change.select2');
                $('.form-select', upliftmentModal).empty();

                gridProducts.option('dataSource', []);
                gridProducts.refresh();
            });

        });
    </script>
@endsection
