app.config(function($routeProvider) {

  dashboard = typeof dashboard !== 'undefined' ?  dashboard : '';

  $routeProvider

  .when('/dashboard', {

    templateUrl: 'angularjs/views/dashboard/' + dashboard,

    controller: 'DashboardController',

  });

});