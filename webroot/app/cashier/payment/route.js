app.config(function($routeProvider) {

  $routeProvider

  .when('/cashier/payment', {

    templateUrl: 'angularjs/views/cashier/payment/index.ctp',

    controller: 'PaymentController',

  })

  .when("/cashier/payment/add/", {
 
    templateUrl: 'angularjs/views/cashier/payment/add.ctp',
 
    controller: "PaymentAddController",
 
  })

  .when("/cashier/payment/view/:id", {
 
    templateUrl: 'angularjs/views/cashier/payment/view.ctp',
 
    controller: "PaymentViewController",
 
  })

  .when("/cashier/payment/edit/:id", {
 
    templateUrl: 'angularjs/views/cashier/payment/edit.ctp',
 
    controller: "PaymentEditController",
 
  });
  
});