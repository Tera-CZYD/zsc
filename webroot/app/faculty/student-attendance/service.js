 app.factory("StudentAttendance", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "student-attendances/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("StudentAttendanceViewDetail", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "student-attendances/view_attendance/:id/:sub_id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

// app.factory("GradeSubmitMidterm", function($resource) {

//   return $resource( api + "grades/submit_midterm/:id", { id: '@id' }, {

//     query: { method: 'GET', isArray: false },

//     update: { method: 'PUT' },

//     search: { method: 'GET' },

//   });

// }); 

// app.factory("GradeSubmitFinalTerm", function($resource) {

//   return $resource( api + "grades/submit_finalterm/:id", { id: '@id' }, {

//     query: { method: 'GET', isArray: false },

//     update: { method: 'PUT' },

//     search: { method: 'GET' },

//   });

// });
