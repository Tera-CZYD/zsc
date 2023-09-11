app.config(function($routeProvider) {

  $routeProvider

  .when('/curriculum', {

    templateUrl: tmp + 'curriculum__index',

    controller: 'CurriculumController',

  })

 .when('/curriculum/add', {

   templateUrl: tmp + 'curriculum__add',

  controller: 'CurriculumAddController',

 })

 .when('/curriculum/edit/:id', {

   templateUrl: tmp + 'curriculum__edit',

   controller: 'CurriculumEditController',

  })

 .when('/curriculum/add-course/:id', {

   templateUrl: tmp + 'curriculum__add_course',

   controller: 'CurriculumAddCourseController',

  })

 .when('/curriculum/view-course/:id', {

    templateUrl: tmp + 'curriculum__view_course',

    controller: 'CurriculumViewCourseController',

  })

  .when('/curriculum/edit-course/:id', {

    templateUrl: tmp + 'curriculum__edit_course',

    controller: 'CurriculumEditCourseController',

  })

  .when('/curriculum/year-term-load/:id', {

    templateUrl: tmp + 'curriculum__year_term_load',

    controller: 'CurriculumYearTermLoadController',

  })

  .when('/curriculum/view/:id', {

    templateUrl: tmp + 'curriculum__view',

    controller: 'CurriculumViewController',

  });

});


