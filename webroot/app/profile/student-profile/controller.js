

app.controller('StudentViewController', function($scope, $routeParams, Student) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Student.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

});

app.controller('StudentEditController', function($scope, $routeParams, Student, Select) {
  
  $scope.id = $routeParams.id;

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });
 

  $scope.data = {

    Student : {}

  }


  // load 

  $scope.load = function() {

    Student.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

 

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Student.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/profile/student-profile/view-profile/' + $scope.id;

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