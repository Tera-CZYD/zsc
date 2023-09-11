app.config(function ($routeProvider) {

$routeProvider

  .when("/admission/scholarship-name", {
  
    templateUrl: 'angularjs/views/admission/scholarship-name/index.ctp',

    controller: "ScholarshipNameController",
 
  })

  .when("/admission/scholarship-name/add", {
  
    templateUrl: 'angularjs/views/admission/scholarship-name/add.ctp',

    controller: "ScholarshipNameAddController",

  })

  .when("/admission/scholarship-name/edit/:id", {
 
    templateUrl: 'angularjs/views/admission/scholarship-name/edit.ctp',

    controller: "ScholarshipNameEditController",

  })

  .when("/admission/scholarship-name/view/:id", {
 
    templateUrl: 'angularjs/views/admission/scholarship-name/view.ctp',
 
    controller: "ScholarshipNameViewController",
 
  })


});
