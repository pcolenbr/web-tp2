app.controller('calendarCtrl', function ($scope, Data, ngDialog) {

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  $scope.currentEvent = {nm:''};
  $scope.majors = [];
  $scope.subjects = [];

  $scope.events = [];

  listEvents();

	$scope.calendarConfig = {
    	calendar:{
        	editable: true,
          //lang: 'pt-br',
        	header:{
          		left: 'month basicWeek basicDay agendaWeek agendaDay',
          		center: 'title',
          		right: 'today prev,next'
        	},
          events: $scope.events,
        	dayClick: $scope.alertEventOnClick,
        	eventDrop: $scope.alertOnDrop,
        	eventResize: $scope.alertOnResize
      	}
    };


    $scope.openAddDialog = function () {

      Data.post('getMajors', null).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          var data = results.cursos;
          for(var i in data) {
            $scope.majors[i] = {id: data[i].id_curso, name: data[i].nome_curso, ab:data[i].ab_curso};
          }
        }
      });

      ngDialog.open({ 
        template: 'partials/newEventDialog.html',
        scope: $scope,
        className: 'ngdialog-theme-plain'
      });
    };

    $scope.$on('ngDialog.opened', function (event, $dialog) {
        $dialog.find('.ngdialog-content').css('width', '400px');
        $dialog.find('.ngdialog-content').css('border-radius', '10px');
        $dialog.find('.ngdialog-content').css('box-shadow', '3px 3px 13px 0px rgba(50, 50, 50, 0.49)');
      })

    $scope.majorSelected = function (major) {
      $scope.subjects = [];
      Data.post('getClasses', {
        id_curso: major
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          var data = results.materias;
          for(var i in data) {
            $scope.subjects[i] = {id: data[i].id_materia, name: data[i].nome_materia, ab:data[i].ab_materia};
          }
        } 
      });
    };

    $scope.addEvent = function (currentEvent) {
      Data.post('createEvent', {
        currentEvent: currentEvent
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          listEvents();
        }
      });
    };

    function listEvents() {
      Data.post('getEvents', null).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          var data = results.eventos;
          for(var i in data) {
            $scope.events[i] = {title: data[i].nome_evento, start:data[i].data_inicio_evento};
          }
        }
      });
    }

});