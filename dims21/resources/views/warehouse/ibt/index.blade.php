
@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'IBT')


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

        <div class="grid" id="gridIBT"></div>
        <!-- IBT Modal -->
        <div class="modal fade modal-xl extra-large" id="IBTModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
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
                            <div class="col-6 tlnumber_container">
                                <div class="form-group mb-2">
                                    <label class="control-label fw-bold" for="strTlNumber">TL Number</label>
                                    <input  class="form-control w-100 strTlNumber" id="strTlNumber" required>
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
                                    <button class="btn btn-success rounded-0 rounded-end w-100" id="btnAddProduct">ADD</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="gridProducts"></div>
                        </div>
                    </div>
                    <input type="text" id="intStatus" hidden>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closeIBTModal" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="btnReceivedIBT" class="btn btn-success" hidden>Received</button>
                        <button type="button" id="btnUpdateIBT" class="btn btn-success" hidden>Update</button>
                        <button type="button" id="btnSaveIBT" class="btn btn-success" >Save</button>
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
        var products = JSON.parse(JSON.stringify({!! json_encode($products) !!}));
        var productsList = $.map(products, function (item) {
            return {
                PastelCode: item.PastelCode,
                PastelDescription: item.PastelDescription,
                Weight: item.Weight,
                qtyavl:item.qtyavl
            };
        });
        var gridProducts;
        var selectedStatus = "";
        var SelectedIbtHeaderId = null;
        var selectedIBTRowDetails = null;
        $(document).ready(function() {
            $('#IBTModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#IBTModal'),
                });
            });
            //This is use for disply the IBT list
            let showReceivedButton = false;
            const gridIBT = $("#gridIBT").dxDataGrid({
                dataSource: [],
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
                            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'IBT.xlsx');
                        });
                    });
                    e.cancel = true;
                },
                columns: [
                    {
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
                        dataField: "gitstrLocationName",
                        caption: "GIT",
                    },
                    {
                        dataField: "strLocationName",
                        caption: "Variance",
                    },
                    {
                        dataField: "strStatus",
                        caption: "Status",
                    },
                    {
                        dataField: "Username",
                        caption: "Created By",
                    },
                    {
                        dataField: "strTlNumber",
                        caption: "TL Number",
                        visible: false,
                    },
                    {
                        dataField: "dtmCreated",
                        caption: "Created Date",
                        customizeText: function(cellInfo) {
                            const date = new Date(cellInfo.value);
                            if (!isNaN(date)) {
                                const day = ("0" + date.getDate()).slice(-2);
                                const month = ("0" + (date.getMonth() + 1)).slice(-2); // Months are 0-based
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            }
                            return cellInfo.value;
                        }
                    }
                ],
                onRowRemoving: function (e) { },
                // onToolbarPreparing should manage toolbar items based on the flag
                onToolbarPreparing: function (e) {
                    e.toolbarOptions.items.unshift(
                        {
                            location: 'before',
                            template: function () {
                                return $('<h3>').text('IBT');
                            }
                        }
                    );
                    e.toolbarOptions.items.push(
                        {
                            location: 'after',
                            widget: "dxButton",
                            options: {
                                icon: "fa fa-plus",
                                text: "ADD",
                                onClick: function () {
                                    modalPopupShow('add');
                                },
                            },
                        }
                    );
                    let receivedButton = {
                        location: 'after',
                        widget: "dxButton",
                        options: {
                            text: "Received",
                            onClick: function () {
                                modalPopupShow('received', selectedIBTRowDetails);
                            },
                        }
                    };
                    if (showReceivedButton) {
                        e.toolbarOptions.items.push(receivedButton);
                    }
                },
                onRowDblClick: function (e) {
                    if (e.data.strStatus == "Pending") {
                        modalPopupShow('update', e);
                    } else {
                        modalPopupShow('show', e);
                    }
                },
                onRowClick: function (e) {
                    if (e.data && e.data.strStatus === "Issued") {
                        showReceivedButton = true;
                        selectedStatus = e.data.strStatus;
                        SelectedIbtHeaderId = e.data.intAutoId;
                        selectedIBTRowDetails = e;
                        e.component.repaint();
                    } else {
                        showReceivedButton = false;
                        setTimeout(function () {
                            e.component.repaint();
                        }, 20);
                    }
                },
            }).dxDataGrid('instance');

            //This is use for disply the Products list
            gridProducts = $(".gridProducts").dxDataGrid({
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
                    mode: "cell",
                    allowUpdating: true,
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
                        dataField: "intQtyReceived",
                        caption: "Qty Received",
                        allowEditing: false,
                    },
                    {
                        dataField: "intQtyVariance",
                        caption: "Qty Variance",
                        allowEditing: false,
                    }
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
                },
                onRowUpdating: function (e) {
                    console.log(e)
                    // Check if the updated field is 'intQtyReceived'
                    var updatedField = e.newData.intQtyReceived; // Get the new value of 'intQtyReceived'
                    var oldQtyReceived = e.oldData.intQtyReceived; // Get the old value of 'intQtyReceived'

                    // If 'intQtyReceived' was updated, calculate 'intQtyVariance'
                    if (updatedField !== oldQtyReceived) {
                        var qty = e.oldData.Qty || 0; // Assuming 'Qty' is the base quantity
                        var intQtyReceived = e.newData.intQtyReceived || 0;

                        // Calculate the variance
                        var intQtyVariance = qty - intQtyReceived;

                        // Update the 'intQtyVariance' value
                        e.newData.intQtyVariance = intQtyVariance;
                    }
                },
                onRowUpdated: function(e) {
                    return $.ajax({
                        url: '{!! url("ibt/update-ibt-lines") !!}',
                        type: 'POST',
                        data: {
                            intAutoId: e.data.intAutoId,
                            intQtyReceived: e.data.intQtyReceived,
                            intQtyVariance: e.data.intQtyVariance,
                        },
                        success: function (data) {
                            console.log("Update success:", data);
                            return data;
                        },
                        error: function () {
                            alert("Error updating record.");
                        }
                    });
                }
            }).dxDataGrid('instance');

            setProductsDataList(productsList);

            //change qty Weight wiil change with use of this function
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

            //This function is use for Save IBT product
            $('#btnAddProduct').click(function() {
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
            });

            //This function is use for Save IBT data with product and convet product to xml and append into formData
            $('#btnSaveIBT').click(function() {
                loadingPanel.option('visible', true);
                var checkedLines = Array();
                checkedLines = gridProducts.option('dataSource');
                var gridResults = '<xml>';
                $.each(checkedLines ,function(key,value) {
                    if (value.Qty !=undefined || value.Qty !=null){
                        gridResults= gridResults + "<result>";
                        gridResults= gridResults + "<PastelCode>"+escapeHtml(value.PastelCode)+"</PastelCode>";
                        gridResults= gridResults + "<Qty>"+value.Qty+"</Qty>";
                        gridResults= gridResults + "<Weight>"+value.Weight+"</Weight>";
                        gridResults= gridResults + "<Comment>"+escapeHtml(value.Comment)+"</Comment>";
                        gridResults= gridResults+ "</result>";
                    }
                });
                gridResults= gridResults+"</xml>";

                var formData = new FormData();
                // Append the other form data to the FormData object
                formData.append('dataxml', gridResults);
                formData.append('dtmCreated', $('#inputDate').val());
                formData.append('strReference',$('#strReference').val());
                formData.append('intFromDC',$('#intFromDC').val());
                formData.append('intToDC',$('#intToDC').val());
                formData.append('intGIT',$('#intGIT').val());
                formData.append('intVariance',$('#intVariance').val());
                formData.append('intStatus',$('#intStatus').val());

                $.ajax({
                    url: '{!!url("/ibt")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        loadingPanel.option('visible', true);
                        location.reload();
                    },
                    complete: function() {
                        // Hide the loading panel
                        loadingPanel.option('visible', false);
                    }
                });
            });

            //This function is use for Update IBT Data with product
            $('#btnUpdateIBT').click(function(){
                loadingPanel.option('visible', true);
                var checkedLines = Array();
                checkedLines = gridProducts.option('dataSource');
                var gridResults = '<xml>';
                $.each(checkedLines ,function(key,value) {
                    if (value.Qty !=undefined || value.Qty !=null){
                        gridResults= gridResults + "<result>";
                        gridResults= gridResults + "<PastelCode>"+escapeHtml(value.PastelCode)+"</PastelCode>";
                        gridResults= gridResults + "<Qty>"+value.Qty+"</Qty>";
                        gridResults= gridResults + "<Weight>"+value.Weight+"</Weight>";
                        gridResults= gridResults + "<Comment>"+escapeHtml(value.Comment)+"</Comment>";
                        gridResults= gridResults+ "</result>";
                    }
                });
                gridResults= gridResults+"</xml>";

                var formData = new FormData();
                formData.append('SelectedIbtHeaderId',SelectedIbtHeaderId);
                formData.append('dataxml', gridResults);
                formData.append('dtmCreated', $('.inputDate').val());
                formData.append('strReference',$('.strReference').val());
                formData.append('intFromDC',$('.intFromDC').val());
                formData.append('intToDC',$('.intToDC').val());
                formData.append('intGIT',$('.intGIT').val());
                formData.append('intVariance',$('.intVariance').val());
                if ($('#intStatus').val() != '') {
                    formData.append('intStatus',$('#intStatus').val());
                }
                if ($('.strTlNumber') != '') {
                    formData.append('strTlNumber',$('.strTlNumber').val());
                }


                $.ajax({
                    url: '{!! url("ibt/update-ibt") !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        loadingPanel.option('visible', true);
                        location.reload();
                    },
                    complete: function() {
                        // Hide the loading panel
                        loadingPanel.option('visible', false);
                    }
                });
            });

            getIbtRecords(gridIBT);

            // To clear and close the IBT modal
            $('#IBTModal').on('hidden.bs.modal', function() {
                $('.txtIBTNumber').text('');
                $('#btnUpdateIBT').prop('hidden',true);
                $('.form-control', IBTModal).val('');
                $('.intFromDC').val('');
                $('.intToDC').val('');
                $('.intGIT').val('');
                $('.intVariance').val('');
                gridProducts.option('dataSource', []);
                gridProducts.refresh();
            });

            $('#btnReceivedIBT').click(function() {
                loadingPanel.option('visible', true);
                $.ajax({
                    url: '{!!url("/ibt/update-status")!!}',
                    type: "POST",
                    data: {
                        intStatus: 3,
                        SelectedIbtHeaderId: SelectedIbtHeaderId,
                    },
                    success: function (data) {
                        loadingPanel.option('visible', true);
                        location.reload();
                    },
                    complete: function() {
                        // Hide the loading panel
                        loadingPanel.option('visible', false);
                    }
                });
            });
        });

        //This function is use for get ibt records
        function getIbtRecords(gridIBT) {
            // Ajax call for Get IBT Records
            $.ajax({
                url: '{!!url("/getIBTRecords")!!}',
                type: "GET",
                success: function (data) {
                    gridIBT.option('dataSource', data);
                    gridIBT.refresh();
                }
            });
        }

        //This function is use for set Products list
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

        //Get IBT Details on time of upadte IBT
        function getGridProducts(IbtHeaderId){
            loadingPanel.option('visible', true);
            $.ajax({
                url: '{!!url("/getIBTDetails")!!}',
                type: 'GET',
                data: {
                    IbtHeaderId: IbtHeaderId
                },
                success: function(data) {
                    gridProducts.option('dataSource', data);
                    gridProducts.refresh();
                },
                complete: function() {
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
                $('#inputDate').val(e.data.dtmCreated);
                $('#strReference').val(e.data.strReference);
                $('#intFromDC').val(e.data.intFromDC);
                $('#intToDC').val(e.data.intToDC);
                $('#intGIT').val(e.data.intGIT);
                $('#intVariance').val(e.data.intVariance);
                $('#strTlNumber').val(e.data.strTlNumber);
                getGridProducts(e.data.intAutoId);
            }
            $('#strTlNumber').attr('disabled', true);
            $(".tlnumber_container").hide();
            if (action != 'show') {
                $('#inputDate').removeAttr('disabled');
                $('#strReference').removeAttr('disabled');
                $('#intFromDC').removeAttr('disabled');
                $('#intToDC').removeAttr('disabled');
                $('#intGIT').removeAttr('disabled');
                $('#intVariance').removeAttr('disabled');
            }
            if (action == 'add') {
                $('#IBTModal .modal-header .modal-title#newuserLabel').text('Create IBT');
                $('#btnSaveIBT').prop('hidden', false);
                $('#btnUpdateIBT').prop('hidden', true);
                $('#btnReceivedIBT').prop('hidden', true);
                $('.txtIBTNumber').text('');
                $('.form-control', IBTModal).val('');
                $('.intFromDC').val('');
                $('.intToDC').val('');
                $('.intGIT').val('');
                $('.intVariance').val('');
                $(".add_product_section").removeClass('d-none');
                gridProducts.option('dataSource', []);
                gridProducts.refresh();
            } else if(action == 'update') {
                $('#newuserLabel').text('Update IBT');
                $('#btnSaveIBT').prop('hidden', true);
                $('#btnUpdateIBT').prop('hidden', false);
                $('#btnReceivedIBT').prop('hidden', true);
                $(".add_product_section").removeClass('d-none');
            } else if(action == 'received') {
                $('#newuserLabel').text('Received IBT');
                $('#btnSaveIBT').prop('hidden', true);
                $('#btnUpdateIBT').prop('hidden', true);
                $('#btnReceivedIBT').prop('hidden', false);
            } else if(action == 'show') {
                $('#newuserLabel').text('IBT Details');
                $('#btnSaveIBT').prop('hidden', true);
                $('#btnUpdateIBT').prop('hidden', true);
                $('#btnReceivedIBT').prop('hidden', true);
            }
            if(action == 'received' || action == 'show') {
                $(".add_product_section").addClass('d-none');
                gridProducts.option("editing.allowDeleting", false);
                $('#inputDate').attr('disabled', true);
                $('#strReference').attr('disabled', true);
                $('#intFromDC').attr('disabled', true);
                $('#intToDC').attr('disabled', true);
                $('#intGIT').attr('disabled', true);
                $('#intVariance').attr('disabled', true);
                $(".tlnumber_container").show();
            }
            gridProducts.columnOption("Qty", "caption", "Qty");
            gridProducts.columnOption("intQtyReceived", "visible", false);
            gridProducts.columnOption("intQtyVariance", "visible", false);
            if ((e != undefined && e.data.strStatus === "Received") || action == 'received') {
                gridProducts.columnOption("Qty", "caption", "Qty Issued");
                gridProducts.columnOption("intQtyReceived", "visible", true);
                gridProducts.columnOption("intQtyVariance", "visible", true);
            }
            gridProducts.columnOption("intQtyReceived", "allowEditing", false);
            if (action == 'received') {
                gridProducts.columnOption("intQtyReceived", "allowEditing", true);
            }
        }
    </script>
@endsection
