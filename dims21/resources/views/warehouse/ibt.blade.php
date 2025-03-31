
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
        <div class="modal fade modal-xl" id="IBTModal" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newuserLabel">Create IBT</h1>
                        <h3 class="modal-title fs-5" id="txtIBTNumber"></h3>
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
                                    <label class="control-label fw-bold" for="strReference">Reference</label>
                                    <input  class="form-control w-100" id="strReference" required>
                                </div>
                            </div>
                        </div>
                        <div class="row d-inline-flex border bg-light mt-3 mb-3 mx-1">
                            <label class="control-label fw-bold">By Products</label>
                            <div class="col-3 pe-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductCode">Code</label>
                                    <input type="text" class="form-control rounded-0 rounded-start" id="inputProductCode">
                                </div>
                            </div>
                            <div class="col-5 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductDescription">Description</label>
                                    <input type="text" class="form-control rounded-0" id="inputProductDescription">
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductQtyAvl">Qty Avl</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductQtyAvl" readonly>
                                </div>
                            </div>
                            <div class="col-1 p-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductQty">Qty</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductQty">
                                </div>
                            </div>
                            <div class="col-2 ps-0">
                                <div class="form-group mb-2">
                                    <label class="control-label" for="inputProductWeight">Weight</label>
                                    <input type="number" class="form-control rounded-0" id="inputProductWeight" readonly>
                                </div>
                            </div>
                            <div class="col-11 pe-0">
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
                            <div id="gridProducts"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btnUpdateIBT" class="btn btn-success" hidden>Update</button>
                        <button type="button" id="btnSaveIBT" class="btn btn-success" >Save</button>
                        <button type="button" class="btn btn-secondary closeIBTModal" data-bs-dismiss="modal">Close</button>
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

        $(document).ready(function() {
            let date = '';
            let reference = '';

            //This is use for disply the IBT list 
            const gridIBT = $("#gridIBT").dxDataGrid({
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
                            // Customize the text for the 'intUpliftmentNumber' column
                            var IbtHeaderId = cellInfo.value;
                            var numericPart = (100000+IbtHeaderId).toString().slice(-6);
                            return 'IBT'+numericPart;
                        },
                    },
                    {
                        dataField: "strReference",
                        caption: "Reference",
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
                        dataField: "dtmCreated",
                        caption: "Created Date",
                    },
                ],
                onRowRemoving: function(e) {

                },
                onRowDblClick: function(e) {
                    var IbtHeaderId = e.data.intAutoId;
                    SelectedIbtHeaderId = e.data.intAutoId;
                    $('#IBTModal').modal('toggle');
                    var numericPart = (1000000 + SelectedIbtHeaderId).toString().slice(-6);
                    $('#newuserLabel').text('Update IBT');
                    $('#txtIBTNumber').text('IBT' + numericPart);
                    $('#btnUpdateIBT').prop('hidden',false);
                    $('#btnSaveIBT').prop('hidden',true);
                    $('#inputDate').val(e.data.dtmCreated);
                    $('#strReference').val(e.data.strReference);
                    
                    getGridProducts(IbtHeaderId);
                },
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
                                onClick: function (args) {
                                    $('#IBTModal').modal('show');
                                    $('#IBTModal .modal-header .modal-title#newuserLabel').text('Create IBT');
                                    $('#btnSaveIBT').prop('hidden',false);
                                    $('#btnUpdateIBT').prop('hidden', true);
                                },
                            },
                        }
                    );
                }
            }).dxDataGrid('instance');

            //This is use for disply the Products list 
            gridProducts = $("#gridProducts").dxDataGrid({
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

            var SelectedIbtHeaderId = 0;
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
            $('#btnSaveIBT').click(function(){
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
                formData.append('strReference',$('#strReference').val())
                
                $.ajax({
                    url: '{!!url("/ibt")!!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            //This function is use for Update IBT Data with product
            $('#btnUpdateIBT').click(function(){
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
                console.log(SelectedIbtHeaderId);
                console.log(gridResults);
                console.log($('#inputDate').val());
                console.log($('#strReference').val());
                formData.append('SelectedIbtHeaderId',SelectedIbtHeaderId);
                formData.append('dataxml', gridResults);
                formData.append('dtmCreated', $('#inputDate').val());
                formData.append('strReference',$('#strReference').val())

                $.ajax({
                    url: '{!! url("update-ibt") !!}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        location.reload();
                    }
                });
            });

            getIbtRecords(gridIBT);

            // To clear and close the IBT modal
            $('#IBTModal').on('hidden.bs.modal', function() {
                $('#txtIBTNumber').text('');
                $('#btnUpdateIBT').prop('hidden',true);
                $('.form-control', IBTModal).val('');
                date = '';
                reference = '';
                gridProducts.option('dataSource', []);
                gridProducts.refresh();
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
            $.ajax({
                url: '{!!url("/getIBTDetails")!!}',
                type: 'GET',
                data: {
                    IbtHeaderId: IbtHeaderId
                },
                success: function(data) {
                    gridProducts.option('dataSource', data);
                    gridProducts.refresh();
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
    </script>
@endsection
