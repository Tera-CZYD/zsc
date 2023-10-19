app.controller('StudentClubController', function($scope, $window, StudentClub) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    options['per_student'] = 1;

    StudentClub.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5); 

      }

    });

  }

  $scope.approved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    options['per_student'] = 1;

    StudentClub.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    options['per_student'] = 1;

    StudentClub.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDisapproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

    $scope.disapproved(options);

  }

  $scope.scrollToTop = function() {

    $window.scrollTo(0, 0);

  };

  $scope.scrollToTop();

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

  $scope.selectedFilter = 'date';

  $scope.changeFilter = function(type){

    $scope.search = {};

    $scope.selectedFilter = type;

    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    });

  }

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    if ($scope.selectedFilter == 'date') {
    
      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');
   
    }else if ($scope.selectedFilter == 'month') {
   
      date = $('.monthpicker').datepicker('getDate');
   
      year = date.getFullYear();
   
      month = date.getMonth() + 1;
   
      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;
      
      $scope.startDate = year + '-' + month + '-01';
      
      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
    
    }else if ($scope.selectedFilter == 'customRange') {
    
      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');
    
      $scope.endDate = Date.parse(search.endDate).toString('yyyy-MM-dd');
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate

    });
  
  } 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        StudentClub.remove({ id: data.id }, function(e) {
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

      printTable(base + 'print/student_club?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_club?print=1');

    }
  }

  $scope.printApproved = function(){

    date = "";
  
    if ($scope.conditionsPrint !== '') {

      printTable(base + 'print/student_club?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/student_club?print=1');

    }
  }

  $scope.printDisapproved = function(){

    date = "";
  
    if ($scope.conditionsPrint !== '') {

      printTable(base + 'print/student_club?print=1' + $scope.conditionsPrintDisapproved);

    }else{

      printTable(base + 'print/student_club?print=1');

    }
  }  

  // $scope.printForm = function(){
  //   printTable(base + 'print/practicum_form/');
  // }
  // $scope.printCOG = function(){
  //   printTable(base + 'print/cog_form/');
  // }
  // $scope.printReportRating = function(){
  //   printTable(base + 'print/report_rating_form/');
  // }
  // $scope.printEAS = function(){
  //   printTable(base + 'print/examinees_attendance_sheet/');
  // }

});

app.controller('StudentClubAddController', function($scope, StudentClub, Select, Student) { 

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

    StudentClub : {}

  }

  Select.get({code: 'student-club-code'}, function(e) {

    $scope.data.StudentClub.code = e.data;
    
    Student.get({ id: e.studentId }, function(response) {

      $scope.data.StudentClub.student_id = response.data.Student.id;

      $scope.data.StudentClub.student_name = response.data.Student.full_name;

      $scope.data.StudentClub.student_no = response.data.Student.student_no;

    });
  });

  Select.get({code: 'club-list'}, function(e) {

    $scope.clubs = e.data;

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

      name : student.name 

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.StudentClub.student_id = $scope.student.id;

    $scope.data.StudentClub.student_name = $scope.student.name;

    $scope.data.StudentClub.student_no = $scope.student.code;

  }

 $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Select.get({code: 'check-student-ledger', student_id : $scope.data.StudentClub.student_id}, function(q) {

        if(q.data){

          StudentClub.save($scope.data, function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text:  e.msg,

              });

              window.location = '#/registrar/student-club';

            } else {

              $.gritter.add({

                title: 'Warning!',

                text:  e.msg,

              });

            }

          });

        }else{

          $.gritter.add({

            title: 'Warning!',

            text:  'You still have a pending payment from apartelle/dormitory.',

          });

        }

      });

    }  

  }

});

app.controller('StudentClubViewController', function($scope, $routeParams, StudentClub) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    StudentClub.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // $scope.print = function(id){
  
  //   bootbox.confirm('Are you sure you want to print request form?', function(c) {

  //     if (c) {

  //       printTable(base + 'print/request_form_receipt/'+id);

  //       $scope.data.StudentClub.isprint = 1;

  //       StudentClub.update({ id: id }, $scope.data)

  //       $scope.load(); 
  //     }

  //   });

  // }

  // $scope.printRequested = function(id){
  
  //   bootbox.confirm('Are you sure you want to print requested form?', function(c) {

  //     if (c) {

  //       printTable(base + 'print/requested_forms/'+id);

  //       $scope.data.StudentClub.is_request_printed = 1;

  //       StudentClub.update({ id: id }, $scope.data)

  //       $scope.load(); 
  //     }

  //   });

  // }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        StudentClub.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/registrar/student-club";

          }

        });

      }

    });

  } 

});

