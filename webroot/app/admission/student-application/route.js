app.config(function($routeProvider) {

  $routeProvider

  .when('/admission/student-application', {

    templateUrl: 'angularjs/views/admission/student-application/index.ctp',

    controller: 'StudentApplicationController',

  })

  .when('/admission/student-application/add', {

    templateUrl: 'angularjs/views/admission/student-application/add.ctp',

    controller: 'StudentApplicationAddController',

  })

  .when('/admission/student-application/edit/:id', {

    templateUrl: 'angularjs/views/admission/student-application/edit.ctp',

    controller: 'StudentApplicationEditController',

  })

  .when('/admission/student-application/view/:id', {

    templateUrl: 'angularjs/views/admission/student-application/view.ctp',

    controller: 'StudentApplicationViewController',

  });
  
});