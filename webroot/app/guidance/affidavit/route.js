app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/affidavit', {

    templateUrl: 'angularjs/views/guidance/affidavit/index.ctp',

    controller: 'AffidavitController',

  })

  .when('/guidance/affidavit/add', {

    templateUrl: 'angularjs/views/guidance/affidavit/add.ctp',

    controller: 'AffidavitAddController',

  })

  .when('/guidance/affidavit/edit/:id', {

    templateUrl: 'angularjs/views/guidance/affidavit/edit.ctp',

    controller: 'AffidavitEditController',

  })

  .when('/guidance/affidavit/view/:id', {

    templateUrl: 'angularjs/views/guidance/affidavit/view.ctp',

    controller: 'AffidavitViewController',

  });
  
});