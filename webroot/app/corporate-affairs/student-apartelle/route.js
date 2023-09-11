app.config(function($routeProvider) {

  $routeProvider

  .when('/corporate-affairs/student-apartelle', {

    templateUrl: tmp + 'corporate_affairs__student_apartelle__index',

    controller: 'StudentApartelleController',

  })

  .when('/corporate-affairs/student-apartelle/view/:id', {

    templateUrl: tmp + 'corporate_affairs__student_apartelle__view',

    controller: 'StudentApartelleViewController',

  });

  
});