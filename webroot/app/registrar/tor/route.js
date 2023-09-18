app.config(function($routeProvider) {

  $routeProvider

  .when('/registrar/tor', {

    templateUrl: "angularjs/views/registrar/tor/index.ctp",

    controller: "TorController",

  })

  .when("/registrar/tor/view/:id", {
 
    templateUrl: "angularjs/views/registrar/tor/view.ctp",
 
    controller: "TorViewController",
 
  });
  
});x