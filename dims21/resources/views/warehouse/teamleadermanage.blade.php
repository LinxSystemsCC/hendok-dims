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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.3/css/dx.material.orange.light.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>

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
                    <h4 id="loadId" class="float-end">TL0</h4>
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
            @endif
        </ul>

        <div class="tab-content h-auto py-3" id="tabs">
            @if ($ref == 0)
            <!-- Management -->
            <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1">
                <div class="d-inline-flex mb-2">
                    <label class="d-flex align-items-center px-2" >Delivery Date</label> 
                    <input class="form-control px-2" type="date" id='date'>
                    <button class="btn btn-success mx-2" id="getdata">SEARCH</button>
                </div>

                <div id="gridContainer"></div>
            </div>
            @else
            <!-- Management -->
            <div class="tab-pane fade show" id="content1" role="tabpanel" aria-labelledby="tab1">
                <div class="d-inline-flex mb-2">
                    <label class="d-flex align-items-center px-2" >Delivery Date</label> 
                    <input class="form-control px-2" type="date" id='date'>
                    <button class="btn btn-success mx-2" id="getdata">SEARCH</button>
                </div>

                <div id="gridContainer"></div>
            </div>
            
            <!-- Pick Load -->
            <div class="tab-pane fade show active" id="content2" role="tabpanel" aria-labelledby="tab2">
                <table id="pickLoadTable" class="table">
                    <thead>
                        <tr style="background: black; color: white;">
                            <th class="col-xs-2">Storename</th>
                            <th class="col-xs-2">Order Date</th>
                            <th class="col-xs-2">Sales Order No</th>
                            <th class="col-xs-2">Instruction</th>
                            <th class="col-xs-2">Description</th>
                            <th class="col-xs-2">Quantity</th>
                            <th class="col-xs-2">Items Picked</th>
                            <th class="col-xs-2">Items Loaded</th>
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
                            <td>STOP: {{$val->intSequence}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        <?php $Grandtotal = $Grandtotal + floatval($val->mnyPickedQuantity);?>
                        @if($storenames != $val->StoreName)
                        @if($count > 0)
                        <tr style="background: darkgray; color: white; font-weight: 900;">
                            <td>STOP: {{$val->intSequence}}</td>
                            <td>NEXT</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        @if($val->isLineInvoiced == 1)
                        <tr id="rtrr{{$ID}}">
                        @else
                        <tr id="rtrr{{$ID}}">
                        @endif
                        <td>{{ $val->StoreName}}</td>
                        <td>{{ $val->OrderDate}}</td>
                        <td>{{$val->OrderNum}}</td>
                        <td>{{ $val->ExtOrderNum}}</td>
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
                            @if($storenames != $val->StoreName)
                            <td>{{ $val->StoreName}}</td>
                            @else
                            <td></td>
                            @endif
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
                            <td>{{ $val->ExtOrderNum}}</td>
                            <td>{{ $val->PastelDescription}}</td>
                            <td style="font-size: 14px; background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                            <td>{{ floatval($val->mnyPickedQuantity)}}</td>
                            <td>{{ floatval($val->mnyLoadedQty)}}</td>
                        </tr>
                        <?php
                        $storenames = $val->StoreName;
                        $orderNumber = $val->OrderNum;
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
                                    <option value="{{ $horse->TruckId }}">{{ $horse->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="trailorOne" class="col-form-label">Trailer One</label>
                            <select class="form-select" type="text" id='trailorOne'>
                                <option></option>
                                @foreach ($trailors as $trailorOne)
                                    <option value="{{ $trailorOne->TruckId }}">{{ $trailorOne->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="trailorTwo" class="col-form-label">Trailer Two</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}">{{ $trailorTwo->TruckName }}</option>
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
                            <label for="picker" class="col-form-label">Picker</label>
                            <select class="form-select" type="text" id='picker' multiple="multiple" >
                                @foreach ($pickers as $picker)
                                    <option value="{{ $picker->UserID }}">{{ $picker->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="loader" class="col-form-label">Loader</label>
                            <select class="form-select" type="text" id='loader' multiple="multiple" >
                                @foreach ($pickers as $picker)
                                    <option value="{{ $picker->UserID }}">{{ $picker->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="staging" class="col-form-label">Staging Area</label>
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
                <h4>Equipment</h4>
            </div>

            <!-- Notifications -->
            <div class="tab-pane fade" id="content5" role="tabpanel" aria-labelledby="tab5">
                <h4>Notifications</h4>
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

            updateData(ref, horse, trailorOne, trailorTwo, stringPickers, stringLoaders, stringStaging, ticket, prompt);
        });
    });

    function getData(){
        var currentSelectedRow = []; // Declare the selectedRowKeys array outside dxDataGrid initialization
        $.ajax({
            url: '{!!url("/getTeamLeaderPlans")!!}',
            type: "GET",
            data: {
                from: $('#date').val(),
                to: $('#date').val()
            },
            success: function (data) {
                $("#gridContainer").dxDataGrid({
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
                            dataField: "intAutoPickingHeader",
                            caption: "Load No.",
                            calculateCellValue: function(data) {
                                return "TL" + data.intAutoPickingHeader;
                            },
                        },
                        {
                            dataField: "strUnickReference",
                            caption: "Ref No.",
                            visible: false,
                        },
                        {
                            width: 150,
                            dataField: "strPickingNickname",
                            caption: "Route Name",
                        },
                        {
                            dataField: "strTeamLeader",
                            caption: "Team Leader",
                        },
                        {
                            dataField: "strTrailorNo",
                            caption: "Horse",
                        },
                        {
                            dataField: "strTrailorone",
                            caption: "Trailor One",
                        },
                        {
                            dataField: "strTrailortwo",
                            caption: "Trailor Two",
                        },
                        {
                            dataField: "strDriverOne",
                            caption: "Driver One",
                        },
                        {
                            dataField: "strDriverTwo",
                            caption: "Driver Two",
                        },
                        {
                            dataField: "strTicket",
                            caption: "Ticket Number",
                        },
                        {
                            dataField: "statustext",
                            caption: "Status",
                            cellTemplate: function(element, info) {
                                element.append("<div>" + info.text + "</div>")
                                    .css("font-size", "16px")
                                    .css("font-weight", "900");
                            }
                        }
                    ] ,
                    onRowPrepared(e) {
                        if (e.rowType == 'data' && e.data.isCancelled ==1) {
                            e.rowElement.css('background', 'red');
                        }
                    },
                    onRowClick: function (e) {
                        var currentID = currentSelectedRow[0];
                        var clickedID = e.data.intAutoPickingHeader;

                        if (clickedID === currentID){
                            currentSelectedRow = [];
                            e.component.clearSelection();
                            $("#btnTeamLeader").prop("disabled", true);
                            $("#btnHorse").prop("disabled", true);
                            $("#btnTrailor").prop("disabled", true);
                            $("#btnDriver").prop("disabled", true);
                            $("#btnTicket").prop("disabled", true);
                        }else{
                            currentSelectedRow = [];
                            currentSelectedRow.push(clickedID);

                            $("#btnTeamLeader").prop("disabled", false);
                            $("#btnHorse").prop("disabled", false);
                            $("#btnTrailor").prop("disabled", false);
                            $("#btnDriver").prop("disabled", false);
                            $("#btnTicket").prop("disabled", false);
                        }
                    },
                    onRowDblClick: function (e) {
                        window.location.href = '{!!url("/teamleadermanage")!!}/' + e.data.strUnickReference;
                    },
                    onInitNewRow: function(e) {
                        console.debug("InitNewRow");
                    },
                    onRowInserting: function(e) {
                        console.debug("RowInserting");
                    },
                    onRowInserted: function(e) {
                        console.debug("RowInserted");
                    },
                    onRowUpdating: function(e) {
                        console.debug("RowUpdating");
                    }
                });

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
                    const pickers = data[0]['strPicking'];
                    const pickersList = pickers.split(",");

                    const loaders = data[0]['strLoading'];
                    const loadersList = loaders.split(",");

                    const staging = data[0]['strStagingArea'];
                    const stagingList = staging.split(",");

                    $('#loadId').text('TL'+data[0]['intAutoPickingHeader']);
                    $('#horse').val(data[0].strTrailorNo).trigger('change');
                    $('#trailorOne').val(data[0]['strTrailorone']).trigger('change');
                    $('#trailorTwo').val(data[0]['strTrailortwo']).trigger('change');
                    $('#staging').val(data[0]['']).trigger('change');
                    $('#ticket').val(data[0]['strTicket']).trigger('change');

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
                }
            }
        });
    };

    function updateData(ref, horse, trailorOne, trailorTwo, picker, loader, staging, ticket, prompt){
        $.ajax({
            url: '{!!url("/teamLeaderUpdatePickingPlan")!!}',
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
            }
        });
    };

</script>
</body>
