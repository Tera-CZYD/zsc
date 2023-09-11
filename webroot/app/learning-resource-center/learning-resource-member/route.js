app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/learning-resource-member', {

    templateUrl: 'angularjs/views/learning-resource-center/learning-resource-member/index.ctp',

    controller: 'LearningResourceMemberController',

  })

  .when('/learning-resource-center/learning-resource-member/add', {

    templateUrl: 'angularjs/views/learning-resource-center/learning-resource-member/add.ctp',

    controller: 'LearningResourceMemberAddController',

  })

  .when('/learning-resource-center/learning-resource-member/edit/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/learning-resource-member/edit.ctp',

    controller: 'LearningResourceMemberEditController',

  })

  .when('/learning-resource-center/learning-resource-member/view/:id', {

    templateUrl: 'angularjs/views/learning-resource-center/learning-resource-member/view.ctp',

    controller: 'LearningResourceMemberViewController',

  });
  
});