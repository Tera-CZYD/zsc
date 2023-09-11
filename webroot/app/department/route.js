app.config(function($routeProvider) {

  $routeProvider

  .when('/department', {

    templateUrl: tmp + 'department__index',

    controller: 'DepartmentController',

  })

 .when('/department/add', {

   templateUrl: tmp + 'department__add',

  controller: 'DepartmentAddController',

 })

 .when('/department/edit/:id', {

   templateUrl: tmp + 'department__edit',

   controller: 'DepartmentEditController',

  })

 .when('/department/view/:id', {

    templateUrl: tmp + 'department__view',

    controller: 'DepartmentViewController',

  });

});


