<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Steam Stats</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
<!--    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- load google Open Sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

	{{--{{ HTML::style('css/paper-bootstrap.min.css') }}--}}
	{{ HTML::style('css/darkly-bootstrap.min.css') }}
	{{--{{ HTML::style('css/flatly-bootstrap.min.css') }}--}}
	{{--{{ HTML::style('css/sandstone-bootstrap.min.css') }}--}}
	{{--{{ HTML::style('css/yeti-bootstrap.min.css') }}--}}
    {{ HTML::style('css/master.style.css') }}
</head>
<body>

    @include('navigation-bar')

	<div id="content">
		<div class="pad-top">
			<div class="container">
				{{--{{ ViewHelper::displayArray(Session::get('alerts.success'),	'<div class="alert alert-success alert-dismissible" role="alert">:message</div>') }}--}}
				{{--{{ ViewHelper::displayArray(Session::get('alerts.info'),	'<div class="alert alert-info alert-dismissible" role="alert">:message</div>') }}--}}
                {{--{{ ViewHelper::displayArray(Session::get('alerts.warning'),	'<div class="alert alert-warning alert-dismissible" role="alert">:message</div>') }}--}}
                {{--{{ ViewHelper::displayArray(Session::get('alerts.danger'),	'<div class="alert alert-danger alert-dismissible" role="alert">:message</div>') }}--}}

				{{ ViewHelper::displayAlerts(Session::get('alerts.success'), 	'success', 	true) }}
				{{ ViewHelper::displayAlerts(Session::get('alerts.info'), 		'info', 	true) }}
				{{ ViewHelper::displayAlerts(Session::get('alerts.warning'), 	'warning', 	true) }}
				{{ ViewHelper::displayAlerts(Session::get('alerts.danger'), 	'danger', 	true) }}
			</div>

			@yield('content')
		</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

	{{ HTML::script('js/main.js') }}
</body>
</html>