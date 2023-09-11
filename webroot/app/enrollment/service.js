 app.factory("StudentEnrollment", function($resource) {

  return $resource( api + "student_enrollments/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
