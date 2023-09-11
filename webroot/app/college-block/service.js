 app.factory("CollegeBlock", function($resource) {

  return $resource( api + "college_blocks/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