app.controller('StudentClubEditController', function($scope, $routeParams, StudentClub, Select) {
  
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

    StudentClub : {}

  }

  Select.get({code: 'club-list'}, function(e) {

    $scope.clubs = e.data;

  });

  // load 

  $scope.load = function() {

    StudentClub.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

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

      id   : student.id,

      code : student.code,

      name : student.name 

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.StudentClub.student_id = $scope.student.id;

    $scope.data.StudentClub.student_name = $scope.student.name;

    $scope.data.StudentClub.student_no = $scope.student.code;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentClub.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/student-club';

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

app.controller('AdminStudentClubController', function($scope, $window, StudentClub) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    StudentClub.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    StudentClub.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    StudentClub.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDisapproved = e.conditionsPrint;

        // paginator

        $scope.paginatorDisapproved  = e.paginator;

        $scope.pagesDisapproved = paginator($scope.paginatorDisapproved, 5);

      }

    });

  }

  

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

    $scope.disapproved(options);


  }

  $scope.scrollToTop = function() {

    $window.scrollTo(0, 0);

  };

  $scope.scrollToTop();

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

  $scope.selectedFilter = 'date';

  $scope.changeFilter = function(type){

    $scope.search = {};

    $scope.selectedFilter = type;

    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    });

  }

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    if ($scope.selectedFilter == 'date') {
    
      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');
   
    }else if ($scope.selectedFilter == 'month') {
   
      date = $('.monthpicker').datepicker('getDate');
   
      year = date.getFullYear();
   
      month = date.getMonth() + 1;
   
      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;
      
      $scope.startDate = year + '-' + month + '-01';
      
      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();
    
    }else if ($scope.selectedFilter == 'customRange') {
    
      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');
    
      $scope.endDate = Date.parse(search.endDate).toString('yyyy-MM-dd');
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate

    });
  
  } 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        StudentClub.remove({ id: data.id }, function(e) {

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

    if ($scope.conditionsPrintPending !== '') {
    
      printTable(base + 'print/student_club?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_club?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/student_club?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/student_club?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDisapproved !== '') {
    
      printTable(base + 'print/student_club?print=1' + $scope.conditionsPrintDisapproved);

    }else{

      printTable(base + 'print/student_club?print=1');

    }

  }

});

app.controller('AdminStudentClubAddController', function($scope, StudentClub, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
    autoclose: true,
    todayHighlight: true,
  });

  $('.clockpicker').clockpicker({
    donetext: 'Done',
    twelvehour: true,
    placement: 'bottom'
  });

  $scope.data = {
    StudentClub: {}
  };

  Select.get({ code: 'student-club-code' }).$promise.then(function(e) {
    $scope.data.StudentClub.code = e.data;
  });

  Select.get({ code: 'club-list' }).$promise.then(function(e) {
    $scope.clubs = e.data;
  });

  $scope.searchStudent = function(options) {
    options = options || {};
    options['code'] = 'search-student';

    Select.query(options).$promise.then(function(e) {
      $scope.students = e.data.result;
      $scope.student = {};
      // paginator
      $scope.paginator = e.data.paginator;
      $scope.pages = paginator($scope.paginator, 10);
      $("#searched-student-modal").modal('show');
    });
  };

  $scope.selectedStudent = function(student) {
    $scope.student = {
      id: student.id,
      code: student.code,
      name: student.name
    };
  };

  $scope.studentData = function(id) {
    $scope.data.StudentClub.student_id = $scope.student.id;
    $scope.data.StudentClub.student_name = $scope.student.name;
    $scope.data.StudentClub.student_no = $scope.student.code;
  };

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Select.get({code: 'check-student-ledger', student_id : $scope.data.StudentClub.student_id}, function(q) {

        if(q.data){

          StudentClub.save($scope.data).$promise.then(function(e) {

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg,

              });

              window.location = '#/registrar/admin-student-club';

            } else {

              $.gritter.add({

                title: 'Warning!',

                text: e.msg,

              });

            }

          });

        }else{

          $.gritter.add({

            title: 'Warning!',

            text:  'Student still have a pending payment from apartelle/dormitory.',

          });

        }

      });

    }

  };

});

app.controller('AdminStudentClubViewController', function($scope, $routeParams, StudentClub,StudentClubApprove,StudentClubDisapprove) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    StudentClub.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // $scope.print = function(id){
  
  //   printTable(base + 'print/request_form_receipt/'+id);

  // }



  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve appointment ' +  data.code + '?', function(e){

      if(e) {

        StudentClubApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Student Club has been approved.'

            });

          }

          window.location = "#/registrar/admin-student-club";

        });

      }

    });

  }

  $scope.disapprove = function(data){

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(e){

      if(e) {

        StudentClubDisapprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Student Club has been disapproved.'

            });

          }

          window.location = "#/registrar/admin-student-club";

        });

      }

    });

  }


});

app.controller('AdminStudentClubEditController', function($scope, $routeParams, StudentClub, Select) {
  
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

    StudentClub : {}

  }



  // load 

  $scope.load = function() {

    StudentClub.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }


  Select.get({code: 'club-list'}, function(e) {

    $scope.clubs = e.data;

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

      name : student.name

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.StudentClub.student_id = $scope.student.id;

    $scope.data.StudentClub.student_name = $scope.student.name;

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

    $scope.data.StudentClub.counselor_id = $scope.employee.id;

    $scope.data.StudentClub.counselor_name = $scope.employee.name;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      StudentClub.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/admin-student-club';

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