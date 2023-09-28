app.factory("Announcement", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;

  return $resource( api + "announcements/:id", { id: '@id', search: '@search' }, {

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

        announcementImage = document.getElementById('announcementImage');

        if (announcementImage != null && announcementImage.files.length > 0)

        var count = announcementImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', announcementImage.files[i]);

        }

        return formData;

      }

    },

    search: { method: 'GET' },

  });

});

app.factory("AnnouncementImage", function($resource) {

  return $resource( api + "announcement-images/add/:id", { id: '@id' }, {

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

        announcementImage = document.getElementById('announcementImage');

        if (announcementImage != null && announcementImage.files.length > 0)

        var count = announcementImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', announcementImage.files[i]);

        }

        return formData;

      }

    }

  });

});

app.factory("AnnouncementRemoveImage", function($resource) {

  return $resource( api + "announcements/deleteImage/:id", { id: '@id' }, {

  });

});

app.factory("AnnouncementApprove", function($resource) {

  return $resource( api + "announcements/approve/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("AnnouncementDisapproved", function($resource) {

  return $resource( api + "announcements/disapprove/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});
