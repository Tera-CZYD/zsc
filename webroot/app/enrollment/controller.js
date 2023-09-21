app.controller('EnrollmentController', function($scope,StudentEnrollment,Select,StudentApplication,Student) {

  $scope.today = Date.parse('today').toString('MM/dd/yyyy');

  $scope.tmpData = {

    StudentEnrollment : {},

    StudentEnrolledCourse : [],

    StudentEnrolledSchedule : []

  };

  $('.datepicker').datepicker({
   
    format: 'mm/dd/yyyy',
   
    autoclose: true,
   
    todayHighlight: true
  
  });

  $scope.selectedCourse = [];

  $scope.base = base;

  Select.get({ code: 'list-available-courses' },function(e){

    $scope.datas = e.data;

    Student.get({ id: e.studentId }, function(response) {

      $scope.data = response.data;

    });

  });

  $scope.addCourse = function(data) {

    bootbox.confirm('Are you sure you want to add this course?', function(c) {

      if(c) {

        $scope.$apply(function() {

          $scope.selectedCourse.push(data);

        });

      }

    });

  }

  $scope.removeCourse = function(index) {

    bootbox.confirm('Are you sure you want to remove this course?', function(c) {

      if(c) {

        $scope.$apply(function() {

          $scope.selectedCourse.splice(index,1);

        });

      }

    });

  }

  $scope.next = function(){

    $('a[data-target="#review_create"]').tab('show');

    $scope.tmpData.StudentEnrollment.student_id = $scope.data.Student.id;

    $scope.tmpData.StudentEnrollment.student_no = $scope.data.Student.student_no;

    $scope.tmpData.StudentEnrollment.student_name = $scope.data.Student.full_name;

    $scope.tmpData.StudentEnrollment.year_term_id = $scope.data.Student.year_term_id;

    if($scope.selectedCourse.length > 0){

      $.each($scope.selectedCourse, function(i,val){

        $scope.tmpData.StudentEnrolledCourse.push({

          student_id              : $scope.data.Student.id,

          course_id               : val.course_id,

          course_code             : val.course_code,

          course                  : val.course,

          year_term_id            : $scope.data.Student.year_term_id,

          section_id              :  val.section_id,

          section                 :  val.section,

          faculty_id              :  val.faculty_id,

          faculty_name            :  val.faculty_name,

          lecture_unit            :  val.lecture_unit,

          lecture_hours           :  val.lecture_hours,

          laboratory_unit         :  val.laboratory_unit,

          laboratory_hours        :  val.laboratory_hours,

          credit_unit             :  val.credit_unit,

          block_section_course_id : val.block_section_course_id

        });

        if(val.schedules.length > 0){

          $.each(val.schedules, function(index,values){

            $scope.tmpData.StudentEnrolledSchedule.push({

              student_id                : $scope.data.Student.id,

              course_id                 : val.course_id,

              course                    : val.course,

              block_section_schedule_id : values.id,

              faculty_id                :  val.faculty_id,

              faculty_name              :  val.faculty_name,

              year_term_id              : $scope.data.Student.year_term_id,

              day                       : values.day,

              room_id                   : val.room_id,

              room                      : val.room,

              time_start                : values.time_start,

              time_end                  : values.time_end,

              section_id                :  val.section_id,

              section                   :  val.section

            });

          });

        }

      });

    }

  }

  $scope.back = function(){

    $('a[data-target="#course_selection"]').tab('show');

    $scope.tmpData = {

      StudentEnrollment : {},

      StudentEnrolledCourse : [],

      StudentEnrolledSchedule : []

    };

  }

  $scope.save = function() {

    bootbox.confirm('Are you sure you want to enroll this course(s)?', function(c) {

      if(c) {

        StudentEnrollment.save($scope.tmpData, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/dashboard';

          } else {

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

          }

        });

      }

    });

  }

});