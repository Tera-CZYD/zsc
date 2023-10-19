app.controller('ApartelleStudentClearanceController', function($scope, $window, ApartelleStudentClearance,ApartelleRegistrationEmail) {

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

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 0;

    ApartelleStudentClearance.query(options, function(e) {

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

    options['per_student'] = 1;

    options['status'] = 1;

    ApartelleStudentClearance.query(options, function(e) {

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

    options['per_student'] = 1;

    options['status'] = 2;

    ApartelleStudentClearance.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDispproved = e.conditionsPrint;

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

      endDate      : $scope.endDate,

      year_term_id : $scope.year_term_id

    });
  
  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.student_name +' ?', function(c) {

      if (c) {

        ApartelleStudentClearance.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/apartelle_student_clearance?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/apartelle_student_clearance?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/apartelle_student_clearance?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/apartelle_student_clearance?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/apartelle_student_clearance?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/apartelle_student_clearance?print=1');

    }

  }

  $scope.sendMail = function(data) {

    $('#form-mail').validationEngine('attach');

    $scope.mail = {

      reference_id : data.id

    };

    $("#send-mail-modal").modal('show');

  } 

  // SEND EMAIL 

  $scope.sendEmailFinal = function(data) {

    valid = $("#form-mail").validationEngine('validate');

    if(valid){

      ApartelleRegistrationEmail.save({ id : data.id },$scope.mail, function(e){

        if(e.ok){

          $scope.reload();

          $.gritter.add({

            title: 'Successful!',

            text: 'Email notification has been sent.'

          });

          $("#send-mail-modal").modal('hide');

        }

      });

    }

  } 

});

app.controller('ApartelleStudentClearanceAddController', function($scope, ApartelleStudentClearance, Student, Select) {

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

    ApartelleStudentClearance : {},

  }

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleStudentClearance.year = val.value;

        }

      });

    }

  }

  $scope.getProgram = function(id){

    if($scope.college_program.length > 0){

      $.each($scope.college_program, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleStudentClearance.program = val.value;

        }

      });

    }

  }

  Select.get({code: 'apartelle-student-clearance-code'}, function(e) {

    $scope.data.ApartelleStudentClearance.code = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data.ApartelleStudentClearance.student_id = response.data.Student.id;

      $scope.data.ApartelleStudentClearance.student_name = response.data.Student.full_name;

      $scope.data.ApartelleStudentClearance.student_no = response.data.Student.student_no;

      $scope.data.ApartelleStudentClearance.program_id = response.data.Student.program_id;

      $scope.data.ApartelleStudentClearance.year_term_id = response.data.Student.year_term_id;

    });

  });

  Select.get({code: 'apartelle-list'}, function(e) {

    $scope.apartelle = e.data;

  });

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

      ApartelleStudentClearance.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/apartelle-student-clearance';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

    });

  }

});

app.controller('ApartelleStudentClearanceViewController', function($scope, $routeParams, ApartelleStudentClearance) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    ApartelleStudentClearance.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.student_name +' ?', function(c) {

      if (c) {

        ApartelleStudentClearance.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/corporate-affairs/apartelle-student-clearance";

          }

        });

      }

    });

  } 

});

app.controller('ApartelleStudentClearanceEditController', function($scope, $routeParams, ApartelleStudentClearance, Select) {
  
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

    ApartelleStudentClearance : {},

  }
  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleStudentClearance.year = val.value;

        }

      });

    }

  }

  $scope.getProgram = function(id){

    if($scope.college_program.length > 0){

      $.each($scope.college_program, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleStudentClearance.program = val.value;

        }

      });

    }

  }


  Select.get({code: 'apartelle-list'}, function(e) {

    $scope.apartelle = e.data;

  });

  // load 

  $scope.load = function() {

    ApartelleStudentClearance.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');
    
      ApartelleStudentClearance.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/apartelle-student-clearance';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,
            
          });

        }
        
    }); 

  }

});

