app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/medical-student-profile', {

    templateUrl: 'angularjs/views/medical-services/medical-student-profile/index.ctp',

    controller: 'MedicalStudentProfileController',

  })

  .when('/medical-services/medical-student-profile/add', {

    templateUrl: 'angularjs/views/medical-services/medical-student-profile/add.ctp',

    controller: 'MedicalStudentProfileAddController',

  })

    .when('/medical-services/medical-student-profile/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/medical-student-profile/edit.ctp',

    controller: 'MedicalStudentProfileEditController',

  })

    .when('/medical-services/medical-student-profile/view/:id', {

    templateUrl: 'angularjs/views/medical-services/medical-student-profile/view.ctp',

    controller: 'MedicalStudentProfileViewController',

  });
  
});