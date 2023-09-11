app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/learning-resource-center/check-ins/index', {

    templateUrl: tmp + 'reports__learning_resource_center__check_ins__index',

    controller: 'ReportCheckInController',

  })

});