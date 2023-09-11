app.config(function($routeProvider) {

  $routeProvider

  .when('/profile/student-profile', {

    templateUrl: tmp + 'profile__student_profile__index',

    controller: 'StudentController',

  })

  // .when("/profile/student-profile/view/:id", {
 
  //   templateUrl: tmp + "profile__student_profile__view",
 
  //   controller: "ProfileViewController",
 
  // })

  .when("/profile/student-profile/view-profile/:id", {
 
    templateUrl: tmp + "profile__student_profile__view_profile",
 
    controller: "StudentViewController",
 
  })

  .when("/profile/student-profile/edit-profile/:id", {

    templateUrl: tmp + 'profile__student_profile__edit_profile',

    controller: 'StudentEditController',

  });
  
});