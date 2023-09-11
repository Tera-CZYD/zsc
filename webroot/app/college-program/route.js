app.config(function($routeProvider) {

  $routeProvider

  .when('/college-program', {

    templateUrl: 'angularjs/views/college-program/index.ctp',

    controller: 'CollegeProgramController',

  })

  .when('/college-program/add', {

    templateUrl: 'angularjs/views/college-program/add.ctp',

    controller: 'CollegeProgramAddController',

  })

  .when('/college-program/edit/:id', {

   templateUrl: 'angularjs/views/college-program/edit.ctp',

   controller: 'CollegeProgramEditController',

  })

  .when('/college-program/view/:id', {

    templateUrl: 'angularjs/views/college-program/view.ctp',

    controller: 'CollegeProgramViewController',

  })

  .when('/college-program/add-course/:id', {

    templateUrl: 'angularjs/views/college-program/add-course.ctp',

    controller: 'CollegeProgramAddCourseController',

  })

  .when('/college-program/view-course/:id', {

    templateUrl: 'angularjs/views/college-program/view-course.ctp',

    controller: 'CollegeProgramViewCourseController',

  })

  .when('/college-program/edit-course/:id', {

    templateUrl: 'angularjs/views/college-program/edit-course.ctp',

    controller: 'CollegeProgramEditCourseController',

  });

});


