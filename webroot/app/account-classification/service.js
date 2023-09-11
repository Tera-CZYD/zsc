 app.factory("AccountClassification", function($resource) {

  return $resource( api + "account_classifications/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
