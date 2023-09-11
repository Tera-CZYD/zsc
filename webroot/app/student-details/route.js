app.config(function($routeProvider) {

  $routeProvider

  .when('/student-details', {

    templateUrl: tmp + 'student_details__index',

    controller: 'StudentDetailController',

  })

 .when('/student-details/add', {

   templateUrl: tmp + 'student_details__add',

  controller: 'StudentDetailAddController',

 })

 .when('/student-details/edit/:id', {

   templateUrl: tmp + 'student_details__edit',

   controller: 'StudentDetailEditController',

  })

 .when('/student-details/view/:id', {

    templateUrl: tmp + 'student_details__view',

    controller: 'StudentDetailViewController',

  });

});


