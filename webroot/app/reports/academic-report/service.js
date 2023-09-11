 app.factory("FacultyMasterlist", function($resource) {

  return $resource( api + "reports/faculty_masterlists/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});