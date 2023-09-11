app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/promissory-note', {

    templateUrl: 'angularjs/views/guidance/promissory-note/index.ctp',

    controller: 'PromissoryNoteController',

  })

  .when('/guidance/promissory-note/add', {

    templateUrl: 'angularjs/views/guidance/promissory-note/add.ctp',

    controller: 'PromissoryNoteAddController',

  })

  .when('/guidance/promissory-note/edit/:id', { 

    templateUrl: 'angularjs/views/guidance/promissory-note/edit.ctp',

    controller: 'PromissoryNoteEditController',

  })

  .when('/guidance/promissory-note/view/:id', {

    templateUrl: 'angularjs/views/guidance/promissory-note/view.ctp',

    controller: 'PromissoryNoteViewController',

  });
  
});