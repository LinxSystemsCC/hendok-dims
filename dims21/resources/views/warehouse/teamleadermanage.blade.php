<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
    <title>Team Leader Dashboard</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Multiselect --> 
    <link href="{{ asset('css/jquery.multiselect.css') }}" rel="stylesheet"  type='text/css'>


    <!-- DevExtreme theme -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.compact.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css"> --}}

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

    <style>
        .red-cell {
            background-color: red;
            color: white;
        }

        .customPadding {
            padding: 3px !important;
        }

    </style>
    

</head>

<body>
<div class="col-lg-12 d-flex vh-100">
    <div class="col-md-12 p-3 h-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h3>Team Leader Management</h3>
                </div>
                <div class="col-md-6">
                    <h4 id="loadId" class="float-end"></h4>
                </div>
            </div>
        </div>
        
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            @if ($ref == 0)
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1" role="tab" aria-controls="content1" aria-selected="true">Management</a>
            </li>
            @else
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab1" data-bs-toggle="tab" href="#content1" role="tab" aria-controls="content1" aria-selected="true">Management</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab2" data-bs-toggle="tab" href="#content2" role="tab" aria-controls="content2" aria-selected="true">Pick - Load</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3" role="tab" aria-controls="content3" aria-selected="false">Assign</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#content4" role="tab" aria-controls="content4" aria-selected="false">Equipment</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#content5" role="tab" aria-controls="content5" aria-selected="false">Notifications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab6" data-bs-toggle="tab" href="#content6" role="tab" aria-controls="content6" aria-selected="false">Instructions</a>
            </li>
            @endif
        </ul>

        <div class="tab-content h-auto py-3" id="tabs">
            @if ($ref == 0)
            <!-- Management -->
            <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1" style="height: calc(100vh - 150px); overflow-y: auto;">
                <div class="d-inline-flex mb-2">
                    <label class="d-flex align-items-center px-2" >Delivery Date</label> 
                    <input class="form-control px-2" type="date" id='date'>
                    <button class="btn btn-success mx-2" id="getdata">SEARCH</button>
                </div>

                <div id="managementTable"></div>
            </div>
            @else
            <!-- Management -->
            <div class="tab-pane fade show" id="content1" role="tabpanel" aria-labelledby="tab1" style="height: calc(100vh - 150px); overflow-y: auto;">
                <div class="d-inline-flex mb-2">
                    <label class="d-flex align-items-center px-2" >Delivery Date</label> 
                    <input class="form-control px-2" type="date" id='date'>
                    <button class="btn btn-success mx-2" id="getdata">SEARCH</button>
                </div>

                <div id="managementTable"></div>
            </div>
            
            <!-- Pick Load -->
            <div class="tab-pane fade show active" id="content2" role="tabpanel" aria-labelledby="tab2" style="height: calc(100vh - 150px); overflow-y: auto;">
                <table id="pickLoadTable" class="table">
                    <thead class="sticky-top">
                        <tr style="background: black; color: white;">
                            <th class="col-xs-2">Order Date</th>
                            <th class="col-xs-2">SO Number</th>
                            <th class="col-xs-2">Description</th>
                            <th class="col-xs-2">Qty</th>
                            <th class="col-xs-2">Picked</th>
                            <th class="col-xs-2">Loaded</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $storenames = "";
                        $orderNumber = "";
                        $Grandtotal = 0;
                        $area = "";
                        $orderdate = "";
                        $istrue = true;
                        $count = 0;
                        ?>

                        @foreach($listproducts as $val)

                        <?php
                        $externalCount = 0;
                        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
                        $t = time();
                        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
                        $ID = $t . $randomString;
                        ?>
                        
                        @if($count == 0)
                        <tr style="background: darkgray; color: white; font-weight: 900;" id="{{$ID}}">
                            <td colspan="4">STOP: {{$val->intSequence}} - {{ $val->StoreName}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        <?php $Grandtotal = $Grandtotal + floatval($val->mnyPickedQuantity);?>
                        @if($storenames != $val->StoreName)
                        @if($count > 0)
                        <tr style="background: darkgray; color: white; font-weight: 900;">
                            <td colspan="4">STOP: {{$val->intSequence}} - {{ $val->StoreName}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        @if($val->isLineInvoiced == 1)
                        <tr id="rtrr{{$ID}}">
                        @else
                        <tr id="rtrr{{$ID}}">
                        @endif
                        <td>{{ $val->OrderDate}}</td>
                        <td>{{$val->OrderNum}}</td>
                        <td>{{ $val->PastelDescription}}</td>
                        <td style="font-size: 14px; background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                        <td>{{ floatval($val->mnyPickedQuantity)}}</td>
                        <td>{{ floatval($val->mnyLoadedQty)}}</td>
                        </tr>
                        <?php
                        $istrue = true;
                        $storenames = $val->StoreName;
                        $orderNumber = $val->OrderNum;
                        $area = $val->areas;
                        $orderdate = $val->OrderDate;
                        ?>
                        @else
                        <tr>
                            @if($orderdate != $val->OrderDate)
                            <td>{{ $val->OrderDate}}</td>
                            @else
                            <td></td>
                            @endif
                            @if($orderNumber != $val->OrderNum)
                            <td>{{$val->OrderNum}}</td>
                            @else
                            <td></td> 
                            @endif
                            <td>{{ $val->PastelDescription}}</td>
                            <td style="font-size: 14px; background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                            <td>{{ floatval($val->mnyPickedQuantity)}}</td>
                            <td>{{ floatval($val->mnyLoadedQty)}}</td>
                        </tr>
                        <?php
                        $storenames = $val->StoreName;
                        $orderNumber = $val->OrderNum;
                        $orderdate = $val->OrderDate;
                        $area = $val->areas;
                        if ($storenames == $val->StoreName) {
                            $istrue = true;
                        }
                        ?>
                        @endif
                        <?php $count++; ?>
                        @endforeach
                        <tr style="background: darkgray; color: white; font-weight: 900;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Assign -->
            <div class="tab-pane fade" id="content3" role="tabpanel" aria-labelledby="tab3">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col mb-3">
                            <label for="horse" class="col-form-label">Horse</label>
                            <select class="form-select" type="text" id='horse'>
                                <option>
                                @foreach ($horses as $horse)
                                    <option value="{{ $horse->TruckId }}" @if ($horse->intInUse == 1) disabled @endif>
                                        {{ $horse->TruckName }} @if ($horse->intInUse == 1) - IN USE @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="trailorOne" class="col-form-label">Trailer One</label>
                            <select class="form-select" type="text" id='trailorOne'>
                                <option></option>
                                @foreach ($trailors as $trailorOne)
                                    <option value="{{ $trailorOne->TruckId }}" @if ($trailorOne->intInUse == 1) disabled @endif>
                                        {{ $trailorOne->TruckName }} @if ($trailorOne->intInUse == 1) - IN USE @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="trailorTwo" class="col-form-label">Trailer Two</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}" @if ($trailorTwo->intInUse == 1) disabled @endif>
                                        {{ $trailorTwo->TruckName }}  @if ($trailorTwo->intInUse == 1)- IN USE @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="ticket" class="col-form-label">Weighbridge Ticket</label>
                            <select class="form-select" type="text" id='ticket'>
                                <option></option>
                                @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->strTicket }}">{{ $ticket->strTicket }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="picker" class="col-form-label">Pickers</label>
                            <select class="form-select" type="text" id='picker' multiple="multiple" >
                                @foreach ($pickers as $picker)
                                    <option value="{{ $picker->UserID }}">{{ $picker->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="loader" class="col-form-label">Loaders</label>
                            <select class="form-select" type="text" id='loader' multiple="multiple" >
                                @foreach ($pickers as $picker)
                                    <option value="{{ $picker->UserID }}">{{ $picker->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="staging" class="col-form-label">Staging / Loading Areas</label>
                            <select class="form-select" type="text" id='staging' multiple="multiple" >
                                @foreach ($stagingAreas as $stagingArea)
                                    <option value="{{ $stagingArea->intAutoStagingId }}">{{ $stagingArea->strAreaName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="container-fluid p-0">
                        <button class="btn btn-success float-end px-5 py-3" id="assign">ASSIGN</button>
                    </div>
                </div>
            </div>

            <!-- Equipment -->
            <div class="tab-pane fade" id="content4" role="tabpanel" aria-labelledby="tab4">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col mb-3">
                            <label for="belts" class="col-form-label">Belts</label>
                            <input id="belts" class="form-control" type="number">
                        </div>
                        <div class="col mb-3">
                            <label for="ratchets" class="col-form-label">Ratchets</label>
                            <input id="ratchets" class="form-control" type="number">
                        </div>
                        <div class="col mb-3">
                            <label for="tarps" class="col-form-label">Tarps</label>
                            <input id="tarps" class="form-control" type="number">
                        </div>
                        <div class="col mb-3">
                            <label for="dunnages" class="col-form-label">Dunnage</label>
                            <input id="dunnages" class="form-control" type="number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="pallets" class="col-form-label">Pallets</label>
                            <input id="pallets" class="form-control" type="number">
                        </div>
                        <div class="col mb-3">
                            <label for="plates" class="col-form-label">Corner Plates</label>
                            <input id="plates" class="form-control" type="number">
                        </div>
                        <div class="col mb-3">
                            <label for="nets" class="col-form-label">Nets</label>
                            <input id="nets" class="form-control" type="number">
                        </div>
                        <div class="col mb-3">
                            <label for="stands" class="col-form-label">Stands</label>
                            <input id="stands" class="form-control" type="number">
                        </div>
                    </div>
                    <div class="container-fluid p-0">
                        <button class="btn btn-success float-end px-5 py-3" id="assignEquipment">ASSIGN</button>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="tab-pane fade" id="content5" role="tabpanel" aria-labelledby="tab5" style="height: calc(100vh - 150px); overflow-y: auto;">
                <div id="notificationsTable"></div>
            </div>

            <!-- Instructions -->
            <div class="tab-pane fade" id="content6" role="tabpanel" aria-labelledby="tab6" style="height: calc(100vh - 150px); overflow-y: auto;">
                <div id="instructionsTable"></div>
            </div>
            @endif
        </div>

    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Multiselect -->
<script src="{{ asset('js/jquery.multiselect.js') }}"></script>

<!-- Excel Saver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- DevExtreme library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/js/dx.all.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });

    $(document).ready(function() {
        $('#horse').select2({
            theme: 'bootstrap-5',
        });

        $('#trailorOne').select2({
            theme: 'bootstrap-5',
        });

        $('#trailorTwo').select2({
            theme: 'bootstrap-5',
        });

        $('#picker').multiselect({
            columns: 5,
            placeholder: 'Select Pickers',
            selectAll: true,
        });

        $('#loader').multiselect({
            columns: 5,
            placeholder: 'Select Loader',
            selectAll: true,
        });

        $('#staging').multiselect({
            columns: 5,
            placeholder: 'Select Staging Area',
            selectAll: true,
        });

        $('#ticket').select2({
            theme: 'bootstrap-5',
        });

        var currentDate = new Date();
        var year = currentDate.getFullYear();
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        var day = ("0" + currentDate.getDate()).slice(-2);
        var formattedDate = year + "-" + month + "-" + day;
        
        $('#date').val(formattedDate);

        getData();
        getPickingPlanData('{{ $ref }}');
        getNotifications('{{ $ref }}');
        getInstructions('{{ $ref }}');

        $('#getdata').click(function(){
            getData();
        });

        $('#assign').click(function(){
            const ref = '{{ $ref }}';
            const horse = $('#horse').val();
            const trailorOne = $('#trailorOne').val();
            const trailorTwo = $('#trailorTwo').val();
            const picker = $('#picker').val();
            const loader = $('#loader').val();
            const staging = $('#staging').val();
            const ticket = $('#ticket').val();
            const prompt = 'update';

            const stringPickers = picker.join(',');
            const stringLoaders = loader.join(',');
            const stringStaging = staging.join(',');

            AssignData(ref, horse, trailorOne, trailorTwo, stringPickers, stringLoaders, stringStaging, ticket, prompt);
        });

        $('#assignEquipment').click(function(){
            const ref = '{{ $ref }}';
            const belts = $('#belts').val() || 'null';
            const ratchets = $('#ratchets').val() || 'null';
            const tarps = $('#tarps').val() || 'null';
            const dunnages = $('#dunnages').val() || 'null';
            const pallets = $('#pallets').val() || 'null';
            const plates = $('#plates').val() || 'null';
            const nets = $('#nets').val() || 'null';
            const stands = $('#stands').val() || 'null';

            assignEquipment(ref, belts, ratchets, tarps, dunnages, pallets, plates, nets, stands);
        });
    });

    function getData(){
        $.ajax({
            url: '{!!url("/getTeamLeaderPlans")!!}',
            type: "GET",
            data: {
                date: $('#date').val(),
            },
            success: function (data) {
                $("#managementTable").dxDataGrid({
                    dataSource:data,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: false
                    },
                    selection: {
                        mode: "single",
                    },
                    columnAutoWidth:true,        
                    allowColumnResizing: true,       
                    columnResizingMode: "nextColumn",
                    columns: [
                        {
                            dataField: "strUnickReference",
                            caption: "Reference",
                            visible: false,
                        },
                        {
                            dataField: "intLoadID",
                            caption: "Assigned Loads",
                            calculateCellValue: function(data) {
                                return "TL" + data.intLoadID;
                            },
                        },{
                            dataField: "strRouteName",
                            caption: "Route Name",
                        },
                        {
                            dataField: "intItemsAssigned",
                            caption: "Items Assigned",
                            cellTemplate: function (container, options) {
                                const value = options.data.intItemsAssigned;
                                if (value == 0) {
                                    container.addClass("bg-danger text-white");
                                    container.text('Not Assigned');

                                } else if (value == 1) {
                                    container.addClass("bg-success text-white");
                                    container.text('Assigned');
                                }
                                
                            },
                        },
                        {
                            dataField: "intEquipmentAssigned",
                            caption: "Equipment Assigned",
                            cellTemplate: function (container, options) {
                                const value = options.data.intEquipmentAssigned;
                                if (value == 0) {
                                    container.addClass("bg-danger text-white");
                                    container.text('Not Assigned');

                                } else if (value == 1) {
                                    container.addClass("bg-success text-white");
                                    container.text('Assigned');
                                }
                                
                            },
                        },
                        {
                            dataField: "strPickingStatus",
                            caption: "Picking Status",
                        },
                        {
                            dataField: "strLoadingStatus",
                            caption: "Loading Status",
                        },
                        {
                            dataField: "intNotifications",
                            caption: "Outstanding Notifications",
                            cellTemplate: function (container, options) {
                                const value = options.data.intNotifications;
                                if (value == 0) {
                                    container.addClass("bg-danger text-white");
                                    container.text('Outstanding');

                                } else if (value == 1) {
                                    container.addClass("bg-success text-white");
                                    container.text('None Outstanding');
                                }
                                
                            },
                        },
                        {
                            dataField: "intInvoiceStatus",
                            caption: "Invoice",
                            cellTemplate: function (container, options) {
                                const value = options.data.intInvoiceStatus;
                                container.addClass("customPadding"); // Add the no-padding class to the container

                                if (value == 0) {
                                    const button = $("<button class='btn btn-primary btn-sm w-100' disabled>").text("invoice").on("click", function() {});
                                    container.append(button);

                                } else {
                                    const button = $("<button class='btn btn-primary btn-sm w-100'>").text("invoice").on("click", function() {
                                        console.log(options.data.strUnickReference);
                                    });
                                    container.append(button);
                                }
                            },
                        },
                    ] ,
                    onRowPrepared(e) {

                    },
                    onRowClick: function (e) {

                    },
                    onRowDblClick: function (e) {
                        window.location.href = '{!!url("/teamleadermanage")!!}/' + e.data.strUnickReference;
                    },
                    onInitNewRow: function(e) {
                        
                    },
                    onRowInserting: function(e) {
                        
                    },
                    onRowInserted: function(e) {
                        
                    },
                    onRowUpdating: function(e) {
                        
                    }
                });
                
            },
            error: function (error) {
                console.error("Error loading data: ", error);
            }
        });
    };

    function getPickingPlanData(ref){
        $.ajax({
            url: '{!!url("/teamLeaderGetPickingPlanData")!!}',
            type: "GET",
            data: {
                ref: ref,
            },
            success: function (data) {
                if(data[0]){
                    let pickersList;
                    if (data[0]['strPicking'] == null){
                        pickersList = null;
                    }else{
                        const pickers = data[0]['strPicking'];
                        pickersList = pickers.split(",");
                    }

                    let loadersList;
                    if (data[0]['strLoading'] == null){
                        loadersList = null;
                    }else{
                        const loaders = data[0]['strLoading'];
                        loadersList = loaders.split(",");
                    }
                    
                    let stagingList;
                    if (data[0]['strStagingArea'] == null){
                        stagingList = null;;
                    }else{
                        const staging = data[0]['strStagingArea'];
                        stagingList = staging.split(",");
                    }
                    
                    $('#loadId').text('TL'+data[0]['intAutoPickingHeader']);
                    $('#date').val(data[0]['dtm']);
                    $('#horse').val(data[0].strTrailorNo).trigger('change');
                    $('#trailorOne').val(data[0]['strTrailorone']).trigger('change');
                    $('#trailorTwo').val(data[0]['strTrailortwo']).trigger('change');
                    $('#staging').val(data[0]['']).trigger('change');
                    $('#ticket').val(data[0]['strTicket']).trigger('change');
                    $('#belts').val(data[0]['intBelts']);
                    $('#ratchets').val(data[0]['intStraps']);
                    $('#tarps').val(data[0]['intTarps']);
                    $('#dunnages').val(data[0]['intDunnages']);
                    $('#pallets').val(data[0]['intPallets']);
                    $('#plates').val(data[0]['intPlasticCorners']);
                    $('#nets').val(data[0]['intNets']);
                    $('#stands').val(data[0]['intStans']);

                    for(var i in pickersList) {
                        var val = pickersList[i];
                        $("#picker").find("option[value="+val+"]").prop("selected", "selected");
                    }
                    $("#picker").multiselect('reload');

                    for(var i in loadersList) {
                        var val = loadersList[i];
                        $("#loader").find("option[value="+val+"]").prop("selected", "selected");
                    }
                    $("#loader").multiselect('reload');

                    for(var i in stagingList) {
                        var val = stagingList[i];
                        $("#staging").find("option[value="+val+"]").prop("selected", "selected");
                    }
                    $("#staging").multiselect('reload');
                    getData();
                }
            }
        });
    };

    function getNotifications(ref){
        $.ajax({
            url: '{!!url("/teamLeaderGetNotifications")!!}',
            type: "GET",
            data: {
                ref: ref,
            },
            success: function (data) {
                $("#notificationsTable").dxDataGrid({
                    dataSource:data,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: false
                    },
                    selection: {
                        mode: "single",
                    },
                    columnAutoWidth:true,        
                    allowColumnResizing: true,       
                    columnResizingMode: "nextColumn",
                    columns: [
                        {
                            dataField: "intAutoID",
                            caption: "ID",
                            visible: false,
                        },{
                            dataField: "strUnickReference",
                            caption: "Reference",
                            visible: false,
                        },{
                            dataField: "intAutoPickingHeader",
                            caption: "Truck Load",
                            calculateCellValue: function(data) {
                                return "TL" + data.intAutoPickingHeader;
                            },
                            visible: false,

                        },{
                            dataField: "intOrderID",
                            caption: "Order ID",
                            visible: false,
                        },{
                            dataField: "createdBy",
                            caption: "Created By",
                            
                        },{
                            dataField: "dtmCreated",
                            caption: "Date Created",
                            
                        },{
                            dataField: "strItemCode",
                            caption: "Product Code",
                            
                        },{
                            dataField: "strStatus",
                            caption: "Status",
                            
                        },{
                            dataField: "strSONumber",
                            caption: "SO Number",
                            
                        },{
                            dataField: "mnyQty",
                            caption: "Qty",
                            
                        },{
                            dataField: "strMessage",
                            caption: "Message",
                            
                        },{
                            dataField: "approvedBy",
                            caption: "Approved By",
                            
                        },{
                            dataField: "dtmApproved",
                            caption: "Date Approved",
                            
                        },{
                            dataField: "bitApproved",
                            caption: "Approved",
                            cellTemplate: function (container, options) {
                                const value = options.data.bitApproved;
                                if (value != 1) {
                                    const button = $("<button class='btn btn-primary btn-sm w-100'>").text("Approve").on("click", function() {
                                        console.log(options.data.intAutoID);
                                        approveNotification(options.data.intAutoID);
                                    });
                                    container.append(button);

                                } else{
                                    container.addClass("bg-success text-white");
                                    container.text('Approved');
                                }
                                
                            },
                        },

                    ] ,
                    onRowPrepared(e) {
                        
                    },
                    onRowClick: function (e) {
                        
                    },
                    onRowDblClick: function (e) {
                        
                    },
                    onInitNewRow: function(e) {
                        
                    },
                    onRowInserting: function(e) {
                        
                    },
                    onRowInserted: function(e) {
                        
                    },
                    onRowUpdating: function(e) {
                        
                    }
                });
            }
        });
    };

    function getInstructions(ref){
        $.ajax({
            url: '{!!url("/teamLeaderGetInstructions")!!}',
            type: "GET",
            data: {
                ref: ref,
            },
            success: function (data) {
                $("#instructionsTable").dxDataGrid({
                    dataSource:data,
                    showBorders: true,
                    filterRow: { visible: true },
                    filterPanel: { visible: true },
                    headerFilter: { visible: true },
                    paging: {
                        enabled: false
                    },
                    selection: {
                        mode: "single",
                    },
                    columnAutoWidth:true,        
                    allowColumnResizing: true,       
                    columnResizingMode: "nextColumn",
                    columns: [
                        {
                            dataField: "strUnickReference",
                            caption: "Reference",
                            visible: false,
                        },{
                            dataField: "strInstruction",
                            caption: "Instruction",
                        },{
                            dataField: "strType",
                            caption: "Type",
                        },
                    ] ,
                    onRowPrepared(e) {
                        
                    },
                    onRowClick: function (e) {
                        
                    },
                    onRowDblClick: function (e) {
                        
                    },
                    onInitNewRow: function(e) {
                        
                    },
                    onRowInserting: function(e) {
                        
                    },
                    onRowInserted: function(e) {
                        
                    },
                    onRowUpdating: function(e) {
                        
                    }
                });
            }
        });
    };

    function AssignData(ref, horse, trailorOne, trailorTwo, picker, loader, staging, ticket, prompt){
        $.ajax({
            url: '{!!url("/teamLeaderAssign")!!}',
            type: "GET",
            data: {
                ref : ref,
                horse : horse,
                trailorOne : trailorOne,
                trailorTwo : trailorTwo,
                picker : picker,
                loader : loader,
                staging : staging,
                ticket : ticket,
                prompt : prompt,
            },
            success: function (data) {
                // location.reload();
                alert('Updated');
                getData();
            }
        });
    };

    function assignEquipment(ref, belts, ratchets, tarps, dunnages, pallets, plates, nets, stands){
        $.ajax({
            url: '{!!url("/teamLeaderEquipmentAssign")!!}',
            type: "GET",
            data: {
                ref: ref,
                belts: belts,
                ratchets: ratchets,
                tarps: tarps,
                dunnages: dunnages,
                pallets: pallets,
                plates: plates,
                nets: nets,
                stands: stands
            },
            success: function (data) {
                alert('Updated');
                getData();
            }
        });
    };

    function approveNotification(id){
        $.ajax({
            url: '{!!url("/teamLeaderApproveNotification")!!}',
            type: "GET",
            data: {
                id: id,
            },
            success: function (data) {
                alert('Updated');
                getData();
                getNotifications('{{ $ref }}');
            }
        });
    }

</script>
</body>
