app.controller('FacultyMasterlistController', function($scope,Select, FacultyMasterlist) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

   Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getData = function(college_id){

    $scope.college_id = college_id;

    $scope.load({

      college_id: $scope.college_id

    });

  }

  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    FacultyMasterlist.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  // $scope.load(); 

  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.college_id = null;

    // $scope.college_program_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {
    
    search = typeof search !== 'undefined' ?  search : '';

    $scope.searchTxts = search;

    if (search.length > 0){

      $scope.load({

        search    : search,

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

         // college_program_id: $scope.college_program_id

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

        // college_program_id: $scope.college_program_id



      });
    
    }
  
  }

  

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/faculty_masterlists?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/faculty_masterlists');

    }

  }

});

app.controller('ListAcademicProgramController', function($scope,Select, ListAcademicProgram) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

   Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getData = function(college_id){

    $scope.college_id = college_id;

    $scope.load({

      college_id: $scope.college_id

    });

  }

  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    ListAcademicProgram.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  // $scope.load(); 

  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.college_id = null;

    // $scope.college_program_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {
    
    search = typeof search !== 'undefined' ?  search : '';

    $scope.searchTxts = search;

    if (search.length > 0){

      $scope.load({

        search    : search,

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

         // college_program_id: $scope.college_program_id

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

        // college_program_id: $scope.college_program_id



      });
    
    }
  
  }

  

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/class_programs?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/class_programs');

    }

  }

});