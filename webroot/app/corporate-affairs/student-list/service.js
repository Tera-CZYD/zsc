 app.factory("StudentList", function($resource) {

  return $resource( api + "ApartelleRegistrations/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

 app.factory("StudentListEmail", function($resource) {

  return $resource( api + "StudentApplications/email/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

