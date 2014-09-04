<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::action('home') }}">Laravel Project</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            {{ HTML::nav([
				action('track-steamid') => 'Track'
            ], ['class' => 'nav navbar-nav']) }}

			@if (Auth::check())
				{{ HTML::nav([
					action('logout') => 'Logout'
				], ['class' => 'nav navbar-nav navbar-right']) }}
			@else
				{{ HTML::nav([
					action('get.login') => 'Login',
					action('get.register') => 'Register'
				], ['class' => 'nav navbar-nav navbar-right']) }}
			@endif

        </div><!-- /.navbar-collapse -->

    </div>
</div>