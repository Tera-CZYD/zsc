app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/counseling-intake', {

    templateUrl: 'angularjs/views/guidance/counseling-intake/index.ctp',

    controller: 'CounselingIntakeController',

  })

 .when('/guidance/counseling-intake/add', {

   templateUrl: 'angularjs/views/guidance/counseling-intake/add.ctp',

  controller: 'CounselingIntakeAddController',

 })

 .when('/guidance/counseling-intake/edit/:id', {

   templateUrl: 'angularjs/views/guidance/counseling-intake/edit.ctp',

   controller: 'CounselingIntakeEditController',

  })

 .when('/guidance/counseling-intake/view/:id', {

    templateUrl: 'angularjs/views/guidance/counseling-intake/view.ctp',

    controller: 'CounselingIntakeViewController',

  });

});

