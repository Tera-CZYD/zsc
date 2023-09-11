app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/corporate-affairs/apartelle-monthly-payment', {

    templateUrl: 'angularjs/views/reports/corporate-affairs/apartelle-monthly-payment.ctp',

    controller: 'MonthlyPaymentController',

  });

});