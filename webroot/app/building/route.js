app.config(function($routeProvider) {

  $routeProvider

  .when('/building', {

    templateUrl: 'angularjs/views/buildings/index.ctp',

    controller: 'BuildingController',

  })

  .when('/building/add', {

    templateUrl: 'angularjs/views/buildings/add.ctp',

    controller: 'BuildingAddController',

  })

  .when('/building/edit/:id', {

    templateUrl: 'angularjs/views/buildings/edit.ctp',

    controller: 'BuildingEditController',

  })

  .when('/building/view/:id', {

    templateUrl: 'angularjs/views/buildings/view.ctp',

    controller: 'BuildingViewController',

  });

});



