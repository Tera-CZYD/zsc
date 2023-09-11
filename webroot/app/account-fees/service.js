 app.factory("AccountFee", function($resource) {

  return $resource( api + "account_fees/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
