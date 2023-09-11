app.config(function($routeProvider) {

  $routeProvider

  .when('/year-level-term', {

    templateUrl: tmp + 'year_level_term__index',

    controller: 'YearLevelTermController',

  })

 .when('/year-level-term/add', {

   templateUrl: tmp + 'year_level_term__add',

  controller: 'YearLevelTermAddController',

 })

 .when('/year-level-term/edit/:id', {

   templateUrl: tmp + 'year_level_term__edit',

   controller: 'YearLevelTermEditController',

  })

 .when('/year-level-term/view/:id', {

    templateUrl: tmp + 'year_level_term__view',

    controller: 'YearLevelTermViewController',

  });

});


