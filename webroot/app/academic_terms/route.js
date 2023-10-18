app.config(function($routeProvider) {

  $routeProvider

  .when('/academic-terms', {

    templateUrl: 'angularjs/views/academic_terms/index.ctp',

    controller: 'AcademicTermController',

  })

  .when('/academic-terms/add', {

    templateUrl: 'angularjs/views/academic_terms/add.ctp',

    controller: 'AcademicTermAddController',

  })

    .when('/academic-terms/edit/:id', {

    templateUrl: 'angularjs/views/academic_terms/edit.ctp',

    controller: 'AcademicTermEditController',

  });
  
});