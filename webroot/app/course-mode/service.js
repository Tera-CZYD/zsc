 app.factory("CourseMode", function($resource) {

  return $resource( api + "course_modes/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
