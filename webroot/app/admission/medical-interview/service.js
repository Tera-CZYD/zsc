 app.factory("MedicalInterview", function($resource) {

  return $resource( api + "medical_interviews/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});