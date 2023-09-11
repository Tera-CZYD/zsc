 app.factory("ListStudent", function($resource) {

  return $resource( api + "reports/list_students/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("ListScholar", function($resource) {

  return $resource( api + "Reports/list_scholars/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("ListApplicant", function($resource) {

  return $resource( api + "Reports/list_applicants/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("ScholarshipEvaluation", function($resource) {

  return $resource( api + "reports/scholarship_evaluations/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});