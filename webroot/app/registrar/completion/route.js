app.config(function ($routeProvider) {
  $routeProvider

    .when("/registrar/completion", {
      templateUrl:'angularjs/views/registrar/completion/index.ctp',

      controller: "CompletionController",
    })

    .when("/registrar/completion/add", {
      templateUrl: 'angularjs/views/registrar/completion/add.ctp',

      controller: "CompletionAddController",
    })

    .when("/registrar/completion/edit/:id", {
      templateUrl: 'angularjs/views/registrar/completion/edit.ctp',

      controller: "CompletionEditController",
    })

    .when("/registrar/completion/view/:id", {
      templateUrl: 'angularjs/views/registrar/completion/view.ctp',

      controller: "CompletionViewController",
    });
});
