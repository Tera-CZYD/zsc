app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/check-out', {

    templateUrl: 'angularjs/views/learning-resource-center/check-out/index.ctp',

    controller: 'CheckOutController',

  })

  .when('/learning-resource-center/check-out/add', {

    templateUrl: 'angularjs/views/learning-resource-center/check-out/add.ctp',

    controller: 'CheckOutAddController',

  })

  .when('/learning-resource-center/check-out/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/check-out/edit.ctp',

    controller: 'CheckOutEditController',

  })

  .when('/learning-resource-center/check-out/view/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/check-out/view.ctp',

    controller: 'CheckOutViewController',

  });
  
});