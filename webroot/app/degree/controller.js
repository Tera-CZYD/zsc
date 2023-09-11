app.controller('DegreeController', function($scope, Degree,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Degree.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();

  $scope.getDepartment = function(id){

    if(id !== undefined && id !== null && id !== ''){

      Select.get({ code: 'college-department-list',id : id },function(e){

        $scope.college_departments = e.data;

      });

    }else{

      $scope.college_departments = [];

      $scope.programs = [];

    }

  }

  $scope.getProgram = function(id){

    if(id !== undefined && id !== null && id !== ''){

      Select.get({ code: 'college-department-program-list',id : id },function(e){

        $scope.programs = e.data;

      });

    }else{

      $scope.programs = [];

    }

  }
  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';
   
    $scope.term_id = null;
   
    $scope.college_id = null;
   
    $scope.department_id = null;
   
    $scope.program_id = null;

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search: search,

        term_id : $scope.term_id,

        college_id : $scope.college_id,

        department_id : $scope.department_id,

        program_id : $scope.program_id

      });

    } else {

      $scope.load({

        term_id : $scope.term_id,

        college_id : $scope.college_id,

        department_id : $scope.department_id,

        program_id : $scope.program_id

      });
    
    }

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        Degree.remove({ id: data.id }, function(e) {

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
 
    $('.monthpicker').datepicker({format: 'MM', autoclose: true, minViewMode: 'months',maxViewMode:'months'});
 
    $('.input-daterange').datepicker({format: 'mm/dd/yyyy'});

    $('#advance-search-modal').modal('show');

  }

  $scope.searchFilter = function(search) {
  
    $scope.filter = false;
   
    $scope.advanceSearch = true;
   
    $scope.term_id = null;
   
    $scope.college_id = null;
   
    $scope.department_id = null;
   
    $scope.program_id = null;

    if(search.term_id !== null && search.term_id !== '' && search.term_id !== undefined){

      $scope.term_id = search.term_id;

    }

    if(search.college_id !== null && search.college_id !== '' && search.college_id !== undefined){

      $scope.college_id = search.college_id;

    }

    if(search.department_id !== null && search.department_id !== '' && search.department_id !== undefined){

      $scope.department_id = search.department_id;

    }

    if(search.program_id !== null && search.program_id !== '' && search.program_id !== undefined){

      $scope.program_id = search.program_id;

    }

    $scope.load({

      term_id : $scope.term_id,

      college_id : $scope.college_id,

      department_id : $scope.department_id,

      program_id : $scope.program_id

    });

    $('#advance-search-modal').modal('hide');
  
  } 

  $scope.print = function(){

    date = "";
    
    if ($scope.conditionsPrint !== '') {
    

      printTable(base + 'print/college_blocks?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/college_blocks?print=1');

    }

  }

});

app.controller('DegreeAddController', function($scope, Degree, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  Select.get({ code: 'table-of-fees-list' },function(e){

    $scope.fees = e.data;

  });

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Degree.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/degree';

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

app.controller('DegreeViewController', function($scope, $routeParams, DeleteSelected, Degree, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Degree.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Degree.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/degree";

          }

        });

      }

    });

  } 

});

app.controller('DegreeEditController', function($scope, $routeParams, Degree, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('.yearpicker').datepicker({

    format: "yyyy",

    autoclose: true,

    minViewMode: "years",

    pickTime: false

  });

  Select.get({ code: 'table-of-fees-list' },function(e){

    $scope.fees = e.data;

  });

  // load 
  $scope.load = function() {

    Degree.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Degree.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/degree';

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