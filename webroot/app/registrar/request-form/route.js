app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/request-form', {

    templateUrl: 'angularjs/views/registrar/request-form/index.ctp',

    controller: 'RequestFormController',

  })

  .when('/registrar/request-form/add', {

    templateUrl: 'angularjs/views/registrar/request-form/add.ctp',

    controller: 'RequestFormAddController',

  })

  .when('/registrar/request-form/edit/:id', {

    templateUrl: 'angularjs/views/registrar/request-form/edit.ctp',

    controller: 'RequestFormEditController',

  })

  .when('/registrar/request-form/view/:id', {

    templateUrl: 'angularjs/views/registrar/request-form/view.ctp',

    controller: 'RequestFormViewController',

  })

  .when('/registrar/admin-request-form', {

    templateUrl: 'angularjs/views/registrar/request-form/admin-index.ctp',

    controller: 'AdminRequestFormController',

  })

  .when('/registrar/admin-request-form/add', {

    templateUrl: 'angularjs/views/registrar/request-form/admin-add.ctp',

    controller: 'AdminRequestFormAddController',

  })

    .when('/registrar/admin-request-form/edit/:id', {

    templateUrl: 'angularjs/views/registrar/request-form/admin-edit.ctp',

    controller: 'AdminRequestFormEditController',

  })

    .when('/registrar/admin-request-form/view/:id', {

    templateUrl: 'angularjs/views/registrar/request-form/admin-view.ctp',

    controller: 'AdminRequestFormViewController',

  });
  
});