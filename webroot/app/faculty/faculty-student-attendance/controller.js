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

app.controller('FacultyStudentAttendanceViewStudentsController', function($scope, $routeParams, Select, FacultyStudentAttendanceViewStudents,StudentAttendanceFile,StudentAttendanceDrop) {

  $scope.id = $routeParams.id;

  $scope.course = $routeParams.course;

  $scope.faculty = $routeParams.faculty;

  $scope.base = base;

    // console.log($scope);


  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.datas = {};

  // $scope.count = {};

  // load 
  $scope.load = function() {

    FacultyStudentAttendanceViewStudents.get({ id: $scope.id, course : $scope.course , faculty : $scope.faculty }, function(e) {

      $scope.datas = e.data;

      $scope.courses = e.course;

      $scope.students = e.students;

      $scope.attendances = e.attendances;

      $scope.records = e.records;

      $scope.header = e.header;

      $scope.year = e.year;

      $scope.month = e.month;

    });

  }


  $scope.load();  

  $scope.showImage = function(data,image,imageSrc) {

    $scope.folder_id = data;

    $scope.imageName = image;

    $scope.imageSrc = imageSrc;

    // alert(data+'<br>'+image);

    $('#view-file').modal('show');

  };

  $scope.attendance = function(data,index,year) {

    $scope.student_id = data;

    $scope.year_term_id = year;

    $scope.day = index;

    $scope.attendanceData = {};

    var x = document.getElementById("upload_prev").innerHTML = " ";

    $('#add-attendance').modal('show');

  };



  $scope.saveFile = function (files,attendanceData) {

    

    

    if(files == undefined){

      files = '';


    }

    var year = new Date().getFullYear(); // Get the current year

    var month = new Date().getMonth() + 1; // Get the current month (add 1 because it's zero-based)


    // Format the number with leading zeros if needed (e.g., '01')
    var formattedNumber = $scope.day < 10 ? '0' + $scope.day : '' + $scope.day;

    // Create the formatted date string 'yyyy-MM-number'
    var formattedDate = year + '-' + (month < 10 ? '0' + month : '' + month) + '-' + formattedNumber;

    // alert(files.length);
    
    $scope.StudentAttendanceFile = [];


    if(files.length > 1){

      $.gritter.add({

        title: 'Warning!',

        text:  'Upload 1 File only',

      });

    }else{

      if(attendanceData.status != 'present'){


        if(files.length == 0){

          $.gritter.add({

            title: 'Warning!',

            text:  'Please upload a file.',

          });

        }else{

          angular.forEach(files, function(file, e){

          $scope.StudentAttendanceFile.push({

            images           : file.name,

            status           : attendanceData.status,

            date             : Date.parse(formattedDate).toString('yyyy-MM-dd'),

            course_id        : $scope.course,

            student_id        : $scope.student_id,

            section_id        : $scope.id,

            faculty_id       : $scope.faculty,

            year_term_id       : $scope.year_term_id,

            url              : file.url,

            _file            : file._file,

            $$hashKey        : file.$$hashKey

          });

        });

        }

       }else{


          $scope.StudentAttendanceFile.push({

            images           : '',

            status           : attendanceData.status,

            date             : Date.parse(formattedDate).toString('yyyy-MM-dd'),

            course_id        : $scope.course,

            student_id        : $scope.student_id,

            section_id        : $scope.id,

            faculty_id       : $scope.faculty,

            year_term_id       : $scope.year_term_id,

          });

       }
 
      StudentAttendanceFile.save($scope.StudentAttendanceFile, function(e) {

        $scope.count_attendance = '';

        Select.get({ code: 'get-student-attendance', student_id : $scope.student_id, year_term_id : $scope.year_term_id },function(q){

          $scope.count = q.data;

          if($scope.count<=5){

            if($scope.count==5){

              StudentAttendanceDrop.update({id:$scope.student_id},$scope.data, function(e){

                if(e.ok){

                  
                  $.gritter.add({

                      title: 'Warning!',

                      text:  'Student Dropped',

                    });

                  $('#add-attendance').modal('hide');

                  $scope.load();

                }

              });


            }else{

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

            }

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  'Student Dropped',

            });

          }
          

        });

      });

    }

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