 app.factory("ListBibliography", function($resource) {

  return $resource( api + "reports/list_bibliographies/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});