app.config(function ($routeProvider) {
  $routeProvider

    .when("/registrar/scholastic-document", {

        templateUrl: 'angularjs/views/registrar/scholastic-document/index.ctp',

      controller: "ScholasticDocumentController",
    })

    .when("/registrar/scholastic-document/add", {
      templateUrl: 'angularjs/views/registrar/scholastic-document/add.ctp',

      controller: "ScholasticDocumentAddController",
    })

    .when("/registrar/scholastic-document/edit/:id", {
      templateUrl: 'angularjs/views/registrar/scholastic-document/edit.ctp',

      controller: "ScholasticDocumentEditController",
    })

    .when("/registrar/scholastic-document/view/:id", {
      templateUrl: 'angularjs/views/registrar/scholastic-document/view.ctp',

      controller: "ScholasticDocumentViewController",
    });
});
