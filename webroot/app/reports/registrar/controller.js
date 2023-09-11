app.controller('SubjectMasterlistController', function($scope,Select, CollegeProgramReport) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  

   Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getCollegeProgram = function(id){

    $scope.college_id = id;

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getData = function(college_program_id){

    $scope.college_program_id = college_program_id;

    $scope.load({

      college_id: $scope.college_id,

      college_program_id: $scope.college_program_id

    });

  }

  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    CollegeProgramReport.query(options, function(e) {

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

    $scope.college_program_id = null;

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

         college_program_id: $scope.college_program_id

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

        college_program_id: $scope.college_program_id



      });
    
    }
  
  }

  

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/subject_masterlists?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/subject_masterlists');

    }

  }

});

app.controller('EnrollmentListReportController', function($scope, EnrollmentListReport,Select) {

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

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    EnrollmentListReport.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  // $scope.load();

  $scope.getData = function(year_term_id){

    $scope.year_term_id = year_term_id;

    $scope.load({

      year_term_id: $scope.year_term_id

    });

  }
  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.year_term_id = null;

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

        year_term_id  : $scope.year_term_id,

      });

    }else{

      $scope.load({

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        year_term_id  : $scope.year_term_id,

      });
    
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

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');

    }

    $scope.load({

      date           : $scope.dateToday,

      startDate      : $scope.startDate,

      endDate        : $scope.endDate,

      year_term_id   : $scope.year_term_id,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.print = function(){

    if ($scope.conditionsPrint !== '') {
    
      printTable(base + 'print/enrollment_list?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/enrollment_list?print=1');

    }

  }

});

app.controller('ListStudentController', function($scope,Select, ListStudent) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.getData = function(year_term_id){

    $scope.year_term_id = year_term_id;

    $scope.load({

      year_term_id: $scope.year_term_id

    });

  }

  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    ListStudent.query(options, function(e) {

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
 
    $scope.advanceSearch = false;
 
    $scope.position_id = null;
 
    $scope.office_id = null;
 
    $scope.employmentStatusId = null;

    $scope.strSearch = '';

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

        year_term_id: $scope.year_term_id

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        year_term_id: $scope.year_term_id

      });
    
    }
  
  }

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    });

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {
  
    $scope.filter = false;
   
    $scope.advanceSearch = true;
   
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;
 
    $scope.position_id = null;
 
    $scope.office_id = null;
 
    $scope.employmentStatusId = null;

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
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate,

      year_term_id : $scope.year_term_id

    });

    $('#advance-search-modal').modal('hide');
  
  } 

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/student_masterlist?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_masterlist');

    }

  }

});

app.controller('StudentRankingController', function($scope, StudentRanking,Select) {

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

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });
  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentRanking.query(options, function(e) {
      
      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }


  $scope.getFinal = function(){

    $scope.load({
      program_id: $scope.program_id,

      year: $scope.year,

    });

  }


    $scope.getData = function(program_id){

    $scope.load({

      program_id: $scope.program_id,

      year_term_id: $scope.year_term_id,

    });

  }

  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.year_term_id = null;
    $scope.program_id = null;

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

        year_term_id  : $scope.year_term_id,

        program_id  : $scope.program_id,

      });

    }else{

      $scope.load({

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        year_term_id  : $scope.year_term_id,

         program_id  : $scope.program_id,

      });
    
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

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');

    }

    $scope.load({

      date           : $scope.dateToday,

      startDate      : $scope.startDate,

      endDate        : $scope.endDate,

      year_term_id   : $scope.year_term_id,

      program_id   : $scope.program_id,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.print = function(){

    if ($scope.conditionsPrint !== '') {
    
      printTable(base + 'print/student_ranking?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_ranking?print=1');

    }

  }

});

app.controller('PromotedStudentController', function($scope, PromotedStudent,Select) {

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

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });
  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    PromotedStudent.query(options, function(e) {
      
      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }


  $scope.getFinal = function(){

    $scope.load({
      program_id: $scope.program_id,

      year: $scope.year,

    });

  }


  $scope.getData = function(program_id){

    $scope.load({

      program_id: $scope.program_id,

      year_term_id: $scope.year_term_id,

    });

  }

  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.year_term_id = null;
    $scope.program_id = null;

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

        year_term_id  : $scope.year_term_id,

        program_id  : $scope.program_id,

      });

    }else{

      $scope.load({

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        year_term_id  : $scope.year_term_id,

         program_id  : $scope.program_id,

      });
    
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

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');

    }

    $scope.load({

      date           : $scope.dateToday,

      startDate      : $scope.startDate,

      endDate        : $scope.endDate,

      year_term_id   : $scope.year_term_id,

      program_id   : $scope.program_id,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.print = function(){

    if ($scope.conditionsPrint !== '') {
    
      printTable(base + 'print/promoted_student?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/promoted_student?print=1');

    }

  }

});


