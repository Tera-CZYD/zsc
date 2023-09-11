app.controller('FacultyClearanceController', function($scope, FacultyClearance) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    FacultyClearance.query(options, function(e) {

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

        FacultyClearance.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/faculty_clearance?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/faculty_clearance?print=1');

    }

  }

});

app.controller('FacultyClearanceAddController', function($scope, FacultyClearance, Select) {

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
 
     FacultyClearance : {}
 
   }
 
   Select.get({code: 'faculty-clearance-code'}, function(e) {
 
     $scope.data.FacultyClearance.code = e.data;
 
   });
 
  
 
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
 
     $scope.data.FacultyClearance.faculty_id = $scope.employee.id;
 
     $scope.data.FacultyClearance.faculty_name = $scope.employee.name;
 
   }
 
   $scope.save = function() {
 
     valid = $("#form").validationEngine('validate');
     
     if (valid) {
 
       FacultyClearance.save($scope.data, function(e) {
 
         if (e.ok) {
 
           $.gritter.add({
 
             title: 'Successful!',
 
             text:  e.msg,
 
           });
 
           window.location = '#/faculty/faculty-clearance';
 
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

 
 app.controller('FacultyClearanceViewController', function($scope, $routeParams, FacultyClearance) {
 
   $scope.id = $routeParams.id;
 
   $scope.data = {};
 
   // load 
 
   $scope.load = function() {
 
     FacultyClearance.get({ id: $scope.id }, function(e) {
 
       $scope.data = e.data;
 
     });
 
   }
 
   $scope.load();  
 
   $scope.print = function(id){
   
     printTable(base + 'print/faculty_clearance_form/'+id);
 
   }
 
   // remove 
   $scope.remove = function(data) {
 
     bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {
 
       if (c) {
 
         FacultyClearance.remove({ id: data.id }, function(e) {
 
           if (e.ok) {
 
             $.gritter.add({
 
               title: 'Successful!',
 
               text:  e.msg,
 
             });
 
             window.location = "#/faculty/faculty-clearance";
 
           }
 
         });
 
       }
 
     });
 
   } 
 
 });

 
 app.controller('FacultyClearanceEditController', function($scope, $routeParams, FacultyClearance, Select) {
   
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
 
     FacultyClearance : {}
 
   }
 
   // Select.get({code: 'course-list'}, function(e) {
 
   //   $scope.course = e.data;
 
   // });
 
   // load 
 
   $scope.load = function() {
 
     FacultyClearance.get({ id: $scope.id }, function(e) {
 
       $scope.data = e.data;
 
     });
 
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
 
     $scope.data.FacultyClearance.faculty_id = $scope.employee.id;
 
     $scope.data.FacultyClearance.faculty_name = $scope.employee.name;
 
   }
 
   $scope.load();
 
   $scope.update = function() {
 
     valid = $("#form").validationEngine('validate');
 
     if (valid) {
 
       FacultyClearance.update({id:$scope.id}, $scope.data, function(e) {
 
         if (e.ok) {
 
           $.gritter.add({
 
             title: 'Successful!',
 
             text:  e.msg,
 
           });
 
           window.location = '#/faculty/faculty-clearance';
 
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