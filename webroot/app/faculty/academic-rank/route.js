app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/academic-rank', {

    templateUrl: 'angularjs/views/faculty/academic-rank/index.ctp',

    controller: 'AcademicRankController',

  })

 .when('/faculty/academic-rank/add', {

   templateUrl: 'angularjs/views/faculty/academic-rank/add.ctp',

  controller: 'AcademicRankAddController',

 })

 .when('/faculty/academic-rank/edit/:id', {

   templateUrl: 'angularjs/views/faculty/academic-rank/edit.ctp',

   controller: 'AcademicRankEditController',

  })



 .when('/faculty/academic-rank/view/:id', {

    templateUrl: 'angularjs/views/faculty/academic-rank/view.ctp',

    controller: 'AcademicRankViewController',

  });

});



