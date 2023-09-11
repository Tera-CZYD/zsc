app.controller('AdminEnrollmentController', function($scope,Enrollment,Select,StudentApplication,Student) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

    // console.log($scope.data);

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
      // console.log(student);
      $scope.student = {
        id: student.id,

        code: student.code,

        name: student.name,

        year: student.year_level
      };
    };

    $scope.studentData = function (id) {

      $scope.data = {
        Enrollment: {},

      }
      $scope.data.Enrollment.student_id = $scope.student.id;

      $scope.data.Enrollment.student_name = $scope.student.name;

      $scope.data.Enrollment.student_no = $scope.student.code;

      $scope.data.Enrollment.year = $scope.student.year;

      Select.get({ code: 'student-academic-term-list' },function(e){

      Student.get({ id: $scope.data.Enrollment.student_id }, function(response) {

        $scope.data.Student = response.data;
              // console.log($scope.data.Student);

          Select.get({ code: 'block-section-list', college_id : $scope.data.Student.Student.college_id, program_id : $scope.data.Student.Student.program_id, year_term_id : $scope.data.Student.Student.year_term_id },function(e){

            $scope.datas = e.data;

          });

        });

      });

      // console.log($scope.data);
      // console.log($scope.datas);

    };

});

app.controller('AdminEnrollmentAddController', function($scope, $routeParams, Enrollment, Select, Student, BlockSection) {

  $scope.id = $routeParams.id;

  $scope.student_id = $routeParams.student;

  // console.log($scope.student_id);

  $('#form').validationEngine('attach');

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.data = {

    BlockSectionCourse : [],

    StudentEnrolledCourse : [],
    StudentEnrolledUnit : {}

  };

  Select.get({ code: 'student-academic-term-list' },function(e){
      // console.log(e);
    Student.get({ id: $scope.student_id }, function(response) {

      $scope.data = response.data;


      if($scope.data.StudentEnrolledUnit.length > 0){

        $.each($scope.data.StudentEnrolledUnit, function(i,val){

          if(val.year_term_id == $scope.data.Student.year_term_id){

            $scope.total_course = val.total_course;

            $scope.total_credit_unit = val.credit_unit;

            $scope.total_lecture_unit = val.lecture_unit;

            $scope.total_laboratory_unit = val.laboratory_unit;

          }

        });

      }else{

        $scope.total_course = 0;

        $scope.total_credit_unit = 0;

        $scope.total_lecture_unit = 0;

        $scope.total_laboratory_unit = 0;

      }

    });

  });

  Select.get({ code: 'block-section-enrollment', block_section_id : $scope.id },function(e){

    $scope.datas = e.data;

  });

  BlockSection.get({ id: $scope.id }, function(e) {

    $scope.blockSectionData = e.data;

  });

  $scope.addCourse = function(data, index){

    bootbox.confirm('Are you sure you want to add course ' + data.course +' ?', function(c) {

      if (c) {

        $scope.$apply(function() {

          $scope.datas[index].btn_status = 1;

          $scope.total_course += 1;

          $scope.total_credit_unit += parseFloat(data.credit_unit);

          $scope.total_lecture_unit += parseFloat(data.lecture_unit);

          $scope.total_laboratory_unit += parseFloat(data.laboratory_unit);

          $scope.data.StudentEnrolledCourse.push({

            block_section_course_id : data.id,

            student_id              : $scope.data.Student.id,

            course_id               : data.course_id,

            course_code             : data.course_code,

            course                  : data.course,

            section_id              : $scope.blockSectionData.BlockSection.section_id,

            section                 : $scope.blockSectionData.BlockSection.section,

            year_term_id            : $scope.data.YearLevelTerm.id,

            credit_unit             : data.credit_unit,

            lecture_unit            : data.lecture_unit,

            lecture_hours           : data.lecture_hours,

            laboratory_unit         : data.laboratory_unit,

            laboratory_hours        : data.laboratory_hours,

            faculty_id              : data.faculty_id,

            faculty_name            : data.faculty_name,

            index                   : index

          });

          if($scope.datas[index].schedules.length > 0){

            $.each($scope.datas[index].schedules, function(i,val){

              $scope.data.StudentEnrolledSchedule.push({

                student_id    : $scope.data.Student.id,

                course_id     : data.course_id,

                course        : data.course,

                block_section_schedule_id : val.id,

                faculty_id    : data.faculty_id,

                faculty_name  : data.faculty_name,

                year_term_id  : $scope.data.YearLevelTerm.id,

                day           : val.day,

                time_start    : val.time_start,

                time_end      : val.time_end,

                section_id    : $scope.blockSectionData.BlockSection.section_id,

                section       : $scope.blockSectionData.BlockSection.section,

                room_id       : data.room_id,

                room          : data.room,

              });

            });

          }

        });

      }

    });

  }

  $scope.removeCourse = function(data, index) {

    bootbox.confirm('Are you sure you want to remove course ' + data.course +' ?', function(c) {

      if (c) {

        $scope.$apply(function() {

          const filteredTimetable = $scope.data.StudentEnrolledSchedule.filter(item => item.course_id !== data.course_id);

          $scope.data.StudentEnrolledSchedule = filteredTimetable;

          $scope.total_course -= 1;

          $scope.total_credit_unit -= parseFloat(data.credit_unit);

          $scope.total_lecture_unit -= parseFloat(data.lecture_unit);

          $scope.total_laboratory_unit -= parseFloat(data.laboratory_unit);

          $scope.data.StudentEnrolledCourse.splice(index,1);

          $scope.datas[data.index].btn_status = 0;

        });

      }

    });

    

  }

  $scope.save = function(){
    
    if (confirm("Are you sure you want to save this registration?") == true) {

      if($scope.data.StudentEnrolledCourse.length > 0){

        Select.get({ code : 'validate-enrollment-registration',student_id : $scope.data.Student.id,year_term_id : $scope.data.YearLevelTerm.id }, function(e) {

          if (e.data.ok) {

            $scope.data.StudentEnrolledUnit.push({

              student_id        : $scope.data.Student.id,

              credit_unit       : $scope.total_credit_unit,

              lecture_unit      : $scope.total_lecture_unit,

              laboratory_unit   : $scope.total_laboratory_unit,

              total_course      : $scope.total_course,

              year_term_id      : $scope.data.YearLevelTerm.id

            });

            Enrollment.save($scope.data, function(e) {
 
              if (e.ok) {

                $.gritter.add({

                  title: 'Successful!',

                  text:  e.msg,

                });

                window.location = '#/admission/enrollment';

              } else {

                $.gritter.add({

                  title: 'Warning!',

                  text:  e.msg,

                });

              }

            });

          }else{

            $.gritter.add({

              title: 'Warning!',

              text:  'Already registered!',

            });

          }

        });

      }else{

        $.gritter.add({

          title: 'Warning!',

          text:  'No added course.',

        });

      }

    }

  }

});

