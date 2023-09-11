app.controller('PermissionsController', function($scope, Permission) {

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Permission.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        //pagination

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();

  //search

  $scope.search = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0) $scope.load({

      search: search

    });

    else $scope.load();

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove this permission?', function(c) {

      if (c) {

        Permission.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load();

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

            $scope.load();

          }

        });

      }

    });

  } 

});

app.controller('PermissionsAddController',function($scope, Permission,Select) {

  $('#form').validationEngine('attach');

  Select.get({ code: 'user-logs-permission'}, function(e) {});

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Permission.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/permissions';

        } else if(e.exists){

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }

  }

});

app.controller('PermissionsEditController',function($scope, Permission, $routeParams,Select) {

  $('#form').validationEngine('attach');

  Select.get({ code: 'user-logs-permission-edit'}, function(e) {});

  $scope.id = $routeParams.id;

  $scope.load = function() {

    Permission.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Permission.update({ id: $routeParams.id },$scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/permissions';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }

  }

});