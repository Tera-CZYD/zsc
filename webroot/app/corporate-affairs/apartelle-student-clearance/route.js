  app.config(function($routeProvider) {

  $routeProvider

  .when('/corporate-affairs/apartelle-student-clearance', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/index.ctp',

    controller: 'ApartelleStudentClearanceController',

  })

  .when('/corporate-affairs/apartelle-student-clearance/add', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/add.ctp',

    controller: 'ApartelleStudentClearanceAddController',

  })

  .when('/corporate-affairs/apartelle-student-clearance/edit/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/edit.ctp',

    controller: 'ApartelleStudentClearanceEditController',

  })

  .when('/corporate-affairs/apartelle-student-clearance/view/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/view.ctp',

    controller: 'ApartelleStudentClearanceViewController',

  })





  .when('/corporate-affairs/admin-apartelle-student-clearance', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/admin-index.ctp',

    controller: 'AdminApartelleStudentClearanceController',

  })


  .when('/corporate-affairs/admin-apartelle-student-clearance/add', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/admin-add.ctp',

    controller: 'AdminApartelleStudentClearanceAddController',

  })


  .when('/corporate-affairs/admin-apartelle-student-clearance/edit/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/admin-edit.ctp',

    controller: 'AdminApartelleStudentClearanceEditController',

  })

  .when('/corporate-affairs/admin-apartelle-student-clearance/view/:id', {

    templateUrl: 'angularjs/views/corporate-affairs/apartelle-student-clearance/admin-view.ctp',

    controller: 'AdminApartelleStudentClearanceViewController',

  })
  
});