app.controller('AffidavitOfLossController', function($scope, AffidavitOfLoss) {

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

    AffidavitOfLoss.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5); 

        console.log($scope.pages)

      }

    });

  }

  $scope.approved = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 1;

    options['per_student'] = 1;

    AffidavitOfLoss.query(options, function(e) {

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

    AffidavitOfLoss.query(options, function(e) {

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

        AffidavitOfLoss.remove({ id: data.id }, function(e) {

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

      printTable(base + 'print/affidavit_of_loss?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/affidavit_of_loss?print=1');

    }
  }

  $scope.printApproved = function(){

    date = "";
  
    if ($scope.conditionsPrint !== '') {

      printTable(base + 'print/request_form?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/request_form?print=1');

    }
  }

   $scope.printDisapproved = function(){

    date = "";
  
    if ($scope.conditionsPrint !== '') {

      printTable(base + 'print/request_form?print=1' + $scope.conditionsPrintDisapproved);

    }else{

      printTable(base + 'print/request_form?print=1');

    }   
  }
  // }
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

app.controller('AffidavitOfLossAddController', function($scope, AffidavitOfLoss, Select, Student) { 

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

    AffidavitOfLoss: {

      image: null

    }

  };

  Select.get({code: 'affidavit-of-loss-code'}, function(e) {

    $scope.data.AffidavitOfLoss.code = e.data;
    
    Student.get({ id: e.studentId }, function(response) {

      $scope.data.AffidavitOfLoss.student_id = response.data.Student.id;

      $scope.data.AffidavitOfLoss.student_name = response.data.Student.full_name;

      $scope.data.AffidavitOfLoss.student_no = response.data.Student.student_no;

    });
  });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_programs = e.data;

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

    $scope.data.AffidavitOfLoss.student_id = $scope.student.id;

    $scope.data.AffidavitOfLoss.student_name = $scope.student.name;

    $scope.data.AffidavitOfLoss.student_no = $scope.student.code;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      $scope.data.AffidavitOfLoss.amount = number_format($scope.data.AffidavitOfLoss.amount, 2, '.', '');

      AffidavitOfLoss.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/affidavit-of-loss';

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

app.controller('AffidavitOfLossViewController', function($scope, $routeParams, AffidavitOfLoss) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    AffidavitOfLoss.get({ id: $scope.id }, function(e) {

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

        AffidavitOfLoss.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/registrar/affidavit-of-loss";

          }

        });

      }

    });

  } 

});

app.controller('AffidavitOfLossEditController', function($scope, $routeParams, AffidavitOfLoss, Select) {
  
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

    AffidavitOfLoss: {

      image: null

    }

  };

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_programs = e.data;

  });

  // load 

  $scope.load = function() {

    AffidavitOfLoss.get({ id: $scope.id }, function(e) {

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

    $scope.data.AffidavitOfLoss.student_id = $scope.student.id;

    $scope.data.AffidavitOfLoss.student_name = $scope.student.name;

    $scope.data.AffidavitOfLoss.student_no = $scope.student.code;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AffidavitOfLoss.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/affidavit-of-loss';

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

app.controller('AdminAffidavitOfLossController', function($scope, AffidavitOfLoss) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.pending = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['status'] = 0;

    AffidavitOfLoss.query(options, function(e) {

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

    AffidavitOfLoss.query(options, function(e) {

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

    AffidavitOfLoss.query(options, function(e) {

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

        AffidavitOfLoss.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/affidavit_of_loss?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/affidavit_of_loss?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/affidavit_of_loss?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/affidavit_of_loss?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDisapproved !== '') {
    
      printTable(base + 'print/affidavit_of_loss?print=1' + $scope.conditionsPrintDisapproved);

    }else{

      printTable(base + 'print/affidavit_of_loss?print=1');

    }

  }

});

app.controller('AdminAffidavitOfLossAddController', function($scope, AffidavitOfLoss, Select) {

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

    AffidavitOfLoss: {

      image: null

    }

  };


  Select.get({ code: 'affidavit-of-loss-code' }).$promise.then(function(e) {

    $scope.data.AffidavitOfLoss.code = e.data;

  });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_programs = e.data;

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

      name: student.name,

      program_id: student.program_id,

    };

  };

  $scope.studentData = function(id) {

    $scope.data.AffidavitOfLoss.student_id = $scope.student.id;

    $scope.data.AffidavitOfLoss.student_name = $scope.student.name;

    $scope.data.AffidavitOfLoss.student_no = $scope.student.code;

    $scope.data.AffidavitOfLoss.program_id = $scope.student.program_id;

  };

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $scope.data.AffidavitOfLoss.amount = number_format($scope.data.AffidavitOfLoss.amount, 2, '.', '');

      AffidavitOfLoss.save($scope.data).$promise.then(function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text: e.msg,

          });

          window.location = '#/registrar/admin-affidavit-of-loss';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text: e.msg,

          });

        }

      });

    }

  };

});

app.controller('AdminAffidavitOfLossViewController', function($scope, $routeParams, AffidavitOfLoss,AffidavitOfLossApprove,AffidavitOfLossDisapprove) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    AffidavitOfLoss.get({ id: $scope.id }, function(e) {

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

        AffidavitOfLossApprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Affidavit Of Loss has been approved.'

            });

          }

          window.location = "#/registrar/admin-affidavit-of-loss";

        });

      }

    });

  }

  $scope.disapprove = function(data){

    bootbox.confirm('Are you sure you want to disapprove appointment ' +  data.code + '?', function(e){

      if(e) {

        AffidavitOfLossDisapprove.get({id:data.id}, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Affidavit Of Loss has been disapproved.'

            });

          }

          window.location = "#/registrar/admin-affidavit-of-loss";

        });

      }

    });

  }


});

app.controller('AdminAffidavitOfLossEditController', function($scope, $routeParams, AffidavitOfLoss, Select) {
  
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

    AffidavitOfLoss: {

      image: null

    }

  };


  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_programs = e.data;

  });



  // load 

  $scope.load = function() {

    AffidavitOfLoss.get({ id: $scope.id }, function(e) {

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

    $scope.data.AffidavitOfLoss.student_id = $scope.student.id;

    $scope.data.AffidavitOfLoss.student_name = $scope.student.name;

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

    $scope.data.AffidavitOfLoss.counselor_id = $scope.employee.id;

    $scope.data.AffidavitOfLoss.counselor_name = $scope.employee.name;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AffidavitOfLoss.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/registrar/admin-affidavit-of-loss';

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