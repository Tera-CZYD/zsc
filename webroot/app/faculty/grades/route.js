app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/grades', {

    templateUrl: 'angularjs/views/faculty/grades/index.ctp',

    controller: 'GradeController',

  })

  .when('/faculty/grades/add', {

    templateUrl: 'angularjs/views/faculty/grades/add.ctp',

    controller: 'GradeAddController',

  })

  .when('/faculty/grades/edit/:id', {

    templateUrl: 'angularjs/views/faculty/grades/edit.ctp',

    controller: 'GradeEditController',

  })

 .when('/faculty/grades/view/:id', {

    templateUrl: 'angularjs/views/faculty/grades/view.ctp',

    controller: 'GradeViewController',

  });

});


