app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/nurse-profile', {

    templateUrl: 'angularjs/views/medical-services/nurse-profile/index.ctp',

    controller: 'NurseProfileController',

  })

  .when('/medical-services/nurse-profile/add', {

    templateUrl: 'angularjs/views/medical-services/nurse-profile/add.ctp',

    controller: 'NurseProfileAddController',

  })

    .when('/medical-services/nurse-profile/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/nurse-profile/edit.ctp',

    controller: 'NurseProfileEditController',

  })

    .when('/medical-services/nurse-profile/view/:id', {

    templateUrl: 'angularjs/views/medical-services/nurse-profile/view.ctp',

    controller: 'NurseProfileViewController',

  });
  
});