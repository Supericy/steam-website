@extends('master')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container text-center">
		<div class="profile-header">
			<div class="profile-image">
				<img src="http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg" width="100px" height="100px" />
			</div>

			<div class="profile-name">Supericy</div>

			<div class="profile-follow">@include('steamid.follow')</div>

			<div class="pull-right text-right">


				<div class="profile-status">Currently Online</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="profile-body col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 pad-top">
			@if($hasBans)
				@include('steamid.ban-list')
			@endif

			@if(count($leagueExperiences) > 0)
				@include('steamid.league-experience-list')
			@endif

			@include('steamid.display-info')
		</div>
	</div> {{--container--}}
</div> {{--jumboron--}}

@stop