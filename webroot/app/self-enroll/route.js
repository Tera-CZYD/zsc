app.config(function($routeProvider) {

  $routeProvider

  .when('/self-enroll', {

    templateUrl: tmp + 'self_enroll__index',

    controller: 'SelfEnrollController',

  });

});


