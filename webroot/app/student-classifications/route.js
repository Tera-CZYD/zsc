app.config(function($routeProvider) {

  $routeProvider

  .when('/student-classifications', {

    templateUrl: 'angularjs/views/student-classifications/index.ctp',

    controller: 'StudentClassificationController',

  })

  .when('/student-classifications/add', {

    templateUrl: 'angularjs/views/student-classifications/add.ctp',

    controller: 'StudentClassificationAddController',

  })

    .when('/student-classifications/edit/:id', {

    templateUrl: 'angularjs/views/student-classifications/edit.ctp',

    controller: 'StudentClassificationEditController',

  });
  
});