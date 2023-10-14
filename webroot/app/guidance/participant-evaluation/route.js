app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/admin-participant-evaluation', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/admin-index.ctp',

    controller: 'AdminParticipantEvaluationActivityController',

  })

  .when('/guidance/admin-participant-evaluation/add', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/admin-add.ctp', 

    controller: 'AdminParticipantEvaluationActivityAddController',

  })

  .when('/guidance/admin-participant-evaluation/edit/:id', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/admin-edit.ctp',

    controller: 'AdminParticipantEvaluationActivityEditController',

  })

  .when('/guidance/admin-participant-evaluation/view/:id', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/admin-view.ctp',

    controller: 'AdminParticipantEvaluationActivityViewController',

  })

  .when('/guidance/participant-evaluation', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/index.ctp',

    controller: 'ParticipantEvaluationActivityController',

  })

  .when('/guidance/participant-evaluation/add', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/add.ctp', 

    controller: 'ParticipantEvaluationActivityAddController',

  })

  .when('/guidance/participant-evaluation/edit/:id', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/edit.ctp',

    controller: 'ParticipantEvaluationActivityEditController',

  })

  .when('/guidance/participant-evaluation/view/:id', {

    templateUrl: 'angularjs/views/guidance/participant-evaluation/view.ctp',

    controller: 'ParticipantEvaluationActivityViewController',

  });
  
});