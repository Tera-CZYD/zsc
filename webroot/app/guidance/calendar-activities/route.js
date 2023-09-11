app.config(function($routeProvider) {

  $routeProvider

  .when('/guidance/calendar-activities', {

    templateUrl: 'angularjs/views/guidance/calendar-activities/index.ctp',

    controller: 'CalendarActivityController',

  })

  .when('/guidance/calendar-activities/add', {

    templateUrl: 'angularjs/views/guidance/calendar-activities/add.ctp',

    controller: 'CalendarActivityAddController',

  })

  .when('/guidance/calendar-activities/view/:id', {

    templateUrl: 'angularjs/views/guidance/calendar-activities/view.ctp',

    controller: 'CalendarActivityViewController',

  })

  .when('/guidance/calendar-activities/edit/:id', {

    templateUrl: 'angularjs/views/guidance/calendar-activities/edit.ctp',

    controller: 'CalendarActivityEditController',

  });

});


