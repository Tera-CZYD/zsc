app.config(function($routeProvider) {

  $routeProvider

  .when('/users', {

    templateUrl: 'angularjs/views/users/index.ctp',

    controller: 'UsersController',

  })

  .when('/users/add', {

    templateUrl: 'angularjs/views/users/add.ctp',

    controller: 'UsersAddController',

  })

  .when('/users/edit/:id', {

    templateUrl: 'angularjs/views/users/edit.ctp',

    controller: 'UsersEditController',

  })

  .when('/users/view/:id', {

    templateUrl: 'angularjs/views/users/view.ctp',

    controller: 'UsersViewController',

  });

});