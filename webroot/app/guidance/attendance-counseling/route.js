app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/attendance-counseling', {

    templateUrl: 'angularjs/views/guidance/attendance-counseling/index.ctp',

    controller: 'AttendanceCounselingController',

  })

  .when('/guidance/attendance-counseling/add', {

    templateUrl: 'angularjs/views/guidance/attendance-counseling/add.ctp',

    controller: 'AttendanceCounselingAddController',

  })

    .when('/guidance/attendance-counseling/edit/:id', {

    templateUrl: 'angularjs/views/guidance/attendance-counseling/edit.ctp',

    controller: 'AttendanceCounselingEditController',

  })

    .when('/guidance/attendance-counseling/view/:id', {

    templateUrl: 'angularjs/views/guidance/attendance-counseling/view.ctp',

    controller: 'AttendanceCounselingViewController',

  });
  
});