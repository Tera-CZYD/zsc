app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/appointment-slip', {

    templateUrl: 'angularjs/views/guidance/appointment-slip/index.ctp',

    controller: 'AppointmentSlipController',

  })

  .when('/guidance/appointment-slip/add', {

    templateUrl: 'angularjs/views/guidance/appointment-slip/add.ctp',

    controller: 'AppointmentSlipAddController',

  })

  .when('/guidance/appointment-slip/edit/:id', {

    templateUrl: 'angularjs/views/guidance/appointment-slip/edit.ctp',

    controller: 'AppointmentSlipEditController',

  })

  .when('/guidance/appointment-slip/view/:id', {

    templateUrl: 'angularjs/views/guidance/appointment-slip/view.ctp',

    controller: 'AppointmentSlipViewController',

  });

});

