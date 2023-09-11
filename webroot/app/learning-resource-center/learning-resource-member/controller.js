app.controller('LearningResourceMemberController', function($scope, LearningResourceMember) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.student = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['classification'] = 'STUDENT';

    LearningResourceMember.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.faculty = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['classification'] = 'FACULTY';

    LearningResourceMember.query(options, function(e) {

      if (e.ok) {

        $scope.datasFaculty = e.data;

        $scope.conditionsPrintFaculty = e.conditionsPrint;

        // paginator

        $scope.paginatorFaculty  = e.paginator;

        $scope.pagesFaculty = paginator($scope.paginatorFaculty, 5);

      }

    });

  }

  $scope.admin = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['classification'] = 'ADMIN';

    LearningResourceMember.query(options, function(e) {

      if (e.ok) {

        $scope.datasAdmin = e.data;

        $scope.conditionsPrintAdmin = e.conditionsPrint;

        $scope.paginatorAdmin = e.paginator;

        $scope.pagesAdmin = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.student(options);

    $scope.faculty(options);

    $scope.admin(options);

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

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        LearningResourceMember.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/student_member?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_member?print=1');

    }

  }

  $scope.printFaculty = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/faculty_member?print=1' + $scope.conditionsPrintFaculty);

    }else{

      printTable(base + 'print/faculty_member?print=1');

    }

  }

  $scope.printAdmin = function() {

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/admin_member?print=1' + $scope.conditionsPrintAdmin);

    }else{

      printTable(base + 'print/admin_member?print=1');

    }

  }

  $scope.export = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_member?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/export_member?print=1');

    }

    // Select.get({code: 'daily-list-collection-export'}, function(e){});

  }

  $scope.exportFaculty = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_member_faculty?print=1' + $scope.conditionsPrintFaculty);

    }else{

      printTable(base + 'print/export_member_faculty?print=1');

    }

    // Select.get({code: 'daily-list-collection-export'}, function(e){});

  }

  $scope.exportAdmin = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_member_admin?print=1' + $scope.conditionsPrintAdmin);

    }else{

      printTable(base + 'print/export_member_admin?print=1');

    }

    // Select.get({code: 'daily-list-collection-export'}, function(e){});

  }

});

app.controller('LearningResourceMemberAddController', function($scope, $routeParams, Select, LearningResourceMember) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $('#form').validationEngine('attach');

  $scope.id = $routeParams.id;

  $scope.data = {

    LearningResourceMember : {

      date : $scope.today

    }

  };

  Select.get({code: 'learning-resource-member-code'}, function(e) {

    $scope.data.LearningResourceMember.code = e.data;

  });

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.getYearTerm = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(val.id == id){

          $scope.data.LearningResourceMember.year_level = val.value;

        }

      });

    }

  }

  $scope.clearData = function(data){

    $scope.data.LearningResourceMember.employee_id = null;

    $scope.data.LearningResourceMember.employee_name = null;

    $scope.data.LearningResourceMember.admin = null;

    $scope.data.LearningResourceMember.admin_name = null;

    $scope.data.LearningResourceMember.student_id = null;

    $scope.data.LearningResourceMember.student_name = null;

    $scope.data.LearningResourceMember.college_id = null;
    
    $scope.data.LearningResourceMember.program_id = null;
    
    $scope.data.LearningResourceMember.year_term_id = null;
    
    $scope.data.LearningResourceMember.email = null;

    $scope.data.LearningResourceMember.office = null;

    $scope.data.LearningResourceMember.address = null;

    $scope.data.LearningResourceMember.contact_no = null;

    $scope.data.LearningResourceMember.faculty_status = null;

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

    $scope.student = {

      id            : student.id,

      code          : student.code,

      name          : student.name,

      email         : student.email, 

      college_id    : student.college_id,

      program_id    : student.program_id,
  
      year_term_id  : student.year_term_id,

      year_level  : student.year_level,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.LearningResourceMember.student_id = $scope.student.id;

    $scope.data.LearningResourceMember.student_name = $scope.student.name;

    $scope.data.LearningResourceMember.student_code = $scope.student.code;

    $scope.data.LearningResourceMember.college_id = $scope.student.college_id;

    $scope.data.LearningResourceMember.program_id = $scope.student.program_id;

    $scope.data.LearningResourceMember.year_term_id = $scope.student.year_term_id;

    $scope.data.LearningResourceMember.year_level = $scope.student.year_level;

    $scope.data.LearningResourceMember.email = $scope.student.email;

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

      id         : employee.id,

      code       : employee.code,

      name       : employee.name,

      email      : employee.email,

      college_id : employee.college_id,

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.LearningResourceMember.employee_id = $scope.employee.id;

    $scope.data.LearningResourceMember.employee_code = $scope.employee.code;

    $scope.data.LearningResourceMember.employee_name = $scope.employee.name;

    $scope.data.LearningResourceMember.email = $scope.employee.email;

    $scope.data.LearningResourceMember.college_id = $scope.employee.college_id;

  }

  $scope.searchAdmin = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-admin';

    Select.query(options, function(e) {

      $scope.admins = e.data.result;

      $scope.admin = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-admin-modal").modal('show');

    });

  }

  $scope.selectedAdmin = function(admin) { 

    $scope.admin = {

      id    : admin.id,

      code  : admin.code,

      name  : admin.name

    }; 

  }

  $scope.adminData = function(id) {

    $scope.data.LearningResourceMember.admin_id = $scope.admin.id;

    $scope.data.LearningResourceMember.admin_code = $scope.admin.code;

    $scope.data.LearningResourceMember.admin_name = $scope.admin.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      LearningResourceMember.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/learning-resource-center/learning-resource-member';

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

app.controller('LearningResourceMemberViewController', function($scope, $routeParams, LearningResourceMember) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    LearningResourceMember.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load(); 

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        LearningResourceMember.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/learning-resource-center/learning-resource-member";

          }

        });

      }

    });

  } 

});

