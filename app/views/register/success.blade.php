@extends('master')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <div class="well">
            <h1><strong>Almost done...</strong></h1>
            <p>We've sent an activation email to <strong>{{ $email }}</strong>, please check your inbox.</p>
        </div>
    </div>
</div>

@stop