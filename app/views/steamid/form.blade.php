<div class="container">
<!--	<div class="row text-center pad-top ">-->
<!--		<div class="col-md-12">-->
<!--			<h2>Bootstrap Login Page</h2>-->
<!--		</div>-->
<!--	</div>-->
	<div class="row  pad-top">
		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Find Profile</strong>
				</div>
				<div class="panel-body">

					{{ Form::open(array('action' => 'search-steamid', 'method' => 'GET', 'role' => 'form', 'onsubmit' => 'return processForm()')) }}

					<div class="form-group">
<!--						<span class="input-group-addon">-->
<!--							<i class="fa fa-tag"  ></i>-->
<!--						</span>-->
						<div class="input-group">
							{{ Form::text('steamid', null, array('id' => 'steamid', 'class' => 'form-control', 'placeholder' => 'SteamID (e.g 0:0:11223344)', 'autofocus'=>'autofocus')) }}
							<span class="input-group-btn">
								{{--<button class="btn btn-success" type="button">Search</button>--}}
								{{ Form::submit('Search', array('class' => 'btn btn-success')) }}
							</span>
						</div>
					</div>
					{{ ViewHelper::displayArray($errors->get('steamid', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

					{{--<div class="panel panel-shadow panel-info">--}}
						{{--<div class="panel-heading">Examples:</div>--}}
						{{--<div class="panel-body">--}}
								{{--<div>0:0:30908</div>--}}
								{{--<div>STEAM_0:0:30908</div>--}}
						{{--</div>--}}
					{{--</div>--}}
					<div>
						<div class="text-info" style="font-style: italic; font-weight: bold">Example Inputs:</div>
						<div><span style="font-style: italic; font-size: 13px;">
							STEAM_0:0:30908 <br/> 0:0:30908 <br/> 76561197984726529 <br/>
							steamcommunity.com/id/supericy <br/>
							steamcommunity.com/profiles/76561198050774634
						</span></div>
					</div>


					{{ Form::close() }}

				</div>

			</div>
		</div>
	</div>
</div>