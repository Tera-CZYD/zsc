app.controller('CollegeController', function($scope, College) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    College.query(options, function(e) {

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

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        College.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/college?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/college?print=1');

    }

  }

});

app.controller('CollegeAddController', function($scope, College, Select) {

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

  $scope.data = {

    College : {},

    CollegeSub : []

  };

  Select.get({ code: 'campus-list' },function(e){

    $scope.campuses = e.data;

  });

  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.sub.program = val.value;

        }

      });

    }

  }

  // add program

  $scope.addProgram = function() {

    $('#program_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-program-modal').modal('show');

  }
  
  $scope.saveProgram = function(data) {

    valid = $("#program_form").validationEngine('validate');

    if(valid){

      $scope.data.CollegeSub.push(data);
      
      $('#add-program-modal').modal('hide');

    }

  }

  $scope.editProgram = function(index,data) {

    $('#edit_program_form').validationEngine('attach');
    
    data.index = index;

    $scope.sub = data;

    $('#edit-program-modal').modal('show');

  }
  
  $scope.updateProgram = function(data) {

    valid = $("#edit_program_form").validationEngine('validate');

    if(valid){

      $scope.data.CollegeSub[data.index] = data;
      
      $('#edit-program-modal').modal('hide');

    }

  }
  
  $scope.removeProgram = function(index) {

    $scope.data.CollegeSub.splice(index,1);

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      College.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/college';

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

app.controller('CollegeViewController', function($scope, $routeParams, DeleteSelected, College, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    College.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        College.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/college";

          }

        });

      }

    });

  } 

});

app.controller('CollegeEditController', function($scope, $routeParams, College, Select) {
  
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

  $scope.data = {

    College : {},

    CollegeSub : []

  };


  Select.get({ code: 'program-list' },function(e){

    $scope.programs = e.data;

  });

  $scope.getProgram = function(id){

    if($scope.programs.length > 0){

      $.each($scope.programs, function(i,val){

        if(val.id == id){

          $scope.sub.program = val.value;

        }

      });

    }

  }

  // load 
  $scope.load = function() {

    College.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  // add program

  $scope.addProgram = function() {

    $('#program_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-program-modal').modal('show');

  }
  
  $scope.saveProgram = function(data) {

    valid = $("#program_form").validationEngine('validate');

    if(valid){

      console.log($scope.data.CollegeSub)

      $scope.data.CollegeSub.push(data);
      
      $('#add-program-modal').modal('hide');

    }

  }

  $scope.editProgram = function(index,data) {

    $('#edit_program_form').validationEngine('attach');
    
    data.index = index;

    $scope.sub = data;

    $('#edit-program-modal').modal('show');

  }
  
  $scope.updateProgram = function(data) {

    valid = $("#edit_program_form").validationEngine('validate');

    if(valid){

      $scope.data.CollegeSub[data.index] = data;
      
      $('#edit-program-modal').modal('hide');

    }

  }
  
  $scope.removeProgram = function(index) {

    $scope.data.CollegeSub.splice(index,1);

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      College.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/college';

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