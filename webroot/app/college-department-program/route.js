app.config(function($routeProvider) {

  $routeProvider

  .when('/college-department-program', {

    templateUrl: tmp + 'college_department_program__index',

    controller: 'CollegeDepartmentProgramController',

  })

 .when('/college-department-program/add', {

   templateUrl: tmp + 'college_department_program__add',

  controller: 'CollegeDepartmentProgramAddController',

 })

 .when('/college-department-program/edit/:id', {

   templateUrl: tmp + 'college_department_program__edit',

   controller: 'CollegeDepartmentProgramEditController',

  })

 .when('/college-department-program/view/:id', {

    templateUrl: tmp + 'college_department_program__view',

    controller: 'CollegeDepartmentProgramViewController',

  });

});

