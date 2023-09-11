app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/referral-recommendation', {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/index.ctp',

    controller: 'ReferralRecommendationController',

  })

  .when('/medical-services/referral-recommendation/add', {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/add.ctp',

    controller: 'ReferralRecommendationAddController',

  })

  .when('/medical-services/referral-recommendation/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/edit.ctp',

    controller: 'ReferralRecommendationEditController',

  })

  .when('/medical-services/referral-recommendation/view/:id', {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/view.ctp',

    controller: 'ReferralRecommendationViewController',

  })

  .when("/medical-services/referral-recommendation/student-index", {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/student-index.ctp',


    controller: "StudentReferralRecommendationController",

  })

  .when("/medical-services/referral-recommendation/student-add", {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/student-add.ctp',


    controller: "StudentReferralRecommendationAddController",

  })

  .when("/medical-services/referral-recommendation/student-edit/:id", {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/student-edit.ctp',


    controller: "StudentReferralRecommendationEditController",

  })

  .when("/medical-services/referral-recommendation/student-view/:id", {

    templateUrl: 'angularjs/views/medical-services/referral-recommendation/student-view.ctp',


    controller: "StudentReferralRecommendationViewController",

  })
  ;
  
});