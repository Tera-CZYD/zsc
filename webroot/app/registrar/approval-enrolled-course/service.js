 app.factory("ApprovalEnrolledCourse", function($resource) {

  return $resource( api + "approval_enrolled_courses/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

 app.factory("ApprovalEnrolledCourseApproved", function($resource) {

  return $resource( api + "approval_enrolled_courses/approve/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});