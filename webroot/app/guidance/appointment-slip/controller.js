app.controller('AppointmentSlipAddController', function($scope, AppointmentSlip, Select) {

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

  $scope.data = {

    AppointmentSlip : {}

  };

  Select.get({code: 'appointment-slip-code'}, function(e) {

    $scope.data.AppointmentSlip.code = e.data;

  })

   Select.get({code: 'course-list'}, function(e) {

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

  $scope.selectedStudent = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name 

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.AppointmentSlip.student_id = $scope.student.id;

    $scope.data.AppointmentSlip.student_no = $scope.student.code;

    $scope.data.AppointmentSlip.student_name = $scope.student.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      AppointmentSlip.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/referral-slip';

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

app.controller('AppointmentSlipViewController', function($scope, $routeParams, AppointmentSlip) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    AppointmentSlip.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.print = function(id){
  
    printTable(base + 'print/appointment_slip/'+id);

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        AppointmentSlip.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/guidance/referral-slip";

          }

        });

      }

    });

  } 

});

app.controller('AppointmentSlipEditController', function($scope, $routeParams, AppointmentSlip, Select) {
  
  $scope.id = $routeParams.id;


  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });


  // load 
  $scope.load = function() {

    AppointmentSlip.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  Select.get({code: 'course-list'}, function(e) {

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

  $scope.selectedStudent = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name 

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.AppointmentSlip.student_id = $scope.student.id;

    $scope.data.AppointmentSlip.student_no = $scope.student.code;

    $scope.data.AppointmentSlip.student_name = $scope.student.name;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AppointmentSlip.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/referral-slip';

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