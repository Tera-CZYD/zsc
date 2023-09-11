app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/customer-satisfaction', {

    templateUrl: tmp + 'guidance__customer_satisfaction__index',

    controller: 'CustomerSatisfactionController',

  })

  .when('/guidance/customer-satisfaction/add', {

    templateUrl: tmp + 'guidance__customer_satisfaction__add',

    controller: 'CustomerSatisfactionAddController',

  })

  .when('/guidance/customer-satisfaction/edit/:id', {

    templateUrl: tmp + 'guidance__customer_satisfaction__edit',

    controller: 'CustomerSatisfactionEditController',

  })

  .when('/guidance/customer-satisfaction/view/:id', {

    templateUrl: tmp + 'guidance__customer_satisfaction__view',

    controller: 'CustomerSatisfactionViewController',

  });
  
});