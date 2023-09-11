app.controller('StudentAdvisingController', function($scope, StudentAdvising) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentAdvising.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();

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

    bootbox.confirm('Are you sure you want to remove '+ data.curriculum +' ?', function(c) {

      if (c) {

        StudentAdvising.remove({ id: data.id }, function(e) {

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

app.controller('StudentAdvisingAddController', function($scope, StudentAdvising, Select) {

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('#form').validationEngine('attach');

   $scope.load = function() {

    StudentAdvising.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

   Select.get({code: 'curriculum'}, function(e) {

    $scope.curriculum = e.data;

  })

   Select.get({code: 'academic_term'}, function(e) {

    $scope.academic_term = e.data;

  })

   Select.get({code: 'course'}, function(e) {

    $scope.course = e.data;

  })
  
   $scope.searchStudent = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-student';

    Select.query(options, function(e) {

      $scope.students = e.data.result;

      $scope.student = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal('show');

    });

  }

  $scope.selected = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.code + ' - ' + student.name 

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.StudentAdvising.student_id = $scope.student.id;

    $scope.data.StudentAdvising.student_name = $scope.student.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentAdvising.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/student-advising';

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

app.controller('StudentAdvisingViewController', function($scope, $routeParams, StudentAdvising) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    StudentAdvising.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.student_name +' ?', function(c) {

      if (c) {

        StudentAdvising.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/student-advising";

          }

        });

      }

    });

  } 

});

app.controller('StudentAdvisingEditController', function($scope, $routeParams, StudentAdvising, Select) {
  
  $scope.id = $routeParams.id;


  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });


  // load 
  $scope.load = function() {

    StudentAdvising.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  Select.get({code: 'curriculum'}, function(e) {

    $scope.curriculum = e.data;

  })

  Select.get({code: 'academic_term'}, function(e) {

    $scope.academic_term = e.data;

  })

  Select.get({code: 'course'}, function(e) {

    $scope.course = e.data;

  })

  $scope.searchStudent = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-student';

    Select.query(options, function(e) {

      $scope.students = e.data.result;

      $scope.student = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal('show');

    });

  }

  $scope.selected = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.code + ' - ' + student.name 

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.StudentAdvising.student_id = $scope.student.id;

    $scope.data.StudentAdvising.student_name = $scope.student.name;

  }

  $scope.load();

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentAdvising.save({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/student-advising';

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