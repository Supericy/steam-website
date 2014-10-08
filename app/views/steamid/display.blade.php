@extends('master')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<div class="pull-right">
			@include('steamid.follow')
		</div> {{--pull-right--}}

		<div class="col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
			@if($hasBans)
				@include('steamid.ban-list')
			@endif

			@include('steamid.league-experience-list')

			@include('steamid.display-info')
		</div>
	</div> {{--container--}}
</div> {{--jumboron--}}

@stop