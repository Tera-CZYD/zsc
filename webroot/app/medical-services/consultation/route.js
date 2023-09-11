app.config(function ($routeProvider) {

  $routeProvider

  .when("/medical-services/consultation", {

    templateUrl: 'angularjs/views/medical-services/consultation/index.ctp',

    controller: "ConsultationController",

  })

  .when("/medical-services/consultation/add", {

    templateUrl: 'angularjs/views/medical-services/consultation/add.ctp',

    controller: "ConsultationAddController",

  })

  .when("/medical-services/consultation/edit/:id", {

    templateUrl: 'angularjs/views/medical-services/consultation/edit.ctp',

    controller: "ConsultationEditController",

  })

  .when("/medical-services/consultation/view/:id", {

    templateUrl: 'angularjs/views/medical-services/consultation/view.ctp',

    controller: "ConsultationViewController",

  })

  .when("/medical-services/consultation/student-index", {

    templateUrl: 'angularjs/views/medical-services/consultation/student-index.ctp',

    controller: "StudentConsultationController",

  })

  .when("/medical-services/consultation/student-add", {

    templateUrl: 'angularjs/views/medical-services/consultation/student-add.ctp',

    controller: "StudentConsultationAddController",

  })

  .when("/medical-services/consultation/student-edit/:id", {

    templateUrl: 'angularjs/views/medical-services/consultation/student-edit.ctp',

    controller: "StudentConsultationEditController",

  })

  .when("/medical-services/consultation/student-view/:id", {

    templateUrl: 'angularjs/views/medical-services/consultation/student-view.ctp',

    controller: "StudentConsultationViewController",

  });
  
});
