app.controller('YearLevelTermController', function($scope, YearLevelTerm) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    YearLevelTerm.query(options, function(e) {

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

        YearLevelTerm.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/YearLevelTerm?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/YearLevelTerm?print=1');

    }

  }

});

app.controller('YearLevelTermAddController', function($scope, YearLevelTerm, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.getOrder = function(educational_level){

    Select.get({ code: 'year-term-list',educational_level : educational_level}, function (e){

      $scope.year_level_terms = e.data;

    });

  }

  $scope.before_yes_change = function(){

    $scope.data.YearLevelTerm.last_yes = false;

    $scope.data.YearLevelTerm.order_disable = false;

  }

  $scope.last_yes_change = function(){

    $scope.data.YearLevelTerm.before_yes = false;

    $scope.data.YearLevelTerm.order_disable = true;

    $scope.data.YearLevelTerm.chronological_order_id = null;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      YearLevelTerm.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/year-level-term';

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

app.controller('YearLevelTermViewController', function($scope, $routeParams, DeleteSelected, YearLevelTerm, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    YearLevelTerm.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.description +' ?', function(c) {

      if (c) {

        YearLevelTerm.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/year-level-term";

          }

        });

      }

    });

  } 

});

app.controller('YearLevelTermEditController', function($scope, $routeParams, YearLevelTerm, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  // load 

  $scope.load = function() {

    YearLevelTerm.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.getOrder($scope.data.YearLevelTerm.educational_level);

    });

  }

  $scope.load();

  $scope.getOrder = function(educational_level){

    Select.get({ code: 'year-term-list',educational_level : educational_level,id : $scope.id }, function (e){

      $scope.year_level_terms = e.data;

    });

  }

  $scope.before_yes_change = function(){

    $scope.data.YearLevelTerm.last_yes = false;

    $scope.data.YearLevelTerm.order_disable = false;

  }

  $scope.last_yes_change = function(){

    $scope.data.YearLevelTerm.before_yes = false;

    $scope.data.YearLevelTerm.order_disable = true;

    $scope.data.YearLevelTerm.chronological_order_id = null;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      YearLevelTerm.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/year-level-term';

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