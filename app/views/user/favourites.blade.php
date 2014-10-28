@extends('master')

@section('content')

<div class="jumbotron">
    <div class="container">
		<h1>Favourites:</h1>

        <div class="panel panel-primary panel-shadow">
            <div class="panel-heading medium-pad">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Steam ID</th>
                            <th>Steam ID</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="panel-body medium-pad">
                <table id="ban-table" class="table table-hover table-condensed">
                    <tbody>
                        @foreach ($favourites as $favourite)
							<tr>
								<td><img src="{{ $favourite->profile->getAvatarUrl() }}" alt="" /> {{ $favourite->profile->getAlias() }}</td>
								<td>{{ $favourite->steamid }}</td>
								<td>
									<div  class="pull-right">@include('steamid.follow', ['steamId' => $favourite->steamid, 'isFollowing' => true])</div>
								</td>
							</tr>
						@endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@stop