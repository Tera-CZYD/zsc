app.controller('IllnessRecommendationController', function($scope, IllnessRecommendation) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    IllnessRecommendation.query(options, function(e) {

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

    bootbox.confirm('Are you sure you want to delete ' + data.ailment +' ?', function(c) {

      if (c) {

        IllnessRecommendation.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/illness_recommendations?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/illness_recommendations?print=1');

    }

  }

});

app.controller('IllnessRecommendationAddController', function($scope, IllnessRecommendation, Select) {

 $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    IllnessRecommendation : {},

    IllnessRecommendationSub : []

  }

  Select.get({ code: "prescription-list" }, function (e) {

    $scope.prescriptions = e.data;

  });

  $scope.addPrescription = function() {

    $('#prescription_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-prescription-modal').modal('show');

  }
  
  $scope.savePrescription = function(data) {

    valid = $("#prescription_form").validationEngine('validate');

    if(valid){

      $scope.data.IllnessRecommendationSub.push(data);
      
      $('#add-prescription-modal').modal('hide');

    }

  }

  $scope.editPrescription = function(index,data) {

    $('#edit_prescription_form').validationEngine('attach');
    
    data.index = index;

    $scope.sub = data;

    $('#edit-prescription-modal').modal('show');

  }
  
  $scope.updatePrescription = function(data) {

    valid = $("#edit_prescription_form").validationEngine('validate');

    if(valid){

      $scope.data.IllnessRecommendationSub[data.index] = data;
      
      $('#edit-prescription-modal').modal('hide');

    }

  }
  
  $scope.removePrescription = function(index) {

    $scope.data.IllnessRecommendationSub.splice(index,1);

  }

  $scope.getPrescription = function(id) {

    if($scope.prescriptions.length > 0) {

      $.each($scope.prescriptions, function(i, val) {

        if(val.id == id) {

          $scope.sub.prescription = val.value;

        }

      });

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      IllnessRecommendation.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/illness-recommendation';

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

app.controller('IllnessRecommendationViewController', function($scope, $routeParams, IllnessRecommendation) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    IllnessRecommendation.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.ailment +' ?', function(c) {

      if (c) {

        IllnessRecommendation.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/medical-services/illness-recommendation";

          }

        });

      }

    });

  } 

});

app.controller('IllnessRecommendationEditController', function($scope, $routeParams, IllnessRecommendation, Select) {
  
  $scope.id = $routeParams.id;

  $('#form').validationEngine('attach');

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

 $('.clockpicker').clockpicker({

    donetext: 'Done',

    twelvehour:  true,

    placement: 'bottom'

  })

  $scope.data = {

    IllnessRecommendation : {},

    IllnessRecommendationSub : []

  }

  Select.get({ code: "prescription-list" }, function (e) {

    $scope.prescriptions = e.data;

  });

  // load 

  $scope.load = function() {

    IllnessRecommendation.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.addPrescription = function() {

    $('#prescription_form').validationEngine('attach');
    
    $scope.sub = {};

    $('#add-prescription-modal').modal('show');

  }
  
  $scope.savePrescription = function(data) {

    valid = $("#prescription_form").validationEngine('validate');

    if(valid){

      $scope.data.IllnessRecommendationSub.push(data);
      
      $('#add-prescription-modal').modal('hide');

    }

  }

  $scope.editPrescription = function(index,data) {

    $('#edit_prescription_form').validationEngine('attach');
    
    data.index = index;

    $scope.sub = data;

    $('#edit-prescription-modal').modal('show');

  }
  
  $scope.updatePrescription = function(data) {

    valid = $("#edit_prescription_form").validationEngine('validate');

    if(valid){

      $scope.data.IllnessRecommendationSub[data.index] = data;
      
      $('#edit-prescription-modal').modal('hide');

    }

  }
  
  $scope.removePrescription = function(index) {

    $scope.data.IllnessRecommendationSub.splice(index,1);

  }

  $scope.getPrescription = function(id) {

    if($scope.prescriptions.length > 0) {

      $.each($scope.prescriptions, function(i, val) {

        if(val.id == id) {

          $scope.sub.prescription = val.value;

        }

      });

    }

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      IllnessRecommendation.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/illness-recommendation';

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