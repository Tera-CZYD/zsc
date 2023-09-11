app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/bibliography', {

    templateUrl: tmp + 'learning_resource_center__bibliography__index',

    controller: 'BibliographyController',

  })

  .when('/learning-resource-center/bibliography/add', {

    templateUrl: tmp + 'learning_resource_center__bibliography__add',

    controller: 'BibliographyAddController',

  })

  .when('/learning-resource-center/bibliography/edit/:id', {

    templateUrl: tmp + 'learning_resource_center__bibliography__edit',

    controller: 'BibliographyEditController',

  })

  .when('/learning-resource-center/bibliography/view/:id', {

    templateUrl: tmp + 'learning_resource_center__bibliography__view',

    controller: 'BibliographyViewController',

  })

  .when('/learning-resource-center/admin-bibliography', {

    templateUrl: 'angularjs/views/learning-resource-center/bibliography/admin-index.ctp',

    controller: 'AdminBibliographyController',

  })

  .when('/learning-resource-center/admin-bibliography/add', {

    templateUrl: 'angularjs/views/learning-resource-center/bibliography/admin-add.ctp',

    controller: 'AdminBibliographyAddController',

  })

  .when('/learning-resource-center/admin-bibliography/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/bibliography/admin-edit.ctp',

    controller: 'AdminBibliographyEditController',

  })

  .when('/learning-resource-center/admin-bibliography/view/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/bibliography/admin-view.ctp',

    controller: 'AdminBibliographyViewController',

  });
  
});