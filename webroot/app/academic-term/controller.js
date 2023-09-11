app.controller('AcademicTermController', function($scope, AcademicTerm) {

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

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.description +' ?', function(c) {

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
    

      printTable(base + 'print/AcademicTerm?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/AcademicTerm?print=1');

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

  Select.get({ code: 'academic-term-list'}, function (e){

    $scope.academic_terms = e.data;

  });

  $scope.before_yes_change = function(){

    $scope.data.AcademicTerm.last_yes = false;

    $scope.data.AcademicTerm.order_disable = false;

  }

  $scope.last_yes_change = function(){

    $scope.data.AcademicTerm.before_yes = false;

    $scope.data.AcademicTerm.order_disable = true;

    $scope.data.AcademicTerm.chronological_order_id = null;

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

          window.location = '#/academic-term';

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

app.controller('AcademicTermViewController', function($scope, $routeParams, DeleteSelected, AcademicTerm, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    AcademicTerm.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.description +' ?', function(c) {

      if (c) {

        AcademicTerm.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/academic-term";

          }

        });

      }

    });

  } 

});

app.controller('AcademicTermEditController', function($scope, $routeParams, AcademicTerm, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  // load 

  $scope.load = function() {

    AcademicTerm.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.getOrder($scope.data.AcademicTerm.educational_level);

    });

  }

  $scope.load();

  $scope.getOrder = function(educational_level){

    Select.get({ code: 'academic-term-list',id : $scope.id}, function (e){

      $scope.academic_terms = e.data;

    });

  }

  $scope.before_yes_change = function(){

    $scope.data.AcademicTerm.last_yes = false;

    $scope.data.AcademicTerm.order_disable = false;

  }

  $scope.last_yes_change = function(){

    $scope.data.AcademicTerm.before_yes = false;

    $scope.data.AcademicTerm.order_disable = true;

    $scope.data.AcademicTerm.chronological_order_id = null;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      AcademicTerm.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/academic-term';

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