app.config(function($routeProvider) {

  $routeProvider

  .when('/enrollment', {

    templateUrl: tmp + 'enrollment__index',

    controller: 'EnrollmentController',

  })

  .when('/enrollment/add/:id', {

    templateUrl: tmp + 'enrollment__add',

    controller: 'EnrollmentAddController',

  });

});


