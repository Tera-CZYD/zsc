app.config(function($routeProvider) {

  $routeProvider

  .when('/corporate-affairs/apartelle', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle/index.ctp',

    controller: 'ApartelleController',

  })

  .when('/corporate-affairs/apartelle/add', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle/add.ctp',

    controller: 'ApartelleAddController',

  })

  .when('/corporate-affairs/apartelle/edit/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle/edit.ctp',

    controller: 'ApartelleEditController',

  })

  .when('/corporate-affairs/apartelle/view/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle/view.ctp',

    controller: 'ApartelleViewController',

  });
  
});