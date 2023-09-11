app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty-qce', {

    templateUrl: tmp + 'faculty_qce__index',

    controller: 'FacultyQceController',

  })

  .when('/faculty-qce/evaluate-faculty/:id', {

    templateUrl: tmp + 'faculty_qce__evaluate_faculty',

    controller: 'FacultyQceEvaluateFacultyController',

  });

});


