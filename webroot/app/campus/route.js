app.config(function($routeProvider) {

  $routeProvider

  .when('/campus', {

    templateUrl: tmp + 'campus__index',

    controller: 'CampusController',

  })

 .when('/campus/add', {

   templateUrl: tmp + 'campus__add',

  controller: 'CampusAddController',

 })

 .when('/campus/edit/:id', {

   templateUrl: tmp + 'campus__edit',

   controller: 'CampusEditController',

  })

 .when('/campus/view/:id', {

    templateUrl: tmp + 'campus__view',

    controller: 'CampusViewController',

  });

});


