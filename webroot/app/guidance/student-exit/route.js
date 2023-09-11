app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/student-exit', {

    templateUrl: 'angularjs/views/guidance/student-exit/index.ctp',

    controller: 'StudentExitController',

  })

  .when('/guidance/student-exit/add', {

    templateUrl: 'angularjs/views/guidance/student-exit/add.ctp',

    controller: 'StudentExitAddController',

  })

  .when('/guidance/student-exit/edit/:id', {

    templateUrl: 'angularjs/views/guidance/student-exit/edit.ctp',

    controller: 'StudentExitEditController',

  })

  .when('/guidance/student-exit/view/:id', {

    templateUrl: 'angularjs/views/guidance/student-exit/view.ctp',

    controller: 'StudentExitViewController',

  });
  
});