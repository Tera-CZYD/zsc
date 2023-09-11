app.config(function($routeProvider) {

  $routeProvider

  .when('/table-of-fees', {

    templateUrl: tmp + 'table_of_fees__index',

    controller: 'TableOfFeeController',

  })

 .when('/table-of-fees/add', {

   templateUrl: tmp + 'table_of_fees__add',

  controller: 'TableOfFeeAddController',

 })

 .when('/table-of-fees/edit/:id', {

   templateUrl: tmp + 'table_of_fees__edit',

   controller: 'TableOfFeeEditController',

  })

 .when('/table-of-fees/view/:id', {

    templateUrl: tmp + 'table_of_fees__view',

    controller: 'TableOfFeeViewController',

  });

});


