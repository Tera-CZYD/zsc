app.config(function($routeProvider) {

  $routeProvider

  .when('/college-department', {

    templateUrl: tmp + 'college_department__index',

    controller: 'CollegeDepartmentController',

  })

 .when('/college-department/add', {

   templateUrl: tmp + 'college_department__add',

  controller: 'CollegeDepartmentAddController',

 })

 .when('/college-department/edit/:id', {

   templateUrl: tmp + 'college_department__edit',

   controller: 'CollegeDepartmentEditController',

  })

 .when('/college-department/view/:id', {

    templateUrl: tmp + 'college_department__view',

    controller: 'CollegeDepartmentViewController',

  });

});


