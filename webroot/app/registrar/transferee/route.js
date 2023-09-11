app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/transferee', {

    templateUrl: 'angularjs/views/registrar/transferee/index.ctp',

    controller: 'TransfereeController',

  })

  .when('/registrar/transferee/add', {

    templateUrl: 'angularjs/views/registrar/transferee/add.ctp',

    controller: 'TransfereeAddController',

  })

  .when('/registrar/transferee/edit/:id', {

    templateUrl: 'angularjs/views/registrar/transferee/edit.ctp',

    controller: 'TransfereeEditController',

  })

  .when('/registrar/transferee/view/:id', {

    templateUrl: 'angularjs/views/registrar/transferee/view.ctp',

    controller: 'TransfereeViewController',

  })

  .when('/registrar/admin-transferee', {

    templateUrl: 'angularjs/views/registrar/transferee/admin-index.ctp',

    controller: 'AdminTransfereeController',

  })

  .when('/registrar/admin-transferee/add', {

    templateUrl: 'angularjs/views/registrar/transferee/admin-add.ctp',

    controller: 'AdminTransfereeAddController',

  })

  .when('/registrar/admin-transferee/edit/:id', {

    templateUrl: 'angularjs/views/registrar/transferee/admin-edit.ctp',

    controller: 'AdminTransfereeEditController',

  })

  .when('/registrar/admin-transferee/view/:id', {

    templateUrl: 'angularjs/views/registrar/transferee/admin-view.ctp',

    controller: 'AdminTransfereeViewController',

  });
  
});