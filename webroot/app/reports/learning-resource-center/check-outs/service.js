 app.factory("ReportCheckOut", function($resource) {

  return $resource( api + "Reports/list_checkouts/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});