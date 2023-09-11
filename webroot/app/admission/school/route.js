app.config(function($routeProvider) {

  $routeProvider

  .when('/admission/school', {

    templateUrl: 'angularjs/views/admission/school/index.ctp',

    controller: 'SchoolController',

  })

  .when('/admission/school/add', {

    templateUrl: 'angularjs/views/admission/school/add.ctp',

    controller: 'SchoolAddController',

  })

  .when('/admission/school/edit/:id', {

    templateUrl: 'angularjs/views/admission/school/edit.ctp',

    controller: 'SchoolEditController',

  })

  .when('/admission/school/view/:id', {

    templateUrl: 'angularjs/views/admission/school/view.ctp',

    controller: 'SchoolViewController',

  });
  
});