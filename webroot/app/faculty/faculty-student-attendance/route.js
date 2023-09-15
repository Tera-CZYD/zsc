app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/faculty-student-attendance', {

    templateUrl: 'angularjs/views/faculty/faculty-student-attendance/index.ctp',

    controller: 'FacultyStudentAttendanceController',

  })

  .when('/faculty/faculty-student-attendance/view-section/:id', {

    templateUrl: 'angularjs/views/faculty/faculty-student-attendance/view-section.ctp',

    controller: 'FacultyStudentAttendanceViewSectionController',

  })

 .when('/faculty/faculty-student-attendance/add', { 

   templateUrl: 'angularjs/views/faculty/faculty-student-attendance/add.ctp',

  controller: 'FacultyStudentAttendanceAddController',

 })

 .when('/faculty/faculty-student-attendance/edit/:id', {

   templateUrl: 'angularjs/views/faculty/faculty-student-attendance/edit.ctp',

   controller: 'FacultyStudentAttendanceEditController',

  })

 .when('/faculty/faculty-student-attendance/view/:id', {

    templateUrl: 'angularjs/views/faculty/faculty-student-attendance/view.ctp',

    controller: 'FacultyStudentAttendanceViewController',

  })

 .when('/faculty/faculty-student-attendance/view-students/:id/:course/:faculty', {

    templateUrl: 'angularjs/views/faculty/faculty-student-attendance/view-students.ctp',

    controller: 'FacultyStudentAttendanceViewStudentsController',

  });

});


