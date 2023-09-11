app.config(function($routeProvider) {

    $routeProvider
  
    .when('/faculty/faculty-clearance', {
  
      templateUrl: 'angularjs/views/faculty/faculty-clearance/index.ctp', 
  
      controller: 'FacultyClearanceController',
  
    })
  
   .when('/faculty/faculty-clearance/add', {
  
     templateUrl: 'angularjs/views/faculty/faculty-clearance/add.ctp',
  
    controller: 'FacultyClearanceAddController',
  
   })
  
   .when('/faculty/faculty-clearance/edit/:id', {
  
     templateUrl: 'angularjs/views/faculty/faculty-clearance/edit.ctp',
  
     controller: 'FacultyClearanceEditController',
  
    })
  
   .when('/faculty/faculty-clearance/view/:id', {
  
      templateUrl: 'angularjs/views/faculty/faculty-clearance/view.ctp',
  
      controller: 'FacultyClearanceViewController',
  
    });
  
  });
  
  
  