app.config(function($routeProvider) {

  $routeProvider

  .when('/account-classification', {

    templateUrl: tmp + 'account_classification__index',

    controller: 'AccountClassificationController',

  })

 .when('/account-classification/add', {

   templateUrl: tmp + 'account_classification__add',

  controller: 'AccountClassificationAddController',

 })

 .when('/account-classification/edit/:id', {

   templateUrl: tmp + 'account_classification__edit',

   controller: 'AccountClassificationEditController',

  })

 .when('/account-classification/view/:id', {

    templateUrl: tmp + 'account_classification__view',

    controller: 'AccountClassificationViewController',

  });

});


