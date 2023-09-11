app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/academic-report/faculty-masterlists', {

    templateUrl: tmp + 'reports__academic_report__faculty_masterlists',

    controller: 'FacultyMasterlistController',

  })

});