app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/inventory-bibliography', {

    templateUrl: 'angularjs/views/learning-resource-center/inventory-bibliography/index.ctp',

    controller: 'InventoryBibliographyController',

  })

  .when('/learning-resource-center/inventory-bibliography/view/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/inventory-bibliography/view.ctp',

    controller: 'InventoryBibliographyViewController',

  });
  
});