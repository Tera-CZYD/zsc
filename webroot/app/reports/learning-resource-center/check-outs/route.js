app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/learning-resource-center/check-outs/', {

    templateUrl: 'angularjs/views/reports/learning-resource-center/check-outs/index.ctp',

    controller: 'ReportCheckOutController',

  })

});