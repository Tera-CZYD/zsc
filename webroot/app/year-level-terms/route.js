app.config(function($routeProvider) {

  $routeProvider

  .when('/year-level-terms', {

    templateUrl: 'angularjs/views/year-level-terms/index.ctp',

    controller: 'YearLevelTermController',

  })

  .when('/year-level-terms/add', {

    templateUrl: 'angularjs/views/year-level-terms/add.ctp',

    controller: 'YearLevelTermAddController',

  })

    .when('/year-level-terms/edit/:id', {

    templateUrl: 'angularjs/views/year-level-terms/edit.ctp',

    controller: 'YearLevelTermEditController',

  });
  
});