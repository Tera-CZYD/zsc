app.controller('StudentProfileController', function($scope, StudentProfile,Select) {

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

  Select.get({ code: 'college-program-list-all' },function(e){

    $scope.college_programs = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentProfile.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  // $scope.load();

  $scope.getData = function(college_program_id){

    $scope.college_program_id = college_program_id;

    $scope.load({

      college_program_id: $scope.college_program_id

    });

  }
  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.college_program_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search        : search,

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        college_program_id  : $scope.college_program_id,

      });

    }else{

      $scope.load({

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        college_program_id  : $scope.college_program_id,

      });
    
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

    $scope.year_term_id = null;

    $scope.college_program_id = null;

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

      year_term_id : $scope.year_term_id,

      college_program_id: $scope.college_program_id

    });
  
  } 
  $scope.print = function(){

    if ($scope.conditionsPrint !== '') {
    
      printTable(base + 'print/student_profiles?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_profiles?print=1');

    }

  }

  $scope.export = function(){

    if ($scope.conditionsPrint !== undefined && $scope.conditionsPrint !== ''){

      printTable(base + 'print/export_student_profiles?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/export_student_profiles?print=1');

    }

    // Select.get({code: 'daily-list-collection-export'}, function(e){});

  }

});

app.controller('StudentProfileViewController', function($scope, $routeParams, StudentProfile, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    StudentProfile.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.requirements = e.requirements;

      $scope.applicationImage = e.applicationImage;

      console.log($scope.data);

    });

  }

  $scope.load();  

  $scope.print = function (id) {
  
    printTable(base + "print/certificate_registrations/" + id);
  
  };

});