app.controller('AcademicTermController', function($scope, $window, AcademicTerm) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    AcademicTerm.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator = e.paginator;

        $scope.conditionsPrint = e.conditionsPrint;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.scrollToTop = function() {

    $window.scrollTo(0, 0);

  };

  $scope.scrollToTop();

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

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.name +' ?', function(c) {

      if (c) {

        AcademicTerm.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/academic_terms?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/academic_terms?print=1');

    }

  }

});

app.controller('AcademicTermAddController', function($scope, AcademicTerm, Select) {

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

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.data = {

    AcademicTerm : {}

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      AcademicTerm.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/academic-terms';

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

app.controller('AcademicTermEditController', function($scope, $routeParams, AcademicTerm, Select) {
  
  $scope.id = $routeParams.id;

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

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  $scope.data = {

    AcademicTerm : {}

  }

  // load 

  $scope.load = function() {

    AcademicTerm.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AcademicTerm.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/academic-terms';

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