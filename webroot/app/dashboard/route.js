app.config(function($routeProvider) {

  $routeProvider

  .when('/dashboard', {

    templateUrl: 'angularjs/views/dashboard/' + dashboard,

    controller: 'DashboardController',

  });

});