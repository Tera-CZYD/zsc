app.factory("Backup", function($resource, $http) {

  var csrfToken = angular.element(document.querySelector('meta[name="csrf-token"]')).attr('content');
  
  $http.defaults.headers.common['X-CSRF-Token'] = csrfToken;
  return $resource( api + 'backups/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});

app.factory("BackupExport", function($resource) {
  return $resource( api + 'Backups/export/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});