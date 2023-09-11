app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/student-profile', {

    templateUrl: 'angularjs/views/learning-resource-center/student-profile/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/learning-resource-center/student-profile/view/:id", {
 
    templateUrl: 'angularjs/views/learning-resource-center/student-profile/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});