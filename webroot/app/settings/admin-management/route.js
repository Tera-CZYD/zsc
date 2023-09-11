app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/admin-management', {

    templateUrl: 'angularjs/views/admin-management/index.ctp',

    controller: 'AdminManagementController',

  })

  .when('/settings/admin-management/add', {

    templateUrl: 'angularjs/views/admin-management/add.ctp',

    controller: 'AdminManagementAddController',

  })

  .when('/settings/admin-management/view/:id', {

    templateUrl: 'angularjs/views/admin-management/view.ctp',

    controller: 'AdminManagementViewController',

  })

  .when('/settings/admin-management/edit/:id', {

    templateUrl: 'angularjs/views/admin-management/edit.ctp',

    controller: 'AdminManagementEditController',

  });
  
});