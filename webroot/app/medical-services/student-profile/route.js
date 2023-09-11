app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/student-profile', {

    templateUrl: 'angularjs/views/medical-services/student-profile/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/medical-services/student-profile/view/:id", {
 
    templateUrl: 'angularjs/views/medical-services/student-profile/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});