<div class="container">
    <div class="row text-center pad-top ">
        <div class="col-md-12">
            <h2>Bootstrap Login Page</h2>
        </div>
    </div>
    <div class="row  pad-top">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Account Login</strong>
                </div>
                <div class="panel-body">

                    {{ Form::open(array('action' => 'post.login', 'method' => 'post', 'role' => 'form')) }}
                        {{ Form::token() }}

                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                            {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Username', 'autofocus'=>'autofocus')) }}
                        </div>
                        {{ ViewHelper::displayArray($errors->get('username', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}


                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
                        </div>
                        {{ ViewHelper::displayArray($errors->get('password', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}


                        {{ Form::submit('Login', array('class' => 'btn btn-success')) }}
                        <hr />
                        <a href="{{ URL::route('login.recovery') }}" >Password recovery</a>
                    {{ Form::close() }}

                </div>

            </div>
        </div>
    </div>
</div>