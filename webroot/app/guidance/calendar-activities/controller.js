app.controller('CalendarActivityController', function($scope, CalendarActivity, $compile) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    CalendarActivity.query(options, function(e) {

      if (e.ok) {

        $scope.activities = e.data;



        $scope.conditionsPrint = e.conditionsPrint;

        //pagination

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

        endDate   : $scope.endDate

      });
    
    }
  
  }

  $scope.advanceSearch = false;
  
  $scope.advance_search = function() {
  
    $scope.search = {};
 
    $scope.advanceSearch = false;
 
    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({format: 'mm/dd/yyyy'});

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {
  
    $scope.filter = false;
   
    $scope.advanceSearch = true;
   
    $scope.dateToday = null;
   
    $scope.startDate = null;
   
    $scope.endDate = null;

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
    
      $scope.startDate = Date.parse(search.startDate).toString('yyyy-MM-dd');

      $scope.endDate = Date.parse(search.endDate).toString('yyyy-MM-dd');
    
    }

    $scope.load({

      date : $scope.dateToday,

      startDate : $scope.startDate,

      endDate : $scope.endDate

    });

    $('#advance-search-modal').modal('hide');
  
  } 

  $scope.printActivity = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/activities?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/activities?print=1');

    }

  }

  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        CalendarActivity.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load();

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

            $scope.load();

          }

        });

      }

    });

  } 

  $scope.eventRender = function( event, element, view ) { 

    element.attr({'tooltip': event.title,'tooltip-append-to-body': true});

    $compile(element)($scope);

  };

		
  $scope.print = function(){
  
    date = '';
  
    printTable(base + 'print/calendar');
  
  } 

});

app.controller('CalendarActivityAddController', function($scope, CalendarActivity, Select) {

  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CalendarActivity : {}

  };

  Select.get({code: 'calendar-activity-code'}, function(e) {

    $scope.data.CalendarActivity.code = e.data;

  });

  $scope.save = function() {

    console.log($scope.data);

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $('#save').attr('disabled', true);

      CalendarActivity.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/calendar-activities';

        } else {

          $('#save').attr('disabled', false);

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }

  }

});

app.controller('CalendarActivityViewController', function($scope, CalendarActivity, $routeParams) {

  $scope.data = {};

  $scope.id = $routeParams.id;

  // load 

  $scope.load = function() {

    CalendarActivity.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        CalendarActivity.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/guidance/calendar-activities";

          }

        });

      }

    });

  } 

});

app.controller('CalendarActivityEditController', function($scope, CalendarActivity, $routeParams, Select) {
  
  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    CalendarActivity : {}

  };

  $scope.id = $routeParams.id;


  // load 

  $scope.load = function() {

    CalendarActivity.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      $('#save').attr('disabled', true);

      CalendarActivity.update({ id : $scope.id }, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/guidance/calendar-activities';

        } else {

          $('#save').attr('disabled', false);

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }

  }

}); 









