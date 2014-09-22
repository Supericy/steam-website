<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{--<strong>Account Login</strong>--}}
            <h5>Sign-in</h5>
        </div>
        <div class="panel-body">

            {{ Form::open(array('action' => 'post.login', 'method' => 'post', 'role' => 'form')) }}
                {{ Form::token() }}

                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                    {{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Your Email', 'autofocus'=>'autofocus')) }}
                </div>
                {{ ViewHelper::displayArray($errors->get('email', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}


                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                    {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
                </div>
                {{ ViewHelper::displayArray($errors->get('password', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

                {{ ViewHelper::displayArray($errors->get('login', '<div class="alert alert-danger alert-input-error" role="alert">:message</div>')) }}

                {{ Form::submit('Login', array('class' => 'btn btn-success')) }}
            {{ Form::close() }}

            <hr/>
            Need an account? <a href="{{ URL::route('get.register') }}" >Register</a>
            <br/>
            <a href="{{ URL::route('login.recovery') }}" >Password recovery</a>
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