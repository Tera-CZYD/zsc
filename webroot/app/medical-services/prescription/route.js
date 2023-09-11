app.config(function($routeProvider) {

    $routeProvider
  
    .when('/medical-services/prescription', {
  
      templateUrl: 'angularjs/views/medical-services/prescription/index.ctp',
  
      controller: 'PrescriptionController',
  
    })
  
    .when('/medical-services/prescription/add', {
  
      templateUrl: 'angularjs/views/medical-services/prescription/add.ctp',
  
      controller: 'PrescriptionAddController',
  
    })
  
    .when('/medical-services/prescription/edit/:id', {
  
      templateUrl: 'angularjs/views/medical-services/prescription/edit.ctp',
  
      controller: 'PrescriptionEditController',
  
    })
  
    .when('/medical-services/prescription/view/:id', {
  
      templateUrl: 'angularjs/views/medical-services/prescription/view.ctp',
  
      controller: 'PrescriptionViewController',
  
    });
    
  });