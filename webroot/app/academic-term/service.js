 app.factory("AcademicTerm", function($resource) {

  return $resource( api + "academic_terms/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
