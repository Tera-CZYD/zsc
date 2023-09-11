app.controller('CounselingIntakeController', function($scope, CounselingIntake) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    CounselingIntake.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();

  $scope.reload = function(options) {
  
    $scope.search = {};

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

    bootbox.confirm('Are you sure you want to remove '+ data.full_name +' ?', function(c) {

      if (c) {

        CounselingIntake.remove({ id: data.id }, function(e) {

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

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/counseling_intake?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/counseling_intake?print=1');

    }

  }

});

app.controller('CounselingIntakeAddController', function($scope, CounselingIntake, Select) {

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $('#form').validationEngine('attach');

   $scope.load = function() {

    CounselingIntake.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  // Select.get({code: 'course-list'}, function(e) {

  //   $scope.course = e.data;

  // });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });
 
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

  $scope.selectedStudent = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.code + ' - ' + student.name,

      date_of_birth : student.date_of_birth

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.CounselingIntake.student_id = $scope.student.id;

    $scope.data.CounselingIntake.student_name = $scope.student.name;

    $scope.data.CounselingIntake.birth_date = $scope.student.date_of_birth;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      CounselingIntake.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/counseling-intake';

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

app.controller('CounselingIntakeViewController', function($scope, $routeParams, CounselingIntake) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    CounselingIntake.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  
  $scope.print = function(id){
    // console.log(id);
    printTable(base + 'print/counseling_intake_form/'+id);

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.student_name +' ?', function(c) {

      if (c) {

        CounselingIntake.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/guidance/counseling-intake";

          }

        });

      }

    });

  } 

});

app.controller('CounselingIntakeEditController', function($scope, $routeParams, CounselingIntake, Select) {
  
  $scope.id = $routeParams.id;


  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $('#form').validationEngine('attach');

   $scope.load = function() {

    CounselingIntake.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  // Select.get({code: 'course-list'}, function(e) {

  //   $scope.course = e.data;

  // });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

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

      name : student.code + ' - ' + student.name,

      date_of_birth : student.date_of_birth

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.ReferralSlip.student_id = $scope.student.id;

    $scope.data.ReferralSlip.student_name = $scope.student.name;

    $scope.data.CounselingIntake.birth_date = $scope.student.date_of_birth;

  }

  $scope.load();

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      CounselingIntake.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/counseling-intake';

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