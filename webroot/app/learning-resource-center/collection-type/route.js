app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/collection-type', {

    templateUrl: 'angularjs/views/learning-resource-center/collection-type/index.ctp',

    controller: 'CollectionTypeController',

  })

  .when('/learning-resource-center/collection-type/add', {

    templateUrl: 'angularjs/views/learning-resource-center/collection-type/add.ctp',

    controller: 'CollectionTypeAddController',

  })

  .when('/learning-resource-center/collection-type/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/collection-type/edit.ctp',

    controller: 'CollectionTypeEditController',

  });
  
});