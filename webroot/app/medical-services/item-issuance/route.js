app.config(function($routeProvider) {

    $routeProvider
  
    .when('/medical-services/item-issuance', {
  
      templateUrl: 'angularjs/views/medical-services/item-issuance/index.ctp',
  
      controller: 'ItemIssuanceController',
  
    })
  
    .when('/medical-services/item-issuance/add', {
  
      templateUrl: 'angularjs/views/medical-services/item-issuance/add.ctp',
  
      controller: 'ItemIssuanceAddController',
  
    })
  
    .when('/medical-services/item-issuance/edit/:id', {
  
      templateUrl: 'angularjs/views/medical-services/item-issuance/edit.ctp',
  
      controller: 'ItemIssuanceEditController',
  
    })
  
    .when('/medical-services/item-issuance/view/:id', {
  
      templateUrl: 'angularjs/views/medical-services/item-issuance/view.ctp',
  
      controller: 'ItemIssuanceViewController',
  
    });
    
  });