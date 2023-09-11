app.config(function($routeProvider) {

  $routeProvider

  .when('/degree', {

    templateUrl: tmp + 'degree__index',

    controller: 'DegreeController',

  })

 .when('/degree/add', {

   templateUrl: tmp + 'degree__add',

  controller: 'DegreeAddController',

 })

 .when('/degree/edit/:id', {

   templateUrl: tmp + 'degree__edit',

   controller: 'DegreeEditController',

  })

 .when('/degree/view/:id', {

    templateUrl: tmp + 'degree__view',

    controller: 'DegreeViewController',

  });

});


