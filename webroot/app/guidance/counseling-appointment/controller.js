app.controller('CounselingAppointmentController', function($scope, CounselingAppointment) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 0;

    CounselingAppointment.query(options, function(e) {

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

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.confirmed = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 4;

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasConfirmed = e.data;

        $scope.conditionsPrintConfirmed = e.conditionsPrint;

        // paginator

        $scope.paginatorConfirmed  = e.paginator;

        $scope.pagesConfirmed = paginator($scope.paginatorConfirmed, 5);

      }

    });

  }

  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 2;

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDispproved = e.conditionsPrint;

        // paginator

        $scope.paginatorDisapproved  = e.paginator;

        $scope.pagesDisapproved = paginator($scope.paginatorDisapproved, 5);

      }

    });

  }

  $scope.cancelled = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['per_student'] = 1;

    options['status'] = 3;

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasCancelled = e.data;

        $scope.conditionsPrintCancelled = e.conditionsPrint;

        // paginator

        $scope.paginatorCancelled  = e.paginator;

        $scope.pagesCancelled = paginator($scope.paginatorCancelled, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

    $scope.confirmed(options);

    $scope.disapproved(options);

    $scope.cancelled(options);

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

        CounselingAppointment.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printConfirmed = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintConfirmed);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printCancelled = function(){

    if ($scope.conditionsPrintCancelled !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintCancelled);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

});

app.controller('CounselingAppointmentAddController', function($scope, CounselingAppointment, Select, Student) {

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

    CounselingAppointment : {}

  }

  Select.get({code: 'counseling-apporintment-code'}, function(e) {

    $scope.data.CounselingAppointment.code = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data.CounselingAppointment.student_id = response.data.Student.id;

      $scope.data.CounselingAppointment.student_name = response.data.Student.full_name;

      $scope.data.CounselingAppointment.student_no = response.data.Student.student_no;

    });

  });

  Select.get({code: 'counseling-type-list'}, function(e) {

    $scope.counseling_types = e.data;

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

    $scope.data.CounselingAppointment.counselor_id = $scope.employee.id;

    $scope.data.CounselingAppointment.counselor_name = $scope.employee.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      CounselingAppointment.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/counseling-appointment';

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

app.controller('CounselingAppointmentViewController', function($scope, $routeParams, CounselingAppointment) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    CounselingAppointment.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        CounselingAppointment.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/guidance/counseling-appointment";

          }

        });

      }

    });

  } 

});

