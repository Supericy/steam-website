@extends('master')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		{{--<div class="panel">--}}
			<div class="pull-right">
				@if (Auth::check())
				    @unless($isFollowing)
					    <a class="btn btn-success" href="{{ URL::action('steamid.follow', ['id'=>$steamId]) }}">Follow</a>
				    @else
				        <a class="btn btn-warning" href="{{ URL::action('steamid.unfollow', ['id'=>$steamId]) }}">Stop Following</a>
				    @endunless
				@else
					@include('login.prompt-modal')
					<button class="btn btn-warning" data-toggle="modal" data-target="#login-modal">Login to follow</button>
				@endif
			</div>

			<h2>{{ $steamId }} is {{ $vacBanned ? '' : 'NOT' }} VAC banned.</h2>
			<h5>Times checked: {{ $timesChecked }}</h5>
		{{--</div>--}}
	</div>

</div>

@stop