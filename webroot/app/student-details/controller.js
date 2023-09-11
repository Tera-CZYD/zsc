app.controller('StudentDetailController', function($scope, Student,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'college-list'}, function (e){

    $scope.colleges = e.data;

  });

  Select.get({ code: 'degree-list'}, function (e){

    $scope.degrees = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Student.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.header = e.header;

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
 
    $scope.college_id = null;
 
    $scope.degree_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search      : search,

        date        : $scope.dateToday,

        startDate   : $scope.startDate,

        endDate     : $scope.endDate,

        college_id  : $scope.college_id,

        degree_id   : $scope.degree_id

      });

    }else{

      $scope.load({

        date        : $scope.dateToday,

        startDate   : $scope.startDate,

        endDate     : $scope.endDate,

        college_id  : $scope.college_id,

        degree_id   : $scope.degree_id

      });
    
    }

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.student_no +' ?', function(c) {

      if (c) {

        Student.remove({ id: data.id }, function(e) {

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

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.yearpicker').datepicker({

      format: 'yyyy', 

      autoclose: true, 

      minViewMode: 'years',

      maxViewMode:'years'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });
 
    $('.monthpicker').datepicker({

      format: 'MM', 

      autoclose: true, 

      minViewMode: 'months',

      maxViewMode:'months'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });

    $('.datepicker').datepicker({

      format:    'mm/dd/yyyy',

      autoclose: true,

      todayHighlight: true,

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    }).on('show', function(e){
    
      if ( e.date ) {
      
        $(this).data('stickyDate', e.date);
      
      } else if($(this).val()){
      
        /**auto-populate existing selection*/
      
        $(this).data('stickyDate', new Date($(this).val()));
      
        $(this).datepicker('setDate', new Date($(this).val()));
      
      } else {
      
        $(this).data('stickyDate', null);
      
      }
    
    }).on('hide', function(e){
    
      var stickyDate = $(this).data('stickyDate');

      if ( !e.date && stickyDate ) {

        $(this).datepicker('setDate', stickyDate);

        $(this).data('stickyDate', null);

      }
    
    });

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {

    $scope.filter = false;

    $scope.advanceSearch = true;

    $scope.dateToday = null;

    $scope.startDate = null;

    $scope.endDate = null;
 
    $scope.college_id = null;
 
    $scope.degree_id = null;

    if (search.filterBy == 'today') {
     
      $scope.dateToday = Date.parse($scope.today).toString('yyyy-MM-dd');

    }else if (search.filterBy == 'date') {

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
   
    }else if (search.filterBy == 'custom-range') {
    
      $scope.startDate = search.startDate;
    
      $scope.endDate = search.endDate;
    
    }else if (search.filterBy == 'year') {
   
      year = search.year;
      
      $scope.startDate = year + '-01-01';
      
      $scope.endDate = year + '-12-31';

    }

    if(search.college_id !== null && search.college_id !== '' && search.college_id !== undefined){

      $scope.college_id = search.college_id;

    }

    if(search.degree_id !== null && search.degree_id !== '' && search.degree_id !== undefined){

      $scope.degree_id = search.degree_id;

    }

    $scope.load({

      date        : $scope.dateToday,

      startDate   : $scope.startDate,

      endDate     : $scope.endDate,

      college_id  : $scope.college_id,

      degree_id   : $scope.degree_id

    });

    $('#advance-search-modal').modal('hide');
  
  }

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/students?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/students?print=1');

    }

  }

});

app.controller('StudentDetailAddController', function($scope, Student, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({ code: 'college-list'}, function (e){

    $scope.colleges = e.data;

  });

  Select.get({ code: 'degree-list'}, function (e){

    $scope.degrees = e.data;

  });

  Select.get({ code: 'income-list'}, function (e){

    $scope.incomes = e.data;

  });

  Select.get({ code: 'province-list'}, function (e){

    $scope.provinces = e.data;

  });

  Select.get({ code: 'student-department-list'}, function (e){

    $scope.departments = e.data;

  });

  Select.get({ code: 'student-program-list'}, function (e){

    $scope.programs = e.data;

  });

  Select.get({ code: 'student-curriculum-list'}, function (e){

    $scope.curriculums = e.data;

  });

  $scope.getTown = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'town-list',province_id: id}, function (e){

        $scope.towns = e.data;

      });

    }else{

      $scope.towns = [];

    }

  }

  $scope.getBarangay = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'barangay-list',town_id: id}, function (e){

        $scope.barangays = e.data;

      });

      Select.get({ code: 'zip-list',town_id: id}, function (e){

        $scope.data.StudentProfile.zip_code = e.data;

      });

    }else{

      $scope.barangays = [];
      
    }

  }

  $scope.cancel = function(){ 

    bootbox.confirm('Are you sure you want to cancel this transaction ?', function(b){

      if(b) {
        
        window.location = '#/student-details'; 

      }

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Student.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/student-details';

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

app.controller('StudentDetailViewController', function($scope, $routeParams, DeleteSelected, Student, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Student.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.student_no +' ?', function(c) {

      if (c) {

        Student.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/student-details";

          }

        });

      }

    });

  } 

});

app.controller('StudentDetailEditController', function($scope, $routeParams, Student, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  Select.get({ code: 'college-list'}, function (e){

    $scope.colleges = e.data;

  });

  Select.get({ code: 'degree-list'}, function (e){

    $scope.degrees = e.data;

  });

  Select.get({ code: 'income-list'}, function (e){

    $scope.incomes = e.data;

  });

  Select.get({ code: 'province-list'}, function (e){

    $scope.provinces = e.data;

  });

  Select.get({ code: 'student-department-list'}, function (e){

    $scope.departments = e.data;

  });

  Select.get({ code: 'student-program-list'}, function (e){

    $scope.programs = e.data;

  });

  Select.get({ code: 'student-curriculum-list'}, function (e){

    $scope.curriculums = e.data;

  });

  // load 

  $scope.load = function() {

    Student.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.getTown($scope.data.StudentProfile.province_id);

      $scope.getBarangayLoad($scope.data.StudentProfile.town_id);

    });

  }

  $scope.load();

  $scope.getTown = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'town-list',province_id: id}, function (e){

        $scope.towns = e.data;

      });

    }else{

      $scope.towns = [];

    }

  }

  $scope.getBarangayLoad = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'barangay-list',town_id: id}, function (e){

        $scope.barangays = e.data;

      });

    }else{

      $scope.barangays = [];
      
    }

  }

  $scope.getBarangay = function(id){

    if(id !== undefined && id !== '' && id !== null){

      Select.get({ code: 'barangay-list',town_id: id}, function (e){

        $scope.barangays = e.data;

      });

      Select.get({ code: 'zip-list',town_id: id}, function (e){

        $scope.data.StudentProfile.zip_code = e.data;

      });

    }else{

      $scope.barangays = [];
      
    }

  }

  $scope.cancel = function(){ 

    bootbox.confirm('Are you sure you want to cancel this transaction ?', function(b){

      if(b) {
        
        window.location = '#/student-details'; 

      }

    });

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Student.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/student-details';

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