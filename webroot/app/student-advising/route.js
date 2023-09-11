app.config(function($routeProvider) {

  $routeProvider

  .when('/student-advising', {

    templateUrl: tmp + 'student_advising__index',

    controller: 'StudentAdvisingController',

  })

 .when('/student-advising/add', {

   templateUrl: tmp + 'student_advising__add',

  controller: 'StudentAdvisingAddController',

 })

 .when('/student-advising/edit/:id', {

   templateUrl: tmp + 'student_advising__edit',

   controller: 'StudentAdvisingEditController',

  })

 .when('/student-advising/view/:id', {

    templateUrl: tmp + 'student_advising__view',

    controller: 'StudentAdvisingViewController',

  });

});

