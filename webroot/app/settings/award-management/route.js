app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/award-management', {

    templateUrl: 'angularjs/views/award-management/index.ctp',

    controller: 'AwardManagementController',

  })

  .when('/settings/award-management/add', {

    templateUrl: 'angularjs/views/award-management/add.ctp',

    controller: 'AwardManagementAddController',

  })

    .when('/settings/award-management/edit/:id', {

    templateUrl: 'angularjs/views/award-management/edit.ctp',

    controller: 'AwardManagementEditController',

  });
  
});