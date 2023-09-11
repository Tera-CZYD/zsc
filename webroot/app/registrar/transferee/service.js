app.factory("Transferee", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "transferees/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    save: {

      method: 'POST',

      headers: { 'Content-Type': undefined, enctype: 'multipart/form-data' },

      transformRequest: function(data) {

        // transform data

        var formData = new FormData();

        attachment = [];

        formData.append('data', JSON.stringify(data));

        // attach file

        transfereeImage = document.getElementById('transfereeImage');

        if (transfereeImage != null && transfereeImage.files.length > 0)

        var count = transfereeImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', transfereeImage.files[i]);

        }

        return formData;

      }

    },

    search: { method: 'GET' },

  });

});

app.factory("TransfereeImage", function($resource) {

  return $resource( api + "transferee-images/:id", { id: '@id' }, {

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

        transfereeImage = document.getElementById('transfereeImage');

        if (transfereeImage != null && transfereeImage.files.length > 0)

        var count = transfereeImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', transfereeImage.files[i]);

        }

        return formData;

      }

    }

  });

});

app.factory("TransfereeRemoveImage", function($resource) {

  return $resource( api + "transferees/deleteImage/:id", { id: '@id' }, {

  });

});

app.factory("TransfereeApprove", function($resource) {

  return $resource( api + "transferees/approve/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("TransfereeDisapproved", function($resource) {

  return $resource( api + "transferees/disapprove/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
