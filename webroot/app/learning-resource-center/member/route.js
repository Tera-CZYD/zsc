app.config(function($routeProvider) {

  $routeProvider

  .when('/learning-resource-center/member', {

    templateUrl: tmp + 'learning_resource_center__member__index',

    controller: 'MemberController',

  })

  .when('/learning-resource-center/member/add', {

    templateUrl: tmp + 'learning_resource_center__member__add',

    controller: 'MemberAddController',

  })

    .when('/learning-resource-center/member/edit/:id', {

    templateUrl: tmp + 'learning_resource_center__member__edit',

    controller: 'MemberEditController',

  })

    .when('/learning-resource-center/member/view/:id', {

    templateUrl: tmp + 'learning_resource_center__member__view',

    controller: 'MemberViewController',

  });
  
});