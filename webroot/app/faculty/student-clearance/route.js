app.config(function ($routeProvider) {

  $routeProvider

  .when("/faculty/student-clearance", {

    templateUrl: 'angularjs/views/faculty/student-clearance/index.ctp',

    controller: "StudentClearanceController",

  })

  .when("/faculty/student-clearance/add", {

    templateUrl: 'angularjs/views/faculty/student-clearance/add.ctp',

    controller: "StudentClearanceAddController",

  })

  .when("/faculty/student-clearance/edit/:id", {

    templateUrl: 'angularjs/views/faculty/student-clearance/edit.ctp',

    controller: "StudentClearanceEditController",

  })

  .when("/faculty/student-clearance/view/:id", {

    templateUrl: 'angularjs/views/faculty/student-clearance/view.ctp',

    controller: "StudentClearanceViewController",

  })

  .when("/faculty/student-clearance/faculty-index", {

    templateUrl: 'angularjs/views/faculty/student-clearance/faculty-index.ctp',

    controller: "StudentClearanceController",

  })

  .when("/faculty/student-clearance/head-index", {

    templateUrl: 'angularjs/views/faculty/student-clearance/head-index.ctp',

    controller: "StudentClearanceController",

  })

  .when("/faculty/student-clearance/faculty-add", {

    templateUrl: 'angularjs/views/faculty/student-clearance/faculty-add.ctp',

    controller: "StudentClearanceFacultyAddController",

  })

  .when("/faculty/student-clearance/faculty-view/:id", {

    templateUrl: 'angularjs/views/faculty/student-clearance/faculty-view.ctp',

    controller: "StudentClearanceFacultyViewController",

  })

  .when("/faculty/student-clearance/dean-index", {

    templateUrl: 'angularjs/views/faculty/student-clearance/dean-index.ctp',

    controller: "StudentClearanceController",

  })

  .when("/faculty/student-clearance/dean-add", {

    templateUrl: 'angularjs/views/faculty/student-clearance/dean-add.ctp',

    controller: "StudentClearanceDeanAddController",

  })

  .when("/faculty/student-clearance/dean-view/:id", {

    templateUrl: 'angularjs/views/faculty/student-clearance/dean-view.ctp',

    controller: "StudentClearanceDeanViewController",

  });

});
