app.config(function($routeProvider) {

  $routeProvider

  .when('/academic-term', {

    templateUrl: tmp + 'academic_term__index',

    controller: 'AcademicTermController',

  })

 .when('/academic-term/add', {

   templateUrl: tmp + 'academic_term__add',

  controller: 'AcademicTermAddController',

 })

 .when('/academic-term/edit/:id', {

   templateUrl: tmp + 'academic_term__edit',

   controller: 'AcademicTermEditController',

  })

 .when('/academic-term/view/:id', {

    templateUrl: tmp + 'academic_term__view',

    controller: 'AcademicTermViewController',

  });

});


