app.config(function($routeProvider) {

  $routeProvider

  .when('/college', {

    templateUrl: 'angularjs/views/colleges/index.ctp',

    controller: 'CollegeController',

  })

 .when('/college/add', {

   templateUrl: 'angularjs/views/colleges/add.ctp',

  controller: 'CollegeAddController',

 })

 .when('/college/edit/:id', {

   templateUrl: 'angularjs/views/colleges/edit.ctp',

   controller: 'CollegeEditController',

  })

 .when('/college/view/:id', {

    templateUrl: 'angularjs/views/colleges/view.ctp',

    controller: 'CollegeViewController',

  });

});


