app.controller('calendarCtrl', function ($scope, $compile, Data, ngDialog) {

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

  $scope.confirmationMessage = "";
  $scope.confimationMethod = "";

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
      start: event.start,
      end: event.end.subtract(23, 'hours')
    };
    
    ngDialog.open({ 
      template: 'partials/editEventDialog.html',
      scope: $scope,
      className: 'ngdialog-theme-plain'
    });
  };

   $scope.eventRender = function( event, element, view ) { 
      var text = "<h3>" + event.title + "</h3>" + "<div>" + "<p><strong>Description:</strong> " + event.description + "</p>" + "<p><strong>Major: </strong>" + event.majorName + "</p>" + "<p><strong>Subject:</strong> " + event.subjectName + " (" + event.year + ") " + "</p>" + "</div>";
      element.attr({
                    'tooltip-html-unsafe': text
                  });
      $compile(element)($scope);
    };

  /**** Dialog Config ****/
  $scope.calendarConfig = {
      calendar:{
          editable: true,
          lang: 'en',
          header:{
              left: 'month agendaWeek agendaDay',
              center: 'title',
              right: 'today prev,next'
          },
          contentHeight: 'auto',
          timezone: 'UTC',
          events: $scope.events,
          eventClick: $scope.onEventClick,
          eventRender: $scope.eventRender
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

    $scope.majorSelected = function (majorId, enroll) {
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

    $scope.openConfirmationDialog = function (option) {
      if(option == "deleteEvent") {
        $scope.confirmationMessage = "Are you sure you want to delete this event?";
        $scope.confimationMethod = "delete";
      }
      ngDialog.open({ 
        template: 'partials/confirmationDialog.html',
        scope: $scope,
        className: 'ngdialog-theme-plain'
      });
    };

    $scope.confirmationMethod = function () {
      if($scope.confimationMethod == "delete") {
        deleteEvent();
        ngDialog.closeAll();
      }
    };



    $scope.$on('ngDialog.opened', function (event, $dialog) {
      $dialog.find('.ngdialog-content').css('width', '400px');
      $dialog.find('.ngdialog-content').css('border-radius', '10px');
      $dialog.find('.ngdialog-content').css('padding', '0px 0px 10px');
      $dialog.find('.ngdialog-content').css('box-shadow', '3px 3px 13px 0px rgba(50, 50, 50, 0.49)');
    });

    $scope.$watch('events', function() {
      $scope.calendarConfig.calendar.events = $scope.events;
    });




    function listEvents() {
      $scope.events = [];
      Data.post('getEvents', null).then(function (results) {
        if (results.status == "success") {
          var data = results.eventos;
          for(var i in data) {
            $scope.events[i] = {
              id: data[i].id_evento,
              allDay: true,
              title: data[i].nome_evento, 
              start: moment(data[i].data_inicio_evento), 
              end: moment(data[i].data_fim_evento).add(23, 'hours'),
              description: data[i].descricao_evento,
              color: data[i].cor_materia,
              majorId: data[i].id_curso,
              majorName: data[i].nome_curso,
              subjectId: data[i].id_materia,
              subjectName: data[i].nome_materia,
              teste: data[i].teste_evento,
              year: data[i].ano_materia + "/" + data[i].semestre_materia
            };
          }
        }
      });
    }

    function listClassesNames(majorId, enroll) {
      $scope.subjects = [];
      Data.post('getClassesNames', {
        id_curso: majorId,
        enroll: enroll
      }).then(function (results) {
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

    function listMajors(enroll) {
      $scope.majors = [];
      Data.post('getMajors', {
        enroll: enroll
      }).then(function (results) {
        
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
        if (results.status == "success") {
          var data = results.anos;
          for(var i in data) {
            $scope.yearsPeriods[i] = {id: data[i].id_materia, year: data[i].ano_materia + "/" + data[i].semestre_materia};
          }
        }
      });
    }

    function deleteEvent() {
      Data.post('deleteEvent', {
        currentEvent: $scope.currentEvent
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          listEvents();
        }
      });
    }

});