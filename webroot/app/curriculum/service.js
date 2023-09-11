 app.factory("Curriculum", function($resource) {

  return $resource( api + "curriculums/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumCourse", function($resource) {

  return $resource( api + "curriculums/course", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumCourseUpdate", function($resource) {

  return $resource( api + "curriculums/course_update/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumCourseView", function($resource) {

  return $resource( api + "curriculums/course_view/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumCourseDelete", function($resource) {

  return $resource( api + "curriculums/course_delete", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumYearLevelTermLoad", function($resource) {

  return $resource( api + "curriculums/year_level_term_load", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumLock", function($resource) {

  return $resource( api + "curriculums/lock/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumUnlock", function($resource) {

  return $resource( api + "curriculums/unlock/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumActivate", function($resource) {

  return $resource( api + "curriculums/activate/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("CurriculumDeactivate", function($resource) {

  return $resource( api + "curriculums/deactivate/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});