app.config(function($routeProvider) {

  $routeProvider

  .when('/course', {

    templateUrl: 'angularjs/views/course/index.ctp',

    controller: 'CourseController',

  })

 .when('/course/add', { 

   templateUrl: 'angularjs/views/course/add.ctp',

  controller: 'CourseAddController',

 })

 .when('/course/edit/:id', {

   templateUrl: 'angularjs/views/course/edit.ctp',

   controller: 'CourseEditController',

  })

 .when('/course/view/:id', {

    templateUrl: 'angularjs/views/course/view.ctp',

    controller: 'CourseViewController',

  });

});


