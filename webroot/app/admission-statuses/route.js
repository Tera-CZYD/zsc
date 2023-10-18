app.config(function($routeProvider) {

  $routeProvider

  .when('/admission-statuses', {

    templateUrl: 'angularjs/views/admission-statuses/index.ctp',

    controller: 'AdmissionStatusController',

  })

  .when('/admission-statuses/add', {

    templateUrl: 'angularjs/views/admission-statuses/add.ctp',

    controller: 'AdmissionStatusAddController',

  })

    .when('/admission-statuses/edit/:id', {

    templateUrl: 'angularjs/views/admission-statuses/edit.ctp',

    controller: 'AdmissionStatusEditController',

  });
  
});