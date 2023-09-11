app.config(function($routeProvider) {

  $routeProvider

  .when('/dashboard', {

    templateUrl: 'angularjs/views/dashboard/student-dashboard.ctp',

    controller: 'DashboardController',

  });

});



