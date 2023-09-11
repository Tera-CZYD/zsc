app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/counseling-appointment', {

    templateUrl:'angularjs/views/guidance/counseling-appointment/index.ctp',

    controller: 'CounselingAppointmentController',

  })

  .when('/guidance/counseling-appointment/add', {

    templateUrl: 'angularjs/views/guidance/counseling-appointment/add.ctp',

    controller: 'CounselingAppointmentAddController',

  })

    .when('/guidance/counseling-appointment/edit/:id', {

    templateUrl: 'angularjs/views/guidance/counseling-appointment/edit.ctp',

    controller: 'CounselingAppointmentEditController',

  })

    .when('/guidance/counseling-appointment/view/:id', {

    templateUrl: 'angularjs/views/guidance/counseling-appointment/view.ctp',

    controller: 'CounselingAppointmentViewController',

  })

  .when('/guidance/admin-counseling-appointment', {

    templateUrl: 'angularjs/views/guidance/counseling-appointment/admin-index.ctp',

    controller: 'AdminCounselingAppointmentController',

  })

  .when('/guidance/admin-counseling-appointment/add', {

    templateUrl: 'angularjs/views/guidance/counseling-appointment/admin-add.ctp',

    controller: 'AdminCounselingAppointmentAddController',

  })

    .when('/guidance/admin-counseling-appointment/edit/:id', {

    templateUrl: 'angularjs/views/guidance/counseling-appointment/admin-edit.ctp',

    controller: 'AdminCounselingAppointmentEditController',

  })

    .when('/guidance/admin-counseling-appointment/view/:id', {

    templateUrl: 'angularjs/views/guidance/counseling-appointment/admin-view.ctp',

    controller: 'AdminCounselingAppointmentViewController',

  });
  
});