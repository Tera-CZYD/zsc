app.config(function($routeProvider) {

    $routeProvider
  
    .when('/medical-services/prescription', {
  
      templateUrl: tmp + 'medical_services__prescription__index',
  
      controller: 'PrescriptionController',
  
    })
  
    .when('/medical-services/prescription/add', {
  
      templateUrl: tmp + 'medical_services__prescription__add',
  
      controller: 'PrescriptionAddController',
  
    })
  
    .when('/medical-services/prescription/edit/:id', {
  
      templateUrl: tmp + 'medical_services__prescription__edit',
  
      controller: 'PrescriptionEditController',
  
    })
  
    .when('/medical-services/prescription/view/:id', {
  
      templateUrl: tmp + 'medical_services__prescription__view',
  
      controller: 'PrescriptionViewController',
  
    });
    
  });