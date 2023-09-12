app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/guidance/requested-form', {

    templateUrl: 'angularjs/views/reports/guidance/requested-form.ctp',

    controller: 'ListRequestedFormController',

  })

  .when('/reports/guidance/gco-evaluation', {

    templateUrl: 'angularjs/views/reports/guidance/gco-evaluation.ctp',

    controller: 'GcoEvaluationListController',

  })

});