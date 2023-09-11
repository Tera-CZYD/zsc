app.config(function($routeProvider) {

  $routeProvider

  .when('/program-term', {

    templateUrl: tmp + 'program_term__index',

    controller: 'ProgramTermController',

  })

 .when('/program-term/add', {

   templateUrl: tmp + 'program_term__add',

  controller: 'ProgramTermAddController',

 })

 .when('/program-term/edit/:id', {

   templateUrl: tmp + 'program_term__edit',

   controller: 'ProgramTermEditController',

  })

 .when('/program-term/view/:id', {

    templateUrl: tmp + 'program_term__view',

    controller: 'ProgramTermViewController',

  });

});


