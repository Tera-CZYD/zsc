app.config(function ($routeProvider) {
  
  $routeProvider

    .when("/registrar/purpose", {

      templateUrl: 'angularjs/views/registrar/purpose/index.ctp',

      controller: "PurposeController",

    })

    .when("/registrar/purpose/add", {

      templateUrl: 'angularjs/views/registrar/purpose/add.ctp',

      controller: "PurposeAddController",

    })

    .when("/registrar/purpose/edit/:id", {

      templateUrl: 'angularjs/views/registrar/purpose/edit.ctp',

      controller: "PurposeEditController",

    })

    .when("/registrar/purpose/view/:id", {

      templateUrl: 'angularjs/views/registrar/purpose/view.ctp',

      controller: "PurposeViewController",

    });

});
