app.factory("Memorandum", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "memorandums/:id", { id: '@id', search: '@search' }, {

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

        memorandumImage = document.getElementById('memorandumImage');

        if (memorandumImage != null && memorandumImage.files.length > 0)

        var count = memorandumImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', memorandumImage.files[i]);

        }

        return formData;

      }

    },

    search: { method: 'GET' },

  });

});

app.factory("MemorandumImage", function($resource) {

  return $resource( api + "memorandum-images/add/:id", { id: '@id' }, {

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

        memorandumImage = document.getElementById('memorandumImage');

        if (memorandumImage != null && memorandumImage.files.length > 0)

        var count = memorandumImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', memorandumImage.files[i]);

        }

        return formData;

      }

    }

  });

});

app.factory("MemorandumRemoveImage", function($resource) {

  return $resource( api + "memorandums/deleteImage/:id", { id: '@id' }, {

  });

});

app.factory("MemorandumApprove", function($resource) {

  return $resource( api + "memorandums/approve/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("MemorandumDisapproved", function($resource) {

  return $resource( api + "memorandums/disapprove/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
