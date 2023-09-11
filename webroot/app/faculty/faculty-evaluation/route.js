app.config(function($routeProvider) {

  $routeProvider

  .when('/faculty/faculty-evaluation', {

    templateUrl: tmp + 'faculty__faculty_evaluation__index',

    controller: 'FacultyEvaluationController',

  })

  .when('/faculty/faculty-evaluation/add/:course/:id/:course_id', {

    templateUrl: tmp + 'faculty__faculty_evaluation__add',

    controller: 'FacultyEvaluationAddController',

  })

  .when('/faculty/faculty-evaluation/edit/:id', {

    templateUrl: tmp + 'faculty__faculty_evaluation__edit',

    controller: 'FacultyEvaluationEditController',

  })

  .when('/faculty/faculty-evaluation/view/:id', {

    templateUrl: tmp + 'faculty__faculty_evaluation__view',

    controller: 'FacultyEvaluationViewController',

  })

  .when('/faculty/admin-faculty-evaluation', {

    templateUrl: tmp + 'faculty__faculty_evaluation__admin_index',

    controller: 'AdminFacultyEvaluationController',

  })

  .when('/faculty/admin-faculty-evaluation/add', {

    templateUrl: tmp + 'faculty__faculty_evaluation__admin_add',

    controller: 'AdminFacultyEvaluationAddController',

  })

  .when('/faculty/admin-faculty-evaluation/edit/:id', {

    templateUrl: tmp + 'faculty__faculty_evaluation__admin_edit',

    controller: 'AdminFacultyEvaluationEditController',

  })

  .when('/faculty/admin-faculty-evaluation/view/:id', {

    templateUrl: tmp + 'faculty__faculty_evaluation__admin_view',

    controller: 'AdminFacultyEvaluationViewController',

  })

  .when('/faculty/admin-faculty-evaluation/view-score/:id', {

    templateUrl: tmp + 'faculty__faculty_evaluation__admin_view_score',

    controller: 'AdminFacultyEvaluationViewScoreController',

  })

    .when('/faculty/admin-faculty-evaluation/view-comment/:id', {

    templateUrl: tmp + 'faculty__faculty_evaluation__admin_view_comment',

    controller: 'AdminFacultyEvaluationViewCommentController',

  });
  
});