app.config(function($routeProvider) {

  $routeProvider

  .when('/student-ledger', {

  	templateUrl: 'angularjs/views/student-ledger/index.ctp',

    controller: 'StudentLedgerController',

  })

  .when('/student-ledger/view/:id', {

  	templateUrl: 'angularjs/views/student-ledger/view.ctp',

    controller: 'StudentLedgerViewController',

  });

});


