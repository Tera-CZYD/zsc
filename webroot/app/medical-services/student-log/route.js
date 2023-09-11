app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/student-log', {

    templateUrl: 'angularjs/views/medical-services/student-log/index.ctp',

    controller: 'StudentLogController',

  })

  .when('/medical-services/student-log/add', {

    templateUrl: 'angularjs/views/medical-services/student-log/add.ctp',

    controller: 'StudentLogAddController',

  })

    .when('/medical-services/student-log/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/student-log/edit.ctp',

    controller: 'StudentLogEditController',

  })

    .when('/medical-services/student-log/view/:id', {

    templateUrl: 'angularjs/views/medical-services/student-log/view.ctp',

    controller: 'StudentLogViewController',

  })

  // .when('/medical-services/student-log/student-index', {

  //   templateUrl: tmp + 'medical_services__student_log__student_index',

  //   controller: 'StudentStudentLogController',

  // })

  // .when('/medical-services/student-log/student-add', {

  //   templateUrl: tmp + 'medical_services__student_log__student_add',

  //   controller: 'StudentStudentLogAddController',

  // })

  //   .when('/medical-services/student-log/student-edit/:id', {

  //   templateUrl: tmp + 'medical_services__student_log__student_edit',

  //   controller: 'StudentStudentLogEditController',

  // })

  //   .when('/medical-services/student-log/student-view/:id', {

  //   templateUrl: tmp + 'medical_services__student_log__student_view',

  //   controller: 'StudentStudentLogViewController',

  // });
  
});