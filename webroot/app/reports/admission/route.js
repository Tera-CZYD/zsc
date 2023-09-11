app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/admission/list-students', {

    templateUrl: 'angularjs/views/reports/admission/list-students.ctp',

    controller: 'ListStudentController',

  })

  .when('/reports/admission/list-scholar-students', {

    templateUrl: 'angularjs/views/reports/admission/list-scholar-students.ctp',

    controller: 'ListScholarsController',

  })

  .when('/reports/admission/list-applicants', {

    templateUrl: 'angularjs/views/reports/admission/list-applicants.ctp',

    controller: 'ListApplicantsController',

  })

    .when("/reports/admission/scholarship-evaluations", {
  
    templateUrl: 'angularjs/views/reports/admission/scholarship-evaluations.ctp',

    controller: "ScholarshipEvaluationsController",
 
  })

});