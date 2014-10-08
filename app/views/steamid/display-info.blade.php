<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading medium-pad">
			<table class="table">
				<thead>
					<tr>
						<th>Profile Information</th>
						{{--<th>Data</th>--}}
					</tr>
				</thead>
				<tbody></tbody>
			</table>
        </div>

        <div class="panel-body medium-pad">
            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>
                        <td>SteamID (text)</td>
                        <td>{{ $steamIdText }}</td>
                    </tr>

                    <tr>
                        <td>SteamID (64bit)</td>
                        <td>{{ $steamId64 }}</td>
                    </tr>

					@foreach ($bans as $ban)
						<tr>
							<td>{{ $ban->getBanName() }} Status</td>
							<td>
								@if ($ban->isBanned())
									<span class="text-danger">BANNED</span>
								@else
									<span class="" style="color: #009926">Good</span>
								@endif
							</td>
						</tr>
					@endforeach

					<tr>
						<td>Times Checked:</td>
						<td>{{ $timesChecked }}</td>
					</tr>

					<tr>
						<td>Community Profile:</td>
						<td>{{ HTML::link($communityUrl) }}</td>
					</tr>
                </tbody>
            </table>
        </div>
    </div>
</div>