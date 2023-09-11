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

});