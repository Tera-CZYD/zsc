app.config(function ($routeProvider) {
  $routeProvider

    .when("/registrar/club", {

        templateUrl: 'angularjs/views/registrar/club/index.ctp',

      controller: "ClubController",
    })

    .when("/registrar/club/add", {
      templateUrl: 'angularjs/views/registrar/club/add.ctp',

      controller: "ClubAddController",
    })

    .when("/registrar/club/edit/:id", {
      templateUrl: 'angularjs/views/registrar/club/edit.ctp',

      controller: "ClubEditController",
    })

    .when("/registrar/club/view/:id", {
      templateUrl: 'angularjs/views/registrar/club/view.ctp',

      controller: "ClubViewController",
    });
});
