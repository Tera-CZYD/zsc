app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/student-profile', {

    templateUrl: 'angularjs/views/registrar/student-profile/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/registrar/student-profile/view/:id", {
 
    templateUrl: 'angularjs/views/registrar/student-profile/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});