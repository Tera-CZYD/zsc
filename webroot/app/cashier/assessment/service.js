 app.factory("Assessment", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "assessments/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

//  app.factory("CashierSub", function($resource, $http) {

//   var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
//   $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

//   return $resource( api + 'cashier_subs/:id', {id:'@id'}, {

//     query: { method: 'GET', isArray: false },

//     update: { method: 'PUT' }

//   });

// });


 app.factory("AssessmentApprove", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "Assessments/approve/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

 