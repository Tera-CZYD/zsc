app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/referral-slip', {

    templateUrl: 'angularjs/views/guidance/referral-slip/index.ctp',

    controller: 'ReferralSlipController', 

  })

 .when('/guidance/referral-slip/add', {

   templateUrl: 'angularjs/views/guidance/referral-slip/add.ctp',

  controller: 'ReferralSlipAddController',

 })

 .when('/guidance/referral-slip/edit/:id', {

   templateUrl: 'angularjs/views/guidance/referral-slip/edit.ctp',

   controller: 'ReferralSlipEditController',

  })

 .when('/guidance/referral-slip/view/:id', {

    templateUrl: 'angularjs/views/guidance/referral-slip/view.ctp',

    controller: 'ReferralSlipViewController',

  });

});

