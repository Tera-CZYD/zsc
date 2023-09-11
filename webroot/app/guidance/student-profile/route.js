app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/student-profile', {

    templateUrl: 'angularjs/views/guidance/student-profile/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/guidance/student-profile/view/:id", {
 
    templateUrl: 'angularjs/views/guidance/student-profile/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});