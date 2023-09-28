app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/announcement', {

    templateUrl: 'angularjs/views/announcement/index.ctp',

    controller: 'AnnouncementController',

  })

  .when('/settings/announcement/add', {

    templateUrl: 'angularjs/views/announcement/add.ctp',

    controller: 'AnnouncementAddController',

  })

  .when('/settings/announcement/edit/:id', {

    templateUrl: 'angularjs/views/announcement/edit.ctp',

    controller: 'AnnouncementEditController',

  })

  .when('/settings/announcement/view/:id', {

    templateUrl: 'angularjs/views/announcement/view.ctp',

    controller: 'AnnouncementViewController',

  });
  
});