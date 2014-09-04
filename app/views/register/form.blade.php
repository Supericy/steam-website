<div class="container">
<!--	<div class="row text-center pad-top ">-->
<!--		<div class="col-md-12">-->
<!--			<h2>Bootstrap Registration Page</h2>-->
<!--		</div>-->
<!--	</div>-->
	<div class="row pad-top">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Account Registration</strong>
				</div>
				<div class="panel-body">

					{{ Form::open(array('action' => 'post.register', 'method' => 'post', 'role' => 'form')) }}
                        {{ Form::token() }}

						<div class="form-group input-group">
							<span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                            {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Desired Username', 'autofocus'=>'autofocus')) }}
						</div>
                        {{ ViewHelper::displayArray($errors->get('username', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

						<div class="form-group input-group">
							<span class="input-group-addon">@</span>
							{{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Your Email')) }}
						</div>
                        {{ ViewHelper::displayArray($errors->get('email', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

						<div class="form-group input-group">
							<span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
							{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter Password')) }}
						</div>
                        {{ ViewHelper::displayArray($errors->get('password', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

						<div class="form-group input-group">
							<span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
							{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Re-Enter Password')) }}
						</div>
                        {{ ViewHelper::displayArray($errors->get('password_confirmation', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

                        {{ Form::submit('Register Me', array('class' => 'btn btn-success')) }}
						<hr />
						Already Registered ?  <a href="{{ URL::route('home') }}" >Login here</a>
					{{ Form::close() }}

				</div>

			</div>
		</div>
	</div>
</div>