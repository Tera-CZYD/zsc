app.controller('ApartelleRegistrationController', function($scope, ApartelleRegistration,ApartelleRegistrationEmail) {

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

    ApartelleRegistration.query(options, function(e) {

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

    ApartelleRegistration.query(options, function(e) {

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

    ApartelleRegistration.query(options, function(e) {

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

    bootbox.confirm('Are you sure you want to delete ' + data.nick_name +' ?', function(c) {

      if (c) {

        ApartelleRegistration.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/apartelle_registration?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/apartelle_registration?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/apartelle_registration?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/apartelle_registration?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/apartelle_registration?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/apartelle_registration?print=1');

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

app.controller('ApartelleRegistrationAddController', function($scope, ApartelleRegistration, Student, Select) {

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

    ApartelleRegistration : {},

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

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({code: 'apartelle-registration-code'}, function(e) {

    $scope.data.ApartelleRegistration.code = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data.ApartelleRegistration.student_id = response.data.Student.id;

      $scope.data.ApartelleRegistration.student_name = response.data.Student.full_name;

      $scope.data.ApartelleRegistration.student_no = response.data.Student.student_no;

      $scope.data.ApartelleRegistration.program_id = response.data.Student.program_id;

      $scope.data.ApartelleRegistration.year_term_id = response.data.Student.year_term_id;

      $scope.data.ApartelleRegistration.date_of_birth = response.data.Student.date_of_birth;

      $scope.data.ApartelleRegistration.address = response.data.Student.address;

      $scope.data.ApartelleRegistration.sex = response.data.Student.gender;


    });

  });

  Select.get({code: 'apartelle-list'}, function(e) {

    $scope.apartelle = e.data;

  });

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

      ApartelleRegistration.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/apartelle-registration';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

    });

  }

});

app.controller('ApartelleRegistrationViewController', function($scope, $routeParams, ApartelleRegistration) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    ApartelleRegistration.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.nick_name +' ?', function(c) {

      if (c) {

        ApartelleRegistration.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/corporate-affairs/apartelle-registration";

          }

        });

      }

    });

  } 

});

app.controller('ApartelleRegistrationEditController', function($scope, $routeParams, ApartelleRegistration, Select) {
  
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

    ApartelleRegistration : {},

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

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({code: 'apartelle-list'}, function(e) {

    $scope.apartelle = e.data;

  });

  // load 

  $scope.load = function() {

    ApartelleRegistration.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');
    
      ApartelleRegistration.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/apartelle-registration';

        } else {

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,
            
          });

        }
        
    }); 

  }

});

app.controller('AdminApartelleRegistrationController', function($scope, ApartelleRegistration,ApartelleRegistrationEmail) {

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

    ApartelleRegistration.query(options, function(e) {

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

    ApartelleRegistration.query(options, function(e) {

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

    ApartelleRegistration.query(options, function(e) {

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

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        ApartelleRegistration.remove({ id: data.id }, function(e) {

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
    
      printTable(base + 'print/apartelle_registration?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/apartelle_registration?print=1');

    }

  }

  $scope.printApproved = function(){

    if ($scope.conditionsPrintApproved !== '') {
    
      printTable(base + 'print/apartelle_registration?print=1' + $scope.conditionsPrintApproved);

    }else{

      printTable(base + 'print/apartelle_registration?print=1');

    }

  }

  $scope.printDisapproved = function(){

    if ($scope.conditionsPrintDispproved !== '') {
    
      printTable(base + 'print/apartelle_registration?print=1' + $scope.conditionsPrintDispproved);

    }else{

      printTable(base + 'print/apartelle_registration?print=1');

    }

  }

});

app.controller('AdminApartelleRegistrationAddController', function($scope, ApartelleRegistration, Select) {

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

    ApartelleRegistration : {}

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

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({code: 'apartelle-registration-code'}, function(e) {

    $scope.data.ApartelleRegistration.code = e.data;

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

      year_term_id : student.year_term_id,

      date_of_birth : student.date_of_birth,

      address : student.address,

      gender : student.gender,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.ApartelleRegistration.student_id = $scope.student.id;

    $scope.data.ApartelleRegistration.student_name = $scope.student.name;

    $scope.data.ApartelleRegistration.program_id = $scope.student.program_id;

    $scope.data.ApartelleRegistration.year_term_id = $scope.student.year_term_id;

    $scope.data.ApartelleRegistration.date_of_birth = $scope.student.date_of_birth;

    $scope.data.ApartelleRegistration.address = $scope.student.address;

    $scope.data.ApartelleRegistration.sex = $scope.student.gender;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      ApartelleRegistration.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/admin-apartelle-registration';

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

app.controller('AdminApartelleRegistrationViewController', function($scope, $routeParams, ApartelleRegistration,ApartelleRegistrationApprove, ApartelleRegistrationDisapproved,Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    ApartelleRegistration.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

    console.log($scope);

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

  $scope.approve = function(data,details){

    bootbox.confirm('Are you sure you want to approve registration ' +  details.code + '?', function(e){

      if(e) {
        $("#select-room-modal").modal('hide');
        $scope.data = {

          room : data.apartelle_id,

          asd : data

        };

        console.log($scope.data);

        ApartelleRegistrationApprove.update({id:details.id},$scope.data, function(e){

          if(e.ok){

            $scope.load();

            $.gritter.add({

              title: 'Successful!',

              text: 'Apartelle Registration has been approved.'

            });

          }

          window.location = "#/corporate-affairs/admin-apartelle-registration";

        });

      }

    });

  }
  $scope.selectRoom = function(data){

    Select.get({code: 'apartelle-list'}, function(e) {

      $scope.apartelle = e.data;
      $scope.details = data;
       // console.log(data);
    });

   
    $("#select-room-modal").modal('show');
  }

  $scope.disapprove = function(data){  

    bootbox.confirm('Are you sure you want to disapprove registration ' +  data.code + '?', function(b){

      if(b) {

        bootbox.prompt('REASON ?', function(result){

          if(result){

            $scope.data = {

              explanation : result

            };

            ApartelleRegistrationDisapproved.update({id:data.id},$scope.data, function(e){

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

app.controller('AdminApartelleRegistrationEditController', function($scope, $routeParams, ApartelleRegistration, Select) {
  
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

    ApartelleRegistration : {}

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

          $scope.data.ApartelleRegistration.year = val.value;

        }

      });

    }

  }

  Select.get({code: 'apartelle-list'}, function(e) {

    $scope.apartelle = e.data;

  });

  // load 

  $scope.load = function() {

    ApartelleRegistration.get({ id: $scope.id }, function(e) {

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

      year_term_id : student.year_term_id,

      date_of_birth : student.date_of_birth,

      address : student.address,

    }; 

  }

  $scope.studentData = function(id) {

    $scope.data.ApartelleRegistration.student_id = $scope.student.id;

    $scope.data.ApartelleRegistration.student_name = $scope.student.name;

    $scope.data.ApartelleRegistration.program_id = $scope.student.program_id;

    $scope.data.ApartelleRegistration.year_term_id = $scope.student.year_term_id;

    $scope.data.ApartelleRegistration.date_of_birth = $scope.student.date_of_birth;

    $scope.data.ApartelleRegistration.address = $scope.student.address;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      ApartelleRegistration.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/corporate-affairs/admin-apartelle-registration';

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