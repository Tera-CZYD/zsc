app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/material-type', {

    templateUrl: 'angularjs/views/learning-resource-center/material-type/index.ctp',

    controller: 'MaterialTypeController',

  })

  .when('/learning-resource-center/material-type/add', {

    templateUrl: 'angularjs/views/learning-resource-center/material-type/add.ctp',

    controller: 'MaterialTypeAddController',

  })

    .when('/learning-resource-center/material-type/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/material-type/edit.ctp',

    controller: 'MaterialTypeEditController',

  });
  
});