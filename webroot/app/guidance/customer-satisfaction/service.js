app.factory("CustomerSatisfaction", function($resource) {

  return $resource( api + "customer_satisfactions/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

