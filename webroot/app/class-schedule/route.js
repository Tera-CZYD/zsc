app.config(function($routeProvider) {

  $routeProvider

  .when('/class-schedule', {

    templateUrl: 'angularjs/views/class-schedule/index.ctp',

    controller: 'ClassScheduleController',

  })

 .when('/class-schedule/add', {

   templateUrl: 'angularjs/views/class-schedule/add.ctp',

  controller: 'ClassScheduleAddController',

 })

 .when('/class-schedule/edit/:id', {

   templateUrl: 'angularjs/views/class-schedule/edit.ctp',

   controller: 'ClassScheduleEditController',

  })

 .when('/class-schedule/view/:id', {

    templateUrl: 'angularjs/views/class-schedule/view.ctp',

    controller: 'ClassScheduleViewController',

  });

});


