@extends('layouts.app')

{{-- @section('nav')
<div id="app2">
    <v-app>
        <nav></nav>
    </v-app>
</div>
@endsection --}}

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    {{ __('You are logged in!') }}
</div>
</div>
</div>
</div>
</div> --}}

<div id="app">
    <v-app>
        <home></home>
    </v-app>
</div>
@endsection
