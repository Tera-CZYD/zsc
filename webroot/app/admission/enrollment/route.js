app.config(function($routeProvider) {

  $routeProvider

  .when('/admission/enrollment', {

    templateUrl: tmp + 'admission__enrollment__index',

    controller: 'AdminEnrollmentController',

  })

  .when('/admission/enrollment/add/:id/:student', {

    templateUrl: tmp + 'admission__enrollment__add',

    controller: 'AdminEnrollmentAddController',

  });

});


