app.config(function($routeProvider) {

  $routeProvider

  .when('/admission/student-profiles', {

    templateUrl: 'angularjs/views/admission/student-profiles/index.ctp',

    controller: 'StudentProfileController',

  })

  .when("/admission/student-profiles/view/:id", {
 
    templateUrl: 'angularjs/views/admission/student-profiles/view.ctp',
 
    controller: "StudentProfileViewController",
 
  });
  
});