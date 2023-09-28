app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/affidavit-of-loss', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/index.ctp',

    controller: 'AffidavitOfLossController',

  })

  .when('/registrar/affidavit-of-loss/add', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/add.ctp',

    controller: 'AffidavitOfLossAddController',

  })

  .when('/registrar/affidavit-of-loss/edit/:id', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/edit.ctp',

    controller: 'AffidavitOfLossEditController',

  })

  .when('/registrar/affidavit-of-loss/view/:id', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/view.ctp',

    controller: 'AffidavitOfLossViewController',

  })

  .when('/registrar/admin-affidavit-of-loss', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/admin-index.ctp',

    controller: 'AdminAffidavitOfLossController',

  })

  .when('/registrar/admin-affidavit-of-loss/add', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/admin-add.ctp',

    controller: 'AdminAffidavitOfLossAddController',

  })

    .when('/registrar/admin-affidavit-of-loss/edit/:id', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/admin-edit.ctp',

    controller: 'AdminAffidavitOfLossEditController',

  })

    .when('/registrar/admin-affidavit-of-loss/view/:id', {

    templateUrl: 'angularjs/views/registrar/affidavit-of-loss/admin-view.ctp',

    controller: 'AdminAffidavitOfLossViewController',

  });
  
});