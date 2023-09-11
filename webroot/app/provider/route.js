app.config(function($routeProvider) {

  $routeProvider

  .when('/provider', {

    templateUrl: tmp + 'provider__index',

    controller: 'ProviderController',

  })

 .when('/provider/add', {

   templateUrl: tmp + 'provider__add',

  controller: 'ProviderAddController',

 })

 .when('/provider/edit/:id', {

   templateUrl: tmp + 'provider__edit',

   controller: 'ProviderEditController',

  })

 .when('/provider/view/:id', {

    templateUrl: tmp + 'provider__view',

    controller: 'ProviderViewController',

  });

});


