app.config(function($routeProvider) {

  $routeProvider

  .when('/admission/medical-interview', {

    templateUrl: tmp + 'admission__medical_interview__index',

    controller: 'MedicalInterviewController',

  });
  
});