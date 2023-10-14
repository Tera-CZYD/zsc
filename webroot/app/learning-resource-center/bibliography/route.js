app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/bibliography', {

    templateUrl: 'angularjs/views/learning-resource-center/bibliography/index.ctp',

    controller: 'BibliographyController',

  })

  .when('/learning-resource-center/bibliography/add', {

<<<<<<< HEAD
    templateUrl: 'angularjs/views/learning-resource-center/bibliography/add.ctp', 
=======
    templateUrl: 'angularjs/views/learning-resource-center/bibliography/add.ctp',
>>>>>>> 1b969585cfe2ee7ab2d2bbbae7b1e7ced4c7a8dd

    controller: 'BibliographyAddController',

  })

  .when('/learning-resource-center/bibliography/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/bibliography/edit.ctp',

    controller: 'BibliographyEditController',

  })

  .when('/learning-resource-center/bibliography/view/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/bibliography/view.ctp',

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