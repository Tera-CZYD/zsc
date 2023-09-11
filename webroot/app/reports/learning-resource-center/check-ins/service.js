 app.factory("ListCheckIn", function($resource) {

  return $resource( api + "reports/list_checkins/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});