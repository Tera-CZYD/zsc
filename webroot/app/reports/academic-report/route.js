app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/academic-report/faculty-masterlists', {

    templateUrl: 'angularjs/views/reports/academic-report/faculty-masterlists.ctp',

    controller: 'FacultyMasterlistController',

  })

});