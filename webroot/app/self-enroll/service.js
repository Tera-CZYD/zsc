 app.factory("PreregistrationSubject", function($resource) {

  return $resource( api + "preregistration_subjects/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
