app.config(function($routeProvider) {

  $routeProvider

  .when('/student-profile', {

    templateUrl: 'angularjs/views/student-profile/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/student-profile/view/:id", {
 
    templateUrl: 'angularjs/views/student-profile/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});