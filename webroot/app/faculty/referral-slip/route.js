app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/referral-slip', {

    templateUrl: 'angularjs/views/faculty/referral-slip/index.ctp',

    controller: 'ReferralSlipController', 

  })

 .when('/faculty/referral-slip/add', {

   templateUrl: 'angularjs/views/faculty/referral-slip/add.ctp',

  controller: 'ReferralSlipAddController',

 })

 .when('/faculty/referral-slip/edit/:id', {

   templateUrl: 'angularjs/views/faculty/referral-slip/edit.ctp',

   controller: 'ReferralSlipEditController',

  })

 .when('/faculty/referral-slip/view/:id', {

    templateUrl: 'angularjs/views/faculty/referral-slip/view.ctp',

    controller: 'ReferralSlipViewController',

  });

});

