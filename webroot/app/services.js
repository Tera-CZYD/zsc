app.factory("Select", function($resource) {

  return $resource( api + 'select', {}, { 

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });
  
});

app.factory("Register", function($resource) {

  return $resource( api + 'register', {}, { 

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});

app.factory("ForgotPassword", function($resource) {

  return $resource( api + 'forgot_password', {}, { 

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});

app.factory("RetrievePassword", function($resource) {

  return $resource( api + 'retrieve_password', {}, { 

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});

app.factory("Application", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "application/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: {

      method: 'POST',

      headers: { 'Content-Type': undefined, enctype: 'multipart/form-data' },

      transformRequest: function(data) {
        
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

app.factory("ChangeProgram", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + 'ChangePrograms/add/:id', {}, { 

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});

app.factory("MobileLogin", function($resource) {

  return $resource( api + 'mobile_login', {}, { 

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});
