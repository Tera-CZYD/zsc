app.config(function($routeProvider) {

  $routeProvider

  .when('/admission/registered-students', {

    templateUrl: 'angularjs/views/admission/registered-students/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/admission/registered-students/view/:id", {
 
    templateUrl: 'angularjs/views/admission/registered-students/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});