app.controller('ScholarshipController', function($scope, Scholarship) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Scholarship.query(options, function(e) {

      if (e.ok) {

        $scope.datas = e.data;

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();
  
  $scope.reload = function(options) {
  
    $scope.search = {};
 
    $scope.searchTxt = '';

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

        Scholarship.remove({ id: data.id }, function(e) {

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

});

app.controller('ScholarshipAddController', function($scope, Scholarship, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    Scholarsip : {},

    ScholarshipSub : []

  };

  Select.get({code: 'provider-list'}, function(e) {

    $scope.provider = e.data;

  })

  Select.get({code: 'category-list'}, function(e) {

    $scope.categories = e.data;

  });

  //AddScholarship

  $scope.addScholarship = function() {

    $('#scholarship_form').validationEngine('attach');
    
    $scope.scholarship = {};

    $('#add-scholarship-modal').modal('show');

  }
  
  $scope.saveScholarship = function(data) {

    valid = $("#scholarship_form").validationEngine('validate');

    if(valid){


      $scope.data.ScholarshipSub.push(data);
      
      $('#add-scholarship-modal').modal('hide');

    }

  }

  $scope.editScholarship = function(index,data) {

    $('#edit_scholarship_form').validationEngine('attach');

    $scope.scholarship = {

      index        : index,

      subtype_code : data.subtype_code,

      subtype_name : data.subtype_name,

      benefit      : data.benefit,
      
      description  : data.description

    };

    $('#edit-scholarship-modal').modal('show');

  }

  $scope.updateScholarship = function(data) {

    valid = $("#edit_scholarship_form").validationEngine('validate'); 

    if(valid){

      $scope.data.ScholarshipSub[data.index] = data;
      
      $('#edit-scholarship-modal').modal('hide');

    }

  }

  $scope.removeScholarship = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.ScholarshipSub.splice(index,1);

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Scholarship.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/scholarship';

        } else {

          $('save').attr('disabled',false);

          $.gritter.add({

            title: 'Warning!',

            text:  e.msg,

          });

        }

      });

    }  

  }

});

app.controller('ScholarshipViewController', function($scope, $routeParams, Scholarship) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Scholarship.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.name +' ?', function(c) {

      if (c) {

        Scholarship.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/scholarship";

          }

        });

      }

    });

  } 

});

app.controller('ScholarshipEditController', function($scope, $routeParams, Scholarship, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    Scholarship : {},

    ScholarshipSub : []

  };

  Select.get({code: 'provider-list'}, function(e) {

    $scope.provider = e.data;

  })

  Select.get({code: 'category-list'}, function(e) {

    $scope.categories = e.data;

  });

  // load 

  $scope.load = function() {

    Scholarship.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  // add scholarship

  $scope.addScholarship = function() {

    $('#scholarship_form').validationEngine('attach');
    
    $scope.scholarship = {};

    $('#add-scholarship-modal').modal('show');

  }
  
  $scope.saveScholarship = function(data) {

    valid = $("#scholarship_form").validationEngine('validate');

    if(valid){


      $scope.data.ScholarshipSub.push(data);
      
      $('#add-scholarship-modal').modal('hide');

    }

  }

  $scope.editScholarship = function(index,data) {

    $('#edit_scholarship_form').validationEngine('attach');
    
    data.index = index;

    $scope.scholarship = {

      index        : index,

      subtype_code : data.subtype_code,

      subtype_name : data.subtype_name,

      benefit      : data.benefit,

      description  : data.description

    };

    $('#edit-scholarship-modal').modal('show');

  }
  
  $scope.updateScholarship = function(data) {

    valid = $("#edit_scholarship_form").validationEngine('validate');

    if(valid){

      $scope.data.ScholarshipSub[data.index] = data;
      
      $('#edit-scholarship-modal').modal('hide');

    }

  }
  
  $scope.removeScholarship = function(index) {

    let text = "Are you sure you want to this record ?";

    if (confirm(text) == true) {

      $scope.data.ScholarshipSub.splice(index,1);

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Scholarship.save({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/scholarship';

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