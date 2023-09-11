app.config(function ($routeProvider) {

$routeProvider

  .when("/admission/scholarship-application", {
  
    templateUrl: 'angularjs/views/admission/scholarship-applications/index.ctp',

    controller: "ScholarshipApplicationController",
 
  })

  .when("/admission/scholarship-application/add", {
  
    templateUrl: 'angularjs/views/admission/scholarship-applications/add.ctp',

    controller: "ScholarshipApplicationAddController",

  })

  .when("/admission/scholarship-application/edit/:id", {
 
    templateUrl: 'angularjs/views/admission/scholarship-applications/edit.ctp',

    controller: "ScholarshipApplicationEditController",

  })

  .when("/admission/scholarship-application/view/:id", {
 
    templateUrl: 'angularjs/views/admission/scholarship-applications/view.ctp',
 
    controller: "ScholarshipApplicationViewController",
 
  })

  .when("/admission/admin-scholarship-application", {
  
    templateUrl: 'angularjs/views/admission/scholarship-applications/admin-index.ctp',

    controller: "AdminScholarshipApplicationController",
 
  })

  .when("/admission/admin-scholarship-application/add", {
  
    templateUrl: 'angularjs/views/admission/scholarship-applications/admin-add.ctp',

    controller: "AdminScholarshipApplicationAddController",

  })

  .when("/admission/admin-scholarship-application/edit/:id", {
 
    templateUrl: 'angularjs/views/admission/scholarship-applications/admin-edit.ctp',

    controller: "AdminScholarshipApplicationEditController",

  })

  .when("/admission/admin-scholarship-application/view/:id", {
 
    templateUrl: 'angularjs/views/admission/scholarship-applications/admin-view.ctp',
 
    controller: "AdminScholarshipApplicationViewController",
 
  });

});
