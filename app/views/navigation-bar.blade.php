<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::action('home') }}">Steam Stats</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            {{ HTML::nav([
				action('search-steamid') => 'Search'
            ], ['class' => 'nav navbar-nav h5']) }}

			@if (Auth::check())
				{{ HTML::nav([
					action('profile.favourites') => 'Favourites',
					action('logout') => 'Logout'
				], ['class' => 'nav navbar-nav navbar-right']) }}
			@else
				{{ HTML::nav([
					action('user.login-prompt') => 'Login',
					action('user.register-prompt') => 'Register'
				], ['class' => 'nav navbar-nav navbar-right h5']) }}
			@endif

        </div><!-- /.navbar-collapse -->

    </div>
</div>