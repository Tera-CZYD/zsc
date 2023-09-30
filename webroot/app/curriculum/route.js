app.config(function($routeProvider) {

  $routeProvider

  .when('/curriculum/curriculums', {

    templateUrl: 'angularjs/views/curriculum/index.ctp',

    controller: 'CurriculumController',

  })

 .when('/curriculum/curriculums/add', {

   templateUrl: 'angularjs/views/curriculum/add.ctp',

  controller: 'CurriculumAddController',

 })

 .when('/curriculum/curriculums/edit/:id', {

   templateUrl: 'angularjs/views/curriculum/edit.ctp',

   controller: 'CurriculumEditController',

  })

  .when('/curriculum/curriculums/view/:id', {

    templateUrl: 'angularjs/views/curriculum/view.ctp',

    controller: 'CurriculumViewController',

  });

});


