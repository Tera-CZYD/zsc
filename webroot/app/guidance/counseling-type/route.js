app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/counseling-type', {

    templateUrl: 'angularjs/views/guidance/counseling-type/index.ctp',

    controller: 'CounselingTypeController',

  })

  .when('/guidance/counseling-type/add', { 

    templateUrl: 'angularjs/views/guidance/counseling-type/add.ctp',

    controller: 'CounselingTypeAddController',

  })

    .when('/guidance/counseling-type/edit/:id', {

    templateUrl: 'angularjs/views/guidance/counseling-type/edit.ctp',

    controller: 'CounselingTypeEditController',

  });
  
});