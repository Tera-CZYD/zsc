app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/gco-evaluation', {

    templateUrl: 'angularjs/views/guidance/gco-evaluation/index.ctp',

    controller: 'GcoEvaluationController',

  })

  .when('/guidance/gco-evaluation/add', {

    templateUrl: 'angularjs/views/guidance/gco-evaluation/add.ctp',

    controller: 'GcoEvaluationAddController',

  })

  .when('/guidance/gco-evaluation/edit/:id', {

    templateUrl: 'angularjs/views/guidance/gco-evaluation/edit.ctp',

    controller: 'GcoEvaluationEditController',

  })

  .when('/guidance/gco-evaluation/view/:id', {

    templateUrl: 'angularjs/views/guidance/gco-evaluation/view.ctp',

    controller: 'GcoEvaluationViewController',

  })

  .when('/guidance/admin-gco-evaluation', {

    templateUrl: 'angularjs/views/guidance/gco-evaluation/admin-index.ctp',

    controller: 'AdminGcoEvaluationController',

  })

  .when('/guidance/admin-gco-evaluation/add', {

    templateUrl: tmp + 'guidance__gco_evaluation__admin_add',

    controller: 'AdminGcoEvaluationAddController',

  })

  .when('/guidance/admin-gco-evaluation/edit/:id', {

    templateUrl: tmp + 'guidance__gco_evaluation__admin_edit',

    controller: 'AdminGcoEvaluationEditController',

  })

  .when('/guidance/admin-gco-evaluation/view/:id', {

    templateUrl: 'angularjs/views/guidance/gco-evaluation/admin-view.ctp',

    controller: 'AdminGcoEvaluationViewController',

  });
  
});