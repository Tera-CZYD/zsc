app.config(function($routeProvider) {

  $routeProvider

  .when('/course-schedule/:id', {

   templateUrl: tmp + 'course_schedule__index',

   controller: 'CourseScheduleController',

  })

 .when('/course-schedule/add/:id', {

   templateUrl: tmp + 'course_schedule__add',

  controller: 'CourseScheduleAddController',

 })

 .when('/course-schedule/add-faculty/:id', {

   templateUrl: tmp + 'course_schedule__add_faculty',

  controller: 'CourseScheduleAddFacultyController',

 })

 .when('/course-schedule/edit-faculty/:faculty_id/:id', {

   templateUrl: tmp + 'course_schedule__edit_faculty',

   controller: 'CourseScheduleEditFacultyController',

  })

 .when('/course-schedule/view-faculty/:faculty_id/:id', {

    templateUrl: tmp + 'course_schedule__view_faculty',

    controller: 'CourseScheduleViewFacultyController',

  })

 .when('/course-schedule/edit/:curriculum_id/:id', {

   templateUrl: tmp + 'course_schedule__edit',

   controller: 'CourseScheduleEditController',

  })

 .when('/course-schedule/view/:curriculum_id/:id', {

    templateUrl: tmp + 'course_schedule__view',

    controller: 'CourseScheduleViewController',

  });

});

