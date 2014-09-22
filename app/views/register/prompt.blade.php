@extends('master')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    {{--@include('register.form')--}}
    <div class="container">
        <div class="row pad-top">
            <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                @include('register.form')
            </div>
        </div>
    </div>
</div>

@stop