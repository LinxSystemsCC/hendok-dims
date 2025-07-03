@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Print Products')

@php
    $includeMenu = false;

    $v = new \App\Http\Controllers\SalesForm();
    if (Auth::guest()) {
        $backButton = '0';
        $logoutButton = '0';
        return redirect('home');
    } else {
        $GroupId = Auth::user()->GroupId;

        $backButton = '1';
        $logoutButton = '1';

        if ($v->getThings($GroupId, 'Has Auto Redirect')) {
            $backButton = '0';
            $logoutButton = '1';
        } else {
            $backButton = '1';
            $logoutButton = '0';
        }
    }
@endphp

@section('page')

    <div class="col-lg-12">
        <div class="d-flex w-100 mb-2">
            @foreach ($departments as $val)
                <?php
                $intId = $val->intAutoID;
                ?>
            @endforeach

            <div class="d-inline-flex w-100">
                <div class="col-2 d-inline-flex">
                    @if ($backButton != '0')
                        <button class="btn btn-dark d-flex justify-content-center align-items-center p-3"
                            onclick="location.href='{!! url('/production_departments') !!}'">
                            <i class="bi bi-arrow-return-left text-center h4"></i>
                        </button>
                    @endif

                    @if ($logoutButton != '0')
                        <button class="btn btn-dark d-flex justify-content-center align-items-center p-3"
                            onclick="document.getElementById('logout-form').submit()">
                            <i class="bi bi-door-open h4"></i>
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>
                            @csrf
                        </form>
                    @endif
                </div>

                <div class="col-8 d-flex justify-content-center align-items-center">
                    <h1 class="text-uppercase fw-bold m-0">
                        {{ $val->strDeptName }} MACHINES
                    </h1>
                </div>
            </div>
        </div>

        @foreach ($machines as $val)
            @if ($val->intDeptID == $deparment)
                <button class="btn btn-danger mb-2 w-100 fs-1"
                    onclick="location.href='{!! url('/production_labels') !!}/{{ $intId }}/{{ $val->intMachineID }}'"
                    type="button">{{ $val->strMachineName }}
                </button>
            @endif
        @endforeach
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#savemachine').click(function() {
                window.location.replace('{!! url('/choosproducttomake') !!}/' + $('#deptid').val() + "/" + $('#machines').val());
            });
        });
    </script>

@endsection