app.controller('StudentBehaviorReportController', function($scope, StudentBehaviorReport,Select) {

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

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });
  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentBehaviorReport.query(options, function(e) {
     
      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }


  $scope.getFinal = function(){

    $scope.load({
      program_id: $scope.program_id,

      year: $scope.year,

    });

  }


  $scope.getData = function(){

    $scope.load({

      program_id: $scope.program_id,

      year_term_id: $scope.year_term_id,

    });

  }

  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.year_term_id = null;
    $scope.program_id = null;

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

        year_term_id  : $scope.year_term_id,

        program_id  : $scope.program_id,

      });

    }else{

      $scope.load({

        date          : $scope.dateToday,

        startDate     : $scope.startDate,

        endDate       : $scope.endDate,

        year_term_id  : $scope.year_term_id,

         program_id  : $scope.program_id,

      });
    
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

    }else if (search.filterBy == 'custom') {

      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate =  Date.parse(search.endDate).toString('yyyy-MM-dd');

    }

    $scope.load({

      date           : $scope.dateToday,

      startDate      : $scope.startDate,

      endDate        : $scope.endDate,

      year_term_id   : $scope.year_term_id,

      program_id   : $scope.program_id,

    });

    $('#advance-search-modal').modal('hide');

  }

  $scope.print = function(){

    if ($scope.conditionsPrint !== '') {
    
      printTable(base + 'print/report_student_behavior?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/report_student_behavior?print=1');

    }

  }

});

app.controller('AcademicFailuresListController', function($scope,Select, AcademicFailuresList) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  

   Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getCollegeProgram = function(id){


    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getCollegeProgramCourse = function(id){


    Select.get({ code: 'program-course-list', id : id }, function(e) {

      $scope.courses = e.data;

    });

  }

  $scope.getDatas = function(college_program_id){

    if($scope.term != undefined){

    $scope.load({

      college_id: $scope.college_id,

      college_program_id: $scope.college_program_id,

      program_course_id : $scope.course_program_id,

      term : $scope.term

    });
  }

  }

  $scope.filterTerm = function(term){


    $scope.load({

      college_id: $scope.college_id,

      college_program_id: $scope.college_program_id,

      program_course_id : $scope.course_program_id,

      term : term

    });

  }

  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    AcademicFailuresList.query(options, function(e) {

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

    $scope.college_program_id = null;

    $scope.course_program_id= null;

    $scope.term = null;

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

         college_program_id: $scope.college_program_id

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

        college_program_id: $scope.college_program_id,

        term : $scope.term



      });
    
    }
  
  }

  

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/academic_failures_list?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/academic_failures_list');

    }

  }

});

app.controller('StudentClubListController', function($scope,Select, StudentClubList) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  

  Select.get({ code: 'club-list' }, function(e) {

    $scope.clubs = e.data;

  });


  $scope.getDatas = function(id){

    $scope.load({

      club_id : id

    });
  
  }


  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentClubList.query(options, function(e) {

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

    $scope.club_id = null;

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

        endDate   : $scope.endDate


      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        club_id : $scope.club_id

      });
    
    }
  
  }

  

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/student_club_list?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/student_club_list');

    }

  }

});


app.controller('AcademicListController', function($scope,Select, AcademicList) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });


  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  
  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

  $scope.getCollegeProgram = function(id){

    $scope.college_id = id;

    Select.get({ code: 'application-program-list', college_id : id }, function(e) {

      $scope.programs = e.data;

    });

  }

  $scope.getData = function(semester){


    $scope.load({
      semester: $scope.semester,
      section_id: $scope.section_id,
      year: $scope.year,
      college_id: $scope.college_id,

      program_id: $scope.program_id,

    });

  }



  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    AcademicList.query(options, function(e) {

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
 
    $scope.advanceSearch = false;
 
    $scope.position_id = null;
 
    $scope.office_id = null;
 
    $scope.employmentStatusId = null;

    $scope.section_id = null;

    $scope.strSearch = '';

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

        section_id: $scope.section_id

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        section_id: $scope.section_id

      });
    
    }
  
  }

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    });

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {
  
    $scope.filter = false;
   
    $scope.advanceSearch = true;
   
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;
 
    $scope.position_id = null;
 
    $scope.office_id = null;
 
    $scope.employmentStatusId = null;

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
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate,

      section_id : $scope.section_id

    });

    $('#advance-search-modal').modal('hide');
  
  } 

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/academic_list?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/academic_list');

    }

  }

});

