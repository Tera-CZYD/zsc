app.factory("Dental", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;
  
  return $resource( api + "dentals/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: {

      method: 'PUT',

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

        dentalImage = document.getElementById('dentalImage');

        if (dentalImage != null && dentalImage.files.length > 0)

        var count = dentalImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', dentalImage.files[i]);

        }

        return formData;

      }

    },

    search: { method: 'GET' },

  });

});

app.factory("DentalTreated", function($resource) {

  return $resource( api + "Dentals/treated/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("DentalDisapprove", function($resource) {

  return $resource( api + "Dentals/disapprove/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("DentalApprove", function($resource) {

  return $resource( api + "Dentals/approve/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("DentalReferred", function($resource) {

  return $resource( api + "Dentals/referred/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("DentalImage", function($resource) {

  return $resource( api + "DentalImages/add/:id", { id: '@id' }, {

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

        dentalImage = document.getElementById('dentalImage');

        if (dentalImage != null && dentalImage.files.length > 0)

        var count = dentalImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', dentalImage.files[i]);

        }

        return formData;

      }

    }

  });

});

app.factory("DentalRemoveImage", function($resource) {

  return $resource( api + "Dentals/deleteImage/:id", { id: '@id' }, {

  });

});