app.controller('LearningResourceMemberEditController', function($scope, $routeParams, LearningResourceMember, Select) {
  
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

    LearningResourceMember : {}

  }

  // load 

  $scope.load = function() {

    LearningResourceMember.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.getYearTerm = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(val.id == id){

          $scope.data.LearningResourceMember.year_level = val.value;

        }

      });

    }

  }

  $scope.clearData = function(data){

    $scope.data.LearningResourceMember.employee_id = null;

    $scope.data.LearningResourceMember.employee_name = null;

    $scope.data.LearningResourceMember.admin = null;

    $scope.data.LearningResourceMember.admin_name = null;

    $scope.data.LearningResourceMember.student_id = null;

    $scope.data.LearningResourceMember.student_name = null;

    $scope.data.LearningResourceMember.college_id = null;
    
    $scope.data.LearningResourceMember.program_id = null;
    
    $scope.data.LearningResourceMember.year_term_id = null;
    
    $scope.data.LearningResourceMember.email = null;

    $scope.data.LearningResourceMember.office = null;

    $scope.data.LearningResourceMember.address = null;

    $scope.data.LearningResourceMember.contact_no = null;

    $scope.data.LearningResourceMember.faculty_status = null;

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

    $scope.student = {

      id            : student.id,

      code          : student.code,

      name          : student.name,

      email         : student.email, 

      college_id    : student.college_id,

      program_id    : student.program_id,
  
      year_term_id  : student.year_term_id,

      year_level  : student.year_level,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.LearningResourceMember.student_id = $scope.student.id;

    $scope.data.LearningResourceMember.student_name = $scope.student.name;

    $scope.data.LearningResourceMember.student_code = $scope.student.code;

    $scope.data.LearningResourceMember.college_id = $scope.student.college_id;

    $scope.data.LearningResourceMember.program_id = $scope.student.program_id;

    $scope.data.LearningResourceMember.year_term_id = $scope.student.year_term_id;

    $scope.data.LearningResourceMember.year_level = $scope.student.year_level;

    $scope.data.LearningResourceMember.email = $scope.student.email;

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

      id         : employee.id,

      code       : employee.code,

      name       : employee.name,

      email      : employee.email,

      college_id : employee.college_id,

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.LearningResourceMember.employee_id = $scope.employee.id;

    $scope.data.LearningResourceMember.employee_code = $scope.employee.code;

    $scope.data.LearningResourceMember.employee_name = $scope.employee.name;

    $scope.data.LearningResourceMember.email = $scope.employee.email;

    $scope.data.LearningResourceMember.college_id = $scope.employee.college_id;

  }

  $scope.searchAdmin = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-admin';

    Select.query(options, function(e) {

      $scope.admins = e.data.result;

      $scope.admin = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-admin-modal").modal('show');

    });

  }

  $scope.selectedAdmin = function(admin) { 

    $scope.admin = {

      id    : admin.id,

      code  : admin.code,

      name  : admin.name

    }; 

  }

  $scope.adminData = function(id) {

    $scope.data.LearningResourceMember.admin_id = $scope.admin.id;

    $scope.data.LearningResourceMember.admin_code = $scope.admin.code;

    $scope.data.LearningResourceMember.admin_name = $scope.admin.name;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      LearningResourceMember.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/learning-resource-center/learning-resource-member';

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