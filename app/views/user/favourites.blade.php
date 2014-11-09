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
								<td>
									<a href="{{ URL::action('steamid.display', ['steamid' => $favourite->steamId->steamid]) }}" >
										<div>
											<img src="{{ $favourite->profile->getMediumAvatarUrl() }}" alt="" />
											{{ $favourite->profile->getAlias() }}
										</div>
									</a>
								</td>
								<td style="vertical-align: middle">STEAM_{{ $favourite->steamId->text }}</td>
								<td style="vertical-align: middle">
									<div  class="pull-right">@include('steamid.follow', ['steamId' => $favourite->steamId->text, 'isFollowing' => true])</div>
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