<div class="container">
	{{--<div class="alert alert-success text-center">This account has <span style="font-weight: bolder">league experience!</span></div>--}}

    <div class="panel panel-primary">
        <div class="panel-heading medium-pad">
            <table class="table">
                <thead>
                    <tr>
						<th>Player</th>
						<th>League</th>
						<th>Division</th>
						<th>Team</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="panel-body medium-pad">
            <table id="ban-table" class="table table-hover table-condensed">
                <tbody>
					@foreach ($leagueExperiences as $exp)
						<tr>
							<td>{{ $exp->player }}</td>
							<td><span class="" style="color: #009926">{{ $exp->league }}</span></td>
							<td><span class="text-info" style="">{{ $exp->division }}</span></td>
							<td>{{ $exp->team }}</td>
						</tr>
					@endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>