app.config(function($routeProvider) {

  $routeProvider

  .when('/program-major', {

    templateUrl: tmp + 'program_major__index',

    controller: 'ProgramMajorController',

  })

 .when('/program-major/add', {

   templateUrl: tmp + 'program_major__add',

  controller: 'ProgramMajorAddController',

 })

 .when('/program-major/edit/:id', {

   templateUrl: tmp + 'program_major__edit',

   controller: 'ProgramMajorEditController',

  })

 .when('/program-major/view/:id', {

    templateUrl: tmp + 'program_major__view',

    controller: 'ProgramMajorViewController',

  });

});


