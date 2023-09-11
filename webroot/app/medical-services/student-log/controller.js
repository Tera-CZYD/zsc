app.controller('StudentLogController', function($scope, StudentLog) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {
 
    options = typeof options !== 'undefined' ?  options : {};

    StudentLog.query(options, function(e) {

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
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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

    bootbox.confirm('Are you sure you want to delete ' + data.student_name +' ?', function(c) {

      if (c) {

        StudentLog.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/student_log?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_log?print=1');

    }

  }

});

app.controller('StudentLogAddController', function($scope, StudentLog, Select) {

 $('#form').validationEngine('attach');

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

  $scope.data = {

    StudentLog : {}

  }

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.StudentLog.employee_id = null;

      $scope.data.StudentLog.employee_name = null;

    }else{

      $scope.data.StudentLog.student_id = null;

      $scope.data.StudentLog.student_name = null;

    }

  }

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentLog.student_id = $scope.student.id;

    $scope.data.StudentLog.student_name = $scope.student.name;

    $scope.data.StudentLog.student_no = $scope.student.code;

  };

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.StudentLog.employee_id = $scope.employee.id;

    $scope.data.StudentLog.employee_no = $scope.employee.code;

    $scope.data.StudentLog.employee_name = $scope.employee.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentLog.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/student-log';

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

app.controller('StudentLogViewController', function($scope, $routeParams, StudentLog) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    StudentLog.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.student_name +' ?', function(c) {

      if (c) {

        StudentLog.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/medical-services/student-log";

          }

        });

      }

    });

  } 

});

app.controller('StudentLogEditController', function($scope, $routeParams, StudentLog, Select) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

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

  $scope.data = {

    StudentLog : {}

  }

  // load 

  $scope.load = function() {

    StudentLog.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.StudentLog.employee_id = null;

      $scope.data.StudentLog.employee_name = null;

    }else{

      $scope.data.StudentLog.student_id = null;

      $scope.data.StudentLog.student_name = null;

    }

  }

  $scope.searchStudent = function (options) {


    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentLog.student_id = $scope.student.id;

    $scope.data.StudentLog.student_name = $scope.student.name;

    $scope.data.StudentLog.student_no = $scope.student.code;

  };

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.StudentLog.employee_id = $scope.employee.id;

    $scope.data.StudentLog.employee_no = $scope.employee.code;

    $scope.data.StudentLog.employee_name = $scope.employee.name;

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentLog.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/student-log';

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

app.controller('StudentStudentLogController', function($scope, StudentLog) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {
 
    options = typeof options !== 'undefined' ?  options : {};
    options['per_student'] = 1;
    StudentLog.query(options, function(e) {

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
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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

    bootbox.confirm('Are you sure you want to delete ' + data.student_name +' ?', function(c) {

      if (c) {

        StudentLog.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/student_log?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_log?print=1');

    }

  }

});

app.controller('StudentStudentLogAddController', function($scope, StudentLog, Select) {

 $('#form').validationEngine('attach');

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

  $scope.data = {

    StudentLog : {}

  }

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.StudentLog.employee_id = null;

      $scope.data.StudentLog.employee_name = null;

    }else{

      $scope.data.StudentLog.student_id = null;

      $scope.data.StudentLog.student_name = null;

    }

  }

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentLog.student_id = $scope.student.id;

    $scope.data.StudentLog.student_name = $scope.student.name;

    $scope.data.StudentLog.student_no = $scope.student.code;

  };

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.StudentLog.employee_id = $scope.employee.id;

    $scope.data.StudentLog.employee_no = $scope.employee.code;

    $scope.data.StudentLog.employee_name = $scope.employee.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentLog.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/student-log/student-index';

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

app.controller('StudentStudentLogViewController', function($scope, $routeParams, StudentLog) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    StudentLog.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.student_name +' ?', function(c) {

      if (c) {

        StudentLog.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/medical-services/student-log/student-index";

          }

        });

      }

    });

  } 

});

app.controller('StudentStudentLogEditController', function($scope, $routeParams, StudentLog, Select) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

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

  $scope.data = {

    StudentLog : {}

  }

  // load 

  $scope.load = function() {

    StudentLog.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.StudentLog.employee_id = null;

      $scope.data.StudentLog.employee_name = null;

    }else{

      $scope.data.StudentLog.student_id = null;

      $scope.data.StudentLog.student_name = null;

    }

  }

  $scope.searchStudent = function (options) {


    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.StudentLog.student_id = $scope.student.id;

    $scope.data.StudentLog.student_name = $scope.student.name;

    $scope.data.StudentLog.student_no = $scope.student.code;

  };

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.StudentLog.employee_id = $scope.employee.id;

    $scope.data.StudentLog.employee_no = $scope.employee.code;

    $scope.data.StudentLog.employee_name = $scope.employee.name;

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentLog.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/student-log/student-index';

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