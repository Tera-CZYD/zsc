app.controller('MedicalMonthlyAccomplishmentController', function($scope,Select, MedicalMonthlyAccomplishment) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    MedicalMonthlyAccomplishment.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.month = e.month; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  $scope.load(); 

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
  
  $scope.selectedFilter = 'month';

  $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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

      endDate      : $scope.endDate

    });
  
  } 

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/medical_monthly_accomplishment?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/medical_monthly_accomplishment');

    }

  }

});

app.controller('MedicalMonthlyConsumptionController', function($scope,Select, MedicalMonthlyConsumption) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    MedicalMonthlyConsumption.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.month = e.month; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  $scope.load(); 

  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $scope.position_id = null;
 
    $scope.office_id = null;
 
    $scope.employmentStatusId = null;

    $scope.searchTxt = '';

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

  $scope.selectedFilter = 'month';

  $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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

      endDate      : $scope.endDate

    });
  
  } 

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/medical_monthly_consumption?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/medical_monthly_consumption');

    }

  }

});

app.controller('MedicalDailyTreatmentController', function($scope,Select, DailyTreatment) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    DailyTreatment.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.month = e.month; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  $scope.load(); 

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

      endDate      : $scope.endDate

    });
  
  }

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/medical_daily_treaments?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/medical_daily_treaments');

    }

  }

});

app.controller('PropertyEquimentReportController', function($scope,Select, PropertyEquipmentReport) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    PropertyEquipmentReport.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  $scope.load(); 

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

      endDate      : $scope.endDate

    });
  
  } 
   

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/medical_property_equipments?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/medical_property_equipments');

    }

  }

});

app.controller('ConsultationReportController', function($scope,Select, ConsultationReport) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    ConsultationReport.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  $scope.load(); 

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

  $scope.selectedFilter = 'month';

  $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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

      endDate      : $scope.endDate

    });
  
  } 

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/consultation_report?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/consultation_report');

    }

  }

});

app.controller('ConsultationEmployeeReportController', function($scope,Select, ConsultationEmployeeReport) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  
  // console.log("saf");

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    ConsultationEmployeeReport.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  $scope.load(); 

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

  $scope.selectedFilter = 'month';

  $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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

      endDate      : $scope.endDate

    });
  
  }

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/consultation_employee_report?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/consultation_employee_report');

    }

  }

});

app.controller('EmployeeFrequencyReportController', function($scope,Select, EmployeeFrequencyReport) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');


  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    EmployeeFrequencyReport.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data; 

        $scope.conditionsPrint = e.conditionsPrint;     

        //paginator

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);   

      }

    });

  }
  
  $scope.load(); 

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

  $scope.selectedFilter = 'month';

  $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});

  $scope.searchFilter = function(search) {
   
    $scope.searchTxt = '';

    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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

      endDate      : $scope.endDate

    });
  
  } 

  $scope.print = function(){

    if ($scope.conditionsPrint !== ''){

      printTable(base + 'print/employee_frequency_report?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/employee_frequency_report');

    }

  }

});