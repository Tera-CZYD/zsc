app.config(function($routeProvider) {

  $routeProvider

  .when('/medical-services/property-log', {

    templateUrl: 'angularjs/views/medical-services/property-log/index.ctp',

    controller: 'PropertyLogController',

  })

  .when('/medical-services/property-log/add', {

    templateUrl: 'angularjs/views/medical-services/property-log/add.ctp',

    controller: 'PropertyLogAddController',

  })

    .when('/medical-services/property-log/edit/:id', {

    templateUrl: 'angularjs/views/medical-services/property-log/edit.ctp',

    controller: 'PropertyLogEditController',

  })

  .when('/medical-services/property-log/view/:id', {

    templateUrl: 'angularjs/views/medical-services/property-log/view.ctp',

    controller: 'PropertyLogViewController',

  });

});