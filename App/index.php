<!DOCTYPE html>
<html ng-app="agendaApp">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Agenda</title>
		<link rel="shortcut icon" href="favicon.ico">

		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="css/toaster.css" type="text/css" />
		<link rel="stylesheet" href="css/animations.css" type="text/css" />
		<link rel="stylesheet" href="css/fullcalendar.min.css" type="text/css" />
		<link rel="stylesheet" href="css/ngDialog.min.css" type="text/css" />
		<link rel="stylesheet" href="css/ngDialog-theme-plain.min.css" type="text/css" />
		<link rel="stylesheet" href="css/spectrum.css" type="text/css" />
		<link rel="stylesheet" href="css/style.min.css" type="text/css" />
		
	</head>

	<body ng-cloak="">

		<div ng-view view-animation></div>

	</body>

	<toaster-container toaster-options="{'time-out': 3000}"></toaster-container>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script src="js/angular.min.js"></script>
	<script src="js/angular-route.min.js"></script>
	<script src="js/angular-animate.min.js"></script>
	<script src="js/ngDialog.min.js"></script>
	<script src="js/toaster.js"></script>
	<script src="js/ui-bootstrap.min.js"></script>
	<script src="js/ui-bootstrap-tpls.min.js"></script>
	<script src="js/spectrum.js"></script>
	<script src="js/angular-spectrum-colorpicker.min.js"></script>
	

	<script src="js/calendar.js"></script>
	<script src="js/fullcalendar.min.js"></script>
	<script src="js/gcal.js"></script>
	<script src="js/pt-br.js"></script>

	<script src="app/app.js"></script>
	<script src="app/data.js"></script>
	<script src="app/directives.js"></script>
	<script src="app/authCtrl.js"></script>
	<script src="app/calendarCtrl.js"></script>
</html>