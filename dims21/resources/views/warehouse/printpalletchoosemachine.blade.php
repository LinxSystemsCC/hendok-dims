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
        }else{
            $backButton = '1';
            $logoutButton = '0';
        }
    }
@endphp

@section('page')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">


    <style>
        .vertical-menu {
            width: 200px;
        }

        .vertical-menu a {
            background-color: #eee;
            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .vertical-menu a:hover {
            background-color: #ccc;
        }

        .vertical-menu a.active {
            background-color: #04AA6D;
            color: white;
        }

        .btn {
            margin-bottom: 20px !important;
        }
    </style>

    <div class="col-lg-12" style="padding:20px; height:100vh;">
        <div style="padding-bottom: 20px; width: 100%;text-align:center; position:relative; margin: auto;">
            @foreach ($departments as $val)
                {{-- <h3>SELECTED DEPARTMENT: {{$val->strDeptName}}</h3> --}}

                <?php
                $intId = $val->intAutoID;
                ?>
            @endforeach

            <div class="d-inline-flex w-100">
                <div class="col-2 d-inline-flex">
                    @if ($backButton != '0')
                        <button class="btn btn-dark d-flex justify-content-center align-items-center me-2" style="width:75px;"
                            onclick="location.href='{!! url('/production_departments') !!}'">
                            <i class="bi bi-arrow-return-left text-center h4"></i>
                        </button>
                    @endif

                    @if ($logoutButton != '0')
                        <button class="btn btn-dark d-flex justify-content-center align-items-center" style="width:75px;"
                            onclick="document.getElementById('logout-form').submit()">
                            <i class="bi bi-door-open h4"></i>
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endif
                </div>

                <div class="col-8">
                    <h1 class="text-uppercase fw-bold" style="font-size: 50px; height: 95px;">{{ $val->strDeptName }}
                        MACHINES</h1>
                </div>

            </div>


        </div>



        @foreach ($machines as $val)
            @if ($val->intDeptID == $deparment)
                <button class="btn btn-danger"
                    onclick="location.href='{!! url('/production_labels') !!}/{{ $intId }}/{{ $val->intMachineID }}'"
                    type="button" style="width: 100% !important;font-size: 40px;">{{ $val->strMachineName }}
                </button>
            @endif
        @endforeach
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {


            $('#savemachine').click(function() {

                window.location.replace('{!! url('/choosproducttomake') !!}/' + $('#deptid').val() + "/" + $(
                    '#machines').val());

            });





        });
    </script>

@endsection
