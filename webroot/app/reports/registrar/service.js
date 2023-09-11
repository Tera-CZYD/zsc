app.factory("CollegeProgramReport", function($resource) {

  return $resource( api + "reports/subject_masterlists/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("EnrollmentListReport", function($resource) {

  return $resource( api + "Reports/enrollment_list/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("ListStudent", function($resource) {

  return $resource( api + "reports/student_masterlist/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("StudentRanking", function($resource) {

  return $resource( api + "reports/student_ranking/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("PromotedStudent", function($resource) {

  return $resource( api + "reports/promoted_student/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("StudentBehaviorReport", function($resource) {

  return $resource( api + "Reports/student_behavior/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("AcademicFailuresList", function($resource) {

  return $resource( api + "Reports/academic_failures_list/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("StudentClubList", function($resource) {

  return $resource( api + "reports/student_club_list/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});


app.factory("AcademicList", function($resource) {

  return $resource( api + "reports/academic_list/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});


app.factory("ListAcademicAwardee", function($resource) {

  return $resource( api + "reports/list_academic_awardees/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("GWA", function($resource) {

  return $resource( api + "reports/gwa/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("EnrollmentProfile", function($resource) {

  return $resource( api + "Reports/enrollment_profile/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

