app.config(function($routeProvider) {

  $routeProvider

  .when('/account-set', {

    templateUrl: tmp + 'account_set__index',

    controller: 'AccountSetController',

  })

 .when('/account-set/add', {

   templateUrl: tmp + 'account_set__add',

  controller: 'AccountSetAddController',

 })

 .when('/account-set/edit/:id', {

   templateUrl: tmp + 'account_set__edit',

   controller: 'AccountSetEditController',

  })

 .when('/account-set/view/:id', {

    templateUrl: tmp + 'account_set__view',

    controller: 'AccountSetViewController',

  });

});


