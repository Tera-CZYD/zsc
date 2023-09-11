app.factory("User", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;
  
  return $resource( api + "users/:id", { id: '@id' }, {
  
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

    }

  });

});

app.factory("UserPermission", function($resource) {

  return $resource( api + 'UserPermissions/add/:id', {id:'@id'}, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});

app.factory("UserPermissionDelete", function($resource) {

  return $resource( api + 'UserPermissions/delete/:id', {id:'@id'}, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});



app.factory("DeleteSelected", function($resource) {

  return $resource( api + 'UserPermissions/deleteSelected/:id', {id:'@id'}, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' }

  });

});



