<div id="ban-list-container" class="container">
	<div class="alert alert-danger">This account has been <span style="font-weight: bolder">banned!</span></div>

    <div class="panel panel-primary">
        <div class="panel-heading medium-pad">
            <table class="table">
                <thead>
                    <tr>
                        <th>Steam ID</th>
                        <th>Type</th>
                        <th>Alias</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="panel-body medium-pad">
            <table id="ban-table" class="table table-hover table-condensed">
                <tbody>
                    @foreach ($bans as $ban)
                        @if($ban->isBanned())
                            <tr>
                                <td>{{ $steamIdText }}</td>
                                <td><span class="text-danger">{{ $ban->getBanName() }}</span></td>

                                @if(method_exists($ban, 'getAlias'))
                                    <td>{{ $ban->getAlias() }}</td>
                                @endif
                                <td class="">{{ date('F jS, Y', $ban->getTimestamp()) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>