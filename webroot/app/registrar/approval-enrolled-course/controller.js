app.controller('ApprovalEnrolledCourseController', function($scope, ApprovalEnrolledCourse, ApprovalEnrolledCourseApproved, ProgramAdviserEmail) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    // options['per_student'] = 1;

    options['status'] = 0;

    ApprovalEnrolledCourse.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        // paginator

        $scope.paginator  = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.approved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    // options['per_student'] = 1;

    options['status'] = 1;

    ApprovalEnrolledCourse.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

  }

  $scope.load();

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve this adviser ' +  data.code + '?', function(e){

      if(e) {

        ApprovalEnrolledCourseApproved.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Enrolled Course has been approved.'

            });

          }

          window.location = "#/registrar/approval-enrolled-course";

        });

      }

    });

  }
  
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

      $scope.load({

        date: $scope.dateToday

      });

    }else if (search.filterBy == 'date') {

      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');

      $scope.load({

        date: $scope.dateToday

      });

    }else if (search.filterBy == 'month') {

      date = $('.monthpicker').datepicker('getDate');

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate

      });

    }else if (search.filterBy == 'this-month') {

      date = new Date();

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

      $scope.load({

        startDate: $scope.startDate,

        endDate: $scope.endDate

      });

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');


    }

    $scope.load({

      date        : $scope.dateToday,

      startDate   : $scope.startDate,

      endDate     : $scope.endDate,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        ApprovalEnrolledCourse.remove({ id: data.id }, function(e) {
         
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

      printTable(base + 'print/approval_enrolled_course?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/approval_enrolled_course?print=1');

    }
  }

  $scope.printApproved = function(){

    date = "";
  
    if ($scope.conditionsPrint !== '') {

      printTable(base + 'print/approval_enrolled_course?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/approval_enrolled_course?print=1');

    }
  }

});

app.controller('ApprovalEnrolledAddCourseController', function($scope, ApprovalEnrolledCourse, Select) { 

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

    ApprovalEnrolledCourse : {}

  }

  Select.get({code: 'approval-enrolled-course-code'}, function(e) {

    $scope.data.ApprovalEnrolledCourse.code = e.data;

  });

  $scope.searchProgramAdviser = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-program-adviser';

    Select.query(options, function(e) {

      if(e.ok) {

        $scope.program_advisers = e.data.result;

        $scope.student = {};
        
        // paginator

        $scope.paginator  = e.data.paginator;

        $scope.pages = paginator($scope.paginator, 10);

        $("#searched-program-adviser-modal").modal('show');

      }

    });

  }

  $scope.selectedStudent = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name,

      age : student.age,

      email : student.email,

      gender : student.gender,

      program : student.program,

      contact_no : student.contact_no

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.ApprovalEnrolledCourse.program_adviser_id = $scope.student.id;

    $scope.data.ApprovalEnrolledCourse.student_name = $scope.student.name;

    $scope.data.ApprovalEnrolledCourse.email = $scope.student.email;

    $scope.data.ApprovalEnrolledCourse.program = $scope.student.program;

    $scope.data.ApprovalEnrolledCourse.gender = $scope.student.gender;

    $scope.data.ApprovalEnrolledCourse.contact_no = $scope.student.contact_no;

    $scope.data.ApprovalEnrolledCourse.age = $scope.student.age;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      ApprovalEnrolledCourse.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/approval-enrolled-course';

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

app.controller('ApprovalEnrolledViewCourseController', function($scope, $routeParams, ApprovalEnrolledCourse, ApprovalEnrolledCourseApproved) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    ApprovalEnrolledCourse.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve this adviser ' +  data.code + '?', function(e){

      if(e) {

        ApprovalEnrolledCourseApproved.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Program Adviser has been approved.'

            });

          }

          window.location = "#/faculty/program-adviser";

        });

      }

    });

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        ApprovalEnrolledCourse.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/registrar/approval-enrolled-course";

          }

        });

      }

    });

  } 

});

app.controller('ApprovalEnrolledEditCourseController', function($scope, $routeParams, ApprovalEnrolledCourse, Select) {
  
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

    ApprovalEnrolledCourse : {}

  }

  $scope.load = function() {

    ApprovalEnrolledCourse.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.searchProgramAdviser = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-program-adviser';

    Select.query(options, function(e) {

      if(e.ok) {

        $scope.program_advisers = e.data.result;

        $scope.student = {};
        
        // paginator

        $scope.paginator  = e.data.paginator;

        $scope.pages = paginator($scope.paginator, 10);

        $("#searched-program-adviser-modal").modal('show');

      }

    });

  }

  $scope.selectedStudent = function(student) { 

    $scope.student = {

      id   : student.id,

      code : student.code,

      name : student.name,

      age : student.age,

      email : student.email,

      gender : student.gender,

      program : student.program,

      contact_no : student.contact_no

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.ApprovalEnrolledCourse.program_adviser_id = $scope.student.id;

    $scope.data.ApprovalEnrolledCourse.student_name = $scope.student.name;

    $scope.data.ApprovalEnrolledCourse.email = $scope.student.email;

    $scope.data.ApprovalEnrolledCourse.program = $scope.student.program;

    $scope.data.ApprovalEnrolledCourse.gender = $scope.student.gender;

    $scope.data.ApprovalEnrolledCourse.contact_no = $scope.student.contact_no;

    $scope.data.ApprovalEnrolledCourse.age = $scope.student.age;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      ApprovalEnrolledCourse.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/approval-enrolled-course';

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