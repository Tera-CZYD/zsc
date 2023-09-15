app.controller('FacultyStudentAttendanceController', function($scope, StudentEnrolledCourse) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    StudentEnrolledCourse.query(options, function(e) {

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

  // $scope.remove = function(data) {

  //   bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

  //     if (c) {

  //       Course.remove({ id: data.id }, function(e) {

  //         if (e.ok) {

  //           $.gritter.add({

  //             title: 'Successful!',

  //             text:  e.msg,

  //           });

  //           $scope.load();

  //         }

  //       });

  //     }

  //   });

  // }

  // $scope.print = function(){

  //   date = "";
    
  //   if ($scope.conditionsPrint !== '') {
    

  //     printTable(base + 'print/course?print=1' + $scope.conditionsPrint);

  //   }else{

  //     printTable(base + 'print/course?print=1');

  //   }

  // }

});

app.controller('FacultyStudentAttendanceViewSectionController', function($scope, $routeParams, FacultyStudentAttendanceViewSection) {

  $scope.id = $routeParams.id;

  $scope.datas = {};

  // load 
  $scope.load = function() {

    FacultyStudentAttendanceViewSection.get({ id: $scope.id }, function(e) {

      $scope.datas = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        FacultyStudentAttendanceViewSection.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/course";

          }

        });

      }

    });

  } 

});

app.controller('FacultyStudentAttendanceViewStudentsController', function($scope, $routeParams, Select, FacultyStudentAttendanceViewStudents,StudentAttendanceFile) {

  $scope.id = $routeParams.id;

  $scope.course = $routeParams.course;

  $scope.faculty = $routeParams.faculty;

    // console.log($scope);


  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.datas = {};

  // load 
  $scope.load = function() {

    FacultyStudentAttendanceViewStudents.get({ id: $scope.id, course : $scope.course , faculty : $scope.faculty }, function(e) {

      $scope.datas = e.data;

      $scope.courses = e.course;

      $scope.students = e.students;

      $scope.attendances = e.attendances;

    });

  }

  Select.get({ code: 'get-month-attendance' },function(e) {

    // console.log(e.data[0].header);

    $scope.header = e.data[0].header;

    $scope.year = e.data[0].year;

    $scope.month = e.data[0].month;

    // $scope.header = e.header;

  });

  // $scope.year = $scope.search.year

  $scope.load();  

  $scope.attendance = function(data) {

    $scope.student_id = data;

    $scope.attendanceData = {};

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#add-attendance').modal('show');

  };

  $scope.saveFile = function (files,attendanceData) {

    // console.log(files);
    
    $scope.StudentAttendanceFile = [];

   if(attendanceData.status != 'present'){

     angular.forEach(files, function(file, e){

      $scope.StudentAttendanceFile.push({

        images           : file.name,

        status           : attendanceData.status,

        date             : Date.parse(attendanceData.date).toString('yyyy-MM-dd'),

        course_id        : $scope.course,

        student_id        : $scope.student_id,

        section_id        : $scope.id,

        faculty_id       : $scope.faculty,

        url              : file.url,

        _file            : file._file,

        $$hashKey        : file.$$hashKey

      });

    });

   }else{

      $scope.StudentAttendanceFile.push({

        images           : '',

        status           : attendanceData.status,

        date             : Date.parse(attendanceData.date).toString('yyyy-MM-dd'),

        course_id        : $scope.course,

        student_id        : $scope.student_id,

        section_id        : $scope.id,

        faculty_id       : $scope.faculty,

      });

   }
    
    StudentAttendanceFile.save($scope.StudentAttendanceFile, function(e) {

      if (e.ok) {

        $.gritter.add({

          title: 'Success!',

          text:  e.msg,

        });

        $('#add-attendance').modal('hide');

        $scope.load();

      } else {

        $.gritter.add({

          title: 'Warning!',

          text:  e.msg,

        });

      }

    });

  }
  

});

app.controller('FacultyStudentAttendanceAddController', function($scope, Course, Select) {

 $('.datepicker').datepicker({

    format:'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $('#form').validationEngine('attach');

  $scope.getCreditHours = function(){

    if($scope.data.Course.lecture_hours != null && $scope.data.Course.lecture_hours != '' && $scope.data.Course.laboratory_hours != null && $scope.data.Course.laboratory_hours != ''){

      $scope.data.Course.credit_hours = parseFloat($scope.data.Course.lecture_hours) + parseFloat($scope.data.Course.laboratory_hours);

    }

  }

  $scope.getCreditUnit = function(){

    if($scope.data.Course.lecture_unit != null && $scope.data.Course.lecture_unit != '' && $scope.data.Course.laboratory_unit != null && $scope.data.Course.laboratory_unit != ''){

      $scope.data.Course.credit_unit = parseFloat($scope.data.Course.lecture_unit) + parseFloat($scope.data.Course.laboratory_unit);

    }

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      Course.save($scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/course';

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

app.controller('FacultyStudentAttendanceViewController', function($scope, $routeParams, DeleteSelected, Course, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};

  // load 
  $scope.load = function() {

    Course.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  

  // remove 
  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.code +' ?', function(c) {

      if (c) {

        Course.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/course";

          }

        });

      }

    });

  } 

});

app.controller('FacultyStudentAttendanceEditController', function($scope, $routeParams, Course, Select) {
  
  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.getCreditHours = function(){

    if($scope.data.Course.lecture_hours != null && $scope.data.Course.lecture_hours != '' && $scope.data.Course.laboratory_hours != null && $scope.data.Course.laboratory_hours != ''){

      $scope.data.Course.credit_hours = parseFloat($scope.data.Course.lecture_hours) + parseFloat($scope.data.Course.laboratory_hours);

    }

  }

  $scope.getCreditUnit = function(){

    if($scope.data.Course.lecture_unit != null && $scope.data.Course.lecture_unit != '' && $scope.data.Course.laboratory_unit != null && $scope.data.Course.laboratory_unit != ''){

      $scope.data.Course.credit_unit = parseFloat($scope.data.Course.lecture_unit) + parseFloat($scope.data.Course.laboratory_unit);

    }

  }

  // load 
  $scope.load = function() {

    Course.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      Course.update({id:$scope.id}, $scope.data, function(e) {

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text:  e.msg,

          });

          window.location = '#/course';

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