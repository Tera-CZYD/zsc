app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/appointment-slip', {

    templateUrl: 'angularjs/views/faculty/appointment-slip/index.ctp',

    controller: 'AppointmentSlipController',

  })

  .when('/faculty/appointment-slip/add', {

    templateUrl: 'angularjs/views/faculty/appointment-slip/add.ctp',

    controller: 'AppointmentSlipAddController',

  })

  .when('/faculty/appointment-slip/edit/:id', {

    templateUrl: 'angularjs/views/faculty/appointment-slip/edit.ctp',

    controller: 'AppointmentSlipEditController',

  })

  .when('/faculty/appointment-slip/view/:id', {

    templateUrl: 'angularjs/views/faculty/appointment-slip/view.ctp',

    controller: 'AppointmentSlipViewController',

  });

});

