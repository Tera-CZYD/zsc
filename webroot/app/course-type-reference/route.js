app.config(function($routeProvider) {

  $routeProvider

  .when('/course-type-reference', {

    templateUrl: tmp + 'course_type_reference__index',

    controller: 'CourseTypeReferenceController',

  })

 .when('/course-type-reference/add', {

   templateUrl: tmp + 'course_type_reference__add',

  controller: 'CourseTypeReferenceAddController',

 })

 .when('/course-type-reference/edit/:id', {

   templateUrl: tmp + 'course_type_reference__edit',

   controller: 'CourseTypeReferenceEditController',

  })

 .when('/course-type-reference/view/:id', {

    templateUrl: tmp + 'course_type_reference__view',

    controller: 'CourseTypeReferenceViewController',

  });

});


