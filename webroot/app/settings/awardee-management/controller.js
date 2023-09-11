app.controller('AwardeeManagementController', function($scope, AwardeeManagement) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    AwardeeManagement.query(options, function(e) {

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

        AwardeeManagement.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/awardee_management?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/awardee_management?print=1');

    }

  }

});

app.controller('AwardeeManagementAddController', function($scope, AwardeeManagement, Select) {

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

    AwardeeManagement : {}

  }

  Select.get({code: 'awardee-management-code'}, function(e) {

    $scope.data.AwardeeManagement.code = e.data;

    console.log(e);

  });
  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });


  Select.get({code: 'course-list'}, function(e) {

    $scope.course = e.data;

  });
  Select.get({code: 'section-list'}, function(e) {

    $scope.section = e.data;

  });
  Select.get({code: 'award-list'}, function(e) {

    $scope.award = e.data;

  });

  $scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.AwardeeManagement.colleges = val.value;

          Select.get({ code: 'application-program-list', college_id: id }, function(e) {

            $scope.programs = e.data;

            $scope.getProgram($scope.data.AwardeeManagement.program_id);

          });

        }

      });

    }

  }


  $scope.getProgram = function(id){

    if($scope.program.length > 0){

      $.each($scope.program, function(i,val){

        if(val.id == id){

          $scope.data.AwardeeManagement.program = val.value;

        }

      });

    }

  }

  $scope.getSection = function(id){

    if($scope.section.length > 0){

      $.each($scope.section, function(i,val){

        if(val.id == id){

          $scope.data.AwardeeManagement.section = val.value;

        }

      });

    }

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

    $scope.data.AwardeeManagement.student_id = $scope.student.id;

    $scope.data.AwardeeManagement.student_name = $scope.student.name;

    $scope.data.AwardeeManagement.student_no = $scope.student.code;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      $scope.data.AwardeeManagement.amount = number_format($scope.data.AwardeeManagement.amount, 2, '.', '');

      AwardeeManagement.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/settings/awardee-management';

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

app.controller('AwardeeManagementViewController', function($scope, $routeParams, AwardeeManagement) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    AwardeeManagement.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  $scope.print = function(id){
  
    printTable(base + 'print/awardee_management_form/'+id);

  }

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        AwardeeManagement.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/settings/awardee-management";

          }

        });

      }

    });

  } 

});

app.controller('AwardeeManagementEditController', function($scope, $routeParams, AwardeeManagement, Select) {
  
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

    AwardeeManagement : {}

  }

  // load 

  $scope.load = function() {

    AwardeeManagement.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      Select.get({ code: 'application-program-list', college_id: $scope.data.AwardeeManagement.college_id }, function(e) {

        $scope.programs = e.data;

        $scope.getProgram($scope.data.AwardeeManagement.program_id);

      });

      // console.log($scope.data);
    });

  }

  
  Select.get({code: 'awardee-management-code'}, function(e) {

    $scope.data.AwardeeManagement.code = e.data;

    // console.log(e);

  });
  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });


  Select.get({code: 'course-list'}, function(e) {

    $scope.course = e.data;

  });
  Select.get({code: 'section-list'}, function(e) {

    $scope.section = e.data;

  });
  Select.get({code: 'award-list'}, function(e) {

    $scope.award = e.data;

  });

$scope.getCollegeProgram = function(id){

    if($scope.colleges.length > 0){

      $.each($scope.colleges, function(i,val){

        if(val.id == id){

          $scope.data.AwardeeManagement.colleges = val.value;

          Select.get({ code: 'application-program-list', college_id: id }, function(e) {

            $scope.programs = e.data;

            $scope.getProgram($scope.data.AwardeeManagement.program_id);

          });

        }

      });

    }

  }


  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.data.AwardeeManagement.programs = val.value;

        }

      });

    }

  }

  $scope.getSection = function(id){

    if($scope.section.length > 0){

      $.each($scope.section, function(i,val){

        if(val.id == id){

          $scope.data.AwardeeManagement.section = val.value;

        }

      });

    }

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

    $scope.data.AwardeeManagement.student_id = $scope.student.id;

    $scope.data.AwardeeManagement.student_name = $scope.student.name;

    $scope.data.AwardeeManagement.student_no = $scope.student.code;

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AwardeeManagement.update({id:$scope.id}, $scope.data, function(e) {
        // console.log($scope.data);
        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/settings/awardee-management';

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