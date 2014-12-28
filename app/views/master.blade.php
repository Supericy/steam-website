<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Steam Stats</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
    <!-- Latest compiled and minified JavaScript -->
    {{--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>--}}

    {{--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>--}}

    {{--<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->--}}
    {{--<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->--}}
    {{--<!--[if lt IE 9]>--}}
    {{--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>--}}
    {{--<!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->--}}
    {{--<![endif]-->--}}

	@includeBowerComponents()

	{{--<script src="/bower_components/jquery/dist/jquery.js"></script>--}}
	{{--<script src="/bower_components/angular/angular.js"></script>--}}
	{{--<script src="/bower_components/angular-route/angular-route.js"></script>--}}
	{{--<script src="/bower_components/bootstrap/dist/js/bootstrap.js"></script>--}}

	{{--<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css" />--}}

    <!-- load google Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

	{{--{{ HTML::style('css/paper-bootstrap.min.css') }}--}}
	{{ HTML::style('css/darkly-bootstrap.min.css') }}
	{{--{{ HTML::style('css/flatly-bootstrap.min.css') }}--}}
	{{--{{ HTML::style('css/sandstone-bootstrap.min.css') }}--}}
	{{--{{ HTML::style('css/yeti-bootstrap.min.css') }}--}}

    {{ HTML::style('css/master.style.css') }}

	{{ HTML::script('js/main.js') }}
</head>
<body>

    @include('navigation-bar')

	<div ng-app="SteamApp">
		<div class="pad-top">
			<div class="container">
				{{ ViewHelper::displayAlerts(Session::get('alerts.success'), 	'success', 	true) }}
				{{ ViewHelper::displayAlerts(Session::get('alerts.info'), 		'info', 	true) }}
				{{ ViewHelper::displayAlerts(Session::get('alerts.warning'), 	'warning', 	true) }}
				{{ ViewHelper::displayAlerts(Session::get('alerts.danger'), 	'danger', 	true) }}
			</div>

			<div id="context">
				@yield('content')
			</div>
		</div>
	</div>
</body>
</html>