app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/accounts', {

    templateUrl: 'angularjs/views/accounts/index.ctp',

    controller: 'AccountController',

  })

  .when('/settings/accounts/add', {

    templateUrl: 'angularjs/views/accounts/add.ctp',

    controller: 'AccountAddController',

  })

    .when('/settings/accounts/edit/:id', {

    templateUrl: 'angularjs/views/accounts/edit.ctp',

    controller: 'AccountEditController',

  });
  
});