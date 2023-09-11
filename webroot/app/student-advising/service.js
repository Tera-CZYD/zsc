 app.factory("StudentAdvising", function($resource) {

  return $resource( api + "student_advisings/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
