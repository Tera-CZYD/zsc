app.controller('PaymentController', function($scope, Payment) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Payment.query(options, function(e) {

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

        Payment.remove({ id: data.id }, function(e) {
         
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

      printTable(base + 'print/payment?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/payment?print=1');

    }
  }

});

app.controller('PaymentAddController', function($scope, Payment, Account, Select) { 

 $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    Payment : {}

  }

  $scope.selecteds = [];

  Select.get({code: 'payment-code'}, function(e) {

    $scope.data.Payment.code = e.data;

  });

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

      id            : student.id,

      code          : student.code,

      name          : student.name,

      email         : student.email, 

      college_id    : student.college_id,

      program_id    : student.program_id,
  
      year_term_id  : student.year_term_id,

      year_level  : student.year_level,

      contact_no  : student.contact_no,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.Payment.student_id = $scope.student.id;

    $scope.data.Payment.student_name = $scope.student.name;

    $scope.data.Payment.student_no = $scope.student.code;

    $scope.data.Payment.program_id = $scope.student.program_id;

    $scope.data.Payment.email = $scope.student.email;

    $scope.data.Payment.contact_no = $scope.student.contact_no;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      $scope.data.Payment.amount = number_format($scope.data.Payment.amount, 2, '.', '');

      Payment.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/cashier/payment';

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

app.controller('PaymentViewController', function($scope, $routeParams, Payment) {

  $scope.id = $routeParams.id;

  $scope.data = {

    Payment : {}

  };

  // load 

  Payment.get({ id: $scope.id }, function(e) {

    $scope.data = e.data;

    $scope.putIndex();

    amount = 0;

    $.each($scope.data.CashierSub, function(key, val) {

      amount += parseFloat(val['amount']);

    });

    $scope.data.Payment.total = amount;

  });

  $scope.putIndex = function() {

    if($scope.data.CashierSub.length > 0) {

      indexMiscellaneous = 1; 

      $.each($scope.data.CashierSub, function(i, value){

        if(value.type == 1) {

          $scope.data.CashierSub[i].index = indexMiscellaneous;

          indexMiscellaneous += 1;

        }

      });

    }

  }

  $scope.compute = function() {

    amount = 0;

    if ( $scope.data.Payment.length > 0) {

      $.each($scope.data.Payment, function(key,val) {

        amount += parseFloat(val[account.amount]);

      });

    }

    $scope.data.Payment.total = amount;

  }

 
  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Payment.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/cashier/payment';

          }

        });

      }

    });

  } 

});

app.controller('PaymentEditController', function($scope, $routeParams, Payment, Select) {
  
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

    Payment : {}

  }

  $scope.selecteds = [];

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Payment.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

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

      id            : student.id,

      code          : student.code,

      name          : student.name,

      email         : student.email, 

      college_id    : student.college_id,

      program_id    : student.program_id,
  
      year_term_id  : student.year_term_id,

      year_level  : student.year_level,

      contact_no  : student.contact_no,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.Payment.student_id = $scope.student.id;

    $scope.data.Payment.student_name = $scope.student.name;

    $scope.data.Payment.student_no = $scope.student.code;

    $scope.data.Payment.program_id = $scope.student.program_id;

    $scope.data.Payment.email = $scope.student.email;

    $scope.data.Payment.contact_no = $scope.student.contact_no;

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $scope.data.Payment.amount = number_format($scope.data.Payment.amount, 2, '.', '');

      Payment.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/cashier/payment';

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