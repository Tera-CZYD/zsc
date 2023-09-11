app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/learning-resource-center/bibliographies/index', {

    templateUrl: tmp + 'reports__learning_resource_center__bibliographies__index',

    controller: 'ReportBibliographyController',

  })

});