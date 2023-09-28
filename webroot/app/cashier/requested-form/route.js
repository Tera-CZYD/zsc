app.config(function($routeProvider) {

  $routeProvider

  .when('/cashier/requested-form-payment', {

    templateUrl: 'angularjs/views/cashier/requested-form/index.ctp',

    controller: 'RequestedFormPaymentController',

  })

  .when("/cashier/requested-form-payment/view/:id", {
 
    templateUrl: 'angularjs/views/cashier/requested-form/view.ctp',
 
    controller: "RequestedFormPaymentViewController",
 
  });
  
});