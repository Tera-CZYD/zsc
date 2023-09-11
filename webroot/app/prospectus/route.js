app.config(function($routeProvider) {

  $routeProvider

  .when('/curriculum/prospectus', {

    templateUrl: 'angularjs/views/prospectus/index.ctp',

    controller: 'ProspectusController',

  })

  .when("/curriculum/prospectus/view/:id", {
 
    templateUrl: "angularjs/views/prospectus/view.ctp",
 
    controller: "ProspectusViewController",
 
  })

  .when("/curriculum/prospectus/view-student/:id", {
 
    templateUrl: "angularjs/views/prospectus/view-student.ctp",
 
    controller: "ProspectusStudentViewController",
 
  });
  
});