@extends('master')

@section('content')

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<class class="panel">
			<h3>{{ $steamId }} is {{ $vacBanned ? '' : 'NOT' }} VAC banned.</h3>
		</class>
	</div>

</div>

@stop