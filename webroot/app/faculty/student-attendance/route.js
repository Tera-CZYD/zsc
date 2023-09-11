app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/student-attendance', {

    templateUrl: 'angularjs/views/faculty/student-attendance/index.ctp',

    controller: 'StudentAttendanceController',

  })

  .when('/faculty/student-attendance/add/:id/:sub_id/:course_id', {

    templateUrl: 'angularjs/views/faculty/student-attendance/add.ctp',

    controller: 'StudentAttendanceAddController',

  })

  .when('/faculty/student-attendance/view-attendance/:id/:sub_id/:course_id', {

    templateUrl: 'angularjs/views/faculty/student-attendance/view-attendance.ctp',

    controller: 'StudentAttendanceViewDetailController',

  })

  .when('/faculty/student-attendance/edit/:id', {

    templateUrl: 'angularjs/views/faculty/student-attendance/edit.ctp',

    controller: 'StudentAttendanceEditController',

  })

 .when('/faculty/student-attendance/view/:id', {

    templateUrl: 'angularjs/views/faculty/student-attendance/view.ctp',

    controller: 'StudentAttendanceViewController',

  }); 

});


