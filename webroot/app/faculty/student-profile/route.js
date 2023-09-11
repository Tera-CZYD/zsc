app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/student-profile', {

    templateUrl: 'angularjs/views/faculty/student-profile/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/faculty/student-profile/view/:id", {
 
    templateUrl: 'angularjs/views/faculty/student-profile/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});