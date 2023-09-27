app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/announcement-management', {

    templateUrl: 'angularjs/views/announcement-management/index.ctp',

    controller: 'AnnouncementManagementController',

  })

  .when('/settings/announcement-management/add', {

    templateUrl: 'angularjs/views/announcement-management/add.ctp',

    controller: 'AnnouncementManagementAddController',

  })

    .when('/settings/announcement-management/edit/:id', {

    templateUrl: 'angularjs/views/announcement-management/edit.ctp',

    controller: 'AnnouncementManagementEditController',

  });
  
});