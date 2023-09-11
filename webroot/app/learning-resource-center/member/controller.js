app.controller('MemberController', function($scope, Member, Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.student = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['member_type'] = 'STUDENT';

    Member.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.faculty = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['member_type'] = 'FACULTY';

    Member.query(options, function(e) {

      if (e.ok) {

        $scope.datasFaculty = e.data;

        $scope.conditionsPrintFaculty = e.conditionsPrint;

        // paginator

        $scope.paginatorFaculty  = e.paginator;

        $scope.pagesFaculty = paginator($scope.paginatorFaculty, 5);

      }

    });

  }

  $scope.admin = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['member_type'] = 'ADMIN';

    Member.query(options, function(e) {

      if (e.ok) {

        $scope.datasAdmin = e.data;

        $scope.conditionsPrintAdmin = e.conditionsPrint;

        $scope.paginatorAdmin = e.paginator;

        $scope.pagesAdmin = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load = function(options) {

    $scope.student(options);

    $scope.faculty(options);

    $scope.admin(options);

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

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  $scope.advance_search = function() {

    $scope.search = {};

    $scope.advanceSearch = false;

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

    $scope.advSearch = '';

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;

    $scope.college = null;

    $scope.program = null;

    $scope.faculty_status = null;

   

    if (search.filterBy == 'today') {

      $scope.dateToday = Date.parse('today').toString('yyyy-MM-dd');

      $scope.today = Date.parse('today').toString('yyyy-MM-dd');

      $scope.dateToday = $scope.today;

    } else if (search.filterBy == 'date') {

      $scope.dateToday = Date.parse(search.date).toString('yyyy-MM-dd');

    }else if (search.filterBy == 'month') {

      date = $('.monthpicker').datepicker('getDate');

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

    }else if (search.filterBy == 'this-month') {

      date = new Date();

      year = date.getFullYear();

      month = date.getMonth() + 1;

      lastDay = new Date(year, month, 0);

      if (month < 10) month = '0' + month;

      $scope.startDate = year + '-' + month + '-01';

      $scope.endDate = year + '-' + month + '-' + lastDay.getDate();

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');


    } else if (search.filterBy == 'college') {

        $scope.college = $scope.search.college;

    } else if (search.filterBy == 'program') {

        $scope.program = $scope.search.program;

    } else if (search.filterBy == 'faculty_status') {

      $scope.faculty_status = $scope.search.faculty_status;

    }
    
    $scope.load({

      college    : $scope.college,

      program    : $scope.program,

      faculty_status :$scope.faculty_status,

      date        : $scope.dateToday,

      startDate   : $scope.startDate,

      endDate     : $scope.endDate,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.member_name +' ?', function(c) {

      if (c) {

        Member.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/student_member?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_member?print=1');

    }

  }

  $scope.printFaculty = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/faculty_member?print=1' + $scope.conditionsPrintFaculty);

    }else{

      printTable(base + 'print/faculty_member?print=1');

    }

  }

  $scope.printAdmin = function() {

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/admin_member?print=1' + $scope.conditionsPrintAdmin);

    }else{

      printTable(base + 'print/admin_member?print=1');

    }

  }

  $scope.export = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_member?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/export_member?print=1');

    }

    // Select.get({code: 'daily-list-collection-export'}, function(e){});

  }

  $scope.exportFaculty = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_member_faculty?print=1' + $scope.conditionsPrintFaculty);

    }else{

      printTable(base + 'print/export_member_faculty?print=1');

    }

    // Select.get({code: 'daily-list-collection-export'}, function(e){});

  }

  $scope.exportAdmin = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_member_admin?print=1' + $scope.conditionsPrintAdmin);

    }else{

      printTable(base + 'print/export_member_admin?print=1');

    }

    // Select.get({code: 'daily-list-collection-export'}, function(e){});

  }

});

app.controller('MemberAddController', function($scope, Member, Select) {

  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

 Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

 Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  $scope.data = {

    Member : {

      date : $scope.today

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Member.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/learning-resource-center/member';

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

app.controller('MemberViewController', function($scope, $routeParams, Member) {

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.id = $routeParams.id;

  $scope.data = {

    Member:{}

  };

  // load 

  $scope.load = function() {

    Member.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load(); 

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.member_name +' ?', function(c) {

      if (c) {

        Member.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/learning-resource-center/member";

          }

        });

      }

    });

  } 

});

app.controller('MemberEditController', function($scope, $routeParams, Member, Select) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  Select.get({ code: "college-program-list-all" }, function (e) {

    $scope.programs = e.data;

  });

  $scope.data = {

    Member : {}

  }
  // load 

  $scope.load = function() {

    Member.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Member.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/learning-resource-center/member';

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