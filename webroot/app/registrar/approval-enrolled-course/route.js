app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/approval-enrolled-course', {

    templateUrl: tmp + 'registrar__approval_enrolled_course__index',

    controller: 'ApprovalEnrolledCourseController',

  })

  .when("/registrar/approval-enrolled-course/add/", {
 
    templateUrl: tmp + "registrar__approval_enrolled_course__add",
 
    controller: "ApprovalEnrolledAddCourseController",
 
  })

  .when("/registrar/approval-enrolled-course/view/:id", {
 
    templateUrl: tmp + "registrar__approval_enrolled_course__view",
 
    controller: "ApprovalEnrolledViewCourseController",
 
  })

  .when("/registrar/approval-enrolled-course/edit/:id", {
 
    templateUrl: tmp + "registrar__approval_enrolled_course__edit",
 
    controller: "ApprovalEnrolledEditCourseController",
 
  });
  
});