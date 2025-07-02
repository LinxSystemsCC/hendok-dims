@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Print Products')

@php
    $includeMenu = false;

    $v = new \App\Http\Controllers\SalesForm();

    $userDepartment = Auth::user()->strPickingTeams;
    
    if (Auth::guest()) {
        $backButton = '0';
        $logoutButton = '0';
        return redirect('home');
    } else {
        $GroupId = Auth::user()->GroupId;

        $backButton = '1';
        $logoutButton = '1';

        if ($v->getThings($GroupId, 'Has Auto Redirect')) {
            if (strpos($userDepartment, '|') !== false) {
                $backButton = '0';
                $logoutButton = '1';
            } else {
                $backButton = '1';
                $logoutButton = '0';
            }
        } else {
            $backButton = '1';
            $logoutButton = '0';
        }
    }
@endphp

@section('page')

    <div class="col-lg-12">
        <div class="d-flex">
            @if ($backButton != '0')
                <button class="btn btn-dark d-flex justify-content-center align-items-center p-3"
                    onclick="location.href='{!! url('/printpalletchoosemachine') !!}/{{ $department }}'">
                    <i class="bi bi-arrow-return-left text-center h4"></i>
                </button>
            @endif

            @if ($logoutButton != '0')
                <button class="btn btn-dark d-flex justify-content-center align-items-center"
                    onclick="document.getElementById('logout-form').submit()">
                    <i class="bi bi-door-open h4"></i>
                </button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            @endif

            <div class="pe-2">
                @foreach ($departments as $val)
                    <h3>Department: {{ $val->strDeptName }}</h3>
                    <input type="hidden" id="deptid" value="{{ $val->intAutoID }}">
                @endforeach

                @foreach ($machines as $val)
                    <h3>Machine: {{ $val->strMachineName }}</h3>
                    <input type="hidden" id="machineid" value="{{ $val->intMachineID }}">
                @endforeach
            </div>
        </div>
        <br>

        <h2 id='batchRef'>Reference: NONE</h2>
        @foreach ($products as $val)
            @if ($loop->first)
                <div class="d-flex w-100 mb-2">
                    <button class="btn btn-danger rounded-0 rounded-start p-3">
                        {{ $val->intSequence }}
                    </button>

                    <button class="btn btn-danger rounded-0 rounded-end text-start p-3 w-100"
                        onclick="location.href='{!! url('/startgenratingqrcodeforpallet') !!}/{{ $val->intSoId }}/{{ $val->intDepartmentId }} }}'">
                        {{ $val->strProductDescription }} {{ $val->strPackToCut }} | {{ $val->strProductStats }}
                    </button>
                </div>
            @else
                <div class="d-flex w-100 mb-2">
                    <button class="btn btn-danger rounded-0 rounded-start p-3" disabled>
                        {{ $val->intSequence }}
                    </button>

                    <button class="btn btn-danger rounded-0 rounded-end text-start p-3 w-100" disabled>
                        {{ $val->strProductDescription }} {{ $val->strPackToCut }} | {{ $val->strProductStats }}
                    </button>
                </div>
            @endif
        @endforeach

    </div>

@endsection

@section('scripts')

    <script src="{{ asset('js/jquery.flexdatalist.min.js') }}"></script>

    <script>
        var jArray = JSON.stringify({!! json_encode($products) !!});
        var Reference = {!! json_encode($products) !!};

        $(document).ready(function() {

            console.debug(Reference);
            if (Reference.length != 0) {
                var BatchRef = Reference[0]['strReference'];
                $('#batchRef').text('BATCH REFERENCE: ' + BatchRef);
            }

            var finalData = $.map(JSON.parse(jArray), function(item) {

                return {
                    strItemCode: item.strItemCode,
                    strProductDescription: item.strProductDescription

                }

            });
            var inputProductcode = $('#productcode').flexdatalist({
                minLength: 1,
                valueProperty: '*',
                selectionRequired: true,
                focusFirstResult: true,
                searchContain: true,
                visibleProperties: ["strItemCode", "strProductDescription"],
                searchIn: 'strProductDescription',
                data: finalData
            });
            inputProductcode.on('select:flexdatalist', function(event, data) {

                $('#productcode').val(data.strItemCode);
                $('#productdesc').val(data.strProductDescription);
                //

                $.ajax({

                    url: '{!! url('/getpalletconfforitems') !!}',
                    type: "POST",
                    data: {
                        productcode: $('#productcode').val()

                    },
                    success: function(data) {
                        var toAppend = '';
                        $("#pallettype").empty();
                        $.each(data, function(i, o) {

                            toAppend += '<option value="' + o.intPalletId +
                                '"><table><tr><td style="background: green">' + o
                                .strPalletTypeDescription + ' </td><td>| /PALLET ' + o
                                .intPalletConf + '</td></tr></table></option>';
                        });
                        $("#pallettype").append(toAppend);

                    }

                });
            });

            $('#savemachine').click(function() {

                window.location.replace('{!! url('/goprintfirstqrcode') !!}/' + $('#deptid').val() + "/" + $(
                        '#machineid').val() + "/" + $('#productcode').val() + "/" + $('#pallettype')
                    .val() + "/" + $('#qtyrequired').val());

            });

            setTimeout(function() {
                window.location.reload(1);
            }, 15000);

        });
    </script>

@endsection
