app.config(function($routeProvider) {



  $routeProvider



  .when('/user-logs', {



    templateUrl: 'angularjs/views/user-logs/index.ctp',



    controller: 'UserLogController',



  });

  

});