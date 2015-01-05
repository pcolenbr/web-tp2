app.controller('calendarCtrl', function ($scope, Data, ngDialog) {

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  $scope.currentEvent = {nm:''};
  $scope.events = [];

  Data.post('getEvents', null).then(function (results) {
    Data.toast(results);
    if (results.status == "success") {
      var data = results.eventos;
      for(var i in data) {
        $scope.events[i] = {title: data[i].nome_evento, start:data[i].data_inicio_evento};
      }
    }
  });

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
      ngDialog.open({ 
        template: 'partials/newEventDialog.html',
        scope: $scope,
        className: 'ngdialog-theme-plain'
      });
    };


    $scope.addEvent = function (currentEvent) {

      Data.post('createEvent', {
        currentEvent: currentEvent
      }).then(function (results) {
        Data.toast(results);
        if (results.status == "success") {
          $scope.events.push({
            title: $scope.currentEvent.nm,
            start: new Date(y, m, 7)
          });
        }
      });
    };

});