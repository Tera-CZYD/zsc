app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/learning-resource-center/bibliographies', {

    templateUrl: 'angularjs/views/reports/learning-resource-center/bibliographies/index.ctp',

    controller: 'ListBibliography', 

  })

});