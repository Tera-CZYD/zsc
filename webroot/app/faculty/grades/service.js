 app.factory("Grade", function($resource) {

  return $resource( api + "grades/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("GradeUpdate", function($resource) {

  return $resource( api + "Grades/grade_update/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("GradeSubmitMidterm", function($resource) {

  return $resource( api + "Grades/submit_midterm/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("GradeSubmitFinalTerm", function($resource) {

  return $resource( api + "Grades/submit_finalterm/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});


app.factory("GradeSubmitSingleMidterm", function($resource) {

  return $resource( api + "Grades/submit_single_midterm/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("GradeSubmitSingleFinalTerm", function($resource) {

  return $resource( api + "Grades/submit_single_finalterm/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
