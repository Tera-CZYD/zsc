app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/good-moral', {

    templateUrl: 'angularjs/views/guidance/good-moral/index.ctp',

    controller: 'GoodMoralController',

  })

  .when('/guidance/good-moral/add', {

    templateUrl: 'angularjs/views/guidance/good-moral/add.ctp',

    controller: 'GoodMoralAddController',

  })

  .when('/guidance/good-moral/edit/:id', {

    templateUrl: 'angularjs/views/guidance/good-moral/edit.ctp',

    controller: 'GoodMoralEditController',

  })

  .when('/guidance/good-moral/view/:id', {

    templateUrl: 'angularjs/views/guidance/good-moral/view.ctp',

    controller: 'GoodMoralViewController',

  });
  
});