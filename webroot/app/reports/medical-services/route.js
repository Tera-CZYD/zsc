app.config(function($routeProvider) {

  $routeProvider

  .when('/reports/medical-services/monthly-accomplishment', {

    templateUrl: 'angularjs/views/reports/medical-services/monthly-accomplishment.ctp',

    controller: 'MedicalMonthlyAccomplishmentController',

  })

  .when('/reports/medical-services/monthly-consumption', {

    templateUrl: 'angularjs/views/reports/medical-services/monthly-consumption.ctp',

    controller: 'MedicalMonthlyConsumptionController',

  })

  .when('/reports/medical-services/daily-treatments', {

    templateUrl: 'angularjs/views/reports/medical-services/daily-treatments.ctp',

    controller: 'MedicalDailyTreatmentController',

  })

  .when('/reports/medical-services/property-equipment', {

    templateUrl: 'angularjs/views/reports/medical-services/property-equipment.ctp',

    controller: 'PropertyEquimentReportController',

  })

  .when('/reports/medical-services/consultation', {

    templateUrl: 'angularjs/views/reports/medical-services/consultation.ctp',

    controller: 'ConsultationReportController',

  })

  .when('/reports/medical-services/consultation-employee', {

    templateUrl: 'angularjs/views/reports/medical-services/consultation-employee.ctp',

    controller: 'ConsultationEmployeeReportController',

  })

  .when('/reports/medical-services/employee-frequency', {

    templateUrl: 'angularjs/views/reports/medical-services/employee-frequency.ctp',

    controller: 'EmployeeFrequencyReportController',

  })

});