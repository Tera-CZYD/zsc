 app.factory("CourseSchedule", function($resource) {

  return $resource( api + "course_schedules/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
