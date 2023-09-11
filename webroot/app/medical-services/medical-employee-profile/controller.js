app.controller('MedicalEmployeeProfileController', function($scope, MedicalEmployeeProfile) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {
 
    options = typeof options !== 'undefined' ?  options : {};

    MedicalEmployeeProfile.query(options, function(e) {

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

    bootbox.confirm('Are you sure you want to delete ' + data.employee_name +' ?', function(c) {

      if (c) {

        MedicalEmployeeProfile.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/medical_employee_profile?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/medical_employee_profile?print=1');

    }

  }

});

app.controller('MedicalEmployeeProfileAddController', function($scope, MedicalEmployeeProfile, Select) {

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

  Select.get({code: 'medical-employee-profile-code'}, function(e) {

    $scope.data.MedicalEmployeeProfile.code = e.data;

  });

  Select.get({code: 'college-list'}, function(e) {

    $scope.college = e.data;

  });

  $scope.data = {

    MedicalEmployeeProfile : {},

    EmployeeFile : []

  }

  $scope.newFiles = [];

  $scope.files = [];

  $scope.images = [];

 $scope.saveImages = function (files) {

    if(files == undefined){

      files = '';

    }

    if(files.length > 0){

      $scope.data.EmployeeFile.push({

        files  : $scope.files,

      });  

    }

  }

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.MedicalEmployeeProfile.employee_id = null;

      $scope.data.MedicalEmployeeProfile.employee_name = null;

    }else{

      $scope.data.MedicalEmployeeProfile.student_id = null;

      $scope.data.MedicalEmployeeProfile.student_name = null;

    }

  }

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name,

      college_id : employee.college_id,

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.MedicalEmployeeProfile.employee_id = $scope.employee.id;

    $scope.data.MedicalEmployeeProfile.employee_no = $scope.employee.code;

    $scope.data.MedicalEmployeeProfile.employee_name = $scope.employee.name;

    $scope.data.MedicalEmployeeProfile.college_id = $scope.employee.college_id;

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      MedicalEmployeeProfile.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/medical-employee-profile';

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

app.controller('MedicalEmployeeProfileViewController', function($scope, $routeParams, MedicalEmployeeProfile) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    MedicalEmployeeProfile.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.applicationImage = e.applicationImage;

    });

  }

  $scope.print = function(id){

    printTable(base + 'print/medical_employee_profile_form/'+$scope.id);

  }

  $scope.printMedical = function(id){

    printTable(base + 'print/medical_history_form_employee/'+$scope.id);

  }

  $scope.load();  

   $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.employee_name +' ?', function(c) {

      if (c) {

        MedicalEmployeeProfile.remove({ id: data.id }, function(e) {

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

app.controller('MedicalEmployeeProfileEditController', function($scope, $routeParams, MedicalEmployeeProfile, EmployeeFile, EmployeeFileRemove, Select) {
  
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

    MedicalEmployeeProfile : {},

    EmployeeFile : [] 

  }

  // Select.get({code: 'medical-employee-profile-code'}, function(e) {

  //   $scope.data.MedicalEmployeeProfile.code = e.data;

  // });

  Select.get({code: 'college-list'}, function(e) {

    $scope.college = e.data;

  });

  // load 

  $scope.load = function() {

    MedicalEmployeeProfile.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.applicationImage = e.applicationImage;

    });

  }

  $scope.load();

  $scope.addImage = function() {

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#edit-upload-image').modal('show');

  };

  $scope.saveImages = function (files) {
    
    $scope.EmployeeFile = [];

    angular.forEach(files, function(file, e){

      $scope.EmployeeFile.push({

        files                 : file.name,

        employee_profile_id   : $scope.id,

        url                   : file.url,

        _file                 : file._file,

        $$hashKey             : file.$$hashKey

      });

    });
    
    EmployeeFile.save($scope.EmployeeFile, function(e) {

      if (e.ok) {

        $.gritter.add({

          title: 'Success!',

          text:  e.msg,

        });

        $('#edit-upload-image').modal('hide');

        $scope.load();

      } else {

        $.gritter.add({

          title: 'Warning!',

          text:  e.msg,

        });

      }

    });

  }

  $scope.removeImage = function(index,image) {

    bootbox.confirm('Are you sure you want to delete ' + image.name + '?', function(b) {

      if (b) {

        StudentFileRemove.delete({ id: image.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text: e.msg,

            });

            $scope.load();

          }

        });

      }

    });

  }

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.MedicalEmployeeProfile.employee_id = null;

      $scope.data.MedicalEmployeeProfile.employee_name = null;

    }else{

      $scope.data.MedicalEmployeeProfile.student_id = null;

      $scope.data.MedicalEmployeeProfile.student_name = null;

    }

  }

  $scope.searchEmployee = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    options['code'] = 'search-employees';

    Select.query(options, function(e) {

      $scope.employees = e.data.result;

      $scope.employee = {};
      
      // paginator

      $scope.paginator  = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-employee-modal").modal('show');

    });

  }

  $scope.selectedEmployee = function(employee) { 

    $scope.employee = {

      id   : employee.id,

      code : employee.code,

      name : employee.name

    }; 

  }

  $scope.employeeData = function(id) {

    $scope.data.MedicalEmployeeProfile.employee_id = $scope.employee.id;

    $scope.data.MedicalEmployeeProfile.employee_no = $scope.employee.code;

    $scope.data.MedicalEmployeeProfile.employee_name = $scope.employee.name;

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      MedicalEmployeeProfile.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/medical-employee-profile';

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