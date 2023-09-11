app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/registrar/subject-masterlists', {

    templateUrl: 'angularjs/views/reports/registrar/subject-masterlists.ctp',

    controller: 'SubjectMasterlistController',

  })

  .when('/reports/registrar/enrollment-list', {

    templateUrl: 'angularjs/views/reports/registrar/enrollment-list.ctp',

    controller: 'EnrollmentListReportController',

  })

  .when('/reports/registrar/student-masterlist', {

    templateUrl: 'angularjs/views/reports/registrar/student-masterlist.ctp',

    controller: 'ListStudentController',

  })

  .when('/reports/registrar/student-ranking', {

    templateUrl: 'angularjs/views/reports/registrar/student-ranking.ctp',

    controller: 'StudentRankingController',

  })

  .when('/reports/registrar/promoted-student', {

    templateUrl: 'angularjs/views/reports/registrar/promoted-student.ctp',

    controller: 'PromotedStudentController',

  })

  .when('/reports/registrar/student-behavior', {

    templateUrl: 'angularjs/views/reports/registrar/student-behavior.ctp',

    controller: 'StudentBehaviorReportController',

  })

  .when('/reports/registrar/academic-failures-list', {

    templateUrl: 'angularjs/views/reports/registrar/academic-failures-list.ctp', 

    controller: 'AcademicFailuresListController', 

  })

  .when('/reports/registrar/student-club-list', {

    templateUrl: 'angularjs/views/reports/registrar/student-club-list.ctp', 

    controller: 'StudentClubListController', 

  })

  .when('/reports/registrar/academic-list', {

    templateUrl: 'angularjs/views/reports/registrar/academic-list.ctp',

    controller: 'AcademicListController',

  })
  
  .when('/reports/registrar/list-academic-awardees', {

    templateUrl: 'angularjs/views/reports/registrar/list-academic-awardees.ctp',

    controller: 'ListAcademicAwardeeController',

  })

  .when('/reports/registrar/gwa', {

    templateUrl: 'angularjs/views/reports/registrar/gwa.ctp',

    controller: 'GWAController',

  })

  .when('/reports/registrar/enrollment-profile', {

    templateUrl: 'angularjs/views/reports/registrar/enrollment-profile.ctp',

    controller: 'EnrollmentProfileController',

  })


});