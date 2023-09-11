app.config(function($routeProvider) {

  $routeProvider

  .when('/settings', {

    templateUrl:'angularjs/views/settings/index.ctp',

    controller: 'SettingController',

  });

});