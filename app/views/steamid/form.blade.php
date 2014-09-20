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
						{{ Form::text('steamid', null, array('id' => 'steamid', 'class' => 'form-control', 'placeholder' => 'steamid (e.g 0:0:11223344)', 'autofocus'=>'autofocus')) }}
					</div>
					{{ ViewHelper::displayArray($errors->get('steamid', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

					{{ Form::submit('Submit', array('class' => 'btn btn-success pull-right')) }}
					{{ Form::close() }}

				</div>

			</div>
		</div>
	</div>
</div>