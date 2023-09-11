app.controller('CollegeDepartmentProgramController', function($scope, CollegeDepartmentProgram) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    CollegeDepartmentProgram.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();
  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search: search

      });

    }else{

      $scope.load();
    
    }

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.college_id +' ?', function(c) {

      if (c) {

        CollegeDepartmentProgram.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,
 		
            });

            $scope.load();

          }

        });

      }

    });

  }

});

app.controller('CollegeDepartmentProgramAddController', function($scope, CollegeDepartmentProgram, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({code: 'second-college-department-list'}, function(e) {

    $scope.college_departments = e.data;

  });

  Select.get({code: 'curriculum-list'}, function(e) {

    $scope.curriculums = e.data;

  });

  Select.get({code: 'program-list'}, function(e) {

    $scope.college_programs = e.data;

  });

  $scope.load = function() {

    CollegeDepartmentProgram.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      CollegeDepartmentProgram.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/college-department-program';

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

app.controller('CollegeDepartmentProgramViewController', function($scope, $routeParams, CollegeDepartmentProgram) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    CollegeDepartmentProgram.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.college_program_id +' ?', function(c) {

      if (c) {

        CollegeDepartmentProgram.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/college-department-program";

          }

        });

      }

    });

  } 

});

app.controller('CollegeDepartmentProgramEditController', function($scope, $routeParams, CollegeDepartmentProgram, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({code: 'second-college-department-list'}, function(e) {

    $scope.college_departments = e.data;

  });

  Select.get({code: 'curriculum-list'}, function(e) {

    $scope.curriculums = e.data;

  });

  Select.get({code: 'program-list'}, function(e) {

    $scope.college_programs = e.data;

  });

  // load 
  
  $scope.load = function() {

    CollegeDepartmentProgram.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      CollegeDepartmentProgram.save({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/college-department-program';

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