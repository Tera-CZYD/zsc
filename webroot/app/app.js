var app = angular.module('esmis', ['ngRoute', 'ngResource', 'chieffancypants.loadingBar', 'selectize']);

  app.config(function($routeProvider) {

    $routeProvider

    .otherwise({

      redirectTo: '/dashboard'

    });
    
  });