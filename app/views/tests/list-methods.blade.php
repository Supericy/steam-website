@extends('...master')

@section('content')

<ul>
	@foreach($urls as $url)
		<li>{{ HTML::link($url) }}</li>
	@endforeach
</ul>

@stop