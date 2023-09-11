app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/program-adviser', {

    templateUrl: 'angularjs/views/faculty/program-adviser/index.ctp',

    controller: 'ProgramAdviserController',

  })

 .when('/faculty/program-adviser/view/:id', {

    templateUrl: 'angularjs/views/faculty/program-adviser/view.ctp',

    controller: 'ProgramAdviserViewController',

  });

});