app.controller('CounselingAppointmentEditController', function($scope, $routeParams, CounselingAppointment, Select) {
  
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

    CounselingAppointment : {}

  }

  // load 

  $scope.load = function() {

    CounselingAppointment.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  Select.get({code: 'counseling-type-list'}, function(e) {

    $scope.counseling_types = e.data;

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

    $scope.data.CounselingAppointment.counselor_id = $scope.employee.id;

    $scope.data.CounselingAppointment.counselor_name = $scope.employee.name;

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      CounselingAppointment.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/counseling-appointment';

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

app.controller('AdminCounselingAppointmentController', function($scope, CounselingAppointment) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    CounselingAppointment.query(options, function(e) {

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

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasApproved = e.data;

        $scope.conditionsPrintApproved = e.conditionsPrint;

        // paginator

        $scope.paginatorApproved  = e.paginator;

        $scope.pagesApproved = paginator($scope.paginatorApproved, 5);

      }

    });

  }

  $scope.confirmed = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 4;

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasConfirmed = e.data;

        $scope.conditionsPrintConfirmed = e.conditionsPrint;

        // paginator

        $scope.paginatorConfirmed  = e.paginator;

        $scope.pagesConfirmed = paginator($scope.paginatorConfirmed, 5);

      }

    });

  }

  $scope.disapproved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 2;

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasDisapproved = e.data;

        $scope.conditionsPrintDispproved = e.conditionsPrint;

        // paginator

        $scope.paginatorDisapproved  = e.paginator;

        $scope.pagesDisapproved = paginator($scope.paginatorDisapproved, 5);

      }

    });

  }

  $scope.cancelled = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 3;

    CounselingAppointment.query(options, function(e) {

      if (e.ok) {

        $scope.datasCancelled = e.data;

        $scope.conditionsPrintCancelled = e.conditionsPrint;

        // paginator

        $scope.paginatorCancelled  = e.paginator;

        $scope.pagesCancelled = paginator($scope.paginatorCancelled, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.pending(options);

    $scope.approved(options);

    $scope.confirmed(options);

    $scope.disapproved(options);

    $scope.cancelled(options);

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

        CounselingAppointment.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printConfirmed = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintConfirmed);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

  $scope.printCancelled = function(){

    if ($scope.conditionsPrintCancelled !== '') {
    
      printTable(base + 'print/counseling_appointment?print=1' + $scope.conditionsPrintCancelled);

    }else{

      printTable(base + 'print/counseling_appointment?print=1');

    }

  }

});

app.controller('AdminCounselingAppointmentAddController', function($scope, CounselingAppointment, Select) {

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

    CounselingAppointment : {}

  }

  Select.get({code: 'counseling-apporintment-code'}, function(e) {

    $scope.data.CounselingAppointment.code = e.data;

  });

  Select.get({code: 'counseling-type-list'}, function(e) {

    $scope.counseling_types = e.data;

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

    $scope.data.CounselingAppointment.student_id = $scope.student.id;

    $scope.data.CounselingAppointment.student_name = $scope.student.name;

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

    $scope.data.CounselingAppointment.counselor_id = $scope.employee.id;

    $scope.data.CounselingAppointment.counselor_name = $scope.employee.name;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      CounselingAppointment.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/admin-counseling-appointment';

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

app.controller('AdminCounselingAppointmentViewController', function($scope, $routeParams, CounselingAppointment,CounselingAppointmentApprove, CounselingAppointmentConfirm, CounselingAppointmentDisapproved, CounselingAppointmentCancel) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    CounselingAppointment.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.print_no_harm_contract_form = function(id){
  
    printTable(base + 'print/no_harm_contract_form/'+id);

  }

  $scope.print_informed_consent_form = function(id){
  
    printTable(base + 'print/informed_consent_form/'+id);

  }

  $scope.print_release_info_form = function(id){
  
    printTable(base + 'print/release_info_form/'+id);

  } 

  $scope.approve = function(data){

    bootbox.confirm('Are you sure you want to approve appointment ' +  data.code + '?', function(e){

      if(e) {

        CounselingAppointmentApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Counseling Appointment has been approved.'

            });

          }

          window.location = "#/guidance/admin-counseling-appointment";

        });

      }

    });

  }

  $scope.confirm = function(data){  

    bootbox.confirm('Are you sure you want to confirm appointment ' +  data.code + '?', function(b){

      if(b) {

        CounselingAppointmentConfirm.update({id:data.id}, function(e){

          if(e.ok){

            $.gritter.add({

              title : 'Successful!',

              text : 'Counseling Appointment has been confirmed.'

            });

            $scope.load();

            window.location = "#/guidance/admin-counseling-appointment";

          }

        });

      }

    });

  }

  $scope.cancel = function(data){  

    bootbox.confirm('Are you sure you want to cancel appointment ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            CounselingAppointmentCancel.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Counseling Appointment has been cancelled.'

                });

                $scope.load();

                window.location = "#/guidance/admin-counseling-appointment";

              }

            });

          }

        });

      }

    });

  }

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            CounselingAppointmentDisapproved.update({id:data.id},$scope.data, function(e){

              if(e.ok){

                $.gritter.add({

                  title : 'Successful!',

                  text : 'Counseling Appointment has been disapproved.'

                });

                $scope.load();

                window.location = "#/guidance/admin-counseling-appointment";

              }

            });

          }

        });

      }

    });

  }

});

app.controller('AdminCounselingAppointmentEditController', function($scope, $routeParams, CounselingAppointment, Select) {
  
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

    CounselingAppointment : {}

  }

  Select.get({code: 'counseling-type-list'}, function(e) {

    $scope.counseling_types = e.data;

  });

  // load 

  $scope.load = function() {

    CounselingAppointment.get({ id: $scope.id }, function(e) {

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

    $scope.data.CounselingAppointment.student_id = $scope.student.id;

    $scope.data.CounselingAppointment.student_name = $scope.student.name;

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

    $scope.data.CounselingAppointment.counselor_id = $scope.employee.id;

    $scope.data.CounselingAppointment.counselor_name = $scope.employee.name;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      CounselingAppointment.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/admin-counseling-appointment';

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