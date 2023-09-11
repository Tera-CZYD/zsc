app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/specialization', {

    templateUrl: 'angularjs/views/faculty/specialization/index.ctp',

    controller: 'SpecializationController',

  })

 .when('/faculty/specialization/add', {

   templateUrl: 'angularjs/views/faculty/specialization/add.ctp',

  controller: 'SpecializationAddController',

 })

 .when('/faculty/specialization/edit/:id', {

   templateUrl: 'angularjs/views/faculty/specialization/edit.ctp',

   controller: 'SpecializationEditController',

  })



 .when('/faculty/specialization/view/:id', {

    templateUrl: 'angularjs/views/faculty/specialization/view.ctp',

    controller: 'SpecializationViewController',

  });

});



