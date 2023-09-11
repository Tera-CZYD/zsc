app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/illness-recommendation', {

    templateUrl: 'angularjs/views/medical-services/illness-recommendation/index.ctp',

    controller: 'IllnessRecommendationController',

  })

  .when('/medical-services/illness-recommendation/add', {

    templateUrl: 'angularjs/views/medical-services/illness-recommendation/add.ctp',

    controller: 'IllnessRecommendationAddController',

  })

    .when('/medical-services/illness-recommendation/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/illness-recommendation/edit.ctp',

    controller: 'IllnessRecommendationEditController',

  })

    .when('/medical-services/illness-recommendation/view/:id', {

    templateUrl: 'angularjs/views/medical-services/illness-recommendation/view.ctp',

    controller: 'IllnessRecommendationViewController',

  });
  
});