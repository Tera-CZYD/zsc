app.config(function($routeProvider) {

  $routeProvider

  .when('/category', {

    templateUrl: tmp + 'category__index',

    controller: 'CategoryController',

  })

 .when('/category/add', {

   templateUrl: tmp + 'category__add',

  controller: 'CategoryAddController',

 })

 .when('/category/edit/:id', {

   templateUrl: tmp + 'category__edit',

   controller: 'CategoryEditController',

  })

 .when('/category/view/:id', {

    templateUrl: tmp + 'category__view',


    controller: 'CategoryViewController',

  });

});

