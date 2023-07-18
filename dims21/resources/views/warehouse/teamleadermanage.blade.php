<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="resources\css\jobmodulestyle.css">
    <link rel="icon" type="image/png" href="{{url('images/dimslogo.png')}}">
    <title>Team Leader Dashboard</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
</head>

<body>
<div class="col-lg-12 d-flex vh-100">
    <div class="col-md-12 p-3 h-100">
        <div>
            <h3>Team Leader Management</h3>
        </div>
        
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1" role="tab" aria-controls="content1" aria-selected="true">Management</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2" role="tab" aria-controls="content2" aria-selected="true">Pick - Load</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3" role="tab" aria-controls="content3" aria-selected="false">Assign</a>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#content4" role="tab" aria-controls="content4" aria-selected="false">Equipment</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#content5" role="tab" aria-controls="content5" aria-selected="false">Notifications</a>
            </li> --}}
        </ul>

        <div class="tab-content h-auto py-3" id="myTabContent">
            <!-- Management -->
            <div class="tab-pane fade show active" id="content1" role="tabpanel" aria-labelledby="tab1">
                <div class="col-xs-2">
                    <label for="date">Date</label>
                    <input type="date" class="form-control mb-2" id="deliveryDate">
                </div>

                <table class="table">
                    <thead>
                        <tr style="background: black; color: white;">
                            <th class="col-xs-2">Load Number</th>
                            <th class="col-xs-2">Items Assigned</th>
                            <th class="col-xs-2">Equipment Assigned</th>
                            <th class="col-xs-2">Picking Status</th>
                            <th class="col-xs-2">Loaded Status</th>
                            <th class="col-xs-2">Notifications</th>
                            <th class="col-xs-2">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>dsad</td>
                            <td>dsad</td>
                            <td>dsad</td>
                            <td>dsad</td>
                            <td>dsad</td>
                            <td>dsad</td>
                            <td>dsad</td>
                        </tr>
                </table>
            </div>

            <!-- Pick Load -->
            <div class="tab-pane fade show " id="content2" role="tabpanel" aria-labelledby="tab2">
                <table id="" class="table">
                    <thead>
                        <tr style="background: black; color: white;">
                            <th class="col-xs-2">Storename</th>
                            <th class="col-xs-1">Area</th>
                            <th class="col-xs-2">Order Date</th>
                            <th class="col-xs-2">Sales Order No</th>
                            <th class="col-xs-2">Instruction</th>
                            <th class="col-xs-2">Line No</th>
                            <th class="col-xs-2">Product Code</th>
                            <th class="col-xs-2">Description</th>
                            <th class="col-xs-2">Quantity</th>
                            <th class="col-xs-2">Weights</th>
                            <th class="col-xs-2">To Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $storenames = "";
                        $orderNumber = "";
                        $subtotal = 0;
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
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        <?php $Grandtotal = $Grandtotal + floatval($val->weightPlanned);?>
                        @if($storenames != $val->StoreName)
                        @if($count > 0)
                        <tr style="background: darkgray; color: white; font-weight: 900;">
                            <td>STOP: {{$val->intSequence}}</td>
                            <td></td>
                            <td>NEXT</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$subtotal}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php $subtotal = 0; $count = 0; ?>
                        @endif
                        @if($val->isLineInvoiced == 1)
                        <tr id="rtrr{{$ID}}" style="background: #0091EA">
                        @else
                        <tr id="rtrr{{$ID}}">
                        @endif
                        <td>{{ $val->StoreName}}</td>
                        <td>{{ $val->areas}}</td>
                        <td>{{ $val->OrderDate}}</td>
                        <td>{{$val->OrderNum}}
                            @if($val->isReadyForInvoicing == 1 && $val->ubARIBT == 0)
                            <button style="background: #0BA008; color: white;" class="invoicethis" value="{{$val->OrderId}}">Invoice {{ $val->OrderNum}}</button>
                            <input type="text" class="invnumber" value="{{$val->InvNumber}}">
                            <input type="hidden" class="refid" value="{{$val->strUnickReference}}">
                            <input type="hidden" class="ownerid" value="{{$val->intOwnerID}}">
                            <input type="hidden" class="OrderNumdim" value="{{$val->OrderNum}}">
                            <input type="hidden" class="ubARIBT" value="{{$val->ubARIBT}}">
                            @endif
                            @if($val->isReadyForInvoicing == 1 && $val->ubARIBT == 1)
                            <button style="background: #0BA008; color: white;" class="ibt" value="{{$val->OrderId}}">IBT {{ $val->OrderNum}}</button>
                            <input type="text" class="invnumber" value="{{$val->InvNumber}}">
                            <input type="hidden" class="refid" value="{{$val->strUnickReference}}">
                            <input type="hidden" class="ownerid" value="{{$val->intOwnerID}}">
                            <input type="hidden" class="OrderNumdim" value="{{$val->OrderNum}}">
                            <input type="hidden" class="ubARIBT" value="{{$val->ubARIBT}}">
                            @endif
                        </td>
                        <td>{{ $val->ExtOrderNum}}</td>
                        <td>{{ $val->iLineID}}</td>
                        <td>{{ $val->PastelCode}}</td>
                        <td>{{ $val->PastelDescription}}</td>
                        <td style="font-size: 14px; background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                        <td>{{ floatval($val->weightPlanned)}}</td>
                        <td>{{ floatval($val->Toinvoice)}}</td>
                        </tr>
                        <?php
                        $istrue = true;
                        $storenames = $val->StoreName;
                        $subtotal = $subtotal + floatval($val->weightPlanned);
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
                            @if($area != $val->areas)
                            <td>{{ $val->areas}}</td>
                            @else
                            <td></td>
                            @endif
                            @if($orderdate != $val->OrderDate)
                            <td>{{ $val->OrderDate}}</td>
                            @else
                            <td></td>
                            @endif
                            @if($orderNumber != $val->OrderNum)
                            <td>{{$val->OrderNum}}
                                @if($val->isReadyForInvoicing == 1 && $val->ubARIBT == 0)
                                <button style="background: #0BA008; color: white;" class="invoicethis" value="{{$val->OrderId}}">Invoice {{ $val->OrderNum}}</button>
                                <input type="text" class="invnumber" value="{{$val->InvNumber}}">
                                <input type="hidden" class="refid" value="{{$val->strUnickReference}}">
                                <input type="hidden" class="ownerid" value="{{$val->intOwnerID}}">
                                <input type="hidden" class="OrderNumdim" value="{{$val->OrderNum}}">
                                <input type="hidden" class="ubARIBT" value="{{$val->ubARIBT}}">
                                @endif
                                @if($val->isReadyForInvoicing == 1 && $val->ubARIBT == 1)
                                <button style="background: #0BA008; color: white;" class="ibt" value="{{$val->OrderId}}">IBT {{ $val->OrderNum}}</button>
                                <input type="text" class="invnumber" value="{{$val->InvNumber}}">
                                <input type="hidden" class="refid" value="{{$val->strUnickReference}}">
                                <input type="hidden" class="ownerid" value="{{$val->intOwnerID}}">
                                <input type="hidden" class="OrderNumdim" value="{{$val->OrderNum}}">
                                <input type="hidden" class="ubARIBT" value="{{$val->ubARIBT}}">
                                @endif
                            </td>
                            @else
                            <td></td>
                            @endif
                            <td>{{ $val->ExtOrderNum}}</td>
                            <td>{{ $val->iLineID}}</td>
                            <td>{{ $val->PastelCode}}</td>
                            <td>{{ $val->PastelDescription}}</td>
                            <td style="font-size: 14px; background: #cacaca">{{ floatval($val->mnyQty)}}</td>
                            <td>{{ floatval($val->weightPlanned)}}</td>
                            <td>{{ floatval($val->Toinvoice)}}</td>
                        </tr>
                        <?php
                        $storenames = $val->StoreName;
                        $subtotal = $subtotal + floatval($val->weightPlanned);
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
                            <td></td>
                            <td>{{$subtotal}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="background: grey; color: white; font-weight: 900;">
                            <td>Grand Total</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$Grandtotal}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Assign -->
            <div class="tab-pane fade" id="content3" role="tabpanel" aria-labelledby="tab3">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-md-2 mb-3">
                            <label for="horse" class="col-form-label">Horse</label>
                            <select class="form-select" type="text" id='horse'>
                                <option>
                                @foreach ($horses as $horse)
                                    <option value="{{ $horse->TruckId }}">{{ $horse->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorOne" class="col-form-label">Trailer One</label>
                            <select class="form-select" type="text" id='trailorOne'>
                                <option></option>
                                @foreach ($trailors as $trailorOne)
                                    <option value="{{ $trailorOne->TruckId }}">{{ $trailorOne->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorTwo" class="col-form-label">Trailer Two</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}">{{ $trailorTwo->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorTwo" class="col-form-label">Picker in Warehouse</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($pickers as $picker)
                                    <option value="{{ $picker->UserID }}">{{ $picker->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorTwo" class="col-form-label">Picker in Galv</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($pickers as $picker)
                                    <option value="{{ $picker->UserID }}">{{ $picker->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorTwo" class="col-form-label">Loader</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($pickers as $picker)
                                    <option value="{{ $picker->UserID }}">{{ $picker->UserName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorTwo" class="col-form-label">Loading Bay</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}">{{ $trailorTwo->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorTwo" class="col-form-label">Staging Area Warehouse</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}">{{ $trailorTwo->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="trailorTwo" class="col-form-label">Staging Area Galv</label>
                            <select class="form-select" type="text" id='trailorTwo'>
                                <option></option>
                                @foreach ($trailors as $trailorTwo)
                                    <option value="{{ $trailorTwo->TruckId }}">{{ $trailorTwo->TruckName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="ticket" class="col-form-label">Weighbridge Ticket</label>
                            <select class="form-select" type="text" id='ticket'>
                                <option></option>
                                @foreach ($tickets as $ticket)
                                    <option value="{{ $ticket->strTicket }}">{{ $ticket->strTicket }}</option>
                                @endforeach 
                            </select>
                        </div>

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
        </div>

    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
        
    });

</script>
</body>
