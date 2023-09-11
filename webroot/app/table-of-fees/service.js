 app.factory("TableOfFee", function($resource) {

  return $resource( api + "table_of_fees/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
