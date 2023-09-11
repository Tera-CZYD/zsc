app.config(function($routeProvider) {

  $routeProvider

  .when('/admission/cat', {

    templateUrl: 'angularjs/views/admission/cat/index.ctp',

    controller: 'CatController',

  })

  .when("/admission/cat/view/:id", {


    templateUrl: 'angularjs/views/admission/cat/view.ctp',
 
    controller: "CatViewController",
 
  });
  
});