app.config(function($routeProvider) {

  $routeProvider

  .when('/scholarship', {

    templateUrl: tmp + 'scholarship__index',

    controller: 'ScholarshipController',

  })

 .when('/scholarship/add', {

   templateUrl: tmp + 'scholarship__add',

  controller: 'ScholarshipAddController',

 })

 .when('/scholarship/edit/:id', {

   templateUrl: tmp + 'scholarship__edit',

   controller: 'ScholarshipEditController',

  })

 .when('/scholarship/view/:id', {

    templateUrl: tmp + 'scholarship__view',

    controller: 'ScholarshipViewController',

  });

});

