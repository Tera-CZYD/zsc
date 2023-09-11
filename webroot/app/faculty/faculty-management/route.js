app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/faculty-management', {

    templateUrl: 'angularjs/views/faculty/faculty-management/index.ctp',

    controller: 'FacultyController',

  })

 .when('/faculty/faculty-management/add', {

   templateUrl: 'angularjs/views/faculty/faculty-management/add.ctp',

  controller: 'FacultyAddController',

 })

 .when('/faculty/faculty-management/edit/:id', {

   templateUrl: 'angularjs/views/faculty/faculty-management/edit.ctp',

   controller: 'FacultyEditController',

  })

 .when('/faculty/faculty-management/view/:id', {

    templateUrl: 'angularjs/views/faculty/faculty-management/view.ctp',

    controller: 'FacultyViewController',

  });

});


