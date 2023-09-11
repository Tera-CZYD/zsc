app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/award-management', {

    templateUrl: tmp + 'faculty__award_management__index',

    controller: 'AwardManagementController',

  })

  .when('/faculty/award-management/add', {

    templateUrl: tmp + 'faculty__award_management__add',

    controller: 'AwardManagementAddController',

  })

    .when('/faculty/award-management/edit/:id', {

    templateUrl: tmp + 'faculty__award_management__edit',

    controller: 'AwardManagementEditController',

  });
  
});