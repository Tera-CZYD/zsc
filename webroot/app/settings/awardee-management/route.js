app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/awardee-management', {

    templateUrl: 'angularjs/views/awardee-management/index.ctp',

    controller: 'AwardeeManagementController',

  })

  .when('/settings/awardee-management/add', {

    templateUrl: 'angularjs/views/awardee-management/add.ctp',

    controller: 'AwardeeManagementAddController',

  })

    .when('/settings/awardee-management/edit/:id', {

    templateUrl: 'angularjs/views/awardee-management/edit.ctp',

    controller: 'AwardeeManagementEditController',

  })
  .when('/settings/awardee-management/view/:id', {

    templateUrl: 'angularjs/views/awardee-management/view.ctp',

    controller: 'AwardeeManagementViewController',

  });
  
});