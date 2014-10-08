<div class="btn-group-vertical">
	@if($isFollowing)
		<a class="btn btn-warning" href="{{ URL::action('steamid.unfollow', ['id'=>$steamId]) }}">Stop following</a>

			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					Notifications
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li role="presentation" class="dropdown-header">Notify when...</li>

					<li role="presentation">
						<a class="" href="#">
							{{--Not sure why, but the pull-right span has to be above the text, otherwise the icon will be on a newline--}}
							<span class="pull-right">
								<i class="fa fa-check fa-lg"></i>
							</span>

							VAC Banned
						</a>
					</li>

					<li role="presentation">
						<a class="" href="#">
							{{--Not sure why, but the pull-right span has to be above the text, otherwise the icon will be on a newline--}}
							<span class="pull-right">
								<i class="fa fa-check fa-lg"></i>
							</span>

							ESEA Banned
						</a>
					</li>
				</ul>
				<script type="text/javascript">
					$('.dropdown-menu li').click(function(e) {
						e.stopPropagation();
					});
				</script>
			</div>
	@else
		{{--User has to follow the profile to get access to notifications--}}
		<a class="btn btn-info" href="{{ URL::action('steamid.follow', ['id'=>$steamId]) }}">Follow</a>
	@endif
</div> {{--btn-group-vertical--}}