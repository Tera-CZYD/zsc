app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/medical-employee-profile', {

    templateUrl: 'angularjs/views/medical-services/medical-employee-profile/index.ctp',

    controller: 'MedicalEmployeeProfileController',

  })

  .when('/medical-services/medical-employee-profile/add', {

    templateUrl: 'angularjs/views/medical-services/medical-employee-profile/add.ctp',

    controller: 'MedicalEmployeeProfileAddController',

  })

    .when('/medical-services/medical-employee-profile/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/medical-employee-profile/edit.ctp',

    controller: 'MedicalEmployeeProfileEditController',

  })

    .when('/medical-services/medical-employee-profile/view/:id', {

    templateUrl: 'angularjs/views/medical-services/medical-employee-profile/view.ctp',

    controller: 'MedicalEmployeeProfileViewController',

  });
  
});