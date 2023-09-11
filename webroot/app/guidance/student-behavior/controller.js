app.controller('StudentBehaviorController', function($scope, StudentBehavior,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom',

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentBehavior.query(options, function(e) {
      
      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();

  $scope.getFinal = function(){

    $scope.load({

      program_id: $scope.program_id,

      year: $scope.year,

    });

  }


  $scope.getData = function(program_id){

    $scope.load({

      program_id: $scope.program_id,

      year_term_id: $scope.year_term_id,

    });

  }

  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.year_term_id = null;

    $scope.program_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search        : search,

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        year_term_id  : $scope.year_term_id,

        program_id  : $scope.program_id,

      });

    }else{

      $scope.load({

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        year_term_id  : $scope.year_term_id,

         program_id  : $scope.program_id,

      });
    
    }

  }

  $scope.advance_search = function() {

    $scope.search = {};

    $scope.advanceSearch = false;
 
    $scope.position_id = null;
 
    $scope.office_id = null;

    $('.monthpicker').datepicker({

      format: 'MM',

      autoclose: true,

      minViewMode: 'months',

      maxViewMode: 'months'

    });

    $('.input-daterange').datepicker({

      format: 'yyyy-mm-dd'

    });

    $('.datepicker').datepicker('setDate', '');

    $('.monthpicker').datepicker('setDate', '');

    $('.input-daterange').datepicker('setDate', '');

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.searchTxt = '';

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    if (search.filterBy == 'today') {

      $scope.dateToday = Date.parse('today').toString('yyyy-MM-dd');

      $scope.today = Date.parse('today').toString('yyyy-MM-dd');

      $scope.dateToday = $scope.today;

    }else if (search.filterBy == 'date') {

      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');

    }else if (search.filterBy == 'month') {

      date = $('.monthpicker').datepicker('getDate');

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

    }else if (search.filterBy == 'this-month') {

      date = new Date();

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');

    }

    $scope.load({

      date           : $scope.dateToday,

      startDate      : $scope.startDate,

      endDate        : $scope.endDate,

      year_term_id   : $scope.year_term_id,

      program_id   : $scope.program_id,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.remove = function (data) {
    // console.log("hello");
    bootbox.confirm('Are you sure you want to remove '+ data.student_name +' ?', function(c) {

      if (c) {

        StudentBehavior.remove({ id: data.id }, function(e) {

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

    if ($scope.conditionsPrint !== '') {
    
      printTable(base + 'print/student_behavior?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_behavior?print=1');

    }

  }

});

app.controller('StudentBehaviorAddController', function($scope, StudentBehavior, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    setDate: new Date(),

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

    StudentBehavior : {}

  }

  $scope.data.StudentBehavior.date = Date.parse('today').toString('MM/dd/yyyy');

  Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.StudentBehavior.year = val.value;

        }

      });

    }

  }

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.StudentBehavior.employee_id = null;

      $scope.data.StudentBehavior.employee_name = null;

    }else{

      $scope.data.StudentBehavior.student_id = null;

      $scope.data.StudentBehavior.student_name = null;

    }

  }

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

    bDate = new Date(student.date_of_birth);

    var age = getAge(bDate);

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name,
     
      age : student.age, 

      year : student.year_level, 

      program : student.program_id, 

    }; 
    

  }

  $scope.studentData = function(id) {

    $scope.data.StudentBehavior.student_id = $scope.student.id;

    $scope.data.StudentBehavior.student_name = $scope.student.name;

    $scope.data.StudentBehavior.student_no = $scope.student.code;

    $scope.data.StudentBehavior.age = $scope.student.age;
    $scope.data.StudentBehavior.year_level = $scope.student.year;

    $scope.data.StudentBehavior.course_id = $scope.student.program;

    // console.log($scope.student);

  }


  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      StudentBehavior.save($scope.data, function(e) {
        console.log($scope.data);
        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/student-behavior';

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

app.controller('StudentBehaviorViewController', function($scope, $routeParams, StudentBehavior) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    StudentBehavior.get({ id: $scope.id }, function(e) {
      console.log(e);
      $scope.data = e.data;

    });

  }
  $scope.load();
 

  $scope.print = function(id){
  
    printTable(base + 'print/medical_certificate_form/'+id);

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.student_name +' ?', function(c) {

      if (c) {

        StudentBehavior.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/registrar/student-behavior";
 
          }
    
        });
    
      }
    
    });
  
  } 

});

app.controller('StudentBehaviorEditController', function($scope, $routeParams, StudentBehavior, Select) {
  
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

    StudentBehavior : {}

  }

  Select.get({code: 'program-list'}, function(e) {

    $scope.course = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.StudentBehavior.year = val.value;

        }

      });

    }

  }

  // load 

  $scope.load = function() {

    StudentBehavior.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

   $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.StudentBehavior.employee_id = null;

      $scope.data.StudentBehavior.employee_name = null;

    }else{

      $scope.data.StudentBehavior.student_id = null;

      $scope.data.StudentBehavior.student_name = null;

    }

  }

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

    bDate = new Date(student.date_of_birth);

    var age = getAge(bDate);

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name,
     
      age : age, 

    }; 
    

  }

  $scope.studentData = function(id) {

    $scope.data.StudentBehavior.student_id = $scope.student.id;

    $scope.data.StudentBehavior.student_name = $scope.student.name;

    $scope.data.StudentBehavior.student_no = $scope.student.code;

    $scope.data.StudentBehavior.age = $scope.student.age;

  }

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

    $scope.data.StudentBehavior.employee_id = $scope.employee.id;

    $scope.data.StudentBehavior.employee_no = $scope.employee.code;

    $scope.data.StudentBehavior.employee_name = $scope.employee.name;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentBehavior.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/student-behavior';

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



