app.config(function($routeProvider) {

  $routeProvider

  .when('/student-admission', {

    templateUrl: tmp + 'student_admission__index',

    controller: 'StudentAdmissionController',

  })

 .when('/student-admission/add', {

   templateUrl: tmp + 'student_admission__add',

  controller: 'StudentAdmissionAddController',

 })

 .when('/student-admission/upload-student-information', {

   templateUrl: tmp + 'student_admission__upload_student_information',

  controller: 'StudentAdmissionUploadStudentInformationAddController',

 })

 .when('/student-admission/edit/:id', {

   templateUrl: tmp + 'student_admission__edit',

   controller: 'StudentAdmissionEditController',

  })

 .when('/student-admission/view/:id', {

    templateUrl: tmp + 'student_admission__view',

    controller: 'StudentAdmissionViewController',

  });

});


