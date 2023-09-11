app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/dental', {

    templateUrl: 'angularjs/views/medical-services/dental/index.ctp',

    controller: 'DentalController',

  })

  .when('/medical-services/dental/add', {

    templateUrl: 'angularjs/views/medical-services/dental/add.ctp',

    controller: 'DentalAddController',

  })

  .when('/medical-services/dental/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/dental/edit.ctp',

    controller: 'DentalEditController',

  })

  .when('/medical-services/dental/view/:id', {

    templateUrl: 'angularjs/views/medical-services/dental/view.ctp',

    controller: 'DentalViewController',

  })

  .when('/medical-services/dental/student-index', {

    templateUrl: 'angularjs/views/medical-services/dental/student-index.ctp',

    controller: 'StudentDentalController',

  })

  .when('/medical-services/dental/student-add', {

    templateUrl: 'angularjs/views/medical-services/dental/student-add.ctp',

    controller: 'StudentDentalAddController',

  })

  .when('/medical-services/dental/student-edit/:id', {

    templateUrl: 'angularjs/views/medical-services/dental/student-edit.ctp',

    controller: 'StudentDentalEditController',

  })

  .when('/medical-services/dental/student-view/:id', {

    templateUrl: 'angularjs/views/medical-services/dental/student-view.ctp',

    controller: 'StudentDentalViewController',

  });
  
});