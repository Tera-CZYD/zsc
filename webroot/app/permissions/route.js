app.config(function($routeProvider) {

  $routeProvider

  .when('/permissions', {

    templateUrl: 'angularjs/views/permissions/index.ctp',

    controller: 'PermissionsController',

  })

  .when('/permissions/add', {

    templateUrl: 'angularjs/views/permissions/add.ctp',

    controller: 'PermissionsAddController',

  })

  .when('/permissions/edit/:id', {

    templateUrl: 'angularjs/views/permissions/edit.ctp',

    controller: 'PermissionsEditController',

  })

  // .when('/permissions/view/:id', {

  //   templateUrl: 'angularjs/views/permissions/view.ctp',

  //   controller: 'PermissionsViewController',

  // })

  ;



});