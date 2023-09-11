app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/student-club', {

    templateUrl: 'angularjs/views/registrar/student-club/index.ctp',

    controller: 'StudentClubController',

  })

  .when('/registrar/student-club/add', {

    templateUrl: 'angularjs/views/registrar/student-club/add.ctp',

    controller: 'StudentClubAddController',

  })

  .when('/registrar/student-club/edit/:id', {

    templateUrl: 'angularjs/views/registrar/student-club/edit.ctp',

    controller: 'StudentClubEditController',

  })

  .when('/registrar/student-club/view/:id', {

    templateUrl: 'angularjs/views/registrar/student-club/view.ctp',

    controller: 'StudentClubViewController',

  })

  .when('/registrar/admin-student-club', {

    templateUrl: 'angularjs/views/registrar/student-club/admin-index.ctp',

    controller: 'AdminStudentClubController',

  })

  .when('/registrar/admin-student-club/add', {

    templateUrl: 'angularjs/views/registrar/student-club/admin-add.ctp',

    controller: 'AdminStudentClubAddController',

  })

    .when('/registrar/admin-student-club/edit/:id', {

    templateUrl: 'angularjs/views/registrar/student-club/admin-edit.ctp',

    controller: 'AdminStudentClubEditController',

  })

    .when('/registrar/admin-student-club/view/:id', {

    templateUrl: 'angularjs/views/registrar/student-club/admin-view.ctp',

    controller: 'AdminStudentClubViewController',

  });
  
});