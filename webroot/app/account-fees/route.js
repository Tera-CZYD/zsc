app.config(function($routeProvider) {

  $routeProvider

  .when('/account-fees', {

    templateUrl: tmp + 'account_fees__index',

    controller: 'AccountFeeController',

  })

 .when('/account-fees/add', {

   templateUrl: tmp + 'account_fees__add',

  controller: 'AccountFeeAddController',

 })

 .when('/account-fees/edit/:id', {

   templateUrl: tmp + 'account_fees__edit',

   controller: 'AccountFeeEditController',

  })

 .when('/account-fees/view/:id', {

    templateUrl: tmp + 'account_fees__view',

    controller: 'AccountFeeViewController',

  });

});


