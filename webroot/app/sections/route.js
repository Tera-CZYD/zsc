app.config(function($routeProvider) {

  $routeProvider

  .when('/sections', {

    templateUrl: 'angularjs/views/sections/index.ctp',

    controller: 'SectionController',

  })

  .when('/sections/add', {

    templateUrl: 'angularjs/views/sections/add.ctp',

    controller: 'SectionAddController',

  })

    .when('/sections/edit/:id', {

    templateUrl: 'angularjs/views/sections/edit.ctp',

    controller: 'SectionEditController',

  });
  
});