<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{--<strong>Account Registration</strong>--}}
            <h5>Account Registration</h5>
        </div>
        <div class="panel-body">

            {{ Form::open(array('action' => 'user.register', 'method' => 'post', 'role' => 'form')) }}
                {{ Form::token() }}

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

                {{ Form::submit('Register', array('class' => 'btn btn-success')) }}
            {{ Form::close() }}

            <hr />
            Already Registered ?  <a href="{{ URL::action('user.login-prompt') }}" >Login here</a>
        </div>

        <div class="panel-heading">
            {{--<strong>Login via:</strong>--}}
            <h5>Sign-in via:</h5>
        </div>
        <div class="panel-body">
            @include('login.oauth')
        </div>

    </div>
</div>