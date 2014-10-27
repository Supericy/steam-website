@extends('master')

@section('content')

<div class="jumbotron">
    <div class="container">

        <div class="panel panel-primary panel-shadow">
            <div class="panel-heading medium-pad">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Steam ID</th>
                            <th>Following</th>
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
								<td>{{ $favourite->steamid }}</td>
								<td>@include('steamid.follow', ['steamId' => $favourite->steamid, 'isFollowing' => true])</td>
							</tr>
						@endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@stop