app.controller('AdminApartelleStudentClearanceController', function($scope, $window, ApartelleStudentClearance) {

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

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    ApartelleStudentClearance.query(options, function(e) {

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

    ApartelleStudentClearance.query(options, function(e) {

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

    ApartelleStudentClearance.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDispproved = e.conditionsPrint;

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

      endDate      : $scope.endDate,

      year_term_id : $scope.year_term_id

    });
  
  }

  $scope.sendMail = function(data) {

    $('#form-mail').validationEngine('attach');

    $scope.mail = {

      reference_id : data.id

    };

    $("#send-mail-modal").modal('show');

  } 

  // SEND EMAIL 

  // $scope.sendEmailFinal = function(data) {

  //   valid = $("#form-mail").validationEngine('validate');

  //   if(valid){

  //     ApartelleRegistrationEmail.save({ id : data.id },$scope.mail, function(e){

  //       if(e.ok){

  //         $scope.reload();

  //         $.gritter.add({

  //           title: 'Successful!',

  //           text: 'Email notification has been sent.'

  //         });

  //         $("#send-mail-modal").modal('hide');

  //       }

  //     });

  //   }

  // } 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.student_name +' ?', function(c) {

      if (c) {

        ApartelleStudentClearance.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/apartelle_student_clearance?print=1' + $scope.conditionsPrint);

    }else{
      
      printTable(base + 'print/apartelle_student_clearance?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/apartelle_student_clearance?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/apartelle_student_clearance?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/apartelle_student_clearance?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/apartelle_student_clearance?print=1');

    }

  }

});

app.controller('AdminApartelleStudentClearanceAddController', function($scope, ApartelleStudentClearance, Select) {

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

    ApartelleStudentClearance : {}

  }

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleStudentClearance.year = val.value;

        }

      });

    }

  }

  Select.get({code: 'apartelle-student-clearance-code'}, function(e) {

    $scope.data.ApartelleStudentClearance.code = e.data;

  });

  Select.get({code: 'apartelle-list'}, function(e) {

    $scope.apartelle = e.data;

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

      name : student.name,

      program_id : student.program_id,

      year_term_id : student.year_term_id

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.ApartelleStudentClearance.student_id = $scope.student.id;

    $scope.data.ApartelleStudentClearance.student_no = $scope.student.code;

    $scope.data.ApartelleStudentClearance.student_name = $scope.student.name;

    $scope.data.ApartelleStudentClearance.program_id = $scope.student.program_id;

    $scope.data.ApartelleStudentClearance.year_term_id = $scope.student.year_term_id;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      ApartelleStudentClearance.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/admin-apartelle-student-clearance';

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

app.controller('AdminApartelleStudentClearanceViewController', function($scope, $routeParams, ApartelleStudentClearance, ApartelleStudentClearanceApprove, ApartelleStudentClearanceDisapprove,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() { 

    ApartelleStudentClearance.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve appointment ' +  data.code + '?', function(e){

      if(e) {

        ApartelleStudentClearanceApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Apartelle Student Clearance has been approved.'

            });

          }

          window.location = "#/corporate-affairs/admin-apartelle-student-clearance";

        });

      }

    });

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.student_name +' ?', function(c) {

      if (c) {

        ApartelleStudentClearance.remove({ id: data.id }, function(e) {

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

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove student clearance ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            ApartelleStudentClearanceDisapprove.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Apartelle Registration has been disapproved.'

                });

                $scope.load();

                window.location = "#/corporate-affairs/admin-apartelle-registration";

              }

            });

          }

        });

      }

    });

  }

});

app.controller('AdminApartelleStudentClearanceEditController', function($scope, $routeParams, ApartelleStudentClearance, Select) {
  
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

    ApartelleStudentClearance : {}

  }

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_terms = e.data;

  });

  $scope.getYear = function(id){

    if($scope.year_terms.length > 0){

      $.each($scope.year_terms, function(i,val){

        if(id == val.id){

          $scope.data.ApartelleStudentClearance.year = val.value;

        }

      });

    }

  }

  Select.get({code: 'apartelle-list'}, function(e) {

    $scope.apartelle = e.data;

  });

  // load 

  $scope.load = function() {

    ApartelleStudentClearance.get({ id: $scope.id }, function(e) {

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

      name : student.name,

      program_id : student.program_id,

      year_term_id : student.year_term_id

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.ApartelleStudentClearance.student_id = $scope.student.id;

    $scope.data.ApartelleStudentClearance.student_no = $scope.student.code;

    $scope.data.ApartelleStudentClearance.student_name = $scope.student.name;

    $scope.data.ApartelleStudentClearance.program_id = $scope.student.program_id;

    $scope.data.ApartelleStudentClearance.year_term_id = $scope.student.year_term_id;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      ApartelleStudentClearance.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/admin-apartelle-student-clearance';

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