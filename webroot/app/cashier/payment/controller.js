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

    Payment : {},

    CashierSub : [],

    Account : []

  }

  $scope.selecteds = [];

  Select.get({code: 'payment-code'}, function(e) {

    $scope.data.Payment.code = e.data;

  });

  $scope.searchApprovalCourse = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-approval-course';

    Select.query(options, function(e) {

      if(e.ok) {

        $scope.approval_enrolled_courses = e.data.result;

        $scope.student = {};
        
        // paginator

        $scope.paginator  = e.data.paginator;

        $scope.pages = paginator($scope.paginator, 10);

        $("#searched-approval-enrolled-course-modal").modal('show');

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

    $scope.data.Payment.program_adviser_id = $scope.student.id;

    $scope.data.Payment.student_name = $scope.student.name;

    $scope.data.Payment.email = $scope.student.email;

    $scope.data.Payment.program = $scope.student.program;

    $scope.data.Payment.gender = $scope.student.gender;

    $scope.data.Payment.contact_no = $scope.student.contact_no;

    $scope.data.Payment.age = $scope.student.age;

  }

  $scope.addMiscellaneous = function() {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'account-list-all';

    Select.query(options, function(e) {

      if(e.ok) {

        $scope.accounts = e.data.result;

        $('#add-miscellaneous-modal').modal('show');

      }

    });    

  }

  $scope.removeMiscellaneous = function(index, data) {

    $scope.data.CashierSub.splice(index,1);

    angular.forEach($scope.accounts, function(select, s) {
      
      if (select.id == data.miscellaneous_id) {

        $scope.accounts[s].selected = false;

        $scope.accounts[s].selecteds = 0;

      }
  
    });

    amount = 0;

    $.each($scope.data.CashierSub, function(key, val) {

      amount += parseFloat(val['amount']);

    });

    $scope.data.Payment.total = amount;

  }

  $scope.saveMiscellaneous = function() {

    angular.forEach($scope.accounts, function(account, e) {

      if(account.selected && account.selecteds != 1) {

        $scope.accounts[e].selected = 1;

        $scope.data.CashierSub.push({

          miscellaneous_id : account.id,

          name : account.name,

          unit : account.unit,

          amount : account.amount,

          code: account.code,

          type : true

        });

      }

    });

    amount = 0;

    $.each($scope.data.CashierSub, function(key, val) {

      amount += parseFloat(val['amount']);

    });

    $scope.data.Payment.total = amount;

    $('#add-miscellaneous-modal').modal('hide');

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

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

    Payment : {},

    CashierSub : []

  }

  $scope.selecteds = [];

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};


    Payment.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.query({code : 'account-list-all' }, function(e) {

        $scope.accounts = e.data;

        if($scope.accounts.length > 0) {

          $.each($scope.accounts, function(i, val) {

            if($scope.data.CashierSub.length > 0) {

              $.each($scope.data.CashierSub, function(is, vals) {

                if(val.id == vals.miscellaneous_id) {

                  $scope.accounts[i].selecteds = 1;

                }

              });

            }

          });

        } 

      });

    });

  }

  $scope.searchApprovalCourse = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-approval-course';

    Select.query(options, function(e) {

      if(e.ok) {

        $scope.approval_enrolled_courses = e.data.result;

        $scope.student = {};
        
        // paginator

        $scope.paginator  = e.data.paginator;

        $scope.pages = paginator($scope.paginator, 10);

        $("#searched-approval-enrolled-course-modal").modal('show');

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

    $scope.data.Payment.program_adviser_id = $scope.student.id;

    $scope.data.Payment.student_name = $scope.student.name;

    $scope.data.Payment.email = $scope.student.email;

    $scope.data.Payment.program = $scope.student.program;

    $scope.data.Payment.gender = $scope.student.gender;

    $scope.data.Payment.contact_no = $scope.student.contact_no;

    $scope.data.Payment.age = $scope.student.age;

  }

  $scope.load();

  $scope.addMiscellaneous = function() {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'account-list-all';

    Select.query(options, function(e) {

      if(e.ok) {

        $scope.accounts = e.data.result;

        $('#add-miscellaneous-modal').modal('show');

      }

    });    

  }

  $scope.removeMiscellaneous = function(index, data) {

    $scope.data.CashierSub.splice(index,1);

    angular.forEach($scope.accounts, function(select, s) {
      
      if (select.id == data.miscellaneous_id) {

        $scope.accounts[s].selected = false;

        $scope.accounts[s].selecteds = 0;

      }
  
    });

    amount = 0;

    $.each($scope.data.CashierSub, function(key, val) {

      amount += parseFloat(val['amount']);

    });

    $scope.data.Payment.total = amount;

  }

  $scope.saveMiscellaneous = function() {

    angular.forEach($scope.accounts, function(account, e) {

      if(account.selected && account.selecteds != 1) {

        $scope.accounts[e].selecteds = 1;

        $scope.data.CashierSub.push({

          miscellaneous_id : account.id,

          name : account.name,

          unit : account.unit,

          amount : account.amount,

          code: account.code,

          type : true

        });

      }

    });

    amount = 0;

    $.each($scope.data.CashierSub, function(key, val) {

      amount += parseFloat(val['amount']);

    });

    $scope.data.Payment.total = amount;

    $('#add-miscellaneous-modal').modal('hide');

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

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