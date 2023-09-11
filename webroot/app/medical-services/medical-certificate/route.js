app.config(function ($routeProvider) {
  $routeProvider

    .when("/medical-services/medical-certificate", {
      templateUrl: "angularjs/views/medical-services/medical-certificate/index.ctp",

      controller: "MedicalCertificateController",
    })

    .when("/medical-services/medical-certificate/add", {
      templateUrl: "angularjs/views/medical-services/medical-certificate/add.ctp",

      controller: "MedicalCertificateAddController",
    })

    .when("/medical-services/medical-certificate/edit/:id", {
      templateUrl: "angularjs/views/medical-services/medical-certificate/edit.ctp",

      controller: "MedicalCertificateEditController",
    })

    .when("/medical-services/medical-certificate/view/:id", {
      templateUrl: "angularjs/views/medical-services/medical-certificate/view.ctp",

      controller: "MedicalCertificateViewController",
    })
    // .when("/medical-services/medical-certificate/student-index", {
    //   templateUrl: tmp + "medical_services__medical_certificate__student_index",

    //   controller: "StudentMedicalCertificateController",
    // })

    // .when("/medical-services/medical-certificate/student-add", {
    //   templateUrl: tmp + "medical_services__medical_certificate__student_add",

    //   controller: "StudentMedicalCertificateAddController",
    // })

    // .when("/medical-services/medical-certificate/student-edit/:id", {
    //   templateUrl: tmp + "medical_services__medical_certificate__student_edit",

    //   controller: "StudentMedicalCertificateEditController",
    // })

    // .when("/medical-services/medical-certificate/student-view/:id", {
    //   templateUrl: tmp + "medical_services__medical_certificate__student_view",

    //   controller: "StudentMedicalCertificateViewController",
    // })
    ;
});
