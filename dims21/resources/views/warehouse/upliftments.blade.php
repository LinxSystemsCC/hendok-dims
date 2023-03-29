<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
    <title>Upliftments</title>
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <!-- DevExtreme theme -->
    {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.carmine.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.contrast.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkmoon.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.darkviolet.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.greenmist.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.blue.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.lime.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.dark.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.purple.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.dark.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.teal.light.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.softblue.css" rel="stylesheet"> --}}

</head>

<div class="col-lg-12"  style="background: white;">
    <div class="col-lg-2"  style="background: white;">
        <div class="vertical-menu">
            @include('warehouse.menu')
        </div>
    </div>
    <div class="col-lg-10" >
        <div class="col-lg-12 d-inline-flex" >
            <h3 style="flex-grow: 1; padding-left: 15px;">Upliftments</h3>
            <!-- Button trigger modal -->
            <button type="button" id="newupliftmentbutton"class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newarea">
                New Upliftment
            </button>
        </div>
        
        <div id="gridContainer" style=""></div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-xl" id="newarea" tabindex="-1" aria-labelledby="newuserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newuserLabel">Create/Edit Upliftment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="d-inline-flex w-100 px-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="upliftmentactioncollect" checked value="Collect Stock">
                    <label class="form-check-label" for="upliftmentactioncollect">
                        Collect
                    </label>
                </div>

                <div class="form-check" style="padding-left: 50px;">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="upliftmentactiondeliver" value="Deliver Stock">
                    <label class="form-check-label" for="upliftmentactiondeliver"> 
                        Deliver
                    </label>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="upliftreason"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Upliftment Reason</label>
                    <select  class="form-select input-sm col-xs-1 " id="upliftreason" style="width: 60%" >
                        <option value="Upliftment">Upliftment</option>
                        <option value="Misc">Miscellaneous</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="date"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Date</label>
                    <input  type="date" class="form-control input-sm col-xs-1" id="date">
                </div>
                <div class="form-group">
                    <label class="control-label" for="company"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Company</label>
                    <select  class="form-select input-sm col-xs-1 " id="company" style="width: 60%" >
                        <option></option>
                        @foreach($companies as $val)
                        <option value="{{$val->companyname}}">{{$val->companyname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="customers">Customer Name</label>
                    <input  class="form-control input-sm col-xs-1" id="customers" style="width: 100%" required>
                    
                </div>
                <div class="form-group">
                    <label class="control-label" for="selectedarea">Selected Area</label>
                    <input readonly  class="form-control input-sm col-xs-1" id="selectedarea" style="width: 100%" required>
                    
                </div>
                <div class="form-group">
                    <label class="control-label" for="area">Custom Area Selection</label>
                    <input  class="form-control input-sm col-xs-1" id="area" style="width: 100%" required>
                </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="address">Address Name</label>
                    <select  class="form-select" id="address" style="width: 100%" required>
                    <option></option>
                </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="altaddress">Alternative Address Name</label>
                    <textarea  class="form-control input-sm col-xs-1" id="altaddress" style="width: 100%" required></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="invoice"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Invoice</label>
                    <input  class="form-control input-sm col-xs-1" id="invoice" style="width: 100%" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="reasonpickup"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Reason for Pickup</label>
                    <textarea   class="form-control input-sm col-xs-1" id="reasonpickup"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="uploadphoto1"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Upload a First Photo</label>
                    <input type="file" name="photo" class="form-control-file" id="uploadphoto1">
                </div>
                <div class="form-group">
                    <label class="control-label" for="uploadphoto2"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Upload a Second Photo</label>
                    <input type="file" name="photo" class="form-control-file" id="uploadphoto2">
                </div>
                <div class="form-group">
                    <label class="control-label" for="uploadphoto3"  style="margin-bottom: 0px;font-weight: 700;font-size: 15px;">Upload a Third Photo</label>
                    <input type="file" name="photo" class="form-control-file" id="uploadphoto3">
                </div>
                <div class="form-group form-inline">
                    <label class="control-label" for="inputProdCode" style="margin-right: 10px;font-weight: 700;font-size: 15px;">Add Product</label>
                    <br>
                    <input class="form-control input-sm" id="inputProdCode" placeholder="Product Code"  required style="width: 10%">
                    <input class="form-control input-sm" id="inputProdDesc" placeholder="Product Description"  required style="width: 30%">
                    <input readonly type="number" class="form-control input-sm" id="inputProdWeight" placeholder="Weight"  required style="width: 15%">
                    <input readonly type="number" class="form-control input-sm" id="inputProdWeightHidden" placeholder="Weight"  required style="width: 15%" hidden>
                    <input type="number" class="form-control input-sm" id="inputProdQty" placeholder="Quantity" required style="width: 20%">
                    <input  class="form-control input-sm" id="inputProdComment" placeholder="Comment" required style="width: 20%">
                </div>
                
                <button type="button" id="savetempproducts" class="btn btn-success" >Add</button>
                <button type="button" id="savetempproductsCurrent" class="btn btn-success" hidden >Add</button>
                <div style="width: 100%; height: 5%;" id="gridBox"></div>
                <div style="width: 100%; height: 5%;" id="gridBoxCurrent"></div>

            <div class="modal-footer">
                <button type="button" id="updateupliftment" class="btn btn-success" hidden>Update</button>
                <button type="button" id="imageupliftment" class="btn btn-success" hidden>Images</button>
                <button type="button" id="enquireupliftment" class="btn btn-success" hidden>Enquiry</button>
                <button type="button" id="backlogupliftment" class="btn btn-success" hidden>Backlog</button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="savesupliftment" class="btn btn-success" >Save</button>
            </div>
        </div>
    </div>
</div>

<style>
    .dx-datagrid-table{
        font-size:15px;
    }

    .dx-datagrid .dx-link {
        color: #df2413;
    }

    .dx-pager .dx-page-sizes .dx-selection, .dx-pager .dx-pages .dx-selection {
        font-weight: 500;
        background-color: #df2413;
        color: #fff;
    }

    .dx-datagrid-filter-panel .dx-datagrid-filter-panel-text {
        color: #df2413;
        font-size: 14px;
        line-height: 18px;
    }

    .dx-datagrid {
        height: calc(100vh - 63px);
        max-height: calc(100vh - 63px);
    }
    .form-inline .form-control {
        display: inline-block;
        width: auto;
        vertical-align: middle;
    }
</style>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<link href="{{ asset('css/jquery.flexdatalist.min.css') }}" rel="stylesheet"  type='text/css'>    
<script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.dialogextend.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
    
    var jArray = JSON.stringify({!! json_encode($products) !!});
    var finalDataProduct = $.map(JSON.parse(jArray), function (item) {
        return {
            PastelCode: item.PastelCode,
            PastelDescription: item.PastelDescription,
            Weight: item.Weight,
        }

    });
    $(document).ready(function() {
        var SelectedUpliftmentNumber = 0;
        $("#savetempproducts").click(function() {
            if ($('#inputProdCode').val().length>0 && $('#inputProdDesc').val().length>0 && $('#inputProdWeight').val()!=0 && $('#inputProdQty').val()!=0 )
                {
                    // retrieve the input values and create a new row object
                    var Code = $('#inputProdCode').val();
                    $('#inputProdCode').val('');
                    var Name = $('#inputProdDesc').val();
                    $('#inputProdDesc').val('');
                    var Weight = $('#inputProdWeight').val();
                    $('#inputProdWeight').val(0);
                    var Quantity = $('#inputProdQty').val();
                    $('#inputProdQty').val(0);
                    var Comment = $('#inputProdComment').val();
                    $('#inputProdComment').val('');
                    var newRow = { Code: Code, Name: Name, Quantity:Quantity,Weight: Weight,Comment:Comment};

                    // add the new row to the data source and refresh the Datagrid
                    var grid = $("#gridBox").dxDataGrid("instance");
                    if (grid) {
                        var dataSource = grid.getDataSource();
                        console.log(dataSource);
                        dataSource.store().insert(newRow);
                        dataSource.reload();
                    } else {
                        console.log('Datagrid not found.');
                    }
                }
        });
        $("#savetempproductsCurrent").click(function() {
            if ($('#inputProdCode').val().length>0 && $('#inputProdDesc').val().length>0 && $('#inputProdWeight').val()!=0 && $('#inputProdQty').val()!=0 )
                {
                    // retrieve the input values and create a new row object
                    var Code = $('#inputProdCode').val();
                    $('#inputProdCode').val('');
                    var Name = $('#inputProdDesc').val();
                    $('#inputProdDesc').val('');
                    var Weight = $('#inputProdWeight').val();
                    $('#inputProdWeight').val(0);
                    var Quantity = $('#inputProdQty').val();
                    $('#inputProdQty').val(0);
                    var Comment = $('#inputProdComment').val();
                    $('#inputProdComment').val('');
                    var newRow = { PastelCode: Code, PastelDescription: Name, Qty:Quantity,Weight: Weight,Comment:Comment};

                    // add the new row to the data source and refresh the Datagrid
                    var grid = $("#gridBoxCurrent").dxDataGrid("instance");
                    if (grid) {
                        var dataSource = grid.getDataSource();
                        console.log(dataSource);
                        dataSource.store().insert(newRow);
                        dataSource.reload();
                    } else {
                        console.log('Datagrid not found.');
                    }
                }
        });
        var inputProduct = $('#inputProdCode').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,
            visibleProperties: ["PastelCode","PastelDescription"],
            searchIn: ["PastelCode","PastelDescription"],
            data: finalDataProduct
        });
        inputProduct.on('select:flexdatalist', function (event, data) {
            //fill in inputs of code desc weight, empty qty empty comment..
            $('#inputProdCode').val(data.PastelCode);
            $('#inputProdDesc').val(data.PastelDescription);
            $('#inputProdWeightHidden').val(data.Weight);
        });
        var inputProductDesc = $('#inputProdDesc').flexdatalist({
            minLength: 1,
            valueProperty: '*',
            selectionRequired: true,
            focusFirstResult: true,
            searchContain:true,
            visibleProperties: ["PastelCode","PastelDescription"],
            searchIn: ["PastelCode","PastelDescription"],
            data: finalDataProduct
        });
        inputProductDesc.on('select:flexdatalist', function (event, data) {
            //fill in inputs of code desc weight, empty qty empty comment..
            $('#inputProdCode').val(data.PastelCode);
            $('#inputProdDesc').val(data.PastelDescription);
            $('#inputProdWeightHidden').val(data.Weight);
        });
                    $("#company").change(function () {
                        var jArrayCustomers="";
                        $.ajax({
                        
                            url: '{!!url("/getCustomerForSelectedCompany")!!}',
                            type: "POST",
                            data: {
                                company: $("#company").val()
                            },
                            success: function (datacustomerdata) {
                                $("#customers").empty();
                                $("#invoice").empty();
                                $("#address").empty();
                                $("#area").empty();
                                $("#selectedarea").empty();
                                
                                jArrayCustomers = JSON.stringify(datacustomerdata);
                                var finalDataCustomer = $.map(JSON.parse(jArrayCustomers), function (item) {
                                    return {
                                        CustomerCode: item.CustomerPastelCode,
                                        StoreName: item.StoreName,
                                    }

                                });

                                var inputCustomerCompany = $('#customers').flexdatalist({
                                    minLength: 1,
                                    valueProperty: '*',
                                    selectionRequired: true,
                                    focusFirstResult: true,
                                    searchContain:true,
                                    visibleProperties: ["CustomerCode","StoreName"],
                                    searchIn: ["CustomerCode","StoreName"],
                                    data: finalDataCustomer
                                });
                                $('#customers').val('').trigger('reset');
                                inputCustomerCompany.on('select:flexdatalist', function (event, data) {
                                    console.log("using flexlist within company change");
                                    //fill in inputs of code desc weight, empty qty empty comment..
                                    $('#customers').val(data.CustomerCode);
                                    $.ajax({

                            url: '{!!url("/getAreaAddressInvoiceInfoParam")!!}',
                            type: "POST",
                            data: {
                                customer: $("#customers").val(),
                                company: $("#company").val()
                            },
                            success: function (data) {

                                var jArrayAreas = JSON.stringify(data.routes);
                                var finalDataAreas = $.map(JSON.parse(jArrayAreas), function (item) {
                                    return {
                                        routeID: item.routeID,
                                        Route: item.Route,
                                    }

                                });
                                var inputAreas = $('#area').flexdatalist({
                                    minLength: 1,
                                    valueProperty: '*',
                                    selectionRequired: true,
                                    focusFirstResult: true,
                                    searchContain:true,
                                    visibleProperties: ["routeID","Route"],
                                    searchIn: ["routeID","Route"],
                                    data: finalDataAreas
                                });
                                
                                inputAreas.on('select:flexdatalist', function (event, data) {
                                    //fill in inputs of code desc weight, empty qty empty comment..
                                    $('#area').val(data.Route);
                                });

                                $("#address").empty();
                                var toAppend='';
                                $.each(data.addresses,function(i,o){

                                    toAppend += '<option value="'+o.strAddress+'">'+o.strAddress+'</option>';
                                });
                                $("#address").append(toAppend);

                                $("#invoice").empty();
                                var jArrayInvoices = JSON.stringify(data.invoices);
                                
                                var finalDataInvoices = $.map(JSON.parse(jArrayInvoices), function (item) {
                                    return {
                                        InvNumber: item.InvNumber
                                    }

                                });
                                var inputInvoices = $('#invoice').flexdatalist({
                                    minLength: 1,
                                    valueProperty: '*',
                                    selectionRequired: true,
                                    focusFirstResult: true,
                                    searchContain:true,
                                    visibleProperties: ["InvNumber"],
                                    searchIn: ["InvNumber"],
                                    data: finalDataInvoices
                                });
                                
                                inputInvoices.on('select:flexdatalist', function (event, data) {
                                    //fill in inputs of code desc weight, empty qty empty comment..
                                    $('#invoice').val(data.InvNumber);
                                });

                                $("#selectedarea").val();
                                $.each(data.areas,function(i,o){

                                    $("#selectedarea").val(o.Route);
                                });

                                
                            }
                        });

                        
                                });
                                
                            }
                        });

                    });
                    $("#inputProdQty").change(function(){
                        $('#inputProdWeight').val($('#inputProdQty').val()*$('#inputProdWeightHidden').val())
                    });
                    
                    $('#newupliftmentbutton').click(function(){

                        $('#savetempproductsCurrent').prop('hidden',true);
                        $('#savetempproducts').prop('hidden',false);
                        createDataGrid();
                        $('#imageupliftment').prop('hidden',true);
                        $('#updateupliftment').prop('hidden',true);
                        $('#enquireupliftment').prop('hidden',true);
                        $('#backlogupliftment').prop('hidden',true);
                        $('#savesupliftment').prop('hidden',false);
                        
                        $('#invoice').val('');
                        $('#reasonpickup').val('');
                        $('#area').val('');
                        $('#selectedarea').val('');
                        $('#altaddress').val('');
                        $('#address').val('');
                        $('#customers').val('');
                        $('#company').val('');
                        $('#date').val('');
                        $('#upliftreason').val('');
                    });
                    $('#savesupliftment').click(function(){
            var checkedLines = Array();
            var grid = $("#gridBox").dxDataGrid("getDataSource").store().load().done(function (data) {
                checkedLines= data;
                });
                var gridResults = '<xml>';
                $.each(checkedLines ,function(key,value) {
                    if (value.Quantity !=undefined || value.Quantity !=null){
                    gridResults= gridResults + "<result>";
                    gridResults= gridResults + "<PastelCode>"+value.Code+"</PastelCode>";
                    gridResults= gridResults + "<PastelDescription>"+value.Name+"</PastelDescription>";
                    gridResults= gridResults + "<Qty>"+value.Quantity+"</Qty>";
                    gridResults= gridResults + "<Weight>"+value.Weight+"</Weight>";
                    gridResults= gridResults + "<Comment>"+value.Comment+"</Comment>";
                    gridResults= gridResults+ "</result>";
                }
                });
                    gridResults= gridResults+"</xml>";
                    var selectedaction="";
                    var upliftmentAction = $('input[name="flexRadioDefault"]:checked').val();


                    if (upliftmentAction === "Collect Stock") {
                        selectedaction="Collect";
                    } else if (upliftmentAction === "Deliver Stock") {
                        selectedaction="Deliver";  
                    }
                    var formData = new FormData();

                        // Append the file to the FormData object
                        formData.append('file1', $('#uploadphoto1')[0].files[0]);
                        formData.append('file2', $('#uploadphoto2')[0].files[0]);
                        formData.append('file3', $('#uploadphoto3')[0].files[0]);

                        // Append the other form data to the FormData object
                        formData.append('dataxml', gridResults);
                        formData.append('invoice', $('#invoice').val());
                        formData.append('reasonpickup', $('#reasonpickup').val());
                        if ($('#area').val().length > 0){
                        formData.append('area', $('#area').val());
                        }
                        else {
                        formData.append('area', $('#selectedarea').val());
                        }
                        
                        if ($('#altaddress').val().length > 0){
                        formData.append('address', $('#altaddress').val());
                        }
                        else {
                        formData.append('address', $('#address').val());
                        }
                        
                        formData.append('customers', $('#customers').val());
                        formData.append('company', $('#company').val());
                        formData.append('date', $('#date').val());
                        formData.append('upliftreason', $('#upliftreason').val());
                        formData.append('upliftmentaction', selectedaction); 
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
        $('#updateupliftment').click(function(){
            var checkedLines = Array();
            var grid = $("#gridBoxCurrent").dxDataGrid("getDataSource").store().load().done(function (data) {
                checkedLines= data;
                });
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
                    
                    var selectedaction="";
                    var upliftmentAction = $('input[name="flexRadioDefault"]:checked').val();


                    if (upliftmentAction === "Collect Stock") {
                        selectedaction="Collect";
                    } else if (upliftmentAction === "Deliver Stock") {
                        selectedaction="Deliver";  
                    }
                    var formData = new FormData();

                        // Append the file to the FormData object
                        formData.append('file1', $('#uploadphoto1')[0].files[0]);
                        formData.append('file2', $('#uploadphoto2')[0].files[0]);
                        formData.append('file3', $('#uploadphoto3')[0].files[0]);

                        // Append the other form data to the FormData object
                        formData.append('dataxml', gridResults);
                        formData.append('invoice', $('#invoice').val());
                        formData.append('reasonpickup', $('#reasonpickup').val());
                        if ($('#area').val().length > 0){
                        formData.append('area', $('#area').val());
                        }
                        else {
                        formData.append('area', $('#selectedarea').val());
                        }
                        
                        if ($('#altaddress').val().length > 0){
                        formData.append('address', $('#altaddress').val());
                        }
                        else {
                        formData.append('address', $('#address').val());
                        }
                        
                        formData.append('customers', $('#customers').val());
                        formData.append('company', $('#company').val());
                        formData.append('date', $('#date').val());
                        formData.append('upliftreason', $('#upliftreason').val());
                        formData.append('upliftmentaction', selectedaction); 
                        formData.append('SelectedUpliftmentNumber',SelectedUpliftmentNumber);
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
        
        $.ajax({

            url: '{!!url("/getUpliftmentRecords")!!}',
            type: "GET",
            success: function (data) {

                $("#gridContainer").dxDataGrid({

                    dataSource:data, //as json
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
                        }, {
                            dataField: "dteUpliftDate",
                            caption: "Uplift Date",
                        }
                        , {
                            dataField: "strUpliftAction",
                            caption: "Uplift Action",
                        },{
                            dataField: "strReasonUpliftment",
                            caption: "Upliftment Reason",
                        },{
                            dataField: "strReasonPickup",
                            caption: "Upliftment Description",
                        },{
                            dataField: "strCompany",
                            caption: "Company",
                        },{
                            dataField: "strCustomer",
                            caption: "Customer",
                        },{
                            dataField: "strArea",
                            caption: "Area",
                        },{
                            dataField: "strAddress",
                            caption: "Address",
                        },{
                            dataField: "strInvoice",
                            caption: "Invoice Number",
                        },{
                            dataField: "strUpliftmentStatus",
                            caption: "Upliftment Status",
                        },{
                            dataField: "Username",
                            caption: "User",
                        },
                        
                    ],
                    onRowDblClick: function(e) {
                        var upliftmentNumber = e.data.intUpliftmentNumber;
                        SelectedUpliftmentNumber = e.data.intUpliftmentNumber;
                        $('#newarea').modal('toggle');
                        $('#updateupliftment').prop('hidden',false);
                        $('#imageupliftment').prop('hidden',false);
                        $('#enquireupliftment').prop('hidden',false);
                        $('#backlogupliftment').prop('hidden',false);
                        $('#savesupliftment').prop('hidden',true);
                        $('#savetempproductsCurrent').prop('hidden',false);
                        $('#savetempproducts').prop('hidden',true);

                        $('#invoice').val(e.data.strInvoice);
                        $('#reasonpickup').val(e.data.strReasonPickup);
                        $('#area').val(e.data.strArea);
                        $('#selectedarea').val(e.data.strArea);
                        $('#altaddress').val(e.data.strAddress);
                        $('#customers').val('').trigger('reset');
                        $('#customers').val(e.data.strCustomer);
                        console.log("double click filled in the box");
                        $('#company').val(e.data.strCompany);
                        $('#date').val(e.data.dteUpliftDate);
                        $('#upliftreason').val(e.data.strReasonUpliftment);
                        const collectRadio = document.getElementById("upliftmentactioncollect");
                        const deliverRadio = document.getElementById("upliftmentactiondeliver");
                        $.ajax({

                            url: '{!!url("/getCustomerForSelectedCompany")!!}',
                            type: "POST",
                            data: {
                                company: $("#company").val()
                            },
                            success: function (datacustomerdata) {
                                
                                var jArrayCustomers = JSON.stringify(datacustomerdata);
                                var finalDataCustomer = $.map(JSON.parse(jArrayCustomers), function (item) {
                                    return {
                                        CustomerCode: item.CustomerPastelCode,
                                        StoreName: item.StoreName,
                                    }

                                });
                                var inputCustomerInner = $('#customers').flexdatalist({
                                    minLength: 1,
                                    valueProperty: '*',
                                    selectionRequired: true,
                                    focusFirstResult: true,
                                    searchContain:true,
                                    visibleProperties: ["CustomerCode","StoreName"],
                                    searchIn: ["CustomerCode","StoreName"],
                                    data: finalDataCustomer
                                });
                                
                                inputCustomerInner.on('select:flexdatalist', function (event, data) {
                                    //fill in inputs of code desc weight, empty qty empty comment..
                                    $('#customers').val(data.CustomerCode);
                                    
                                    console.log("Flex data list called within double click");
                                    $.ajax({

                            url: '{!!url("/getAreaAddressInvoiceInfoParam")!!}',
                            type: "POST",
                            data: {
                                customer: $("#customers").val(),
                                company: $("#company").val()
                            },
                            success: function (data) {

                                var jArrayAreas = JSON.stringify(data.routes);
                                var finalDataAreas = $.map(JSON.parse(jArrayAreas), function (item) {
                                    return {
                                        routeID: item.routeID,
                                        Route: item.Route,
                                    }

                                });
                                var inputAreas = $('#area').flexdatalist({
                                    minLength: 1,
                                    valueProperty: '*',
                                    selectionRequired: true,
                                    focusFirstResult: true,
                                    searchContain:true,
                                    visibleProperties: ["routeID","Route"],
                                    searchIn: ["routeID","Route"],
                                    data: finalDataAreas
                                });
                                
                                inputAreas.on('select:flexdatalist', function (event, data) {
                                    //fill in inputs of code desc weight, empty qty empty comment..
                                    $('#area').val(data.Route);
                                });

                                var toAppend='';
                                $.each(data.addresses,function(i,o){

                                    toAppend += '<option value="'+o.strAddress+'">'+o.strAddress+'</option>';
                                });
                                $("#address").append(toAppend);

                                var jArrayInvoices = JSON.stringify(data.invoices);
                                
                                var finalDataInvoices = $.map(JSON.parse(jArrayInvoices), function (item) {
                                    return {
                                        InvNumber: item.InvNumber
                                    }

                                });
                                var inputInvoices = $('#invoice').flexdatalist({
                                    minLength: 1,
                                    valueProperty: '*',
                                    selectionRequired: true,
                                    focusFirstResult: true,
                                    searchContain:true,
                                    visibleProperties: ["InvNumber"],
                                    searchIn: ["InvNumber"],
                                    data: finalDataInvoices
                                });
                                
                                inputInvoices.on('select:flexdatalist', function (event, data) {
                                    //fill in inputs of code desc weight, empty qty empty comment..
                                    $('#invoice').val(data.InvNumber);
                                });

                                $("#selectedarea").val();
                                $.each(data.areas,function(i,o){

                                    $("#selectedarea").val(o.Route);
                                });

                                
                            }
                        });

                                });
                                
                            }
                        });
                        $('#address').val(e.data.strAddress);
                        if (e.data.strUpliftAction =="Collect"){
                            deliverRadio.checked = false;
                            collectRadio.checked = true;
                        }
                        else
                        {
                            deliverRadio.checked = true;
                            collectRadio.checked = false;
                        }
                        
                        const imagebutton = document.getElementById("imageupliftment");
                        const enquirebutton = document.getElementById("enquireupliftment");
                        const backlogbutton = document.getElementById("backlogupliftment");

                        enquirebutton.setAttribute("href", '{!!url("/upliftEnquiry")!!}/' + upliftmentNumber);
                        imagebutton.setAttribute("href", '{!!url("/upliftImageGetter")!!}/' + upliftmentNumber);
                        backlogbutton.setAttribute("href", '{!!url("/upliftmentBacklog")!!}/' + upliftmentNumber);

                        imagebutton.addEventListener("click", function() {
                            window.open('{!!url("/upliftImageGetter")!!}/'+upliftmentNumber, 'upliftimagegetter', "location=1,status=1,scrollbars=1, width=1200,height=850");
                        });
                        
                        backlogbutton.addEventListener("click", function() {
                            window.open('{!!url("/upliftmentBacklog")!!}/'+upliftmentNumber, 'upliftmentbackloggetter', "location=1,status=1,scrollbars=1, width=1200,height=850");
                        });

                        enquirebutton.addEventListener("click", function() {
                            window.open('{!!url("/upliftEnquiry")!!}/'+upliftmentNumber, 'upliftenquirygetter', "location=1,status=1,scrollbars=1, width=1200,height=850");
                        });
                        
                        $.ajax({
                            url: '{!!url("/getUpliftmentDetails")!!}',
                            type: 'GET',
                            data: {
                                upliftmentNumber: upliftmentNumber
                            },
                            success: function(data) {
                                populateDataGrid(data);

                        }});

                    }
            });
        }
        });

        $('.sidebar ul li a').on(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });

        $('.sidebar ul li a').click(function(){
            var id = $(this).attr('id');
            $('nav ul li ul.item-show-'+id).toggleClass("show");
            $('nav ul li #'+id+' span').toggleClass("rotate");
            
        });
        
        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

        
    });


    function createDataGrid() {
        $('#gridBoxCurrent').hide();
        $('#gridBox').show();
        var dataSource = new DevExpress.data.DataSource({
        store: [],
        paginate: true
    });
    $("#gridBox").dxDataGrid({
        dataSource: dataSource,
        
        columns: [
            { dataField: 'Code', caption: 'Item Code' },
            { dataField: 'Name', caption: 'Item Description' },
            { dataField: 'Quantity', caption: 'Quantity' },
            { dataField: 'Weight', caption: 'Weight' },
            { dataField: 'Comment', caption: 'Comment' }
        ],
        editing: {
            mode: 'batch',
            allowDeleting: true
        },
        onRowInserted: function(e) {
            var newRecord = e.data;
            // retrieve the new record and perform any necessary processing
        },
        onRowUpdated: function(e) {
            var updatedRecord = e.data;
            // retrieve the updated record and perform any necessary processing
        }
    });
    

}
function populateDataGrid(datagriddata) {
        $('#gridBox').hide();
        $('#gridBoxCurrent').show();
    $("#gridBoxCurrent").dxDataGrid({
        dataSource: datagriddata,
        
        columns: [
            { dataField: 'PastelCode', caption: 'Item Code' },
            { dataField: 'PastelDescription', caption: 'Item Description' },
            { dataField: 'Qty', caption: 'Quantity' },
            { dataField: 'Weight', caption: 'Weight' },
            { dataField: 'Comment', caption: 'Comment' }
        ],
        editing: {
            mode: 'batch',
            allowDeleting: true
        },
        onRowInserted: function(e) {
            var newRecord = e.data;
            // retrieve the new record and perform any necessary processing
        },
        onRowUpdated: function(e) {
            var updatedRecord = e.data;
            // retrieve the updated record and perform any necessary processing
        }
    });
    

}

    function showDialog(tag,width,height)
    {
        $( tag ).dialog({height: height, modal: false,
            width: width,containment: false}).dialogExtend({
            "closable" : true, // enable/disable close button
            "maximizable" : false, // enable/disable maximize button
            "minimizable" : true, // enable/disable minimize button
            "collapsable" : true, // enable/disable collapse button
            "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
            "titlebar" : false, // false, 'none', 'transparent'
            "minimizeLocation" : "right", // sets alignment of minimized dialogues
            "icons" : { // jQuery UI icon class

                "maximize" : "ui-icon-circle-plus",
                "minimize" : "ui-icon-circle-minus",
                "collapse" : "ui-icon-triangle-1-s",
                "restore" : "ui-icon-bullet"
            },
            "load" : function(evt, dlg){ }, // event
            "beforeCollapse" : function(evt, dlg){ }, // event
            "beforeMaximize" : function(evt, dlg){ }, // event
            "beforeMinimize" : function(evt, dlg){ }, // event
            "beforeRestore" : function(evt, dlg){ }, // event
            "collapse" : function(evt, dlg){  }, // event
            "maximize" : function(evt, dlg){ }, // event
            "minimize" : function(evt, dlg){  }, // event
            "restore" : function(evt, dlg){  } // event
        });
    }
  /*   function showPopup(data, extradata) {
    // Create a new div to hold the popup content
    var content = $("<div>");

    // Create a new instance of the dxPopup widget
    
    var intUpliftForImage = data[0].intUpliftmentNumber;
    console.log(intUpliftForImage);
    var popup = $("<div>").appendTo(document.body).dxPopup({
    title: "Upliftment Details",
    width: 800,
    height: 600,
    toolbarItems: [
        {
        widget: "dxButton",
        location: "before",
        options: {
            text: "Upliftment Image",
            onClick: function() {
                window.open('{!!url("/upliftImageGetter")!!}/'+intUpliftForImage, 'upliftimagegetter', "location=1,status=1,scrollbars=1, width=1200,height=850");
            }
        }
    },
    {
        widget: "dxButton",
        location: "before",
        options: {
            text: "Enquiry",
            onClick: function() {
                window.open('{!!url("/upliftEnquiry")!!}/'+intUpliftForImage, 'upliftimagegetter', "location=1,status=1,scrollbars=1, width=1200,height=850");
            }
        }
    },
    {
        widget: "dxButton",
        location: "after",
        options: {
            text: "Delete",
            onClick: function() {
                console.log("DELETING");
                $.ajax({
                    url: '{!!url("/deleteUpliftmentPost")!!}',
                    type: 'POST',
                    data: {
                        intUpliftmentNumber: intUpliftForImage
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        }
    },
    {
        widget: "dxButton",
        location: "after",
        options: {
            text: "Close",
            onClick: function() {
                popup.hide();
            }
        }
    }
],

    contentTemplate: function(contentElement) {
        // Add the content to the popup
        $("<div>").appendTo(contentElement).text("Upliftment ID: " + extradata.intUpliftmentNumber);
        $("<div>").appendTo(contentElement).text("Upliftment Date: " + extradata.dteUpliftDate);
        $("<div>").appendTo(contentElement).text("Upliftment Action: " + extradata.strUpliftAction);
        $("<div>").appendTo(contentElement).text("Upliftment Reason: " + extradata.strReasonPickup);
        $("<div>").appendTo(contentElement).text("Company: " + extradata.strCompany);
        $("<div>").appendTo(contentElement).text("Customer: " + extradata.strCustomer);
        $("<div>").appendTo(contentElement).text("Area: " + extradata.strArea);
        $("<div>").appendTo(contentElement).text("Address: " + extradata.strAddress);
        $("<div>").appendTo(contentElement).text("Invoice Number: " + extradata.strInvoice);

        $("<div>").appendTo(contentElement).text("Invoice Number: " + extradata.strInvoice);
    
        content.appendTo(contentElement);
        
        
    }
}).dxPopup("instance");


  

    // Show the popup
    popup.show();
} */

</script>
