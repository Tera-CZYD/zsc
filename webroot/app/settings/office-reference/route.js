app.config(function($routeProvider) {

  $routeProvider

  .when('/settings/office-reference', {

    templateUrl:'angularjs/views/office-reference/index.ctp',

    controller: 'OfficeReferenceController',

  })

  .when('/settings/office-reference/add', {

    templateUrl:'angularjs/views/office-reference/add.ctp',

    controller: 'OfficeReferenceAddController',

  })

    .when('/settings/office-reference/edit/:id', {

    templateUrl:'angularjs/views/office-reference/edit.ctp',

    controller: 'OfficeReferenceEditController',

  })

    .when('/settings/office-reference/view/:id', {

    templateUrl: 'angularjs/views/office-reference/view.ctp',

    controller: 'OfficeReferenceViewController',

  });
  
});