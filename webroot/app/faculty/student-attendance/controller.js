app.controller('StudentAttendanceController', function($scope, Employee,Select) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  Select.get({ code: 'college-list' },function(e){

    $scope.colleges = e.data;

  });

  $scope.getCollege = function(id){
 
    $scope.college_id = id;

    $scope.load({

      college_id: $scope.college_id, 

    });

  }

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    Employee.query(options, function(e) {

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

    $scope.load();

  }

  $scope.searchy = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search: search,

      });

    } else {

      $scope.load();
    
    }

  }

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.code +' ?', function(c) {

      if (c) {

        Employee.remove({ id: data.id }, function(e) {

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
    

      printTable(base + 'print/faculty?print=1' + $scope.conditionsPrint);

    }else{

      printTable(base + 'print/faculty?print=1');

    }

  }

});

app.controller('StudentAttendanceViewController', function($scope, $routeParams, StudentAttendance, Employee, Select) {

  $scope.id = $routeParams.id;

  $scope.data = {};



  $scope.conditionsPrint = '';


  // Select.get({ code: 'program-list' },function(e){

  //   $scope.programs = e.data;

  // });

  $scope.getProgram = function(id){

    Select.get({ code: 'program-course-list', id : id },function(e){

      $scope.courses = e.data;

    });

  }

  Select.get({ code: 'section-list' },function(e){

    $scope.sections = e.data;

  });

  Select.get({ code: 'year-term-list' },function(e){

    $scope.year_terms = e.data;

  });

  Select.get({ code: "course-list" }, function (e) {

    $scope.course = e.data;

  });

  // load 
  $scope.load = function() {

    Employee.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

    });

  }

  $scope.load();  


  $scope.getDatas = function() {

    // if($scope.program_id !=null && $scope.year_term_id != null){

    Select.get({ code: 'get-student_enrolled',faculty_id : $scope.id, course_id : $scope.course_id},function(e){

        $scope.datas = e.data;

    });

   // }
 }

  $scope.print = function(){
    
    printTable(base + 'print/report_rating_form?print=1' + $scope.conditionsPrint);

  }

});

app.controller('StudentAttendanceAddController', function($scope, $routeParams, StudentAttendance, Employee, Select) {

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.id = $routeParams.id;

  $scope.sub_id = $routeParams.sub_id;

  $scope.course_id = $routeParams.course_id;

 

  $scope.data = {

    StudentAttendance : {},

    StudentAttendanceSub : []

  }


  $scope.conditionsPrint = '';



  Select.get({ code: 'schedule-list-attendance', faculty_id : $scope.id, class_schedule_sub_id : $scope.sub_id },function(e){

    $scope.scheduledays = e.data;

    $scope.scheduledays.length > 0 ? $scope.is_empty = true : $scope.is_empty = false
    
  });



  $scope.getStudents = function(id) {


    Select.get({ code: 'schedule-list-students', block_section_schedule_id : id, course_id : $scope.course_id},function(e){

    $scope.adata = e.data;

    $scope.data.StudentAttendance.block_section_schedule_id = id;


      if($scope.adata.length > 0 ){

        $.each($scope.adata, function(i,val){

        $scope.data.StudentAttendanceSub.push({student_id : val.student_id, is_present: false , student_name : val.name});

      });

      }

    });
    
    
  }



$scope.save = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      StudentAttendance.save($scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          window.history.back();

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});

app.controller('StudentAttendanceViewDetailController', function($scope, $routeParams, StudentAttendanceViewDetail, StudentAttendance, Employee, Select) {

  $scope.data = {};

  $scope.adata = {};

  $scope.sub_id = $routeParams.sub_id;

  $scope.course_id = $routeParams.course_id;

  $scope.id = $routeParams.id;


  function convertTimeToAMPM(time) {

    const parts = time.split(':');

    const hour = parseInt(parts[0]);

    const minute = parseInt(parts[1]);
    
    // Create a dummy date with the desired time

    const dummyDate = new Date();

    dummyDate.setHours(hour);

    dummyDate.setMinutes(minute);

    // Use the toLocaleString method to convert to AM/PM format

    const formattedTime = dummyDate.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
    
    return formattedTime;

  }

  // load 
  $scope.load = function() {

    StudentAttendanceViewDetail.get({ id: $scope.id, sub_id : $scope.sub_id }, function(e) {

      $scope.data = e.data;

      $scope.adata = e.adata;


      if($scope.data.BlockSectionSchedule.length > 0){

        $scope.data.BlockSectionSchedule.forEach((e) => {

          e.time_start = convertTimeToAMPM(e.time_start)

          e.time_end = convertTimeToAMPM(e.time_end)

        })

      }

    });

  }





  $scope.load();  


  $scope.viewAttendance = function(index,data) {

    $('#view_attendance_form').validationEngine('attach');



    $scope.index = index;
    
    data.index = index;

    $scope.sub = data;

       Select.get({ code: 'student-attendance-date', block_section_schedule_id : $scope.sub.id},function(e){

      $scope.subs = e.data;

    });

    $('#view-attendance-modal').modal('show');

  }

    $scope.reFetch = function() {

      $scope.date = 0;
    }

    $scope.getStudentLists = function(id) {


        Select.get({ code: 'student-list-attendance', student_attendance_id : id},function(e){

      $scope.datas = e.data;

    });

  }

  $scope.editAttendance = function () {

      $('#view-attendance-modal').modal('hide');


      window.location = "#/faculty/student-attendance/edit/"+$scope.date

      }

  $scope.remove = function(id) {

    bootbox.confirm('Are you sure you want to delete ?', function(c) {

      if (c) {

        $('#view-attendance-modal').modal('hide');

        $scope.date = 0;

        StudentAttendance.remove({ id: id }, function(e) {

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


app.controller('StudentAttendanceEditController', function($scope, $routeParams, StudentAttendance, Employee, Select) {

  angular.element(document.querySelector(".modal-backdrop")).remove();


  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.id = $routeParams.id;
 
  console.log($scope.id)

  $scope.data = {

  }



  $scope.conditionsPrint = '';

    
    
  // }

    $scope.load = function() {


      Select.get({ code: 'student-attendance', id : $scope.id },function(e) {

        $scope.data = e.data;


        if ($scope.data.StudentAttendanceSub.length > 0) {

        $scope.data.StudentAttendanceSub.forEach(function (attendance) {

          attendance.is_present = (attendance.is_present === 'Present');

        });

      }

    });
      
  }

  $scope.load();



$scope.update = function () {

    valid = $("#form").validationEngine("validate");

    if (valid) {

      StudentAttendance.update({id:$scope.id},$scope.data, function (e) {

        if (e.ok) {

          $.gritter.add({

            title: "Successful!",

            text: e.msg,

          });

          console.log($scope.id)

          window.history.back();

        } else {

          $.gritter.add({

            title: "Warning!",

            text: e.msg,

          });

        }

      });

    }

  };

});