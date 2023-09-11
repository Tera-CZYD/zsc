app.config(function($routeProvider) {

  $routeProvider

  .when('/block-section', {

    templateUrl: 'angularjs/views/block-section/index.ctp',

    controller: 'BlockSectionController',

  })

  .when('/block-section/add', {

    templateUrl: 'angularjs/views/block-section/add.ctp',

    controller: 'BlockSectionAddController',

  })

  .when('/block-section/edit/:id', {

    templateUrl: 'angularjs/views/block-section/edit.ctp',

    controller: 'BlockSectionEditController',

  })

  .when('/block-section/view/:id', {

    templateUrl: 'angularjs/views/block-section/view.ctp',

    controller: 'BlockSectionViewController',

  })

  .when('/block-section/view-schedule/:id', {

    templateUrl: 'angularjs/views/block-section/view-schedule.ctp',

    controller: 'BlockSectionScheduleViewController',

  });
  
});