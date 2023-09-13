 app.factory("ListBibliography", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken; 

  return $resource( api + "reports/list_bibliographies/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});