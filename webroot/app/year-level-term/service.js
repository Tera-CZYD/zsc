 app.factory("YearLevelTerm", function($resource) {

  return $resource( api + "year_level_terms/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
