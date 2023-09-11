app.config(['$routeProvider',function($routeProvider) {
  
  $routeProvider
  
    .when('/major', {
      
      templateUrl: 'angularjs/views/major/index.ctp',
      
      controller: 'MajorController',
      
    })
    

    .when('/major/add', {
      
      templateUrl: 'angularjs/views/major/add.ctp',
      
      controller: 'MajorAddController',
      
    })
    

    .when('/major/edit/:id', {
      
      templateUrl: 'angularjs/views/major/edit.ctp',
      
      controller: 'MajorEditController',
      
    });
    

}]);