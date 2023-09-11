app.factory("StudentApartelle", function($resource) {

  return $resource( api + "apartelles/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: {

      method: 'POST',

      headers: { 'Content-Type': undefined, enctype: 'multipart/form-data' },

      transformRequest: function(data) {

        // transform data

        var formData = new FormData();

        attachment = [];

        formData.append('data', JSON.stringify(data));

        // attach file

        apartelleImage = document.getElementById('apartelleImage');

        if (apartelleImage != null && apartelleImage.files.length > 0)

        var count = apartelleImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', apartelleImage.files[i]);

          console.log(apartelleImage.files[i]);

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

        apartelleImage = document.getElementById('apartelleImage');

        if (apartelleImage != null && apartelleImage.files.length > 0)

        var count = apartelleImage.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', apartelleImage.files[i]);

          console.log(apartelleImage.files[i]);

        }

          return formData;

      }

    }

  });

});

