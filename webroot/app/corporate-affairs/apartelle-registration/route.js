  app.config(function($routeProvider) {

  $routeProvider

  .when('/corporate-affairs/apartelle-registration', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/index.ctp',

    controller: 'ApartelleRegistrationController',

  })

  .when('/corporate-affairs/apartelle-registration/add', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/add.ctp',

    controller: 'ApartelleRegistrationAddController',

  })

  .when('/corporate-affairs/apartelle-registration/edit/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/edit.ctp',

    controller: 'ApartelleRegistrationEditController',

  })

  .when('/corporate-affairs/apartelle-registration/view/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/view.ctp',

    controller: 'ApartelleRegistrationViewController',

  })





  .when('/corporate-affairs/admin-apartelle-registration', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/admin-index.ctp',

    controller: 'AdminApartelleRegistrationController',

  })


  .when('/corporate-affairs/admin-apartelle-registration/add', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/admin-add.ctp',

    controller: 'AdminApartelleRegistrationAddController',

  })


  .when('/corporate-affairs/admin-apartelle-registration/edit/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/admin-edit.ctp',

    controller: 'AdminApartelleRegistrationEditController',

  })

  .when('/corporate-affairs/admin-apartelle-registration/view/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-registration/admin-view.ctp',

    controller: 'AdminApartelleRegistrationViewController',

  })
  
});