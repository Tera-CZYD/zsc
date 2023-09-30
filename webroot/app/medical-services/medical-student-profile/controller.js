app.controller('MedicalStudentProfileController', function($scope, MedicalStudentProfile) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {
 
    options = typeof options !== 'undefined' ?  options : {};

    MedicalStudentProfile.query(options, function(e) {

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

    bootbox.confirm('Are you sure you want to delete ' + data.student_name +' ?', function(c) {

      if (c) {

        MedicalStudentProfile.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/medical_student_profile?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/medical_student_profile?print=1');

    }

  }

});

app.controller('MedicalStudentProfileAddController', function($scope, MedicalStudentProfile, Select) {

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

  Select.get({code: 'medical-student-profile-code'}, function(e) {

    $scope.data.MedicalStudentProfile.code = e.data;

  });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_level_term = e.data;

  });

  $scope.data = {

    MedicalStudentProfile : {},

    MedicalStudentProfileImage : []

  }

 $scope.saveImages = function (files) {

    if(files == undefined){

      files = '';

    }

    if(files.length > 0){

      $scope.data.MedicalStudentProfileImage.push({

        images  : $scope.files,

      });  

    }

  }

  $scope.getMember = function(data){

    if(data == 'Student'){

      $scope.data.MedicalStudentProfile.employee_id = null;

      $scope.data.MedicalStudentProfile.employee_name = null;

    }else{

      $scope.data.MedicalStudentProfile.student_id = null;

      $scope.data.MedicalStudentProfile.student_name = null;

    }

  }

  $scope.searchStudent = function (options) {

    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

      program_id: student.program_id,

      year_term_id: student.year_term_id,

      address: student.address,

      gender: student.gender,

      civil_status: student.civil_status,

      age: student.age,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.MedicalStudentProfile.student_id = $scope.student.id;

    $scope.data.MedicalStudentProfile.student_name = $scope.student.name;

    $scope.data.MedicalStudentProfile.student_no = $scope.student.code;

    $scope.data.MedicalStudentProfile.course_id = $scope.student.program_id;

    $scope.data.MedicalStudentProfile.year_term_id = $scope.student.year_term_id;

    $scope.data.MedicalStudentProfile.address = $scope.student.address;

    $scope.data.MedicalStudentProfile.gender = $scope.student.gender;

    $scope.data.MedicalStudentProfile.civil_status = $scope.student.civil_status;

    $scope.data.MedicalStudentProfile.age = $scope.student.age;

  };

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      MedicalStudentProfile.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/medical-student-profile';

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

app.controller('MedicalStudentProfileViewController', function($scope, $routeParams, MedicalStudentProfile, MedicalStudentProfileImage) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 

  $scope.load = function() {

    MedicalStudentProfile.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.medicalStudentProfileImage = e.medicalStudentProfileImage;

    });

  }

  $scope.print = function(id){

    printTable(base + 'print/medical_student_profile_form/'+$scope.id);

  }

  $scope.printMedical = function(id){

    printTable(base + 'print/medical_history_form/'+$scope.id);

  }

  $scope.load();  

   $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.student_name +' ?', function(c) {

      if (c) {

        MedicalStudentProfile.remove({ id: data.id }, function(e) {

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

app.controller('MedicalStudentProfileEditController', function($scope, $routeParams, MedicalStudentProfile, MedicalStudentProfileImage, MedicalStudentProfileImageRemove, Select) {
  
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

    MedicalStudentProfile : {},

    MedicalStudentProfileImage : []

  }

  // Select.get({code: 'medical-student-profile-code'}, function(e) {

  //   $scope.data.MedicalStudentProfile.code = e.data;

  // });

  Select.get({code: 'college-program-list-all'}, function(e) {

    $scope.college_program = e.data;

  });

  Select.get({code: 'year-term-list'}, function(e) {

    $scope.year_level_term = e.data;

  });

  // load 

  $scope.load = function() {

    MedicalStudentProfile.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.medicalStudentProfileImage = e.medicalStudentProfileImage;

    });

  }

  $scope.load();

  $scope.addImage = function() {

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#edit-upload-image').modal('show');

  };

  $scope.saveImages = function (files) {
    
    $scope.MedicalStudentProfileImage = [];

    angular.forEach(files, function(file, e){

      $scope.MedicalStudentProfileImage.push({

        images                 : file.name,

        student_profile_id    : $scope.id,

        url                   : file.url,

        _file                 : file._file,

        $$hashKey             : file.$$hashKey

      });

    });
    
    MedicalStudentProfileImage.save($scope.MedicalStudentProfileImage, function(e) {

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

        MedicalStudentProfileImageRemove.delete({ id: image.id }, function(e) {

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

      $scope.data.MedicalStudentProfile.employee_id = null;

      $scope.data.MedicalStudentProfile.employee_name = null;

    }else{

      $scope.data.MedicalStudentProfile.student_id = null;

      $scope.data.MedicalStudentProfile.student_name = null;

    }

  }

  $scope.searchStudent = function (options) {


    options = typeof options !== "undefined" ? options : {};

    options["code"] = "search-student";

    Select.query(options, function (e) {

      $scope.students = e.data.result;

      $scope.student = {};

      // paginator

      $scope.paginator = e.data.paginator;

      $scope.pages = paginator($scope.paginator, 10);

      $("#searched-student-modal").modal("show");

    });

  };

  $scope.selectedStudent = function (student) {

    $scope.student = {

      id: student.id,

      code: student.code,

      name: student.name,

    };

  };

  $scope.studentData = function (id) {

    $scope.data.MedicalStudentProfile.student_id = $scope.student.id;

    $scope.data.MedicalStudentProfile.student_name = $scope.student.name;

    $scope.data.MedicalStudentProfile.student_no = $scope.student.code;

  };

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      MedicalStudentProfile.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/medical-services/medical-student-profile';

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