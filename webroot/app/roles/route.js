app.config(function($routeProvider) {

  $routeProvider

    .when('/roles', {

    templateUrl: 'angularjs/views/roles/index.ctp',

    controller: 'RoleController',

  })

  .when('/roles/add', {

    templateUrl: 'angularjs/views/roles/add.ctp',

    controller: 'RoleAddController',

  })

  .when('/roles/view/:id', {

    templateUrl: 'angularjs/views/roles/view.ctp',

    controller: 'RoleViewController',

  })

  .when('/roles/edit/:id', {

    templateUrl: 'angularjs/views/roles/edit.ctp',

    controller: 'RoleEditController',

  });

});


