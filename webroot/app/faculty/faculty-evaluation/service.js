app.factory("FacultyEvaluation", function($resource) {

  return $resource( api + "faculty_evaluations/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

