 app.factory("CourseTypeReference", function($resource) {

  return $resource( api + "course_type_references/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
