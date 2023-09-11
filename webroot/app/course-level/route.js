app.config(function($routeProvider) {

  $routeProvider

  .when('/course-level', {

    templateUrl: tmp + 'course_level__index',

    controller: 'CourseLevelController',

  })

 .when('/course-level/add', {

   templateUrl: tmp + 'course_level__add',

  controller: 'CourseLevelAddController',

 })

 .when('/course-level/edit/:id', {

   templateUrl: tmp + 'course_level__edit',

   controller: 'CourseLevelEditController',

  })

 .when('/course-level/view/:id', {

    templateUrl: tmp + 'course_level__view',

    controller: 'CourseLevelViewController',

  });

});


