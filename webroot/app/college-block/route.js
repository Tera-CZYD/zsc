app.config(function($routeProvider) {

  $routeProvider

  .when('/college-block', {

    templateUrl: tmp + 'college_block__index',

    controller: 'CollegeBlockController',

  })

 .when('/college-block/add', {

   templateUrl: tmp + 'college_block__add',

  controller: 'CollegeBlockAddController',

 })

 .when('/college-block/edit/:id', {

   templateUrl: tmp + 'college_block__edit',

   controller: 'CollegeBlockEditController',

  })

 .when('/college-block/view/:id', {

    templateUrl: tmp + 'college_block__view',

    controller: 'CollegeBlockViewController',

  });

});


