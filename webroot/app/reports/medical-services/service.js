app.factory("MedicalMonthlyAccomplishment", function($resource) {

  return $resource( api + "reports/medical_monthly_accomplishment/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("MedicalMonthlyConsumption", function($resource) {

  return $resource( api + "reports/medical_monthly_consumption/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("DailyTreatment", function($resource) {

  return $resource( api + "reports/medical_daily_treatments/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});

app.factory("PropertyEquipmentReport", function($resource) {

  return $resource( api + "reports/medical_property_equipment/:id", { id: '@id', search: '@search' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },
    
  });

});