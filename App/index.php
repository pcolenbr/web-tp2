<!DOCTYPE html>
<html ng-app="agendaApp">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Agenda</title>

		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="css/toaster.css" type="text/css" />
		<link rel="stylesheet" href="css/animations.css" type="text/css" />
		<link rel="stylesheet" href="css/style.min.css" type="text/css" />
		
	</head>

	<body ng-cloak="">

		<div ng-view view-animation></div>

	</body>

	<toaster-container toaster-options="{'time-out': 3000}"></toaster-container>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/angular.min.js"></script>
	<script src="js/angular-route.min.js"></script>
	<script src="js/angular-animate.min.js"></script>
	<script src="js/toaster.js"></script>

	<script src="app/app.js"></script>
	<script src="app/data.js"></script>
	<script src="app/directives.js"></script>
	<script src="app/authCtrl.js"></script>
</html>