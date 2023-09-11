app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/check-in', {

    templateUrl: 'angularjs/views/learning-resource-center/check-in/index.ctp',

    controller: 'CheckInController',

  })

  .when('/learning-resource-center/check-in/add', {

    templateUrl: 'angularjs/views/learning-resource-center/check-in/add.ctp',

    controller: 'CheckInAddController',

  })

  .when('/learning-resource-center/check-in/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/check-in/edit.ctp',

    controller: 'CheckInEditController',

  })

  .when('/learning-resource-center/check-in/view/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/check-in/view.ctp',

    controller: 'CheckInViewController',

  });
  
});