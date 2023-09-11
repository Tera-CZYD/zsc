app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/student-behavior', {

    templateUrl: 'angularjs/views/guidance/student-behavior/index.ctp',

    controller: 'StudentBehaviorController',

  })

   .when('/guidance/student-behavior/add', {

    templateUrl: 'angularjs/views/guidance/student-behavior/add.ctp',

    controller: 'StudentBehaviorAddController',

  })

  .when('/guidance/student-behavior/edit/:id', {

    templateUrl: 'angularjs/views/guidance/student-behavior/edit.ctp',

    controller: 'StudentBehaviorEditController',

  })

  .when('/guidance/student-behavior/view/:id', {

    templateUrl: 'angularjs/views/guidance/student-behavior/view.ctp',

    controller: 'StudentBehaviorViewController',

  })

});