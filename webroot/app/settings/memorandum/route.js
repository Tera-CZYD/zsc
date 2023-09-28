app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/memorandum', {

    templateUrl: 'angularjs/views/memorandum/index.ctp',

    controller: 'MemorandumController',

  })

  .when('/settings/memorandum/add', {

    templateUrl: 'angularjs/views/memorandum/add.ctp',

    controller: 'MemorandumAddController',

  })

  .when('/settings/memorandum/edit/:id', {

    templateUrl: 'angularjs/views/memorandum/edit.ctp',

    controller: 'MemorandumEditController',

  })

  .when('/settings/memorandum/view/:id', {

    templateUrl: 'angularjs/views/memorandum/view.ctp',

    controller: 'MemorandumViewController',

  });
  
});