@extends('master')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container text-center">
		<div class="profile-header">
			<div class="profile-image">
				<img src="{{ $profile->getFullAvatarUrl() }}" width="100px" height="100px" />
			</div>

			<div class="profile-name">
				<div>{{ $profile->getAlias() }}</div>
				<div class="profile-status">{{ $profile->getPersonaState()->string() }}</div>
			</div>

			<div class="pull-right text-right">
				@include('steamid.follow')
			</div>
		</div>
	</div>

	<div class="container">
		<div class="profile-body col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 pad-top">
			@if($hasBans)
				@include('steamid.ban-list')
			@endif

			@if($hasLeagueExperiences)
				@include('steamid.league-experience-list')
			@endif

			@include('steamid.display-info')
		</div>
	</div> {{--container--}}
</div> {{--jumboron--}}

@stop