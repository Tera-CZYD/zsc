app.config(function($routeProvider) {

  $routeProvider

  .when('/designation', {

    templateUrl: tmp + 'designation__index',

    controller: 'DesignationController',

  })

 .when('/designation/add', {

   templateUrl: tmp + 'designation__add',

  controller: 'DesignationAddController',

 })

 .when('/designation/edit/:id', {

   templateUrl: tmp + 'designation__edit',

   controller: 'DesignationEditController',

  })

 .when('/designation/view/:id', {

    templateUrl: tmp + 'designation__view',

    controller: 'DesignationViewController',

  });

});


