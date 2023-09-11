app.config(function($routeProvider) {

  $routeProvider

  .when('/course-mode', {

    templateUrl: tmp + 'course_mode__index',

    controller: 'CourseModeController',

  })

 .when('/course-mode/add', {

   templateUrl: tmp + 'course_mode__add',

  controller: 'CourseModeAddController',

 })

 .when('/course-mode/edit/:id', {

   templateUrl: tmp + 'course_mode__edit',

   controller: 'CourseModeEditController',

  })

 .when('/course-mode/view/:id', {

    templateUrl: tmp + 'course_mode__view',

    controller: 'CourseModeViewController',

  });

});