app.controller('ListAcademicAwardeeController', function($scope,Select, ListAcademicAwardee) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

   Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

   Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });
   
  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    ListAcademicAwardee.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }

  $scope.getFinal = function(){

    $scope.load({

      college_id: $scope.college_id,
      
      program_id: $scope.program_id,

      year: $scope.year,

      award: $scope.award,

    });

  }


    $scope.getData = function(){

    $scope.load({

      college_id: $scope.college_id,

      program_id: $scope.program_id,

      year_term_id: $scope.year_term_id,

      award: $scope.award,

    });

  }

    $scope.award = '';

    $scope.awardMatch = function(studentAward) {

      return studentAward === $scope.award;

    };

  // $scope.load(); 

  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';

    $scope.choice = '';

    $scope.datas = [];
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

    $scope.year_term_id = null;

    $scope.college_id = null;

    $scope.program_id = null;
    $scope.award = null;

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

        program_id : $scope.program_id,

         year_term_id  : $scope.year_term_id,

         award   : $scope.award,

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

        program_id : $scope.program_id,

        year_term_id  : $scope.year_term_id,
        
        award   : $scope.award,

      });
    
    }
  
  }

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    });

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {
  
    $scope.filter = false;
   
    $scope.advanceSearch = true;
   
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;
 
    $scope.position_id = null;
 
    $scope.office_id = null;
 
    $scope.employmentStatusId = null;

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
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate,

      year_term_id   : $scope.year_term_id,

      college_id : $scope.college_id,

      program_id   : $scope.program_id,
      award   : $scope.award,

    });

    $('#advance-search-modal').modal('hide');
  
  } 
  

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/list_academic_awardees?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/list_academic_awardees');

    }

  }

});

app.controller('GWAController', function($scope,Select, GWA) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

   Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });

   
  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });


  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    GWA.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }




    $scope.getData = function(){

    $scope.load({

      college_id: $scope.college_id,

      program_id: $scope.program_id,

      section_id: $scope.section_id,
      // award: $scope.award,

    });

  }



  // $scope.load(); 

  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';

    $scope.choice = '';

    $scope.datas = [];
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;


    $scope.college_id = null;

    $scope.program_id = null;

    $scope.section_id = null;

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

        program_id : $scope.program_id,

        section_id : $scope.section_id,
      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        college_id : $scope.college_id,

        program_id : $scope.program_id,

        section_id : $scope.section_id,
      });
    
    }
  
  }

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({
 
      format: 'mm/dd/yyyy'

    });

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {
  
    $scope.filter = false;
   
    $scope.advanceSearch = true;
   
    $scope.searchTxt = '';
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;
 
    $scope.position_id = null;
 
    $scope.office_id = null;
 
    $scope.employmentStatusId = null;

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
    
    }

    $scope.load({

      date         : $scope.dateToday,

      startDate    : $scope.startDate,

      endDate      : $scope.endDate,


      college_id : $scope.college_id,

      program_id   : $scope.program_id,
      section_id : $scope.section_id,

    });

    $('#advance-search-modal').modal('hide');
  
  } 
  

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/gwa?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/gwa');

    }

  }

});

app.controller('EnrollmentProfileController', function($scope,Select, EnrollmentProfile) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

   Select.get({ code: 'program-list' }, function(e) {

    $scope.programs = e.data;

  });

  Select.get({ code: 'college-list' }, function(e) {

    $scope.colleges = e.data;

  });
  
  Select.get({ code: 'section-list' }, function(e) {

    $scope.sections = e.data;

  });

  Select.get({ code: 'year-term-list' }, function(e) {

    $scope.years = e.data;

  });

  $scope.getData = function(year_term_id){

    year_term_id: $scope.year_term_id

    $scope.load({

      college_id: $scope.college_id,

      section_id: $scope.section_id,

      course_id: $scope.course_id,

      year_term_id: $scope.year_term_id

    });

  }

  $scope.datas = '';

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    EnrollmentProfile.query(options, function(e) {

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

    $scope.section_id = null;

    $scope.college_id = null;

    $scope.year_term_id = null

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

        program_id : $scope.program_id,

        college_id : $scope.college_id,

        section_id : $scope.section_id,

        year_term_id: $scope.year_term_id

      });

    }else{

      $scope.load({

        date      : $scope.dateToday,

        startDate : $scope.startDate,

        endDate   : $scope.endDate,

        program_id : $scope.program_id,

        college_id : $scope.college_id,

        section_id : $scope.section_id,

        year_term_id: $scope.year_term_id

      });
    
    }
  
  }

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/enrollment_profile?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/enrollment_profile');

    }

  }

});