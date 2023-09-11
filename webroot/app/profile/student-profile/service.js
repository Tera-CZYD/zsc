app.factory("Student", function($resource) {

    return $resource( api + "students/:id", { id: '@id', search: '@search' }, {
  
      query: { method: 'GET', isArray: false },
  
      update: { method: 'PUT' },
  
      search: { method: 'GET' },
  
    });
  
  });
  