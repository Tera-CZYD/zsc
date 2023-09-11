app.config(function ($routeProvider) {

  $routeProvider

    .when("/corporate-affairs/interview-request", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/index.ctp",

      controller: "InterviewRequestController",

    })

    .when("/corporate-affairs/interview-request/add", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/add.ctp",

      controller: "InterviewRequestAddController",

    })

    .when("/corporate-affairs/interview-request/edit/:id", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/edit.ctp",

      controller: "InterviewRequestEditController",

    })

    .when("/corporate-affairs/interview-request/view/:id", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/view.ctp",

      controller: "InterviewRequestViewController",
      
    })

    .when("/corporate-affairs/interview-request/student-index", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/student-index.ctp",

      controller: "StudentInterviewRequestController",

    })

    .when("/corporate-affairs/interview-request/student-add", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/student-add.ctp",

      controller: "StudentInterviewRequestAddController",

    })

    .when("/corporate-affairs/interview-request/student-edit/:id", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/student-edit.ctp",

      controller: "StudentInterviewRequestEditController",

    })

    .when("/corporate-affairs/interview-request/student-view/:id", {

      templateUrl: "angularjs/views/corporate-affairs/interview-request/student-view.ctp",

      controller: "StudentInterviewRequestViewController",
    })
    
});
