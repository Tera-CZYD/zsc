app.factory("AffidavitOfLoss", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "affidavit-of-losses/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: {
      
      method: 'POST',
  
      headers: { 'Content-Type': undefined, enctype: 'multipart/form-data' },
  
      transformRequest: function(data) {
    
        $data = data;
        
        var formData = new FormData();

        formData.append('data', JSON.stringify($data));

        // attach file

        fileImage = document.getElementById('fileImage');

        if (fileImage != null && fileImage.files.length > 0)

          formData.append('file', fileImage.files[0]);      

        return formData;

      }

    },

    save: {

      method: 'POST',

      headers: { 'Content-Type': undefined, enctype: 'multipart/form-data' },

      transformRequest: function(data) {
        
        $data = data;
        
        var formData = new FormData();

        formData.append('data', JSON.stringify($data));
    
        // attach file

        fileImage = document.getElementById('fileImage');

        if (fileImage != null && fileImage.files.length > 0)

          formData.append('file', fileImage.files[0]);     
        
        return formData;
      }

    },

    search: { method: 'GET' }, 

  });

});

app.factory("AffidavitOfLossApprove", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "AffidavitOfLosses/approve/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("AffidavitOfLossDisapprove", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "AffidavitOfLosses/disapprove/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

