app.config(function($routeProvider) {

  $routeProvider

  .when('/cashier/assessment', {

    templateUrl: 'angularjs/views/cashier/assessment/index.ctp',

    controller: 'AssessmentController',

  })

  .when("/cashier/assessment/view/:id", {
 
    templateUrl: 'angularjs/views/cashier/assessment/view.ctp',
 
    controller: "AssessmentViewController",
 
  });
  
});