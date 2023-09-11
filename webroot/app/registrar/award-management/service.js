app.factory("AwardManagement", function($resource) {

  return $resource( api + "award_managements/:id", { id: '@id' }, {

    query: { method: 'GET', isArray: false },

    update: { method: 'PUT' },

    search: { method: 'GET' },

  });

});