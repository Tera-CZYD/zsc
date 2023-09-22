app.config(function($routeProvider) {

  $routeProvider

  .when('/student/schedule', {

    templateUrl: 'angularjs/views/student-schedule/index.ctp',

    controller: 'StudentScheduleController',

  });
  
});