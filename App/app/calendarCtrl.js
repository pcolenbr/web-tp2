app.controller('calendarCtrl', function ($scope, Data, ngDialog) {

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  $scope.currentEvent = {id:'', nm:'', description:'', major:'', subjectName:'', subjectId:'', start:'', end:''};
  $scope.enrollment = {major:'', subjectId:''};
  $scope.majors = [];
  $scope.subjects = [];

  $scope.selectClassMessage = "-- Select a Class --";
  $scope.yearsPeriods = [];

  $scope.events = [];

  listEvents();

  /**** Dialog Events ****/

  $scope.onEventClick = function( event, jsEvent, view){
    listMajors(false);
    listClassesNames(event.majorId, false);
    listYearsSemester({name: event.subjectName}, false);
    $scope.currentEvent = {
      id: event.id,
      nm: event.title,
      description: event.description,
      major: event.majorId,
      subjectName: event.subjectName,
      subjectId: event.subjectId,
      start: new Date(event.start),
      end: new Date(event.end)
    };
    ngDialog.open({ 
      template: 'partials/editEventDialog.html',
      scope: $scope,
      className: 'ngdialog-theme-plain'
    });
  };

  /**** Dialog Config ****/
	$scope.calendarConfig = {
    	calendar:{
        	editable: true,
          //lang: 'pt-br',
        	header:{
          		left: 'month agendaWeek agendaDay',
          		center: 'title',
          		right: 'today prev,next'
        	},
          contentHeight: 'auto',
          events: $scope.events,
        	eventClick: $scope.onEventClick
      	}
    };

    /**** Other Events ****/
    $scope.openAddDialog = function () {
      $scope.currentEvent = {id:'', nm:'', description:'', major:'', subjectName:'', subjectId:'', start:'', end:''};
      listMajors(false);

      ngDialog.open({ 
        template: 'partials/newEventDialog.html',
        scope: $scope,
        className: 'ngdialog-theme-plain'
      });
    };

    $scope.$on('ngDialog.opened', function (event, $dialog) {
      $dialog.find('.ngdialog-content').css('width', '400px');
      $dialog.find('.ngdialog-content').css('border-radius', '10px');
      $dialog.find('.ngdialog-content').css('padding', '0px 0px 10px');
      $dialog.find('.ngdialog-content').css('box-shadow', '3px 3px 13px 0px rgba(50, 50, 50, 0.49)');
    })

    $scope.majorSelected = function (majorId, enroll) {
      $scope.subjects = [];
      listClassesNames(majorId, enroll)
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

    $scope.editEvent = function (currentEvent) {
      Data.post('editEvent', {
        currentEvent: currentEvent
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          listEvents();
          $scope.currentEvent = {id:'', nm:'', description:'', major:'', subjectName:'', subjectId:'', start:'', end:''};
        }
      });
    };

    $scope.openEnrollmentDialog = function () {
      listMajors(true);

      ngDialog.open({ 
        template: 'partials/enrollmentDialog.html',
        scope: $scope,
        className: 'ngdialog-theme-plain'
      });
    };

    $scope.enroll = function (enrollment) {
      Data.post('enroll', {
        enrollment: enrollment
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          listEvents();
        }
      });
    };

    $scope.classSelected = function (subjectName, enroll) {
      $scope.yearsPeriods = [];
      listYearsSemester(subjectName, enroll);
    };





    function listClassesNames(majorId, enroll) {
      Data.post('getClassesNames', {
        id_curso: majorId,
        enroll: enroll
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          var data = results.materias;
          $scope.selectClassMessage = "-- Select a Class --";
          for(var i in data) {
            $scope.subjects[i] = {name: data[i].nome_materia};
          }
        } else {
          $scope.selectClassMessage = "-- No Classes Found --";
        }
      });
    } 

    function listEvents() {
      Data.post('getEvents', null).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          var data = results.eventos;
          for(var i in data) {
            $scope.events[i] = {
              id: data[i].id_evento,
              title: data[i].nome_evento, 
              start: data[i].data_inicio_evento,
              description: data[i].descricao_evento,
              majorId: data[i].id_curso,
              subjectId: data[i].id_materia,
              subjectName: data[i].nome_materia,
              year: data[i].ano_materia + "/" + data[i].semestre_materia
            };
          }
        }
      });
    }

    function listMajors(enroll) {
      $scope.majors = [];
      Data.post('getMajors', {
        enroll: enroll
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          var data = results.cursos;
          for(var i in data) {
            $scope.majors[i] = {id: data[i].id_curso, name: data[i].nome_curso, ab:data[i].ab_curso};
          }
        }
      });
    }

    function listYearsSemester(subjectName, enroll) {
      $scope.yearsPeriods = [];
      Data.post('listYearsSemester', {
        nome_materia: subjectName,
        enroll: enroll
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          var data = results.anos;
          for(var i in data) {
            $scope.yearsPeriods[i] = {id: data[i].id_materia, year: data[i].ano_materia + "/" + data[i].semestre_materia};
          }
        }
      });
    }

});