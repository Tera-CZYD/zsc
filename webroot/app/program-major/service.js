 app.factory("ProgramMajor", function($resource) {

  return $resource( api + "program_majors/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
