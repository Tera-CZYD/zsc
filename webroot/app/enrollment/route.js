app.config(function($routeProvider) {

  $routeProvider

  .when('/enrollment', {

    templateUrl: tmp + 'enrollment__index',

    templateUrl: 'angularjs/views/enrollment/index.ctp',

    controller: 'EnrollmentController',

  });

});


