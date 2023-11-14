@extends('layouts.admin')

@section('content')
    {{-- <h1 class="text-danger">TEST</h1> --}}
    <div class="container-fluid">

        <h2 class="text-uppercase text-dark my-4">
            {{ __('Dashboard') }}
        </h2>

        <hr>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header"><i class="fa-solid fa-user"></i> {{ __('User Dashboard') }}</div>

                    <div class="card-body">
                        <p>
                            {{ __('You are logged in') }}, {{ Auth::user()->name }}!
                        </p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header"><i class="fa-solid fa-users"></i></i> {{ __('Users') }}</div>

                    <div class="card-body">
                        <p>Numbers of Users: <strong>{{ $total_users }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header"><i class="fa-solid fa-diagram-project"></i> {{ __('Projects') }}</div>

                    <div class="card-body">
                        <p>Number of Projects registered<strong>{{ $total_projects }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
