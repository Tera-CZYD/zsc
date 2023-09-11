app.config(function($routeProvider) {

  $routeProvider

  .when('/account-category', {

    templateUrl: tmp + 'account_category__index',

    controller: 'AccountCategoryController',

  })

 .when('/account-category/add', {

   templateUrl: tmp + 'account_category__add',

  controller: 'AccountCategoryAddController',

 })

 .when('/account-category/edit/:id', {

   templateUrl: tmp + 'account_category__edit',

   controller: 'AccountCategoryEditController',

  })

 .when('/account-category/view/:id', {

    templateUrl: tmp + 'account_category__view',

    controller: 'AccountCategoryViewController',

  });

});


