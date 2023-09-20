app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/learning-resource-center/check-ins', {

    templateUrl: 'angularjs/views/reports/learning-resource-center/check-ins/index.ctp',

    controller: 'ReportCheckInController',

  })

});