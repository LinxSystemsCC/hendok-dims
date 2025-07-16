@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Print Products')

@php
    $includeMenu = false;

    $userDepartment = Auth::user()->strPickingTeams;

    if (Auth::guest()) {
        $backButton = '0';
        $logoutButton = '0';
        return redirect('home');
    } else {
        $backButton = '1';
        $logoutButton = '1';

        if ($hasRedirect) {
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
        <div class="d-flex w-100 mb-2">
            <div class="col-2 d-inline-flex">
                <button class="btn btn-dark d-flex justify-content-center align-items-center p-3"
                    onclick="document.getElementById('logout-form').submit()">
                    <i class="bi bi-door-open h4"></i>
                </button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>
                    @csrf
                </form>
            </div>

            <div class="col-8 d-flex justify-content-center align-items-center">
                <h1 class="text-uppercase fw-bold m-0">
                    PICK DEPARTMENT
                </h1>
            </div>
        </div>

        @foreach ($departments as $val)
            <button class="btn btn-danger mb-2 w-100 fs-1" onclick="location.href='{!! url('/production_machines') !!}/{{ $val->intAutoID }}'"
                type="button">{{ $val->strDeptName }}
            </button>
        @endforeach
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#selecteddept').click(function() {
                var selecteddept = $(this).val();
                window.location.replace('{!! url('/production_machines') !!}/' + selecteddept);
            });
        });
    </script>

@endsection
