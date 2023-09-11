

app.config(function($routeProvider) {

  $routeProvider
  .when('/registrar/adding-dropping-subject', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/index.ctp',

    controller: 'AddingDroppingSubjectController',

  })

  .when('/registrar/adding-dropping-subject/add', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/add.ctp',

    controller: 'AddingDroppingSubjectAddController',

  })

  .when('/registrar/adding-dropping-subject/edit/:id', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/edit.ctp',

    controller: 'AddingDroppingSubjectEditController',

  })

  .when('/registrar/adding-dropping-subject/view/:id', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/view.ctp',

    controller: 'AddingDroppingSubjectViewController',

  })


  .when('/registrar/admin-adding-dropping-subject', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/admin-index.ctp',

    controller: 'AdminAddingDroppingSubjectController',

  })

  .when('/registrar/admin-adding-dropping-subject/add', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/admin-add.ctp',

    controller: 'AdminAddingDroppingSubjectAddController',

  })

  .when('/registrar/admin-adding-dropping-subject/edit/:id', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/admin-edit.ctp',

    controller: 'AdminAddingDroppingSubjectEditController',

  })

  .when('/registrar/admin-adding-dropping-subject/view/:id', {

    templateUrl: 'angularjs/views/registrar/adding-dropping-subject/admin-view.ctp',

    controller: 'AdminAddingDroppingSubjectViewController'

  });

  

  
});