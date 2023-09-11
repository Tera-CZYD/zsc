 app.factory("CollegeDepartmentProgram", function($resource) {

  return $resource( api + "college_department_programs/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
