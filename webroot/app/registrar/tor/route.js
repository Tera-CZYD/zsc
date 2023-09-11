app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/tor', {

    templateUrl: tmp + 'registrar__tor__index',

    controller: 'TorController',

  })

  .when("/registrar/tor/view/:id", {
 
    templateUrl: tmp + "registrar__tor__view",
 
    controller: "TorViewController",
 
  });
  
});