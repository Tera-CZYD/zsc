app.factory("StudentApplicant", function($resource) {

  return $resource( api + "student_applicants/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("StudentApplicantAdmit", function($resource) {

  return $resource( api + "student_applicants/admit/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("ImportUpload", function($resource) {

  return $resource( api + "import_uploads/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("ImportUploadCheckData", function($resource) {

  return $resource( api + "import_uploads/check/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("ImportUploadSave", function($resource) {

  return $resource( api + "import_uploads/import/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});

app.factory("StudentApplicantImport", function($resource) {

  return $resource( api + "student_applicant_imports/:id", { id: '@id' }, {

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

        excel = document.getElementById('excel');

        if (excel != null && excel.files.length > 0)

        var count = excel.files.length - 1;

        for(var i = 0; i <= count ; i++){

          formData.append('attachment[]', excel.files[i]);

        }

        return formData;

      }

    }

  });

});
