app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/visitors-alumni', {

    templateUrl: 'angularjs/views/learning-resource-center/visitors-alumni/index.ctp',

    controller: 'VisitorsAlumniController',

  })

  .when('/learning-resource-center/visitors-alumni/add', {

    templateUrl: 'angularjs/views/learning-resource-center/visitors-alumni/add.ctp',

    controller: 'VisitorsAlumniAddController',

  })

  .when('/learning-resource-center/visitors-alumni/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/visitors-alumni/edit.ctp',

    controller: 'VisitorsAlumniEditController',

  });
  
});