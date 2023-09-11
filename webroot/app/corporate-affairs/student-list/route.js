app.config(function($routeProvider) {

  $routeProvider


  .when('/corporate-affairs/student-list', {

    templateUrl: 'angularjs/views/corporate-affairs/student-list/index.ctp',

    controller: 'StudentListController',

  })


  // .when('/corporate-affairs/admin-apartelle-registration/add', {

  //   templateUrl: tmp + 'corporate_affairs__apartelle_registration__admin_add',

  //   controller: 'AdminApartelleRegistrationAddController',

  // })


  // .when('/corporate-affairs/admin-apartelle-registration/edit/:id', {

  //   templateUrl: tmp + 'corporate_affairs__apartelle_registration__admin_edit',

  //   controller: 'AdminApartelleRegistrationEditController',

  // })

  .when('/corporate-affairs/student-list/view/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/student-list/view.ctp',

    controller: 'StudentListViewController',

  })
  
});