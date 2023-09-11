app.config(function($routeProvider) {

  $routeProvider

  .when('/room', {

    templateUrl: 'angularjs/views/room/index.ctp',

    controller: 'RoomController',

  })

 .when('/room/add', {

   templateUrl: 'angularjs/views/room/add.ctp',

  controller: 'RoomAddController',

 })

 .when('/room/edit/:id', {

   templateUrl: 'angularjs/views/room/edit.ctp',

   controller: 'RoomEditController',

  })



 .when('/room/view/:id', {

    templateUrl: 'angularjs/views/room/view.ctp',

    controller: 'RoomViewController',

  });

});



