app.config(function($routeProvider) {

  $routeProvider

  .when('/backup', {

    templateUrl: 'angularjs/views/backup/index.ctp',

    controller: 'BackupController',

  });
  
});