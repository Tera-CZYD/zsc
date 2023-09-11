 app.factory("CourseLevel", function($resource) {

  return $resource( api + "course_levels/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
