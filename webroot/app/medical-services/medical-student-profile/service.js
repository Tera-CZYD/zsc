 app.factory("MedicalStudentProfile", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "medical-student-profiles/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: {

      method: 'PUT'

    },

    save: {

      method: 'POST',

      headers: { 'Content-Type': undefined, enctype: 'multipart/form-data' },

      transformRequest: function(data) {

        // transform data

        var formData = new FormData();

        attachment = [];

        formData.append('data', JSON.stringify(data));

        // attach file

        applicationImage = document.getElementById('applicationImage');

        if (applicationImage != null && applicationImage.files.length > 0)

        var count = applicationImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', applicationImage.files[i]);

        }

        return formData;

      }

    },

    search: { method: 'GET' },

  });

});

app.factory("MedicalStudentProfileImage", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "MedicalStudentProfileImages/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT'},

    save: {

      method: 'POST',
      
      headers: { 'Content-Type': undefined, enctype: 'multipart/form-data' },

      transformRequest: function(data) {

        // transform data

        var formData = new FormData();

        attachment = [];

        formData.append('data', JSON.stringify(data));

        // attach file

        applicationImage = document.getElementById('applicationImage');

        if (applicationImage != null && applicationImage.files.length > 0)

        var count = applicationImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', applicationImage.files[i]);

        }

        return formData;

      }

    }

  });

});

app.factory("MedicalStudentProfileImageRemove", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "MedicalStudentProfiles/deleteImage/:id", { id: '@id' }, {

  });

});
