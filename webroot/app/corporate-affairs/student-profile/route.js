app.config(function($routeProvider) {

  $routeProvider

  .when('/corporate-affairs/student-profile', {

    templateUrl: 'angularjs/views/corporate-affairs/student-profile/index.ctp',

    controller: 'RegisteredStudentController',

  })

  .when("/corporate-affairs/student-profile/view/:id", {
 
    templateUrl: 'angularjs/views/corporate-affairs/student-profile/view.ctp',
 
    controller: "RegisteredStudentViewController",
 
  });
  
});