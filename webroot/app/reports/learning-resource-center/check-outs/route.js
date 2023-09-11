app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/learning-resource-center/check-outs/index', {

    templateUrl: 'angularjs/views/reports/learning-resource-center/check-outs/index.ctp',

    controller: 'ReportCheckOutController',

  })

});