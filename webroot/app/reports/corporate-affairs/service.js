 app.factory("MonthlyPayment", function($resource) {

  return $resource( api + "reports/apartelle-monhtly-payments/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});