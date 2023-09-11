 app.factory("FacultyQce", function($resource) {

  return $resource( api + "faculty_qces/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
