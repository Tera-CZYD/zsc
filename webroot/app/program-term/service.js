 app.factory("ProgramTerm", function($resource) {

  return $resource( api + "program_terms/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
